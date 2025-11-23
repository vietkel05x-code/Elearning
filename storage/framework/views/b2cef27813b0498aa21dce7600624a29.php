

<?php $__env->startSection('title', 'Thống kê doanh thu'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/admin.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-statistics-page">
  <h1 class="admin-statistics-page__title">Thống kê doanh thu</h1>

  <!-- Filter -->
  <div class="admin-statistics-filters">
    <form method="GET" action="<?php echo e(route('admin.statistics.revenue')); ?>" class="admin-statistics-filters__form">
      <div class="admin-statistics-filters__field">
        <label class="admin-statistics-filters__label">Khoảng thời gian</label>
        <select name="period" class="admin-statistics-filters__select">
          <option value="day" <?php echo e($period == 'day' ? 'selected' : ''); ?>>Theo ngày</option>
          <option value="week" <?php echo e($period == 'week' ? 'selected' : ''); ?>>Theo tuần</option>
          <option value="month" <?php echo e($period == 'month' ? 'selected' : ''); ?>>Theo tháng</option>
          <option value="year" <?php echo e($period == 'year' ? 'selected' : ''); ?>>Theo năm</option>
        </select>
      </div>
      <div class="admin-statistics-filters__field">
        <label class="admin-statistics-filters__label">Từ ngày</label>
        <input type="date" name="start_date" value="<?php echo e($startDate->format('Y-m-d')); ?>" class="admin-statistics-filters__input">
      </div>
      <div class="admin-statistics-filters__field">
        <label class="admin-statistics-filters__label">Đến ngày</label>
        <input type="date" name="end_date" value="<?php echo e($endDate->format('Y-m-d')); ?>" class="admin-statistics-filters__input">
      </div>
      <button type="submit" class="admin-statistics-filters__button">Lọc</button>
    </form>
  </div>

  <!-- Summary Cards -->
  <div class="admin-summary-cards">
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Tổng doanh thu</p>
      <p class="admin-summary-card__value admin-summary-card__value--primary">₫<?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Tổng đơn hàng</p>
      <p class="admin-summary-card__value admin-summary-card__value--info"><?php echo e($totalOrders); ?></p>
      <p class="admin-summary-card__meta"><?php echo e($paidOrders); ?> đã thanh toán</p>
    </div>
    <div class="admin-summary-card">
      <p class="admin-summary-card__label">Đơn hàng trung bình</p>
      <p class="admin-summary-card__value admin-summary-card__value--success">
        ₫<?php echo e($paidOrders > 0 ? number_format($totalRevenue / $paidOrders, 0, ',', '.') : '0'); ?>

      </p>
    </div>
  </div>

  <!-- Revenue Chart -->
  <div class="admin-chart-container">
    <h2 class="admin-chart-container__title">Biểu đồ doanh thu</h2>
    <canvas id="revenueChart" class="admin-chart-container__canvas"></canvas>
  </div>

  <!-- Revenue by Payment Method -->
  <div class="admin-card">
    <h2 class="admin-card__title" style="margin-bottom: var(--spacing-lg);">Doanh thu theo phương thức thanh toán</h2>
    <?php if($revenueByPayment->count() > 0): ?>
      <div class="admin-payment-list">
        <?php $__currentLoopData = $revenueByPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="admin-payment-item">
            <div class="admin-payment-item__header">
              <div>
                <p class="admin-payment-item__name">
                  <?php if($item->provider == 'bank_transfer'): ?> Chuyển khoản
                  <?php elseif($item->provider == 'vnpay'): ?> VNPay
                  <?php elseif($item->provider == 'momo'): ?> MoMo
                  <?php elseif($item->provider == 'paypal'): ?> PayPal
                  <?php else: ?> <?php echo e($item->provider); ?>

                  <?php endif; ?>
                </p>
              </div>
              <p class="admin-payment-item__value">
                ₫<?php echo e(number_format($item->total, 0, ',', '.')); ?>

              </p>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php else: ?>
      <p class="admin-card__empty">Chưa có dữ liệu thanh toán</p>
    <?php endif; ?>
  </div>

  <!-- Recent Orders -->
  <div class="admin-card">
    <h2 class="admin-card__title" style="margin-bottom: var(--spacing-lg);">Đơn hàng gần đây</h2>
    <?php if($recentOrders->count() > 0): ?>
      <div style="overflow-x: auto;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Mã đơn</th>
              <th>Khách hàng</th>
              <th>Khóa học</th>
              <th style="text-align: right;">Tổng tiền</th>
              <th style="text-align: center;">Trạng thái</th>
              <th>Ngày</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td style="font-weight: bold;">#<?php echo e($order->code); ?></td>
                <td><?php echo e($order->user->name); ?></td>
                <td>
                  <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($item->course->title); ?></div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </td>
                <td style="text-align: right; font-weight: bold;">₫<?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
                <td style="text-align: center;">
                  <?php if($order->status == 'paid'): ?>
                    <span class="admin-badge" style="background: var(--color-success); color: white;">Đã thanh toán</span>
                  <?php elseif($order->status == 'pending'): ?>
                    <span class="admin-badge" style="background: #ffc107; color: #333;">Chờ thanh toán</span>
                  <?php else: ?>
                    <span class="admin-badge" style="background: #6c757d; color: white;"><?php echo e($order->status); ?></span>
                  <?php endif; ?>
                </td>
                <td style="color: var(--color-text-secondary); font-size: var(--font-size-base);"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="admin-card__empty">Chưa có đơn hàng nào</p>
    <?php endif; ?>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('revenueChart').getContext('2d');
  const chartData = <?php echo json_encode($chartData, 15, 512) ?>;
  
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartData.map(d => d.label),
      datasets: [{
        label: 'Doanh thu (₫)',
        data: chartData.map(d => d.revenue),
        borderColor: '#a435f0',
        backgroundColor: 'rgba(164, 53, 240, 0.1)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return '₫' + new Intl.NumberFormat('vi-VN').format(value);
            }
          }
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Doanh thu: ₫' + new Intl.NumberFormat('vi-VN').format(context.parsed.y);
            }
          }
        }
      }
    }
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\elearning\resources\views/admin/statistics/revenue.blade.php ENDPATH**/ ?>