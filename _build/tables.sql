# create freepass db
CREATE DATABASE `freepass` ;

# create clients table
CREATE TABLE `freepass`.`clients` (
  `client_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NULL,
  `name` VARCHAR(45) NOT NULL,
  `desc` VARCHAR(45) NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE INDEX `client_id_UNIQUE` (`client_id` ASC));

# create records table
CREATE TABLE `freepass`.`records` (
  `record_id` INT NOT NULL AUTO_INCREMENT,
  `client_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `domain` VARCHAR(45) NULL,
  `host` VARCHAR(45) NULL,
  `desc` VARCHAR(45) NULL,
  PRIMARY KEY (`record_id`));

# create users table
CREATE TABLE `freepass`.`users` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `secret_question_answer` VARCHAR(255) NOT NULL,
  `is_reset` INT NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC));

CREATE TABLE `freepass`.`usergroups` (
  `group_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `desc` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`group_id`));

CREATE TABLE `freepass`.`categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `colour` VARCHAR(45) NOT NULL,
  `desc` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`category_id`));

CREATE TABLE `freepass`.`rel_categories` (
  `rel_id` INT NOT NULL AUTO_INCREMENT,
  `record_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`rel_id`));

CREATE TABLE `freepass`.`rel_starred_categories` (
  `rel_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`rel_id`));



# insert default users
#INSERT INTO `freepass`.`users`(`username`, `password`) VALUES("marynika", )

#ALTER TABLE `freepass`.`records` ADD COLUMN `user_id` INT NOT NULL AFTER `client_id`;
#ALTER TABLE `freepass`.`records` ADD COLUMN `desc` VARCHAR(45) NOT NULL AFTER `host`;

#ALTER TABLE `freepass`.`users` ADD COLUMN `secret_question_answer` VARCHAR(255) NOT NULL AFTER `password`;
#ALTER TABLE `freepass`.`users` ADD COLUMN `is_reset` INT NOT NULL AFTER `secret_question_answer`;
#ALTER TABLE `freepass`.`users` ADD COLUMN `group_id` INT NOT NULL AFTER `userid`;

#INSERT INTO `freepass`.`usergroups` (`name`, `desc`) VALUES ('registered', 'Registered users');
#INSERT INTO `freepass`.`usergroups` (`name`, `desc`) VALUES ('administrator', 'Can perform administration actions');
#UPDATE `freepass`.`users` SET `group_id`='2' WHERE `userid`='1';
#ALTER TABLE `freepass`.`categories` ADD COLUMN `colour` VARCHAR(45) NOT NULL AFTER `name`;

# ????? NOT COMMITTED LIVE YET:
#ALTER TABLE `freepass`.`records` CHANGE COLUMN `password` `password` VARCHAR(88) NOT NULL ;
