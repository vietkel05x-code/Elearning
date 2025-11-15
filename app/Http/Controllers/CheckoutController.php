<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $courses = [];
        $subtotal = 0;

        foreach ($cart as $courseId => $item) {
            $course = Course::find($courseId);
            if ($course) {
                $courses[] = $course;
                $subtotal += $course->price;
            }
        }

        // Check coupon if exists
        $discount = 0;
        $couponCode = session()->get('coupon_code');
        $coupon = null;
        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }
        $total = $subtotal - $discount;

        return view('checkout.index', compact('courses', 'subtotal', 'discount', 'total', 'couponCode', 'coupon'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:momo,vnpay,bank_transfer',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            $courses = [];
            
            foreach ($cart as $courseId => $item) {
                $course = Course::find($courseId);
                if ($course) {
                    // Check if already enrolled
                    if ($course->isEnrolledBy(Auth::id())) {
                        DB::rollBack();
                        return redirect()->route('cart.index')
                            ->with('error', "Bạn đã đăng ký khóa học: {$course->title}");
                    }
                    
                    $courses[] = $course;
                    $subtotal += $course->price;
                }
            }

            // Check coupon if exists
            $discount = 0;
            $couponCode = session()->get('coupon_code');
            if ($couponCode) {
                $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($subtotal);
                }
            }
            $total = $subtotal - $discount;

            // Create order with pending status
            $order = Order::create([
                'user_id' => Auth::id(),
                'code' => Order::generateCode(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'status' => 'pending', // Will be updated after payment
            ]);

            // Create order items
            foreach ($courses as $course) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'course_id' => $course->id,
                    'price' => $course->price,
                ]);
            }

            DB::commit();

            // Redirect to payment gateway based on method
            $paymentMethod = $validated['payment_method'];
            
            if ($paymentMethod === 'bank_transfer') {
                // For bank transfer, show instructions and mark as paid after confirmation
                return redirect()->route('payment.bank-transfer', $order);
            } else {
                // For MoMo and VNPay, redirect to payment gateway
                return redirect()->route('payment.gateway', ['order' => $order->id, 'method' => $paymentMethod]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return redirect()->route('checkout.index')
                ->with('error', 'Mã giảm giá không tồn tại!');
        }

        if (!$coupon->isValid()) {
            return redirect()->route('checkout.index')
                ->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        session()->put('coupon_code', $coupon->code);

        return redirect()->route('checkout.index')
            ->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon_code');

        return redirect()->route('checkout.index')
            ->with('success', 'Đã xóa mã giảm giá!');
    }
}

