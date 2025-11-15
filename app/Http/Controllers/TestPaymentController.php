<?php

namespace App\Http\Controllers;

use App\Services\MomoPaymentService;
use App\Services\VnpayPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestPaymentController extends Controller
{
    /**
     * Test MoMo config
     */
    public function testMomo()
    {
        $config = [
            'partner_code' => config('services.momo.partner_code'),
            'access_key' => config('services.momo.access_key') ? '***' . substr(config('services.momo.access_key'), -4) : 'EMPTY',
            'secret_key' => config('services.momo.secret_key') ? '***' . substr(config('services.momo.secret_key'), -4) : 'EMPTY',
            'sandbox' => config('services.momo.sandbox'),
            'return_url' => config('services.momo.return_url') ?: 'AUTO',
            'notify_url' => config('services.momo.notify_url') ?: 'AUTO',
        ];

        $momoService = new MomoPaymentService();
        $testUrl = $momoService->createPayment(999, 10000, 'Test payment');

        return response()->json([
            'config' => $config,
            'has_payment_url' => !empty($testUrl),
            'payment_url' => $testUrl,
            'message' => empty($testUrl) ? 'Không tạo được payment URL. Kiểm tra lại API keys hoặc xem log để biết lỗi.' : 'OK',
        ]);
    }

    /**
     * Test VNPay config
     */
    public function testVnpay()
    {
        $config = [
            'tmn_code' => config('services.vnpay.tmn_code') ?: 'EMPTY',
            'hash_secret' => config('services.vnpay.hash_secret') ? '***' . substr(config('services.vnpay.hash_secret'), -4) : 'EMPTY',
            'sandbox' => config('services.vnpay.sandbox'),
            'return_url' => config('services.vnpay.return_url') ?: 'AUTO',
        ];

        $vnpayService = new VnpayPaymentService();
        $testUrl = $vnpayService->createPayment(999, 10000, 'Test payment');

        return response()->json([
            'config' => $config,
            'has_payment_url' => !empty($testUrl),
            'payment_url' => $testUrl,
            'message' => empty($testUrl) ? 'Không tạo được payment URL. Kiểm tra lại API keys.' : 'OK',
        ]);
    }
}

