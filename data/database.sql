CREATE DATABASE IF NOT EXISTS `library`
  CHARACTER SET utf8;

USE `library`;

DROP TABLE IF EXISTS `author_book`;
DROP TABLE IF EXISTS `author`;
DROP TABLE IF EXISTS `book_instance`;
DROP TABLE IF EXISTS `book_run`;
DROP TABLE IF EXISTS `publisher`;
DROP TABLE IF EXISTS `edition`;
DROP TABLE IF EXISTS `book`;

DROP TABLE IF EXISTS `user`;

CREATE TABLE `book`
(
  `id`          VARCHAR(255) NOT NULL,
  `name`        VARCHAR(255),
  `description` TEXT,
  `modified`    TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted`     DATETIME     NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Общая информация о книге';

CREATE TABLE `edition`
(
  `id`          VARCHAR(255) NOT NULL,
  `book_id`     VARCHAR(255) NOT NULL,
  `type`        VARCHAR(255)      DEFAULT NULL
  COMMENT 'Тип (номер) издания',
  `description` VARCHAR(255) COMMENT 'Описание издания',
  `modified`    TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted`     DATETIME     NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`book_id`) REFERENCES `book` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Издания книги';

CREATE TABLE `publisher`
(
  `id`       VARCHAR(255) NOT NULL,
  `name`     VARCHAR(255),
  `modified` TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted`  DATETIME     NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Издательства';

CREATE TABLE `book_run`
(
  `id`           VARCHAR(255) NOT NULL,
  `edition_id`   VARCHAR(255) NOT NULL,
  `publisher_id` VARCHAR(255) NOT NULL,
  `image`        MEDIUMBLOB   NULL
  COMMENT 'Изображение обложки',
  `image_thumb`  MEDIUMBLOB   NULL
  COMMENT 'Миниатюра изображения обложки',
  `modified`     TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted`      DATETIME     NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`edition_id`) REFERENCES `edition` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Тираж книги';

CREATE TABLE `book_instance`
(
  `id`          VARCHAR(20) NOT NULL
  COMMENT 'Библиотечный идентификатор',
  `book_run_id` VARCHAR(255),
  `modified`    TIMESTAMP   NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted`     DATETIME    NULL DEFAULT NULL
  COMMENT 'Когда удалено',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`book_run_id`) REFERENCES `book_run` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Конкретная книга в библиотеке';

CREATE TABLE `author`
(
  `id`          VARCHAR(255) NOT NULL,
  `first_name`  VARCHAR(255) NULL,
  `last_name`   VARCHAR(255) NULL,
  `birthday`    DATE         NULL,
  `image`       MEDIUMBLOB   NULL
  COMMENT 'Изображение с автором (напр. фото)',
  `image_thumb` MEDIUMBLOB   NULL
  COMMENT 'Миниатюра изображения с автором',
  `modified`    TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted`     DATETIME     NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Список авторов';

CREATE TABLE `author_book`
(
  `author_id` VARCHAR(255) NOT NULL,
  `book_id`   VARCHAR(255) NOT NULL,
  PRIMARY KEY (`author_id`, book_id),
  FOREIGN KEY (`author_id`) REFERENCES `author` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `book` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Связь авторов и книг';

CREATE TABLE `user`
(
  `id`            VARCHAR(255) NOT NULL,
  `login`         VARCHAR(50)  NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created`       TIMESTAMP    NOT NULL                      DEFAULT CURRENT_TIMESTAMP,
  `modified`      TIMESTAMP    NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE (`login`),
  CHECK (`login` > '')
)
  ENGINE = InnoDB
  CHARSET = utf8
  COMMENT 'Пользователи (на данный момент все администраторы)';

INSERT INTO `user`
SET login = 'admin', password_hash = 'temp123';
