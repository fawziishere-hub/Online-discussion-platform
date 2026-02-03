
CREATE TABLE `debate_rounds` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `post_id` INT(11) NOT NULL,
  `round_number` INT(11) NOT NULL,
  `time_limit` INT(11) NOT NULL DEFAULT 600, -- Default 10 minutes
  `content` TEXT NOT NULL,
  `user_id` INT(11) NOT NULL,
  `date_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `post_list`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
