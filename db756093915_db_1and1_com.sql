-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: db756093915.db.1and1.com
-- Generation Time: Dec 27, 2018 at 05:41 PM
-- Server version: 5.5.60-0+deb7u1-log
-- PHP Version: 7.0.33-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db756093915`
--
CREATE DATABASE IF NOT EXISTS `db756093915` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db756093915`;

-- --------------------------------------------------------

--
-- Table structure for table `action_configurations`
--

CREATE TABLE `action_configurations` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_id` int(10) UNSIGNED NOT NULL,
  `action_plan_configuration_id` int(10) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `started_date` date DEFAULT NULL,
  `estimated_fulfillment_date` date DEFAULT NULL,
  `real_fulfillment_date` date DEFAULT NULL,
  `current_objectives` int(11) DEFAULT NULL,
  `collaboration` tinyint(1) NOT NULL DEFAULT '0',
  `done_before` tinyint(1) NOT NULL DEFAULT '0',
  `know_what_to_do` tinyint(1) NOT NULL DEFAULT '0',
  `knowledge_level` int(11) DEFAULT NULL,
  `know_how_to_improve` tinyint(1) NOT NULL DEFAULT '0',
  `improve_knowledge` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `action_configurations`
--

INSERT INTO `action_configurations` (`id`, `action_id`, `action_plan_configuration_id`, `start_date`, `ending_date`, `started_date`, `estimated_fulfillment_date`, `real_fulfillment_date`, `current_objectives`, `collaboration`, `done_before`, `know_what_to_do`, `knowledge_level`, `know_how_to_improve`, `improve_knowledge`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2018-11-27', '2018-11-28', NULL, NULL, NULL, NULL, 1, 0, 0, NULL, 0, NULL, '2018-11-18 12:28:59', '2018-11-18 12:28:59'),
(2, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, 0, NULL, '2018-11-18 12:30:30', '2018-11-18 12:30:30'),
(3, 3, 3, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, 0, NULL, '2018-11-18 19:21:54', '2018-11-18 19:21:54'),
(4, 4, 4, '2018-11-20', '2018-12-12', NULL, NULL, NULL, NULL, 1, 0, 0, NULL, 0, NULL, '2018-11-20 14:09:48', '2018-11-20 14:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `action_micro_content`
--

CREATE TABLE `action_micro_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_id` int(10) UNSIGNED NOT NULL,
  `micro_content_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `action_micro_content`
--

