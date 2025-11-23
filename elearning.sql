-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2025 at 08:15 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_best_answer` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `user_id`, `content`, `is_best_answer`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'Sau đây là các bước...', 0, '2025-11-21 05:16:50', '2025-11-21 05:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(160) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Lập trình', 'lap-trinh', 'Khám phá thế giới lập trình với các ngôn ngữ phổ biến như PHP, Python, JavaScript, Java, C++. Từ cơ bản đến nâng cao, học cách xây dựng ứng dụng web, mobile và phần mềm chuyên nghiệp.', 'categories/lap-trinh.jpg', NULL, '2025-10-15 13:08:10', '2025-11-16 16:38:10'),
(2, 'Thiết kế', 'thiet-ke', 'Học thiết kế đồ họa, UI/UX, và thiết kế web với các công cụ chuyên nghiệp như Adobe Photoshop, Illustrator, Figma, Canva. Phát triển kỹ năng sáng tạo và thẩm mỹ cho sự nghiệp thiết kế.', 'categories/thiet-ke.jpg', NULL, '2025-10-15 13:08:10', '2025-11-16 16:38:10'),
(3, 'Khoa học dữ liệu', 'khoa-hoc-du-lieu', 'Nắm vững phân tích dữ liệu, thống kê, và visualization với Python, R, SQL, Power BI. Học cách khai thác insights từ dữ liệu lớn và đưa ra quyết định dựa trên số liệu.', 'categories/khoa-hoc-du-lieu.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10'),
(4, 'Trí tuệ nhân tạo', 'tri-tue-nhan-tao', 'Khám phá Machine Learning, Deep Learning, Computer Vision, NLP và LLM. Xây dựng mô hình AI thực tế với TensorFlow, PyTorch, scikit-learn và các framework hiện đại.', 'categories/tri-tue-nhan-tao.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10'),
(5, 'Phát triển web', 'phat-trien-web', 'Xây dựng website và ứng dụng web hoàn chỉnh với HTML, CSS, JavaScript, React, Laravel, Node.js. Từ frontend responsive đến backend mạnh mẽ, làm chủ full-stack development.', 'categories/phat-trien-web.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10'),
(6, 'Phát triển di động', 'phat-trien-di-dong', 'Tạo ứng dụng mobile đa nền tảng với React Native, Flutter, hoặc native iOS/Android. Học cách thiết kế UX mobile, tích hợp API và publish app lên App Store/Google Play.', 'categories/phat-trien-di-dong.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10'),
(7, 'Marketing số', 'marketing-so', 'Làm chủ Digital Marketing với SEO, SEM, Social Media Marketing, Email Marketing, Google Ads, Facebook Ads. Học cách tăng traffic, chuyển đổi khách hàng và đo lường hiệu quả chiến dịch.', 'categories/marketing-so.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10'),
(8, 'Kinh doanh', 'kinh-doanh', 'Phát triển kỹ năng quản lý, lãnh đạo, khởi nghiệp và chiến lược kinh doanh. Học cách lập kế hoạch, quản trị tài chính, marketing và vận hành doanh nghiệp hiệu quả.', 'categories/kinh-doanh.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10'),
(9, 'An ninh mạng', 'an-ninh-mang', 'Bảo vệ hệ thống và dữ liệu với kiến thức về Cybersecurity, Ethical Hacking, Network Security, Penetration Testing. Học cách phát hiện lỗ hổng, phòng chống tấn công và tuân thủ an toàn thông tin.', 'categories/an-ninh-mang.jpg', NULL, '2025-10-29 16:46:37', '2025-11-16 16:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `category_media`
--

CREATE TABLE `category_media` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'thumbnail',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_media`
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
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('percent','fixed') COLLATE utf8mb4_general_ci NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `max_uses` int UNSIGNED DEFAULT NULL,
  `uses` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `starts_at`, `ends_at`, `max_uses`, `uses`, `created_at`, `updated_at`) VALUES
