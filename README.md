# Font Management

Font Management using PHP

- git clone the repository

  Project setup
- Rename your project directory to "FontManagemennt"

  Create Database:

- create database name ex: "font_mgt"
- create table using given below sql statement

CREATE TABLE IF NOT EXISTS `fonts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `font_name` varchar(100) NOT NULL,
  `font_file` varchar(200) NOT NULL,
  `is_active` int(3) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `font_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `group_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `font_name` varchar(100) NOT NULL,
  `font` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

### Run the Project

Run the localhost (Apache service)

http://localhost/FontManagemennt