INSERT INTO `action_micro_content` (`id`, `action_id`, `micro_content_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `action_plan_configuration_user`
--

CREATE TABLE `action_plan_configuration_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_plan_configuration_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `action_plan_configurations`
--

CREATE TABLE `action_plan_configurations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action_plan_id` int(10) UNSIGNED NOT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `has_coach` tinyint(1) DEFAULT NULL,
  `coach_id` int(10) UNSIGNED DEFAULT NULL,
  `coach_functions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracing` tinyint(1) DEFAULT NULL,
  `reminders` tinyint(1) DEFAULT NULL,
  `reminders_period` int(11) DEFAULT NULL,
  `reminders_value` bigint(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `action_plan_configurations`
--

INSERT INTO `action_plan_configurations` (`id`, `user_id`, `action_plan_id`, `public`, `has_coach`, `coach_id`, `coach_functions`, `tracing`, `reminders`, `reminders_period`, `reminders_value`, `start_date`, `ending_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 0, NULL, NULL, NULL, 1, 1, 1542550200, '2018-11-11', '2018-11-22', '2018-11-18 12:28:59', '2018-11-18 12:28:59'),
(2, 3, 2, NULL, 0, NULL, NULL, NULL, 1, 1, 1542550200, NULL, NULL, '2018-11-18 12:30:29', '2018-11-18 12:30:29'),
(3, 3, 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-27', '2018-11-30', '2018-11-18 19:21:53', '2018-11-18 19:21:53'),
(4, 3, 4, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-21', '2018-11-29', '2018-11-20 14:09:48', '2018-11-20 14:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `action_plan_topic`
--

CREATE TABLE `action_plan_topic` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_plan_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `action_plans`
--

CREATE TABLE `action_plans` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `collaboration` smallint(6) NOT NULL DEFAULT '0',
  `objectives` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `action_plans`
--

INSERT INTO `action_plans` (`id`, `title`, `type`, `collaboration`, `objectives`, `created_at`, `updated_at`) VALUES
(1, 'Cómo cambiar los hábitos para conseguír los nuestros.', 0, 0, 'cumplir plan', '2018-11-18 12:28:59', '2018-11-18 19:03:44'),
(2, 'Cómo cambiar los hábitos para conseguír los nuestros.', 0, 1, 'cumplir plan', '2018-11-18 12:30:29', '2018-11-18 20:49:41'),
(3, 'Cómo cambiar los hábitos para conseguír los nuestros.', 0, 1, 'Ni idea', '2018-11-18 19:21:53', '2018-11-18 19:21:53'),
(4, 'Cómo cambiar los hábitos para conseguír los nuestros.', 0, 1, 'Cómo cambiar los hábitos para conseguír los nuestros.', '2018-11-20 14:09:47', '2018-11-20 14:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `action_tests`
--

CREATE TABLE `action_tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_plan_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectives` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objectives_percent` double(8,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `action_plan_id`, `title`, `objectives`, `objectives_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 'plan de accion2', 'cumplir plan2', 50.00, '2018-11-18 12:28:59', '2018-11-18 12:28:59'),
(2, 2, 'plan de accion2', 'cumplir plan2', 50.00, '2018-11-18 12:30:29', '2018-11-18 12:30:29'),
(3, 3, 'Accion 1', NULL, 23.00, '2018-11-18 19:21:54', '2018-11-18 19:21:54'),
(4, 4, 'Plan 2', 'Cómo cambiar los hábitos para conseguír los nuestros.', 10.00, '2018-11-20 14:09:48', '2018-11-20 14:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `answer_user_question`
--

CREATE TABLE `answer_user_question` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `answer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answer_user_question`
--

INSERT INTO `answer_user_question` (`id`, `user_id`, `question_id`, `answer_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, NULL, NULL),
(2, 3, 1, 1, NULL, NULL),
(3, 1, 1, 1, NULL, NULL),
(4, 1, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `value`, `is_correct`, `created_at`, `updated_at`) VALUES
(1, 1, 'nada...', 1, '2018-11-18 12:25:02', '2018-11-21 00:19:54'),
(2, 2, 'esta bien te creo...', 1, '2018-11-21 00:17:33', '2018-11-21 00:17:54'),
(3, 3, 'si eso mismo...', 1, '2018-11-21 00:19:14', '2018-11-21 00:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `automatic` int(11) DEFAULT NULL,
  `approach` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `name`, `description`, `automatic`, `approach`, `created_at`, `updated_at`) VALUES
(1, 'chatbot', 'descripcion de chatbot', NULL, 'Plan de acción', '2018-12-04 08:43:35', '2018-12-04 08:43:35'),
(2, 'chatbot2', 'esto es un chatbot', NULL, 'Intereses', '2018-12-06 20:56:04', '2018-12-06 20:56:04'),
(3, 'chatbot3', 'esto es otro chatbot', NULL, 'Reuniones', '2018-12-06 20:56:51', '2018-12-06 20:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_answer_chatbot`
--

CREATE TABLE `chatbot_answer_chatbot` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` int(11) DEFAULT NULL,
  `is_correct` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_question_chatbot`
--

CREATE TABLE `chatbot_question_chatbot` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_user`
--

CREATE TABLE `department_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `entity_notifications`
--

CREATE TABLE `entity_notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_configurations`
--

CREATE TABLE `evaluation_configurations` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_test_id` int(10) UNSIGNED NOT NULL,
  `action_configuration_id` int(10) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `free_contents`
--

CREATE TABLE `free_contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `action_plan_id` int(10) UNSIGNED NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE `group_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_user`
--

INSERT INTO `group_user` (`id`, `user_id`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL),
(2, 5, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Grupo 1', '2018-11-01 12:40:28', '2018-11-01 12:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interest_topic`
--

CREATE TABLE `interest_topic` (
  `id` int(10) UNSIGNED NOT NULL,
  `interest_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `importance_level` int(11) DEFAULT NULL,
  `knowledge_valuation` int(11) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `objectives` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL,
  `reminders` tinyint(1) DEFAULT NULL,
  `reminders_period` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` (`id`, `user_id`, `title`, `importance_level`, `knowledge_valuation`, `expiration_date`, `objectives`, `public`, `reminders`, `reminders_period`, `created_at`, `updated_at`) VALUES
(1, 1, 'Interes', 3, 1, '2018-10-11', 'Objetivo 1', NULL, 1, 1, '2018-11-01 12:42:12', '2018-11-01 12:42:12'),
(2, 1, 'yo', 2, 2, NULL, 'jn sd', NULL, NULL, 4, '2018-11-04 12:05:20', '2018-11-05 14:44:35'),
(3, 1, 'Jessica', 1, 0, NULL, 'joder', NULL, NULL, 4, '2018-11-06 14:37:42', '2018-11-06 14:37:42'),
(4, 1, 'Yanniel', 2, 1, '2018-10-10', 'blabla', NULL, NULL, 4, '2018-11-06 14:38:40', '2018-11-06 14:38:40'),
(5, 1, 'Rey', 3, 2, '2018-10-12', 'dgsd', NULL, NULL, 4, '2018-11-06 14:39:18', '2018-11-06 14:39:18'),
(6, 1, 'ariel', 4, 2, '2018-10-03', 'fdfgsd', NULL, NULL, 4, '2018-11-06 14:40:14', '2018-11-06 14:40:14'),
(7, 1, 'God', 5, 2, '2018-10-03', 'dafg', NULL, NULL, 4, '2018-11-06 14:41:07', '2018-11-06 14:41:07'),
(8, 1, 'text area', 2, 0, '2018-11-15', 'Text area sdfkijgskdfnmvjsndf sdfin sdfkvnsdfkv sdfokvsodifjvsd dfkvinskdjfnvskjdfv', NULL, 1, 2, '2018-11-08 07:23:47', '2018-11-08 07:23:47');

-- --------------------------------------------------------

--
-- Table structure for table `micro_content_topic`
--

CREATE TABLE `micro_content_topic` (
  `id` int(10) UNSIGNED NOT NULL,
  `micro_content_id` int(10) UNSIGNED NOT NULL,
  `topic_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `micro_content_topic`
--

INSERT INTO `micro_content_topic` (`id`, `micro_content_id`, `topic_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `micro_contents`
--

CREATE TABLE `micro_contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED NOT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `micro_contents`
--

INSERT INTO `micro_contents` (`id`, `title`, `public`, `user_id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Cómo cambiar los hábitos para conseguír los nuestros.', 0, 3, 1, '2018-11-18 12:25:02', '2018-11-21 00:19:54'),
(2, 'Cómo cambiar los hábitos para conseguír los nuestros.', 0, 3, 0, '2018-11-21 00:17:32', '2018-11-21 00:17:54'),
(3, 'Cómo cambiar los hábitos para conseguír los nuestros.', 1, 3, 1, '2018-11-21 00:19:14', '2018-11-21 00:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_08_27_061439_create_plan_answers_table', 1),
(4, '2018_08_27_061540_create_plan_questions_table', 1),
(5, '2018_08_27_061615_create_plan_question_options_table', 1),
(6, '2018_08_27_174315_create_action_plan_configuration_user_table', 1),
(7, '2018_08_27_174754_create_user_evaluation_configuration_table', 1),
(8, '2018_08_27_181043_create_departments_table', 1),
(9, '2018_08_27_181224_create_action_plans_table', 1),
(10, '2018_08_27_181519_create_action_tests_table', 1),
(11, '2018_08_27_181623_create_actions_table', 1),
(12, '2018_08_27_182017_create_user_visibilities_table', 1),
(13, '2018_08_27_182039_create_notifications_table', 1),
(14, '2018_08_27_182255_create_action_plan_configurations_table', 1),
(15, '2018_08_27_182442_create_action_plan_topic_table', 1),
(16, '2018_08_27_184050_create_user_interest_table', 1),
(17, '2018_08_27_184614_create_action_micro_content_table', 1),
(18, '2018_08_27_191043_create_topics_table', 1),
(19, '2018_08_27_191059_create_interests_table', 1),
(20, '2018_08_27_191150_create_interest_topic_table', 1),
(21, '2018_08_27_192039_create_entity_notifications_table', 1),
(22, '2018_08_27_201043_create_groups_table', 1),
(23, '2018_08_27_201133_create_micro_contents_table', 1),
(24, '2018_08_27_202354_create_action_configurations_table', 1),
(25, '2018_08_27_205011_create_evaluation_configurations_table', 1),
(26, '2018_08_27_211103_create_questions_table', 1),
(27, '2018_08_27_211114_create_answers_table', 1),
(28, '2018_08_27_211204_create_pages_table', 1),
(29, '2018_08_27_221127_create_micro_content_topic_table', 1),
(30, '2018_08_27_221204_create_free_contents_table', 1),
(31, '2018_08_27_233024_create_answer_user_question_table', 1),
(32, '2018_08_27_233124_create_department_user_table', 1),
(33, '2018_08_27_233124_create_group_user_table', 1),
(34, '2018_08_27_233500_create_images_table', 1),
(35, '2018_08_28_171451_create_foreigns_keys', 1),
(36, '2018_08_30_201934_create_permission_tables', 1),
(37, '2018_11_28_210550_create_chatbot_table', 2),
(38, '2018_11_28_210851_create_chatbot_answer_chatbot_table', 2),
(39, '2018_11_28_210915_create_chatbot_question_chatbot_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\User', 3),
(3, 'App\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `micro_content_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `micro_content_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(3, 2, 'Cómo cambiar los hábitos para conseguír los nuestros.', '', '2018-11-21 00:17:54', '2018-11-21 00:17:54'),
(4, 3, 'Cómo cambiar los hábitos para conseguír los nuestros.', '', '2018-11-21 00:19:14', '2018-11-21 00:19:14'),
(5, 1, 'micro1', '', '2018-11-21 00:19:54', '2018-11-21 00:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'users-list', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18'),
(2, 'user-create', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18'),
(3, 'user-read', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18'),
(4, 'user-update', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18'),
(5, 'user-delete', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `plan_answers`
--

CREATE TABLE `plan_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `plan_question_id` int(10) UNSIGNED NOT NULL,
  `action_configuration_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_question_options`
--

CREATE TABLE `plan_question_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `plan_question_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plan_question_options`
--

INSERT INTO `plan_question_options` (`id`, `plan_question_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 'no es nada...', '2018-11-18 12:28:59', '2018-11-18 12:28:59'),
(2, 2, 'no es nada...', '2018-11-18 12:30:30', '2018-11-18 12:30:30'),
(3, 3, NULL, '2018-11-18 19:21:54', '2018-11-18 19:21:54'),
(4, 4, 'aqui..', '2018-11-20 14:09:49', '2018-11-20 14:09:49');

-- --------------------------------------------------------

--
-- Table structure for table `plan_questions`
--

CREATE TABLE `plan_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_id` int(10) UNSIGNED NOT NULL,
  `action_plan_id` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plan_questions`
--

INSERT INTO `plan_questions` (`id`, `title`, `action_id`, `action_plan_id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'que es plan de accion?', 1, NULL, 0, '2018-11-18 12:28:59', '2018-11-18 12:28:59'),
(2, 'que es plan de accion?', 2, NULL, 0, '2018-11-18 12:30:30', '2018-11-18 12:30:30'),
(3, 'Pregunta1', 3, NULL, 0, '2018-11-18 19:21:54', '2018-11-18 19:21:54'),
(4, 'donde ?', 4, NULL, 0, '2018-11-20 14:09:48', '2018-11-20 14:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `micro_content_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `micro_content_id`, `value`, `points`, `created_at`, `updated_at`) VALUES
(1, 1, 'que es?', 3.00, '2018-11-18 12:25:02', '2018-11-18 12:25:02'),
(2, 2, 'de que se trata?', 67.00, '2018-11-21 00:17:33', '2018-11-21 00:17:33'),
(3, 3, 'que es?', 45.00, '2018-11-21 00:19:14', '2018-11-21 00:19:14');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `color`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '#EE6255', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18'),
(2, 'Jefe', '#79C944', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18'),
(3, 'Empleado', '#FFAD00', 'web', '2018-11-01 12:25:18', '2018-11-01 12:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Tema 1', '2018-11-01 12:42:57', '2018-11-01 12:42:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_evaluation_configuration`
--

CREATE TABLE `user_evaluation_configuration` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `evaluation_configuration_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_interest`
--

CREATE TABLE `user_interest` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `interest_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_interest`
--

INSERT INTO `user_interest` (`id`, `user_id`, `interest_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL),
(8, 1, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_visibilities`
--

CREATE TABLE `user_visibilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `target_user_id` int(10) UNSIGNED NOT NULL,
  `permission` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `evaluation` double(8,2) DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `boss_id` int(10) UNSIGNED DEFAULT NULL,
  `is_coach` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `evaluation`, `email`, `password`, `avatar`, `boss_id`, `is_coach`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'yaniel', '', NULL, 'tato@icid.cu', '$2y$10$Uwt70aJdQW/TGNmK1RLlze5WVbYaQ8N1hj4O0Hi85sJwXJQqzkJLS', NULL, NULL, NULL, 'LxujdqTWgxIok131Y7RCCOCPxt22SDyzfo2hEX1swhGcqRApa81NwmWGr2es', '2018-11-01 12:39:00', '2018-11-01 12:39:00'),
(3, 'Jorge', 'Rodríguez', NULL, 'jorge@rocket.com', '$2y$10$jLVpb8bKys126SNcmmOHgO0d1vrUq0QVbzBne8n5aULmpTkqcY95u', 'gRNOGTonOkpEtXexFrHlOLnkc8edCp12ZzJxJYjmDZZwUA4jVdrm0nX66KUePj8X.jpg', NULL, 0, '64rkhRYQCIuZbI88fWgHQHmN1L9T6Fq1PqkItnWloBBEzRkJI0IQ9QyRdVER', '2018-11-18 08:39:08', '2018-11-18 13:36:18'),
(4, 'raidel', NULL, NULL, 'raidel@learning.com', '$2y$10$ty.HXi0OGL9Hxh/Bk544seH23E1SPWMhFLah1D/PjWFm0Mle5Elvm', NULL, NULL, NULL, 'vPRfSunonkWE2DTCQeUrVsXT5VtwqTdUmZsqNGpm0DRbb9yziKa9HOfLZDQ2', '2018-11-19 10:34:45', '2018-11-19 10:34:45'),
(5, 'raidel', 'pupo', NULL, 'raidel@rocket.com', '$2y$10$ytjrjpbOLnFnG77tMQtH6eIgLO.7QrjQe1wUrxjiAXH9yPtGOUFb2', 'cuTO7E1Vpz7uETBwmu0zsLi55wzEJbrX5DtyoTwejgrwSf6i9penY7BabkSXzErA.jpg', NULL, 0, NULL, '2018-11-19 11:07:28', '2018-11-19 11:07:28'),
(6, 'amauri', NULL, NULL, 'amauri@gmail.com', '$2y$10$rPCrnamIaqrZJBUaxUgxhuJ9Md3xwlYP5KdSlY8MNC0dfHyHSDuPC', NULL, NULL, NULL, NULL, '2018-11-21 06:46:02', '2018-11-21 06:46:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_configurations`
--
ALTER TABLE `action_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `acaai_fk` (`action_id`),
  ADD KEY `acacpapci_fk` (`action_plan_configuration_id`);

--
-- Indexes for table `action_micro_content`
--
ALTER TABLE `action_micro_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `amcaai_fk` (`action_id`),
  ADD KEY `amcmcmci_fk` (`micro_content_id`);

--
-- Indexes for table `action_plan_configuration_user`
--
ALTER TABLE `action_plan_configuration_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apceapcapci_fk` (`action_plan_configuration_id`),
  ADD KEY `apceeei_fk` (`user_id`);

--
-- Indexes for table `action_plan_configurations`
--
ALTER TABLE `action_plan_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apceei_fk` (`user_id`),
  ADD KEY `apcapapi_fk` (`action_plan_id`),
  ADD KEY `apceci_fk` (`coach_id`);

--
-- Indexes for table `action_plan_topic`
--
ALTER TABLE `action_plan_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aptapapi_fk` (`action_plan_id`),
  ADD KEY `apttti_fk` (`topic_id`);

--
-- Indexes for table `action_plans`
--
ALTER TABLE `action_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `action_tests`
--
ALTER TABLE `action_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ataai_fk` (`action_id`);

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aapapi_fk` (`action_plan_id`);

--
-- Indexes for table `answer_user_question`
--
ALTER TABLE `answer_user_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auquui_fk` (`user_id`),
  ADD KEY `auqqqi_fk` (`question_id`),
  ADD KEY `auqaai_fk` (`answer_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aqqi_fk` (`question_id`);

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot_answer_chatbot`
--
ALTER TABLE `chatbot_answer_chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot_question_chatbot`
--
ALTER TABLE `chatbot_question_chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_user`
--
ALTER TABLE `department_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `duuui_fk` (`user_id`),
  ADD KEY `duddi_fk` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entity_notifications`
--
ALTER TABLE `entity_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ennni_fk` (`notification_id`);

--
-- Indexes for table `evaluation_configurations`
--
ALTER TABLE `evaluation_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evatati_fk` (`action_test_id`),
  ADD KEY `ecacaci_fk` (`action_configuration_id`);

--
-- Indexes for table `free_contents`
--
ALTER TABLE `free_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fcapapi_fk` (`action_plan_id`);

--
-- Indexes for table `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guuui_fk` (`user_id`),
  ADD KEY `puggi_fk` (`group_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interest_topic`
--
ALTER TABLE `interest_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itiii_fk` (`interest_id`),
  ADD KEY `ittti_fk` (`topic_id`);

--
-- Indexes for table `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ieei_fk` (`user_id`);

--
-- Indexes for table `micro_content_topic`
--
ALTER TABLE `micro_content_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mctmcmci_fk` (`micro_content_id`),
  ADD KEY `mcttti_fk` (`topic_id`);

--
-- Indexes for table `micro_contents`
--
ALTER TABLE `micro_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mcuui_fk` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `neei_fk` (`user_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pmcmci_fk` (`micro_content_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_answers`
--
ALTER TABLE `plan_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `papqpqi_fk` (`plan_question_id`),
  ADD KEY `papqaci_fk` (`action_configuration_id`),
  ADD KEY `paupaui_fk` (`user_id`);

--
-- Indexes for table `plan_question_options`
--
ALTER TABLE `plan_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pqopqpqi_fk` (`plan_question_id`);

--
-- Indexes for table `plan_questions`
--
ALTER TABLE `plan_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pqaai_fk` (`action_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qmcmci_fk` (`micro_content_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_evaluation_configuration`
--
ALTER TABLE `user_evaluation_configuration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eeceei_fk` (`user_id`),
  ADD KEY `eecececi_fk` (`evaluation_configuration_id`);

--
-- Indexes for table `user_interest`
--
ALTER TABLE `user_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eieei_fk` (`user_id`),
  ADD KEY `eiiii_fk` (`interest_id`);

--
-- Indexes for table `user_visibilities`
--
ALTER TABLE `user_visibilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eveei_fk` (`user_id`),
  ADD KEY `evetei_fk` (`target_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_configurations`
--
ALTER TABLE `action_configurations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `action_micro_content`
--
ALTER TABLE `action_micro_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `action_plan_configuration_user`
--
ALTER TABLE `action_plan_configuration_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `action_plan_configurations`
--
ALTER TABLE `action_plan_configurations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `action_plan_topic`
--
ALTER TABLE `action_plan_topic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `action_plans`
--
ALTER TABLE `action_plans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `action_tests`
--
ALTER TABLE `action_tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `answer_user_question`
--
ALTER TABLE `answer_user_question`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `chatbot_answer_chatbot`
--
ALTER TABLE `chatbot_answer_chatbot`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chatbot_question_chatbot`
--
ALTER TABLE `chatbot_question_chatbot`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department_user`
--
ALTER TABLE `department_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `entity_notifications`
--
ALTER TABLE `entity_notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evaluation_configurations`
--
ALTER TABLE `evaluation_configurations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `free_contents`
--
ALTER TABLE `free_contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `group_user`
--
ALTER TABLE `group_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `interest_topic`
--
ALTER TABLE `interest_topic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `micro_content_topic`
--
ALTER TABLE `micro_content_topic`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `micro_contents`
--
ALTER TABLE `micro_contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `plan_answers`
--
ALTER TABLE `plan_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `plan_question_options`
--
ALTER TABLE `plan_question_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `plan_questions`
--
ALTER TABLE `plan_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_evaluation_configuration`
--
ALTER TABLE `user_evaluation_configuration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_interest`
--
ALTER TABLE `user_interest`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_visibilities`
--
ALTER TABLE `user_visibilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `action_configurations`
--
ALTER TABLE `action_configurations`
  ADD CONSTRAINT `acaai_fk` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `acacpapci_fk` FOREIGN KEY (`action_plan_configuration_id`) REFERENCES `action_plan_configurations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `action_micro_content`
--
ALTER TABLE `action_micro_content`
  ADD CONSTRAINT `amcaai_fk` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `amcmcmci_fk` FOREIGN KEY (`micro_content_id`) REFERENCES `micro_contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `action_plan_configuration_user`
--
ALTER TABLE `action_plan_configuration_user`
  ADD CONSTRAINT `apceapcapci_fk` FOREIGN KEY (`action_plan_configuration_id`) REFERENCES `action_plan_configurations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `apceeei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `action_plan_configurations`
--
ALTER TABLE `action_plan_configurations`
  ADD CONSTRAINT `apcapapi_fk` FOREIGN KEY (`action_plan_id`) REFERENCES `action_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `apceci_fk` FOREIGN KEY (`coach_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `apceei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `action_plan_topic`
--
ALTER TABLE `action_plan_topic`
  ADD CONSTRAINT `aptapapi_fk` FOREIGN KEY (`action_plan_id`) REFERENCES `action_plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `apttti_fk` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `action_tests`
--
ALTER TABLE `action_tests`
  ADD CONSTRAINT `ataai_fk` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`);

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `aapapi_fk` FOREIGN KEY (`action_plan_id`) REFERENCES `action_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `answer_user_question`
--
ALTER TABLE `answer_user_question`
  ADD CONSTRAINT `auqaai_fk` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auqqqi_fk` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auquui_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `aqqi_fk` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `department_user`
--
ALTER TABLE `department_user`
  ADD CONSTRAINT `duddi_fk` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `duuui_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `entity_notifications`
--
ALTER TABLE `entity_notifications`
  ADD CONSTRAINT `ennni_fk` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`);

--
-- Constraints for table `evaluation_configurations`
--
ALTER TABLE `evaluation_configurations`
  ADD CONSTRAINT `ecacaci_fk` FOREIGN KEY (`action_configuration_id`) REFERENCES `action_configurations` (`id`),
  ADD CONSTRAINT `evatati_fk` FOREIGN KEY (`action_test_id`) REFERENCES `action_tests` (`id`);

--
-- Constraints for table `free_contents`
--
ALTER TABLE `free_contents`
  ADD CONSTRAINT `fcapapi_fk` FOREIGN KEY (`action_plan_id`) REFERENCES `action_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `guuui_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `puggi_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `interest_topic`
--
ALTER TABLE `interest_topic`
  ADD CONSTRAINT `itiii_fk` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`id`),
  ADD CONSTRAINT `ittti_fk` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

--
-- Constraints for table `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `ieei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `micro_content_topic`
--
ALTER TABLE `micro_content_topic`
  ADD CONSTRAINT `mctmcmci_fk` FOREIGN KEY (`micro_content_id`) REFERENCES `micro_contents` (`id`),
  ADD CONSTRAINT `mcttti_fk` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

--
-- Constraints for table `micro_contents`
--
ALTER TABLE `micro_contents`
  ADD CONSTRAINT `mcuui_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `neei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pmcmci_fk` FOREIGN KEY (`micro_content_id`) REFERENCES `micro_contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plan_answers`
--
ALTER TABLE `plan_answers`
  ADD CONSTRAINT `papqaci_fk` FOREIGN KEY (`action_configuration_id`) REFERENCES `action_configurations` (`id`),
  ADD CONSTRAINT `papqpqi_fk` FOREIGN KEY (`plan_question_id`) REFERENCES `plan_questions` (`id`),
  ADD CONSTRAINT `paupaui_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `plan_question_options`
--
ALTER TABLE `plan_question_options`
  ADD CONSTRAINT `pqopqpqi_fk` FOREIGN KEY (`plan_question_id`) REFERENCES `plan_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plan_questions`
--
ALTER TABLE `plan_questions`
  ADD CONSTRAINT `pqaai_fk` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `qmcmci_fk` FOREIGN KEY (`micro_content_id`) REFERENCES `micro_contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_evaluation_configuration`
--
ALTER TABLE `user_evaluation_configuration`
  ADD CONSTRAINT `eecececi_fk` FOREIGN KEY (`evaluation_configuration_id`) REFERENCES `evaluation_configurations` (`id`),
  ADD CONSTRAINT `eeceei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_interest`
--
ALTER TABLE `user_interest`
  ADD CONSTRAINT `eieei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `eiiii_fk` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`id`);

--
-- Constraints for table `user_visibilities`
--
ALTER TABLE `user_visibilities`
  ADD CONSTRAINT `eveei_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `evetei_fk` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
