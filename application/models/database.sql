-- 2022-06-24

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_auth_code` varchar(150) NOT NULL,
  `user_status` enum('1','0') DEFAULT NULL,
  `password_auth_code` varchar(150) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `template_description` text DEFAULT NULL,
  `template_subject` varchar(255) DEFAULT NULL,
  `template_content` text DEFAULT NULL,
  `template_visibility` varchar(255) DEFAULT NULL,
  `template_status` enum('1','0') NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `email_template_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `category_description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `email_templates` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `email_templates` ADD FOREIGN KEY (`category_id`) REFERENCES `email_template_categories` (`id`) ON DELETE CASCADE;


CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salutation` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `primary_email` varchar(150) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `contact_email_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_content` text DEFAULT NULL,
  `email_status` varchar(50) DEFAULT NULl,
  `sent_to` int(11) DEFAULT NULL,
  `sent_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `contacts` ADD FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `contacts` ADD FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `contact_email_histories` ADD FOREIGN KEY (`sent_to`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;

ALTER TABLE `contact_email_histories` ADD FOREIGN KEY (`sent_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;