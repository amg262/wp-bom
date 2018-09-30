-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 01, 2017 at 01:00 PM
-- Server version: 5.5.42
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `dev_sandbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'A WordPress Commenter', 'wapuu@wordpress.example', 'https://wordpress.org/', '', '2017-05-01 07:03:44', '2017-05-01 07:03:44', 'Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href="https://gravatar.com">Gravatar</a>.', 0, '1', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB AUTO_INCREMENT=422 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://www.sandbox.dev', 'yes'),
(2, 'home', 'http://www.sandbox.dev', 'yes'),
(3, 'blogname', 'sandbox', 'yes'),
(4, 'blogdescription', 'Just another WordPress site', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'dev@dev.com', 'yes'),
(7, 'start_of_week', '1', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '0', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'F j, Y', 'yes'),
(24, 'time_format', 'g:i a', 'yes'),
(25, 'links_updated_date_format', 'F j, Y g:i a', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:157:{s:24:"^wc-auth/v([1]{1})/(.*)?";s:63:"index.php?wc-auth-version=$matches[1]&wc-auth-route=$matches[2]";s:22:"^wc-api/v([1-3]{1})/?$";s:51:"index.php?wc-api-version=$matches[1]&wc-api-route=/";s:24:"^wc-api/v([1-3]{1})(.*)?";s:61:"index.php?wc-api-version=$matches[1]&wc-api-route=$matches[2]";s:7:"shop/?$";s:27:"index.php?post_type=product";s:37:"shop/feed/(feed|rdf|rss|rss2|atom)/?$";s:44:"index.php?post_type=product&feed=$matches[1]";s:32:"shop/(feed|rdf|rss|rss2|atom)/?$";s:44:"index.php?post_type=product&feed=$matches[1]";s:24:"shop/page/([0-9]{1,})/?$";s:45:"index.php?post_type=product&paged=$matches[1]";s:11:"^wp-json/?$";s:22:"index.php?rest_route=/";s:14:"^wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:21:"^index.php/wp-json/?$";s:22:"index.php?rest_route=/";s:24:"^index.php/wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:23:"category/(.+?)/embed/?$";s:46:"index.php?category_name=$matches[1]&embed=true";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:32:"category/(.+?)/wc-api(/(.*))?/?$";s:54:"index.php?category_name=$matches[1]&wc-api=$matches[3]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:20:"tag/([^/]+)/embed/?$";s:36:"index.php?tag=$matches[1]&embed=true";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:29:"tag/([^/]+)/wc-api(/(.*))?/?$";s:44:"index.php?tag=$matches[1]&wc-api=$matches[3]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:21:"type/([^/]+)/embed/?$";s:44:"index.php?post_format=$matches[1]&embed=true";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:55:"product-category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_cat=$matches[1]&feed=$matches[2]";s:50:"product-category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_cat=$matches[1]&feed=$matches[2]";s:31:"product-category/(.+?)/embed/?$";s:44:"index.php?product_cat=$matches[1]&embed=true";s:43:"product-category/(.+?)/page/?([0-9]{1,})/?$";s:51:"index.php?product_cat=$matches[1]&paged=$matches[2]";s:25:"product-category/(.+?)/?$";s:33:"index.php?product_cat=$matches[1]";s:52:"product-tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_tag=$matches[1]&feed=$matches[2]";s:47:"product-tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?product_tag=$matches[1]&feed=$matches[2]";s:28:"product-tag/([^/]+)/embed/?$";s:44:"index.php?product_tag=$matches[1]&embed=true";s:40:"product-tag/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?product_tag=$matches[1]&paged=$matches[2]";s:22:"product-tag/([^/]+)/?$";s:33:"index.php?product_tag=$matches[1]";s:35:"product/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:45:"product/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:65:"product/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:60:"product/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:60:"product/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:41:"product/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:24:"product/([^/]+)/embed/?$";s:40:"index.php?product=$matches[1]&embed=true";s:28:"product/([^/]+)/trackback/?$";s:34:"index.php?product=$matches[1]&tb=1";s:48:"product/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:46:"index.php?product=$matches[1]&feed=$matches[2]";s:43:"product/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:46:"index.php?product=$matches[1]&feed=$matches[2]";s:36:"product/([^/]+)/page/?([0-9]{1,})/?$";s:47:"index.php?product=$matches[1]&paged=$matches[2]";s:43:"product/([^/]+)/comment-page-([0-9]{1,})/?$";s:47:"index.php?product=$matches[1]&cpage=$matches[2]";s:33:"product/([^/]+)/wc-api(/(.*))?/?$";s:48:"index.php?product=$matches[1]&wc-api=$matches[3]";s:39:"product/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:50:"product/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:32:"product/([^/]+)(?:/([0-9]+))?/?$";s:46:"index.php?product=$matches[1]&page=$matches[2]";s:24:"product/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:34:"product/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:54:"product/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:49:"product/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:49:"product/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:30:"product/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:8:"embed/?$";s:21:"index.php?&embed=true";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:17:"wc-api(/(.*))?/?$";s:29:"index.php?&wc-api=$matches[2]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:17:"comments/embed/?$";s:21:"index.php?&embed=true";s:26:"comments/wc-api(/(.*))?/?$";s:29:"index.php?&wc-api=$matches[2]";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:20:"search/(.+)/embed/?$";s:34:"index.php?s=$matches[1]&embed=true";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:29:"search/(.+)/wc-api(/(.*))?/?$";s:42:"index.php?s=$matches[1]&wc-api=$matches[3]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:23:"author/([^/]+)/embed/?$";s:44:"index.php?author_name=$matches[1]&embed=true";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:32:"author/([^/]+)/wc-api(/(.*))?/?$";s:52:"index.php?author_name=$matches[1]&wc-api=$matches[3]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:45:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$";s:74:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:54:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/wc-api(/(.*))?/?$";s:82:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&wc-api=$matches[5]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:32:"([0-9]{4})/([0-9]{1,2})/embed/?$";s:58:"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:41:"([0-9]{4})/([0-9]{1,2})/wc-api(/(.*))?/?$";s:66:"index.php?year=$matches[1]&monthnum=$matches[2]&wc-api=$matches[4]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:19:"([0-9]{4})/embed/?$";s:37:"index.php?year=$matches[1]&embed=true";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:28:"([0-9]{4})/wc-api(/(.*))?/?$";s:45:"index.php?year=$matches[1]&wc-api=$matches[3]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:58:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:68:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:88:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:83:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:64:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:53:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/embed/?$";s:91:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/trackback/?$";s:85:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&tb=1";s:77:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&feed=$matches[5]";s:65:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&paged=$matches[5]";s:72:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$";s:98:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&cpage=$matches[5]";s:62:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)/wc-api(/(.*))?/?$";s:99:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&wc-api=$matches[6]";s:62:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:73:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:61:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$";s:97:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&name=$matches[4]&page=$matches[5]";s:47:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:57:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:77:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:53:"[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}/[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&cpage=$matches[4]";s:51:"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]";s:38:"([0-9]{4})/comment-page-([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&cpage=$matches[2]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:".?.+?/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"(.?.+?)/embed/?$";s:41:"index.php?pagename=$matches[1]&embed=true";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:25:"(.?.+?)/wc-api(/(.*))?/?$";s:49:"index.php?pagename=$matches[1]&wc-api=$matches[3]";s:28:"(.?.+?)/order-pay(/(.*))?/?$";s:52:"index.php?pagename=$matches[1]&order-pay=$matches[3]";s:33:"(.?.+?)/order-received(/(.*))?/?$";s:57:"index.php?pagename=$matches[1]&order-received=$matches[3]";s:25:"(.?.+?)/orders(/(.*))?/?$";s:49:"index.php?pagename=$matches[1]&orders=$matches[3]";s:29:"(.?.+?)/view-order(/(.*))?/?$";s:53:"index.php?pagename=$matches[1]&view-order=$matches[3]";s:28:"(.?.+?)/downloads(/(.*))?/?$";s:52:"index.php?pagename=$matches[1]&downloads=$matches[3]";s:31:"(.?.+?)/edit-account(/(.*))?/?$";s:55:"index.php?pagename=$matches[1]&edit-account=$matches[3]";s:31:"(.?.+?)/edit-address(/(.*))?/?$";s:55:"index.php?pagename=$matches[1]&edit-address=$matches[3]";s:34:"(.?.+?)/payment-methods(/(.*))?/?$";s:58:"index.php?pagename=$matches[1]&payment-methods=$matches[3]";s:32:"(.?.+?)/lost-password(/(.*))?/?$";s:56:"index.php?pagename=$matches[1]&lost-password=$matches[3]";s:34:"(.?.+?)/customer-logout(/(.*))?/?$";s:58:"index.php?pagename=$matches[1]&customer-logout=$matches[3]";s:37:"(.?.+?)/add-payment-method(/(.*))?/?$";s:61:"index.php?pagename=$matches[1]&add-payment-method=$matches[3]";s:40:"(.?.+?)/delete-payment-method(/(.*))?/?$";s:64:"index.php?pagename=$matches[1]&delete-payment-method=$matches[3]";s:45:"(.?.+?)/set-default-payment-method(/(.*))?/?$";s:69:"index.php?pagename=$matches[1]&set-default-payment-method=$matches[3]";s:31:".?.+?/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:42:".?.+?/attachment/([^/]+)/wc-api(/(.*))?/?$";s:51:"index.php?attachment=$matches[1]&wc-api=$matches[3]";s:24:"(.?.+?)(?:/([0-9]+))?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:3:{i:0;s:33:"duplicate-post/duplicate-post.php";i:1;s:17:"wc-bom/wc-bom.php";i:2;s:27:"woocommerce/woocommerce.php";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'storefront', 'yes'),
(41, 'stylesheet', 'storefront', 'yes'),
(42, 'comment_whitelist', '1', 'yes'),
(43, 'blacklist_keys', '', 'no'),
(44, 'comment_registration', '0', 'yes'),
(45, 'html_type', 'text/html', 'yes'),
(46, 'use_trackback', '0', 'yes'),
(47, 'default_role', 'subscriber', 'yes'),
(48, 'db_version', '38590', 'yes'),
(49, 'uploads_use_yearmonth_folders', '1', 'yes'),
(50, 'upload_path', '', 'yes'),
(51, 'blog_public', '0', 'yes'),
(52, 'default_link_category', '2', 'yes'),
(53, 'show_on_front', 'posts', 'yes'),
(54, 'tag_base', '', 'yes'),
(55, 'show_avatars', '1', 'yes'),
(56, 'avatar_rating', 'G', 'yes'),
(57, 'upload_url_path', '', 'yes'),
(58, 'thumbnail_size_w', '150', 'yes'),
(59, 'thumbnail_size_h', '150', 'yes'),
(60, 'thumbnail_crop', '1', 'yes'),
(61, 'medium_size_w', '300', 'yes'),
(62, 'medium_size_h', '300', 'yes'),
(63, 'avatar_default', 'mystery', 'yes'),
(64, 'large_size_w', '1024', 'yes'),
(65, 'large_size_h', '1024', 'yes'),
(66, 'image_default_link_type', 'none', 'yes'),
(67, 'image_default_size', '', 'yes'),
(68, 'image_default_align', '', 'yes'),
(69, 'close_comments_for_old_posts', '0', 'yes'),
(70, 'close_comments_days_old', '14', 'yes'),
(71, 'thread_comments', '1', 'yes'),
(72, 'thread_comments_depth', '5', 'yes'),
(73, 'page_comments', '0', 'yes'),
(74, 'comments_per_page', '50', 'yes'),
(75, 'default_comments_page', 'newest', 'yes'),
(76, 'comment_order', 'asc', 'yes'),
(77, 'sticky_posts', 'a:0:{}', 'yes'),
(78, 'widget_categories', 'a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(79, 'widget_text', 'a:0:{}', 'yes'),
(80, 'widget_rss', 'a:0:{}', 'yes'),
(81, 'uninstall_plugins', 'a:0:{}', 'no'),
(82, 'timezone_string', '', 'yes'),
(83, 'page_for_posts', '0', 'yes'),
(84, 'page_on_front', '0', 'yes'),
(85, 'default_post_format', '0', 'yes'),
(86, 'link_manager_enabled', '0', 'yes'),
(87, 'finished_splitting_shared_terms', '1', 'yes'),
(88, 'site_icon', '0', 'yes'),
(89, 'medium_large_size_w', '768', 'yes'),
(90, 'medium_large_size_h', '0', 'yes'),
(91, 'initial_db_version', '38590', 'yes'),
(92, 'wp_user_roles', 'a:7:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:132:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;s:18:"manage_woocommerce";b:1;s:24:"view_woocommerce_reports";b:1;s:12:"edit_product";b:1;s:12:"read_product";b:1;s:14:"delete_product";b:1;s:13:"edit_products";b:1;s:20:"edit_others_products";b:1;s:16:"publish_products";b:1;s:21:"read_private_products";b:1;s:15:"delete_products";b:1;s:23:"delete_private_products";b:1;s:25:"delete_published_products";b:1;s:22:"delete_others_products";b:1;s:21:"edit_private_products";b:1;s:23:"edit_published_products";b:1;s:20:"manage_product_terms";b:1;s:18:"edit_product_terms";b:1;s:20:"delete_product_terms";b:1;s:20:"assign_product_terms";b:1;s:15:"edit_shop_order";b:1;s:15:"read_shop_order";b:1;s:17:"delete_shop_order";b:1;s:16:"edit_shop_orders";b:1;s:23:"edit_others_shop_orders";b:1;s:19:"publish_shop_orders";b:1;s:24:"read_private_shop_orders";b:1;s:18:"delete_shop_orders";b:1;s:26:"delete_private_shop_orders";b:1;s:28:"delete_published_shop_orders";b:1;s:25:"delete_others_shop_orders";b:1;s:24:"edit_private_shop_orders";b:1;s:26:"edit_published_shop_orders";b:1;s:23:"manage_shop_order_terms";b:1;s:21:"edit_shop_order_terms";b:1;s:23:"delete_shop_order_terms";b:1;s:23:"assign_shop_order_terms";b:1;s:16:"edit_shop_coupon";b:1;s:16:"read_shop_coupon";b:1;s:18:"delete_shop_coupon";b:1;s:17:"edit_shop_coupons";b:1;s:24:"edit_others_shop_coupons";b:1;s:20:"publish_shop_coupons";b:1;s:25:"read_private_shop_coupons";b:1;s:19:"delete_shop_coupons";b:1;s:27:"delete_private_shop_coupons";b:1;s:29:"delete_published_shop_coupons";b:1;s:26:"delete_others_shop_coupons";b:1;s:25:"edit_private_shop_coupons";b:1;s:27:"edit_published_shop_coupons";b:1;s:24:"manage_shop_coupon_terms";b:1;s:22:"edit_shop_coupon_terms";b:1;s:24:"delete_shop_coupon_terms";b:1;s:24:"assign_shop_coupon_terms";b:1;s:17:"edit_shop_webhook";b:1;s:17:"read_shop_webhook";b:1;s:19:"delete_shop_webhook";b:1;s:18:"edit_shop_webhooks";b:1;s:25:"edit_others_shop_webhooks";b:1;s:21:"publish_shop_webhooks";b:1;s:26:"read_private_shop_webhooks";b:1;s:20:"delete_shop_webhooks";b:1;s:28:"delete_private_shop_webhooks";b:1;s:30:"delete_published_shop_webhooks";b:1;s:27:"delete_others_shop_webhooks";b:1;s:26:"edit_private_shop_webhooks";b:1;s:28:"edit_published_shop_webhooks";b:1;s:25:"manage_shop_webhook_terms";b:1;s:23:"edit_shop_webhook_terms";b:1;s:25:"delete_shop_webhook_terms";b:1;s:25:"assign_shop_webhook_terms";b:1;s:10:"copy_posts";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:35:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:10:"copy_posts";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}s:8:"customer";a:2:{s:4:"name";s:8:"Customer";s:12:"capabilities";a:1:{s:4:"read";b:1;}}s:12:"shop_manager";a:2:{s:4:"name";s:12:"Shop manager";s:12:"capabilities";a:110:{s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:4:"read";b:1;s:18:"read_private_pages";b:1;s:18:"read_private_posts";b:1;s:10:"edit_users";b:1;s:10:"edit_posts";b:1;s:10:"edit_pages";b:1;s:20:"edit_published_posts";b:1;s:20:"edit_published_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"edit_private_posts";b:1;s:17:"edit_others_posts";b:1;s:17:"edit_others_pages";b:1;s:13:"publish_posts";b:1;s:13:"publish_pages";b:1;s:12:"delete_posts";b:1;s:12:"delete_pages";b:1;s:20:"delete_private_pages";b:1;s:20:"delete_private_posts";b:1;s:22:"delete_published_pages";b:1;s:22:"delete_published_posts";b:1;s:19:"delete_others_posts";b:1;s:19:"delete_others_pages";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:17:"moderate_comments";b:1;s:15:"unfiltered_html";b:1;s:12:"upload_files";b:1;s:6:"export";b:1;s:6:"import";b:1;s:10:"list_users";b:1;s:18:"manage_woocommerce";b:1;s:24:"view_woocommerce_reports";b:1;s:12:"edit_product";b:1;s:12:"read_product";b:1;s:14:"delete_product";b:1;s:13:"edit_products";b:1;s:20:"edit_others_products";b:1;s:16:"publish_products";b:1;s:21:"read_private_products";b:1;s:15:"delete_products";b:1;s:23:"delete_private_products";b:1;s:25:"delete_published_products";b:1;s:22:"delete_others_products";b:1;s:21:"edit_private_products";b:1;s:23:"edit_published_products";b:1;s:20:"manage_product_terms";b:1;s:18:"edit_product_terms";b:1;s:20:"delete_product_terms";b:1;s:20:"assign_product_terms";b:1;s:15:"edit_shop_order";b:1;s:15:"read_shop_order";b:1;s:17:"delete_shop_order";b:1;s:16:"edit_shop_orders";b:1;s:23:"edit_others_shop_orders";b:1;s:19:"publish_shop_orders";b:1;s:24:"read_private_shop_orders";b:1;s:18:"delete_shop_orders";b:1;s:26:"delete_private_shop_orders";b:1;s:28:"delete_published_shop_orders";b:1;s:25:"delete_others_shop_orders";b:1;s:24:"edit_private_shop_orders";b:1;s:26:"edit_published_shop_orders";b:1;s:23:"manage_shop_order_terms";b:1;s:21:"edit_shop_order_terms";b:1;s:23:"delete_shop_order_terms";b:1;s:23:"assign_shop_order_terms";b:1;s:16:"edit_shop_coupon";b:1;s:16:"read_shop_coupon";b:1;s:18:"delete_shop_coupon";b:1;s:17:"edit_shop_coupons";b:1;s:24:"edit_others_shop_coupons";b:1;s:20:"publish_shop_coupons";b:1;s:25:"read_private_shop_coupons";b:1;s:19:"delete_shop_coupons";b:1;s:27:"delete_private_shop_coupons";b:1;s:29:"delete_published_shop_coupons";b:1;s:26:"delete_others_shop_coupons";b:1;s:25:"edit_private_shop_coupons";b:1;s:27:"edit_published_shop_coupons";b:1;s:24:"manage_shop_coupon_terms";b:1;s:22:"edit_shop_coupon_terms";b:1;s:24:"delete_shop_coupon_terms";b:1;s:24:"assign_shop_coupon_terms";b:1;s:17:"edit_shop_webhook";b:1;s:17:"read_shop_webhook";b:1;s:19:"delete_shop_webhook";b:1;s:18:"edit_shop_webhooks";b:1;s:25:"edit_others_shop_webhooks";b:1;s:21:"publish_shop_webhooks";b:1;s:26:"read_private_shop_webhooks";b:1;s:20:"delete_shop_webhooks";b:1;s:28:"delete_private_shop_webhooks";b:1;s:30:"delete_published_shop_webhooks";b:1;s:27:"delete_others_shop_webhooks";b:1;s:26:"edit_private_shop_webhooks";b:1;s:28:"edit_published_shop_webhooks";b:1;s:25:"manage_shop_webhook_terms";b:1;s:23:"edit_shop_webhook_terms";b:1;s:25:"delete_shop_webhook_terms";b:1;s:25:"assign_shop_webhook_terms";b:1;}}}', 'yes'),
(93, 'fresh_site', '0', 'yes'),
(94, 'widget_search', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(95, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(96, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
(97, 'widget_archives', 'a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
(98, 'widget_meta', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
(99, 'sidebars_widgets', 'a:8:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:8:"header-1";a:0:{}s:8:"footer-1";a:0:{}s:8:"footer-2";N;s:8:"footer-3";N;s:8:"footer-4";N;s:13:"array_version";i:3;}', 'yes'),
(100, 'widget_pages', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(101, 'widget_calendar', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(102, 'widget_tag_cloud', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(103, 'widget_nav_menu', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(104, 'cron', 'a:9:{i:1493663539;a:1:{s:32:"woocommerce_cancel_unpaid_orders";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:2:{s:8:"schedule";b:0;s:4:"args";a:0:{}}}}i:1493665424;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1493665617;a:1:{s:28:"woocommerce_cleanup_sessions";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1493683200;a:1:{s:27:"woocommerce_scheduled_sales";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1493708634;a:1:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1493708817;a:1:{s:30:"woocommerce_tracker_send_event";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1493708849;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1496707200;a:1:{s:25:"woocommerce_geoip_updater";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:7:"monthly";s:4:"args";a:0:{}s:8:"interval";i:2635200;}}}s:7:"version";i:2;}', 'yes'),
(105, 'theme_mods_twentyseventeen', 'a:2:{s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1493622379;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";a:0:{}}}}', 'yes'),
(116, '_site_transient_timeout_browser_fa9d3b6a12ca197fcd0b8da44b832bb2', '1494227027', 'no'),
(117, '_site_transient_browser_fa9d3b6a12ca197fcd0b8da44b832bb2', 'a:9:{s:8:"platform";s:9:"Macintosh";s:4:"name";s:6:"Chrome";s:7:"version";s:13:"57.0.2987.133";s:10:"update_url";s:28:"http://www.google.com/chrome";s:7:"img_src";s:49:"http://s.wordpress.org/images/browsers/chrome.png";s:11:"img_src_ssl";s:48:"https://wordpress.org/images/browsers/chrome.png";s:15:"current_version";s:2:"18";s:7:"upgrade";b:0;s:8:"insecure";b:0;}', 'no'),
(118, 'can_compress_scripts', '1', 'no'),
(120, '_transient_timeout_plugin_slugs', '1493747539', 'no'),
(121, '_transient_plugin_slugs', 'a:4:{i:0;s:30:"advanced-custom-fields/acf.php";i:1;s:33:"duplicate-post/duplicate-post.php";i:2;s:17:"wc-bom/wc-bom.php";i:3;s:27:"woocommerce/woocommerce.php";}', 'no'),
(122, '_transient_timeout_dash_88ae138922fe95674369b1cb3d215a2b', '1493665433', 'no'),
(123, '_transient_dash_88ae138922fe95674369b1cb3d215a2b', '<div class="rss-widget"><p><strong>RSS Error:</strong> WP HTTP Error: cURL error 6: Couldn''t resolve host ''wordpress.org''</p></div><div class="rss-widget"><p><strong>RSS Error:</strong> WP HTTP Error: cURL error 6: Couldn''t resolve host ''planet.wordpress.org''</p></div><div class="rss-widget"><ul></ul></div>', 'no'),
(129, '_site_transient_update_core', 'O:8:"stdClass":4:{s:7:"updates";a:1:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:59:"https://downloads.wordpress.org/release/wordpress-4.7.4.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:59:"https://downloads.wordpress.org/release/wordpress-4.7.4.zip";s:10:"no_content";s:70:"https://downloads.wordpress.org/release/wordpress-4.7.4-no-content.zip";s:11:"new_bundled";s:71:"https://downloads.wordpress.org/release/wordpress-4.7.4-new-bundled.zip";s:7:"partial";b:0;s:8:"rollback";b:0;}s:7:"current";s:5:"4.7.4";s:7:"version";s:5:"4.7.4";s:11:"php_version";s:5:"5.2.4";s:13:"mysql_version";s:3:"5.0";s:11:"new_bundled";s:3:"4.7";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1493630086;s:15:"version_checked";s:5:"4.7.4";s:12:"translations";a:0:{}}', 'no'),
(131, '_site_transient_timeout_wporg_theme_feature_list', '1493633116', 'no'),
(132, '_site_transient_wporg_theme_feature_list', 'a:3:{s:6:"Layout";a:7:{i:0;s:11:"grid-layout";i:1;s:10:"one-column";i:2;s:11:"two-columns";i:3;s:13:"three-columns";i:4;s:12:"four-columns";i:5;s:12:"left-sidebar";i:6;s:13:"right-sidebar";}s:8:"Features";a:20:{i:0;s:19:"accessibility-ready";i:1;s:10:"buddypress";i:2;s:17:"custom-background";i:3;s:13:"custom-colors";i:4;s:13:"custom-header";i:5;s:11:"custom-menu";i:6;s:12:"editor-style";i:7;s:21:"featured-image-header";i:8;s:15:"featured-images";i:9;s:15:"flexible-header";i:10;s:14:"footer-widgets";i:11;s:20:"front-page-post-form";i:12;s:19:"full-width-template";i:13;s:12:"microformats";i:14;s:12:"post-formats";i:15;s:20:"rtl-language-support";i:16;s:11:"sticky-post";i:17;s:13:"theme-options";i:18;s:17:"threaded-comments";i:19;s:17:"translation-ready";}s:7:"Subject";a:9:{i:0;s:4:"blog";i:1;s:10:"e-commerce";i:2;s:9:"education";i:3;s:13:"entertainment";i:4;s:14:"food-and-drink";i:5;s:7:"holiday";i:6;s:4:"news";i:7;s:11:"photography";i:8;s:9:"portfolio";}}', 'no'),
(134, '_site_transient_update_themes', 'O:8:"stdClass":4:{s:12:"last_checked";i:1493630087;s:7:"checked";a:4:{s:10:"storefront";s:5:"2.1.8";s:13:"twentyfifteen";s:3:"1.7";s:15:"twentyseventeen";s:3:"1.2";s:13:"twentysixteen";s:3:"1.3";}s:8:"response";a:0:{}s:12:"translations";a:0:{}}', 'no'),
(135, 'current_theme', 'Storefront', 'yes'),
(136, 'theme_mods_storefront', 'a:4:{i:0;b:0;s:17:"storefront_styles";s:4645:"\n			.main-navigation ul li a,\n			.site-title a,\n			ul.menu li a,\n			.site-branding h1 a,\n			.site-footer .storefront-handheld-footer-bar a:not(.button),\n			button.menu-toggle,\n			button.menu-toggle:hover {\n				color: #d5d9db;\n			}\n\n			button.menu-toggle,\n			button.menu-toggle:hover {\n				border-color: #d5d9db;\n			}\n\n			.main-navigation ul li a:hover,\n			.main-navigation ul li:hover > a,\n			.site-title a:hover,\n			a.cart-contents:hover,\n			.site-header-cart .widget_shopping_cart a:hover,\n			.site-header-cart:hover > li > a,\n			.site-header ul.menu li.current-menu-item > a {\n				color: #ffffff;\n			}\n\n			table th {\n				background-color: #f8f8f8;\n			}\n\n			table tbody td {\n				background-color: #fdfdfd;\n			}\n\n			table tbody tr:nth-child(2n) td {\n				background-color: #fbfbfb;\n			}\n\n			.site-header,\n			.secondary-navigation ul ul,\n			.main-navigation ul.menu > li.menu-item-has-children:after,\n			.secondary-navigation ul.menu ul,\n			.storefront-handheld-footer-bar,\n			.storefront-handheld-footer-bar ul li > a,\n			.storefront-handheld-footer-bar ul li.search .site-search,\n			button.menu-toggle,\n			button.menu-toggle:hover {\n				background-color: #2c2d33;\n			}\n\n			p.site-description,\n			.site-header,\n			.storefront-handheld-footer-bar {\n				color: #9aa0a7;\n			}\n\n			.storefront-handheld-footer-bar ul li.cart .count,\n			button.menu-toggle:after,\n			button.menu-toggle:before,\n			button.menu-toggle span:before {\n				background-color: #d5d9db;\n			}\n\n			.storefront-handheld-footer-bar ul li.cart .count {\n				color: #2c2d33;\n			}\n\n			.storefront-handheld-footer-bar ul li.cart .count {\n				border-color: #2c2d33;\n			}\n\n			h1, h2, h3, h4, h5, h6 {\n				color: #484c51;\n			}\n\n			.widget h1 {\n				border-bottom-color: #484c51;\n			}\n\n			body,\n			.secondary-navigation a,\n			.onsale,\n			.pagination .page-numbers li .page-numbers:not(.current), .woocommerce-pagination .page-numbers li .page-numbers:not(.current) {\n				color: #43454b;\n			}\n\n			.widget-area .widget a,\n			.hentry .entry-header .posted-on a,\n			.hentry .entry-header .byline a {\n				color: #75777d;\n			}\n\n			a  {\n				color: #96588a;\n			}\n\n			a:focus,\n			.button:focus,\n			.button.alt:focus,\n			.button.added_to_cart:focus,\n			.button.wc-forward:focus,\n			button:focus,\n			input[type="button"]:focus,\n			input[type="reset"]:focus,\n			input[type="submit"]:focus {\n				outline-color: #96588a;\n			}\n\n			button, input[type="button"], input[type="reset"], input[type="submit"], .button, .added_to_cart, .widget a.button, .site-header-cart .widget_shopping_cart a.button {\n				background-color: #96588a;\n				border-color: #96588a;\n				color: #ffffff;\n			}\n\n			button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .added_to_cart:hover, .widget a.button:hover, .site-header-cart .widget_shopping_cart a.button:hover {\n				background-color: #7d3f71;\n				border-color: #7d3f71;\n				color: #ffffff;\n			}\n\n			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .added_to_cart.alt, .widget-area .widget a.button.alt, .added_to_cart, .pagination .page-numbers li .page-numbers.current, .woocommerce-pagination .page-numbers li .page-numbers.current, .widget a.button.checkout {\n				background-color: #2c2d33;\n				border-color: #2c2d33;\n				color: #ffffff;\n			}\n\n			button.alt:hover, input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover, .button.alt:hover, .added_to_cart.alt:hover, .widget-area .widget a.button.alt:hover, .added_to_cart:hover, .widget a.button.checkout:hover {\n				background-color: #13141a;\n				border-color: #13141a;\n				color: #ffffff;\n			}\n\n			#comments .comment-list .comment-content .comment-text {\n				background-color: #f8f8f8;\n			}\n\n			.site-footer {\n				background-color: #f0f0f0;\n				color: #61656b;\n			}\n\n			.site-footer a:not(.button) {\n				color: #2c2d33;\n			}\n\n			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 {\n				color: #494c50;\n			}\n\n			#order_review,\n			#payment .payment_methods > li .payment_box {\n				background-color: #ffffff;\n			}\n\n			#payment .payment_methods > li {\n				background-color: #fafafa;\n			}\n\n			#payment .payment_methods > li:hover {\n				background-color: #f5f5f5;\n			}\n\n			@media screen and ( min-width: 768px ) {\n				.secondary-navigation ul.menu a:hover {\n					color: #b3b9c0;\n				}\n\n				.secondary-navigation ul.menu a {\n					color: #9aa0a7;\n				}\n\n				.site-header-cart .widget_shopping_cart,\n				.main-navigation ul.menu ul.sub-menu,\n				.main-navigation ul.nav-menu ul.children {\n					background-color: #24252b;\n				}\n			}";s:29:"storefront_woocommerce_styles";s:2233:"\n			a.cart-contents,\n			.site-header-cart .widget_shopping_cart a {\n				color: #d5d9db;\n			}\n\n			table.cart td.product-remove,\n			table.cart td.actions {\n				border-top-color: #ffffff;\n			}\n\n			.woocommerce-tabs ul.tabs li.active a,\n			ul.products li.product .price,\n			.onsale,\n			.widget_search form:before,\n			.widget_product_search form:before {\n				color: #43454b;\n			}\n\n			.woocommerce-breadcrumb a,\n			a.woocommerce-review-link,\n			.product_meta a {\n				color: #75777d;\n			}\n\n			.onsale {\n				border-color: #43454b;\n			}\n\n			.star-rating span:before,\n			.quantity .plus, .quantity .minus,\n			p.stars a:hover:after,\n			p.stars a:after,\n			.star-rating span:before,\n			#payment .payment_methods li input[type=radio]:first-child:checked+label:before {\n				color: #96588a;\n			}\n\n			.widget_price_filter .ui-slider .ui-slider-range,\n			.widget_price_filter .ui-slider .ui-slider-handle {\n				background-color: #96588a;\n			}\n\n			.woocommerce-breadcrumb,\n			#reviews .commentlist li .comment_container {\n				background-color: #f8f8f8;\n			}\n\n			.order_details {\n				background-color: #f8f8f8;\n			}\n\n			.order_details > li {\n				border-bottom: 1px dotted #e3e3e3;\n			}\n\n			.order_details:before,\n			.order_details:after {\n				background: -webkit-linear-gradient(transparent 0,transparent 0),-webkit-linear-gradient(135deg,#f8f8f8 33.33%,transparent 33.33%),-webkit-linear-gradient(45deg,#f8f8f8 33.33%,transparent 33.33%)\n			}\n\n			p.stars a:before,\n			p.stars a:hover~a:before,\n			p.stars.selected a.active~a:before {\n				color: #43454b;\n			}\n\n			p.stars.selected a.active:before,\n			p.stars:hover a:before,\n			p.stars.selected a:not(.active):before,\n			p.stars.selected a.active:before {\n				color: #96588a;\n			}\n\n			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger {\n				background-color: #96588a;\n				color: #ffffff;\n			}\n\n			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger:hover {\n				background-color: #7d3f71;\n				border-color: #7d3f71;\n				color: #ffffff;\n			}\n\n			@media screen and ( min-width: 768px ) {\n				.site-header-cart .widget_shopping_cart,\n				.site-header .product_list_widget li .quantity {\n					color: #9aa0a7;\n				}\n			}";s:18:"custom_css_post_id";i:-1;}', 'yes'),
(137, 'theme_switched', '', 'yes'),
(138, '_site_transient_timeout_poptags_40cd750bba9870f18aada2478b24840a', '1493633191', 'no');
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(139, '_site_transient_poptags_40cd750bba9870f18aada2478b24840a', 'O:8:"stdClass":100:{s:6:"widget";a:3:{s:4:"name";s:6:"widget";s:4:"slug";s:6:"widget";s:5:"count";i:4331;}s:4:"post";a:3:{s:4:"name";s:4:"post";s:4:"slug";s:4:"post";s:5:"count";i:2475;}s:5:"admin";a:3:{s:4:"name";s:5:"admin";s:4:"slug";s:5:"admin";s:5:"count";i:2342;}s:11:"woocommerce";a:3:{s:4:"name";s:11:"woocommerce";s:4:"slug";s:11:"woocommerce";s:5:"count";i:2033;}s:5:"posts";a:3:{s:4:"name";s:5:"posts";s:4:"slug";s:5:"posts";s:5:"count";i:1815;}s:8:"comments";a:3:{s:4:"name";s:8:"comments";s:4:"slug";s:8:"comments";s:5:"count";i:1575;}s:9:"shortcode";a:3:{s:4:"name";s:9:"shortcode";s:4:"slug";s:9:"shortcode";s:5:"count";i:1541;}s:7:"twitter";a:3:{s:4:"name";s:7:"twitter";s:4:"slug";s:7:"twitter";s:5:"count";i:1428;}s:6:"google";a:3:{s:4:"name";s:6:"google";s:4:"slug";s:6:"google";s:5:"count";i:1325;}s:6:"images";a:3:{s:4:"name";s:6:"images";s:4:"slug";s:6:"images";s:5:"count";i:1316;}s:8:"facebook";a:3:{s:4:"name";s:8:"facebook";s:4:"slug";s:8:"facebook";s:5:"count";i:1306;}s:7:"sidebar";a:3:{s:4:"name";s:7:"sidebar";s:4:"slug";s:7:"sidebar";s:5:"count";i:1265;}s:5:"image";a:3:{s:4:"name";s:5:"image";s:4:"slug";s:5:"image";s:5:"count";i:1254;}s:3:"seo";a:3:{s:4:"name";s:3:"seo";s:4:"slug";s:3:"seo";s:5:"count";i:1090;}s:4:"page";a:3:{s:4:"name";s:4:"page";s:4:"slug";s:4:"page";s:5:"count";i:1036;}s:7:"gallery";a:3:{s:4:"name";s:7:"gallery";s:4:"slug";s:7:"gallery";s:5:"count";i:1034;}s:6:"social";a:3:{s:4:"name";s:6:"social";s:4:"slug";s:6:"social";s:5:"count";i:979;}s:5:"email";a:3:{s:4:"name";s:5:"email";s:4:"slug";s:5:"email";s:5:"count";i:916;}s:5:"links";a:3:{s:4:"name";s:5:"links";s:4:"slug";s:5:"links";s:5:"count";i:810;}s:9:"ecommerce";a:3:{s:4:"name";s:9:"ecommerce";s:4:"slug";s:9:"ecommerce";s:5:"count";i:785;}s:5:"login";a:3:{s:4:"name";s:5:"login";s:4:"slug";s:5:"login";s:5:"count";i:780;}s:7:"widgets";a:3:{s:4:"name";s:7:"widgets";s:4:"slug";s:7:"widgets";s:5:"count";i:761;}s:5:"video";a:3:{s:4:"name";s:5:"video";s:4:"slug";s:5:"video";s:5:"count";i:751;}s:3:"rss";a:3:{s:4:"name";s:3:"rss";s:4:"slug";s:3:"rss";s:5:"count";i:663;}s:10:"buddypress";a:3:{s:4:"name";s:10:"buddypress";s:4:"slug";s:10:"buddypress";s:5:"count";i:651;}s:7:"content";a:3:{s:4:"name";s:7:"content";s:4:"slug";s:7:"content";s:5:"count";i:646;}s:4:"spam";a:3:{s:4:"name";s:4:"spam";s:4:"slug";s:4:"spam";s:5:"count";i:638;}s:5:"pages";a:3:{s:4:"name";s:5:"pages";s:4:"slug";s:5:"pages";s:5:"count";i:638;}s:6:"jquery";a:3:{s:4:"name";s:6:"jquery";s:4:"slug";s:6:"jquery";s:5:"count";i:634;}s:8:"security";a:3:{s:4:"name";s:8:"security";s:4:"slug";s:8:"security";s:5:"count";i:617;}s:6:"slider";a:3:{s:4:"name";s:6:"slider";s:4:"slug";s:6:"slider";s:5:"count";i:591;}s:4:"ajax";a:3:{s:4:"name";s:4:"ajax";s:4:"slug";s:4:"ajax";s:5:"count";i:590;}s:5:"media";a:3:{s:4:"name";s:5:"media";s:4:"slug";s:5:"media";s:5:"count";i:585;}s:8:"category";a:3:{s:4:"name";s:8:"category";s:4:"slug";s:8:"category";s:5:"count";i:571;}s:4:"feed";a:3:{s:4:"name";s:4:"feed";s:4:"slug";s:4:"feed";s:5:"count";i:569;}s:6:"search";a:3:{s:4:"name";s:6:"search";s:4:"slug";s:6:"search";s:5:"count";i:565;}s:9:"analytics";a:3:{s:4:"name";s:9:"analytics";s:4:"slug";s:9:"analytics";s:5:"count";i:561;}s:10:"e-commerce";a:3:{s:4:"name";s:10:"e-commerce";s:4:"slug";s:10:"e-commerce";s:5:"count";i:553;}s:4:"menu";a:3:{s:4:"name";s:4:"menu";s:4:"slug";s:4:"menu";s:5:"count";i:542;}s:5:"embed";a:3:{s:4:"name";s:5:"embed";s:4:"slug";s:5:"embed";s:5:"count";i:532;}s:10:"javascript";a:3:{s:4:"name";s:10:"javascript";s:4:"slug";s:10:"javascript";s:5:"count";i:526;}s:4:"link";a:3:{s:4:"name";s:4:"link";s:4:"slug";s:4:"link";s:5:"count";i:517;}s:4:"form";a:3:{s:4:"name";s:4:"form";s:4:"slug";s:4:"form";s:5:"count";i:510;}s:3:"css";a:3:{s:4:"name";s:3:"css";s:4:"slug";s:3:"css";s:5:"count";i:500;}s:5:"share";a:3:{s:4:"name";s:5:"share";s:4:"slug";s:5:"share";s:5:"count";i:492;}s:7:"comment";a:3:{s:4:"name";s:7:"comment";s:4:"slug";s:7:"comment";s:5:"count";i:485;}s:7:"youtube";a:3:{s:4:"name";s:7:"youtube";s:4:"slug";s:7:"youtube";s:5:"count";i:481;}s:5:"theme";a:3:{s:4:"name";s:5:"theme";s:4:"slug";s:5:"theme";s:5:"count";i:475;}s:10:"categories";a:3:{s:4:"name";s:10:"categories";s:4:"slug";s:10:"categories";s:5:"count";i:462;}s:6:"custom";a:3:{s:4:"name";s:6:"custom";s:4:"slug";s:6:"custom";s:5:"count";i:459;}s:9:"dashboard";a:3:{s:4:"name";s:9:"dashboard";s:4:"slug";s:9:"dashboard";s:5:"count";i:454;}s:10:"responsive";a:3:{s:4:"name";s:10:"responsive";s:4:"slug";s:10:"responsive";s:5:"count";i:453;}s:3:"ads";a:3:{s:4:"name";s:3:"ads";s:4:"slug";s:3:"ads";s:5:"count";i:438;}s:6:"button";a:3:{s:4:"name";s:6:"button";s:4:"slug";s:6:"button";s:5:"count";i:432;}s:4:"tags";a:3:{s:4:"name";s:4:"tags";s:4:"slug";s:4:"tags";s:5:"count";i:431;}s:9:"affiliate";a:3:{s:4:"name";s:9:"affiliate";s:4:"slug";s:9:"affiliate";s:5:"count";i:430;}s:6:"editor";a:3:{s:4:"name";s:6:"editor";s:4:"slug";s:6:"editor";s:5:"count";i:423;}s:5:"photo";a:3:{s:4:"name";s:5:"photo";s:4:"slug";s:5:"photo";s:5:"count";i:417;}s:4:"user";a:3:{s:4:"name";s:4:"user";s:4:"slug";s:4:"user";s:5:"count";i:408;}s:9:"slideshow";a:3:{s:4:"name";s:9:"slideshow";s:4:"slug";s:9:"slideshow";s:5:"count";i:402;}s:12:"contact-form";a:3:{s:4:"name";s:12:"contact form";s:4:"slug";s:12:"contact-form";s:5:"count";i:401;}s:6:"mobile";a:3:{s:4:"name";s:6:"mobile";s:4:"slug";s:6:"mobile";s:5:"count";i:400;}s:5:"stats";a:3:{s:4:"name";s:5:"stats";s:4:"slug";s:5:"stats";s:5:"count";i:398;}s:5:"users";a:3:{s:4:"name";s:5:"users";s:4:"slug";s:5:"users";s:5:"count";i:392;}s:7:"contact";a:3:{s:4:"name";s:7:"contact";s:4:"slug";s:7:"contact";s:5:"count";i:391;}s:6:"photos";a:3:{s:4:"name";s:6:"photos";s:4:"slug";s:6:"photos";s:5:"count";i:390;}s:10:"statistics";a:3:{s:4:"name";s:10:"statistics";s:4:"slug";s:10:"statistics";s:5:"count";i:373;}s:3:"api";a:3:{s:4:"name";s:3:"api";s:4:"slug";s:3:"api";s:5:"count";i:370;}s:10:"navigation";a:3:{s:4:"name";s:10:"navigation";s:4:"slug";s:10:"navigation";s:5:"count";i:361;}s:6:"events";a:3:{s:4:"name";s:6:"events";s:4:"slug";s:6:"events";s:5:"count";i:357;}s:4:"news";a:3:{s:4:"name";s:4:"news";s:4:"slug";s:4:"news";s:5:"count";i:348;}s:12:"social-media";a:3:{s:4:"name";s:12:"social media";s:4:"slug";s:12:"social-media";s:5:"count";i:331;}s:7:"plugins";a:3:{s:4:"name";s:7:"plugins";s:4:"slug";s:7:"plugins";s:5:"count";i:330;}s:8:"calendar";a:3:{s:4:"name";s:8:"calendar";s:4:"slug";s:8:"calendar";s:5:"count";i:330;}s:9:"multisite";a:3:{s:4:"name";s:9:"multisite";s:4:"slug";s:9:"multisite";s:5:"count";i:327;}s:10:"shortcodes";a:3:{s:4:"name";s:10:"shortcodes";s:4:"slug";s:10:"shortcodes";s:5:"count";i:321;}s:4:"code";a:3:{s:4:"name";s:4:"code";s:4:"slug";s:4:"code";s:5:"count";i:320;}s:4:"meta";a:3:{s:4:"name";s:4:"meta";s:4:"slug";s:4:"meta";s:5:"count";i:318;}s:4:"list";a:3:{s:4:"name";s:4:"list";s:4:"slug";s:4:"list";s:5:"count";i:317;}s:3:"url";a:3:{s:4:"name";s:3:"url";s:4:"slug";s:3:"url";s:5:"count";i:314;}s:10:"newsletter";a:3:{s:4:"name";s:10:"newsletter";s:4:"slug";s:10:"newsletter";s:5:"count";i:307;}s:7:"payment";a:3:{s:4:"name";s:7:"payment";s:4:"slug";s:7:"payment";s:5:"count";i:307;}s:6:"simple";a:3:{s:4:"name";s:6:"simple";s:4:"slug";s:6:"simple";s:5:"count";i:291;}s:3:"tag";a:3:{s:4:"name";s:3:"tag";s:4:"slug";s:3:"tag";s:5:"count";i:290;}s:5:"popup";a:3:{s:4:"name";s:5:"popup";s:4:"slug";s:5:"popup";s:5:"count";i:290;}s:9:"marketing";a:3:{s:4:"name";s:9:"marketing";s:4:"slug";s:9:"marketing";s:5:"count";i:287;}s:16:"custom-post-type";a:3:{s:4:"name";s:16:"custom post type";s:4:"slug";s:16:"custom-post-type";s:5:"count";i:285;}s:8:"redirect";a:3:{s:4:"name";s:8:"redirect";s:4:"slug";s:8:"redirect";s:5:"count";i:282;}s:4:"chat";a:3:{s:4:"name";s:4:"chat";s:4:"slug";s:4:"chat";s:5:"count";i:279;}s:11:"advertising";a:3:{s:4:"name";s:11:"advertising";s:4:"slug";s:11:"advertising";s:5:"count";i:279;}s:6:"author";a:3:{s:4:"name";s:6:"author";s:4:"slug";s:6:"author";s:5:"count";i:278;}s:4:"html";a:3:{s:4:"name";s:4:"html";s:4:"slug";s:4:"html";s:5:"count";i:270;}s:7:"adsense";a:3:{s:4:"name";s:7:"adsense";s:4:"slug";s:7:"adsense";s:5:"count";i:269;}s:5:"forms";a:3:{s:4:"name";s:5:"forms";s:4:"slug";s:5:"forms";s:5:"count";i:267;}s:8:"lightbox";a:3:{s:4:"name";s:8:"lightbox";s:4:"slug";s:8:"lightbox";s:5:"count";i:263;}s:14:"administration";a:3:{s:4:"name";s:14:"administration";s:4:"slug";s:14:"administration";s:5:"count";i:262;}s:7:"captcha";a:3:{s:4:"name";s:7:"captcha";s:4:"slug";s:7:"captcha";s:5:"count";i:262;}s:15:"payment-gateway";a:3:{s:4:"name";s:15:"payment gateway";s:4:"slug";s:15:"payment-gateway";s:5:"count";i:262;}s:12:"notification";a:3:{s:4:"name";s:12:"notification";s:4:"slug";s:12:"notification";s:5:"count";i:261;}s:7:"tinymce";a:3:{s:4:"name";s:7:"tinyMCE";s:4:"slug";s:7:"tinymce";s:5:"count";i:260;}}', 'no'),
(143, 'woocommerce_default_country', 'US:AL', 'yes'),
(144, 'woocommerce_allowed_countries', 'all', 'yes'),
(145, 'woocommerce_all_except_countries', '', 'yes'),
(146, 'woocommerce_specific_allowed_countries', '', 'yes'),
(147, 'woocommerce_ship_to_countries', '', 'yes'),
(148, 'woocommerce_specific_ship_to_countries', '', 'yes'),
(149, 'woocommerce_default_customer_address', 'geolocation', 'yes'),
(150, 'woocommerce_calc_taxes', 'no', 'yes'),
(151, 'woocommerce_demo_store', 'no', 'yes'),
(152, 'woocommerce_demo_store_notice', 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'no'),
(153, 'woocommerce_currency', 'USD', 'yes'),
(154, 'woocommerce_currency_pos', 'left', 'yes'),
(155, 'woocommerce_price_thousand_sep', ',', 'yes'),
(156, 'woocommerce_price_decimal_sep', '.', 'yes'),
(157, 'woocommerce_price_num_decimals', '2', 'yes'),
(158, 'woocommerce_weight_unit', 'lbs', 'yes'),
(159, 'woocommerce_dimension_unit', 'in', 'yes'),
(160, 'woocommerce_enable_review_rating', 'yes', 'yes'),
(161, 'woocommerce_review_rating_required', 'yes', 'no'),
(162, 'woocommerce_review_rating_verification_label', 'yes', 'no'),
(163, 'woocommerce_review_rating_verification_required', 'no', 'no'),
(164, 'woocommerce_shop_page_id', '4', 'yes'),
(165, 'woocommerce_shop_page_display', '', 'yes'),
(166, 'woocommerce_category_archive_display', '', 'yes'),
(167, 'woocommerce_default_catalog_orderby', 'menu_order', 'yes'),
(168, 'woocommerce_cart_redirect_after_add', 'no', 'yes'),
(169, 'woocommerce_enable_ajax_add_to_cart', 'yes', 'yes'),
(170, 'shop_catalog_image_size', 'a:3:{s:5:"width";s:3:"300";s:6:"height";s:3:"300";s:4:"crop";i:1;}', 'yes'),
(171, 'shop_single_image_size', 'a:3:{s:5:"width";s:3:"600";s:6:"height";s:3:"600";s:4:"crop";i:1;}', 'yes'),
(172, 'shop_thumbnail_image_size', 'a:3:{s:5:"width";s:3:"180";s:6:"height";s:3:"180";s:4:"crop";i:1;}', 'yes'),
(173, 'woocommerce_manage_stock', 'yes', 'yes'),
(174, 'woocommerce_hold_stock_minutes', '60', 'no'),
(175, 'woocommerce_notify_low_stock', 'yes', 'no'),
(176, 'woocommerce_notify_no_stock', 'yes', 'no'),
(177, 'woocommerce_stock_email_recipient', 'dev@dev.com', 'no'),
(178, 'woocommerce_notify_low_stock_amount', '2', 'no'),
(179, 'woocommerce_notify_no_stock_amount', '0', 'yes'),
(180, 'woocommerce_hide_out_of_stock_items', 'no', 'yes'),
(181, 'woocommerce_stock_format', '', 'yes'),
(182, 'woocommerce_file_download_method', 'force', 'no'),
(183, 'woocommerce_downloads_require_login', 'no', 'no'),
(184, 'woocommerce_downloads_grant_access_after_payment', 'yes', 'no'),
(185, 'woocommerce_prices_include_tax', 'no', 'yes'),
(186, 'woocommerce_tax_based_on', 'shipping', 'yes'),
(187, 'woocommerce_shipping_tax_class', 'inherit', 'yes'),
(188, 'woocommerce_tax_round_at_subtotal', 'no', 'yes'),
(189, 'woocommerce_tax_classes', 'Reduced rate\nZero rate', 'yes'),
(190, 'woocommerce_tax_display_shop', 'excl', 'yes'),
(191, 'woocommerce_tax_display_cart', 'excl', 'no'),
(192, 'woocommerce_price_display_suffix', '', 'yes'),
(193, 'woocommerce_tax_total_display', 'itemized', 'no'),
(194, 'woocommerce_enable_shipping_calc', 'yes', 'no'),
(195, 'woocommerce_shipping_cost_requires_address', 'no', 'no'),
(196, 'woocommerce_ship_to_destination', 'billing', 'no'),
(197, 'woocommerce_shipping_debug_mode', 'no', 'no'),
(198, 'woocommerce_enable_coupons', 'yes', 'yes'),
(199, 'woocommerce_calc_discounts_sequentially', 'no', 'no'),
(200, 'woocommerce_enable_guest_checkout', 'yes', 'no'),
(201, 'woocommerce_force_ssl_checkout', 'no', 'yes'),
(202, 'woocommerce_unforce_ssl_checkout', 'no', 'yes'),
(203, 'woocommerce_cart_page_id', '5', 'yes'),
(204, 'woocommerce_checkout_page_id', '6', 'yes'),
(205, 'woocommerce_terms_page_id', '', 'no'),
(206, 'woocommerce_checkout_pay_endpoint', 'order-pay', 'yes'),
(207, 'woocommerce_checkout_order_received_endpoint', 'order-received', 'yes'),
(208, 'woocommerce_myaccount_add_payment_method_endpoint', 'add-payment-method', 'yes'),
(209, 'woocommerce_myaccount_delete_payment_method_endpoint', 'delete-payment-method', 'yes'),
(210, 'woocommerce_myaccount_set_default_payment_method_endpoint', 'set-default-payment-method', 'yes'),
(211, 'woocommerce_myaccount_page_id', '7', 'yes'),
(212, 'woocommerce_enable_signup_and_login_from_checkout', 'yes', 'no'),
(213, 'woocommerce_enable_myaccount_registration', 'no', 'no'),
(214, 'woocommerce_enable_checkout_login_reminder', 'yes', 'no'),
(215, 'woocommerce_registration_generate_username', 'yes', 'no'),
(216, 'woocommerce_registration_generate_password', 'no', 'no'),
(217, 'woocommerce_myaccount_orders_endpoint', 'orders', 'yes'),
(218, 'woocommerce_myaccount_view_order_endpoint', 'view-order', 'yes'),
(219, 'woocommerce_myaccount_downloads_endpoint', 'downloads', 'yes'),
(220, 'woocommerce_myaccount_edit_account_endpoint', 'edit-account', 'yes'),
(221, 'woocommerce_myaccount_edit_address_endpoint', 'edit-address', 'yes'),
(222, 'woocommerce_myaccount_payment_methods_endpoint', 'payment-methods', 'yes'),
(223, 'woocommerce_myaccount_lost_password_endpoint', 'lost-password', 'yes'),
(224, 'woocommerce_logout_endpoint', 'customer-logout', 'yes'),
(225, 'woocommerce_email_from_name', 'sandbox', 'no'),
(226, 'woocommerce_email_from_address', 'dev@dev.com', 'no'),
(227, 'woocommerce_email_header_image', '', 'no'),
(228, 'woocommerce_email_footer_text', 'sandbox - Powered by WooCommerce', 'no'),
(229, 'woocommerce_email_base_color', '#96588a', 'no'),
(230, 'woocommerce_email_background_color', '#f7f7f7', 'no'),
(231, 'woocommerce_email_body_background_color', '#ffffff', 'no'),
(232, 'woocommerce_email_text_color', '#3c3c3c', 'no'),
(233, 'woocommerce_api_enabled', 'yes', 'yes'),
(237, 'woocommerce_db_version', '3.0.5', 'yes'),
(238, 'woocommerce_version', '3.0.5', 'yes'),
(239, 'recently_activated', 'a:1:{s:30:"advanced-custom-fields/acf.php";i:1493660655;}', 'yes'),
(240, 'woocommerce_admin_notices', 'a:1:{i:2;s:19:"no_shipping_methods";}', 'yes'),
(242, '_transient_woocommerce_webhook_ids', 'a:0:{}', 'yes'),
(243, 'widget_woocommerce_widget_cart', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(244, 'widget_woocommerce_layered_nav_filters', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(245, 'widget_woocommerce_layered_nav', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(246, 'widget_woocommerce_price_filter', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(247, 'widget_woocommerce_product_categories', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(248, 'widget_woocommerce_product_search', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(249, 'widget_woocommerce_product_tag_cloud', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(250, 'widget_woocommerce_products', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(251, 'widget_woocommerce_rating_filter', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(252, 'widget_woocommerce_recent_reviews', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(253, 'widget_woocommerce_recently_viewed_products', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(254, 'widget_woocommerce_top_rated_products', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
(255, '_transient_wc_attribute_taxonomies', 'a:0:{}', 'yes'),
(257, '_transient_wc_count_comments', 'O:8:"stdClass":7:{s:8:"approved";s:1:"1";s:14:"total_comments";i:1;s:3:"all";i:1;s:9:"moderated";i:0;s:4:"spam";i:0;s:5:"trash";i:0;s:12:"post-trashed";i:0;}', 'yes'),
(258, 'woocommerce_meta_box_errors', 'a:0:{}', 'yes'),
(260, '_transient_timeout_geoip_::1', '1494227228', 'no'),
(261, '_transient_geoip_::1', '', 'no'),
(262, '_transient_timeout_external_ip_address_::1', '1494227228', 'no'),
(263, '_transient_external_ip_address_::1', '24.209.146.93', 'no'),
(264, '_transient_timeout_geoip_24.209.146.93', '1494227228', 'no'),
(265, '_transient_geoip_24.209.146.93', 'US', 'no'),
(266, 'woocommerce_paypal-braintree_settings', 'a:1:{s:7:"enabled";s:2:"no";}', 'yes'),
(267, 'woocommerce_stripe_settings', 'a:1:{s:7:"enabled";s:2:"no";}', 'yes'),
(268, 'woocommerce_paypal_settings', 'a:2:{s:7:"enabled";s:2:"no";s:5:"email";s:11:"dev@dev.com";}', 'yes'),
(269, 'woocommerce_cheque_settings', 'a:1:{s:7:"enabled";s:2:"no";}', 'yes'),
(270, 'woocommerce_bacs_settings', 'a:1:{s:7:"enabled";s:2:"no";}', 'yes'),
(271, 'woocommerce_cod_settings', 'a:1:{s:7:"enabled";s:2:"no";}', 'yes'),
(272, 'woocommerce_allow_tracking', 'no', 'yes'),
(273, '_transient_shipping-transient-version', '1493622450', 'yes'),
(274, '_transient_timeout_wc_shipping_method_count_0_1493622450', '1496214450', 'no'),
(275, '_transient_wc_shipping_method_count_0_1493622450', '0', 'no'),
(280, 'product_cat_children', 'a:0:{}', 'yes'),
(281, '_transient_product_query-transient-version', '1493622753', 'yes'),
(282, '_transient_product-transient-version', '1493622753', 'yes'),
(283, 'duplicate_post_copytitle', '1', 'yes'),
(284, 'duplicate_post_copydate', '1', 'yes'),
(285, 'duplicate_post_copystatus', '1', 'yes'),
(286, 'duplicate_post_copyslug', '1', 'yes'),
(287, 'duplicate_post_copyexcerpt', '1', 'yes'),
(288, 'duplicate_post_copycontent', '1', 'yes'),
(289, 'duplicate_post_copythumbnail', '1', 'yes'),
(290, 'duplicate_post_copytemplate', '1', 'yes'),
(291, 'duplicate_post_copyformat', '1', 'yes'),
(292, 'duplicate_post_copyauthor', '', 'yes'),
(293, 'duplicate_post_copypassword', '', 'yes'),
(294, 'duplicate_post_copyattachments', '', 'yes'),
(295, 'duplicate_post_copychildren', '', 'yes'),
(296, 'duplicate_post_copycomments', '', 'yes'),
(297, 'duplicate_post_copymenuorder', '1', 'yes'),
(298, 'duplicate_post_taxonomies_blacklist', '', 'yes'),
(299, 'duplicate_post_blacklist', '', 'yes'),
(300, 'duplicate_post_types_enabled', 'a:8:{i:0;s:4:"post";i:1;s:4:"page";i:2;s:15:"acf-field-group";i:3;s:7:"product";i:4;s:10:"shop_order";i:5;s:11:"shop_coupon";i:6;s:4:"part";i:7;s:8:"assembly";}', 'yes'),
(301, 'duplicate_post_show_row', '1', 'yes'),
(302, 'duplicate_post_show_adminbar', '1', 'yes'),
(303, 'duplicate_post_show_submitbox', '1', 'yes'),
(304, 'duplicate_post_show_bulkactions', '1', 'yes'),
(305, 'duplicate_post_version', '3.2', 'no'),
(306, 'duplicate_post_show_notice', '1', 'no'),
(307, 'duplicate_post_title_prefix', '', 'yes'),
(308, 'duplicate_post_title_suffix', '', 'yes'),
(309, 'duplicate_post_increase_menu_order_by', '', 'yes'),
(310, 'duplicate_post_roles', 'a:2:{i:0;s:13:"administrator";i:1;s:6:"editor";}', 'yes'),
(338, '_transient_timeout_wc_report_sales_by_date', '1493747413', 'no'),
(339, '_transient_wc_report_sales_by_date', 'a:64:{s:32:"71c9c1bed432b666ea06dacfce300849";a:0:{}s:32:"ad79bcf651eb6995cb132706bcd01cf4";a:0:{}s:32:"d29b53bcb7b75634160435b5740cac87";a:0:{}s:32:"6d350430aaaacd07a439eb14ee7a8fa3";N;s:32:"40e5b39a7884b522ce8edd45b998d4b4";a:0:{}s:32:"31e63dadee3bf4b7ca4487c0a4288ad6";a:0:{}s:32:"5d8aa6fc66b531414181d27760272c4b";a:0:{}s:32:"188f410f86627dd224155130b2768da5";a:0:{}s:32:"feeff71eab6ea6152f259931ad44041c";a:0:{}s:32:"7cac4fc8034db9877b299c66ff7d932d";a:0:{}s:32:"99db0ef6948bfd67f2bdaafa44710361";a:0:{}s:32:"be1fd50458e0dd480fd9145dfc95735e";N;s:32:"66085ec6a161a6c0378a66b4d8a34b94";a:0:{}s:32:"3404343552e5cb9ab3744ab8f2c6d9e2";a:0:{}s:32:"20a98aeb2382bc20bb8ad058135bc006";a:0:{}s:32:"f19b388958170d8bd15d723736a26663";a:0:{}s:32:"9b6531b9d5a4a41ce30b27a0e2f5f068";a:0:{}s:32:"e9c2cb430352bc08b41b08601c1c1b80";a:0:{}s:32:"cc09afd1888922377981bef0d5f269c5";a:0:{}s:32:"9599262c04a292b0ccc5dff1ecd08318";N;s:32:"21cbb391e68322e917610631c8bdeef4";a:0:{}s:32:"9ff59121c3cf50da60163924de246e7a";a:0:{}s:32:"3566f60764ea77b83e3ece35dca339a5";a:0:{}s:32:"c6a1f2953df6392e37eb4b2e84084a19";a:0:{}s:32:"2922250e46694c8bcd6b658c26fe78cc";a:0:{}s:32:"96c3b1ee05c955adaad5df6f8270b9d6";a:0:{}s:32:"3cb8f7ae392acdd99718f096387a8ad7";a:0:{}s:32:"0a363d7de5e6627af75562d8d3957a0b";N;s:32:"8286bd249ac7a358059f3e872cec4b24";a:0:{}s:32:"81f229e1a20b1d6f91ea1a1983f7a439";a:0:{}s:32:"2b9f1598b42451af1bf5e3135e0949f8";a:0:{}s:32:"f0ac9b23d4a463d40020b4ef621ed946";a:0:{}s:32:"a4e0bc8114f6ba79328cdba596cd0b3d";a:0:{}s:32:"6e76081b6cb4e33166fa8ca8cf6d598c";a:0:{}s:32:"0b1ef026a551a65351fab375925860fb";a:0:{}s:32:"5257265cbf0ed8515beb26bdaaed3fae";N;s:32:"adf8662a0603e13a29146daa5474f711";a:0:{}s:32:"4adbd9ab21d42219466ff39e5a8703ca";a:0:{}s:32:"cca760d879b296f211338ba0ea9ed438";a:0:{}s:32:"1a65cc89dc98fadde793a51c3c318d29";a:0:{}s:32:"63c57c06d8650ec23bdcd881d42ad372";a:0:{}s:32:"898fe34709cd20d77d8dd05a2f7818c9";a:0:{}s:32:"965bc4ddf1516650a5b55d6869949f0b";a:0:{}s:32:"13d7d47d89a1a6d279b187bdefa374fe";N;s:32:"97d693c9d89e3491413dedf77cae113c";a:0:{}s:32:"1103a99d29c8fe4ed67bfc7da702c776";a:0:{}s:32:"9c8c8b91d0adf95c3afa6ca4e17f6618";a:0:{}s:32:"214af6043ddecc094f1dba3820c8b383";a:0:{}s:32:"9020375a3fb1db4b8e5207166cda221c";a:0:{}s:32:"1d98f1a6dbedaadd2639d6bc49955bbe";a:0:{}s:32:"3d71970b34b815ccc313fe99314ea10f";a:0:{}s:32:"b7dcaf517a03385e4c5c32272f227798";N;s:32:"7c8ed8be660d28501a336708dcd58915";a:0:{}s:32:"287ac7a94afce00cd6687acea64a2a50";a:0:{}s:32:"55b4595c8d230e8910abd8aba007f4ee";a:0:{}s:32:"21f2424307bce379eb1b90c4582f657d";a:0:{}s:32:"d54fc5e2c0d7ac5319f575dc89a07bda";a:0:{}s:32:"fa7813f97d6b2319587798366f1a538e";a:0:{}s:32:"c2594eb5c9d52d270755174381c07216";a:0:{}s:32:"d850f8a00d6ce2afc34c6508df4edb24";N;s:32:"7e57a71234da8476f0fe4aaeb8df1973";a:0:{}s:32:"23dd017f2355c788d80f732592e5c8b0";a:0:{}s:32:"873fdbd676eba2c7a623f5f3c9152385";a:0:{}s:32:"a70e2ed024837e477a482fcf91632d4f";a:0:{}}', 'no'),
(340, '_transient_timeout_wc_admin_report', '1493710202', 'no'),
(341, '_transient_wc_admin_report', 'a:1:{s:32:"faba5188d6eee913c75ba950a72db20d";a:0:{}}', 'no'),
(342, '_transient_timeout_wc_low_stock_count', '1496215802', 'no'),
(343, '_transient_wc_low_stock_count', '0', 'no'),
(344, '_transient_timeout_wc_outofstock_count', '1496215802', 'no'),
(345, '_transient_wc_outofstock_count', '0', 'no'),
(346, 'wco_2_selector_1', '6', 'yes'),
(347, 'wco_2_selector_1_text', '', 'yes'),
(348, 'wco_2_selector_1_obj', '', 'yes'),
(349, 'wco_2_background_position_1', '', 'yes'),
(350, 'wco_2_background_color_1', '', 'yes'),
(351, 'wco_2_background_repeat_1', 'no-repeat', 'yes'),
(352, 'wco_2_image_opacity_1', '', 'yes'),
(353, 'wco_2_image_url_1', '', 'yes'),
(354, 'wco_2_selector_2', '10', 'yes'),
(355, 'wco_2_selector_2_text', '', 'yes'),
(356, 'wco_2_selector_2_obj', '', 'yes'),
(357, 'wco_2_background_position_2', '', 'yes'),
(358, 'wco_2_background_color_2', '', 'yes'),
(359, 'wco_2_background_repeat_2', 'no-repeat', 'yes'),
(360, 'wco_2_image_opacity_2', '', 'yes'),
(361, 'wco_2_image_url_2', '', 'yes'),
(366, '_transient_woocommerce_cache_excluded_uris', 'a:6:{i:0;s:3:"p=5";i:1;s:6:"/cart/";i:2;s:3:"p=6";i:3;s:10:"/checkout/";i:4;s:3:"p=7";i:5;s:12:"/my-account/";}', 'yes'),
(368, 'wco_2_classes', 'a:17:{i:0;s:4:"four";i:1;s:3:"one";i:2;s:5:"three";i:3;s:3:"two";i:4;s:6:"post-8";i:5;s:7:"post-44";i:6;s:7:"post-45";i:7;s:7:"post-47";i:8;s:18:"has-post-thumbnail";i:9;s:12:"downloadable";i:10;s:7:"virtual";i:11;s:16:"shipping-taxable";i:12;s:11:"purchasable";i:13;s:21:"product-type-variable";i:14;s:12:"has-children";i:15;s:7:"instock";i:16;s:10:"outofstock";}', 'yes'),
(374, 'wco_options', 'a:2:{s:4:"init";b:1;s:7:"upgrade";b:0;}', 'yes'),
(378, '_site_transient_timeout_theme_roots', '1493631886', 'no'),
(379, '_site_transient_theme_roots', 'a:4:{s:10:"storefront";s:7:"/themes";s:13:"twentyfifteen";s:7:"/themes";s:15:"twentyseventeen";s:7:"/themes";s:13:"twentysixteen";s:7:"/themes";}', 'no'),
(380, '_site_transient_update_plugins', 'O:8:"stdClass":5:{s:12:"last_checked";i:1493659636;s:7:"checked";a:4:{s:30:"advanced-custom-fields/acf.php";s:6:"4.4.11";s:33:"duplicate-post/duplicate-post.php";s:3:"3.2";s:17:"wc-bom/wc-bom.php";s:5:"1.0.0";s:27:"woocommerce/woocommerce.php";s:5:"3.0.5";}s:8:"response";a:0:{}s:12:"translations";a:0:{}s:9:"no_update";a:3:{s:30:"advanced-custom-fields/acf.php";O:8:"stdClass":6:{s:2:"id";s:5:"21367";s:4:"slug";s:22:"advanced-custom-fields";s:6:"plugin";s:30:"advanced-custom-fields/acf.php";s:11:"new_version";s:6:"4.4.11";s:3:"url";s:53:"https://wordpress.org/plugins/advanced-custom-fields/";s:7:"package";s:72:"https://downloads.wordpress.org/plugin/advanced-custom-fields.4.4.11.zip";}s:33:"duplicate-post/duplicate-post.php";O:8:"stdClass":7:{s:2:"id";s:4:"1295";s:4:"slug";s:14:"duplicate-post";s:6:"plugin";s:33:"duplicate-post/duplicate-post.php";s:11:"new_version";s:3:"3.2";s:3:"url";s:45:"https://wordpress.org/plugins/duplicate-post/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/duplicate-post.3.2.zip";s:14:"upgrade_notice";s:48:"new website + WPML compatibility + various fixes";}s:27:"woocommerce/woocommerce.php";O:8:"stdClass":7:{s:2:"id";s:5:"25331";s:4:"slug";s:11:"woocommerce";s:6:"plugin";s:27:"woocommerce/woocommerce.php";s:11:"new_version";s:5:"3.0.5";s:3:"url";s:42:"https://wordpress.org/plugins/woocommerce/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/woocommerce.3.0.5.zip";s:14:"upgrade_notice";s:132:"3.0 is a major update. Make a full site backup, update your theme and extensions, and review update best practices before upgrading.";}}}', 'no'),
(383, 'part-category_children', 'a:0:{}', 'yes'),
(388, 'inventory-category_children', 'a:0:{}', 'yes'),
(389, 'wc_bom_options', 'a:1:{s:4:"init";b:1;}', 'yes'),
(390, 'wc_bom_settings', 'a:1:{s:5:"setup";b:0;}', 'yes'),
(393, '_transient_timeout_wc_featured_products', '1496230644', 'no'),
(394, '_transient_wc_featured_products', 'a:0:{}', 'no'),
(395, '_transient_timeout_wc_products_onsale', '1496230644', 'no'),
(396, '_transient_wc_products_onsale', 'a:0:{}', 'no'),
(397, '_transient_timeout_wc_loopde021493622753', '1496230644', 'no'),
(398, '_transient_wc_loopde021493622753', 'O:8:"WP_Query":49:{s:5:"query";a:8:{s:9:"post_type";s:7:"product";s:11:"post_status";s:7:"publish";s:19:"ignore_sticky_posts";i:1;s:14:"posts_per_page";s:1:"2";s:7:"orderby";s:4:"date";s:5:"order";s:4:"desc";s:10:"meta_query";a:0:{}s:9:"tax_query";a:1:{i:0;a:4:{s:8:"taxonomy";s:18:"product_visibility";s:5:"field";s:16:"term_taxonomy_id";s:5:"terms";a:1:{i:0;i:7;}s:8:"operator";s:6:"NOT IN";}}}s:10:"query_vars";a:68:{s:9:"post_type";s:7:"product";s:11:"post_status";s:7:"publish";s:19:"ignore_sticky_posts";i:1;s:14:"posts_per_page";i:2;s:7:"orderby";s:4:"date";s:5:"order";s:4:"DESC";s:10:"meta_query";a:0:{}s:9:"tax_query";a:1:{i:0;a:4:{s:8:"taxonomy";s:18:"product_visibility";s:5:"field";s:16:"term_taxonomy_id";s:5:"terms";a:1:{i:0;i:7;}s:8:"operator";s:6:"NOT IN";}}s:5:"error";s:0:"";s:1:"m";s:0:"";s:1:"p";i:0;s:11:"post_parent";s:0:"";s:7:"subpost";s:0:"";s:10:"subpost_id";s:0:"";s:10:"attachment";s:0:"";s:13:"attachment_id";i:0;s:4:"name";s:0:"";s:6:"static";s:0:"";s:8:"pagename";s:0:"";s:7:"page_id";i:0;s:6:"second";s:0:"";s:6:"minute";s:0:"";s:4:"hour";s:0:"";s:3:"day";i:0;s:8:"monthnum";i:0;s:4:"year";i:0;s:1:"w";i:0;s:13:"category_name";s:0:"";s:3:"tag";s:0:"";s:3:"cat";s:0:"";s:6:"tag_id";s:0:"";s:6:"author";s:0:"";s:11:"author_name";s:0:"";s:4:"feed";s:0:"";s:2:"tb";s:0:"";s:5:"paged";i:0;s:8:"meta_key";s:0:"";s:10:"meta_value";s:0:"";s:7:"preview";s:0:"";s:1:"s";s:0:"";s:8:"sentence";s:0:"";s:5:"title";s:0:"";s:6:"fields";s:0:"";s:10:"menu_order";s:0:"";s:5:"embed";s:0:"";s:12:"category__in";a:0:{}s:16:"category__not_in";a:0:{}s:13:"category__and";a:0:{}s:8:"post__in";a:0:{}s:12:"post__not_in";a:0:{}s:13:"post_name__in";a:0:{}s:7:"tag__in";a:0:{}s:11:"tag__not_in";a:0:{}s:8:"tag__and";a:0:{}s:12:"tag_slug__in";a:0:{}s:13:"tag_slug__and";a:0:{}s:15:"post_parent__in";a:0:{}s:19:"post_parent__not_in";a:0:{}s:10:"author__in";a:0:{}s:14:"author__not_in";a:0:{}s:16:"suppress_filters";b:0;s:13:"cache_results";b:1;s:22:"update_post_term_cache";b:1;s:19:"lazy_load_term_meta";b:1;s:22:"update_post_meta_cache";b:1;s:8:"nopaging";b:0;s:17:"comments_per_page";s:2:"50";s:13:"no_found_rows";b:0;}s:9:"tax_query";O:12:"WP_Tax_Query":6:{s:7:"queries";a:1:{i:0;a:5:{s:8:"taxonomy";s:18:"product_visibility";s:5:"terms";a:1:{i:0;i:7;}s:5:"field";s:16:"term_taxonomy_id";s:8:"operator";s:6:"NOT IN";s:16:"include_children";b:1;}}s:8:"relation";s:3:"AND";s:16:"\0*\0table_aliases";a:0:{}s:13:"queried_terms";a:0:{}s:13:"primary_table";s:8:"wp_posts";s:17:"primary_id_column";s:2:"ID";}s:10:"meta_query";O:13:"WP_Meta_Query":9:{s:7:"queries";a:0:{}s:8:"relation";N;s:10:"meta_table";N;s:14:"meta_id_column";N;s:13:"primary_table";N;s:17:"primary_id_column";N;s:16:"\0*\0table_aliases";a:0:{}s:10:"\0*\0clauses";a:0:{}s:18:"\0*\0has_or_relation";b:0;}s:10:"date_query";b:0;s:7:"request";s:329:"SELECT SQL_CALC_FOUND_ROWS  wp_posts.ID FROM wp_posts  WHERE 1=1  AND ( \n  wp_posts.ID NOT IN (\n				SELECT object_id\n				FROM wp_term_relationships\n				WHERE term_taxonomy_id IN (7)\n			)\n) AND wp_posts.post_type = ''product'' AND ((wp_posts.post_status = ''publish'')) GROUP BY wp_posts.ID ORDER BY wp_posts.post_date DESC LIMIT 0, 2";s:5:"posts";a:2:{i:0;O:7:"WP_Post":24:{s:2:"ID";i:47;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2017-05-01 07:12:27";s:13:"post_date_gmt";s:19:"2017-05-01 07:12:27";s:12:"post_content";s:0:"";s:10:"post_title";s:29:"prod one (Copy) (Copy) (Copy)";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:4:"open";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:23:"prod-one-copy-copy-copy";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2017-05-01 07:12:33";s:17:"post_modified_gmt";s:19:"2017-05-01 07:12:33";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:51:"http://www.sandbox.dev/?post_type=product&#038;p=47";s:10:"menu_order";i:0;s:9:"post_type";s:7:"product";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}i:1;O:7:"WP_Post":24:{s:2:"ID";i:45;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2017-05-01 07:12:07";s:13:"post_date_gmt";s:19:"2017-05-01 07:12:07";s:12:"post_content";s:0:"";s:10:"post_title";s:22:"prod one (Copy) (Copy)";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:4:"open";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:18:"prod-one-copy-copy";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2017-05-01 07:12:22";s:17:"post_modified_gmt";s:19:"2017-05-01 07:12:22";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:51:"http://www.sandbox.dev/?post_type=product&#038;p=45";s:10:"menu_order";i:0;s:9:"post_type";s:7:"product";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}}s:10:"post_count";i:2;s:12:"current_post";i:-1;s:11:"in_the_loop";b:0;s:4:"post";r:119;s:13:"comment_count";i:0;s:15:"current_comment";i:-1;s:11:"found_posts";s:1:"4";s:13:"max_num_pages";d:2;s:21:"max_num_comment_pages";i:0;s:9:"is_single";b:0;s:10:"is_preview";b:0;s:7:"is_page";b:0;s:10:"is_archive";b:1;s:7:"is_date";b:0;s:7:"is_year";b:0;s:8:"is_month";b:0;s:6:"is_day";b:0;s:7:"is_time";b:0;s:9:"is_author";b:0;s:11:"is_category";b:0;s:6:"is_tag";b:0;s:6:"is_tax";b:0;s:9:"is_search";b:0;s:7:"is_feed";b:0;s:15:"is_comment_feed";b:0;s:12:"is_trackback";b:0;s:7:"is_home";b:0;s:6:"is_404";b:0;s:8:"is_embed";b:0;s:8:"is_paged";b:0;s:8:"is_admin";b:0;s:13:"is_attachment";b:0;s:11:"is_singular";b:0;s:9:"is_robots";b:0;s:13:"is_posts_page";b:0;s:20:"is_post_type_archive";b:1;s:25:"\0WP_Query\0query_vars_hash";s:32:"66e32a2a05cc0dadaf167bd0f45b5de5";s:28:"\0WP_Query\0query_vars_changed";b:0;s:17:"thumbnails_cached";b:0;s:19:"\0WP_Query\0stopwords";N;s:23:"\0WP_Query\0compat_fields";a:2:{i:0;s:15:"query_vars_hash";i:1;s:18:"query_vars_changed";}s:24:"\0WP_Query\0compat_methods";a:2:{i:0;s:16:"init_query_flags";i:1;s:15:"parse_tax_query";}}', 'no'),
(399, '_transient_timeout_wc_term_counts', '1496230644', 'no'),
(400, '_transient_wc_term_counts', 'a:4:{i:18;s:1:"4";i:15;s:1:"4";i:17;s:1:"4";i:16;s:1:"4";}', 'no'),
(401, '_transient_timeout_wc_loop62341493622753', '1496230644', 'no'),
(402, '_transient_wc_loop62341493622753', 'O:8:"WP_Query":49:{s:5:"query";a:8:{s:9:"post_type";s:7:"product";s:11:"post_status";s:7:"publish";s:19:"ignore_sticky_posts";i:1;s:14:"posts_per_page";i:4;s:8:"meta_key";s:11:"total_sales";s:7:"orderby";s:14:"meta_value_num";s:10:"meta_query";a:0:{}s:9:"tax_query";a:1:{i:0;a:4:{s:8:"taxonomy";s:18:"product_visibility";s:5:"field";s:16:"term_taxonomy_id";s:5:"terms";a:1:{i:0;i:7;}s:8:"operator";s:6:"NOT IN";}}}s:10:"query_vars";a:68:{s:9:"post_type";s:7:"product";s:11:"post_status";s:7:"publish";s:19:"ignore_sticky_posts";i:1;s:14:"posts_per_page";i:4;s:8:"meta_key";s:11:"total_sales";s:7:"orderby";s:14:"meta_value_num";s:10:"meta_query";a:0:{}s:9:"tax_query";a:1:{i:0;a:4:{s:8:"taxonomy";s:18:"product_visibility";s:5:"field";s:16:"term_taxonomy_id";s:5:"terms";a:1:{i:0;i:7;}s:8:"operator";s:6:"NOT IN";}}s:5:"error";s:0:"";s:1:"m";s:0:"";s:1:"p";i:0;s:11:"post_parent";s:0:"";s:7:"subpost";s:0:"";s:10:"subpost_id";s:0:"";s:10:"attachment";s:0:"";s:13:"attachment_id";i:0;s:4:"name";s:0:"";s:6:"static";s:0:"";s:8:"pagename";s:0:"";s:7:"page_id";i:0;s:6:"second";s:0:"";s:6:"minute";s:0:"";s:4:"hour";s:0:"";s:3:"day";i:0;s:8:"monthnum";i:0;s:4:"year";i:0;s:1:"w";i:0;s:13:"category_name";s:0:"";s:3:"tag";s:0:"";s:3:"cat";s:0:"";s:6:"tag_id";s:0:"";s:6:"author";s:0:"";s:11:"author_name";s:0:"";s:4:"feed";s:0:"";s:2:"tb";s:0:"";s:5:"paged";i:0;s:10:"meta_value";s:0:"";s:7:"preview";s:0:"";s:1:"s";s:0:"";s:8:"sentence";s:0:"";s:5:"title";s:0:"";s:6:"fields";s:0:"";s:10:"menu_order";s:0:"";s:5:"embed";s:0:"";s:12:"category__in";a:0:{}s:16:"category__not_in";a:0:{}s:13:"category__and";a:0:{}s:8:"post__in";a:0:{}s:12:"post__not_in";a:0:{}s:13:"post_name__in";a:0:{}s:7:"tag__in";a:0:{}s:11:"tag__not_in";a:0:{}s:8:"tag__and";a:0:{}s:12:"tag_slug__in";a:0:{}s:13:"tag_slug__and";a:0:{}s:15:"post_parent__in";a:0:{}s:19:"post_parent__not_in";a:0:{}s:10:"author__in";a:0:{}s:14:"author__not_in";a:0:{}s:16:"suppress_filters";b:0;s:13:"cache_results";b:1;s:22:"update_post_term_cache";b:1;s:19:"lazy_load_term_meta";b:1;s:22:"update_post_meta_cache";b:1;s:8:"nopaging";b:0;s:17:"comments_per_page";s:2:"50";s:13:"no_found_rows";b:0;s:5:"order";s:4:"DESC";}s:9:"tax_query";O:12:"WP_Tax_Query":6:{s:7:"queries";a:1:{i:0;a:5:{s:8:"taxonomy";s:18:"product_visibility";s:5:"terms";a:1:{i:0;i:7;}s:5:"field";s:16:"term_taxonomy_id";s:8:"operator";s:6:"NOT IN";s:16:"include_children";b:1;}}s:8:"relation";s:3:"AND";s:16:"\0*\0table_aliases";a:0:{}s:13:"queried_terms";a:0:{}s:13:"primary_table";s:8:"wp_posts";s:17:"primary_id_column";s:2:"ID";}s:10:"meta_query";O:13:"WP_Meta_Query":9:{s:7:"queries";a:2:{i:0;a:1:{s:3:"key";s:11:"total_sales";}s:8:"relation";s:2:"OR";}s:8:"relation";s:3:"AND";s:10:"meta_table";s:11:"wp_postmeta";s:14:"meta_id_column";s:7:"post_id";s:13:"primary_table";s:8:"wp_posts";s:17:"primary_id_column";s:2:"ID";s:16:"\0*\0table_aliases";a:1:{i:0;s:11:"wp_postmeta";}s:10:"\0*\0clauses";a:1:{s:11:"wp_postmeta";a:4:{s:3:"key";s:11:"total_sales";s:7:"compare";s:1:"=";s:5:"alias";s:11:"wp_postmeta";s:4:"cast";s:4:"CHAR";}}s:18:"\0*\0has_or_relation";b:0;}s:10:"date_query";b:0;s:7:"request";s:447:"SELECT SQL_CALC_FOUND_ROWS  wp_posts.ID FROM wp_posts  INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id ) WHERE 1=1  AND ( \n  wp_posts.ID NOT IN (\n				SELECT object_id\n				FROM wp_term_relationships\n				WHERE term_taxonomy_id IN (7)\n			)\n) AND ( \n  wp_postmeta.meta_key = ''total_sales''\n) AND wp_posts.post_type = ''product'' AND ((wp_posts.post_status = ''publish'')) GROUP BY wp_posts.ID ORDER BY wp_postmeta.meta_value+0 DESC LIMIT 0, 4";s:5:"posts";a:4:{i:0;O:7:"WP_Post":24:{s:2:"ID";i:8;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2017-05-01 07:08:46";s:13:"post_date_gmt";s:19:"2017-05-01 07:08:46";s:12:"post_content";s:0:"";s:10:"post_title";s:8:"prod one";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:4:"open";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:8:"prod-one";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2017-05-01 07:08:46";s:17:"post_modified_gmt";s:19:"2017-05-01 07:08:46";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:50:"http://www.sandbox.dev/?post_type=product&#038;p=8";s:10:"menu_order";i:0;s:9:"post_type";s:7:"product";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}i:1;O:7:"WP_Post":24:{s:2:"ID";i:44;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2017-05-01 07:11:52";s:13:"post_date_gmt";s:19:"2017-05-01 07:11:52";s:12:"post_content";s:0:"";s:10:"post_title";s:15:"prod one (Copy)";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:4:"open";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:13:"prod-one-copy";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2017-05-01 07:11:58";s:17:"post_modified_gmt";s:19:"2017-05-01 07:11:58";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:51:"http://www.sandbox.dev/?post_type=product&#038;p=44";s:10:"menu_order";i:0;s:9:"post_type";s:7:"product";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}i:2;O:7:"WP_Post":24:{s:2:"ID";i:45;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2017-05-01 07:12:07";s:13:"post_date_gmt";s:19:"2017-05-01 07:12:07";s:12:"post_content";s:0:"";s:10:"post_title";s:22:"prod one (Copy) (Copy)";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:4:"open";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:18:"prod-one-copy-copy";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2017-05-01 07:12:22";s:17:"post_modified_gmt";s:19:"2017-05-01 07:12:22";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:51:"http://www.sandbox.dev/?post_type=product&#038;p=45";s:10:"menu_order";i:0;s:9:"post_type";s:7:"product";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}i:3;O:7:"WP_Post":24:{s:2:"ID";i:47;s:11:"post_author";s:1:"1";s:9:"post_date";s:19:"2017-05-01 07:12:27";s:13:"post_date_gmt";s:19:"2017-05-01 07:12:27";s:12:"post_content";s:0:"";s:10:"post_title";s:29:"prod one (Copy) (Copy) (Copy)";s:12:"post_excerpt";s:0:"";s:11:"post_status";s:7:"publish";s:14:"comment_status";s:4:"open";s:11:"ping_status";s:6:"closed";s:13:"post_password";s:0:"";s:9:"post_name";s:23:"prod-one-copy-copy-copy";s:7:"to_ping";s:0:"";s:6:"pinged";s:0:"";s:13:"post_modified";s:19:"2017-05-01 07:12:33";s:17:"post_modified_gmt";s:19:"2017-05-01 07:12:33";s:21:"post_content_filtered";s:0:"";s:11:"post_parent";i:0;s:4:"guid";s:51:"http://www.sandbox.dev/?post_type=product&#038;p=47";s:10:"menu_order";i:0;s:9:"post_type";s:7:"product";s:14:"post_mime_type";s:0:"";s:13:"comment_count";s:1:"0";s:6:"filter";s:3:"raw";}}s:10:"post_count";i:4;s:12:"current_post";i:-1;s:11:"in_the_loop";b:0;s:4:"post";r:128;s:13:"comment_count";i:0;s:15:"current_comment";i:-1;s:11:"found_posts";s:1:"4";s:13:"max_num_pages";d:1;s:21:"max_num_comment_pages";i:0;s:9:"is_single";b:0;s:10:"is_preview";b:0;s:7:"is_page";b:0;s:10:"is_archive";b:1;s:7:"is_date";b:0;s:7:"is_year";b:0;s:8:"is_month";b:0;s:6:"is_day";b:0;s:7:"is_time";b:0;s:9:"is_author";b:0;s:11:"is_category";b:0;s:6:"is_tag";b:0;s:6:"is_tax";b:0;s:9:"is_search";b:0;s:7:"is_feed";b:0;s:15:"is_comment_feed";b:0;s:12:"is_trackback";b:0;s:7:"is_home";b:0;s:6:"is_404";b:0;s:8:"is_embed";b:0;s:8:"is_paged";b:0;s:8:"is_admin";b:0;s:13:"is_attachment";b:0;s:11:"is_singular";b:0;s:9:"is_robots";b:0;s:13:"is_posts_page";b:0;s:20:"is_post_type_archive";b:1;s:25:"\0WP_Query\0query_vars_hash";s:32:"864484ede3ea4326477d173874a22ba6";s:28:"\0WP_Query\0query_vars_changed";b:0;s:17:"thumbnails_cached";b:0;s:19:"\0WP_Query\0stopwords";N;s:23:"\0WP_Query\0compat_fields";a:2:{i:0;s:15:"query_vars_hash";i:1;s:18:"query_vars_changed";}s:24:"\0WP_Query\0compat_methods";a:2:{i:0;s:16:"init_query_flags";i:1;s:15:"parse_tax_query";}}', 'no'),
(403, '_transient_timeout_external_ip_address_127.0.0.1', '1494244921', 'no'),
(404, '_transient_external_ip_address_127.0.0.1', '24.209.146.93', 'no'),
(405, 'acf_version', '5.5.8', 'yes'),
(407, 'category_children', 'a:0:{}', 'yes'),
(421, 'assembly_category_children', 'a:0:{}', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=840 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 8, '_wc_review_count', '0'),
(3, 8, '_wc_rating_count', 'a:0:{}'),
(4, 8, '_wc_average_rating', '0'),
(5, 8, '_edit_last', '1'),
(6, 8, '_edit_lock', '1493622388:1'),
(7, 9, '_wp_attached_file', '2017/05/2015-top-dentists-award.png'),
(8, 9, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:187;s:6:"height";i:185;s:4:"file";s:35:"2017/05/2015-top-dentists-award.png";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:35:"2015-top-dentists-award-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:35:"2015-top-dentists-award-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(9, 10, '_wp_attached_file', '2017/05/2016TopDentistsLogo.png'),
(10, 10, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:187;s:6:"height";i:185;s:4:"file";s:31:"2017/05/2016TopDentistsLogo.png";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:31:"2016TopDentistsLogo-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:31:"2016TopDentistsLogo-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(11, 11, '_wp_attached_file', '2017/05/appointment.jpg'),
(12, 11, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:265;s:6:"height";i:206;s:4:"file";s:23:"2017/05/appointment.jpg";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:23:"appointment-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:23:"appointment-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(13, 12, '_wp_attached_file', '2017/05/award.png'),
(14, 12, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:187;s:6:"height";i:186;s:4:"file";s:17:"2017/05/award.png";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:17:"award-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:17:"award-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(15, 13, '_wp_attached_file', '2017/05/award2.png'),
(16, 13, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:150;s:6:"height";i:221;s:4:"file";s:18:"2017/05/award2.png";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:18:"award2-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:18:"award2-150x180.png";s:5:"width";i:150;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(17, 14, '_wp_attached_file', '2017/05/doctors.png'),
(18, 14, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:699;s:6:"height";i:478;s:4:"file";s:19:"2017/05/doctors.png";s:5:"sizes";a:5:{s:9:"thumbnail";a:4:{s:4:"file";s:19:"doctors-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:19:"doctors-300x205.png";s:5:"width";i:300;s:6:"height";i:205;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:19:"doctors-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:19:"doctors-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:19:"doctors-600x478.png";s:5:"width";i:600;s:6:"height";i:478;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(19, 15, '_wp_attached_file', '2017/05/google-review-graphic.jpg'),
(20, 15, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:412;s:6:"height";i:134;s:4:"file";s:33:"2017/05/google-review-graphic.jpg";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:33:"google-review-graphic-150x134.jpg";s:5:"width";i:150;s:6:"height";i:134;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:32:"google-review-graphic-300x98.jpg";s:5:"width";i:300;s:6:"height";i:98;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:33:"google-review-graphic-180x134.jpg";s:5:"width";i:180;s:6:"height";i:134;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:33:"google-review-graphic-300x134.jpg";s:5:"width";i:300;s:6:"height";i:134;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"1";s:8:"keywords";a:0:{}}}'),
(21, 16, '_wp_attached_file', '2017/05/logo.png'),
(22, 16, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:362;s:6:"height";i:70;s:4:"file";s:16:"2017/05/logo.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:15:"logo-150x70.png";s:5:"width";i:150;s:6:"height";i:70;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:15:"logo-300x58.png";s:5:"width";i:300;s:6:"height";i:58;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:15:"logo-180x70.png";s:5:"width";i:180;s:6:"height";i:70;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:15:"logo-300x70.png";s:5:"width";i:300;s:6:"height";i:70;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(23, 17, '_wp_attached_file', '2017/05/qoute.png'),
(24, 17, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:72;s:6:"height";i:72;s:4:"file";s:17:"2017/05/qoute.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(25, 18, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale.jpg'),
(26, 18, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:256;s:6:"height";i:256;s:4:"file";s:82:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale.jpg";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(27, 19, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale.png'),
(28, 19, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:240;s:6:"height";i:108;s:4:"file";s:82:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale.png";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale-150x108.png";s:5:"width";i:150;s:6:"height";i:108;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale-180x108.png";s:5:"width";i:180;s:6:"height";i:108;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(29, 20, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1.jpg'),
(30, 20, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:480;s:6:"height";i:360;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1.jpg";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1-300x225.jpg";s:5:"width";i:300;s:6:"height";i:225;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(31, 21, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1.png'),
(32, 21, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:164;s:6:"height";i:175;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1.png";s:5:"sizes";a:1:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(33, 22, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2.jpg'),
(34, 22, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1366;s:6:"height";i:600;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2.jpg";s:5:"sizes";a:7:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-300x132.jpg";s:5:"width";i:300;s:6:"height";i:132;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-768x337.jpg";s:5:"width";i:768;s:6:"height";i:337;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-1024x450.jpg";s:5:"width";i:1024;s:6:"height";i:450;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-600x600.jpg";s:5:"width";i:600;s:6:"height";i:600;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(35, 23, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2.png'),
(36, 23, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:59;s:6:"height";i:492;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-59x150.png";s:5:"width";i:59;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-36x300.png";s:5:"width";i:36;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-59x180.png";s:5:"width";i:59;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:82:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2-59x300.png";s:5:"width";i:59;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(37, 24, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3.jpg'),
(38, 24, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1336;s:6:"height";i:555;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3.jpg";s:5:"sizes";a:7:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-300x125.jpg";s:5:"width";i:300;s:6:"height";i:125;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-768x319.jpg";s:5:"width";i:768;s:6:"height";i:319;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-1024x425.jpg";s:5:"width";i:1024;s:6:"height";i:425;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-600x555.jpg";s:5:"width";i:600;s:6:"height";i:555;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(39, 25, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3.png'),
(40, 25, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:512;s:6:"height";i:512;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(41, 26, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4.jpg'),
(42, 26, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1364;s:6:"height";i:680;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4.jpg";s:5:"sizes";a:7:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-300x150.jpg";s:5:"width";i:300;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-768x383.jpg";s:5:"width";i:768;s:6:"height";i:383;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-1024x510.jpg";s:5:"width";i:1024;s:6:"height";i:510;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-300x300.jpg";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-600x600.jpg";s:5:"width";i:600;s:6:"height";i:600;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(43, 27, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4.png'),
(44, 27, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:512;s:6:"height";i:512;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(45, 28, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5.png'),
(46, 28, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:512;s:6:"height";i:512;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(47, 29, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6.png'),
(48, 29, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:512;s:6:"height";i:512;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(49, 30, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7.png'),
(50, 30, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:512;s:6:"height";i:512;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(51, 31, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8.png'),
(52, 31, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:512;s:6:"height";i:512;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(53, 32, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9.png'),
(54, 32, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:140;s:6:"height";i:420;s:4:"file";s:83:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9-140x150.png";s:5:"width";i:140;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9-100x300.png";s:5:"width";i:100;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9-140x180.png";s:5:"width";i:140;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9-140x300.png";s:5:"width";i:140;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(55, 33, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10.png'),
(56, 33, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:320;s:6:"height";i:250;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10.png";s:5:"sizes";a:4:{s:9:"thumbnail";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10-300x234.png";s:5:"width";i:300;s:6:"height";i:234;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10-180x180.png";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10-300x250.png";s:5:"width";i:300;s:6:"height";i:250;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(57, 34, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale11.png'),
(58, 34, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:132;s:6:"height";i:52;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale11.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(59, 35, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale12.png'),
(60, 35, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:174;s:6:"height";i:71;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale12.png";s:5:"sizes";a:1:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale12-150x71.png";s:5:"width";i:150;s:6:"height";i:71;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(61, 36, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13.png'),
(62, 36, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1903;s:6:"height";i:88;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13.png";s:5:"sizes";a:7:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-150x88.png";s:5:"width";i:150;s:6:"height";i:88;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-300x14.png";s:5:"width";i:300;s:6:"height";i:14;s:9:"mime-type";s:9:"image/png";}s:12:"medium_large";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-768x36.png";s:5:"width";i:768;s:6:"height";i:36;s:9:"mime-type";s:9:"image/png";}s:5:"large";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-1024x47.png";s:5:"width";i:1024;s:6:"height";i:47;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-180x88.png";s:5:"width";i:180;s:6:"height";i:88;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-300x88.png";s:5:"width";i:300;s:6:"height";i:88;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13-600x88.png";s:5:"width";i:600;s:6:"height";i:88;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(63, 37, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14.png'),
(64, 37, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1366;s:6:"height";i:89;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14.png";s:5:"sizes";a:7:{s:9:"thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-150x89.png";s:5:"width";i:150;s:6:"height";i:89;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-300x20.png";s:5:"width";i:300;s:6:"height";i:20;s:9:"mime-type";s:9:"image/png";}s:12:"medium_large";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-768x50.png";s:5:"width";i:768;s:6:"height";i:50;s:9:"mime-type";s:9:"image/png";}s:5:"large";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-1024x67.png";s:5:"width";i:1024;s:6:"height";i:67;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-180x89.png";s:5:"width";i:180;s:6:"height";i:89;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-300x89.png";s:5:"width";i:300;s:6:"height";i:89;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14-600x89.png";s:5:"width";i:600;s:6:"height";i:89;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(65, 38, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale15.png'),
(66, 38, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:32;s:6:"height";i:33;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale15.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(67, 39, '_wp_attached_file', '2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16.png'),
(68, 39, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:1366;s:6:"height";i:138;s:4:"file";s:84:"2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16.png";s:5:"sizes";a:7:{s:9:"thumbnail";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-150x138.png";s:5:"width";i:150;s:6:"height";i:138;s:9:"mime-type";s:9:"image/png";}s:6:"medium";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-300x30.png";s:5:"width";i:300;s:6:"height";i:30;s:9:"mime-type";s:9:"image/png";}s:12:"medium_large";a:4:{s:4:"file";s:83:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-768x78.png";s:5:"width";i:768;s:6:"height";i:78;s:9:"mime-type";s:9:"image/png";}s:5:"large";a:4:{s:4:"file";s:85:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-1024x103.png";s:5:"width";i:1024;s:6:"height";i:103;s:9:"mime-type";s:9:"image/png";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-180x138.png";s:5:"width";i:180;s:6:"height";i:138;s:9:"mime-type";s:9:"image/png";}s:12:"shop_catalog";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-300x138.png";s:5:"width";i:300;s:6:"height";i:138;s:9:"mime-type";s:9:"image/png";}s:11:"shop_single";a:4:{s:4:"file";s:84:"Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16-600x138.png";s:5:"width";i:600;s:6:"height";i:138;s:9:"mime-type";s:9:"image/png";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(69, 40, '_wp_attached_file', '2017/05/star.png'),
(70, 40, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:125;s:6:"height";i:26;s:4:"file";s:16:"2017/05/star.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(71, 41, '_wp_attached_file', '2017/05/studio-gallery.jpg'),
(72, 41, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:265;s:6:"height";i:208;s:4:"file";s:26:"2017/05/studio-gallery.jpg";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:26:"studio-gallery-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:26:"studio-gallery-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(73, 42, '_wp_attached_file', '2017/05/testimonial.jpg'),
(74, 42, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:265;s:6:"height";i:208;s:4:"file";s:23:"2017/05/testimonial.jpg";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:23:"testimonial-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:23:"testimonial-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(75, 43, '_wp_attached_file', '2017/05/virtual-tour.jpg'),
(76, 43, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:265;s:6:"height";i:208;s:4:"file";s:24:"2017/05/virtual-tour.jpg";s:5:"sizes";a:2:{s:9:"thumbnail";a:4:{s:4:"file";s:24:"virtual-tour-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:24:"virtual-tour-180x180.jpg";s:5:"width";i:180;s:6:"height";i:180;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
(77, 8, '_thumbnail_id', '12'),
(78, 8, '_sku', ''),
(79, 8, '_regular_price', '0'),
(80, 8, '_sale_price', ''),
(81, 8, '_sale_price_dates_from', ''),
(82, 8, '_sale_price_dates_to', ''),
(83, 8, 'total_sales', '0'),
(84, 8, '_tax_status', 'taxable'),
(85, 8, '_tax_class', ''),
(86, 8, '_manage_stock', 'no'),
(87, 8, '_backorders', 'no'),
(88, 8, '_sold_individually', 'no'),
(89, 8, '_weight', ''),
(90, 8, '_length', ''),
(91, 8, '_width', ''),
(92, 8, '_height', ''),
(93, 8, '_upsell_ids', 'a:0:{}'),
(94, 8, '_crosssell_ids', 'a:0:{}'),
(95, 8, '_purchase_note', ''),
(96, 8, '_default_attributes', 'a:0:{}'),
(97, 8, '_virtual', 'yes'),
(98, 8, '_downloadable', 'no'),
(99, 8, '_product_image_gallery', ''),
(100, 8, '_download_limit', '-1'),
(101, 8, '_download_expiry', '-1'),
(102, 8, '_stock', NULL),
(103, 8, '_stock_status', 'instock'),
(104, 8, '_product_version', '3.0.5'),
(105, 8, '_price', '0'),
(106, 44, '_sku', ''),
(107, 44, '_regular_price', '0'),
(108, 44, '_sale_price', ''),
(109, 44, '_sale_price_dates_from', ''),
(110, 44, '_sale_price_dates_to', ''),
(111, 44, 'total_sales', '0'),
(112, 44, '_tax_status', 'taxable'),
(113, 44, '_tax_class', ''),
(114, 44, '_manage_stock', 'no'),
(115, 44, '_backorders', 'no'),
(116, 44, '_sold_individually', 'no'),
(117, 44, '_weight', ''),
(118, 44, '_length', ''),
(119, 44, '_width', ''),
(120, 44, '_height', ''),
(121, 44, '_upsell_ids', 'a:0:{}'),
(122, 44, '_crosssell_ids', 'a:0:{}'),
(123, 44, '_purchase_note', ''),
(124, 44, '_default_attributes', 'a:0:{}'),
(125, 44, '_virtual', 'yes'),
(126, 44, '_downloadable', 'no'),
(127, 44, '_product_image_gallery', ''),
(128, 44, '_download_limit', '-1'),
(129, 44, '_download_expiry', '-1'),
(130, 44, '_thumbnail_id', '12'),
(131, 44, '_stock', NULL),
(132, 44, '_stock_status', 'instock'),
(133, 44, '_wc_average_rating', '0'),
(134, 44, '_wc_rating_count', 'a:0:{}'),
(135, 44, '_wc_review_count', '0'),
(136, 44, '_downloadable_files', 'a:0:{}'),
(137, 44, '_product_attributes', 'a:0:{}'),
(138, 44, '_product_version', '3.0.5'),
(139, 44, '_price', '0'),
(140, 44, '_edit_lock', '1493622585:1'),
(141, 44, '_edit_last', '1'),
(142, 45, '_sku', ''),
(143, 45, '_regular_price', '0'),
(144, 45, '_sale_price', ''),
(145, 45, '_sale_price_dates_from', ''),
(146, 45, '_sale_price_dates_to', ''),
(147, 45, 'total_sales', '0'),
(148, 45, '_tax_status', 'taxable'),
(149, 45, '_tax_class', ''),
(150, 45, '_manage_stock', 'no'),
(151, 45, '_backorders', 'no'),
(152, 45, '_sold_individually', 'no'),
(153, 45, '_weight', ''),
(154, 45, '_length', ''),
(155, 45, '_width', ''),
(156, 45, '_height', ''),
(157, 45, '_upsell_ids', 'a:0:{}'),
(158, 45, '_crosssell_ids', 'a:0:{}'),
(159, 45, '_purchase_note', ''),
(160, 45, '_default_attributes', 'a:0:{}'),
(161, 45, '_virtual', 'yes'),
(162, 45, '_downloadable', 'no'),
(163, 45, '_product_image_gallery', ''),
(164, 45, '_download_limit', '-1'),
(165, 45, '_download_expiry', '-1'),
(166, 45, '_thumbnail_id', '22'),
(167, 45, '_stock', NULL),
(168, 45, '_stock_status', 'instock'),
(169, 45, '_wc_average_rating', '0'),
(170, 45, '_wc_rating_count', 'a:0:{}'),
(171, 45, '_wc_review_count', '0'),
(172, 45, '_downloadable_files', 'a:0:{}'),
(173, 45, '_product_attributes', 'a:0:{}'),
(174, 45, '_product_version', '3.0.5'),
(175, 45, '_price', '0'),
(176, 45, '_edit_lock', '1493622605:1'),
(177, 45, '_edit_last', '1'),
(178, 46, '_sku', ''),
(179, 46, '_regular_price', '0'),
(180, 46, '_sale_price', ''),
(181, 46, '_sale_price_dates_from', ''),
(182, 46, '_sale_price_dates_to', ''),
(183, 46, 'total_sales', '0'),
(184, 46, '_tax_status', 'taxable'),
(185, 46, '_tax_class', ''),
(186, 46, '_manage_stock', 'no'),
(187, 46, '_backorders', 'no'),
(188, 46, '_sold_individually', 'no'),
(189, 46, '_weight', ''),
(190, 46, '_length', ''),
(191, 46, '_width', ''),
(192, 46, '_height', ''),
(193, 46, '_upsell_ids', 'a:0:{}'),
(194, 46, '_crosssell_ids', 'a:0:{}'),
(195, 46, '_purchase_note', ''),
(196, 46, '_default_attributes', 'a:0:{}'),
(197, 46, '_virtual', 'yes'),
(198, 46, '_downloadable', 'no'),
(199, 46, '_product_image_gallery', ''),
(200, 46, '_download_limit', '-1'),
(201, 46, '_download_expiry', '-1'),
(202, 46, '_thumbnail_id', '22'),
(203, 46, '_stock', NULL),
(204, 46, '_stock_status', 'instock'),
(205, 46, '_wc_average_rating', '0'),
(206, 46, '_wc_rating_count', 'a:0:{}'),
(207, 46, '_wc_review_count', '0'),
(208, 46, '_downloadable_files', 'a:0:{}'),
(209, 46, '_product_attributes', 'a:0:{}'),
(210, 46, '_product_version', '3.0.5'),
(211, 46, '_price', '0'),
(212, 47, '_sku', ''),
(213, 47, '_regular_price', '0'),
(214, 47, '_sale_price', ''),
(215, 47, '_sale_price_dates_from', ''),
(216, 47, '_sale_price_dates_to', ''),
(217, 47, 'total_sales', '0'),
(218, 47, '_tax_status', 'taxable'),
(219, 47, '_tax_class', ''),
(220, 47, '_manage_stock', 'no'),
(221, 47, '_backorders', 'no'),
(222, 47, '_sold_individually', 'no'),
(223, 47, '_weight', ''),
(224, 47, '_length', ''),
(225, 47, '_width', ''),
(226, 47, '_height', ''),
(227, 47, '_upsell_ids', 'a:0:{}'),
(228, 47, '_crosssell_ids', 'a:0:{}'),
(229, 47, '_purchase_note', ''),
(230, 47, '_default_attributes', 'a:0:{}'),
(231, 47, '_virtual', 'yes'),
(232, 47, '_downloadable', 'no'),
(233, 47, '_product_image_gallery', ''),
(234, 47, '_download_limit', '-1'),
(235, 47, '_download_expiry', '-1'),
(236, 47, '_thumbnail_id', '22'),
(237, 47, '_stock', NULL),
(238, 47, '_stock_status', 'instock'),
(239, 47, '_wc_average_rating', '0'),
(240, 47, '_wc_rating_count', 'a:0:{}'),
(241, 47, '_wc_review_count', '0'),
(242, 47, '_downloadable_files', 'a:0:{}'),
(243, 47, '_product_attributes', 'a:0:{}'),
(244, 47, '_product_version', '3.0.5'),
(245, 47, '_price', '0'),
(246, 47, '_edit_lock', '1493622616:1'),
(247, 47, '_edit_last', '1'),
(394, 161, '_wc_review_count', '0'),
(395, 161, '_wc_rating_count', 'a:0:{}'),
(396, 161, '_wc_average_rating', '0'),
(397, 162, '_edit_last', '1'),
(398, 162, '_edit_lock', '1493661289:1'),
(399, 162, 'assembly_id', 'one'),
(400, 162, '_assembly_id', 'field_58bec9cbae35a'),
(401, 162, 'assembly_no', 'two'),
(402, 162, '_assembly_no', 'field_58bec9d3ae35b'),
(403, 162, 'assembly_name', 'two'),
(404, 162, '_assembly_name', 'field_58bec9d8ae35c'),
(405, 162, 'assembly_category', 'a:2:{i:0;s:2:"30";i:1;s:2:"27";}'),
(406, 162, '_assembly_category', 'field_58bed73b66f46'),
(407, 162, 'assembly_description', ''),
(408, 162, '_assembly_description', 'field_58bed72466f45'),
(409, 162, 'sub-assemblies', ''),
(410, 162, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(411, 162, 'assembly_files', ''),
(412, 162, '_assembly_files', 'field_58bed77ab852a'),
(413, 162, 'assembly_images', ''),
(414, 162, '_assembly_images', 'field_58bed7a7b852b'),
(415, 163, 'assembly_id', 'one'),
(416, 163, '_assembly_id', 'field_58bec9cbae35a'),
(417, 163, 'assembly_no', 'two'),
(418, 163, '_assembly_no', 'field_58bec9d3ae35b'),
(419, 163, 'assembly_name', 'two'),
(420, 163, '_assembly_name', 'field_58bec9d8ae35c'),
(421, 163, 'assembly_category', 'a:2:{i:0;s:2:"30";i:1;s:2:"27";}'),
(422, 163, '_assembly_category', 'field_58bed73b66f46'),
(423, 163, 'assembly_description', ''),
(424, 163, '_assembly_description', 'field_58bed72466f45'),
(425, 163, 'sub-assemblies', ''),
(426, 163, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(427, 163, 'assembly_files', ''),
(428, 163, '_assembly_files', 'field_58bed77ab852a'),
(429, 163, 'assembly_images', ''),
(430, 163, '_assembly_images', 'field_58bed7a7b852b'),
(512, 195, 'assembly_id', 'two'),
(513, 195, '_assembly_id', 'field_58bec9cbae35a'),
(514, 195, 'assembly_no', 'two'),
(515, 195, '_assembly_no', 'field_58bec9d3ae35b'),
(516, 195, 'assembly_name', 'two'),
(517, 195, '_assembly_name', 'field_58bec9d8ae35c'),
(518, 195, 'assembly_category', 'a:1:{i:0;s:2:"27";}'),
(519, 195, '_assembly_category', 'field_58bed73b66f46'),
(520, 195, 'assembly_description', ''),
(521, 195, '_assembly_description', 'field_58bed72466f45'),
(522, 195, 'sub-assemblies', ''),
(523, 195, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(524, 195, 'assembly_files', ''),
(525, 195, '_assembly_files', 'field_58bed77ab852a'),
(526, 195, 'assembly_images', ''),
(527, 195, '_assembly_images', 'field_58bed7a7b852b'),
(528, 195, '_dp_original', '162'),
(529, 195, '_edit_last', '1'),
(530, 195, '_edit_lock', '1493661289:1'),
(531, 198, 'assembly_id', 'two'),
(532, 198, '_assembly_id', 'field_58bec9cbae35a'),
(533, 198, 'assembly_no', 'two'),
(534, 198, '_assembly_no', 'field_58bec9d3ae35b'),
(535, 198, 'assembly_name', 'two'),
(536, 198, '_assembly_name', 'field_58bec9d8ae35c'),
(537, 198, 'assembly_category', 'a:2:{i:0;s:2:"29";i:1;s:2:"27";}'),
(538, 198, '_assembly_category', 'field_58bed73b66f46');
INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(539, 198, 'assembly_description', ''),
(540, 198, '_assembly_description', 'field_58bed72466f45'),
(541, 198, 'sub-assemblies', ''),
(542, 198, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(543, 198, 'assembly_files', ''),
(544, 198, '_assembly_files', 'field_58bed77ab852a'),
(545, 198, 'assembly_images', ''),
(546, 198, '_assembly_images', 'field_58bed7a7b852b'),
(548, 198, '_dp_original', '195'),
(549, 198, '_edit_last', '1'),
(550, 198, '_edit_lock', '1493661289:1'),
(551, 201, 'assembly_id', 'four'),
(552, 201, '_assembly_id', 'field_58bec9cbae35a'),
(553, 201, 'assembly_no', 'four'),
(554, 201, '_assembly_no', 'field_58bec9d3ae35b'),
(555, 201, 'assembly_name', 'four'),
(556, 201, '_assembly_name', 'field_58bec9d8ae35c'),
(557, 201, 'assembly_category', 'a:2:{i:0;s:2:"29";i:1;s:2:"27";}'),
(558, 201, '_assembly_category', 'field_58bed73b66f46'),
(559, 201, 'assembly_description', ''),
(560, 201, '_assembly_description', 'field_58bed72466f45'),
(561, 201, 'sub-assemblies', ''),
(562, 201, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(563, 201, 'assembly_files', ''),
(564, 201, '_assembly_files', 'field_58bed77ab852a'),
(565, 201, 'assembly_images', ''),
(566, 201, '_assembly_images', 'field_58bed7a7b852b'),
(568, 201, '_dp_original', '198'),
(569, 201, '_edit_lock', '1493661208:1'),
(570, 201, '_edit_last', '1'),
(571, 202, 'assembly_id', 'one'),
(572, 202, '_assembly_id', 'field_58bec9cbae35a'),
(573, 202, 'assembly_no', 'one'),
(574, 202, '_assembly_no', 'field_58bec9d3ae35b'),
(575, 202, 'assembly_name', 'one'),
(576, 202, '_assembly_name', 'field_58bec9d8ae35c'),
(577, 202, 'assembly_category', 'a:2:{i:0;s:2:"29";i:1;s:2:"27";}'),
(578, 202, '_assembly_category', 'field_58bed73b66f46'),
(579, 202, 'assembly_description', ''),
(580, 202, '_assembly_description', 'field_58bed72466f45'),
(581, 202, 'sub-assemblies', ''),
(582, 202, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(583, 202, 'assembly_files', ''),
(584, 202, '_assembly_files', 'field_58bed77ab852a'),
(585, 202, 'assembly_images', ''),
(586, 202, '_assembly_images', 'field_58bed7a7b852b'),
(587, 203, 'assembly_id', 'four'),
(588, 203, '_assembly_id', 'field_58bec9cbae35a'),
(589, 203, 'assembly_no', 'four'),
(590, 203, '_assembly_no', 'field_58bec9d3ae35b'),
(591, 203, 'assembly_name', 'four'),
(592, 203, '_assembly_name', 'field_58bec9d8ae35c'),
(593, 203, 'assembly_category', 'a:2:{i:0;s:2:"29";i:1;s:2:"27";}'),
(594, 203, '_assembly_category', 'field_58bed73b66f46'),
(595, 203, 'assembly_description', ''),
(596, 203, '_assembly_description', 'field_58bed72466f45'),
(597, 203, 'sub-assemblies', ''),
(598, 203, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(599, 203, 'assembly_files', ''),
(600, 203, '_assembly_files', 'field_58bed77ab852a'),
(601, 203, 'assembly_images', ''),
(602, 203, '_assembly_images', 'field_58bed7a7b852b'),
(603, 197, 'assembly_id', 'three'),
(604, 197, '_assembly_id', 'field_58bec9cbae35a'),
(605, 197, 'assembly_no', 'three'),
(606, 197, '_assembly_no', 'field_58bec9d3ae35b'),
(607, 197, 'assembly_name', 'three'),
(608, 197, '_assembly_name', 'field_58bec9d8ae35c'),
(609, 197, 'assembly_category', 'a:1:{i:0;s:2:"27";}'),
(610, 197, '_assembly_category', 'field_58bed73b66f46'),
(611, 197, 'assembly_description', ''),
(612, 197, '_assembly_description', 'field_58bed72466f45'),
(613, 197, 'sub-assemblies', ''),
(614, 197, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(615, 197, 'assembly_files', ''),
(616, 197, '_assembly_files', 'field_58bed77ab852a'),
(617, 197, 'assembly_images', ''),
(618, 197, '_assembly_images', 'field_58bed7a7b852b'),
(619, 204, 'assembly_id', 'two'),
(620, 204, '_assembly_id', 'field_58bec9cbae35a'),
(621, 204, 'assembly_no', 'two'),
(622, 204, '_assembly_no', 'field_58bec9d3ae35b'),
(623, 204, 'assembly_name', 'two'),
(624, 204, '_assembly_name', 'field_58bec9d8ae35c'),
(625, 204, 'assembly_category', 'a:2:{i:0;s:2:"29";i:1;s:2:"27";}'),
(626, 204, '_assembly_category', 'field_58bed73b66f46'),
(627, 204, 'assembly_description', ''),
(628, 204, '_assembly_description', 'field_58bed72466f45'),
(629, 204, 'sub-assemblies', ''),
(630, 204, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(631, 204, 'assembly_files', ''),
(632, 204, '_assembly_files', 'field_58bed77ab852a'),
(633, 204, 'assembly_images', ''),
(634, 204, '_assembly_images', 'field_58bed7a7b852b'),
(635, 205, 'assembly_id', 'two'),
(636, 205, '_assembly_id', 'field_58bec9cbae35a'),
(637, 205, 'assembly_no', 'two'),
(638, 205, '_assembly_no', 'field_58bec9d3ae35b'),
(639, 205, 'assembly_name', 'two'),
(640, 205, '_assembly_name', 'field_58bec9d8ae35c'),
(641, 205, 'assembly_category', 'a:1:{i:0;s:2:"27";}'),
(642, 205, '_assembly_category', 'field_58bed73b66f46'),
(643, 205, 'assembly_description', ''),
(644, 205, '_assembly_description', 'field_58bed72466f45'),
(645, 205, 'sub-assemblies', ''),
(646, 205, '_sub-assemblies', 'field_58bec9fc4dcd4'),
(647, 205, 'assembly_files', ''),
(648, 205, '_assembly_files', 'field_58bed77ab852a'),
(649, 205, 'assembly_images', ''),
(650, 205, '_assembly_images', 'field_58bed7a7b852b'),
(651, 206, '_edit_last', '1'),
(652, 206, '_edit_lock', '1493661341:1'),
(653, 206, 'part_id', 'a'),
(654, 206, '_part_id', 'field_58be21cb63558'),
(655, 206, 'part_no', 'a'),
(656, 206, '_part_no', 'field_58be224180f49'),
(657, 206, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(658, 206, '_part_category', 'field_58bed5eb041ea'),
(659, 206, 'part_name', 'a'),
(660, 206, '_part_name', 'field_58be224e80f4a'),
(661, 206, 'part_sku', ''),
(662, 206, '_part_sku', 'field_58be2211b049f'),
(663, 206, 'part_description', ''),
(664, 206, '_part_description', 'field_58be225a80f4b'),
(665, 206, 'part_units', ''),
(666, 206, '_part_units', 'field_58be23ec87b4e'),
(667, 206, 'part_cost', ''),
(668, 206, '_part_cost', 'field_58be26e874984'),
(669, 206, 'part_weight', ''),
(670, 206, '_part_weight', 'field_58be25d7bc42b'),
(671, 206, 'part_measurement', ''),
(672, 206, '_part_measurement', 'field_58be27115df5e'),
(673, 206, 'part_notes', ''),
(674, 206, '_part_notes', 'field_58be268b32e00'),
(675, 207, 'part_id', 'a'),
(676, 207, '_part_id', 'field_58be21cb63558'),
(677, 207, 'part_no', 'a'),
(678, 207, '_part_no', 'field_58be224180f49'),
(679, 207, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(680, 207, '_part_category', 'field_58bed5eb041ea'),
(681, 207, 'part_name', 'a'),
(682, 207, '_part_name', 'field_58be224e80f4a'),
(683, 207, 'part_sku', ''),
(684, 207, '_part_sku', 'field_58be2211b049f'),
(685, 207, 'part_description', ''),
(686, 207, '_part_description', 'field_58be225a80f4b'),
(687, 207, 'part_units', ''),
(688, 207, '_part_units', 'field_58be23ec87b4e'),
(689, 207, 'part_cost', ''),
(690, 207, '_part_cost', 'field_58be26e874984'),
(691, 207, 'part_weight', ''),
(692, 207, '_part_weight', 'field_58be25d7bc42b'),
(693, 207, 'part_measurement', ''),
(694, 207, '_part_measurement', 'field_58be27115df5e'),
(695, 207, 'part_notes', ''),
(696, 207, '_part_notes', 'field_58be268b32e00'),
(697, 208, 'part_id', 'b'),
(698, 208, '_part_id', 'field_58be21cb63558'),
(699, 208, 'part_no', 'b'),
(700, 208, '_part_no', 'field_58be224180f49'),
(701, 208, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(702, 208, '_part_category', 'field_58bed5eb041ea'),
(703, 208, 'part_name', 'a'),
(704, 208, '_part_name', 'field_58be224e80f4a'),
(705, 208, 'part_sku', ''),
(706, 208, '_part_sku', 'field_58be2211b049f'),
(707, 208, 'part_description', ''),
(708, 208, '_part_description', 'field_58be225a80f4b'),
(709, 208, 'part_units', ''),
(710, 208, '_part_units', 'field_58be23ec87b4e'),
(711, 208, 'part_cost', ''),
(712, 208, '_part_cost', 'field_58be26e874984'),
(713, 208, 'part_weight', ''),
(714, 208, '_part_weight', 'field_58be25d7bc42b'),
(715, 208, 'part_measurement', ''),
(716, 208, '_part_measurement', 'field_58be27115df5e'),
(717, 208, 'part_notes', ''),
(718, 208, '_part_notes', 'field_58be268b32e00'),
(719, 208, '_dp_original', '206'),
(720, 208, '_edit_lock', '1493661362:1'),
(721, 208, '_edit_last', '1'),
(722, 209, 'part_id', 'b'),
(723, 209, '_part_id', 'field_58be21cb63558'),
(724, 209, 'part_no', 'b'),
(725, 209, '_part_no', 'field_58be224180f49'),
(726, 209, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(727, 209, '_part_category', 'field_58bed5eb041ea'),
(728, 209, 'part_name', 'a'),
(729, 209, '_part_name', 'field_58be224e80f4a'),
(730, 209, 'part_sku', ''),
(731, 209, '_part_sku', 'field_58be2211b049f'),
(732, 209, 'part_description', ''),
(733, 209, '_part_description', 'field_58be225a80f4b'),
(734, 209, 'part_units', ''),
(735, 209, '_part_units', 'field_58be23ec87b4e'),
(736, 209, 'part_cost', ''),
(737, 209, '_part_cost', 'field_58be26e874984'),
(738, 209, 'part_weight', ''),
(739, 209, '_part_weight', 'field_58be25d7bc42b'),
(740, 209, 'part_measurement', ''),
(741, 209, '_part_measurement', 'field_58be27115df5e'),
(742, 209, 'part_notes', ''),
(743, 209, '_part_notes', 'field_58be268b32e00'),
(744, 210, 'part_id', 'c'),
(745, 210, '_part_id', 'field_58be21cb63558'),
(746, 210, 'part_no', 'c'),
(747, 210, '_part_no', 'field_58be224180f49'),
(748, 210, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(749, 210, '_part_category', 'field_58bed5eb041ea'),
(750, 210, 'part_name', 'a'),
(751, 210, '_part_name', 'field_58be224e80f4a'),
(752, 210, 'part_sku', ''),
(753, 210, '_part_sku', 'field_58be2211b049f'),
(754, 210, 'part_description', ''),
(755, 210, '_part_description', 'field_58be225a80f4b'),
(756, 210, 'part_units', ''),
(757, 210, '_part_units', 'field_58be23ec87b4e'),
(758, 210, 'part_cost', ''),
(759, 210, '_part_cost', 'field_58be26e874984'),
(760, 210, 'part_weight', ''),
(761, 210, '_part_weight', 'field_58be25d7bc42b'),
(762, 210, 'part_measurement', ''),
(763, 210, '_part_measurement', 'field_58be27115df5e'),
(764, 210, 'part_notes', ''),
(765, 210, '_part_notes', 'field_58be268b32e00'),
(767, 210, '_dp_original', '208'),
(768, 210, '_edit_lock', '1493661386:1'),
(769, 210, '_edit_last', '1'),
(770, 211, 'part_id', 'c'),
(771, 211, '_part_id', 'field_58be21cb63558'),
(772, 211, 'part_no', 'c'),
(773, 211, '_part_no', 'field_58be224180f49'),
(774, 211, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(775, 211, '_part_category', 'field_58bed5eb041ea'),
(776, 211, 'part_name', 'a'),
(777, 211, '_part_name', 'field_58be224e80f4a'),
(778, 211, 'part_sku', ''),
(779, 211, '_part_sku', 'field_58be2211b049f'),
(780, 211, 'part_description', ''),
(781, 211, '_part_description', 'field_58be225a80f4b'),
(782, 211, 'part_units', ''),
(783, 211, '_part_units', 'field_58be23ec87b4e'),
(784, 211, 'part_cost', ''),
(785, 211, '_part_cost', 'field_58be26e874984'),
(786, 211, 'part_weight', ''),
(787, 211, '_part_weight', 'field_58be25d7bc42b'),
(788, 211, 'part_measurement', ''),
(789, 211, '_part_measurement', 'field_58be27115df5e'),
(790, 211, 'part_notes', ''),
(791, 211, '_part_notes', 'field_58be268b32e00'),
(792, 212, 'part_id', 'd'),
(793, 212, '_part_id', 'field_58be21cb63558'),
(794, 212, 'part_no', 'd'),
(795, 212, '_part_no', 'field_58be224180f49'),
(796, 212, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(797, 212, '_part_category', 'field_58bed5eb041ea'),
(798, 212, 'part_name', 'a'),
(799, 212, '_part_name', 'field_58be224e80f4a'),
(800, 212, 'part_sku', ''),
(801, 212, '_part_sku', 'field_58be2211b049f'),
(802, 212, 'part_description', ''),
(803, 212, '_part_description', 'field_58be225a80f4b'),
(804, 212, 'part_units', ''),
(805, 212, '_part_units', 'field_58be23ec87b4e'),
(806, 212, 'part_cost', ''),
(807, 212, '_part_cost', 'field_58be26e874984'),
(808, 212, 'part_weight', ''),
(809, 212, '_part_weight', 'field_58be25d7bc42b'),
(810, 212, 'part_measurement', ''),
(811, 212, '_part_measurement', 'field_58be27115df5e'),
(812, 212, 'part_notes', ''),
(813, 212, '_part_notes', 'field_58be268b32e00'),
(815, 212, '_dp_original', '210'),
(816, 212, '_edit_lock', '1493661543:1'),
(817, 212, '_edit_last', '1'),
(818, 213, 'part_id', 'd'),
(819, 213, '_part_id', 'field_58be21cb63558'),
(820, 213, 'part_no', 'd'),
(821, 213, '_part_no', 'field_58be224180f49'),
(822, 213, 'part_category', 'a:1:{i:0;s:2:"19";}'),
(823, 213, '_part_category', 'field_58bed5eb041ea'),
(824, 213, 'part_name', 'a'),
(825, 213, '_part_name', 'field_58be224e80f4a'),
(826, 213, 'part_sku', ''),
(827, 213, '_part_sku', 'field_58be2211b049f'),
(828, 213, 'part_description', ''),
(829, 213, '_part_description', 'field_58be225a80f4b'),
(830, 213, 'part_units', ''),
(831, 213, '_part_units', 'field_58be23ec87b4e'),
(832, 213, 'part_cost', ''),
(833, 213, '_part_cost', 'field_58be26e874984'),
(834, 213, 'part_weight', ''),
(835, 213, '_part_weight', 'field_58be25d7bc42b'),
(836, 213, 'part_measurement', ''),
(837, 213, '_part_measurement', 'field_58be27115df5e'),
(838, 213, 'part_notes', ''),
(839, 213, '_part_notes', 'field_58be268b32e00');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2017-05-01 07:03:44', '2017-05-01 07:03:44', 'Welcome to WordPress. This is your first post. Edit or delete it, then start writing!', 'Hello world!', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2017-05-01 07:03:44', '2017-05-01 07:03:44', '', 0, 'http://www.sandbox.dev/?p=1', 0, 'post', '', 1),
(2, 1, '2017-05-01 07:03:44', '2017-05-01 07:03:44', 'This is an example page. It''s different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:\n\n<blockquote>Hi there! I''m a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin'' caught in the rain.)</blockquote>\n\n...or something like this:\n\n<blockquote>The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.</blockquote>\n\nAs a new WordPress user, you should go to <a href="http://www.sandbox.dev/wp-admin/">your dashboard</a> to delete this page and create new pages for your content. Have fun!', 'Sample Page', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2017-05-01 07:03:44', '2017-05-01 07:03:44', '', 0, 'http://www.sandbox.dev/?page_id=2', 0, 'page', '', 0),
(3, 1, '2017-05-01 07:03:47', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2017-05-01 07:03:47', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?p=3', 0, 'post', '', 0),
(4, 1, '2017-05-01 07:07:06', '2017-05-01 07:07:06', '', 'Shop', '', 'publish', 'closed', 'closed', '', 'shop', '', '', '2017-05-01 07:07:06', '2017-05-01 07:07:06', '', 0, 'http://www.sandbox.dev/shop/', 0, 'page', '', 0),
(5, 1, '2017-05-01 07:07:06', '2017-05-01 07:07:06', '[woocommerce_cart]', 'Cart', '', 'publish', 'closed', 'closed', '', 'cart', '', '', '2017-05-01 07:07:06', '2017-05-01 07:07:06', '', 0, 'http://www.sandbox.dev/cart/', 0, 'page', '', 0),
(6, 1, '2017-05-01 07:07:06', '2017-05-01 07:07:06', '[woocommerce_checkout]', 'Checkout', '', 'publish', 'closed', 'closed', '', 'checkout', '', '', '2017-05-01 07:07:06', '2017-05-01 07:07:06', '', 0, 'http://www.sandbox.dev/checkout/', 0, 'page', '', 0),
(7, 1, '2017-05-01 07:07:06', '2017-05-01 07:07:06', '[woocommerce_my_account]', 'My account', '', 'publish', 'closed', 'closed', '', 'my-account', '', '', '2017-05-01 07:07:06', '2017-05-01 07:07:06', '', 0, 'http://www.sandbox.dev/my-account/', 0, 'page', '', 0),
(8, 1, '2017-05-01 07:08:46', '2017-05-01 07:08:46', '', 'prod one', '', 'publish', 'open', 'closed', '', 'prod-one', '', '', '2017-05-01 07:08:46', '2017-05-01 07:08:46', '', 0, 'http://www.sandbox.dev/?post_type=product&#038;p=8', 0, 'product', '', 0),
(9, 1, '2017-05-01 07:07:57', '2017-05-01 07:07:57', '', '2015-top-dentists-award', '', 'inherit', 'open', 'closed', '', '2015-top-dentists-award', '', '', '2017-05-01 07:07:57', '2017-05-01 07:07:57', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/2015-top-dentists-award.png', 0, 'attachment', 'image/png', 0),
(10, 1, '2017-05-01 07:07:59', '2017-05-01 07:07:59', '', '2016TopDentistsLogo', '', 'inherit', 'open', 'closed', '', '2016topdentistslogo', '', '', '2017-05-01 07:07:59', '2017-05-01 07:07:59', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/2016TopDentistsLogo.png', 0, 'attachment', 'image/png', 0),
(11, 1, '2017-05-01 07:08:00', '2017-05-01 07:08:00', '', 'appointment', '', 'inherit', 'open', 'closed', '', 'appointment', '', '', '2017-05-01 07:08:00', '2017-05-01 07:08:00', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/appointment.jpg', 0, 'attachment', 'image/jpeg', 0),
(12, 1, '2017-05-01 07:08:01', '2017-05-01 07:08:01', '', 'award', '', 'inherit', 'open', 'closed', '', 'award', '', '', '2017-05-01 07:08:01', '2017-05-01 07:08:01', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/award.png', 0, 'attachment', 'image/png', 0),
(13, 1, '2017-05-01 07:08:03', '2017-05-01 07:08:03', '', 'award2', '', 'inherit', 'open', 'closed', '', 'award2', '', '', '2017-05-01 07:08:03', '2017-05-01 07:08:03', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/award2.png', 0, 'attachment', 'image/png', 0),
(14, 1, '2017-05-01 07:08:04', '2017-05-01 07:08:04', '', 'doctors', '', 'inherit', 'open', 'closed', '', 'doctors', '', '', '2017-05-01 07:08:04', '2017-05-01 07:08:04', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/doctors.png', 0, 'attachment', 'image/png', 0),
(15, 1, '2017-05-01 07:08:06', '2017-05-01 07:08:06', '', 'google-review-graphic', '', 'inherit', 'open', 'closed', '', 'google-review-graphic', '', '', '2017-05-01 07:08:06', '2017-05-01 07:08:06', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/google-review-graphic.jpg', 0, 'attachment', 'image/jpeg', 0),
(16, 1, '2017-05-01 07:08:07', '2017-05-01 07:08:07', '', 'logo', '', 'inherit', 'open', 'closed', '', 'logo', '', '', '2017-05-01 07:08:07', '2017-05-01 07:08:07', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/logo.png', 0, 'attachment', 'image/png', 0),
(17, 1, '2017-05-01 07:08:08', '2017-05-01 07:08:08', '', 'qoute', '', 'inherit', 'open', 'closed', '', 'qoute', '', '', '2017-05-01 07:08:08', '2017-05-01 07:08:08', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/qoute.png', 0, 'attachment', 'image/png', 0),
(18, 1, '2017-05-01 07:08:09', '2017-05-01 07:08:09', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale', '', '', '2017-05-01 07:08:09', '2017-05-01 07:08:09', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale.jpg', 0, 'attachment', 'image/jpeg', 0),
(19, 1, '2017-05-01 07:08:11', '2017-05-01 07:08:11', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale-2', '', '', '2017-05-01 07:08:11', '2017-05-01 07:08:11', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale.png', 0, 'attachment', 'image/png', 0),
(20, 1, '2017-05-01 07:08:12', '2017-05-01 07:08:12', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(1)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale1', '', '', '2017-05-01 07:08:12', '2017-05-01 07:08:12', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1.jpg', 0, 'attachment', 'image/jpeg', 0),
(21, 1, '2017-05-01 07:08:13', '2017-05-01 07:08:13', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(1)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale1-2', '', '', '2017-05-01 07:08:13', '2017-05-01 07:08:13', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale1.png', 0, 'attachment', 'image/png', 0),
(22, 1, '2017-05-01 07:08:14', '2017-05-01 07:08:14', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(2)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale2', '', '', '2017-05-01 07:08:14', '2017-05-01 07:08:14', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2.jpg', 0, 'attachment', 'image/jpeg', 0),
(23, 1, '2017-05-01 07:08:15', '2017-05-01 07:08:15', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(2)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale2-2', '', '', '2017-05-01 07:08:15', '2017-05-01 07:08:15', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale2.png', 0, 'attachment', 'image/png', 0),
(24, 1, '2017-05-01 07:08:16', '2017-05-01 07:08:16', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(3)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale3', '', '', '2017-05-01 07:08:16', '2017-05-01 07:08:16', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3.jpg', 0, 'attachment', 'image/jpeg', 0),
(25, 1, '2017-05-01 07:08:18', '2017-05-01 07:08:18', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(3)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale3-2', '', '', '2017-05-01 07:08:18', '2017-05-01 07:08:18', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale3.png', 0, 'attachment', 'image/png', 0),
(26, 1, '2017-05-01 07:08:20', '2017-05-01 07:08:20', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(4)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale4', '', '', '2017-05-01 07:08:20', '2017-05-01 07:08:20', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4.jpg', 0, 'attachment', 'image/jpeg', 0),
(27, 1, '2017-05-01 07:08:21', '2017-05-01 07:08:21', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(4)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale4-2', '', '', '2017-05-01 07:08:21', '2017-05-01 07:08:21', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale4.png', 0, 'attachment', 'image/png', 0),
(28, 1, '2017-05-01 07:08:22', '2017-05-01 07:08:22', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(5)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale5', '', '', '2017-05-01 07:08:22', '2017-05-01 07:08:22', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale5.png', 0, 'attachment', 'image/png', 0),
(29, 1, '2017-05-01 07:08:23', '2017-05-01 07:08:23', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(6)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale6', '', '', '2017-05-01 07:08:23', '2017-05-01 07:08:23', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale6.png', 0, 'attachment', 'image/png', 0),
(30, 1, '2017-05-01 07:08:24', '2017-05-01 07:08:24', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(7)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale7', '', '', '2017-05-01 07:08:24', '2017-05-01 07:08:24', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale7.png', 0, 'attachment', 'image/png', 0),
(31, 1, '2017-05-01 07:08:26', '2017-05-01 07:08:26', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(8)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale8', '', '', '2017-05-01 07:08:26', '2017-05-01 07:08:26', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale8.png', 0, 'attachment', 'image/png', 0),
(32, 1, '2017-05-01 07:08:27', '2017-05-01 07:08:27', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(9)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale9', '', '', '2017-05-01 07:08:27', '2017-05-01 07:08:27', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale9.png', 0, 'attachment', 'image/png', 0),
(33, 1, '2017-05-01 07:08:28', '2017-05-01 07:08:28', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(10)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale10', '', '', '2017-05-01 07:08:28', '2017-05-01 07:08:28', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale10.png', 0, 'attachment', 'image/png', 0),
(34, 1, '2017-05-01 07:08:29', '2017-05-01 07:08:29', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(11)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale11', '', '', '2017-05-01 07:08:29', '2017-05-01 07:08:29', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale11.png', 0, 'attachment', 'image/png', 0),
(35, 1, '2017-05-01 07:08:30', '2017-05-01 07:08:30', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(12)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale12', '', '', '2017-05-01 07:08:30', '2017-05-01 07:08:30', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale12.png', 0, 'attachment', 'image/png', 0),
(36, 1, '2017-05-01 07:08:31', '2017-05-01 07:08:31', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(13)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale13', '', '', '2017-05-01 07:08:31', '2017-05-01 07:08:31', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale13.png', 0, 'attachment', 'image/png', 0),
(37, 1, '2017-05-01 07:08:32', '2017-05-01 07:08:32', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(14)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale14', '', '', '2017-05-01 07:08:32', '2017-05-01 07:08:32', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale14.png', 0, 'attachment', 'image/png', 0),
(38, 1, '2017-05-01 07:08:33', '2017-05-01 07:08:33', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(15)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale15', '', '', '2017-05-01 07:08:33', '2017-05-01 07:08:33', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale15.png', 0, 'attachment', 'image/png', 0),
(39, 1, '2017-05-01 07:08:34', '2017-05-01 07:08:34', '', 'Scottsdale Cosmetic Dentist Experienced Cosmetic Dentist in Scottsdale(16)', '', 'inherit', 'open', 'closed', '', 'scottsdale-cosmetic-dentist-experienced-cosmetic-dentist-in-scottsdale16', '', '', '2017-05-01 07:08:34', '2017-05-01 07:08:34', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/Scottsdale-Cosmetic-Dentist-Experienced-Cosmetic-Dentist-in-Scottsdale16.png', 0, 'attachment', 'image/png', 0),
(40, 1, '2017-05-01 07:08:35', '2017-05-01 07:08:35', '', 'star', '', 'inherit', 'open', 'closed', '', 'star', '', '', '2017-05-01 07:08:35', '2017-05-01 07:08:35', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/star.png', 0, 'attachment', 'image/png', 0),
(41, 1, '2017-05-01 07:08:36', '2017-05-01 07:08:36', '', 'studio-gallery', '', 'inherit', 'open', 'closed', '', 'studio-gallery', '', '', '2017-05-01 07:08:36', '2017-05-01 07:08:36', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/studio-gallery.jpg', 0, 'attachment', 'image/jpeg', 0),
(42, 1, '2017-05-01 07:08:37', '2017-05-01 07:08:37', '', 'testimonial', '', 'inherit', 'open', 'closed', '', 'testimonial', '', '', '2017-05-01 07:08:37', '2017-05-01 07:08:37', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/testimonial.jpg', 0, 'attachment', 'image/jpeg', 0),
(43, 1, '2017-05-01 07:08:38', '2017-05-01 07:08:38', '', 'virtual-tour', '', 'inherit', 'open', 'closed', '', 'virtual-tour', '', '', '2017-05-01 07:08:38', '2017-05-01 07:08:38', '', 8, 'http://www.sandbox.dev/wp-content/uploads/2017/05/virtual-tour.jpg', 0, 'attachment', 'image/jpeg', 0),
(44, 1, '2017-05-01 07:11:52', '2017-05-01 07:11:52', '', 'prod one (Copy)', '', 'publish', 'open', 'closed', '', 'prod-one-copy', '', '', '2017-05-01 07:11:58', '2017-05-01 07:11:58', '', 0, 'http://www.sandbox.dev/?post_type=product&#038;p=44', 0, 'product', '', 0),
(45, 1, '2017-05-01 07:12:07', '2017-05-01 07:12:07', '', 'prod one (Copy) (Copy)', '', 'publish', 'open', 'closed', '', 'prod-one-copy-copy', '', '', '2017-05-01 07:12:22', '2017-05-01 07:12:22', '', 0, 'http://www.sandbox.dev/?post_type=product&#038;p=45', 0, 'product', '', 0),
(46, 1, '2017-05-01 07:12:27', '2017-05-01 07:12:27', '', 'prod one (Copy) (Copy) (Copy)', '', 'draft', 'open', 'closed', '', '', '', '', '2017-05-01 07:12:27', '2017-05-01 07:12:27', '', 0, 'http://www.sandbox.dev/?post_type=product&p=46', 0, 'product', '', 0),
(47, 1, '2017-05-01 07:12:27', '2017-05-01 07:12:27', '', 'prod one (Copy) (Copy) (Copy)', '', 'publish', 'open', 'closed', '', 'prod-one-copy-copy-copy', '', '', '2017-05-01 07:12:33', '2017-05-01 07:12:33', '', 0, 'http://www.sandbox.dev/?post_type=product&#038;p=47', 0, 'product', '', 0),
(153, 1, '2017-05-01 12:49:09', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 12:49:09', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=part&p=153', 0, 'part', '', 0),
(154, 1, '2017-05-01 12:49:12', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 12:49:12', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=part&p=154', 0, 'part', '', 0),
(155, 1, '2017-05-01 12:49:29', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 12:49:29', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=assembly&p=155', 0, 'assembly', '', 0),
(156, 1, '2017-05-01 12:49:32', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 12:49:32', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=assembly&p=156', 0, 'assembly', '', 0),
(161, 1, '2017-05-01 12:55:05', '0000-00-00 00:00:00', '', 'AUTO-DRAFT', '', 'auto-draft', 'open', 'closed', '', '', '', '', '2017-05-01 12:55:05', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=product&p=161', 0, 'product', '', 0),
(162, 1, '2017-05-01 13:02:21', '2017-05-01 13:02:21', '', 'Assembly One', '', 'publish', 'closed', 'closed', '', 'assembly-one', '', '', '2017-05-01 17:56:52', '2017-05-01 17:56:52', '', 0, 'http://www.sandbox.dev/?post_type=assembly&#038;p=162', 0, 'assembly', '', 0),
(163, 1, '2017-05-01 13:02:21', '2017-05-01 13:02:21', '', 'Assembly One', '', 'inherit', 'closed', 'closed', '', '162-revision-v1', '', '', '2017-05-01 13:02:21', '2017-05-01 13:02:21', '', 162, 'http://www.sandbox.dev/2017/05/01/162-revision-v1/', 0, 'revision', '', 0),
(164, 1, '2017-05-01 13:02:35', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 13:02:35', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=part&p=164', 0, 'part', '', 0),
(165, 1, '2017-05-01 16:51:38', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 16:51:38', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=part&p=165', 0, 'part', '', 0),
(166, 1, '2017-05-01 16:51:59', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 16:51:59', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=part&p=166', 0, 'part', '', 0),
(167, 1, '2017-05-01 17:16:13', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2017-05-01 17:16:13', '0000-00-00 00:00:00', '', 0, 'http://www.sandbox.dev/?post_type=part&p=167', 0, 'part', '', 0),
(168, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:8:{s:8:"location";a:1:{i:0;a:1:{i:0;a:3:{s:5:"param";s:9:"post_type";s:8:"operator";s:2:"==";s:5:"value";s:8:"assembly";}}}s:8:"position";s:6:"normal";s:5:"style";s:7:"default";s:15:"label_placement";s:4:"left";s:21:"instruction_placement";s:5:"label";s:14:"hide_on_screen";a:4:{i:0;s:11:"the_content";i:1;s:7:"excerpt";i:2;s:13:"custom_fields";i:3;s:10:"discussion";}s:11:"description";s:0:"";s:5:"local";s:3:"php";}', 'Assembly', 'assembly', 'publish', 'closed', 'closed', '', 'group_58bec9c065391', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 0, 'http://www.sandbox.dev/?post_type=acf-field-group&p=168', 0, 'acf-field-group', '', 0),
(169, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:7:{s:4:"type";s:3:"tab";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:9:"placement";s:3:"top";s:8:"endpoint";i:0;}', 'Basic', '', 'publish', 'closed', 'closed', '', 'field_58bed89fe21dc', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=169', 0, 'acf-field', '', 0),
(170, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Assembly ID', 'assembly_id', 'publish', 'closed', 'closed', '', 'field_58bec9cbae35a', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=170', 1, 'acf-field', '', 0),
(171, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Assembly No.', 'assembly_no', 'publish', 'closed', 'closed', '', 'field_58bec9d3ae35b', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=171', 2, 'acf-field', '', 0),
(172, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Assembly Name', 'assembly_name', 'publish', 'closed', 'closed', '', 'field_58bec9d8ae35c', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=172', 3, 'acf-field', '', 0),
(173, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:13:{s:4:"type";s:8:"taxonomy";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:8:"taxonomy";s:17:"assembly_category";s:10:"field_type";s:8:"checkbox";s:10:"allow_null";i:0;s:8:"add_term";i:1;s:10:"save_terms";i:1;s:10:"load_terms";i:1;s:13:"return_format";s:6:"object";s:8:"multiple";i:0;}', 'Assembly Category', 'assembly_category', 'publish', 'closed', 'closed', '', 'field_58bed73b66f46', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=173', 4, 'acf-field', '', 0),
(174, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:8:"textarea";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:9:"maxlength";s:0:"";s:4:"rows";s:0:"";s:9:"new_lines";s:7:"wpautop";}', 'Assembly Description', 'assembly_description', 'publish', 'closed', 'closed', '', 'field_58bed72466f45', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=174', 5, 'acf-field', '', 0),
(175, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:7:{s:4:"type";s:3:"tab";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:9:"placement";s:3:"top";s:8:"endpoint";i:0;}', 'Materials', '', 'publish', 'closed', 'closed', '', 'field_58bed8b1e21dd', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=175', 6, 'acf-field', '', 0),
(176, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:8:"repeater";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:9:"collapsed";s:0:"";s:3:"min";i:0;s:3:"max";i:0;s:6:"layout";s:3:"row";s:12:"button_label";s:0:"";}', 'Sub-Assemblies', 'sub-assemblies', 'publish', 'closed', 'closed', '', 'field_58bec9fc4dcd4', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=176', 7, 'acf-field', '', 0),
(177, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:11:{s:4:"type";s:11:"post_object";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:9:"post_type";a:2:{i:0;s:8:"assembly";i:1;s:4:"part";}s:8:"taxonomy";a:0:{}s:10:"allow_null";i:1;s:8:"multiple";i:0;s:13:"return_format";s:6:"object";s:2:"ui";i:1;}', 'Sub-Assembly', 'sub-assembly', 'publish', 'closed', 'closed', '', 'field_58beca404dcd5', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 176, 'http://www.sandbox.dev/?post_type=acf-field&p=177', 0, 'acf-field', '', 0),
(178, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Qty', 'qty', 'publish', 'closed', 'closed', '', 'field_58beca774dcd6', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 176, 'http://www.sandbox.dev/?post_type=acf-field&p=178', 1, 'acf-field', '', 0),
(179, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"file";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"return_format";s:5:"array";s:7:"library";s:3:"all";s:8:"min_size";s:0:"";s:8:"max_size";s:0:"";s:10:"mime_types";s:0:"";}', 'Assembly Files', 'assembly_files', 'publish', 'closed', 'closed', '', 'field_58bed77ab852a', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=179', 8, 'acf-field', '', 0),
(180, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:16:{s:4:"type";s:7:"gallery";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:3:"min";s:0:"";s:3:"max";s:0:"";s:6:"insert";s:6:"append";s:7:"library";s:3:"all";s:9:"min_width";s:0:"";s:10:"min_height";s:0:"";s:8:"min_size";s:0:"";s:9:"max_width";s:0:"";s:10:"max_height";s:0:"";s:8:"max_size";s:0:"";s:10:"mime_types";s:0:"";}', 'Assembly Images', 'assembly_images', 'publish', 'closed', 'closed', '', 'field_58bed7a7b852b', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 168, 'http://www.sandbox.dev/?post_type=acf-field&p=180', 9, 'acf-field', '', 0),
(181, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:8:{s:8:"location";a:1:{i:0;a:1:{i:0;a:3:{s:5:"param";s:9:"post_type";s:8:"operator";s:2:"==";s:5:"value";s:4:"part";}}}s:8:"position";s:6:"normal";s:5:"style";s:7:"default";s:15:"label_placement";s:4:"left";s:21:"instruction_placement";s:5:"label";s:14:"hide_on_screen";a:3:{i:0;s:7:"excerpt";i:1;s:13:"custom_fields";i:2;s:6:"author";}s:11:"description";s:0:"";s:5:"local";s:3:"php";}', 'Part', 'part', 'publish', 'closed', 'closed', '', 'group_58be21633a48e', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 0, 'http://www.sandbox.dev/?post_type=acf-field-group&p=181', 0, 'acf-field-group', '', 0),
(182, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:7:{s:4:"type";s:3:"tab";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:9:"placement";s:3:"top";s:8:"endpoint";i:0;}', 'Basic', '', 'publish', 'closed', 'closed', '', 'field_58bed3428e47c', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=182', 0, 'acf-field', '', 0),
(183, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:1;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Part ID', 'part_id', 'publish', 'closed', 'closed', '', 'field_58be21cb63558', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=183', 1, 'acf-field', '', 0),
(184, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:1;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Part No.', 'part_no', 'publish', 'closed', 'closed', '', 'field_58be224180f49', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=184', 2, 'acf-field', '', 0),
(185, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:13:{s:4:"type";s:8:"taxonomy";s:12:"instructions";s:0:"";s:8:"required";i:1;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:8:"taxonomy";s:13:"part-category";s:10:"field_type";s:8:"checkbox";s:10:"allow_null";i:1;s:8:"add_term";i:1;s:10:"save_terms";i:1;s:10:"load_terms";i:1;s:13:"return_format";s:6:"object";s:8:"multiple";i:0;}', 'Part Category', 'part_category', 'publish', 'closed', 'closed', '', 'field_58bed5eb041ea', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=185', 3, 'acf-field', '', 0),
(186, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Part Name', 'part_name', 'publish', 'closed', 'closed', '', 'field_58be224e80f4a', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=186', 4, 'acf-field', '', 0),
(187, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Part Sku', 'part_sku', 'publish', 'closed', 'closed', '', 'field_58be2211b049f', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=187', 5, 'acf-field', '', 0),
(188, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:8:"textarea";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:9:"maxlength";s:0:"";s:4:"rows";s:0:"";s:9:"new_lines";s:0:"";}', 'Part Description', 'part_description', 'publish', 'closed', 'closed', '', 'field_58be225a80f4b', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=188', 6, 'acf-field', '', 0),
(189, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:7:{s:4:"type";s:3:"tab";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:9:"placement";s:3:"top";s:8:"endpoint";i:0;}', 'Details', '', 'publish', 'closed', 'closed', '', 'field_58bed39aaa35e', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=189', 7, 'acf-field', '', 0),
(190, 1, '2017-05-01 17:49:10', '2017-05-01 17:49:10', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Part Units', 'part_units', 'publish', 'closed', 'closed', '', 'field_58be23ec87b4e', '', '', '2017-05-01 17:49:10', '2017-05-01 17:49:10', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=190', 8, 'acf-field', '', 0),
(191, 1, '2017-05-01 17:49:11', '2017-05-01 17:49:11', 'a:12:{s:4:"type";s:6:"number";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:3:"min";s:0:"";s:3:"max";s:0:"";s:4:"step";s:0:"";}', 'Part Cost', 'part_cost', 'publish', 'closed', 'closed', '', 'field_58be26e874984', '', '', '2017-05-01 17:49:11', '2017-05-01 17:49:11', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=191', 9, 'acf-field', '', 0),
(192, 1, '2017-05-01 17:49:11', '2017-05-01 17:49:11', 'a:12:{s:4:"type";s:6:"number";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:3:"min";s:0:"";s:3:"max";s:0:"";s:4:"step";s:0:"";}', 'Part Weight', 'part_weight', 'publish', 'closed', 'closed', '', 'field_58be25d7bc42b', '', '', '2017-05-01 17:49:11', '2017-05-01 17:49:11', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=192', 10, 'acf-field', '', 0),
(193, 1, '2017-05-01 17:49:11', '2017-05-01 17:49:11', 'a:10:{s:4:"type";s:4:"text";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:7:"prepend";s:0:"";s:6:"append";s:0:"";s:9:"maxlength";s:0:"";}', 'Part Measurement', 'part_measurement', 'publish', 'closed', 'closed', '', 'field_58be27115df5e', '', '', '2017-05-01 17:49:11', '2017-05-01 17:49:11', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=193', 11, 'acf-field', '', 0),
(194, 1, '2017-05-01 17:49:11', '2017-05-01 17:49:11', 'a:10:{s:4:"type";s:8:"textarea";s:12:"instructions";s:0:"";s:8:"required";i:0;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:0:"";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:11:"placeholder";s:0:"";s:9:"maxlength";s:0:"";s:4:"rows";s:0:"";s:9:"new_lines";s:7:"wpautop";}', 'Part Notes', 'part_notes', 'publish', 'closed', 'closed', '', 'field_58be268b32e00', '', '', '2017-05-01 17:49:11', '2017-05-01 17:49:11', '', 181, 'http://www.sandbox.dev/?post_type=acf-field&p=194', 12, 'acf-field', '', 0),
(195, 1, '2017-05-01 13:02:21', '2017-05-01 13:02:21', '', 'Assembly two', '', 'publish', 'closed', 'closed', '', 'assembly-one-2', '', '', '2017-05-01 17:56:49', '2017-05-01 17:56:49', '', 0, 'http://www.sandbox.dev/assembly/assembly-one-2/', 0, 'assembly', '', 0),
(196, 1, '2017-05-01 17:52:54', '2017-05-01 17:52:54', '', 'Assembly One', '', 'inherit', 'closed', 'closed', '', '195-revision-v1', '', '', '2017-05-01 17:52:54', '2017-05-01 17:52:54', '', 195, 'http://www.sandbox.dev/2017/05/01/195-revision-v1/', 0, 'revision', '', 0),
(197, 1, '2017-05-01 17:53:12', '2017-05-01 17:53:12', '', 'Assembly two', '', 'inherit', 'closed', 'closed', '', '195-revision-v1', '', '', '2017-05-01 17:53:12', '2017-05-01 17:53:12', '', 195, 'http://www.sandbox.dev/2017/05/01/195-revision-v1/', 0, 'revision', '', 0),
(198, 1, '2017-05-01 13:02:21', '2017-05-01 13:02:21', '', 'Assembly three', '', 'publish', 'closed', 'closed', '', 'assembly-one-2-2', '', '', '2017-05-01 17:56:52', '2017-05-01 17:56:52', '', 0, 'http://www.sandbox.dev/assembly/assembly-two/', 0, 'assembly', '', 0),
(199, 1, '2017-05-01 17:54:37', '2017-05-01 17:54:37', '', 'Assembly two', '', 'inherit', 'closed', 'closed', '', '198-revision-v1', '', '', '2017-05-01 17:54:37', '2017-05-01 17:54:37', '', 198, 'http://www.sandbox.dev/2017/05/01/198-revision-v1/', 0, 'revision', '', 0),
(200, 1, '2017-05-01 17:54:50', '2017-05-01 17:54:50', '', 'Assembly three', '', 'inherit', 'closed', 'closed', '', '198-revision-v1', '', '', '2017-05-01 17:54:50', '2017-05-01 17:54:50', '', 198, 'http://www.sandbox.dev/2017/05/01/198-revision-v1/', 0, 'revision', '', 0),
(201, 1, '2017-05-01 13:02:21', '2017-05-01 13:02:21', '', 'Assembly four', '', 'publish', 'closed', 'closed', '', 'assembly-four', '', '', '2017-05-01 17:55:46', '2017-05-01 17:55:46', '', 0, 'http://www.sandbox.dev/?post_type=assembly&#038;p=201', 0, 'assembly', '', 0),
(202, 1, '2017-05-01 17:55:21', '2017-05-01 17:55:21', '', 'Assembly four', '', 'inherit', 'closed', 'closed', '', '201-revision-v1', '', '', '2017-05-01 17:55:21', '2017-05-01 17:55:21', '', 201, 'http://www.sandbox.dev/2017/05/01/201-revision-v1/', 0, 'revision', '', 0),
(203, 1, '2017-05-01 17:55:46', '2017-05-01 17:55:46', '', 'Assembly four', '', 'inherit', 'closed', 'closed', '', '201-revision-v1', '', '', '2017-05-01 17:55:46', '2017-05-01 17:55:46', '', 201, 'http://www.sandbox.dev/2017/05/01/201-revision-v1/', 0, 'revision', '', 0),
(204, 1, '2017-05-01 17:56:19', '2017-05-01 17:56:19', '', 'Assembly three', '', 'inherit', 'closed', 'closed', '', '198-revision-v1', '', '', '2017-05-01 17:56:19', '2017-05-01 17:56:19', '', 198, 'http://www.sandbox.dev/2017/05/01/198-revision-v1/', 0, 'revision', '', 0),
(205, 1, '2017-05-01 17:56:49', '2017-05-01 17:56:49', '', 'Assembly two', '', 'inherit', 'closed', 'closed', '', '195-revision-v1', '', '', '2017-05-01 17:56:49', '2017-05-01 17:56:49', '', 195, 'http://www.sandbox.dev/2017/05/01/195-revision-v1/', 0, 'revision', '', 0),
(206, 1, '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 'Part a', '', 'publish', 'closed', 'closed', '', 'part-a', '', '', '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 0, 'http://www.sandbox.dev/?post_type=part&#038;p=206', 0, 'part', '', 0),
(207, 1, '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 'Part a', '', 'inherit', 'closed', 'closed', '', '206-revision-v1', '', '', '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 206, 'http://www.sandbox.dev/2017/05/01/206-revision-v1/', 0, 'revision', '', 0),
(208, 1, '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 'Part b', '', 'publish', 'closed', 'closed', '', 'part-b', '', '', '2017-05-01 17:58:16', '2017-05-01 17:58:16', '', 0, 'http://www.sandbox.dev/?post_type=part&#038;p=208', 0, 'part', '', 0),
(209, 1, '2017-05-01 17:58:16', '2017-05-01 17:58:16', '', 'Part b', '', 'inherit', 'closed', 'closed', '', '208-revision-v1', '', '', '2017-05-01 17:58:16', '2017-05-01 17:58:16', '', 208, 'http://www.sandbox.dev/2017/05/01/208-revision-v1/', 0, 'revision', '', 0),
(210, 1, '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 'Part c', '', 'publish', 'closed', 'closed', '', 'part-c', '', '', '2017-05-01 17:58:38', '2017-05-01 17:58:38', '', 0, 'http://www.sandbox.dev/?post_type=part&#038;p=210', 0, 'part', '', 0),
(211, 1, '2017-05-01 17:58:38', '2017-05-01 17:58:38', '', 'Part c', '', 'inherit', 'closed', 'closed', '', '210-revision-v1', '', '', '2017-05-01 17:58:38', '2017-05-01 17:58:38', '', 210, 'http://www.sandbox.dev/2017/05/01/210-revision-v1/', 0, 'revision', '', 0),
(212, 1, '2017-05-01 17:57:55', '2017-05-01 17:57:55', '', 'Part d', '', 'publish', 'closed', 'closed', '', 'part-d', '', '', '2017-05-01 17:59:01', '2017-05-01 17:59:01', '', 0, 'http://www.sandbox.dev/?post_type=part&#038;p=212', 0, 'part', '', 0),
(213, 1, '2017-05-01 17:59:01', '2017-05-01 17:59:01', '', 'Part d', '', 'inherit', 'closed', 'closed', '', '212-revision-v1', '', '', '2017-05-01 17:59:01', '2017-05-01 17:59:01', '', 212, 'http://www.sandbox.dev/2017/05/01/212-revision-v1/', 0, 'revision', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_termmeta`
--

INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) VALUES
(1, 15, 'order', '0'),
(2, 16, 'order', '0'),
(3, 17, 'order', '0'),
(4, 18, 'order', '0'),
(5, 18, 'product_count_product_cat', '4'),
(6, 17, 'product_count_product_cat', '4'),
(7, 16, 'product_count_product_cat', '4'),
(8, 15, 'product_count_product_cat', '4');

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0),
(2, 'simple', 'simple', 0),
(3, 'grouped', 'grouped', 0),
(4, 'variable', 'variable', 0),
(5, 'external', 'external', 0),
(6, 'exclude-from-search', 'exclude-from-search', 0),
(7, 'exclude-from-catalog', 'exclude-from-catalog', 0),
(8, 'featured', 'featured', 0),
(9, 'outofstock', 'outofstock', 0),
(10, 'rated-1', 'rated-1', 0),
(11, 'rated-2', 'rated-2', 0),
(12, 'rated-3', 'rated-3', 0),
(13, 'rated-4', 'rated-4', 0),
(14, 'rated-5', 'rated-5', 0),
(15, 'one', 'one', 0),
(16, 'two', 'two', 0),
(17, 'three', 'three', 0),
(18, 'four', 'four', 0),
(19, 'Part', 'part', 0),
(20, 'Component', 'component', 0),
(21, 'Raw Material', 'raw-material', 0),
(22, 'Requisition', 'requisition', 0),
(23, 'Purchase Order', 'purchase-order', 0),
(24, 'Work Order', 'work-order', 0),
(25, 'Receiving', 'receiving', 0),
(26, 'Shipping', 'shipping', 0),
(27, 'Cat two', 'cat-two', 0),
(28, 'Cat one', 'cat-one', 0),
(29, 'Cat three', 'cat-three', 0),
(30, 'Cat four', 'cat-four', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(8, 2, 0),
(8, 15, 0),
(8, 16, 0),
(8, 17, 0),
(8, 18, 0),
(44, 2, 0),
(44, 14, 0),
(44, 15, 0),
(44, 16, 0),
(44, 17, 0),
(44, 18, 0),
(45, 2, 0),
(45, 14, 0),
(45, 15, 0),
(45, 16, 0),
(45, 17, 0),
(45, 18, 0),
(46, 2, 0),
(46, 14, 0),
(46, 15, 0),
(46, 16, 0),
(46, 17, 0),
(46, 18, 0),
(47, 2, 0),
(47, 14, 0),
(47, 15, 0),
(47, 16, 0),
(47, 17, 0),
(47, 18, 0),
(162, 27, 0),
(162, 30, 0),
(195, 27, 0),
(198, 27, 0),
(198, 29, 0),
(201, 27, 0),
(201, 29, 0),
(206, 19, 0),
(208, 19, 0),
(210, 19, 0),
(212, 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1),
(2, 2, 'product_type', '', 0, 4),
(3, 3, 'product_type', '', 0, 0),
(4, 4, 'product_type', '', 0, 0),
(5, 5, 'product_type', '', 0, 0),
(6, 6, 'product_visibility', '', 0, 0),
(7, 7, 'product_visibility', '', 0, 0),
(8, 8, 'product_visibility', '', 0, 0),
(9, 9, 'product_visibility', '', 0, 0),
(10, 10, 'product_visibility', '', 0, 0),
(11, 11, 'product_visibility', '', 0, 0),
(12, 12, 'product_visibility', '', 0, 0),
(13, 13, 'product_visibility', '', 0, 0),
(14, 14, 'product_visibility', '', 0, 3),
(15, 15, 'product_cat', '', 0, 4),
(16, 16, 'product_cat', '', 0, 4),
(17, 17, 'product_cat', '', 0, 4),
(18, 18, 'product_cat', '', 0, 4),
(19, 19, 'part-category', '', 0, 4),
(20, 20, 'part-category', '', 0, 0),
(21, 21, 'part-category', '', 0, 0),
(22, 22, 'inventory-category', '', 0, 0),
(23, 23, 'inventory-category', '', 0, 0),
(24, 24, 'inventory-category', '', 0, 0),
(25, 25, 'inventory-category', '', 0, 0),
(26, 26, 'inventory-category', '', 0, 0),
(27, 27, 'assembly_category', '', 0, 4),
(28, 28, 'assembly_category', '', 0, 0),
(29, 29, 'assembly_category', '', 0, 2),
(30, 30, 'assembly_category', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'dev'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'comment_shortcuts', 'false'),
(7, 1, 'admin_color', 'fresh'),
(8, 1, 'use_ssl', '0'),
(9, 1, 'show_admin_bar_front', 'true'),
(10, 1, 'locale', ''),
(11, 1, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
(12, 1, 'wp_user_level', '10'),
(13, 1, 'dismissed_wp_pointers', ''),
(14, 1, 'show_welcome_panel', '1'),
(15, 1, 'session_tokens', 'a:2:{s:64:"2e60115b0e4f15b940b9a91790d7ba17a400d179952d9d1da5c2d20f37bbc48e";a:4:{s:10:"expiration";i:1494831825;s:2:"ip";s:3:"::1";s:2:"ua";s:121:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";s:5:"login";i:1493622225;}s:64:"60b5762041d92b93b48897741139f4081529614fa0310661dd401389af9bb0c1";a:4:{s:10:"expiration";i:1494849730;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:121:"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36";s:5:"login";i:1493640130;}}'),
(16, 1, 'wp_dashboard_quick_press_last_post_id', '3'),
(17, 1, 'closedpostboxes_product', 'a:0:{}'),
(18, 1, 'metaboxhidden_product', 'a:2:{i:0;s:10:"postcustom";i:1;s:7:"slugdiv";}'),
(19, 1, 'wp_user-settings', 'libraryContent=browse'),
(20, 1, 'wp_user-settings-time', '1493622522');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'dev', '$P$By5zpSOfIQv/iDJtzBflc9YpvUoa82.', 'dev', 'dev@dev.com', '', '2017-05-01 07:03:44', '', 0, 'dev');

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_api_keys`
--

CREATE TABLE `wp_woocommerce_api_keys` (
  `key_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consumer_key` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consumer_secret` char(43) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nonces` longtext COLLATE utf8mb4_unicode_ci,
  `truncated_key` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_access` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_attribute_taxonomies`
--

CREATE TABLE `wp_woocommerce_attribute_taxonomies` (
  `attribute_id` bigint(20) unsigned NOT NULL,
  `attribute_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_label` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attribute_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_orderby` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_public` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_downloadable_product_permissions`
--

CREATE TABLE `wp_woocommerce_downloadable_product_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `download_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `order_key` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `downloads_remaining` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_granted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access_expires` datetime DEFAULT NULL,
  `download_count` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_log`
--

CREATE TABLE `wp_woocommerce_log` (
  `log_id` bigint(20) unsigned NOT NULL,
  `timestamp` datetime NOT NULL,
  `level` smallint(4) NOT NULL,
  `source` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_order_itemmeta`
--

CREATE TABLE `wp_woocommerce_order_itemmeta` (
  `meta_id` bigint(20) unsigned NOT NULL,
  `order_item_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_order_items`
--

CREATE TABLE `wp_woocommerce_order_items` (
  `order_item_id` bigint(20) unsigned NOT NULL,
  `order_item_name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `order_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_payment_tokenmeta`
--

CREATE TABLE `wp_woocommerce_payment_tokenmeta` (
  `meta_id` bigint(20) unsigned NOT NULL,
  `payment_token_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_payment_tokens`
--

CREATE TABLE `wp_woocommerce_payment_tokens` (
  `token_id` bigint(20) unsigned NOT NULL,
  `gateway_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_sessions`
--

CREATE TABLE `wp_woocommerce_sessions` (
  `session_id` bigint(20) unsigned NOT NULL,
  `session_key` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_expiry` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_woocommerce_sessions`
--

INSERT INTO `wp_woocommerce_sessions` (`session_id`, `session_key`, `session_value`, `session_expiry`) VALUES
(1, '1', 'a:1:{s:8:"customer";s:652:"a:24:{s:8:"postcode";s:0:"";s:4:"city";s:0:"";s:9:"address_1";s:0:"";s:7:"address";s:0:"";s:9:"address_2";s:0:"";s:5:"state";s:2:"AL";s:7:"country";s:2:"US";s:17:"shipping_postcode";s:0:"";s:13:"shipping_city";s:0:"";s:18:"shipping_address_1";s:0:"";s:16:"shipping_address";s:0:"";s:18:"shipping_address_2";s:0:"";s:14:"shipping_state";s:2:"AL";s:16:"shipping_country";s:2:"US";s:13:"is_vat_exempt";b:0;s:19:"calculated_shipping";b:0;s:10:"first_name";s:0:"";s:9:"last_name";s:0:"";s:7:"company";s:0:"";s:5:"phone";s:0:"";s:5:"email";s:11:"dev@dev.com";s:19:"shipping_first_name";s:0:"";s:18:"shipping_last_name";s:0:"";s:16:"shipping_company";s:0:"";}";}', 1493795256);

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_shipping_zones`
--

CREATE TABLE `wp_woocommerce_shipping_zones` (
  `zone_id` bigint(20) unsigned NOT NULL,
  `zone_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone_order` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_shipping_zone_locations`
--

CREATE TABLE `wp_woocommerce_shipping_zone_locations` (
  `location_id` bigint(20) unsigned NOT NULL,
  `zone_id` bigint(20) unsigned NOT NULL,
  `location_code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_shipping_zone_methods`
--

CREATE TABLE `wp_woocommerce_shipping_zone_methods` (
  `zone_id` bigint(20) unsigned NOT NULL,
  `instance_id` bigint(20) unsigned NOT NULL,
  `method_id` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_order` bigint(20) unsigned NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_tax_rates`
--

CREATE TABLE `wp_woocommerce_tax_rates` (
  `tax_rate_id` bigint(20) unsigned NOT NULL,
  `tax_rate_country` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate_state` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tax_rate_priority` bigint(20) unsigned NOT NULL,
  `tax_rate_compound` int(1) NOT NULL DEFAULT '0',
  `tax_rate_shipping` int(1) NOT NULL DEFAULT '1',
  `tax_rate_order` bigint(20) unsigned NOT NULL,
  `tax_rate_class` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woocommerce_tax_rate_locations`
--

CREATE TABLE `wp_woocommerce_tax_rate_locations` (
  `location_id` bigint(20) unsigned NOT NULL,
  `location_code` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_rate_id` bigint(20) unsigned NOT NULL,
  `location_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_woo_bom`
--

CREATE TABLE `wp_woo_bom` (
  `id` mediumint(9) NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `name` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wp_woo_bom`
--

INSERT INTO `wp_woo_bom` (`id`, `time`, `name`, `text`, `url`) VALUES
(1, '2017-05-01 09:19:51', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(2, '2017-05-01 09:19:56', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(3, '2017-05-01 09:20:58', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(4, '2017-05-01 09:21:24', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(5, '2017-05-01 09:22:35', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(6, '2017-05-01 09:22:45', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(7, '2017-05-01 09:22:51', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(8, '2017-05-01 09:22:57', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(9, '2017-05-01 11:28:33', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(10, '2017-05-01 11:29:25', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(11, '2017-05-01 11:29:27', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(12, '2017-05-01 11:29:42', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(13, '2017-05-01 11:30:28', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(14, '2017-05-01 11:30:43', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(15, '2017-05-01 11:30:58', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(16, '2017-05-01 11:33:00', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(17, '2017-05-01 11:34:59', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(18, '2017-05-01 11:37:00', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(19, '2017-05-01 11:37:09', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(20, '2017-05-01 11:37:11', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(21, '2017-05-01 11:37:14', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(22, '2017-05-01 11:37:16', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(23, '2017-05-01 11:37:28', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(24, '2017-05-01 11:37:29', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(25, '2017-05-01 11:37:42', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(26, '2017-05-01 11:37:44', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(27, '2017-05-01 11:38:00', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(28, '2017-05-01 11:39:21', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(29, '2017-05-01 11:39:22', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(30, '2017-05-01 11:39:24', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(31, '2017-05-01 11:39:35', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(32, '2017-05-01 11:40:36', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(33, '2017-05-01 11:41:37', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(34, '2017-05-01 11:42:57', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(35, '2017-05-01 11:42:59', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(36, '2017-05-01 11:44:01', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(37, '2017-05-01 11:44:43', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(38, '2017-05-01 11:44:46', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(39, '2017-05-01 11:44:51', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(40, '2017-05-01 11:44:53', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(41, '2017-05-01 11:45:08', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(42, '2017-05-01 11:46:44', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(43, '2017-05-01 11:46:59', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(44, '2017-05-01 11:47:15', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(45, '2017-05-01 11:47:29', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(46, '2017-05-01 11:48:01', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(47, '2017-05-01 11:49:25', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(48, '2017-05-01 11:49:28', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(49, '2017-05-01 11:49:31', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(50, '2017-05-01 11:49:32', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(51, '2017-05-01 11:49:34', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(52, '2017-05-01 11:49:51', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(53, '2017-05-01 11:50:14', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(54, '2017-05-01 11:50:15', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(55, '2017-05-01 11:50:18', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(56, '2017-05-01 11:50:33', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(57, '2017-05-01 11:50:49', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(58, '2017-05-01 11:52:50', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(59, '2017-05-01 11:54:51', 'Mr. WordPress', 'Congratulations, you just completed the installation!', ''),
(60, '2017-05-01 11:56:50', 'Mr. WordPress', 'Congratulations, you just completed the installation!', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10)),
  ADD KEY `woo_idx_comment_type` (`comment_type`);

--
-- Indexes for table `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Indexes for table `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`);

--
-- Indexes for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Indexes for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Indexes for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Indexes for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Indexes for table `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `wp_woocommerce_api_keys`
--
ALTER TABLE `wp_woocommerce_api_keys`
  ADD PRIMARY KEY (`key_id`),
  ADD KEY `consumer_key` (`consumer_key`),
  ADD KEY `consumer_secret` (`consumer_secret`);

--
-- Indexes for table `wp_woocommerce_attribute_taxonomies`
--
ALTER TABLE `wp_woocommerce_attribute_taxonomies`
  ADD PRIMARY KEY (`attribute_id`),
  ADD KEY `attribute_name` (`attribute_name`(20));

--
-- Indexes for table `wp_woocommerce_downloadable_product_permissions`
--
ALTER TABLE `wp_woocommerce_downloadable_product_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD KEY `download_order_key_product` (`product_id`,`order_id`,`order_key`(16),`download_id`),
  ADD KEY `download_order_product` (`download_id`,`order_id`,`product_id`);

--
-- Indexes for table `wp_woocommerce_log`
--
ALTER TABLE `wp_woocommerce_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `level` (`level`);

--
-- Indexes for table `wp_woocommerce_order_itemmeta`
--
ALTER TABLE `wp_woocommerce_order_itemmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `order_item_id` (`order_item_id`),
  ADD KEY `meta_key` (`meta_key`(32));

--
-- Indexes for table `wp_woocommerce_order_items`
--
ALTER TABLE `wp_woocommerce_order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `wp_woocommerce_payment_tokenmeta`
--
ALTER TABLE `wp_woocommerce_payment_tokenmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `payment_token_id` (`payment_token_id`),
  ADD KEY `meta_key` (`meta_key`(32));

--
-- Indexes for table `wp_woocommerce_payment_tokens`
--
ALTER TABLE `wp_woocommerce_payment_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wp_woocommerce_sessions`
--
ALTER TABLE `wp_woocommerce_sessions`
  ADD PRIMARY KEY (`session_key`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `wp_woocommerce_shipping_zones`
--
ALTER TABLE `wp_woocommerce_shipping_zones`
  ADD PRIMARY KEY (`zone_id`);

--
-- Indexes for table `wp_woocommerce_shipping_zone_locations`
--
ALTER TABLE `wp_woocommerce_shipping_zone_locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `location_type_code` (`location_type`(10),`location_code`(20));

--
-- Indexes for table `wp_woocommerce_shipping_zone_methods`
--
ALTER TABLE `wp_woocommerce_shipping_zone_methods`
  ADD PRIMARY KEY (`instance_id`);

--
-- Indexes for table `wp_woocommerce_tax_rates`
--
ALTER TABLE `wp_woocommerce_tax_rates`
  ADD PRIMARY KEY (`tax_rate_id`),
  ADD KEY `tax_rate_country` (`tax_rate_country`),
  ADD KEY `tax_rate_state` (`tax_rate_state`(2)),
  ADD KEY `tax_rate_class` (`tax_rate_class`(10)),
  ADD KEY `tax_rate_priority` (`tax_rate_priority`);

--
-- Indexes for table `wp_woocommerce_tax_rate_locations`
--
ALTER TABLE `wp_woocommerce_tax_rate_locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `tax_rate_id` (`tax_rate_id`),
  ADD KEY `location_type_code` (`location_type`(10),`location_code`(20));

--
-- Indexes for table `wp_woo_bom`
--
ALTER TABLE `wp_woo_bom`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=422;
--
-- AUTO_INCREMENT for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=840;
--
-- AUTO_INCREMENT for table `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=214;
--
-- AUTO_INCREMENT for table `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wp_woocommerce_api_keys`
--
ALTER TABLE `wp_woocommerce_api_keys`
  MODIFY `key_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_attribute_taxonomies`
--
ALTER TABLE `wp_woocommerce_attribute_taxonomies`
  MODIFY `attribute_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_downloadable_product_permissions`
--
ALTER TABLE `wp_woocommerce_downloadable_product_permissions`
  MODIFY `permission_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_log`
--
ALTER TABLE `wp_woocommerce_log`
  MODIFY `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_order_itemmeta`
--
ALTER TABLE `wp_woocommerce_order_itemmeta`
  MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_order_items`
--
ALTER TABLE `wp_woocommerce_order_items`
  MODIFY `order_item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_payment_tokenmeta`
--
ALTER TABLE `wp_woocommerce_payment_tokenmeta`
  MODIFY `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_payment_tokens`
--
ALTER TABLE `wp_woocommerce_payment_tokens`
  MODIFY `token_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_sessions`
--
ALTER TABLE `wp_woocommerce_sessions`
  MODIFY `session_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wp_woocommerce_shipping_zones`
--
ALTER TABLE `wp_woocommerce_shipping_zones`
  MODIFY `zone_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_shipping_zone_locations`
--
ALTER TABLE `wp_woocommerce_shipping_zone_locations`
  MODIFY `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_shipping_zone_methods`
--
ALTER TABLE `wp_woocommerce_shipping_zone_methods`
  MODIFY `instance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_tax_rates`
--
ALTER TABLE `wp_woocommerce_tax_rates`
  MODIFY `tax_rate_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woocommerce_tax_rate_locations`
--
ALTER TABLE `wp_woocommerce_tax_rate_locations`
  MODIFY `location_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wp_woo_bom`
--
ALTER TABLE `wp_woo_bom`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;