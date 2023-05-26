DROP
DATABASE IF EXISTS task_force;

CREATE
DATABASE task_force
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE
task_force;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task_force`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
                              `category_id` int NOT NULL,
                              `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                              `icon` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
                          `city_id` int NOT NULL,
                          `name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                          `latitude` float DEFAULT NULL,
                          `longitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `executor_categories`
--

CREATE TABLE `executor_categories` (
                                       `executor_category_id` int NOT NULL,
                                       `executor_id` int NOT NULL,
                                       `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
                         `file_id` int NOT NULL,
                         `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `path` varchar(256) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `responses`
--

CREATE TABLE `responses` (
                             `response_id` int NOT NULL,
                             `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                             `task_id` int NOT NULL,
                             `executor_id` int NOT NULL,
                             `price` int NOT NULL,
                             `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                             `rejected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
                           `review_id` int NOT NULL,
                           `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                           `task_id` int NOT NULL,
                           `author_id` int NOT NULL,
                           `score` int NOT NULL,
                           `text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                           `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
                         `task_id` int NOT NULL,
                         `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `status` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `customer_id` int NOT NULL,
                         `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `latitude` float DEFAULT NULL,
                         `longitude` float DEFAULT NULL,
                         `end_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `price` int DEFAULT NULL,
                         `category_id` int NOT NULL,
                         `executor_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `task_files`
--

CREATE TABLE `task_files` (
                              `task_file_id` int NOT NULL,
                              `task_id` int NOT NULL,
                              `file_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
                         `user_id` int NOT NULL,
                         `add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `first_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `last_name` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `phone` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
                         `telegram` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
                         `city_id` int DEFAULT NULL,
                         `information` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
                         `birthday` date DEFAULT NULL,
                         `avatar_file_id` int DEFAULT NULL,
                         `is_executor` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
    ADD PRIMARY KEY (`category_id`),
    ADD KEY `name` (`name`),
    ADD KEY `icon` (`icon`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
    ADD PRIMARY KEY (`city_id`),
    ADD KEY `name` (`name`),
    ADD KEY `longitude` (`longitude`),
    ADD KEY `latitude` (`latitude`);

--
-- Индексы таблицы `executor_categories`
--
ALTER TABLE `executor_categories`
    ADD PRIMARY KEY (`executor_category_id`),
    ADD KEY `executor_id` (`executor_id`),
    ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
    ADD PRIMARY KEY (`file_id`),
    ADD KEY `path` (`path`);

--
-- Индексы таблицы `responses`
--
ALTER TABLE `responses`
    ADD PRIMARY KEY (`response_id`),
    ADD KEY `responses_tasks__fk` (`task_id`),
    ADD KEY `responses_users__fk` (`executor_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
    ADD PRIMARY KEY (`review_id`),
    ADD KEY `reviews_users__fk` (`user_id`),
    ADD KEY `reviews_tasks__fk` (`task_id`),
    ADD KEY `reviews_users__fk_2` (`author_id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
    ADD PRIMARY KEY (`task_id`),
    ADD KEY `add_date` (`add_date`),
    ADD KEY `status` (`status`),
    ADD KEY `tilte` (`title`),
    ADD KEY `end_date` (`end_date`),
    ADD KEY `price` (`price`),
    ADD KEY `customer_id` (`customer_id`),
    ADD KEY `executor_id` (`executor_id`),
    ADD KEY `category_id` (`category_id`),
    ADD KEY `longitude` (`longitude`),
    ADD KEY `latitude` (`latitude`);
ALTER TABLE `tasks` ADD FULLTEXT KEY `description` (`description`);

--
-- Индексы таблицы `task_files`
--
ALTER TABLE `task_files`
    ADD PRIMARY KEY (`task_file_id`),
    ADD KEY `task_id` (`task_id`),
    ADD KEY `task_files_files__fk` (`file_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`) USING BTREE,
    ADD KEY `add_date` (`add_date`),
    ADD KEY `password_hash` (`password_hash`),
    ADD KEY `email` (`email`),
    ADD KEY `phone` (`phone`),
    ADD KEY `telegram` (`telegram`),
    ADD KEY `city_id` (`city_id`),
    ADD KEY `is_executor` (`is_executor`),
    ADD KEY `name` (`first_name`),
    ADD KEY `avatar_file_id` (`avatar_file_id`),
    ADD KEY `last_name` (`last_name`);
ALTER TABLE `users` ADD FULLTEXT KEY `information` (`information`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
    MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
    MODIFY `city_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `executor_categories`
--
ALTER TABLE `executor_categories`
    MODIFY `executor_category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
    MODIFY `file_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `responses`
--
ALTER TABLE `responses`
    MODIFY `response_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
    MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
    MODIFY `task_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `task_files`
--
ALTER TABLE `task_files`
    MODIFY `task_file_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cities`
--
ALTER TABLE `cities`
    ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `users` (`city_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `executor_categories`
--
ALTER TABLE `executor_categories`
    ADD CONSTRAINT `executor_categories_categories__fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
    ADD CONSTRAINT `executor_categories_users__fk` FOREIGN KEY (`executor_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `files`
--
ALTER TABLE `files`
    ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `users` (`avatar_file_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `responses`
--
ALTER TABLE `responses`
    ADD CONSTRAINT `responses_tasks__fk` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`),
    ADD CONSTRAINT `responses_users__fk` FOREIGN KEY (`executor_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
    ADD CONSTRAINT `reviews_tasks__fk` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`),
    ADD CONSTRAINT `reviews_users__fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
    ADD CONSTRAINT `reviews_users__fk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
    ADD CONSTRAINT `tasks_categories__fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
    ADD CONSTRAINT `tasks_users__fk` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`),
    ADD CONSTRAINT `tasks_users__fk_2` FOREIGN KEY (`executor_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `task_files`
--
ALTER TABLE `task_files`
    ADD CONSTRAINT `task_files_files__fk` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`),
    ADD CONSTRAINT `task_files_tasks__fk` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`);
COMMIT;