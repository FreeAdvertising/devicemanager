##
# Create Product tables
#
# freepass tables
CREATE DATABASE `freepass` ;

CREATE TABLE `freepass`.`clients` (
  `client_id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NULL,
  `name` VARCHAR(45) NOT NULL,
  `desc` VARCHAR(45) NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE INDEX `client_id_UNIQUE` (`client_id` ASC));

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

##
# device_manager tables
# 
CREATE TABLE `freepass`.`device_manager_devices` (
  `device_id` INT NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(8) NOT NULL,
  `os` INT NOT NULL, #ENUM
  `meta_ram` INT NOT NULL,
  `meta_hdd` INT NOT NULL,
  #`meta_tracked_apps_id` INT NOT NULL, #foreign key: _tracked_applications
  #`meta_maintenance_id` INT NOT NULL, #foreign key: _maintenance_tasks
  `date_checkout` DATE NOT NULL,
  `date_checkin` DATE NOT NULL,
  `last_checkedout_by` INT NOT NULL,
  `status` INT NOT NULL, #ENUM
  `location` INT NOT NULL, #ENUM
  PRIMARY KEY (`device_id`));

CREATE TABLE `freepass`.`device_manager_tracked_applications` (
  `app_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL, #foreign key
  `name` INT NOT NULL,
  `description` INT NOT NULL,
  `` INT NOT NULL,
  PRIMARY KEY (`app_id`));

CREATE TABLE `freepass`.`device_manager_tracked_applications_rel` (
  `rel_id` INT NOT NULL AUTO_INCREMENT,
  #NOT SURE WHAT SHOULD BE IN HERE YET...
  PRIMARY KEY (`rel+id`));

CREATE TABLE `freepass`.`device_manager_maintenance_tasks` (
  `task_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL, #foreign key: _devices.device_id
  `assignee` INT NOT NULL,
  `created_by` INT NOT NULL,
  `description` BLOB NOT NULL,
  `category` INT NOT NULL, #foreign key: _maintenance_task_categories.category_id
  `status` INT NOT NULL, #ENUM
  PRIMARY KEY (`app_id`));

CREATE TABLE `freepass`.`device_manager_maintenance_task_categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `name` INT NOT NULL,
  `description` INT NOT NULL,
  PRIMARY KEY (`category_id`));

##
# Modify existing Product tables
# (these changes are already added to the table schemas, should only be run on
# existing data)
# 

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
#ALTER TABLE `freepass`.`records` CHANGE COLUMN `password` `password` VARCHAR(88) NOT NULL ;
