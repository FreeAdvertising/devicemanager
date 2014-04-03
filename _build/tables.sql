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
  `password` VARCHAR(88) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `domain` VARCHAR(45) NULL,
  `host` VARCHAR(45) NULL,
  `desc` VARCHAR(45) NULL,
  PRIMARY KEY (`record_id`));

CREATE TABLE `freepass`.`users` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
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
  `name` VARCHAR(45) NULL,
  `meta_ram` INT NOT NULL,
  `meta_hdd` INT NOT NULL,
  `meta_type` INT NOT NULL,
  `date_checkout` DATE NOT NULL,
  `date_checkin` DATE NOT NULL,
  `last_checkedout_by` INT NOT NULL,
  `status` INT NOT NULL, #ENUM
  `location` INT NOT NULL, #ENUM
  PRIMARY KEY (`device_id`));

CREATE TABLE `freepass`.`device_manager_tracked_applications` (
  `app_id` INT NOT NULL AUTO_INCREMENT,
  #`device_id` INT NOT NULL, # DROP THIS
  `name` VARCHAR(255) NOT NULL,
  `description` BLOB NOT NULL,
  #`version` VARCHAR(10) NOT NULL, # DROP THIS
  PRIMARY KEY (`app_id`),
  INDEX devid_idx (device_id),
  FOREIGN KEY (device_id)
    REFERENCES `freepass`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE `freepass`.`device_manager_tracked_applications_rel` (
  `tapp_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `app_id` INT NOT NULL,
  `version` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`tapp_id`),
  INDEX devid_idx (device_id),
  INDEX appid_idx (app_id),
  FOREIGN KEY (device_id)
    REFERENCES `freepass`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (app_id)
    REFERENCES `freepass`.`device_manager_tracked_applications`(app_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE `freepass`.`device_manager_maintenance_tasks` (
  `task_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `assignee` INT NOT NULL,
  `created_by` INT NOT NULL,
  `description` BLOB NOT NULL,
  `status` INT NOT NULL, #ENUM
  PRIMARY KEY (`task_id`),
  INDEX devid_idx (device_id),
  FOREIGN KEY (device_id)
    REFERENCES `freepass`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE `freepass`.`device_manager_maintenance_task_categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` BLOB NOT NULL,
  PRIMARY KEY (`category_id`));

CREATE TABLE `freepass`.`device_manager_maintenance_task_categories_rel` (
  `rel_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `task_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`rel_id`),
  INDEX devid_idx (device_id),
  INDEX tasid_idx (task_id),
  INDEX catid_idx (category_id),
  # device id foreign key
  FOREIGN KEY (device_id)
    REFERENCES `freepass`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  # task id foreign key
  FOREIGN KEY (task_id)
    REFERENCES `freepass`.`device_manager_maintenance_tasks`(task_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  # category id foreign key
  FOREIGN KEY (category_id)
    REFERENCES `freepass`.`device_manager_maintenance_task_categories`(category_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE `freepass`.`device_manager_reservations_rel` (
  `res_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `userid` INT NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`res_id`),
  INDEX devid_idx (device_id),
  INDEX usrid_idx (userid),
  FOREIGN KEY (device_id)
    REFERENCES `freepass`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (userid)
    REFERENCES `freepass`.`users`(userid)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE `freepass`.`device_manager_assignments_rel` (
  `ass_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `userid` INT NOT NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`ass_id`),
  INDEX devid_idx (device_id),
  INDEX usrid_idx (userid),
  FOREIGN KEY (device_id)
    REFERENCES `freepass`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (userid)
    REFERENCES `freepass`.`users`(userid)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE `freepass`.`device_manager_history` (
  `hist_id` INT NOT NULL AUTO_INCREMENT,
  `rel_id` INT NOT NULL, # i.e. res_id, ass_id, maint_id - to get details about the item
  `type` VARCHAR(25) NOT NULL, # i.e. assignment, reservation, maintenance
  PRIMARY KEY (`hist_id`),
  INDEX type_idx (type)
  );

##
# Modify existing Product tables
# (these changes are already added to the table schemas, should only be run on
# existing data)
# 

#INSERT INTO `freepass`.`usergroups` (`name`, `desc`) VALUES ('registered', 'Registered users');
#INSERT INTO `freepass`.`usergroups` (`name`, `desc`) VALUES ('administrator', 'Can perform administration actions');
#UPDATE `freepass`.`users` SET `group_id`='2' WHERE `userid`='1';

# NOT COMMITTED LIVE YET
#ALTER TABLE `freepass`.`device_manager_tracked_applications` DROP FOREIGN KEY `device_manager_tracked_applications_ibfk_1` ;
#ALTER TABLE `freepass`.`device_manager_tracked_applications` DROP COLUMN `version` , DROP COLUMN `device_id` , DROP INDEX `devid_idx` ;
# ALTER TABLE `freepass`.`device_manager_tracked_applications_rel` ADD COLUMN version VARCHAR(10) NOT NULL

#ALTER TABLE `freepass`.`device_manager_history` DROP COLUMN `type`, ADD COLUMN `type` VARCHAR(25) NOT NULL