(1, 'BLACKFRIDAY', 'percent', 40.00, '2025-11-12 02:42:00', '2025-11-28 02:42:00', 1, 1, '2025-11-11 19:42:25', '2025-11-22 15:07:01');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `instructor_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(260) COLLATE utf8mb4_general_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_general_ci,
  `description` longtext COLLATE utf8mb4_general_ci,
  `description_html` longtext COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `thumbnail_path` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('draft','published','hidden','archived') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `total_duration` int UNSIGNED NOT NULL DEFAULT '0',
  `level` enum('beginner','intermediate','advanced') COLLATE utf8mb4_general_ci DEFAULT 'beginner',
  `language` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Vietnamese',
  `enrolled_students` int DEFAULT '0',
  `rating` decimal(2,1) DEFAULT '0.0',
  `rating_count` int DEFAULT '0',
  `video_count` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `instructor_id`, `category_id`, `title`, `slug`, `short_description`, `description`, `description_html`, `price`, `compare_at_price`, `thumbnail_path`, `status`, `total_duration`, `level`, `language`, `enrolled_students`, `rating`, `rating_count`, `video_count`, `created_at`, `updated_at`) VALUES
(10, 1, 1, 'Laravel Cơ bản', 'laravel-co-ban', 'Khóa học Laravel dành cho người mới bắt đầu', 'Tìm hiểu cách xây dựng ứng dụng web bằng Laravel Framework. Bao gồm routing, controller, view, Eloquent ORM và Blade Template.', NULL, 500000.00, 900000.00, 'laravel-basic.jpg', 'published', 19, 'beginner', 'Vietnamese', 1200, 4.7, 86, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(11, 1, 1, 'PHP OOP nâng cao', 'php-oop-nang-cao', 'Làm chủ Lập trình Hướng đối tượng trong PHP', 'Khóa học giúp bạn hiểu sâu về OOP, SOLID, Dependency Injection, Design Patterns và thực hành với PHP 8.', NULL, 450000.00, 850000.00, 'php-oop.jpg', 'published', 15, 'intermediate', 'Vietnamese', 980, 4.5, 65, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(12, 1, 1, 'NodeJS từ cơ bản đến nâng cao', 'nodejs-co-ban-den-nang-cao', 'Xây dựng ứng dụng backend với NodeJS và Express', 'Khóa học hướng dẫn cách tạo RESTful API, xử lý JWT, upload file, và kết nối với MongoDB.', NULL, 600000.00, 1100000.00, 'nodejs-advanced.jpg', 'published', 22, 'intermediate', 'Vietnamese', 2100, 4.8, 124, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(13, 1, 1, 'ReactJS hiện đại', 'reactjs-hien-dai', 'Xây dựng ứng dụng Frontend với React Hooks & Router', 'Khóa học hướng dẫn cách sử dụng React Hooks, Context API, Redux Toolkit và tạo ứng dụng SPA hoàn chỉnh.', NULL, 550000.00, 990000.00, 'reactjs-modern.jpg', 'published', 20, 'intermediate', 'Vietnamese', 1801, 5.0, 1, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(14, 1, 1, 'Java Spring Boot Cơ bản', 'java-spring-boot-co-ban', 'Lập trình backend với Java Spring Boot', 'Khóa học giúp bạn làm chủ Spring Boot, JPA, REST API, và triển khai ứng dụng trên server thực tế.', NULL, 650000.00, 1200000.00, 'spring-boot.jpg', 'published', 26, 'intermediate', 'Vietnamese', 1500, 4.7, 78, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(15, 1, 1, 'Python Web với Django', 'python-django', 'Học Django Framework để tạo web nhanh chóng và mạnh mẽ', 'Khóa học giúp bạn hiểu rõ về MVT, ORM, Authentication, Form và triển khai ứng dụng Django thực tế.', NULL, 500000.00, 950000.00, 'django-web.jpg', 'published', 19, 'intermediate', 'Vietnamese', 1750, 4.8, 103, 0, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(16, 1, 1, 'C# .NET Core Web API', 'csharp-dotnetcore-api', 'Phát triển ứng dụng API mạnh mẽ với .NET Core', 'Khóa học giúp bạn làm chủ C#, Entity Framework Core, Identity, Authentication và API Documentation (Swagger).', NULL, 700000.00, 1300000.00, 'dotnet-core.jpg', 'published', 24, 'intermediate', 'Vietnamese', 950, 4.5, 52, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(17, 1, 1, 'Fullstack MERN Project', 'fullstack-mern-project', 'Dự án thực tế Fullstack với MongoDB, Express, React, Node', 'Khóa học giúp bạn tự tay xây dựng ứng dụng thực tế, kết nối frontend – backend – database, deploy lên server.', NULL, 800000.00, 1500000.00, 'mern-project.jpg', 'published', 30, 'advanced', 'Vietnamese', 2100, 4.9, 128, 4, '2025-10-29 18:46:13', '2025-11-22 12:20:40'),
(19, NULL, 2, 'Nền tảng Thiết kế đồ hoạ với Canva', 'canva-thiet-ke-do-hoa', 'Bắt đầu với Canva: bố cục, phông chữ, màu sắc, template.', '<p>Khoá học giúp bạn làm chủ Canva từ con số 0, tạo banner, poster, social post chuyên nghiệp.</p>', NULL, 399000.00, 790000.00, 'canva-basics.jpg', 'published', 10, 'beginner', 'Vietnamese', 1200, 4.6, 320, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(20, NULL, 2, 'Figma UI/UX từ cơ bản đến prototype', 'figma-ui-ux-prototype', 'Thiết kế giao diện, auto layout, component, prototype trong Figma.', '<p>Làm chủ Figma với workflow thực chiến: grid, component, variants, prototype & handoff.</p>', NULL, 549000.00, 990000.00, 'figma-uiux.jpg', 'published', 18, 'beginner', 'Vietnamese', 2100, 4.7, 540, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(21, NULL, 2, 'Adobe Illustrator Chuyên sâu', 'adobe-illustrator-chuyen-sau', 'Vector, pen tool, logo, icon, bộ nhận diện thương hiệu.', '<p>Đi sâu kỹ thuật vector: pathfinder, blend, pattern, gradient mesh, appearance…</p>', NULL, 589000.00, 1090000.00, 'ai-illustrator.jpg', 'published', 22, 'intermediate', 'Vietnamese', 1600, 4.5, 410, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(22, NULL, 2, 'Photoshop Thực chiến Retouch & Social', 'photoshop-retouch-social', 'Retouch chân dung, blend màu, thiết kế social banner.', '<p>Thực hành retouch chuyên nghiệp, action, LUT, smart object & workflow social.</p>', NULL, 519000.00, 990000.00, 'photoshop-retouch.jpg', 'published', 16, 'intermediate', 'Vietnamese', 1350, 4.6, 360, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(23, NULL, 3, 'Python cho Phân tích dữ liệu', 'python-phan-tich-du-lieu', 'Numpy, Pandas, Matplotlib, làm sạch & trực quan hoá dữ liệu.', '<p>Pipeline xử lý dữ liệu thực tế: EDA, thống kê mô tả, vẽ biểu đồ & report.</p>', NULL, 599000.00, 1190000.00, 'python-data-analysis.jpg', 'published', 20, 'beginner', 'Vietnamese', 3200, 4.7, 890, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(24, NULL, 3, 'SQL từ cơ bản đến nâng cao', 'sql-tu-co-ban-den-nang-cao', 'Truy vấn dữ liệu, join, window function, tối ưu & bài tập thực tế.', '<p>Luyện SQL trên MySQL/PostgreSQL với hàng chục case: sales, e-commerce, marketing.</p>', NULL, 449000.00, 890000.00, 'sql-advanced.jpg', 'published', 14, 'beginner', 'Vietnamese', 4101, 4.6, 1100, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(25, NULL, 3, 'Machine Learning cơ bản với Scikit-learn', 'machine-learning-scikit-learn', 'Linear/Logistic Regression, Tree, SVM, model metrics & tuning.', '<p>Xây dựng mô hình ML đầu tay, đánh giá & cải thiện bằng cross-validation, grid search.</p>', NULL, 649000.00, 1290000.00, 'ml-scikit.jpg', 'published', 24, 'intermediate', 'Vietnamese', 2600, 4.6, 670, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(26, NULL, 3, 'Power BI: Dashboard & DAX thực chiến', 'power-bi-dashboard-dax', 'Kết nối dữ liệu, làm sạch, DAX, dashboard theo KPI.', '<p>Làm báo cáo động theo KPI Sales/Finance, chia sẻ & publish lên Power BI Service.</p>', NULL, 579000.00, 1090000.00, 'powerbi.jpg', 'published', 18, 'intermediate', 'Vietnamese', 2200, 4.7, 590, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(27, NULL, 4, 'Deep Learning cơ bản với Keras', 'deep-learning-keras', 'ANN, CNN, RNN, overfitting, augmentation, callback.', '<p>Xây dựng mạng nơ-ron cho ảnh & chuỗi, thực hành trên TensorFlow/Keras.</p>', NULL, 689000.00, 1390000.00, 'dl-keras.jpg', 'published', 22, 'intermediate', 'Vietnamese', 1800, 4.6, 520, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(28, NULL, 4, 'Xử lý ngôn ngữ tự nhiên (NLP) cơ bản', 'nlp-co-ban', 'Tiền xử lý văn bản, TF-IDF, Word2Vec, phân loại & sentiment.', '<p>Pipeline NLP end-to-end, đánh giá & triển khai mô hình phân loại văn bản.</p>', NULL, 629000.00, 1190000.00, 'nlp-basics.jpg', 'published', 16, 'intermediate', 'Vietnamese', 1500, 4.5, 410, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(29, NULL, 4, 'Computer Vision với OpenCV', 'computer-vision-opencv', 'Tiền xử lý ảnh, phát hiện đối tượng, contour, tracking.', '<p>Thực hành OpenCV + Python cho các bài toán thị giác máy tính nền tảng.</p>', NULL, 569000.00, 1090000.00, 'opencv.jpg', 'published', 14, 'intermediate', 'Vietnamese', 1400, 4.5, 380, 4, '2025-10-30 00:16:19', '2025-11-22 12:20:40'),
(30, NULL, 4, 'LLM & Prompt Engineering thực hành', 'llm-prompt-engineering', 'Hiểu LLM, token, prompt pattern, RAG cơ bản.', 'Thực hành prompt hiệu quả & tích hợp LLM vào ứng dụng bằng API.ádddddddd', '<p>Khóa học “LLM &amp; Prompt Engineering Thực Hành” được thiết kế dành cho những ai muốn khai thác tối đa sức mạnh của các mô hình ngôn ngữ lớn (Large Language Models – LLMs) như GPT, Claude, Gemini, hay Mistral. Học viên không chỉ được trang bị nền tảng lý thuyết vững chắc về cách LLM hoạt động, mà còn trực tiếp <strong>thực hành xây dựng, tối ưu và triển khai prompt</strong> trong các tình huống thực tế như tạo nội dung, xử lý dữ liệu, lập trình, hay phân tích ngữ nghĩa.</p><p>Khóa học tập trung vào <strong>tư duy kỹ sư prompt (Prompt Engineering Mindset)</strong> — hiểu cách mô hình “nghĩ”, học cách đặt câu hỏi thông minh, kiểm thử và tinh chỉnh để đạt kết quả tốt nhất. Học viên cũng được hướng dẫn cách sử dụng các công cụ và framework hiện đại như LangChain, OpenAI API, hay LlamaIndex để <strong>xây dựng ứng dụng AI end-to-end</strong>.</p><p><strong>Bạn sẽ học được:</strong></p><ul><li>Nguyên lý hoạt động của các mô hình LLM hiện đại.</li><li>Kỹ thuật thiết kế prompt hiệu quả: từ zero-shot, few-shot đến chain-of-thought.</li><li>Thực hành với các bài tập mô phỏng dự án thực tế.</li><li>Cách kết hợp LLM với dữ liệu riêng (Retrieval-Augmented Generation - RAG).</li><li>Triển khai ứng dụng AI với Python và API thực tế.</li></ul><p><strong>Đối tượng học viên:</strong></p><ul><li>Lập trình viên, nhà phân tích dữ liệu, marketer, chuyên viên nội dung, hoặc bất kỳ ai muốn ứng dụng AI vào công việc.</li><li>Không yêu cầu nền tảng học thuật phức tạp — chỉ cần tư duy logic và tinh thần học hỏi.</li></ul><p><strong>Kết quả đạt được:</strong><br>Sau khóa học, bạn sẽ có khả năng <strong>hiểu – thiết kế – triển khai</strong> prompt và ứng dụng AI tùy chỉnh, giúp tăng tốc hiệu suất làm việc, sáng tạo và ra quyết định.</p>', 699000.00, 1490000.00, 'llm-prompt.jpg', 'published', 8237, 'intermediate', 'Vietnamese', 901, 0.0, 0, 5, '2025-10-30 00:16:20', '2025-11-22 12:20:40'),
(31, NULL, 5, 'HTML/CSS/JS Cơ bản qua dự án', 'html-css-js-co-ban', 'Xây dựng landing page responsive từ A → Z.', '<p>Nắm vững cấu trúc HTML, Flex/Grid, DOM & best-practices responsive.</p>', NULL, 379000.00, 790000.00, 'html-css-js.jpg', 'published', 776, 'beginner', 'Vietnamese', 4804, 4.7, 1400, 6, '2025-10-30 00:16:20', '2025-11-22 12:20:40'),
(32, NULL, 5, 'ReactJS từ cơ bản đến nâng cao', 'reactjs-tu-co-ban-den-nang-cao', 'Component, hook, router, state management, tối ưu hiệu năng.', '<p>Xây SPA hoàn chỉnh, tách module & tối ưu hoá production build.</p>', '<h2>Requirements</h2><ul><li>Có tư duy lập trình</li><li>Có hiểu biết về lập trình webiste là một lợi thế</li><li>Có kiến thức về HTML, CSS, Javascript cơ bản là một lợi thế</li></ul><h2>Description</h2><p><strong>1. Công nghệ sử dụng</strong></p><p>React version 18 &amp; 19</p><p>React là thư viện với cơ chế CSR - client side rendering</p><p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Các kiến thức trọng tâm:</strong></p><ul><li>Phân biệt các phong cách code/sử dụng React trong thực tế</li><li><p>Học React với đúng tư duy ban đầu của React - React là library UI</p><p>&nbsp;</p><p><strong>Các kiến thức về React (cốt lõi nhất):</strong></p></li><li>Tư duy thiết kế UI với React (sử dụng Component)</li><li>Render/Re-render giao diện với Props và State (useState hook)</li><li>Điều hướng trang với React-router-dom</li><li>Sử dụng useEffect để gọi API backend</li><li>Sử dụng Context API để sharing data giữa các component</li><li>Sử dụng mô hình Stateless (với access_token)</li><li>Sử dụng Ant Design (antd) để làm giao diện chuyên nghiệp (UI - UX)</li><li>Tối ưu hóa re-render với Uncontrolled Component</li></ul><p>&nbsp;</p><p><strong>Backend (Nestjs)</strong> được mình cung cấp sẵn. Chỉ sử dụng và không sửa đổi. (<strong>không học code backend trong khóa học này</strong>).</p><p><strong>Database MongoDB</strong> sử dụng online (miễn phí) với MongoDB Atlas</p><p>&nbsp;</p><p><strong>2. Học viên nào có thể học ?</strong></p><p>Học viên cần trang bị các kiến thức sau trước khi theo học: <strong>HTML, CSS và cú pháp của Javascript</strong></p><p>&nbsp;</p><p><strong>3. Triển khai dự án</strong></p><p>Đến cuối khóa học, dự án được triển khai:</p><ul><li>Frontend triển khai với Vercel</li><li>Backend triển khai với Render</li><li>Database triển khai với MongoDB Atlas</li></ul>', 649000.00, 1290000.00, 'reactjs.jpg', 'published', 617, 'intermediate', 'Vietnamese', 5201, 4.7, 1600, 4, '2025-10-30 00:16:20', '2025-11-22 12:20:40'),
(33, NULL, 5, 'NodeJS & Express APIs thực chiến', 'nodejs-express-api-thuc-chien', 'RESTful API, auth (JWT), middleware, upload, logging.', '<p>Xây dựng API chuẩn production: cấu trúc, test, bảo mật & deploy.</p>', NULL, 629000.00, 1190000.00, 'node-express.jpg', 'published', 20, 'intermediate', 'Vietnamese', 3900, 4.6, 980, 4, '2025-10-30 00:16:20', '2025-11-22 12:20:40'),
(34, NULL, 5, 'Laravel Cơ bản đến CRUD & Auth', 'laravel-co-ban-crud-auth', 'Routing, Blade, Eloquent, migration, CRUD, auth, middleware.', '<p>Hoàn thiện mini-project chuẩn MVC & thực hành best-practice Laravel.</p>', NULL, 599000.00, 1190000.00, 'laravel-crud-auth.jpg', 'published', 18, 'beginner', 'Vietnamese', 4500, 4.7, 1200, 4, '2025-10-30 00:16:20', '2025-11-22 12:20:40'),
(35, 3, NULL, 'Lập trình C++ cơ bản, nâng cao', 'C++_co_ban', NULL, NULL, NULL, 0.00, NULL, 'lap-trinh-c-co-ban-nang-cao-1763317230.png', 'published', 10438, 'beginner', 'Vietnamese', 5, 5.0, 1, 19, '2025-11-16 06:08:08', '2025-11-21 17:20:34'),
(36, NULL, 6, 'React Native cơ bản đến ứng dụng thực tế', 'react-native-co-ban', 'Xây dựng ứng dụng di động đa nền tảng với React Native từ A-Z.', '<p>Học cách phát triển ứng dụng mobile cho iOS và Android chỉ với một mã nguồn. Khóa học bao gồm: Component, Navigation, API integration, Authentication, và publish app lên stores.</p>', NULL, 649000.00, 1290000.00, 'react-native-co-ban-den-ung-dung-thuc-te-1763315966.png', 'published', 25, 'intermediate', 'Vietnamese', 1850, 4.6, 420, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(37, NULL, 6, 'Flutter & Dart - Xây dựng App đa nền tảng', 'flutter-dart-app', 'Tạo ứng dụng mobile đẹp mắt với Flutter framework từ Google.', '<p>Làm chủ Flutter và Dart để xây dựng ứng dụng native performance. Học Material Design, State Management (Provider, Bloc), Firebase integration, và best practices.</p>', NULL, 699000.00, 1390000.00, 'flutter-dart-xay-dung-app-da-nen-tang-1763315996.jpg', 'published', 28, 'intermediate', 'Vietnamese', 2100, 4.7, 580, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(38, NULL, 6, 'iOS Development với Swift & SwiftUI', 'ios-swift-swiftui', 'Phát triển ứng dụng iOS hiện đại với Swift và SwiftUI.', '<p>Xây dựng ứng dụng iPhone/iPad từ đầu. Học Swift programming, SwiftUI declarative syntax, CoreData, networking, và publish lên App Store.</p>', NULL, 749000.00, 1490000.00, 'ios-development-voi-swift-swiftui-1763316204.png', 'published', 32, 'intermediate', 'Vietnamese', 1420, 4.5, 310, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(39, NULL, 6, 'Android Development với Kotlin', 'android-kotlin', 'Tạo ứng dụng Android với Kotlin và Jetpack Compose.', '<p>Học lập trình Android hiện đại với Kotlin. Khóa học bao gồm: Activity/Fragment, MVVM, Room Database, Retrofit, Jetpack Compose, và testing.</p>', NULL, 699000.00, 1390000.00, 'android-development-voi-kotlin-1763316095.png', 'published', 30, 'intermediate', 'Vietnamese', 1680, 4.6, 380, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(40, NULL, 7, 'SEO từ cơ bản đến chuyên sâu', 'seo-co-ban-chuyen-sau', 'Tối ưu website lên TOP Google với kỹ thuật SEO hiện đại.', '<p>Làm chủ SEO onpage/offpage, keyword research, technical SEO, link building, Google Analytics/Search Console. Học cách tăng traffic tự nhiên và ranking bền vững.</p>', NULL, 549000.00, 1090000.00, 'seo-tu-co-ban-den-chuyen-sau-1763316049.jpg', 'published', 22, 'beginner', 'Vietnamese', 3201, 4.7, 890, 4, '2025-11-16 16:41:03', '2025-11-23 07:48:59'),
(41, NULL, 7, 'Facebook Ads & Google Ads thực chiến', 'facebook-google-ads', 'Chạy quảng cáo hiệu quả trên Facebook và Google.', '<p>Tạo và tối ưu chiến dịch quảng cáo trên Facebook Ads Manager và Google Ads. Học targeting, bidding, conversion tracking, A/B testing, và tối ưu ROI.</p>', NULL, 599000.00, 1190000.00, 'facebook-ads-google-ads-thuc-chien-1763315756.png', 'published', 26, 'intermediate', 'Vietnamese', 2850, 4.6, 720, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(42, NULL, 7, 'Content Marketing & Copywriting', 'content-marketing-copywriting', 'Viết content thu hút và chuyển đổi khách hàng hiệu quả.', '<p>Học cách viết content marketing, blog SEO, email marketing, landing page copy. Nắm vững storytelling, AIDA, hook, CTA và chiến lược nội dung toàn diện.</p>', NULL, 499000.00, 990000.00, 'content-marketing-copywriting-1763315705.jpg', 'published', 18, 'beginner', 'Vietnamese', 2450, 4.5, 610, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(43, NULL, 7, 'Social Media Marketing toàn diện', 'social-media-marketing', 'Xây dựng và phát triển thương hiệu trên mạng xã hội.', '<p>Chiến lược marketing trên Facebook, Instagram, TikTok, LinkedIn. Học content planning, engagement, influencer marketing, analytics, và community management.</p>', NULL, 579000.00, 1090000.00, 'social-media-marketing-toan-dien-1763315668.png', 'published', 24, 'intermediate', 'Vietnamese', 3100, 4.6, 780, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(44, NULL, 8, 'Khởi nghiệp từ ý tưởng đến thực thi', 'khoi-nghiep-startup', 'Xây dựng startup thành công từ zero với roadmap chi tiết.', '<p>Học cách validate ý tưởng, xây dựng MVP, tìm kiếm funding, pitching, scaling. Bao gồm Lean Startup, Business Model Canvas, và case study thực tế.</p>', NULL, 649000.00, 1290000.00, 'khoi-nghiep-tu-y-tuong-den-thuc-thi-1763315618.jpg', 'published', 28, 'intermediate', 'Vietnamese', 1950, 4.7, 480, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(45, NULL, 8, 'Quản trị và Lãnh đạo hiệu quả', 'quan-tri-lanh-dao', 'Phát triển kỹ năng quản lý đội nhóm và lãnh đạo tổ chức.', '<p>Nắm vững các kỹ năng quản lý: team building, delegation, motivation, conflict resolution, performance management, và strategic thinking.</p>', NULL, 599000.00, 1190000.00, 'quan-tri-va-lanh-dao-hieu-qua-1763315517.jpg', 'published', 0, 'intermediate', 'Vietnamese', 2301, 4.6, 560, 3, '2025-11-16 16:41:03', '2025-11-23 08:20:33'),
(46, NULL, 8, 'Tài chính doanh nghiệp cơ bản', 'tai-chinh-doanh-nghiep', 'Hiểu và quản lý tài chính cho doanh nghiệp vừa và nhỏ.', '<p>Học đọc báo cáo tài chính, cash flow management, budgeting, financial planning, ROI analysis, và các chỉ số tài chính quan trọng.</p>', NULL, 549000.00, 1090000.00, 'tai-chinh-doanh-nghiep-co-ban-1763316264.jpg', 'published', 0, 'beginner', 'Vietnamese', 1781, 4.5, 410, 4, '2025-11-16 16:41:03', '2025-11-22 12:22:01'),
(47, NULL, 8, 'Chiến lược kinh doanh và Marketing', 'chien-luoc-kinh-doanh', 'Xây dựng chiến lược phát triển doanh nghiệp bền vững.', '<p>Phát triển business strategy, competitive analysis, market positioning, growth hacking, customer acquisition, và sustainable business model.</p>', NULL, 629000.00, 1190000.00, 'chien-luoc-kinh-doanh-va-marketing-1763316299.jpg', 'published', 25, 'intermediate', 'Vietnamese', 2151, 4.7, 520, 4, '2025-11-16 16:41:03', '2025-11-22 14:57:40'),
(48, NULL, 9, 'Ethical Hacking cơ bản', 'ethical-hacking-co-ban', 'Học penetration testing và bảo mật hệ thống từ đầu.', '<p>Nắm vững các kỹ thuật hacking đạo đức: reconnaissance, scanning, exploitation, post-exploitation. Thực hành trên lab với Kali Linux, Metasploit, Burp Suite.</p>', NULL, 749000.00, 1490000.00, 'ethical-hacking-co-ban-1763316331.jpg', 'published', 32, 'intermediate', 'Vietnamese', 1620, 4.8, 420, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(49, NULL, 9, 'Network Security & Firewall', 'network-security-firewall', 'Bảo vệ hệ thống mạng với firewall và các công cụ security.', '<p>Học cách bảo mật network: firewall configuration, VPN, IDS/IPS, network monitoring, packet analysis với Wireshark, và incident response.</p>', NULL, 699000.00, 1390000.00, 'network-security-firewall-1763316386.webp', 'published', 28, 'intermediate', 'Vietnamese', 1480, 4.6, 360, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(50, NULL, 9, 'Web Application Security', 'web-app-security', 'Bảo mật ứng dụng web - tìm và vá lỗ hổng OWASP Top 10.', '<p>Phát hiện và khắc phục các lỗ hổng web: SQL Injection, XSS, CSRF, authentication bypass. Học secure coding practices và web security testing.</p>', NULL, 649000.00, 1290000.00, 'web-application-security-1763316413.webp', 'published', 26, 'intermediate', 'Vietnamese', 1850, 4.7, 460, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40'),
(51, NULL, 9, 'Cryptography & Blockchain Security', 'cryptography-blockchain', 'Mật mã học và bảo mật blockchain cho developer.', '<p>Hiểu về encryption, hashing, digital signatures, PKI, SSL/TLS. Tìm hiểu blockchain security, smart contract auditing, và crypto best practices.</p>', NULL, 699000.00, 1390000.00, 'cryptography-blockchain-security-1763315926.jpg', 'published', 24, 'advanced', 'Vietnamese', 1320, 4.5, 290, 4, '2025-11-16 16:41:03', '2025-11-22 12:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `status` enum('active','revoked') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `enrolled_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `status`, `enrolled_at`, `created_at`, `updated_at`) VALUES
(2, 1, 31, 'active', '2025-11-11 19:30:40', '2025-11-11 19:30:40', '2025-11-11 19:30:40'),
(3, 1, 24, 'active', '2025-11-11 19:43:22', '2025-11-11 19:43:22', '2025-11-11 19:43:22'),
(6, 5, 31, 'active', '2025-11-12 17:58:24', '2025-11-12 17:58:24', '2025-11-12 17:58:24'),
(8, 3, 31, 'active', '2025-11-15 18:19:40', '2025-11-15 18:19:40', '2025-11-15 18:19:40'),
(9, 1, 35, 'active', '2025-11-16 07:40:16', '2025-11-16 07:40:16', '2025-11-16 07:40:16'),
(11, 5, 35, 'active', '2025-11-16 15:41:34', '2025-11-16 15:41:34', '2025-11-16 15:41:34'),
(12, 6, 35, 'active', '2025-11-21 12:09:54', '2025-11-21 12:09:54', '2025-11-21 12:09:54'),
(13, 7, 35, 'active', '2025-11-21 17:20:34', '2025-11-21 17:20:34', '2025-11-21 17:20:34'),
(14, 6, 46, 'active', '2025-11-22 09:02:13', '2025-11-22 09:02:13', '2025-11-22 09:02:13'),
(15, 6, 47, 'active', '2025-11-22 14:57:40', '2025-11-22 14:57:40', '2025-11-22 14:57:40'),
(16, 6, 45, 'active', '2025-11-22 15:07:01', '2025-11-22 15:07:01', '2025-11-22 15:07:01'),
(17, 6, 40, 'active', '2025-11-23 07:48:59', '2025-11-23 07:48:59', '2025-11-23 07:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `video_path` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hls_path` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cloudinary_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attachment_path` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `is_preview` tinyint(1) NOT NULL DEFAULT '0',
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `section_id`, `title`, `video_path`, `hls_path`, `cloudinary_id`, `video_url`, `attachment_path`, `duration`, `is_preview`, `position`, `created_at`, `updated_at`) VALUES
(2, 2, 'Bài học vỡ lòng', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=Hc5edo4R5Oc&list=RDHc5edo4R5Oc&start_radio=1', 'attachments/lessons/5MLB77ReeyPUsznjgEp10eNwa4qVWi73IBy4nElR.pdf', 312, 1, 3, '2025-11-11 19:30:07', '2025-11-15 04:01:16'),
(4, 2, 'mikasa', 'videos/lessons/FgTXR7FJOKytyRnROjSDy6qXGYlG8yDMbeuU6YHm.mp4', NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-12 17:44:23', '2025-11-12 17:44:23'),
(5, 2, 'ẻ3f', NULL, NULL, 'videos/lessons/syzbozme9wg0u4wjvnm1', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/sp_hd/videos/lessons/syzbozme9wg0u4wjvnm1.m3u8', NULL, 22, 0, 4, '2025-11-12 17:57:22', '2025-11-15 19:45:58'),
(6, 5, 'try', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=Sk5r_SxGeS0', NULL, 0, 0, 2, '2025-11-12 18:11:51', '2025-11-12 18:12:34'),
(7, 5, 'acx', NULL, NULL, 'videos/lessons/jnfwtbdabgls8dn1ghg2', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763271776/videos/lessons/jnfwtbdabgls8dn1ghg2.mp4', NULL, 442, 0, 1, '2025-11-12 18:12:21', '2025-11-16 05:43:03'),
(8, 6, 'Prompt AI: Hướng Dẫn Viết Prompt Hiệu Quả - Kinh nghiệm đúc kết gần 1000 giờ dùng AI', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=RiPLeXEwIXE&list=PLyCvV8IiFZXGA0D0dFtVrDJSpguOaxbTM&index=1', NULL, 2636, 0, 1, '2025-11-12 18:25:59', '2025-11-16 13:41:54'),
(9, 6, 'AI Model là gì? 5 Điều bạn cần biết để tạo PROMPT AI HIỆU QUẢ HƠN', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=8i4HE0dMSXU&list=PLyCvV8IiFZXGA0D0dFtVrDJSpguOaxbTM&index=2', NULL, 896, 0, 2, '2025-11-12 18:26:30', '2025-11-16 13:41:55'),
(10, 6, '5 Bí kíp Prompt giúp Prompt AI trở nên vượt trội', NULL, NULL, NULL, 'https://drive.google.com/file/d/12-DQz06q516o1REMmuLw-l3qQ0BAkdD6/view', NULL, 23, 0, 3, '2025-11-12 18:27:08', '2025-11-12 18:46:39'),
(11, 6, 'Custom Prompt: Cách x2 thu nhập & tối ưu 30% chi phí với AI', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=XobgVozuf3I&list=PLyCvV8IiFZXGA0D0dFtVrDJSpguOaxbTM&index=4', NULL, 2892, 0, 4, '2025-11-12 18:27:39', '2025-11-16 13:41:55'),
(12, 7, '7 Bí Kíp Sử Dụng ChatGPT Cực Xịn mà 90% Người Dùng Không Biết!', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=clJJXlBzYhk&list=PLyCvV8IiFZXGA0D0dFtVrDJSpguOaxbTM&index=5', NULL, 1790, 0, 1, '2025-11-12 18:29:07', '2025-11-16 13:41:55'),
(13, 3, 'fsgfdg', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=Hc5edo4R5Oc&list=RDHc5edo4R5Oc&start_radio=1', NULL, 312, 0, 1, '2025-11-15 04:03:40', '2025-11-15 04:03:40'),
(14, 3, 'dfgdfg', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=OuNo8Tkb3lI&list=RDHc5edo4R5Oc&index=2', NULL, 266, 0, 2, '2025-11-15 04:03:59', '2025-11-16 13:41:55'),
(15, 3, 'ụad', 'videos/lessons/TtdTcu36SNQmHx3ScgBjHKxeU2GOsHKLGrhPIuFi.mp4', NULL, NULL, NULL, NULL, 22, 0, 3, '2025-11-15 04:07:52', '2025-11-15 15:08:00'),
(16, 3, 'aggh', 'videos/lessons/0CHh823Cx2TP37Sl0J3GEI8mTLCSLa2njIuU2XWM.mp4', NULL, NULL, NULL, NULL, 17, 0, 4, '2025-11-15 04:08:18', '2025-11-15 15:06:39'),
(17, 10, 'Giới thiệu khóa học', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/ztxkobdzohk6k926onqt', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763273445/videos/Lap_trinh_C_co_ban_nang_cao/ztxkobdzohk6k926onqt.mp4', NULL, 62, 0, 1, '2025-11-16 06:11:18', '2025-11-16 06:11:18'),
(18, 10, 'Cài đặt Dev C++', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/ed5cm5e5kbh7nhqzjyz1', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763273540/videos/Lap_trinh_C_co_ban_nang_cao/ed5cm5e5kbh7nhqzjyz1.mp4', NULL, 151, 0, 2, '2025-11-16 06:13:39', '2025-11-16 06:13:39'),
(19, 10, 'Hướng dẫn sử dụng Dev C++', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/os2rbwgmfhca2t4sax2r', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763273721/videos/Lap_trinh_C_co_ban_nang_cao/os2rbwgmfhca2t4sax2r.mp4', NULL, 213, 0, 3, '2025-11-16 06:16:41', '2025-11-16 06:16:41'),
(20, 11, 'Biến và nhập xuất dữ liệu', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/hdsxgeqjr05qcij8hc72', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763273947/videos/Lap_trinh_C_co_ban_nang_cao/hdsxgeqjr05qcij8hc72.mp4', NULL, 454, 0, 1, '2025-11-16 06:21:03', '2025-11-16 06:21:03'),
(21, 11, 'Kiểu dữ liệu thường gặp', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/ww6f3b49qg4ruplivabq', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763274123/videos/Lap_trinh_C_co_ban_nang_cao/ww6f3b49qg4ruplivabq.mp4', NULL, 343, 0, 2, '2025-11-16 06:23:31', '2025-11-16 06:32:20'),
(22, 11, 'Biến cục bộ và biến toàn cục', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/ggwx101uys5qkwhip4dt', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763274786/videos/Lap_trinh_C_co_ban_nang_cao/ggwx101uys5qkwhip4dt.mp4', NULL, 401, 0, 3, '2025-11-16 06:35:28', '2025-11-16 06:35:28'),
(23, 11, 'Hằng số', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/eyurxgbf0oe4cqcegmzb', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763275005/videos/Lap_trinh_C_co_ban_nang_cao/eyurxgbf0oe4cqcegmzb.mp4', NULL, 217, 0, 4, '2025-11-16 06:38:12', '2025-11-16 06:38:12'),
(24, 11, 'Toán tử gán và toán tử số học', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/sinblqafjvipyrxk46jc', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763275144/videos/Lap_trinh_C_co_ban_nang_cao/sinblqafjvipyrxk46jc.mp4', NULL, 653, 0, 5, '2025-11-16 06:42:45', '2025-11-16 06:42:45'),
(25, 11, 'Toán tử quan hệ và toán tử logic', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/fstnhzwuy5jrhldqbokd', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763275442/videos/Lap_trinh_C_co_ban_nang_cao/fstnhzwuy5jrhldqbokd.mp4', NULL, 746, 0, 6, '2025-11-16 06:47:49', '2025-11-16 06:47:49'),
(26, 11, 'Ép kiểu dữ liệu và bảng mã ASCII', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/qdq9uvo6zh7johhjilga', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763275728/videos/Lap_trinh_C_co_ban_nang_cao/qdq9uvo6zh7johhjilga.mp4', NULL, 532, 0, 7, '2025-11-16 06:52:19', '2025-11-16 06:52:19'),
(27, 11, 'Thực hành làm bài tập chương 02', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/nnbcbxywi8iyuz7htoip', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763276035/videos/Lap_trinh_C_co_ban_nang_cao/nnbcbxywi8iyuz7htoip.mp4', NULL, 931, 0, 8, '2025-11-16 06:54:01', '2025-11-16 06:54:01'),
(28, 12, 'Cấu trúc if else', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/tfuqe190vd2cbdwqm5mv', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763276106/videos/Lap_trinh_C_co_ban_nang_cao/tfuqe190vd2cbdwqm5mv.mp4', NULL, 562, 0, 1, '2025-11-16 06:57:39', '2025-11-16 06:57:39'),
(29, 12, 'Cấu trúc switch case', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/eqakkw18fqumgkcl6oru', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763276310/videos/Lap_trinh_C_co_ban_nang_cao/eqakkw18fqumgkcl6oru.mp4', NULL, 672, 0, 2, '2025-11-16 07:03:38', '2025-11-16 07:03:38'),
(30, 12, 'Toán tử 3 ngôi trong C++', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/gf4cr6blggsarmisw3xo', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763276928/videos/Lap_trinh_C_co_ban_nang_cao/gf4cr6blggsarmisw3xo.mp4', NULL, 332, 0, 3, '2025-11-16 07:10:17', '2025-11-16 07:10:17'),
(31, 12, 'Vòng lặp trong C++', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/rdveeemuetnyyosjtxae', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763277065/videos/Lap_trinh_C_co_ban_nang_cao/rdveeemuetnyyosjtxae.mp4', NULL, 767, 0, 4, '2025-11-16 07:15:37', '2025-11-16 07:15:37'),
(32, 13, 'Mảng một chiều', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/ufxlbfqeerblsol0rnir', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763277439/videos/Lap_trinh_C_co_ban_nang_cao/ufxlbfqeerblsol0rnir.mp4', NULL, 560, 0, 1, '2025-11-16 07:21:02', '2025-11-16 07:21:02'),
(33, 13, 'Thực hành sử dụng mảng', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/j2lmjept88mvte1xiyba', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763277800/videos/Lap_trinh_C_co_ban_nang_cao/j2lmjept88mvte1xiyba.mp4', NULL, 1131, 0, 2, '2025-11-16 07:23:25', '2025-11-16 07:23:25'),
(34, 14, 'Hàm trong C++', NULL, NULL, 'videos/Lap_trinh_C_co_ban_nang_cao/p8jxxrjpwwbb2yimjrzt', 'https://res.cloudinary.com/dpwjfxi8i/video/upload/v1763277979/videos/Lap_trinh_C_co_ban_nang_cao/p8jxxrjpwwbb2yimjrzt.mp4', NULL, 1072, 0, 1, '2025-11-16 07:26:24', '2025-11-16 07:26:24'),
(35, 15, 'Review THE CONJURING 4: PHIM KINH DỊ nhưng KHÔNG ĐÁNG SỢ?', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=8Pqg0IGN02g', NULL, 639, 0, 1, '2025-11-16 13:02:55', '2025-11-16 13:41:55'),
(36, 9, 'ád', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:44:26', '2025-11-16 18:44:26'),
(37, 16, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(38, 16, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(39, 17, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(40, 17, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(41, 18, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(42, 18, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(43, 19, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(44, 19, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(45, 20, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(46, 20, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(47, 21, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(48, 21, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(49, 22, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(50, 22, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(51, 23, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(52, 23, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(53, 24, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(54, 24, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(55, 25, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(56, 25, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(57, 26, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(58, 26, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(59, 27, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(60, 27, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(61, 28, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(62, 28, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(63, 29, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(64, 29, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(65, 30, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(66, 30, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(67, 31, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(68, 31, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(69, 32, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(70, 32, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(71, 33, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(72, 33, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(73, 34, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(74, 34, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(75, 35, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(76, 35, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(77, 36, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(78, 36, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(79, 37, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(80, 37, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(81, 38, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(82, 38, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(83, 39, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(84, 39, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(85, 40, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(86, 40, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(87, 41, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(88, 41, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(89, 42, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(90, 42, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(91, 43, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(92, 43, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(93, 44, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(94, 44, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(95, 45, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(96, 45, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(97, 46, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(98, 46, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(99, 47, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(100, 47, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(101, 48, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(102, 48, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(103, 49, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(104, 49, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(105, 50, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(106, 50, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(107, 51, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(108, 51, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(109, 52, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(110, 52, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(111, 53, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(112, 53, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(113, 54, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(114, 54, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(115, 55, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(116, 55, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(117, 56, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(118, 56, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(119, 57, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(120, 57, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(121, 58, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(122, 58, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(123, 59, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(124, 59, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(125, 60, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(126, 60, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(127, 61, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(128, 61, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(129, 62, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(130, 62, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(131, 63, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(132, 63, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(133, 64, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(134, 64, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(135, 65, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(136, 65, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(137, 66, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(138, 66, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(139, 67, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(140, 67, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(141, 68, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(142, 68, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(143, 69, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(144, 69, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(145, 70, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(146, 70, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(147, 71, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(148, 71, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(149, 72, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(150, 72, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(151, 73, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(152, 73, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(153, 74, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(157, 76, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(158, 76, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(159, 77, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(160, 77, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(161, 78, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(162, 78, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(163, 79, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(164, 79, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(165, 80, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(166, 80, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(167, 81, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(168, 81, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(169, 82, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(170, 82, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(171, 83, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(172, 83, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(173, 84, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(174, 84, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(175, 85, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(176, 85, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(177, 86, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(178, 86, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(179, 87, 'Bài học 1', NULL, NULL, NULL, NULL, NULL, 0, 0, 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(180, 87, 'Bài học 2', NULL, NULL, NULL, NULL, NULL, 0, 0, 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `is_completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '2025-11-11 19:38:48', '2025-11-11 19:38:48', '2025-11-11 19:38:48'),
(2, 5, 4, 1, '2025-11-12 17:59:16', '2025-11-12 17:59:16', '2025-11-12 17:59:16'),
(3, 5, 2, 1, '2025-11-12 17:59:59', '2025-11-12 17:59:59', '2025-11-12 17:59:59'),
(4, 5, 5, 1, '2025-11-12 18:17:32', '2025-11-12 18:17:32', '2025-11-12 18:17:32'),
(5, 5, 7, 1, '2025-11-12 18:18:43', '2025-11-12 18:18:43', '2025-11-12 18:18:43'),
(8, 1, 4, 1, '2025-11-14 05:57:17', '2025-11-14 05:57:17', '2025-11-14 05:57:17'),
(9, 1, 5, 1, '2025-11-14 05:57:26', '2025-11-14 05:57:26', '2025-11-14 05:57:26'),
(10, 1, 7, 1, '2025-11-14 05:58:21', '2025-11-14 05:58:21', '2025-11-14 05:58:21'),
(21, 3, 2, 1, '2025-11-15 18:20:12', '2025-11-15 18:20:12', '2025-11-15 18:20:12'),
(22, 3, 5, 1, '2025-11-15 18:35:39', '2025-11-15 18:35:39', '2025-11-15 18:35:39'),
(24, 1, 17, 1, '2025-11-16 07:42:54', '2025-11-16 07:42:54', '2025-11-16 07:42:54'),
(25, 1, 18, 1, '2025-11-16 07:43:39', '2025-11-16 07:43:39', '2025-11-16 07:43:39'),
(26, 1, 19, 1, '2025-11-16 07:52:42', '2025-11-16 07:52:42', '2025-11-16 07:52:42'),
(27, 6, 17, 0, '2025-11-23 11:51:52', '2025-11-23 11:51:52', '2025-11-23 11:51:52'),
(28, 6, 18, 0, '2025-11-23 11:56:28', '2025-11-23 11:56:28', '2025-11-23 11:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_10_29_025747_create_sessions_table', 1),
(2, '2025_10_29_093627_add_image_to_categories_table', 2),
(3, '2025_10_29_093959_create_category_media_table', 3),
(4, '2025_10_29_144425_add_description_html_to_courses_table', 4),
(5, '2025_10_29_151234_make_instructor_id_nullable_on_courses_table', 5),
(6, '2025_11_11_190214_add_avatar_to_users_table', 6),
(7, '2025_11_11_192338_fix_admin_password', 6),
(8, '2025_11_11_193310_add_video_url_to_lessons_table', 7),
(9, '2025_11_15_034330_create_cache_table', 8),
(10, '2025_11_15_144331_add_hls_path_to_lessons_table', 9),
(11, '2025_11_15_153045_create_jobs_table', 10),
(12, '2025_11_15_164724_add_cloudinary_id_to_lessons_table', 11),
(13, '2025_11_16_172359_add_is_completed_to_lesson_progress_table', 12),
(14, '2025_11_21_113039_update_users_table_add_instructor_role', 13),
(15, '2025_11_21_112218_create_questions_table', 14),
(16, '2025_11_21_112223_create_answers_table', 15),
(17, '0001_01_01_000000_create_users_table', 16),
(18, '0001_01_01_000001_create_cache_table', 16),
(19, '0001_01_01_000002_create_jobs_table', 16),
(20, '2025_11_22_130000_add_coupon_id_to_orders_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `body` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `body`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'Chào mừng tất cả mọi người đến với Elearning', 'Chúc mọi người có thật nhiều những trải nghiệm tuyệt vời với vô vàn khóa học.', NULL, '2025-11-22 08:56:46', '2025-11-22 08:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','failed','cancelled','refunded') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `coupon_id`, `code`, `subtotal`, `discount`, `total`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, 'ORD-YUGQ5ICC', 379000.00, 0.00, 379000.00, 'paid', '2025-11-11 19:30:40', '2025-11-11 19:30:40'),
(3, 1, NULL, 'ORD-EY3AIHXR', 449000.00, 0.00, 449000.00, 'paid', '2025-11-11 19:43:22', '2025-11-11 19:43:22'),
(16, 5, NULL, 'ORD-TV8QEDFZ', 379000.00, 0.00, 379000.00, 'paid', '2025-11-12 17:57:50', '2025-11-12 17:58:24'),
(19, 3, NULL, 'ORD-A99ERDRL', 379000.00, 0.00, 379000.00, 'paid', '2025-11-15 18:19:38', '2025-11-15 18:19:40'),
(20, 1, NULL, 'ORD-1SS2AGDK', 0.00, 0.00, 0.00, 'paid', '2025-11-16 07:40:16', '2025-11-16 07:40:16'),
(22, 5, NULL, 'ORD-KSRYFYZN', 0.00, 0.00, 0.00, 'paid', '2025-11-16 15:41:34', '2025-11-16 15:41:34'),
(23, 6, NULL, 'ORD-QPBMJLVR', 0.00, 0.00, 0.00, 'paid', '2025-11-21 12:09:54', '2025-11-21 12:09:54'),
(24, 7, NULL, 'ORD-MADURDNK', 0.00, 0.00, 0.00, 'paid', '2025-11-21 17:20:34', '2025-11-21 17:20:34'),
(25, 6, NULL, 'ORD-VROURZW9', 549000.00, 0.00, 549000.00, 'paid', '2025-11-22 09:01:52', '2025-11-22 09:02:13'),
(26, 6, NULL, 'ORD-K8APDVGM', 629000.00, 251600.00, 377400.00, 'paid', '2025-11-22 14:57:37', '2025-11-22 14:57:40'),
(27, 6, 1, 'ORD-BH16KSCY', 599000.00, 239600.00, 359400.00, 'paid', '2025-11-22 15:07:00', '2025-11-22 15:07:01'),
(28, 6, NULL, 'ORD-BMWXJTQG', 549000.00, 0.00, 549000.00, 'paid', '2025-11-23 07:48:49', '2025-11-23 07:48:59'),
(29, 6, NULL, 'ORD-VVFVHMPO', 699000.00, 0.00, 699000.00, 'failed', '2025-11-23 08:10:40', '2025-11-23 08:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `course_id`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 31, 379000.00, '2025-11-11 19:30:40', '2025-11-11 19:30:40'),
(3, 3, 24, 449000.00, '2025-11-11 19:43:22', '2025-11-11 19:43:22'),
(17, 16, 31, 379000.00, '2025-11-12 17:57:50', '2025-11-12 17:57:50'),
(20, 19, 31, 379000.00, '2025-11-15 18:19:38', '2025-11-15 18:19:38'),
(21, 20, 35, 0.00, '2025-11-16 07:40:16', '2025-11-16 07:40:16'),
(23, 22, 35, 0.00, '2025-11-16 15:41:34', '2025-11-16 15:41:34'),
(24, 23, 35, 0.00, '2025-11-21 12:09:54', '2025-11-21 12:09:54'),
(25, 24, 35, 0.00, '2025-11-21 17:20:34', '2025-11-21 17:20:34'),
(26, 25, 46, 549000.00, '2025-11-22 09:01:52', '2025-11-22 09:01:52'),
(27, 26, 47, 629000.00, '2025-11-22 14:57:37', '2025-11-22 14:57:37'),
(28, 27, 45, 599000.00, '2025-11-22 15:07:00', '2025-11-22 15:07:00'),
(29, 28, 40, 549000.00, '2025-11-23 07:48:49', '2025-11-23 07:48:49'),
(30, 29, 39, 699000.00, '2025-11-23 08:10:40', '2025-11-23 08:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `provider` enum('bank_transfer','vnpay','momo','paypal') COLLATE utf8mb4_general_ci NOT NULL,
  `transaction_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('initiated','succeeded','failed','refunded') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'initiated',
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `provider`, `transaction_id`, `amount`, `status`, `meta`, `created_at`, `updated_at`) VALUES
(11, 16, 'momo', '4611400441', 379000.00, 'succeeded', '{\"order\":\"16_1762970271\",\"partnerCode\":\"MOMOFOEL20251112_TEST\",\"orderId\":\"16_1762970271\",\"requestId\":\"1762970271\",\"amount\":\"379000\",\"orderInfo\":\"Thanh toan don hang #ORD-TV8QEDFZ\",\"orderType\":\"momo_wallet\",\"transId\":\"4611400441\",\"resultCode\":\"0\",\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"payType\":\"qr\",\"responseTime\":\"1762970297812\",\"extraData\":null,\"signature\":\"91ee16f232320173ac391f2ce2ef8f70829c51aad99473de593dac530686a3bf\"}', '2025-11-12 17:58:24', '2025-11-12 17:58:24'),
(15, 19, 'vnpay', 'TXN17632307806415', 379000.00, 'succeeded', '{\"payment_time\":\"2025-11-15 18:19:40\",\"method\":\"vnpay\"}', '2025-11-15 18:19:40', '2025-11-15 18:19:40'),
(16, 25, 'momo', '4613739624', 549000.00, 'succeeded', '{\"order\":\"25_1763802112\",\"partnerCode\":\"MOMOFOEL20251112_TEST\",\"orderId\":\"25_1763802112\",\"requestId\":\"1763802112\",\"amount\":\"549000\",\"orderInfo\":\"Thanh toan don hang #ORD-VROURZW9\",\"orderType\":\"momo_wallet\",\"transId\":\"4613739624\",\"resultCode\":\"0\",\"message\":\"Th\\u00e0nh c\\u00f4ng.\",\"payType\":\"qr\",\"responseTime\":\"1763802125449\",\"extraData\":null,\"signature\":\"53edefd84c4023d1518202a8b7749097c66de3e3e7fc9b8e82fc8b3cbe20162b\"}', '2025-11-22 09:02:13', '2025-11-22 09:02:13'),
(17, 26, 'vnpay', 'TXN17638234608017', 377400.00, 'succeeded', '{\"payment_time\":\"2025-11-22 14:57:40\",\"method\":\"vnpay\"}', '2025-11-22 14:57:40', '2025-11-22 14:57:40'),
(18, 27, 'vnpay', 'TXN17638240211855', 359400.00, 'succeeded', '{\"payment_time\":\"2025-11-22 15:07:01\",\"method\":\"vnpay\"}', '2025-11-22 15:07:01', '2025-11-22 15:07:01'),
(19, 28, 'vnpay', 'TXN17638841392244', 549000.00, 'succeeded', '{\"payment_time\":\"2025-11-23 07:48:59\",\"method\":\"vnpay\"}', '2025-11-23 07:48:59', '2025-11-23 07:48:59'),
(20, 29, 'momo', '1763885479424', 699000.00, 'failed', '{\"order\":\"29_1763885440\",\"partnerCode\":\"MOMOFOEL20251112_TEST\",\"orderId\":\"29_1763885440\",\"requestId\":\"1763885440\",\"amount\":\"699000\",\"orderInfo\":\"Thanh toan don hang #ORD-VVFVHMPO\",\"orderType\":\"momo_wallet\",\"transId\":\"1763885479424\",\"resultCode\":\"1006\",\"message\":\"Giao d\\u1ecbch b\\u1ecb t\\u1eeb ch\\u1ed1i b\\u1edfi ng\\u01b0\\u1eddi d\\u00f9ng.\",\"payType\":null,\"responseTime\":\"1763885479425\",\"extraData\":null,\"signature\":\"38319f4c74ff3da7fc49c430995f97a662ed546979a0a22adabc12fa4f53f934\"}', '2025-11-23 08:11:28', '2025-11-23 08:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','answered','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_resolved` tinyint(1) NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `course_id`, `lesson_id`, `title`, `content`, `status`, `is_resolved`, `views`, `created_at`, `updated_at`) VALUES
(2, 6, 35, 18, 'Chưa hiểu cách cài đặt', 'Hiện rất nhiều lỗi như .....', 'answered', 0, 11, '2025-11-21 05:10:38', '2025-11-21 10:21:33'),
(3, 6, 35, 28, 'Em chưa hiểu bước này', 'Làm sao mà', 'pending', 0, 2, '2025-11-21 10:18:17', '2025-11-21 10:21:27'),
(4, 7, 35, 18, 'Chưa hiểu cách cài đặt', 'aaaaaaaaaaaaaaaaaaaa', 'pending', 0, 3, '2025-11-21 10:21:22', '2025-11-21 10:30:28'),
(5, 6, 47, 161, 'Tiêu đề câu hỏi', 'Nội dung câu hỏi', 'pending', 0, 1, '2025-11-23 00:44:04', '2025-11-23 00:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `content` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `course_id`, `rating`, `content`, `created_at`, `updated_at`) VALUES
(3, 1, 35, 5, 'Quá tốt rồi', '2025-11-16 16:00:36', '2025-11-16 16:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `position` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `course_id`, `title`, `position`, `created_at`, `updated_at`) VALUES
(2, 31, 'Phần 1', 1, '2025-11-11 19:26:53', '2025-11-11 19:26:53'),
(3, 32, 'gf', 1, '2025-11-12 05:35:46', '2025-11-12 05:35:46'),
(5, 31, 'phần 2', 2, '2025-11-12 18:11:22', '2025-11-12 18:11:22'),
(6, 30, 'Phần 1: Hướng Dẫn Viết Prompt Hiệu Quả', 1, '2025-11-12 18:24:52', '2025-11-12 18:24:52'),
(7, 30, 'Phần 2: Thực Hành Với Các Công Cụ', 2, '2025-11-12 18:28:33', '2025-11-12 18:28:33'),
(8, 15, 'y', 1, '2025-11-14 18:52:23', '2025-11-14 18:52:23'),
(9, 31, 'df', 3, '2025-11-15 17:55:42', '2025-11-15 17:55:42'),
(10, 35, 'Phần 1: Giới thiệu', 1, '2025-11-16 06:08:29', '2025-11-16 06:08:29'),
(11, 35, 'Phần 2: Biến và kiểu dữ liệu', 2, '2025-11-16 06:08:54', '2025-11-16 06:08:54'),
(12, 35, 'Phần 3: Cấu trúc điều khiển và vòng lặp', 3, '2025-11-16 06:09:17', '2025-11-16 06:09:17'),
(13, 35, 'Phần 4: Mảng', 4, '2025-11-16 06:09:32', '2025-11-16 06:09:32'),
(14, 35, 'Phần 5: Hàm', 5, '2025-11-16 06:09:41', '2025-11-16 06:09:41'),
(15, 35, 'test', 6, '2025-11-16 13:02:15', '2025-11-16 13:02:15'),
(16, 10, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(17, 10, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(18, 11, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(19, 11, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(20, 12, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(21, 12, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(22, 13, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(23, 13, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(24, 14, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(25, 14, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(26, 16, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(27, 16, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(28, 17, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(29, 17, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(30, 19, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(31, 19, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(32, 20, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(33, 20, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(34, 21, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(35, 21, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(36, 22, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(37, 22, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(38, 23, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(39, 23, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:27', '2025-11-16 18:46:27'),
(40, 24, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(41, 24, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(42, 25, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(43, 25, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(44, 26, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(45, 26, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(46, 27, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(47, 27, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(48, 28, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(49, 28, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(50, 29, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(51, 29, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(52, 33, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(53, 33, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(54, 34, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(55, 34, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(56, 36, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(57, 36, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(58, 37, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(59, 37, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(60, 38, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(61, 38, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(62, 39, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(63, 39, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(64, 40, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(65, 40, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(66, 41, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(67, 41, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(68, 42, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(69, 42, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(70, 43, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(71, 43, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(72, 44, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(73, 44, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(74, 45, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(76, 46, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(77, 46, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(78, 47, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(79, 47, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(80, 48, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(81, 48, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(82, 49, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(83, 49, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(84, 50, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(85, 50, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(86, 51, 'Phần 1: Giới thiệu', 1, '2025-11-16 18:46:28', '2025-11-16 18:46:28'),
(87, 51, 'Phần 2: Nội dung chính', 2, '2025-11-16 18:46:28', '2025-11-16 18:46:28');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9qLtMYgLlDxd8ZJteiarX0WYJJVKgFNGL5GQuZfT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlNZRVRua1pMZEdYMzRROWJXSFJDN3dNT1N5MkViajVpZ0hJQllvWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763879471),
('APVRAfxYvqhg3CJldQ9iGyagqH9MUrguvv4VKFCG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWZWQ1ZhTld6alNlRlptYmdvZ1FVR3RkamFkdm12NFl0eWpUN2pqSSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9xdWVzdGlvbnMvNCI7czo1OiJyb3V0ZSI7czoyMDoiYWRtaW4ucXVlc3Rpb25zLnNob3ciO31zOjE1OiJhZG1pbl9sb2dnZWRfaW4iO2I6MTtzOjEzOiJhZG1pbl91c2VyX2lkIjtpOjM7fQ==', 1763886477),
('k1XwcvUwU5KUI6pnKwntSEm08yMSXovi6CBXQ6eO', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiT3VGNTcwb3JmNG84anl4S1dJOXhuUXBHQUtGNmhpRFNwakxsQ3ZDTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdGF0aXN0aWNzL3N0dWRlbnRzIjtzOjU6InJvdXRlIjtzOjI1OiJhZG1pbi5zdGF0aXN0aWNzLnN0dWRlbnRzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NjtzOjE1OiJhZG1pbl9sb2dnZWRfaW4iO2I6MTtzOjEzOiJhZG1pbl91c2VyX2lkIjtpOjE7fQ==', 1763899519),
('S7zm74KByGk0tKQhBsPvFxTtVHzZWZwgq2Xl8tfu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzFxTFNqejBDd0d4UzNHdmpOT1ZTU0JOOWtCckpXYWJ3NlZFdzY3MiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO319', 1763886364),
('SCS4SRQFMpJkF2OTJBLqHsq3af0fEoTZAvzsbYfr', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoielhvYjZReWZwRm1uUEJhYlUxbmcxeWJHZWZiYWt6cWRzWG02YWx3aiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1763898721),
('tgtU0qYMQJSWqTG2NMS01PgTcNxIRvJLYYnisKDl', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSUVybld3T1d2R0F0R01BWFd2QUZOQ2s2eDYwd0RjOTVEdUdmaFV6QSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdGF0aXN0aWNzL3N0dWRlbnRzIjtzOjU6InJvdXRlIjtzOjI1OiJhZG1pbi5zdGF0aXN0aWNzLnN0dWRlbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNToiYWRtaW5fbG9nZ2VkX2luIjtiOjE7czoxMzoiYWRtaW5fdXNlcl9pZCI7aToxO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1763889382);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('student','instructor','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'student',
  `email_verified_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `password`, `role`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', 'avatars/2qRpJDI16LpIXYDSpto81Az04MBwJT0TIQxM9nA1.png', '$2y$12$1K9GoUy/CSDezbSJADsfJ.RcBOd5QeC5B/3pEYnle.LMo2u7W6m7C', 'admin', NULL, NULL, '2025-10-15 13:08:10', '2025-11-21 11:57:21'),
(3, 'Việt', 'vietkel05@gmail.com', NULL, '$2y$12$./5p0/8ef9QBWd031HW9iuxRNQB3E2teC16KtY79dvSDOqkts4OlC', 'instructor', NULL, NULL, '2025-10-29 17:49:54', '2025-11-21 12:01:46'),
(5, 'Việt', 'vietkel@gmail.com', NULL, '$2y$12$q.PuFOKd4LJpD2CbuAWaDuCeVjXg39u2GPg63rd4s0xhk2bw9comS', 'instructor', NULL, NULL, '2025-11-12 17:32:35', '2025-11-21 12:02:33'),
(6, 'Học', 'learn@gmail.com', NULL, '$2y$12$IznX/bTNaEqbltZrW4TqSOtk7bzZxiQK1H4FsVo6Pj0G.v8BlrvK2', 'student', NULL, NULL, '2025-11-21 12:06:55', '2025-11-21 12:06:55'),
(7, 'Nguyễn Việt', 'learn2@gmail.com', NULL, '$2y$12$5S220/torZssr0R6pP4y5uYS.ApiDUhhx2tmYX2fUyEmQkF.DuThG', 'student', NULL, NULL, '2025-11-21 17:20:18', '2025-11-21 17:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `notification_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`notification_id`, `user_id`, `read_at`) VALUES
(2, 1, NULL),
(2, 3, NULL),
(2, 5, NULL),
(2, 6, '2025-11-22 08:57:52'),
(2, 7, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_answer_question` (`question_id`),
  ADD KEY `idx_answer_user` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_categories_parent` (`parent_id`);

--
-- Indexes for table `category_media`
--
ALTER TABLE `category_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_media_category_id_foreign` (`category_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_coupons_active_window` (`starts_at`,`ends_at`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_courses_instructor` (`instructor_id`),
  ADD KEY `idx_courses_status` (`status`);
ALTER TABLE `courses` ADD FULLTEXT KEY `ftx_courses` (`title`,`short_description`,`description`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_enroll_user_course` (`user_id`,`course_id`),
  ADD KEY `idx_enroll_course` (`course_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lessons_section_pos` (`section_id`,`position`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_progress_user_lesson` (`user_id`,`lesson_id`),
  ADD KEY `fk_progress_lesson` (`lesson_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_admin` (`created_by`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `idx_orders_status_created` (`status`,`created_at`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_item_order_course` (`order_id`,`course_id`),
  ADD KEY `fk_items_course` (`course_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_order` (`order_id`),
  ADD KEY `idx_payments_provider_status` (`provider`,`status`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_question_user` (`user_id`),
  ADD KEY `idx_question_course` (`course_id`),
  ADD KEY `idx_question_lesson` (`lesson_id`),
  ADD KEY `idx_question_status` (`status`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_review_user_course` (`user_id`,`course_id`),
  ADD KEY `idx_reviews_course` (`course_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sections_course_pos` (`course_id`,`position`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role` (`role`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`notification_id`,`user_id`),
  ADD KEY `fk_un_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category_media`
--
ALTER TABLE `category_media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_answer_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_answer_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `category_media`
--
ALTER TABLE `category_media`
  ADD CONSTRAINT `category_media_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enroll_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enroll_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `fk_lessons_section` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `fk_progress_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_progress_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_admin` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `fk_question_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_question_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_question_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `fk_sections_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `fk_un_notification` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_un_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
