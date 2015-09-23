CREATE DATABASE amazon;

CREATE TABLE `item` (
  `title` text NOT NULL,
  `detail` text,
  `medium_image_url` text,
  `large_image_url` text,
  `asin` text NOT NULL,
  `tag` text,
  `detail_url` text,
  `create_time` datetime DEFAULT NULL,
  `show_flag` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`asin`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `other` (
  `title` text NOT NULL,
  `detail` text,
  `medium_image_url` text,
  `large_image_url` text,
  `asin` int(11) NOT NULL AUTO_INCREMENT,
  `tag` text,
  `detail_url` text,
  `create_time` datetime DEFAULT NULL,
  `show_flag` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`asin`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
