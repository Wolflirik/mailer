-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 20 2017 г., 16:29
-- Версия сервера: 5.6.37
-- Версия PHP: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mailer_new`
--

-- --------------------------------------------------------

--
-- Структура таблицы `delivery`
--

CREATE TABLE `delivery` (
  `id_ai` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `unique_name` varchar(256) NOT NULL,
  `text` text NOT NULL,
  `text_courier` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `delivery`
--

INSERT INTO `delivery` (`id_ai`, `id`, `name`, `unique_name`, `text`, `text_courier`, `time`) VALUES
(1, 0, 'default', 'default', '<!doctype html>\n<html>\n  <head>\n    <meta name=\"viewport\" content=\"width=device-width\">\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n    <title>Заказ отправлен</title>\n    <style>\n@media only screen and (max-width: 620px) {\n  table[class=body] h1 {\n    font-size: 28px !important;\n    margin-bottom: 10px !important;\n  }\n\n  table[class=body] p,\ntable[class=body] ul,\ntable[class=body] ol,\ntable[class=body] td,\ntable[class=body] span,\ntable[class=body] a {\n    font-size: 16px !important;\n  }\n\n  table[class=body] .wrapper,\ntable[class=body] .article {\n    padding: 10px !important;\n  }\n\n  table[class=body] .content {\n    padding: 0 !important;\n  }\n\n  table[class=body] .container {\n    padding: 0 !important;\n    width: 100% !important;\n  }\n\n  table[class=body] .main {\n    border-left-width: 0 !important;\n    border-radius: 0 !important;\n    border-right-width: 0 !important;\n  }\n\n  table[class=body] .btn table {\n    width: 100% !important;\n  }\n\n  table[class=body] .btn a {\n    width: 100% !important;\n  }\n\n  table[class=body] .img-responsive {\n    height: auto !important;\n    max-width: 100% !important;\n    width: auto !important;\n  }\n.im{color:#000 !important;}\n}\n</style>\n  </head>\n  <body class=\"\" style=\"background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 15px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">\n    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;\" width=\"100%\" bgcolor=\"#f6f6f6\">\n      <tr>\n        <td style=\"font-family: sans-serif; font-size: 15px; vertical-align: top;\" valign=\"top\"> </td>\n        <td class=\"container\" style=\"font-family: sans-serif; font-size: 15px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; Margin: 0 auto;\" width=\"580\" valign=\"top\">\n          <div class=\"content\" style=\"box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;\">\n            <table class=\"main\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;\" width=\"100%\">\n              <tr>\n                <td class=\"wrapper\" style=\"font-family: sans-serif; font-size: 15px; vertical-align: top; box-sizing: border-box; padding: 20px; padding-bottom: 0;\" valign=\"top\">\n                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\" width=\"100%\">\n                    <tr>\n                      <td style=\"font-family: sans-serif; font-size: 15px; vertical-align: top;\" valign=\"top\">\n                        <a href=\"https://for.care/\" class=\"button\" style=\"color: #3498db; text-decoration: underline;\">\n                          <img width=\"162\" border=\"0\" height=\"43\" alt=\"\" style=\"-ms-interpolation-mode: bicubic; max-width: 100%; display: block; border: none; outline: none; text-decoration: none;\" src=\"https://for.care/image/data/logo.jpg\">\n                        </a>\n                      </td>\n                    </tr>\n                    <tr>\n                      <td style=\"font-family: sans-serif; font-size: 15px; vertical-align: top;\" valign=\"top\">\n                        <br><br>', '</td>\r\n                    </tr>\r\n                  </table>\r\n                </td>\r\n              </tr>\r\n            </table>\r\n          </div>\r\n        </td>\r\n        <td style=\"font-family: sans-serif; font-size: 15px; vertical-align: top;\" valign=\"top\"> </td>\r\n      </tr>\r\n    </table>\r\n  </body>\r\n</html>', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `email` varchar(256) CHARACTER SET utf8 NOT NULL,
  `status` varchar(256) CHARACTER SET utf8 NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `full_name` varchar(256) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text_map` text CHARACTER SET utf8 NOT NULL,
  `track` varchar(256) CHARACTER SET utf8 NOT NULL,
  `email_status` int(1) NOT NULL,
  `date_created` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_phone` varchar(20) CHARACTER SET utf8 NOT NULL,
  `address_string` text CHARACTER SET utf8 NOT NULL,
  `delivery_method` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(256) CHARACTER SET utf8 NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email_server` varchar(200) CHARACTER SET utf8 NOT NULL,
  `email_login` varchar(256) CHARACTER SET utf8 NOT NULL,
  `email_password` varchar(200) CHARACTER SET utf8 NOT NULL,
  `email_port` int(11) NOT NULL,
  `count_mails` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id_ai`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id_ai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
