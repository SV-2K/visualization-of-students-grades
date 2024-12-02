CREATE TABLE `students` (
  `id` integer PRIMARY KEY,
  `group_id` int,
  `name` varchar(128)
);

CREATE TABLE `grades` (
  `id` integer PRIMARY KEY,
  `student_id` int,
  `subject_id` int,
  `grade` int
);

CREATE TABLE `subjects` (
  `id` integer PRIMARY KEY,
  `name` varchar(128)
);

CREATE TABLE `attendance` (
  `id` integer PRIMARY KEY,
  `student_id` int,
  `attended_hours` int,
  `missed_hours` int
);

CREATE TABLE `groups` (
  `id` int,
  `name` varchar(32)
);

ALTER TABLE `grades` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

ALTER TABLE `students` ADD FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

ALTER TABLE `grades` ADD FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
