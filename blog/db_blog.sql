DROP DATABASE IF EXISTS db_blog;
CREATE DATABASE db_blog;
USE db_blog;


-- Categories Table
CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  PRIMARY KEY (`cat_id`)
);

-- Posts Table
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_title` varchar(255) NOT NULL,
  `post_des` text NOT NULL,
  `post_image` text NOT NULL,
  `post_date` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_cat_id` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'Publish',
  `post_comment` int(11) DEFAULT 0,
  PRIMARY KEY (`post_id`),
  FOREIGN KEY (`post_cat_id`) REFERENCES `categories`(`cat_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Comments Table
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_des` text NOT NULL,
  `comment_date` varchar(255) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_post_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_id`),
  FOREIGN KEY (`comment_post_id`) REFERENCES `posts`(`post_id`) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Users Table
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
);


-- Categories Data
INSERT INTO categories (cat_title) VALUES 
('mysqli'),
('pdo'),
('php'),
('laravel'),
('javascript'),
('react'),
('nodejs'),
('jquery'),
('security');

-- Posts Data 
INSERT INTO posts (post_title, post_des, post_image, post_date, post_author, post_cat_id, post_status, post_comment	) VALUES 
('MySQLi', 'MySQLi is a driver for MySQL databases that provides an easy way to interact with MySQL using PHP. It is both procedural and object-oriented, making it versatile.', 'mysqli.jpg', '2023-08-17', 'John Doe', 1, 'Publish', 2),
('PDO', 'PDO (PHP Data Objects) is a consistent interface for accessing databases in PHP. It abstracts database access and allows for switching databases easily.', 'pdo.jpg', '2023-08-17', 'John Doe', 2, 'Publish', 2),
('PHP', 'PHP is a widely-used open-source scripting language. It is especially suited for web development and can be embedded into HTML.', 'php.png', '2023-08-17', 'John Doe', 3, 'Publish',2),
('Laravel', 'Laravel is a web application framework with expressive, elegant syntax. It believes that web development should be an enjoyable, creative experience.', 'laravel.jpg', '2023-08-17', 'John Doe', 4, 'Publish', 0),
('Javascript', 'JavaScript is a lightweight, interpreted programming language with first-class functions. While it is most well-known as the scripting language for web pages, it is also used in non-browser environments.', 'js.png', '2023-08-17', 'John Doe', 5, 'Publish',0),
('React', 'React is a JavaScript library for building user interfaces. It is maintained by Facebook and a community of individual developers and companies.', 'reactjs.png', '2023-08-17', 'John Doe', 6, 'Publish',0),
('Getting Started with Node.js', 'Node.js is an open-source, cross-platform JavaScript runtime environment. It executes JavaScript code outside of a web browser. With Node.js, you can build scalable and efficient server-side applications.', 'nodejs.png', '2023-08-17', 'John Doe', 7, 'Publish',0),
('Introduction to jQuery', 'jQuery is a JavaScript library designed to simplify HTML DOM tree traversal and manipulation, as well as event handling, and animation. It is free, open-source software using the permissive MIT License.', 'jquery.png', '2023-08-17', 'John Doe', 8, 'Publish',0),
('Basics of Web Security', 'Web security is a branch of information security that deals specifically with the security of websites, web applications, and web services. It encompasses multiple layers of protection, policies, and technologies.', 'security.png', '2023-08-17', 'John Doe', 9, 'Publish',0);

-- Comments Data 
-- For demonstration purposes, I'm adding comments to the first three posts.
INSERT INTO comments (comment_des, comment_date, comment_author, comment_post_id) VALUES 
('I found MySQLi really helpful for my projects.', '2023-08-17', 'Alice Smith', 1),
('I use MySQLi with PHP all the time.', '2023-08-18', 'Bob Johnson', 1),
('PDO is great because of its flexibility with various databases.', '2023-08-17', 'Charlie Brown', 2),
('I prefer PDO over MySQLi due to its prepared statements.', '2023-08-18', 'David White', 2),
('I have been using PHP for years and love it.', '2023-08-17', 'Ella Harris', 3),
('PHP is indeed a versatile scripting language.', '2023-08-18', 'Frank Martin', 3);


-- Insertion dans la table `users`
INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES 
('ouss', 'ouss@gmail.com', '$2y$10$sIcGBcsGyGCKZH.WS2euSu5ZT.JQJu3WnQfBF1TI8wJkJePE4Km3i')

-- user_password = ouss@123

