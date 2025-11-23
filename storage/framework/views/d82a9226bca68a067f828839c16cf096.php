<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'E-Learning'); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <?php echo $__env->yieldPushContent('styles'); ?>

</head>
<body>
    <header class="navbar" id="mainHeader">
        <div class="navbar-left">
            <h1 class="logo"><a href="<?php echo e(route('home')); ?>"><span class="logo-e">E</span><span class="highlight">LEARNING</span></a></h1>
            <nav>
                <a href="<?php echo e(route('courses.index')); ?>">Khám phá</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('student.courses')); ?>">Khóa học của tôi</a>
                <?php endif; ?>
            </nav>
        </div>

        <div class="navbar-center">
            <form action="<?php echo e(route('courses.index')); ?>" method="GET" class="search-form">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" placeholder="Bạn muốn học gì hôm nay?" 
                           value="<?php echo e(request('search')); ?>" class="search-input">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="navbar-right">
            
            
            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('notifications.index')); ?>" class="header-icon-btn notification-icon" title="Thông báo">
                    <i class="fas fa-bell"></i>
                    <?php
                        $unreadCount = Auth::user()->unreadNotificationsCount();
                    ?>
                    <?php if(($unreadCount ?? 0) > 0): ?>
                        <span class="icon-badge notification-badge"><?php echo e(($unreadCount ?? 0) > 9 ? '9+' : ($unreadCount ?? 0)); ?></span>
                    <?php endif; ?>
                </a>
                
                <div class="user-menu">
                    <div class="avatar" id="avatarBtn">
                        <?php if(Auth::user()->avatar): ?>
                            <img src="<?php echo e(Auth::user()->avatar_url); ?>" alt="Avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                        <?php else: ?>
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        <?php endif; ?>
                    </div>
                    <div class="dropdown-menu" id="userDropdown">
                        <div class="user-info">
                            <div class="user-name"><?php echo e(Auth::user()->name); ?></div>
                            <div class="user-email"><?php echo e(Auth::user()->email); ?></div>
                        </div>
                        <hr>
                        <a href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-user"></i> Thông tin cá nhân</a>
                        <a href="<?php echo e(route('student.courses')); ?>"><i class="fas fa-book"></i> Khóa học của tôi</a>
                        <a href="<?php echo e(route('orders.index')); ?>"><i class="fas fa-receipt"></i> Đơn hàng</a>
                        
                        <?php if(Auth::user()->isInstructor()): ?>
                            <hr>
                            <a href="<?php echo e(route('instructor.questions.index')); ?>" style="background: #f7f9fa;">
                                <i class="fas fa-chalkboard-teacher"></i> Quản lý Hỏi đáp (Giảng viên)
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('notifications.index')); ?>">
                            <i class="fas fa-bell"></i> Thông báo
                            <?php if(($unreadCount ?? 0) > 0): ?>
                                <span class="menu-badge"><?php echo e(($unreadCount ?? 0) > 9 ? '9+' : ($unreadCount ?? 0)); ?></span>
                            <?php endif; ?>
                        </a>
                        <hr>
                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
                        </form>
                        <hr>
                        <div class="plus-section">
                            <strong>E-Learning Plus</strong><br>
                            <small>Truy cập 10,000+ khóa học</small>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <a href="/login" class="login-link">Đăng nhập</a>
                <a href="/register" class="register-btn">Tham gia miễn phí</a>
            <?php endif; ?>
        </div>
    </header>


    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Về E-Learning</h3>
                <p>Nền tảng học trực tuyến hàng đầu với hàng nghìn khóa học chất lượng cao từ các giảng viên chuyên nghiệp.</p>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Khóa học</h3>
                <ul>
                    <li><a href="<?php echo e(route('courses.index')); ?>?level=beginner">Khóa học cơ bản</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>?level=intermediate">Khóa học trung bình</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>?level=advanced">Khóa học nâng cao</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>">Tất cả khóa học</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Hỗ trợ</h3>
                <ul>
                    <li><a href="#">Trung tâm trợ giúp</a></li>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Thông tin</h3>
                <ul>
                    <li><a href="#">Về chúng tôi</a></li>
                    <li><a href="#">Trở thành giảng viên</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 E-Learning. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Chính sách</a>
                <a href="#">Điều khoản</a>
                <a href="#">Bản đồ trang</a>
            </div>
        </div>
    </footer>

<script src="<?php echo e(asset('js/main.js')); ?>"></script>

</body>
</html>
<?php /**PATH D:\elearning\resources\views/layouts/app.blade.php ENDPATH**/ ?>