-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2021 at 04:20 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `viserplace_update`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `access`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '5ff1c3531ed3f1609679699.jpg', NULL, '$2y$10$Z7ifEDvfu5QNI0HpDI1EeuxtokN0BBrQ75jariAYOFGuwKZ2w0iOO', NULL, '2021-01-04 03:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_fee` decimal(18,8) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Active:1, Deactive:2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_details`
--

CREATE TABLE `category_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL,
  `options` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `method_code` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `method_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` decimal(18,8) NOT NULL,
  `rate` decimal(18,8) NOT NULL,
  `final_amo` decimal(18,8) DEFAULT 0.00000000,
  `detail` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `try` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel',
  `admin_feedback` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_templates`
--

CREATE TABLE `email_sms_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subj` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_body` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcodes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_status` tinyint(4) NOT NULL DEFAULT 1,
  `sms_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_sms_templates`
--

INSERT INTO `email_sms_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(1, 'PASS_RESET_CODE', 'Password Reset', 'Password Reset', '<div>We have received a request to reset the password for your account on <b>{{time}} .<br></b></div><div>Requested From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div><div><br></div><br><div><div><div>Your account recovery code is:&nbsp;&nbsp; <font size=\"6\"><b>{{code}}</b></font></div><div><br></div></div></div><div><br></div><div><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><br>', 'Your account recovery code is: {{code}}', ' {\"code\":\"Password Reset Code\",\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2021-01-06 00:49:06'),
(2, 'PASS_RESET_DONE', 'Password Reset Confirmation', 'You have Reset your password', '<div><p>\r\n    You have successfully reset your password.</p><p>You changed from&nbsp; IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}}&nbsp;</b> on <b>{{time}}</b></p><p><b><br></b></p><p><font color=\"#FF0000\"><b>If you did not changed that, Please contact with us as soon as possible.</b></font><br></p></div>', 'Your password has been changed successfully', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-07 10:23:47'),
(3, 'EVER_CODE', 'Email Verification', 'Please verify your email address', '<div><br></div><div>Thanks For join with us. <br></div><div>Please use below code to verify your email address.<br></div><div><br></div><div>Your email verification code is:<font size=\"6\"><b> {{code}}</b></font></div>', 'Your email verification code is: {{code}}', '{\"code\":\"Verification code\"}', 1, 1, '2019-09-24 23:04:05', '2021-01-03 23:35:10'),
(4, 'SVER_CODE', 'SMS Verification ', 'Please verify your phone', 'Your phone verification code is: {{code}}', 'Your phone verification code is: {{code}}', '{\"code\":\"Verification code\"}', 0, 1, '2019-09-24 23:04:05', '2020-03-08 01:28:52'),
(5, '2FA_ENABLE', 'Google Two Factor - Enable', 'Google Two Factor Authentication is now  Enabled for Your Account', '<div>You just enabled Google Two Factor Authentication for Your Account.</div><div><br></div><div>Enabled at <b>{{time}} </b>From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div>', 'Your verification code is: {{code}}', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-08 01:42:59'),
(6, '2FA_DISABLE', 'Google Two Factor Disable', 'Google Two Factor Authentication is now  Disabled for Your Account', '<div>You just Disabled Google Two Factor Authentication for Your Account.</div><div><br></div><div>Disabled at <b>{{time}} </b>From IP: <b>{{ip}}</b> using <b>{{browser}}</b> on <b>{{operating_system}} </b>.</div>', 'Google two factor verification is disabled', '{\"ip\":\"IP of User\",\"browser\":\"Browser of User\",\"operating_system\":\"Operating System of User\",\"time\":\"Request Time\"}', 1, 1, '2019-09-24 23:04:05', '2020-03-08 01:43:46'),
(16, 'ADMIN_SUPPORT_REPLY', 'Support Ticket Reply ', 'Reply Support Ticket', '<div><p><span style=\"font-size: 11pt;\" data-mce-style=\"font-size: 11pt;\"><strong>A member from our support team has replied to the following ticket:</strong></span></p><p><b><span style=\"font-size: 11pt;\" data-mce-style=\"font-size: 11pt;\"><strong><br></strong></span></b></p><p><b>[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</b></p><p>----------------------------------------------</p><p>Here is the reply : <br></p><p> {{reply}}<br></p></div><div><br></div>', '{{subject}}\r\n\r\n{{reply}}\r\n\r\n\r\nClick here to reply:  {{link}}', '{\"ticket_id\":\"Support Ticket ID\", \"ticket_subject\":\"Subject Of Support Ticket\", \"reply\":\"Reply from Staff/Admin\",\"link\":\"Ticket URL For relpy\"}', 1, 1, '2020-06-08 18:00:00', '2020-05-04 02:24:40'),
(206, 'DEPOSIT_COMPLETE', 'Automated Deposit - Successful', 'Deposit Completed Successfully', '<div>Your deposit of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>has been completed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#000000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br><br></div>', '{{amount}} {{currrency}} Deposit successfully by {{gateway_name}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2020-06-24 18:00:00', '2020-11-17 03:10:00'),
(207, 'DEPOSIT_REQUEST', 'Manual Deposit - User Requested', 'Deposit Request Submitted Successfully', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>submitted successfully<b> .<br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br></div>', '{{amount}} Deposit requested by {{method}}. Charge: {{charge}} . Trx: {{trx}}\r\n', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\"}', 1, 1, '2020-05-31 18:00:00', '2020-06-01 18:00:00'),
(208, 'DEPOSIT_APPROVE', 'Manual Deposit - Admin Approved', 'Your Deposit is Approved', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>is Approved .<b><br></b></div><div><b><br></b></div><div><b>Details of your Deposit :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br></div>', 'Admin Approve Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}} transaction : {{transaction}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2020-06-16 18:00:00', '2020-06-14 18:00:00'),
(209, 'DEPOSIT_REJECT', 'Manual Deposit - Admin Rejected', 'Your Deposit Request is Rejected', '<div>Your deposit request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} has been rejected</b>.<b><br></b></div><br><div>Transaction Number was : {{trx}}</div><div><br></div><div>if you have any query, feel free to contact us.<br></div><br><div><br><br></div>\r\n\r\n\r\n\r\n{{rejection_message}}', 'Admin Rejected Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\",\"rejection_message\":\"Rejection message\"}', 1, 1, '2020-06-09 18:00:00', '2020-06-14 18:00:00'),
(210, 'WITHDRAW_REQUEST', 'Withdraw  - User Requested', 'Withdraw Request Submitted Successfully', '<div>Your withdraw request of <b>{{amount}} {{currency}}</b>&nbsp; via&nbsp; <b>{{method_name}} </b>has been submitted Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>You will get: {{method_amount}} {{method_currency}} <br></div><div>Via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"4\" color=\"#FF0000\"><b><br></b></font></div><div><font size=\"4\" color=\"#FF0000\"><b>This may take {{delay}} to process the payment.</b></font><br></div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br><br><br></div>', '{{amount}} {{currency}} withdraw requested by {{withdraw_method}}. You will get {{method_amount}} {{method_currency}} in {{duration}}. Trx: {{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\", \"delay\":\"Delay time for processing\"}', 1, 1, '2020-06-07 18:00:00', '2020-06-14 18:00:00'),
(211, 'WITHDRAW_REJECT', 'Withdraw - Admin Rejected', 'Withdraw Request has been Rejected and your money is refunded to your account', '<div>Your withdraw request of <b>{{amount}} {{currency}}</b>&nbsp; via&nbsp; <b>{{method_name}} </b>has been Rejected.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>You should get: {{method_amount}} {{method_currency}} <br></div><div>Via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br></div><div>----</div><div><font size=\"3\"><br></font></div><div><font size=\"3\"> {{amount}} {{currency}} has been <b>refunded </b>to your account and your current Balance is <b>{{post_balance}}</b><b> {{currency}}</b></font></div><div><br></div><div>-----</div><div><br></div><div><font size=\"4\">Details of Rejection :</font></div><div><font size=\"4\"><b>{{admin_details}}</b></font></div><div><br></div><div><br><br><br><br><br><br></div>', 'Admin Rejected Your {{amount}} {{currency}} withdraw request. Your Main Balance {{main_balance}}  {{method}} , Transaction {{transaction}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\", \"admin_details\":\"Details Provided By Admin\"}', 1, 1, '2020-06-09 18:00:00', '2020-06-14 18:00:00'),
(212, 'WITHDRAW_APPROVE', 'Withdraw - Admin  Approved', 'Withdraw Request has been Processed and your money is sent', '<div>Your withdraw request of <b>{{amount}} {{currency}}</b>&nbsp; via&nbsp; <b>{{method_name}} </b>has been Processed Successfully.<b><br></b></div><div><b><br></b></div><div><b>Details of your withdraw:<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>You will get: {{method_amount}} {{method_currency}} <br></div><div>Via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div>-----</div><div><br></div><div><font size=\"4\">Details of Processed Payment :</font></div><div><font size=\"4\"><b>{{admin_details}}</b></font></div><div><br></div><div><br><br><br><br><br></div>', 'Admin Approve Your {{amount}} {{currency}} withdraw request by {{method}}. Transaction {{transaction}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"admin_details\":\"Details Provided By Admin\"}', 1, 1, '2020-06-10 18:00:00', '2020-06-06 18:00:00'),
(215, 'BAL_ADD', 'Balance Add by Admin', 'Your Account has been Credited', '<div>{{amount}} {{currency}} has been added to your account .</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div>Your Current Balance is : <font size=\"3\"><b>{{post_balance}}&nbsp; {{currency}}&nbsp;</b></font>', '{{amount}} {{currency}} credited in your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2019-09-14 19:14:22', '2021-01-06 00:46:18'),
(216, 'BAL_SUB', 'Balance Subtracted by Admin', 'Your Account has been Debited', '<div>{{amount}} {{currency}} has been subtracted from your account .</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div>Your Current Balance is : <font size=\"3\"><b>{{post_balance}}&nbsp; {{currency}}</b></font>', '{{amount}} {{currency}} debited from your account. Your Current Balance {{remaining_balance}} {{currency}} . Transaction: #{{trx}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By Admin\",\"currency\":\"Site Currency\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2019-09-14 19:14:22', '2019-11-10 09:07:12'),
(217, 'REVIEWER_CREDENTIALS', 'Reviewer Credentials', 'Reviewer Credentials', 'Your username is: {{username}} and password is: {{password}}', 'Your username is: {{username}} and password is: {{password}}', '{\"username\":\"Reviewer Username\",\"password\":\"Reviewer Password\"}', 1, 1, NULL, NULL),
(218, 'PRODUCT_PURCHASED', 'Product Purchased', 'Purchased Product Successfully', '<div><span style=\"color: rgb(33, 37, 41); font-size: 1rem;\">We have received</span><span style=\"color: rgb(33, 37, 41); font-weight: bolder; font-size: 1rem;\">&nbsp;{{total_amount}}{{currency}}</span>&nbsp; via&nbsp; <b>{{method_name}}</b>.<b><br></b></div><div><b><br></b></div><div><b>Details of your Product Purchase :<br></b></div><div><br></div><div>Products Name:</div><div><br></div><div>{{product_list}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br></div>', '{{total_amount}} {{currency}} is subtracted from your balance  via  {{method_name}}.\r\n\r\nDetails of your Product Purchase:\r\n\r\nOrder Number: {{order_number}}\r\nTransaction Number : {{trx}}\r\n\r\nYour current Balance is {{post_balance}} {{currency}}', '{\"total_amount\":\"Total Price\",\"currency\":\"Site Currency\",\"method_name\":\"Payment Method Name\",\"post_balance\":\"Post Balance of User\",\"product_list\":\"Name of purchased products\"}', 1, 1, '2020-06-16 18:00:00', '2021-06-05 07:54:02'),
(219, 'PRODUCT_SOLD', 'Product Sold', 'Sold Product Successfully', '<div><span style=\"color: rgb(33, 37, 41); font-weight: bolder; font-size: 1rem;\">{{amount}}{{currency}}</span><b>&nbsp;</b>is added as earning balance for selling a product.&nbsp;<b style=\"font-size: 1rem;\">{{buyer_fee}}{{currency}}&nbsp;</b><span style=\"color: rgb(33, 37, 41); font-size: 1rem;\">charged as buyer fee.</span></div><div><b style=\"font-size: 1rem;\"><br></b></div><div><b style=\"font-size: 1rem;\">Details of your sold product :</b></div><div><br></div><div>Name : {{product_name}}</div><div>License type : {{license}}</div><div>Product price : {{product_amount}} {{currency}}</div><div>Support fee : {{support_fee}}{{currency}}</div><div>Support time : {{support_time}}</div><div>Purchase code : {{purchase_code}}</div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current balance is <b>{{post_balance}} {{currency}}</b></font></div>', '{{amount}}{{currency}} is added as earning balance for selling a product. {{buyer_fee}}{{currency}} charged as buyer fee.\r\n\r\nDetails of your sold product :\r\n\r\nName : {{product_name}}\r\nLicense type : {{license}}\r\nProduct price : {{product_amount}} {{currency}}\r\nSupport fee : {{support_fee}}\r\nSupport time : {{support_time}}\r\nPurchase code : {{purchase_code}}\r\nTransaction Number : {{trx}}\r\n\r\nYour current earning balance is {{post_balance}} {{currency}}', '{\"product_name\":\"Product Name\",\"license\":\"License Type\",\"trx\":\"Transaction Number\",\"support_fee\":\"Product Support fee\",\"support_time\":\"Support Expired Date\",\"currency\":\"Site Currency\",\"buyer_fee\":\"Charge For Product Sell\",\"product_amount\":\"Product Price\",\"purchase_code\":\"Purchase Code\",\"post_balance\":\"Post Balance of User\"}', 1, 1, '2020-06-16 18:00:00', '2021-05-23 06:20:49'),
(220, 'PAYMENT_REQUEST', 'Manual Payment - User Requested', 'Payment Request Submitted Successfully', '<div>Your payment request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>submitted successfully<b> .<br></b></div><div><b><br></b></div><div><b>Details of your Payment :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br></div>', '{{amount}} Payment requested by {{method}}. Charge: {{charge}} . Trx: {{trx}}\r\n', '{\"trx\":\"Transaction Number\",\"amount\":\"Payment Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Payment Method Name\",\"method_currency\":\"Payment Method Currency\",\"method_amount\":\"Payment Method Amount After Conversion\"}', 1, 1, '2020-05-31 18:00:00', '2021-06-05 07:34:55'),
(221, 'PAYMENT_APPROVE', 'Manual Payment - Admin Approved', 'Your Payment is Approved', '<div>Your payment request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} </b>is Approved .<b><br></b></div><div><b><br></b></div><div><b>Details of your Payment :<br></b></div><div><br></div><div>Amount : {{amount}} {{currency}}</div><div>Charge: <font color=\"#FF0000\">{{charge}} {{currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}} <br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><b><br></b></font></div><div><font size=\"5\">Your current Balance is <b>{{post_balance}} {{currency}}</b></font></div><div><br></div><div><br><br></div>', 'Admin Approve Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}}. Your transaction number: {{transaction}}. Your order number : {{order_number}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\", \"post_balance\":\"Users Balance After this operation\"}', 1, 1, '2020-06-16 18:00:00', '2021-06-05 07:40:53'),
(222, 'PAYMENT_REJECT', 'Manual Payment - Admin Rejected', 'Your Payment Request is Rejected', '<div>Your payment request of <b>{{amount}} {{currency}}</b> is via&nbsp; <b>{{method_name}} has been rejected</b>.<b><br></b></div><br><div>Transaction Number was : {{trx}}</div><div><br></div><div>If you have any query, feel free to contact us.<br></div><br><div><br><br></div>\r\n\r\n\r\n\r\n{{rejection_message}}', 'Admin Rejected Your {{amount}} {{gateway_currency}} payment request by {{gateway_name}} for order number {{order_number}}\r\n\r\n{{rejection_message}}', '{\"trx\":\"Transaction Number\",\"amount\":\"Request Amount By user\",\"charge\":\"Gateway Charge\",\"currency\":\"Site Currency\",\"rate\":\"Conversion Rate\",\"method_name\":\"Deposit Method Name\",\"method_currency\":\"Deposit Method Currency\",\"method_amount\":\"Deposit Method Amount After Conversion\",\"rejection_message\":\"Rejection message\"}', 1, 1, '2020-06-09 18:00:00', '2021-06-05 07:42:21'),
(223, 'PRODUCT_APPROVED', 'Product - Approved', 'Your Product Is Approved', '<div>Congratulations! Your submission&nbsp;<b>{{product_name}}</b>&nbsp;has been approved for sale.&nbsp;</div><div><br></div><div>Thanks for your high quality submission. Keep up the awesome work!</div>', 'Congratulations! Your submission {{product_name}} has been approved for sale. Thanks for your high quality submission. Keep up the awesome work!', '{\"product_name\":\"Product Name\"}', 1, 1, '2020-06-09 18:00:00', '2021-07-17 00:35:57'),
(224, 'PRODUCT_HARD_REJECT', 'Product - Rejected', 'Your Product Is Rejected', '<div>Thanks for your submission. We have completed our review of&nbsp;<b>{{product_name}}</b>&nbsp;and unfortunately it isn\'t at the quality standard required to move forward, and you won\'t be able to re-submit this product again.</div><div><br></div><div>We appreciate the effort and time you\'ve put into creating your product. And we\'d happy to the help make sure your next entry will meet our submission requirements.&nbsp;</div><div><br></div><div>Remember you can get help by contacting us by our support system. Our helpful community will be glad to lend a hand.</div><div><br></div><div>We hope to see a new submission from you soon!</div>', 'Thank you for your submission. We have completed our review of {{product_name}} and unfortunately we found it isn\'t at the quality standard required to move forward, and you won\'t be able to re-submit this item again.\r\nWe appreciate the effort and time you\'ve put into creating your product. And we\'d be happy to help make sure your next entry will meet our submission requirements.', '{\"product_name\":\"Product Name\"}', 1, 1, '2020-06-09 18:00:00', '2021-06-03 07:44:03'),
(225, 'PRODUCT_UPDATE_APPROVED', 'Product Update - Approved', 'Your Product Update Is Approved', '<div>Congratulations! Your update to&nbsp;<b>{{product_name}}</b>&nbsp;has been approved.</div><div><br></div><div>Thanks for your submission.</div>', 'Congratulations! Your update to {{product_name}} has been approved', '{\"product_name\":\"Product Name\"}', 1, 1, '2020-06-09 18:00:00', '2021-07-14 03:22:12'),
(226, 'PRODUCT_UPDATE_REJECTED', 'Product Update - Rejected', 'Your Product Update Is Rejected', '<div>Thanks for your submission. We have completed our review on the update of&nbsp;<b>{{product_name}}</b>&nbsp;and unfortunately it isn\'t at the quality standard required to move forward.</div><div><br></div><div>We appreciate the effort and time you\'ve put into updating your product. And we\'d happy to the help make sure your next entry will meet our submission requirements.&nbsp;</div><div><br></div><div>Remember you can get help by contacting us by our support system. Our helpful community will be glad to lend a hand.</div><div><br></div><div>We hope to see a new submission from you soon!</div>', 'Thank you for your submission. We have completed our review on the update of {{product_name}} and unfortunately we found it isn\'t at the quality standard required to move forward.\r\nWe appreciate the effort and time you\'ve put into updating your product. And we\'d be happy to help make sure your next entry will meet our submission requirements.', '{\"product_name\":\"Product Name\"}', 1, 1, '2020-06-09 18:00:00', '2021-06-03 07:59:34'),
(227, 'PRODUCT_SOFT_REJECT', 'Product - Soft Rejected', 'Your Product Is Soft Rejected', '<div>Unfortunately your submission of&nbsp;<b>{{product_name}}</b>&nbsp;isn\'t quite ready for sale.</div><div><br></div><div>Here\'s some feedback from our Review team on why it couldn\'t be accepted.</div><div><br></div><div>Here is the soft reject message :&nbsp;</div><div><br></div><div>{{rejection_message}}</div>', 'Unfortunately your submission of {{product_name}} isn’t quite ready for sale. Here’s some feedback from our Review team on why it couldn’t be accepted.\r\n\r\n{{rejection_message}}', '{\"product_name\":\"Product Name\",\"rejection_message\":\"Rejection Message\"}', 1, 1, '2020-06-09 18:00:00', '2021-06-03 08:26:31'),
(228, 'MAIL_TO_ATHOR', 'Email To Author', 'A message from a client', '<div>You have a message from a client</div><div><br></div><div><b>Message : </b>&nbsp;{{message}}.</div><div><br></div><div>Please send a response to following email.&nbsp;</div><div><br></div><div><span><b>Email To Response : </b>&nbsp;</span><span>&nbsp;{{reply_to}}</span><br></div>', 'You have a message from a client.\r\n\r\nMessage : {{message}}\r\n\r\nPlease reply to this email : {{reply_to}}', '{\"reply_to\":\"Client Email\",\"message\":\"Client Message\"}', 1, 1, '2020-06-09 18:00:00', '2021-07-13 04:57:01');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `act` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"58dd135ef7bbaa72709c3470\\/default\"}}', 'twak.png', 1, NULL, '2019-10-18 23:16:05', '2021-01-03 23:39:18'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\r\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\r\n<div class=\"g-recaptcha\" data-sitekey=\"{{sitekey}}\" data-callback=\"verifyCaptcha\"></div>\r\n<div id=\"g-recaptcha-error\"></div>', '{\"sitekey\":{\"title\":\"Site Key\",\"value\":\"6Lfpm3cUAAAAAGIjbEJKhJNKS4X1Gns9ANjh8MfH\"}}', 'recaptcha.png', 0, NULL, '2019-10-18 23:16:05', '2021-08-07 08:56:50'),
(3, 'custom-captcha', 'Custom Captcha', 'Just Put Any Random String', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, NULL, '2019-10-18 23:16:05', '2021-08-07 08:56:55'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google-analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\r\n                <script>\r\n                  window.dataLayer = window.dataLayer || [];\r\n                  function gtag(){dataLayer.push(arguments);}\r\n                  gtag(\"js\", new Date());\r\n                \r\n                  gtag(\"config\", \"{{app_key}}\");\r\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"Demo\"}}', 'ganalytics.png', 1, NULL, NULL, '2020-07-21 01:07:30'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"713047905830100\"}}', 'fb_com.PNG', 1, NULL, NULL, '2021-08-08 07:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `featureds`
--

CREATE TABLE `featureds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `revoked_at` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` int(10) UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"admin\",\"blog\",\"aaaa\",\"ddd\",\"aaa\"],\"description\":\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit\",\"social_title\":\"Viserplace - Digital Marketplace Platform\",\"social_description\":\"Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit ff\",\"image\":\"60f2d910639701626528016.jpg\"}', '2020-07-04 23:42:52', '2021-08-08 07:48:18'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"Latest News\",\"sub_heading\":\"Register New Account\",\"description\":\"fdg sdfgsdf g ggg\",\"about_icon\":\"<i class=\\\"las la-address-card\\\"><\\/i>\",\"background_image\":\"5f9914e8e46281603867880.jpg\",\"about_image\":\"5f9914e907ace1603867881.jpg\"}', '2020-10-28 00:51:20', '2021-01-03 23:18:10'),
(25, 'blog.content', '{\"heading\":\"Latest News\",\"sub_title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, iste maiores dolore iusto in vero unde amet, ipsam laborum eveniet, veritatis dolor incidunt blanditiis.\"}', '2020-10-28 00:51:34', '2021-08-04 06:47:16'),
(27, 'contact_us.content', '{\"sub_heading\":\"Contact with us\",\"heading\":\"Get in touch for any kind of help and information.\",\"latitude\":\"56.1304\",\"longitude\":\"106.3468\"}', '2020-10-28 00:59:19', '2021-08-08 07:23:24'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"sub_heading\":\"Register New Account\"}', '2020-10-28 01:04:02', '2020-10-28 01:04:02'),
(31, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook\\\"><\\/i>\",\"url\":\"https:\\/\\/www.google.com\\/\"}', '2020-11-12 04:07:30', '2021-05-20 07:43:21'),
(33, 'feature.content', '{\"heading\":\"asdf\",\"sub_heading\":\"asdf\"}', '2021-01-03 23:40:54', '2021-01-03 23:40:55'),
(35, 'service.element', '{\"trx_type\":\"withdraw\",\"service_icon\":\"<i class=\\\"las la-highlighter\\\"><\\/i>\",\"title\":\"asdfasdf\",\"description\":\"asdfasdfasdfasdf\"}', '2021-03-06 01:12:10', '2021-03-06 01:12:10'),
(36, 'service.content', '{\"trx_type\":\"withdraw\",\"heading\":\"asdf fffff\",\"sub_heading\":\"asdf asdfasdf\"}', '2021-03-06 01:27:34', '2021-03-06 02:19:39'),
(39, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"36,365 Digital products and elements in this platform\",\"sub_title\":\"A marketplace of Quality &amp; Professional Digital Products\",\"image\":\"610e780953aba1628338185.jpg\"}', '2021-04-20 09:51:38', '2021-08-07 06:09:45'),
(40, 'latest_product.content', '{\"heading\":\"Check out our newest digital products\",\"sub_title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, iste maiores dolore iusto in vero unde amet, ipsam laborum eveniet, veritatis dolor incidunt blanditiis voluptatibus quod velit dicta enim omnis.\"}', '2021-04-20 10:13:58', '2021-04-20 10:13:58'),
(41, 'testimonial.content', '{\"heading\":\"What our clients say\",\"sub_title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, iste maiores dolore iusto in vero unde amet, ipsam laborum eveniet, veritatis dolor incidunt blanditiis.\"}', '2021-04-20 21:54:49', '2021-08-04 06:33:47'),
(42, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Tasfin\",\"designation\":\"@themeuradurah\",\"quote\":\"Incidunt yau, dolor sit amet cotur adipisicing elit. Nisi, indunt max. Quae accusamus a eos, inventore nihil hic asperiores exerawndeem temporibus incidunt officia nisi.\",\"image\":\"607fa233a1f941618977331.jpg\"}', '2021-04-20 21:55:31', '2021-08-04 06:09:54'),
(43, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Demo Name\",\"designation\":\"@themeuradurah\",\"quote\":\"Incidunt yau, dolor sit amet cotur adipisicing elit. Nisi, indunt max. Quae accusamus a eos, inventore nihil hic asperiores exerawndeem temporibus incidunt officia nisi.\",\"image\":\"607fa24f1672d1618977359.jpg\"}', '2021-04-20 21:55:59', '2021-08-04 06:09:59'),
(44, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Sherrinford William\",\"designation\":\"@designation\",\"quote\":\"Incidunt yau, dolor sit amet cotur adipisicing elit. Nisi, indunt max. Quae accusamus a eos, inventore nihil hic asperiores exerawndeem temporibus incidunt officia nisi.\",\"image\":\"607fa26283f7a1618977378.jpg\"}', '2021-04-20 21:56:18', '2021-08-08 07:25:16'),
(45, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Digital Marketplace\",\"tag\":\"demo\",\"description\":\"Digital marketplace dolor sit amet consectetur adipisicing elit. Omnis amet molestiae ipsum cupiditate magnam nulla explicabo, veniam laboriosam voluptatem vitae. Quam sunt nesciunt in, aliquid laboriosam qui, veniam libero iusto quos sequi delectus, est corrupti cupiditate facere nobis! Tempora omnis facilis iste veritatis commodi doloremque est ut aliquid pariatur officiis ratione accusamus adipisci tenetur sapiente nihil vel dicta explicabo laudantium ad culpa eum, sit sunt sed beatae. Autem inventore rerum dignissimos nisi eum quasi illum sit expedita error commodi est molestiae eligendi a mollitia voluptatibus odio suscipit, et numquam iure possimus vel, quod obcaecati totam aliquam! Libero vero asperiores vitae, cupiditate, quasi aperiam rem earum reiciendis, fugiat deserunt molestiae. Officiis dignissimos accusamus eaque quibusdam ea quos ratione atque laudantium sit ab, nemo suscipit error animi libero explicabo vel exercitationem voluptates commodi obcaecati molestias non pariatur! Ullam harum, cum corrupti voluptates ratione nulla provident sequi eum.<div><br \\/><\\/div><div>Perferendis expedita nesciunt itaque modi perspiciatis eligendi quam fugit similique illum numquam, nulla suscipit iusto veniam voluptatem unde, deserunt obcaecati enim iste. Quod, vitae necessitatibus? Tempora modi expedita enim odio quisquam, porro ipsam, placeat quos at labore nisi saepe mollitia cum fugiat iure! Dolorem voluptatibus fugiat, beatae adipisci itaque explicabo aperiam autem laudantium ratione consequuntur harum quos sit velit? Est debitis placeat animi tenetur molestias pariatur porro consectetur similique molestiae rerum ad optio quas recusandae accusantium dolor, omnis ullam saepe quo laboriosam eius repellat eveniet laborum unde!<\\/div><div><br \\/><\\/div><div>Voluptatem a dolorem consequuntur nam facilis in, laborum iste quas magnam non asperiores ea ab, aliquam temporibus. Saepe voluptates magni dicta! Veniam a optio odit repellendus necessitatibus rerum corporis soluta, nesciunt cum obcaecati delectus, libero ullam dolorem facere ducimus et architecto nihil explicabo fugiat. Ratione laudantium deserunt assumenda soluta molestias omnis veniam, illo iste, aut odit nesciunt praesentium expedita quo ea possimus asperiores quaerat beatae accusantium consequuntur laboriosam, in aspernatur officiis atque!<br \\/><\\/div>\",\"image\":\"610ba82a102b91628153898.jpg\"}', '2021-04-20 23:01:13', '2021-08-08 05:39:58'),
(46, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Online Transaction\",\"tag\":\"demo\",\"description\":\"<span style=\\\"color:rgb(33,37,41);\\\">Digital marketplace dolor sit amet consectetur adipisicing elit. Omnis amet molestiae ipsum cupiditate magnam nulla explicabo, veniam laboriosam voluptatem vitae. Quam sunt nesciunt in, aliquid laboriosam qui, veniam libero iusto quos sequi delectus, est corrupti cupiditate facere nobis! Tempora omnis facilis iste veritatis commodi doloremque est ut aliquid pariatur officiis ratione accusamus adipisci tenetur sapiente nihil vel dicta explicabo laudantium ad culpa eum, sit sunt sed beatae. Autem inventore rerum dignissimos nisi eum quasi illum sit expedita error commodi est molestiae eligendi a mollitia voluptatibus odio suscipit, et numquam iure possimus vel, quod obcaecati totam aliquam! Libero vero asperiores vitae, cupiditate, quasi aperiam rem earum reiciendis, fugiat deserunt molestiae. Officiis dignissimos accusamus eaque quibusdam ea quos ratione atque laudantium sit ab, nemo suscipit error animi libero explicabo vel exercitationem voluptates commodi obcaecati molestias non pariatur! Ullam harum, cum corrupti voluptates ratione nulla provident sequi eum.<\\/span><div><br \\/><\\/div><div>Perferendis expedita nesciunt itaque modi perspiciatis eligendi quam fugit similique illum numquam, nulla suscipit iusto veniam voluptatem unde, deserunt obcaecati enim iste. Quod, vitae necessitatibus? Tempora modi expedita enim odio quisquam, porro ipsam, placeat quos at labore nisi saepe mollitia cum fugiat iure! Dolorem voluptatibus fugiat, beatae adipisci itaque explicabo aperiam autem laudantium ratione consequuntur harum quos sit velit? Est debitis placeat animi tenetur molestias pariatur porro consectetur similique molestiae rerum ad optio quas recusandae accusantium dolor, omnis ullam saepe quo laboriosam eius repellat eveniet laborum unde!<\\/div><div><br \\/><\\/div><div>Voluptatem a dolorem consequuntur nam facilis in, laborum iste quas magnam non asperiores ea ab, aliquam temporibus. Saepe voluptates magni dicta! Veniam a optio odit repellendus necessitatibus rerum corporis soluta, nesciunt cum obcaecati delectus, libero ullam dolorem facere ducimus et architecto nihil explicabo fugiat. Ratione laudantium deserunt assumenda soluta molestias omnis veniam, illo iste, aut odit nesciunt praesentium expedita quo ea possimus asperiores quaerat beatae accusantium consequuntur laboriosam, in aspernatur officiis atque!<\\/div>\",\"image\":\"610ba83d9feef1628153917.jpg\"}', '2021-04-20 23:01:48', '2021-08-08 05:40:38'),
(47, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Software Market\",\"tag\":\"demo\",\"description\":\"<span style=\\\"color:rgb(33,37,41);\\\">Digital marketplace dolor sit amet consectetur adipisicing elit. Omnis amet molestiae ipsum cupiditate magnam nulla explicabo, veniam laboriosam voluptatem vitae. Quam sunt nesciunt in, aliquid laboriosam qui, veniam libero iusto quos sequi delectus, est corrupti cupiditate facere nobis! Tempora omnis facilis iste veritatis commodi doloremque est ut aliquid pariatur officiis ratione accusamus adipisci tenetur sapiente nihil vel dicta explicabo laudantium ad culpa eum, sit sunt sed beatae. Autem inventore rerum dignissimos nisi eum quasi illum sit expedita error commodi est molestiae eligendi a mollitia voluptatibus odio suscipit, et numquam iure possimus vel, quod obcaecati totam aliquam! Libero vero asperiores vitae, cupiditate, quasi aperiam rem earum reiciendis, fugiat deserunt molestiae. Officiis dignissimos accusamus eaque quibusdam ea quos ratione atque laudantium sit ab, nemo suscipit error animi libero explicabo vel exercitationem voluptates commodi obcaecati molestias non pariatur! Ullam harum, cum corrupti voluptates ratione nulla provident sequi eum.<\\/span><div><br \\/><\\/div><div>Perferendis expedita nesciunt itaque modi perspiciatis eligendi quam fugit similique illum numquam, nulla suscipit iusto veniam voluptatem unde, deserunt obcaecati enim iste. Quod, vitae necessitatibus? Tempora modi expedita enim odio quisquam, porro ipsam, placeat quos at labore nisi saepe mollitia cum fugiat iure! Dolorem voluptatibus fugiat, beatae adipisci itaque explicabo aperiam autem laudantium ratione consequuntur harum quos sit velit? Est debitis placeat animi tenetur molestias pariatur porro consectetur similique molestiae rerum ad optio quas recusandae accusantium dolor, omnis ullam saepe quo laboriosam eius repellat eveniet laborum unde!<\\/div><div><br \\/><\\/div><div>Voluptatem a dolorem consequuntur nam facilis in, laborum iste quas magnam non asperiores ea ab, aliquam temporibus. Saepe voluptates magni dicta! Veniam a optio odit repellendus necessitatibus rerum corporis soluta, nesciunt cum obcaecati delectus, libero ullam dolorem facere ducimus et architecto nihil explicabo fugiat. Ratione laudantium deserunt assumenda soluta molestias omnis veniam, illo iste, aut odit nesciunt praesentium expedita quo ea possimus asperiores quaerat beatae accusantium consequuntur laboriosam, in aspernatur officiis atque!<\\/div>\",\"image\":\"610ba8447e11d1628153924.jpg\"}', '2021-04-20 23:02:13', '2021-08-08 05:41:11'),
(48, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"610bc6e8dcc611628161768.jpg\"}', '2021-04-22 00:36:42', '2021-08-05 05:09:29'),
(49, 'contact_us.element', '{\"heading\":\"Contact no\",\"details\":\"+1212121245545\",\"icon\":\"<i class=\\\"las la-phone-volume\\\"><\\/i>\"}', '2021-04-23 21:54:13', '2021-04-23 21:54:13'),
(50, 'contact_us.element', '{\"heading\":\"Email Address\",\"details\":\"demo@demo.com\",\"icon\":\"<i class=\\\"far fa-envelope\\\"><\\/i>\"}', '2021-04-23 21:54:48', '2021-04-23 21:55:00'),
(51, 'contact_us.element', '{\"heading\":\"Our Address\",\"details\":\"2nd floor, 36 Sonargaon Janapath, Dhaka 1231\",\"icon\":\"<i class=\\\"las la-map\\\"><\\/i>\"}', '2021-04-23 21:55:45', '2021-04-23 21:55:45'),
(52, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Sherlock\",\"designation\":\"@resignation\",\"quote\":\"Incidunt yau, dolor sit amet cotur adipisicing elit. Nisi, indunt max. Quae accusamus a eos, inventore nihil hic asperiores exerawndeem temporibus incidunt officia nisi.\",\"image\":\"607fa26283f7a1618977378.jpg\"}', '2021-04-20 21:56:18', '2021-08-08 07:25:29'),
(53, 'featured_product.content', '{\"heading\":\"Our Featured Products\",\"sub_title\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, iste maiores dolore iusto in vero unde amet, ipsam laborum eveniet, veritatis dolor incidunt blanditiis voluptatibus.\"}', '2021-05-20 05:39:36', '2021-05-20 05:39:36'),
(54, 'best_sell_product.content', '{\"heading\":\"Checkout our best selling items.\",\"sub_title\":\"Maiores deleniti animi explicabo vero et ex maiores veniam in dolor sequi deserunt.\"}', '2021-05-20 06:06:23', '2021-08-07 06:18:18'),
(55, 'best_author_product.content', '{\"heading\":\"Best Author\'s items\",\"sub_title\":\"Maiores deleniti animi explicabo vero et ex maiores veniam in dolor sequi deserunt.\"}', '2021-05-20 06:25:22', '2021-08-07 06:18:10'),
(56, 'social_icon.element', '{\"title\":\"Google\",\"social_icon\":\"<i class=\\\"fab fa-google\\\"><\\/i>\",\"url\":\"https:\\/\\/www.google.com\\/\"}', '2021-05-20 07:43:05', '2021-05-20 07:43:05'),
(57, 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"fab fa-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/www.google.com\\/\"}', '2021-05-20 07:43:53', '2021-05-20 07:43:53'),
(58, 'subscribe.content', '{\"heading\":\"Get discounts and gifts every week!\"}', '2021-06-02 23:43:14', '2021-08-07 06:33:04'),
(59, 'policy.element', '{\"heading\":\"Privacy and Policy\",\"details\":\"<div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Aliquam tempora a harum accusantium repellat<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Consectetur earum amet consequuntur dolorum similique<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ipsa rerum ratione a amet, quo modi distinctio ad maxime<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ducimus sit exercitationem repellendus odit quae<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div>\"}', '2021-06-03 00:06:36', '2021-08-08 07:15:24'),
(60, 'policy.element', '{\"heading\":\"Terms Conditions\",\"details\":\"<div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Aliquam tempora a harum accusantium repellat<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Consectetur earum amet consequuntur dolorum similique<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ipsa rerum ratione a amet, quo modi distinctio ad maxime<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ducimus sit exercitationem repellendus odit quae<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div>\"}', '2021-06-03 00:07:15', '2021-06-03 00:07:15'),
(61, 'policy.element', '{\"heading\":\"Help Center\",\"details\":\"<div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Aliquam tempora a harum accusantium repellat<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Consectetur earum amet consequuntur dolorum similique<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ipsa rerum ratione a amet, quo modi distinctio ad maxime<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div>\"}', '2021-06-03 00:07:39', '2021-06-03 00:07:39'),
(62, 'policy.element', '{\"heading\":\"Support System\",\"details\":\"<div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Aliquam tempora a harum accusantium repellat<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Consectetur earum amet consequuntur dolorum similique<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"margin-top:2.1875rem;color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ipsa rerum ratione a amet, quo modi distinctio ad maxime<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div>\"}', '2021-06-03 00:08:02', '2021-06-03 00:08:03'),
(63, 'support.content', '{\"details\":\"<div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Aliquam tempora a harum accusantium repellat<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;margin-top:2.1875rem;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Consectetur earum amet consequuntur dolorum similique<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;margin-top:2.1875rem;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ipsa rerum ratione a amet, quo modi distinctio ad maxime<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div><div class=\\\"cotent-block\\\" style=\\\"color:rgb(111,111,111);font-family:Roboto, sans-serif;margin-top:2.1875rem;\\\"><h3 class=\\\"title mb-3\\\" style=\\\"font-weight:600;font-size:24px;font-family:Poppins, sans-serif;color:rgb(54,54,54);\\\">Ducimus sit exercitationem repellendus odit quae<\\/h3><p style=\\\"margin-right:0px;margin-left:0px;\\\">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolore repellendus, quae cumque adipisci eos ducimus vel odit laudantium harum iure maxime. Fugiat reprehenderit odit saepe blanditiis? Consectetur earum amet consequuntur dolorum similique pariatur reprehenderit magni iste, numquam quidem explicabo qui dolores esse nulla fugit voluptates corporis repellat quas labore quibusdam voluptatem veniam possimus. Ipsa rerum ratione a amet, quo modi distinctio ad maxime sunt necessitatibus nam quaerat accusantium blanditiis molestiae nihil. Dicta a quasi corporis omnis temporibus architecto error nulla. Ut, ducimus sit exercitationem repellendus odit quae, aliquam tempora a harum accusantium repellat, iste blanditiis necessitatibus itaque. Pariatur, magni blanditiis.<\\/p><\\/div>\"}', '2021-06-05 02:50:10', '2021-06-05 02:50:10'),
(64, 'footer.content', '{\"has_image\":\"1\",\"copyright\":\"Copyright \\u00a9 2021 | All Right Reserved by Viserplace\",\"image\":\"60e96ef9d8d0d1625911033.png\"}', '2021-07-10 03:57:13', '2021-08-08 07:55:05'),
(65, 'cookie.data', '{\"link\":\"#\",\"description\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"status\":1}', NULL, '2021-08-08 07:50:03'),
(66, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Jhon Doe\",\"designation\":\"@authorid\",\"quote\":\"Incidunt yau, dolor sit amet cotur adipisicing elit. Nisi, indunt max. Quae accusamus a eos, inventore nihil hic asperiores exerawndeem temporibus incidunt officia nisi.\",\"image\":\"610a85a0745e61628079520.jpg\"}', '2021-08-04 06:18:40', '2021-08-04 06:19:10'),
(67, 'testimonial.element', '{\"has_image\":[\"1\"],\"name\":\"Jorina Khatun\",\"designation\":\"@jorinaThemes\",\"quote\":\"Incidunt yau, dolor sit amet cotur adipisicing elit. Nisi, indunt max. Quae accusamus a eos, inventore nihil hic asperiores exerawndeem temporibus incidunt officia nisi.\",\"image\":\"610a85db0f8ac1628079579.jpg\"}', '2021-08-04 06:19:39', '2021-08-04 06:19:39'),
(69, 'faq.content', '{\"heading\":\"Frequently Asked Questions\",\"sub_title\":\"This answer and questions are based on users query about us. Hope this will help to clear your ideas about us.\"}', '2021-08-07 07:17:53', '2021-08-07 07:17:53'),
(70, 'faq.element', '{\"question\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit 1\",\"answer\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque perspiciatis harum voluptatibus natus alias nesciunt eius similique tenetur corporis fuga eligendi in enim quisquam dolor voluptates nihil obcaecati pariatur commodi facilis, officiis nobis porro eum architecto! Delectus ut voluptatibus voluptatem, aliquam tenetur et facilis, quia veritatis temporibus, ex magni soluta.\"}', '2021-08-07 07:20:15', '2021-08-07 07:38:27'),
(71, 'faq.element', '{\"question\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit 2\",\"answer\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque perspiciatis harum voluptatibus natus alias nesciunt eius similique tenetur corporis fuga eligendi in enim quisquam dolor voluptates nihil obcaecati pariatur commodi facilis, officiis nobis porro eum architecto! Delectus ut voluptatibus voluptatem, aliquam tenetur et facilis, quia veritatis temporibus, ex magni soluta.\"}', '2021-08-07 07:20:27', '2021-08-07 07:38:33'),
(72, 'faq.element', '{\"question\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit 3\",\"answer\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque perspiciatis harum voluptatibus natus alias nesciunt eius similique tenetur corporis fuga eligendi in enim quisquam dolor voluptates nihil obcaecati pariatur commodi facilis, officiis nobis porro eum architecto! Delectus ut voluptatibus voluptatem, aliquam tenetur et facilis, quia veritatis temporibus, ex magni soluta.\"}', '2021-08-07 07:20:41', '2021-08-07 07:38:38'),
(73, 'faq.element', '{\"question\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit 4\",\"answer\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque perspiciatis harum voluptatibus natus alias nesciunt eius similique tenetur corporis fuga eligendi in enim quisquam dolor voluptates nihil obcaecati pariatur commodi facilis, officiis nobis porro eum architecto! Delectus ut voluptatibus voluptatem, aliquam tenetur et facilis, quia veritatis temporibus, ex magni soluta.\"}', '2021-08-07 07:21:08', '2021-08-07 07:38:43'),
(74, 'authentication.content', '{\"has_image\":\"1\",\"image\":\"610ea141d23491628348737.jpg\"}', '2021-08-07 09:05:37', '2021-08-07 09:05:38'),
(75, 'featured_auhor.content', '{\"heading\":\"Monthly Featured Author\"}', '2021-08-08 04:39:01', '2021-08-08 04:39:01'),
(76, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Digital Analysis\",\"tag\":\"demo\",\"description\":\"<span style=\\\"color:rgb(33,37,41);\\\">Digital marketplace dolor sit amet consectetur adipisicing elit. Omnis amet molestiae ipsum cupiditate magnam nulla explicabo, veniam laboriosam voluptatem vitae. Quam sunt nesciunt in, aliquid laboriosam qui, veniam libero iusto quos sequi delectus, est corrupti cupiditate facere nobis! Tempora omnis facilis iste veritatis commodi doloremque est ut aliquid pariatur officiis ratione accusamus adipisci tenetur sapiente nihil vel dicta explicabo laudantium ad culpa eum, sit sunt sed beatae. Autem inventore rerum dignissimos nisi eum quasi illum sit expedita error commodi est molestiae eligendi a mollitia voluptatibus odio suscipit, et numquam iure possimus vel, quod obcaecati totam aliquam! Libero vero asperiores vitae, cupiditate, quasi aperiam rem earum reiciendis, fugiat deserunt molestiae. Officiis dignissimos accusamus eaque quibusdam ea quos ratione atque laudantium sit ab, nemo suscipit error animi libero explicabo vel exercitationem voluptates commodi obcaecati molestias non pariatur! Ullam harum, cum corrupti voluptates ratione nulla provident sequi eum.<\\/span><div><br \\/><\\/div><div>Perferendis expedita nesciunt itaque modi perspiciatis eligendi quam fugit similique illum numquam, nulla suscipit iusto veniam voluptatem unde, deserunt obcaecati enim iste. Quod, vitae necessitatibus? Tempora modi expedita enim odio quisquam, porro ipsam, placeat quos at labore nisi saepe mollitia cum fugiat iure! Dolorem voluptatibus fugiat, beatae adipisci itaque explicabo aperiam autem laudantium ratione consequuntur harum quos sit velit? Est debitis placeat animi tenetur molestias pariatur porro consectetur similique molestiae rerum ad optio quas recusandae accusantium dolor, omnis ullam saepe quo laboriosam eius repellat eveniet laborum unde!<\\/div><div><br \\/><\\/div><div>Voluptatem a dolorem consequuntur nam facilis in, laborum iste quas magnam non asperiores ea ab, aliquam temporibus. Saepe voluptates magni dicta! Veniam a optio odit repellendus necessitatibus rerum corporis soluta, nesciunt cum obcaecati delectus, libero ullam dolorem facere ducimus et architecto nihil explicabo fugiat. Ratione laudantium deserunt assumenda soluta molestias omnis veniam, illo iste, aut odit nesciunt praesentium expedita quo ea possimus asperiores quaerat beatae accusantium consequuntur laboriosam, in aspernatur officiis atque!<\\/div>\",\"image\":\"610fd0fc6afdb1628426492.jpg\"}', '2021-08-08 06:41:32', '2021-08-08 06:43:32'),
(77, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"E-commerce\",\"tag\":\"demo\",\"description\":\"<span style=\\\"color:rgb(33,37,41);\\\">Digital marketplace dolor sit amet consectetur adipisicing elit. Omnis amet molestiae ipsum cupiditate magnam nulla explicabo, veniam laboriosam voluptatem vitae. Quam sunt nesciunt in, aliquid laboriosam qui, veniam libero iusto quos sequi delectus, est corrupti cupiditate facere nobis! Tempora omnis facilis iste veritatis commodi doloremque est ut aliquid pariatur officiis ratione accusamus adipisci tenetur sapiente nihil vel dicta explicabo laudantium ad culpa eum, sit sunt sed beatae. Autem inventore rerum dignissimos nisi eum quasi illum sit expedita error commodi est molestiae eligendi a mollitia voluptatibus odio suscipit, et numquam iure possimus vel, quod obcaecati totam aliquam! Libero vero asperiores vitae, cupiditate, quasi aperiam rem earum reiciendis, fugiat deserunt molestiae. Officiis dignissimos accusamus eaque quibusdam ea quos ratione atque laudantium sit ab, nemo suscipit error animi libero explicabo vel exercitationem voluptates commodi obcaecati molestias non pariatur! Ullam harum, cum corrupti voluptates ratione nulla provident sequi eum.<\\/span><div><br \\/><\\/div><div>Perferendis expedita nesciunt itaque modi perspiciatis eligendi quam fugit similique illum numquam, nulla suscipit iusto veniam voluptatem unde, deserunt obcaecati enim iste. Quod, vitae necessitatibus? Tempora modi expedita enim odio quisquam, porro ipsam, placeat quos at labore nisi saepe mollitia cum fugiat iure! Dolorem voluptatibus fugiat, beatae adipisci itaque explicabo aperiam autem laudantium ratione consequuntur harum quos sit velit? Est debitis placeat animi tenetur molestias pariatur porro consectetur similique molestiae rerum ad optio quas recusandae accusantium dolor, omnis ullam saepe quo laboriosam eius repellat eveniet laborum unde!<\\/div><div><br \\/><\\/div><div>Voluptatem a dolorem consequuntur nam facilis in, laborum iste quas magnam non asperiores ea ab, aliquam temporibus. Saepe voluptates magni dicta! Veniam a optio odit repellendus necessitatibus rerum corporis soluta, nesciunt cum obcaecati delectus, libero ullam dolorem facere ducimus et architecto nihil explicabo fugiat. Ratione laudantium deserunt assumenda soluta molestias omnis veniam, illo iste, aut odit nesciunt praesentium expedita quo ea possimus asperiores quaerat beatae accusantium consequuntur laboriosam, in aspernatur officiis atque!<\\/div>\",\"image\":\"610fd108dbf7e1628426504.jpg\"}', '2021-08-08 06:41:44', '2021-08-08 06:43:59'),
(78, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Online Business Ideas\",\"tag\":\"demo\",\"description\":\"<span style=\\\"color:rgb(33,37,41);\\\">Digital marketplace dolor sit amet consectetur adipisicing elit. Omnis amet molestiae ipsum cupiditate magnam nulla explicabo, veniam laboriosam voluptatem vitae. Quam sunt nesciunt in, aliquid laboriosam qui, veniam libero iusto quos sequi delectus, est corrupti cupiditate facere nobis! Tempora omnis facilis iste veritatis commodi doloremque est ut aliquid pariatur officiis ratione accusamus adipisci tenetur sapiente nihil vel dicta explicabo laudantium ad culpa eum, sit sunt sed beatae. Autem inventore rerum dignissimos nisi eum quasi illum sit expedita error commodi est molestiae eligendi a mollitia voluptatibus odio suscipit, et numquam iure possimus vel, quod obcaecati totam aliquam! Libero vero asperiores vitae, cupiditate, quasi aperiam rem earum reiciendis, fugiat deserunt molestiae. Officiis dignissimos accusamus eaque quibusdam ea quos ratione atque laudantium sit ab, nemo suscipit error animi libero explicabo vel exercitationem voluptates commodi obcaecati molestias non pariatur! Ullam harum, cum corrupti voluptates ratione nulla provident sequi eum.<\\/span><div><br \\/><\\/div><div>Perferendis expedita nesciunt itaque modi perspiciatis eligendi quam fugit similique illum numquam, nulla suscipit iusto veniam voluptatem unde, deserunt obcaecati enim iste. Quod, vitae necessitatibus? Tempora modi expedita enim odio quisquam, porro ipsam, placeat quos at labore nisi saepe mollitia cum fugiat iure! Dolorem voluptatibus fugiat, beatae adipisci itaque explicabo aperiam autem laudantium ratione consequuntur harum quos sit velit? Est debitis placeat animi tenetur molestias pariatur porro consectetur similique molestiae rerum ad optio quas recusandae accusantium dolor, omnis ullam saepe quo laboriosam eius repellat eveniet laborum unde!<\\/div><div><br \\/><\\/div><div>Voluptatem a dolorem consequuntur nam facilis in, laborum iste quas magnam non asperiores ea ab, aliquam temporibus. Saepe voluptates magni dicta! Veniam a optio odit repellendus necessitatibus rerum corporis soluta, nesciunt cum obcaecati delectus, libero ullam dolorem facere ducimus et architecto nihil explicabo fugiat. Ratione laudantium deserunt assumenda soluta molestias omnis veniam, illo iste, aut odit nesciunt praesentium expedita quo ea possimus asperiores quaerat beatae accusantium consequuntur laboriosam, in aspernatur officiis atque!<\\/div>\",\"image\":\"610fd13e155d21628426558.jpg\"}', '2021-08-08 06:42:38', '2021-08-08 06:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_currencies` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_form` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `code`, `alias`, `image`, `name`, `status`, `parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `input_form`, `created_at`, `updated_at`) VALUES
(1, 101, 'paypal', '5f6f1bd8678601601117144.jpg', 'Paypal', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-zlbi7986064@personal.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-01-17 03:02:44'),
(2, 102, 'perfect_money', '5f6f1d2a742211601117482.jpg', 'Perfect Money', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"6451561651551\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:46'),
(3, 103, 'stripe', '5f6f1d4bc69e71601117515.jpg', 'Stripe Hosted', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:49'),
(4, 104, 'skrill', '5f6f1d41257181601117505.jpg', 'Skrill', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:52'),
(5, 105, 'paytm', '5f6f1d1d3ec731601117469.jpg', 'PayTM', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:54'),
(6, 106, 'payeer', '5f6f1bc61518b1601117126.jpg', 'Payeer', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.payeer\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:26:58'),
(7, 107, 'paystack', '5f7096563dfb71601214038.jpg', 'PayStack', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_3c9c87f51b13c15d99eb367ca6ebc52cc9eb1f33\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_2a3f97a146ab5694801f993b60fcb81cd7254f12\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.paystack\"}}\r\n', NULL, NULL, '2019-09-14 13:14:22', '2020-12-28 01:25:38'),
(8, 108, 'voguepay', '5f6f1d5951a111601117529.jpg', 'VoguePay', 1, '{\"merchant_id\":{\"title\":\"MERCHANT ID\",\"global\":true,\"value\":\"demo\"}}', '{\"USD\":\"USD\",\"GBP\":\"GBP\",\"EUR\":\"EUR\",\"GHS\":\"GHS\",\"NGN\":\"NGN\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:52:09'),
(9, 109, 'flutterwave', '5f6f1b9e4bb961601117086.jpg', 'Flutterwave', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"demo_publisher_key\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"demo_secret_key\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"demo_encryption_key\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-01-04 03:29:50'),
(10, 110, 'razorpay', '5f6f1d3672dd61601117494.jpg', 'RazorPay', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:51:34'),
(11, 111, 'stripe_js', '5f7096a31ed9a1601214115.jpg', 'Stripe Storefront', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 03:56:20'),
(12, 112, 'instamojo', '5f6f1babbdbb31601117099.jpg', 'Instamojo', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:44:59'),
(13, 501, 'blockchain', '5f6f1b2b20c6f1601116971.jpg', 'Blockchain', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2021-01-31 06:55:45'),
(14, 502, 'blockio', '5f6f19432bedf1601116483.jpg', 'Block.io', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":false,\"value\":\"1658-8015-2e5e-9afb\"},\"api_pin\":{\"title\":\"API PIN\",\"global\":true,\"value\":\"covidvai2020\"}}', '{\"BTC\":\"BTC\",\"LTC\":\"LTC\",\"DOGE\":\"DOGE\"}', 1, '{\"cron\":{\"title\": \"Cron URL\",\"value\":\"ipn.blockio\"}}', NULL, NULL, '2019-09-14 13:14:22', '2021-01-03 23:19:59'),
(15, 503, 'coinpayments', '5f6f1b6c02ecd1601117036.jpg', 'CoinPayments', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"7638eebaf4061b7f7cdfceb14046318bbdabf7e2f64944773d6550bd59f70274\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"Cb6dee7af8Eb9E0D4123543E690dA3673294147A5Dc8e7a621B5d484a3803207\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:56'),
(16, 504, 'coinpayments_fiat', '5f6f1b94e9b2b1601117076.jpg', 'CoinPayments Fiat', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-22 03:17:29'),
(17, 505, 'coingate', '5f6f1b5fe18ee1601117023.jpg', 'Coingate', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"Ba1VgPx6d437xLXGKCBkmwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:44'),
(18, 506, 'coinbase_commerce', '5f6f1b4c774af1601117004.jpg', 'Coinbase Commerce', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.coinbase_commerce\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:43:24'),
(24, 113, 'paypal_sdk', '5f6f1bec255c61601117164.jpg', 'Paypal Express', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-10-31 23:50:27'),
(25, 114, 'stripe_v3', '5f709684736321601214084.jpg', 'Stripe Checkout', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51HuxFUHyGzEKoTKAfIosswAQduMOGU4q4elcNr8OE6LoBZcp2MHKalOW835wjRiF6fxVTc7RmBgatKfAt1Qq0heb00rUaCOd2T\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51HuxFUHyGzEKoTKAueAuF9BrMDA5boMcpJLLt0vu4q3QdPX5isaGudKNe6OyVjZP1UugpYd6JA7i7TczRWsbutaP004YmBiSp5\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"w5555\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.stripe_v3\"}}', NULL, NULL, '2019-09-14 13:14:22', '2020-12-05 03:56:14'),
(27, 115, 'mollie', '5f6f1bb765ab11601117111.jpg', 'Mollie', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"ronniearea@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2019-09-14 13:14:22', '2020-09-26 04:45:11'),
(30, 116, 'cashmaal', '5f9a8b62bb4dd1603963746.png', 'Cashmaal', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.cashmaal\"}}', NULL, NULL, NULL, '2020-10-29 03:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_code` int(11) DEFAULT NULL,
  `gateway_alias` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(18,8) NOT NULL,
  `max_amount` decimal(18,8) NOT NULL,
  `percent_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `fixed_charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameter` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sitename` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `regular` int(2) NOT NULL,
  `extended` int(2) NOT NULL,
  `email_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_api` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_color` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email configuration',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'sms notification, 0 - dont send, 1 - send',
  `registration` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Off	, 1: On',
  `social_login` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'social login',
  `social_credential` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_version` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `sitename`, `cur_text`, `cur_sym`, `regular`, `extended`, `email_from`, `email_template`, `sms_api`, `base_color`, `secondary_color`, `mail_config`, `ev`, `en`, `sv`, `sn`, `registration`, `social_login`, `social_credential`, `active_template`, `sys_version`, `created_at`, `updated_at`) VALUES
(1, 'Viserplace', 'USD', '$', 5, 10, 'do-not-reply@viserlab.com', '<table style=\"color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-size: medium; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(0, 23, 54); text-decoration-style: initial; text-decoration-color: initial;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#001736\"><tbody><tr><td valign=\"top\" align=\"center\"><table class=\"mobile-shell\" width=\"650\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"td container\" style=\"width: 650px; min-width: 650px; font-size: 0pt; line-height: 0pt; margin: 0px; font-weight: normal; padding: 55px 0px;\"><div style=\"text-align: center;\"><img src=\"https://i.imgur.com/C9IS7Z1.png\" style=\"height: 240 !important;width: 338px;margin-bottom: 20px;\"></div><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"padding-bottom: 10px;\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"tbrr p30-15\" style=\"padding: 60px 30px; border-radius: 26px 26px 0px 0px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td style=\"color: rgb(255, 255, 255); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 46px; padding-bottom: 25px; font-weight: bold;\">Hi {{name}} ,</td></tr><tr><td style=\"color: rgb(193, 205, 220); font-family: Muli, Arial, sans-serif; font-size: 20px; line-height: 30px; padding-bottom: 25px;\">{{message}}</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table style=\"width: 650px; margin: 0px auto;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"p30-15 bbrr\" style=\"padding: 50px 30px; border-radius: 0px 0px 26px 26px;\" bgcolor=\"#000036\"><table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"text-footer1 pb10\" style=\"color: rgb(0, 153, 255); font-family: Muli, Arial, sans-serif; font-size: 18px; line-height: 30px; text-align: center; padding-bottom: 10px;\">© 2021 ViserLab. All Rights Reserved.</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>', 'https://api.infobip.com/api/v3/sendsms/plain?user=viserlab&password=26289099&sender=ViserLab&SMSText={{message}}&GSM={{number}}&type=longSMS', '00b580', '011731', '{\"name\":\"php\"}', 1, 1, 0, 1, 1, 0, '{\"google_client_id\":\"53929591142-l40gafo7efd9onfe6tj545sf9g7tv15t.apps.googleusercontent.com\",\"google_client_secret\":\"BRdB3np2IgYLiy4-bwMcmOwN\",\"fb_client_id\":\"277229062999748\",\"fb_client_secret\":\"1acfc850f73d1955d14b282938585122\"}', 'basic', NULL, NULL, '2021-08-08 07:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_align` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: left to right text align, 1: right to left text align',
  `is_default` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `icon`, `text_align`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '5f15968db08911595250317.png', 0, 1, '2020-07-06 03:47:55', '2021-08-08 07:47:49'),
(4, 'bangla', 'bn', '5f1596a650cd11595250342.png', 0, 0, '2020-07-20 07:05:42', '2021-01-03 23:59:33'),
(5, 'Hindi', 'hn', NULL, 0, 0, '2020-12-29 02:20:07', '2020-12-29 02:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `earning` int(11) NOT NULL,
  `product_charge` int(11) NOT NULL,
  `default_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `image`, `earning`, `product_charge`, `default_status`, `created_at`, `updated_at`) VALUES
(1, 'Default Level', 'default.png', 0, 5, 1, '2021-04-19 23:53:06', '2021-05-22 02:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `license` tinyint(1) NOT NULL,
  `support` tinyint(1) NOT NULL,
  `support_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_fee` decimal(18,8) NOT NULL,
  `product_price` decimal(18,8) NOT NULL,
  `total_price` decimal(18,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', 'home', 'templates.basic.', '[\"featured_product\",\"best_sell_product\",\"latest_product\",\"best_author_product\",\"featured_auhor\",\"testimonial\",\"blog\",\"subscribe\"]', 1, '2020-07-11 06:23:58', '2021-08-08 04:38:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `update_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'pending:1, Approved:2, Rejected:3',
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `regular_price` decimal(18,8) NOT NULL,
  `extended_price` decimal(18,8) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Pending:0, Approved:1, Soft Reject:2, Hard Reject:3, Deleted:4, Rsubmitted:5',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `total_sell` int(11) NOT NULL DEFAULT 0,
  `total_rating` int(11) NOT NULL DEFAULT 0,
  `total_response` int(11) NOT NULL DEFAULT 0,
  `avg_rating` tinyint(1) NOT NULL DEFAULT 0,
  `support` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Yes:1, No:0',
  `support_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `support_discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `screenshot` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `demo_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `soft_reject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hard_reject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_reject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(11) DEFAULT NULL,
  `balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `ev` tinyint(1) NOT NULL,
  `sv` tinyint(1) NOT NULL,
  `ver_code` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ver_code_send_at` datetime DEFAULT NULL,
  `ts` tinyint(1) NOT NULL,
  `tv` tinyint(1) NOT NULL,
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewer_logins`
--

CREATE TABLE `reviewer_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewer_password_resets`
--

CREATE TABLE `reviewer_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sells`
--

CREATE TABLE `sells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `license` tinyint(1) NOT NULL,
  `support` tinyint(1) NOT NULL,
  `support_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_fee` decimal(18,8) NOT NULL,
  `product_price` decimal(18,8) NOT NULL,
  `total_price` decimal(18,8) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT 'Pending:0, Approved:1, Rejected:2',
  `reject_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Active:1, Deactive:2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_message_id` int(11) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `supportticket_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_products`
--

CREATE TABLE `temp_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT 'Resubmit:1, Update:2',
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `regular_price` decimal(18,8) NOT NULL,
  `extended_price` decimal(18,8) NOT NULL,
  `support` int(1) NOT NULL DEFAULT 0,
  `support_charge` decimal(5,2) NOT NULL DEFAULT 0.00,
  `support_discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `screenshot` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `demo_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `post_balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `trx_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` int(11) DEFAULT 1,
  `top_author` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(11) DEFAULT NULL,
  `balance` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `earning` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `total_rating` int(11) NOT NULL DEFAULT 0,
  `total_response` int(11) NOT NULL DEFAULT 0,
  `avg_rating` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: sms unverified, 1: sms verified',
  `ver_code` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(91) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(10) UNSIGNED NOT NULL,
  `method_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(18,8) NOT NULL,
  `currency` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(18,8) NOT NULL,
  `charge` decimal(18,8) NOT NULL,
  `trx` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_amount` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `after_charge` decimal(18,8) NOT NULL,
  `withdraw_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(18,8) DEFAULT NULL,
  `max_limit` decimal(18,8) NOT NULL DEFAULT 0.00000000,
  `delay` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_charge` decimal(18,8) DEFAULT NULL,
  `rate` decimal(18,8) DEFAULT NULL,
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_details`
--
ALTER TABLE `category_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featureds`
--
ALTER TABLE `featureds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`email`);

--
-- Indexes for table `reviewer_logins`
--
ALTER TABLE `reviewer_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewer_password_resets`
--
ALTER TABLE `reviewer_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_products`
--
ALTER TABLE `temp_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_details`
--
ALTER TABLE `category_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_sms_templates`
--
ALTER TABLE `email_sms_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `featureds`
--
ALTER TABLE `featureds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewer_logins`
--
ALTER TABLE `reviewer_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewer_password_resets`
--
ALTER TABLE `reviewer_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_products`
--
ALTER TABLE `temp_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
