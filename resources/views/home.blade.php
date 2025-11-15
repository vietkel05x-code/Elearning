@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h2>Bắt đầu hành trình học tập với chi phí<span> tiết kiệm!</span></h2>
        <p>Nếu bạn mới bắt đầu với E-Learning, tin vui cho bạn đây! Trong thời gian có hạn, các khóa học chỉ từ <strong>279,000đ</strong> dành cho học viên mới. Đăng ký ngay hôm nay!</p>
        <div class="hero-cta">
            <a href="{{ route('courses.index') }}" class="cta-primary">Khám phá khóa học</a>
            <a href="{{ route('register') }}" class="cta-secondary">Đăng ký miễn phí</a>
        </div>
    </div>
    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-number" data-count="{{ \App\Models\Course::where('status', 'published')->count() }}">0</div>
            <div class="stat-label">Khóa học</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-count="{{ \App\Models\User::where('role', 'student')->count() }}">0</div>
            <div class="stat-label">Học viên</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" data-count="{{ \App\Models\Enrollment::where('status', 'active')->count() }}">0</div>
            <div class="stat-label">Lượt đăng ký</div>
        </div>
    </div>
</section>

<!-- CATEGORY SECTION -->
<section class="category-section">
  <div class="category-left">
    <h2>Trang bị các kỹ năng quan trọng cho công việc và cuộc sống.</h2>
    <p>E-Learning giúp bạn rèn luyện nhanh các kỹ năng được nhà tuyển dụng tìm kiếm và nâng tầm sự nghiệp trong bối cảnh thị trường lao động luôn biến động.</p>
  </div>

  <div class="category-right">
    <div class="category-carousel-wrapper">
        <div class="category-carousel">
            @foreach ($categories as $cat)
                <div class="category-card">
                    <img src="{{ asset('img/categories/' . ($cat->thumbnail->path ?? 'default.jpg')) }}" alt="{{ $cat->name }}">
                    <div class="category-info">
                        <h4>{{ $cat->name }}</h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="carousel-dots">
        <span class="dot active" data-index="0"></span>
        <span class="dot" data-index="1"></span>
        <span class="dot" data-index="2"></span>
    </div>
  </div>
</section>


<!-- ================= COURSES BY CATEGORY (TABS) ================= -->
<div class="page-wrapper">

    <section class="tab-section">
        <h2>Kỹ năng giúp bạn bứt phá trong sự nghiệp và cuộc sống.</h2>
        <p>Dù là kỹ năng thiết yếu hay kiến thức kỹ thuật chuyên sâu, E-Learning luôn hỗ trợ bạn phát triển sự nghiệp bền vững.</p>

        <div class="tab-header">
            @foreach ($topCategories as $index => $category)
                <div class="tab-link {{ $index === 0 ? 'active' : '' }}" data-id="{{ $category->id }}">
                    {{ $category->name }}
                </div>
            @endforeach
        </div>

        <div class="tab-content">
            @foreach ($topCategories as $index => $category)
                <div class="tab-panel {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $category->id }}">
                    <div class="course-slider">
                        <button class="arrow prev">&#10094;</button>
                        <div class="course-grid">
                            @foreach ($coursesByCategory[$category->id] as $course)
                            <div class="course-card">
                                <img src="{{ asset('img/courses/' . ($course->thumbnail_path ?? 'default.jpg')) }}" alt="{{ $course->title }}">
                                <h4>{{ $course->title }}</h4>
                                <p class="instructor">{{ $course->instructor->name ?? 'Instructor' }}</p>
                                <div class="price">
                                    <span class="new">₫{{ number_format($course->price, 0, ',', '.') }}</span>
                                    @if($course->compare_at_price)
                                    <span class="old">₫{{ number_format($course->compare_at_price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <!-- Popup -->
                                <div class="course-popup">
                                    <h4>{{ $course->title }}</h4>
                                    <span class="badge">Bestseller</span>
                                    <p class="meta">
                                        {{ $course->total_duration }} total hours · {{ ucfirst($course->level) }} · {{ ucfirst($course->language) }}
                                    </p>
                                    <p class="desc">{{ $course->short_description }}</p>
                                    <ul>
                                        <li>Understand key concepts and build solid foundations</li>
                                        <li>Hands-on lessons and real projects</li>
                                        <li>Updated to latest version in 2025</li>
                                    </ul>
                                    <button class="add-cart-btn">Add to cart</button>
                                </div>
                            </div>
                            @endforeach
                        </div> <!-- course-grid -->
                        <button class="arrow next">&#10095;</button>
                    </div> <!-- course-slider -->

                </div>
            @endforeach
        </div>
    </section>
</div>

<!-- STATS SECTION -->
<section class="stats-section">
    <div class="page-wrapper">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Học mọi lúc mọi nơi</h3>
                <p>Truy cập khóa học từ bất kỳ thiết bị nào, học theo tốc độ của riêng bạn</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3>Chứng chỉ hoàn thành</h3>
                <p>Nhận chứng chỉ sau khi hoàn thành khóa học để nâng cao sự nghiệp</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Cộng đồng học tập</h3>
                <p>Kết nối với hàng nghìn học viên và giảng viên trên toàn thế giới</p>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Hỗ trợ 24/7</h3>
                <p>Đội ngũ hỗ trợ luôn sẵn sàng giúp đỡ bạn trong suốt quá trình học tập</p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="testimonials-section">
    <div class="page-wrapper">
        <h2 style="text-align:center;margin-bottom:48px;font-size:32px;font-weight:700">Học viên nói gì về chúng tôi</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"E-Learning đã giúp tôi nâng cao kỹ năng và tìm được công việc mơ ước. Các khóa học rất chất lượng và dễ hiểu!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">N</div>
                    <div class="author-info">
                        <div class="author-name">Nguyễn Văn A</div>
                        <div class="author-role">Software Developer</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Nội dung khóa học rất thực tế và có thể áp dụng ngay vào công việc. Tôi đã học được rất nhiều điều bổ ích!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">T</div>
                    <div class="author-info">
                        <div class="author-name">Trần Thị B</div>
                        <div class="author-role">Marketing Manager</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Giảng viên rất nhiệt tình và chuyên nghiệp. Tôi đã hoàn thành nhiều khóa học và rất hài lòng với chất lượng!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">L</div>
                    <div class="author-info">
                        <div class="author-name">Lê Văn C</div>
                        <div class="author-role">Business Analyst</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
