CREATE TABLE IF NOT EXISTS `pageVisits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_agent_string` varchar(10000) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
