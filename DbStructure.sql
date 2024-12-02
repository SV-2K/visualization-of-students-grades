CREATE TABLE `students` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `group_id` int NOT NULL,
  `name` varchar(64) UNIQUE NOT NULL,
  UNIQUE KEY unique_group_name (group_id, name);
);

CREATE TABLE `grades` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `monitoring_id` int NOT NULL,
  `student_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `grade` char NOT NULL,
  UNIQUE KEY unique_grade (monitoring_id, student_id, subject_id);
);

CREATE TABLE `subjects` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(128) UNIQUE NOT NULL
);

CREATE TABLE `attendance` (
  `monitoring_id` int NOT NULL,
  `student_id` int NOT NULL,
  `invalid_absence_hours` int NOT NULL,
  `valid_absence_hours` int NOT NULL,
  UNIQUE KEY unique_absences (monitoring_id, student_id, invalid_absence_hours, valid_absence_hours);
);

CREATE TABLE `groups` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(32) UNIQUE NOT NULL
);

CREATE TABLE `monitoring` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `start_date` varchar(32) NOT NULL,
  `end_date` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL
);

ALTER TABLE `grades` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

ALTER TABLE `students` ADD FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

ALTER TABLE `grades` ADD FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

ALTER TABLE `grades` ADD FOREIGN KEY (`monitoring_id`) REFERENCES `monitoring` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`monitoring_id`) REFERENCES `monitoring` (`id`);
