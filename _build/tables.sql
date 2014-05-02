##
# device_manager tables
# 

CREATE DATABASE IF NOT EXISTS `device_manager` ;

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_devices` (
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

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_tracked_applications` (
  `app_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` BLOB NOT NULL,
  PRIMARY KEY (`app_id`),
  INDEX devid_idx (device_id),
  FOREIGN KEY (device_id)
    REFERENCES `device_manager`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_tracked_applications_rel` (
  `tapp_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `app_id` INT NOT NULL,
  `version` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`tapp_id`),
  INDEX devid_idx (device_id),
  INDEX appid_idx (app_id),
  FOREIGN KEY (device_id)
    REFERENCES `device_manager`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (app_id)
    REFERENCES `device_manager`.`device_manager_tracked_applications`(app_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_maintenance_tasks` (
  `task_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `assignee` INT NOT NULL,
  `created_by` INT NOT NULL,
  `description` BLOB NOT NULL,
  `status` INT NOT NULL, #ENUM
  `date` DATE NOT NULL,
  PRIMARY KEY (`task_id`),
  INDEX devid_idx (device_id),
  FOREIGN KEY (device_id)
    REFERENCES `device_manager`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_maintenance_task_categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` BLOB NOT NULL,
  PRIMARY KEY (`category_id`));

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_maintenance_task_categories_rel` (
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
    REFERENCES `device_manager`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  # task id foreign key
  FOREIGN KEY (task_id)
    REFERENCES `device_manager`.`device_manager_maintenance_tasks`(task_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  # category id foreign key
  FOREIGN KEY (category_id)
    REFERENCES `device_manager`.`device_manager_maintenance_task_categories`(category_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_reservations_rel` (
  `res_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `userid` INT NOT NULL,
  `date` DATE NOT NULL,
  `checked_in` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`res_id`),
  INDEX devid_idx (device_id),
  INDEX usrid_idx (userid),
  FOREIGN KEY (device_id)
    REFERENCES `device_manager`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (userid)
    REFERENCES `device_manager`.`users`(userid)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_assignments_rel` (
  `ass_id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `userid` INT NOT NULL,
  `date` DATE NOT NULL,
  `checked_in` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`ass_id`),
  INDEX devid_idx (device_id),
  INDEX usrid_idx (userid),
  FOREIGN KEY (device_id)
    REFERENCES `device_manager`.`device_manager_devices`(device_id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (userid)
    REFERENCES `device_manager`.`users`(userid)
    ON UPDATE CASCADE
    ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`device_manager_history` (
  `hist_id` INT NOT NULL AUTO_INCREMENT,
  `rel_id` INT NOT NULL, # i.e. res_id, ass_id, maint_id - to get details about the item
  `type` VARCHAR(25) NOT NULL, # i.e. assignment, reservation, maintenance
  PRIMARY KEY (`hist_id`),
  INDEX type_idx (type)
  );

CREATE TABLE IF NOT EXISTS `device_manager`.`users` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `secret_question_answer` VARCHAR(255) NOT NULL,
  `is_reset` INT NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC));

CREATE TABLE IF NOT EXISTS `device_manager`.`users_quarantine` (
  `userid` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `secret_question_answer` VARCHAR(255) NOT NULL,
  `is_reset` INT NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC));

CREATE TABLE IF NOT EXISTS `device_manager`.`usergroups` (
  `group_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `desc` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`group_id`));

##
# Modify existing Product tables
# (these changes are already added to the table schemas, should only be run on
# existing data)
# 
