-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 07, 2025 lúc 04:34 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `elearning`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Lập trình', 'lap-trinh', NULL, NULL, NULL, '2025-10-15 13:08:10', '2025-10-15 13:08:10'),
(2, 'Thiết kế', 'thiet-ke', NULL, NULL, NULL, '2025-10-15 13:08:10', '2025-10-15 13:08:10'),
(3, 'Khoa học dữ liệu', 'khoa-hoc-du-lieu', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37'),
(4, 'Trí tuệ nhân tạo', 'tri-tue-nhan-tao', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37'),
(5, 'Phát triển web', 'phat-trien-web', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37'),
(6, 'Phát triển di động', 'phat-trien-di-dong', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37'),
(7, 'Marketing số', 'marketing-so', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37'),
(8, 'Kinh doanh', 'kinh-doanh', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37'),
(9, 'An ninh mạng', 'an-ninh-mang', NULL, NULL, NULL, '2025-10-29 16:46:37', '2025-10-29 16:46:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category_media`
--

CREATE TABLE `category_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'thumbnail',
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category_media`
--

INSERT INTO `category_media` (`id`, `category_id`, `type`, `path`, `created_at`, `updated_at`) VALUES
(1, 1, 'thumbnail', 'lap-trinh.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(2, 2, 'thumbnail', 'thiet-ke.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(3, 3, 'thumbnail', 'khoa-hoc-du-lieu.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(4, 4, 'thumbnail', 'tri-tue-nhan-tao.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(5, 5, 'thumbnail', 'phat-trien-web.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(6, 6, 'thumbnail', 'phat-trien-di-dong.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(7, 7, 'thumbnail', 'marketing-so.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(8, 8, 'thumbnail', 'kinh-doanh.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10'),
(9, 9, 'thumbnail', 'an-ninh-mang.jpg', '2025-10-29 09:48:10', '2025-10-29 09:48:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(40) NOT NULL,
  `type` enum('percent','fixed') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `max_uses` int(10) UNSIGNED DEFAULT NULL,
  `uses` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(260) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `description_html` longtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `thumbnail_path` varchar(500) DEFAULT NULL,
  `status` enum('draft','published','hidden','archived') NOT NULL DEFAULT 'draft',
  `total_duration` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `level` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `language` varchar(50) DEFAULT 'Vietnamese',
  `enrolled_students` int(11) DEFAULT 0,
  `rating` decimal(2,1) DEFAULT 0.0,
  `rating_count` int(11) DEFAULT 0,
  `video_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `instructor_id`, `category_id`, `title`, `slug`, `short_description`, `description`, `description_html`, `price`, `compare_at_price`, `thumbnail_path`, `status`, `total_duration`, `level`, `language`, `enrolled_students`, `rating`, `rating_count`, `video_count`, `created_at`, `updated_at`) VALUES
(10, 1, 1, 'Laravel Cơ bản', 'laravel-co-ban', 'Khóa học Laravel dành cho người mới bắt đầu', 'Tìm hiểu cách xây dựng ứng dụng web bằng Laravel Framework. Bao gồm routing, controller, view, Eloquent ORM và Blade Template.', NULL, 500000.00, 900000.00, 'laravel-basic.jpg', 'published', 19, 'beginner', 'Vietnamese', 1200, 4.7, 86, 42, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(11, 1, 1, 'PHP OOP nâng cao', 'php-oop-nang-cao', 'Làm chủ Lập trình Hướng đối tượng trong PHP', 'Khóa học giúp bạn hiểu sâu về OOP, SOLID, Dependency Injection, Design Patterns và thực hành với PHP 8.', NULL, 450000.00, 850000.00, 'php-oop.jpg', 'published', 15, 'intermediate', 'Vietnamese', 980, 4.5, 65, 35, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(12, 1, 1, 'NodeJS từ cơ bản đến nâng cao', 'nodejs-co-ban-den-nang-cao', 'Xây dựng ứng dụng backend với NodeJS và Express', 'Khóa học hướng dẫn cách tạo RESTful API, xử lý JWT, upload file, và kết nối với MongoDB.', NULL, 600000.00, 1100000.00, 'nodejs-advanced.jpg', 'published', 22, 'intermediate', 'Vietnamese', 2100, 4.8, 124, 58, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(13, 1, 1, 'ReactJS hiện đại', 'reactjs-hien-dai', 'Xây dựng ứng dụng Frontend với React Hooks & Router', 'Khóa học hướng dẫn cách sử dụng React Hooks, Context API, Redux Toolkit và tạo ứng dụng SPA hoàn chỉnh.', NULL, 550000.00, 990000.00, 'reactjs-modern.jpg', 'published', 20, 'intermediate', 'Vietnamese', 1800, 4.6, 94, 47, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(14, 1, 1, 'Java Spring Boot Cơ bản', 'java-spring-boot-co-ban', 'Lập trình backend với Java Spring Boot', 'Khóa học giúp bạn làm chủ Spring Boot, JPA, REST API, và triển khai ứng dụng trên server thực tế.', NULL, 650000.00, 1200000.00, 'spring-boot.jpg', 'published', 26, 'intermediate', 'Vietnamese', 1500, 4.7, 78, 62, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(15, 1, 1, 'Python Web với Django', 'python-django', 'Học Django Framework để tạo web nhanh chóng và mạnh mẽ', 'Khóa học giúp bạn hiểu rõ về MVT, ORM, Authentication, Form và triển khai ứng dụng Django thực tế.', NULL, 500000.00, 950000.00, 'django-web.jpg', 'published', 19, 'intermediate', 'Vietnamese', 1750, 4.8, 103, 51, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(16, 1, 1, 'C# .NET Core Web API', 'csharp-dotnetcore-api', 'Phát triển ứng dụng API mạnh mẽ với .NET Core', 'Khóa học giúp bạn làm chủ C#, Entity Framework Core, Identity, Authentication và API Documentation (Swagger).', NULL, 700000.00, 1300000.00, 'dotnet-core.jpg', 'published', 24, 'intermediate', 'Vietnamese', 950, 4.5, 52, 40, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(17, 1, 1, 'Fullstack MERN Project', 'fullstack-mern-project', 'Dự án thực tế Fullstack với MongoDB, Express, React, Node', 'Khóa học giúp bạn tự tay xây dựng ứng dụng thực tế, kết nối frontend – backend – database, deploy lên server.', NULL, 800000.00, 1500000.00, 'mern-project.jpg', 'published', 30, 'advanced', 'Vietnamese', 2100, 4.9, 128, 70, '2025-10-29 18:46:13', '2025-10-29 18:46:13'),
(19, NULL, 2, 'Nền tảng Thiết kế đồ hoạ với Canva', 'canva-thiet-ke-do-hoa', 'Bắt đầu với Canva: bố cục, phông chữ, màu sắc, template.', '<p>Khoá học giúp bạn làm chủ Canva từ con số 0, tạo banner, poster, social post chuyên nghiệp.</p>', NULL, 399000.00, 790000.00, 'canva-basics.jpg', 'published', 10, 'beginner', 'Vietnamese', 1200, 4.6, 320, 85, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(20, NULL, 2, 'Figma UI/UX từ cơ bản đến prototype', 'figma-ui-ux-prototype', 'Thiết kế giao diện, auto layout, component, prototype trong Figma.', '<p>Làm chủ Figma với workflow thực chiến: grid, component, variants, prototype & handoff.</p>', NULL, 549000.00, 990000.00, 'figma-uiux.jpg', 'published', 18, 'beginner', 'Vietnamese', 2100, 4.7, 540, 140, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(21, NULL, 2, 'Adobe Illustrator Chuyên sâu', 'adobe-illustrator-chuyen-sau', 'Vector, pen tool, logo, icon, bộ nhận diện thương hiệu.', '<p>Đi sâu kỹ thuật vector: pathfinder, blend, pattern, gradient mesh, appearance…</p>', NULL, 589000.00, 1090000.00, 'ai-illustrator.jpg', 'published', 22, 'intermediate', 'Vietnamese', 1600, 4.5, 410, 120, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(22, NULL, 2, 'Photoshop Thực chiến Retouch & Social', 'photoshop-retouch-social', 'Retouch chân dung, blend màu, thiết kế social banner.', '<p>Thực hành retouch chuyên nghiệp, action, LUT, smart object & workflow social.</p>', NULL, 519000.00, 990000.00, 'photoshop-retouch.jpg', 'published', 16, 'intermediate', 'Vietnamese', 1350, 4.6, 360, 96, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(23, NULL, 3, 'Python cho Phân tích dữ liệu', 'python-phan-tich-du-lieu', 'Numpy, Pandas, Matplotlib, làm sạch & trực quan hoá dữ liệu.', '<p>Pipeline xử lý dữ liệu thực tế: EDA, thống kê mô tả, vẽ biểu đồ & report.</p>', NULL, 599000.00, 1190000.00, 'python-data-analysis.jpg', 'published', 20, 'beginner', 'Vietnamese', 3200, 4.7, 890, 155, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(24, NULL, 3, 'SQL từ cơ bản đến nâng cao', 'sql-tu-co-ban-den-nang-cao', 'Truy vấn dữ liệu, join, window function, tối ưu & bài tập thực tế.', '<p>Luyện SQL trên MySQL/PostgreSQL với hàng chục case: sales, e-commerce, marketing.</p>', NULL, 449000.00, 890000.00, 'sql-advanced.jpg', 'published', 14, 'beginner', 'Vietnamese', 4100, 4.6, 1100, 120, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(25, NULL, 3, 'Machine Learning cơ bản với Scikit-learn', 'machine-learning-scikit-learn', 'Linear/Logistic Regression, Tree, SVM, model metrics & tuning.', '<p>Xây dựng mô hình ML đầu tay, đánh giá & cải thiện bằng cross-validation, grid search.</p>', NULL, 649000.00, 1290000.00, 'ml-scikit.jpg', 'published', 24, 'intermediate', 'Vietnamese', 2600, 4.6, 670, 170, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(26, NULL, 3, 'Power BI: Dashboard & DAX thực chiến', 'power-bi-dashboard-dax', 'Kết nối dữ liệu, làm sạch, DAX, dashboard theo KPI.', '<p>Làm báo cáo động theo KPI Sales/Finance, chia sẻ & publish lên Power BI Service.</p>', NULL, 579000.00, 1090000.00, 'powerbi.jpg', 'published', 18, 'intermediate', 'Vietnamese', 2200, 4.7, 590, 130, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(27, NULL, 4, 'Deep Learning cơ bản với Keras', 'deep-learning-keras', 'ANN, CNN, RNN, overfitting, augmentation, callback.', '<p>Xây dựng mạng nơ-ron cho ảnh & chuỗi, thực hành trên TensorFlow/Keras.</p>', NULL, 689000.00, 1390000.00, 'dl-keras.jpg', 'published', 22, 'intermediate', 'Vietnamese', 1800, 4.6, 520, 160, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(28, NULL, 4, 'Xử lý ngôn ngữ tự nhiên (NLP) cơ bản', 'nlp-co-ban', 'Tiền xử lý văn bản, TF-IDF, Word2Vec, phân loại & sentiment.', '<p>Pipeline NLP end-to-end, đánh giá & triển khai mô hình phân loại văn bản.</p>', NULL, 629000.00, 1190000.00, 'nlp-basics.jpg', 'published', 16, 'intermediate', 'Vietnamese', 1500, 4.5, 410, 110, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(29, NULL, 4, 'Computer Vision với OpenCV', 'computer-vision-opencv', 'Tiền xử lý ảnh, phát hiện đối tượng, contour, tracking.', '<p>Thực hành OpenCV + Python cho các bài toán thị giác máy tính nền tảng.</p>', NULL, 569000.00, 1090000.00, 'opencv.jpg', 'published', 14, 'intermediate', 'Vietnamese', 1400, 4.5, 380, 95, '2025-10-30 00:16:19', '2025-10-30 00:16:19'),
(30, NULL, 4, 'LLM & Prompt Engineering thực hành', 'llm-prompt-engineering', 'Hiểu LLM, token, prompt pattern, RAG cơ bản.', 'Thực hành prompt hiệu quả & tích hợp LLM vào ứng dụng bằng API.ádddddddd', '<ul><li>Thực hành prompt hiệu quả &amp; tích hợp LLM vào ứng dụng bằng API.</li><li>Thực hành prompt hiệu quả &amp; tích hợp LLM vào ứng dụng bằng API.</li><li>Thực hành prompt hiệu quả &amp; tích hợp LLM vào ứng dụng bằng API.</li><li>Thực hành prompt hiệu quả &amp; tích hợp LLM vào ứng dụng bằng API.</li></ul>', 699000.00, 1490000.00, 'llm-prompt.jpg', 'published', 12, 'intermediate', 'Vietnamese', 900, 4.6, 210, 70, '2025-10-30 00:16:20', '2025-10-29 17:31:22'),
(31, NULL, 5, 'HTML/CSS/JS Cơ bản qua dự án', 'html-css-js-co-ban', 'Xây dựng landing page responsive từ A → Z.', '<p>Nắm vững cấu trúc HTML, Flex/Grid, DOM & best-practices responsive.</p>', NULL, 379000.00, 790000.00, 'html-css-js.jpg', 'published', 12, 'beginner', 'Vietnamese', 4800, 4.7, 1400, 90, '2025-10-30 00:16:20', '2025-10-30 00:16:20'),
(32, NULL, 5, 'ReactJS từ cơ bản đến nâng cao', 'reactjs-tu-co-ban-den-nang-cao', 'Component, hook, router, state management, tối ưu hiệu năng.', '<p>Xây SPA hoàn chỉnh, tách module & tối ưu hoá production build.</p>', NULL, 649000.00, 1290000.00, 'reactjs.jpg', 'published', 24, 'intermediate', 'Vietnamese', 5200, 4.7, 1600, 170, '2025-10-30 00:16:20', '2025-10-30 00:16:20'),
(33, NULL, 5, 'NodeJS & Express APIs thực chiến', 'nodejs-express-api-thuc-chien', 'RESTful API, auth (JWT), middleware, upload, logging.', '<p>Xây dựng API chuẩn production: cấu trúc, test, bảo mật & deploy.</p>', NULL, 629000.00, 1190000.00, 'node-express.jpg', 'published', 20, 'intermediate', 'Vietnamese', 3900, 4.6, 980, 140, '2025-10-30 00:16:20', '2025-10-30 00:16:20'),
(34, NULL, 5, 'Laravel Cơ bản đến CRUD & Auth', 'laravel-co-ban-crud-auth', 'Routing, Blade, Eloquent, migration, CRUD, auth, middleware.', '<p>Hoàn thiện mini-project chuẩn MVC & thực hành best-practice Laravel.</p>', NULL, 599000.00, 1190000.00, 'laravel-crud-auth.jpg', 'published', 18, 'beginner', 'Vietnamese', 4500, 4.7, 1200, 125, '2025-10-30 00:16:20', '2025-10-30 00:16:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `course_category`
--

CREATE TABLE `course_category` (
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','revoked') NOT NULL DEFAULT 'active',
  `enrolled_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `video_path` varchar(500) DEFAULT NULL,
  `attachment_path` varchar(500) DEFAULT NULL,
  `duration` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_preview` tinyint(1) NOT NULL DEFAULT 0,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lesson_id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_10_29_025747_create_sessions_table', 1),
(2, '2025_10_29_093627_add_image_to_categories_table', 2),
(3, '2025_10_29_093959_create_category_media_table', 3),
(4, '2025_10_29_144425_add_description_html_to_courses_table', 4),
(5, '2025_10_29_151234_make_instructor_id_nullable_on_courses_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(40) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','failed','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `provider` enum('bank_transfer','vnpay','momo','paypal') NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('initiated','succeeded','failed','refunded') NOT NULL DEFAULT 'initiated',
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1i7FojiuAYYQYG9ocywaiw1SbrwP124nRM3mvQp6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidEFQanBXR1Q5RDY4dU9EWHVDNUpnRkVyY2xUSWt4NkhSWDY4TGRyaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761790360),
('1MyutWV2tlAiyEFUsQ0p999ol7Lp00VisSkHrG8d', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0J3NlZvUGdEVXdjWlAydXFHQkdIZ0locWJvSmVPd3BpeFdwZVBGTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTcxOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvP2dpZHpsPWEyTlkyMFlmWGFRVkNrODgyUlEwSDkwcnZtdVV2alRFc3NJbjE0WmN0SF9HRFViSjQtQUI3dUtzd3J6NGt1T1ZxSnd0MTNVV2pMTHYwZ0U3STAmdXRtX2NhbXBhaWduPXphbG8mdXRtX21lZGl1bT16YWxvJnV0bV9zb3VyY2U9emFsbyZ6YXJzcmM9MzAiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761759635),
('iUa5C5ZrJkclb5758lgxaQY30NRDUCnrQZ6v5pgy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVNMRGpZU3NTSE84T0pKTURnREI3c0VMNEtQUENpaWZOWHgzWWpvZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761760354),
('kcjR1jY0Rq3mQ1GhPFtimGxzCM720Tkm45PLrNtD', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0FzaGExWG9DcEFTRVk5dWpQUzN2UnZocFpVSXAxb09wN0h3UmJBWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761759625),
('UIjHPlnhV9DFmDYThDvxHfqjm9DD0DaiyIPG6ypi', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_2_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.2 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRGZqNUM5WHN2em9sYW9NQVVLT3p5TU5JVkdzVHJUdkE4aDM3Q2R6cSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761759661),
('VIxpSsTV6SsQ8gbGqet5cNXOGEWHmmVPMhek26zT', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidXo4ZzlmSk5VYlV3UWwyRWJvMnBWenpJT0d3dW9iMW5GYk8zclYzUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1761760247),
('WlxBtk9L3GEi2VG3lwLI6LjI1JeZgqjnahiFqvG9', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiblVPelFDNmRib200eEthQkNDMWtPVzhLa0gxT21DUnZGSkV1RzBiayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3Vyc2VzLzE3L2VkaXQiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLmNvdXJzZXMuZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1761757628);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `email_verified_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '12345678', 'admin', NULL, NULL, '2025-10-15 13:08:10', '2025-10-15 13:08:10'),
(2, 'Trinh Nguyen', 'vietkel05x@gmail.com', '$2y$12$ah1AEiHtbUYhbv.dPPLtp.9R4xftJ51eINKdIbwbA4Ff3ck/NiF.O', 'student', NULL, NULL, '2025-10-29 14:10:21', '2025-10-29 14:10:21'),
(3, 'Việt', 'vietkel05@gmail.com', '$2y$12$./5p0/8ef9QBWd031HW9iuxRNQB3E2teC16KtY79dvSDOqkts4OlC', 'student', NULL, NULL, '2025-10-29 17:49:54', '2025-10-29 17:49:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_notifications`
--

CREATE TABLE `user_notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_categories_parent` (`parent_id`);

--
-- Chỉ mục cho bảng `category_media`
--
ALTER TABLE `category_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_media_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_coupons_active_window` (`starts_at`,`ends_at`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_courses_instructor` (`instructor_id`),
  ADD KEY `idx_courses_status` (`status`);
ALTER TABLE `courses` ADD FULLTEXT KEY `ftx_courses` (`title`,`short_description`,`description`);

--
-- Chỉ mục cho bảng `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`course_id`,`category_id`),
  ADD KEY `fk_cc_category` (`category_id`);

--
-- Chỉ mục cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_enroll_user_course` (`user_id`,`course_id`),
  ADD KEY `idx_enroll_course` (`course_id`);

--
-- Chỉ mục cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lessons_section_pos` (`section_id`,`position`);

--
-- Chỉ mục cho bảng `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_progress_user_lesson` (`user_id`,`lesson_id`),
  ADD KEY `fk_progress_lesson` (`lesson_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_admin` (`created_by`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `idx_orders_status_created` (`status`,`created_at`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_item_order_course` (`order_id`,`course_id`),
  ADD KEY `fk_items_course` (`course_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_order` (`order_id`),
  ADD KEY `idx_payments_provider_status` (`provider`,`status`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_review_user_course` (`user_id`,`course_id`),
  ADD KEY `idx_reviews_course` (`course_id`);

--
-- Chỉ mục cho bảng `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sections_course_pos` (`course_id`,`position`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role` (`role`);

--
-- Chỉ mục cho bảng `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`notification_id`,`user_id`),
  ADD KEY `fk_un_user` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `category_media`
--
ALTER TABLE `category_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `category_media`
--
ALTER TABLE `category_media`
  ADD CONSTRAINT `category_media_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `course_category`
--
ALTER TABLE `course_category`
  ADD CONSTRAINT `fk_cc_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cc_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enroll_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enroll_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `fk_lessons_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `fk_progress_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_admin` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `fk_sections_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `fk_un_notification` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_un_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
