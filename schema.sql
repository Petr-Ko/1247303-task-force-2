DROP
DATABASE IF EXISTS task_force;

CREATE
DATABASE task_force
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_unicode_ci;

USE
task_force;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База данных: `task_force`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `location` point NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `executor_categories`
--

CREATE TABLE `executor_categories` (
  `id` int NOT NULL,
  `executor_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int NOT NULL,
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `path` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `responses`
--

CREATE TABLE `responses` (
  `id` int NOT NULL,
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `task_id` int NOT NULL,
  `executor_id` int NOT NULL,
  `price` int NOT NULL,
  `descrpiption` text CHARACTER SET utf8 NOT NULL,
  `rejected` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `task_id` int NOT NULL,
  `author_id` int NOT NULL,
  `score` int NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int NOT NULL,
  `customer_id` int NOT NULL,
  `tilte` varchar(256) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `location` point NOT NULL,
  `end_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int NOT NULL,
  `category_id` int NOT NULL,
  `executor_id` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `task_files`
--

CREATE TABLE `task_files` (
  `id` int NOT NULL,
  `task_id` int NOT NULL,
  `file_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` text COLLATE utf8_unicode_ci NOT NULL,
  `telegram` text COLLATE utf8_unicode_ci,
  `city_id` int NOT NULL,
  `information` text COLLATE utf8_unicode_ci,
  `birthday` date NOT NULL,
  `avatar_file_id` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `is_executor` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `categories` ADD FULLTEXT KEY `name` (`name`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `cities` ADD FULLTEXT KEY `name` (`name`);

--
-- Индексы таблицы `executor_categories`
--
ALTER TABLE `executor_categories`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `executor_categories`
  ADD KEY `executor_id` (`executor_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_date` (`add_date`),
  ADD KEY `path` (`path`);

--
-- Индексы таблицы `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_date` (`add_date`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `executor_id` (`executor_id`),
  ADD KEY `price` (`price`),
  ADD KEY `descrpiption` (`descrpiption`(256)),
  ADD KEY `rejected` (`rejected`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_date` (`add_date`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `score` (`score`),
  ADD KEY `user_id` (`user_id`);
ALTER TABLE `reviews` ADD FULLTEXT KEY `text` (`text`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_date` (`add_date`),
  ADD KEY `status` (`status`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `tilte` (`tilte`),
  ADD SPATIAL KEY `location` (`location`),
  ADD KEY `end_date` (`end_date`),
  ADD KEY `price` (`price`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `executor_id` (`executor_id`);
ALTER TABLE `tasks` ADD FULLTEXT KEY `description` (`description`);

--
-- Индексы таблицы `task_files`
--
ALTER TABLE `task_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_date` (`registration_date`),
  ADD KEY `password_hash` (`password_hash`),
  ADD KEY `email` (`email`(256)),
  ADD KEY `phone` (`phone`(256)),
  ADD KEY `telegram` (`telegram`(256)),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `birthday` (`birthday`),
  ADD KEY `avatar_file_id` (`avatar_file_id`),
  ADD KEY `is_executor` (`is_executor`);
ALTER TABLE `users` ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `users` ADD FULLTEXT KEY `information` (`information`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
