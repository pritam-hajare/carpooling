
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `menu_title` varchar(128) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `route_id` int(128) NOT NULL,
  `content` longtext NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT '0',
  `seo_title` text NOT NULL,
  `meta` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `new_window` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`,`content`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `route` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(120) DEFAULT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- new query

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_address` (
  `id` int(150) NOT NULL AUTO_INCREMENT,
  `trip_id` int(150) NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `weight` int(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

INSERT INTO `settings` (`id`, `code`, `setting_key`, `setting`) VALUES
(1, 'payment_modules', 'cod', '0'),
(2, 'cod', 'enabled', '0'),
(3, 'shipping_modules', 'flatrate', '0'),
(4, 'flatrate', 'rate', ''),
(5, 'flatrate', 'enabled', '0');

-- new query

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `admin_password` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `admin_name` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_mobile` varchar(255) DEFAULT NULL,
  `admin_img` varchar(255) DEFAULT NULL,
  `access` varchar(12) NOT NULL DEFAULT 'Admin',
  `admin_createddate` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_amenities` (
  `amenities_id` int(11) NOT NULL AUTO_INCREMENT,
  `amenities_name` varchar(40) DEFAULT NULL,
  `created_on` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`amenities_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `category_id` int(15) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(56) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` int(2) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_email_template` (
  `tplid` int(11) NOT NULL AUTO_INCREMENT,
  `tplshortname` varchar(250) NOT NULL,
  `tplsubject` varchar(250) NOT NULL,
  `tplmessage` text NOT NULL,
  `tplmailid` varchar(100) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tplid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

INSERT INTO `tbl_email_template` (`tplid`, `tplshortname`, `tplsubject`, `tplmessage`, `tplmailid`, `isactive`) VALUES
(3, 'Activate your Carpooling account', 'Activate your Carpooling account', '<p>Hello <strong>{NAME}</strong></p>\n\n<p>Thank you for registering with carpoolingscript.com</p>\n\n<p>Before we can complete your registration, we need to verify your e-mail address. Please click on the link below to complete your registration.</p>\n\n<p><a href="{SITE_PATH}user/access/{code}" target="_blank">{SITE_PATH}user/access/{code}</a></p>\n\n<p>If you have problems following the link, please copy and paste it into your browser to complete your registration.</p>\n\n<p>A request to create account was received from your Carpoolingscript Account - {EMAIL} from the IP - {IP}</p>\n\n<p>Enjoy!<br />\n<strong>The Carpooling Script Team</strong><br />\n<br />\n<br />\nIf you have not initiated this request, send mail to info@carpoolingscript.com<br />\nIf you have any query please send mail to info@carpoolingscript.com<br />\nThis is an automated email, please don&#39;t reply.</p>', NULL, 0),
(10, 'Thanks for Contact Us', 'Thanks for Contact Us', '<p>Dear Admin,<br />\r\n<br />\r\nName: {Name}<br />\r\nEmail: {email}<br />\r\nPhone: {phone}<br />\r\nMessage:<br />\r\n<br />\r\n{message}<br />\r\n<br />\r\nRegards,<br />\r\ncarpoolingscript.com Team</p>', NULL, 0),
(11, 'Feedback', 'Feedback', '<p>Dear Admin,<br />\r\n<br />\r\nName: {Name}<br />\r\nEmail: {email}<br />\r\nPhone: {phone}<br />\r\nFeedback:<br />\r\n<br />\r\n{message}<br />\r\n<br />\r\nPage: {page}<br />\r\nRating: {rating}<br />\r\nRegards,<br />\r\ncarpoolingscript.com Team</p>', NULL, 0),
(12, 'Activate your Carpooling account', 'Activate your Carpooling account', '<p>Hello <strong>{NAME}</strong></p>\n\n<p>Thank you for registering with Carpoolingscript.com</p>\n\n<p>Your Password is <strong>{PASSWORD}</strong></p>\n\n<p>A request to create account was received from your Carpooling Account - {EMAIL} from the IP - {IP}</p>\n\n<p>Enjoy!<br />\n<strong>The Carpooling Script Team</strong><br />\n<br />\n<br />\nIf you have not initiated this request, send mail to info@carpoolingscript.com<br />\nIf you have any query please send mail to info@carpoolingscript.com<br />\nThis is an automated email, please don&#39;t reply.</p>', NULL, 0),
(26, 'Carpoolingscript:Password changed', 'Carpoolingscript:Reset password-{EMAIL}', '<p>A request to reset password was received from your Carpooling Account - {EMAIL} from the IP - {IP}</p>\n\n<p>Your password has been reset to <strong> {PASSWORD} </strong></p>\n\n<p>Enjoy!<br />\n<strong>The Carpooling Script Team</strong><br />\n<br />\n<br />\nIf you have not initiated this request, send mail to care@carpoolingscript.com<br />\nIf you have any query please send mail to care@carpoolingscript.com<br />\nThis is an automated email, please don&#39;t reply.</p>', NULL, 0),
(2, 'Thank you for subscribe', 'Thank you for subscribe', '<p> Thank you for subscribe </p>', NULL, 0),
(28, 'Carpoolingscript:Trip enquiry', 'Carpoolingscript:Trip enquiry', '<p>Hello <strong>{NAME}</strong></p>\r\n\r\n<p>Passanger_name: <strong>{NAME}</strong></p>\r\n\r\n<p>Traveller_name: <strong>{PNAME}</strong></p>\r\n\r\n<p>Traveller_email: <strong>{PEMAIL}</strong></p>\r\n\r\n<p>Traveller_mobile: <strong>{PMOBILE}</strong></p>\r\n\r\n<p>Enjoy!<br />\r\n<strong>The Carpoolingscript Team</strong><br />\r\n<br />\r\n&nbsp;</p>', NULL, 0),
(27, 'Carpoolingscript:Trip enquiry', 'Carpoolingscript:Trip enquiry', '<p>Hello <strong>{NAME}</strong></p>\r\n\r\n<p>Traveller_name: <strong>{NAME}</strong></p>\r\n\r\n<p>Passanger_name: <strong>{PNAME}</strong></p>\r\n\r\n<p>Passanger_email: <strong>{PEMAIL}</strong></p>\r\n\r\n<p>Passanger_mobile: <strong>{PMOBILE}</strong></p>\r\n\r\n<p>Enjoy!<br />\r\n<strong>The</strong> <strong>Carpoolingscript Team</strong><br />\r\n<br />\r\n&nbsp;</p>', NULL, 0);

-- new query

CREATE TABLE IF NOT EXISTS `tbl_country` (
  `country_id` int(6) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(120) DEFAULT NULL,
  `country_code` varchar(15) DEFAULT NULL,
  `currency` varchar(100) NOT NULL,
  `is_active` int(11) DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `currency_id` int(6) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(120) DEFAULT NULL,
  `currency_symbol` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_enquires` (
  `enquiry_id` int(16) NOT NULL AUTO_INCREMENT,
  `enquiry_passanger_id` varchar(40) DEFAULT NULL,
  `enquiry_trip_id` varchar(40) DEFAULT NULL,
  `enquire_travel_id` varchar(255) DEFAULT NULL,
  `enquiry_date_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enquiry_id`),
  KEY `tbl_trips_tbl_enquires` (`enquiry_trip_id`),
  KEY `tbl_passengers_tbl_enquires` (`enquiry_passanger_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(22) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(44) NOT NULL,
  `feedback` varchar(444) NOT NULL,
  `page` varchar(50) DEFAULT NULL,
  `rating` varchar(50) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_language` (
  `language_id` int(6) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(120) DEFAULT NULL,
  `language_code` varchar(15) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_radius` (
  `id` int(150) NOT NULL AUTO_INCREMENT,
  `distance_from` int(150) NOT NULL,
  `distance_to` int(150) NOT NULL,
  `radius` int(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_subscribe` (
  `subscribe_id` int(150) NOT NULL AUTO_INCREMENT,
  `subscribe_email` varchar(255) NOT NULL,
  `subscribe_ip` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subscribe_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_testimonials` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `isactive` int(2) NOT NULL DEFAULT '1',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_trips` (
  `trip_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_driver_id` varchar(40) DEFAULT NULL,
  `trip_vehicle_id` varchar(40) DEFAULT NULL,
  `trip_from_latlan` text,
  `trip_to_latlan` text,
  `source` text NOT NULL,
  `destination` text NOT NULL,
  `route` text NOT NULL,
  `route_full_data` text NOT NULL,
  `trip_routes_lat_lan` text,
  `trip_routes` text NOT NULL,
  `trip_return` varchar(40) DEFAULT NULL,
  `trip_depature_time` time DEFAULT NULL,
  `trip_return_time` time DEFAULT NULL,
  `trip_journey_hours` varchar(40) DEFAULT NULL,
  `trip_amenities` varchar(255) DEFAULT NULL,
  `trip_frequncy` varchar(40) DEFAULT NULL,
  `trip_avilable_seat` varchar(40) DEFAULT NULL,
  `passenger_type` varchar(255) DEFAULT NULL COMMENT '1->male 2->female 3->both',
  `trip_rate_details` varchar(40) DEFAULT NULL,
  `contact_person_name` varchar(40) DEFAULT NULL,
  `contact_person_number` varchar(40) DEFAULT NULL,
  `trip_comments` text,
  `trip_user_id` varchar(40) DEFAULT NULL,
  `trip_casual_date` varchar(255) NOT NULL,
  `trip_created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trip_status` tinyint(1) NOT NULL DEFAULT '1',
  `trip_otp_status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trip_id`),
  KEY `tbl_users_tbl_trips` (`trip_user_id`),
  KEY `tbl_vehicle_tbl_trips` (`trip_vehicle_id`),
  KEY `tbl_drivers_tbl_trips` (`trip_driver_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_t_login_logs` (
  `login_log_id` double DEFAULT NULL,
  `login_id` double DEFAULT NULL,
  `login_ip` varchar(675) DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_t_trip_legs` (
  `trip_led_id` int(150) NOT NULL AUTO_INCREMENT,
  `source_leg` text NOT NULL,
  `source_latitude` varchar(255) NOT NULL,
  `source_longitude` varchar(255) NOT NULL,
  `destination_leg` text NOT NULL,
  `destination_latitude` varchar(255) NOT NULL,
  `destination_longitude` varchar(255) NOT NULL,
  `expected_time` varchar(50) NOT NULL,
  `trip_return` int(10) NOT NULL,
  `route_rate` int(150) NOT NULL DEFAULT '0',
  `trip_id` int(150) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`trip_led_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(40) DEFAULT NULL,
  `user_password` varchar(40) DEFAULT NULL,
  `user_type` varchar(40) DEFAULT NULL COMMENT '1->Travel  , 2->Individuals',
  `user_company_name` varchar(255) DEFAULT NULL,
  `user_first_name` varchar(40) DEFAULT NULL,
  `user_last_name` varchar(40) DEFAULT NULL,
  `user_about_us` text NOT NULL,
  `user_profile_img` varchar(255) NOT NULL,
  `user_mobile` varchar(40) DEFAULT NULL,
  `user_secondary_phone` varchar(40) DEFAULT NULL,
  `user_secondary_mail` varchar(40) DEFAULT NULL,
  `user_company_id` varchar(40) DEFAULT NULL,
  `user_url` varchar(255) NOT NULL,
  `user_street` varchar(255) DEFAULT NULL,
  `user_city` varchar(40) DEFAULT NULL,
  `postal_code` int(50) DEFAULT NULL,
  `user_occupation` varchar(40) DEFAULT NULL,
  `marital_status` varchar(40) DEFAULT NULL,
  `isverified` varchar(60) NOT NULL,
  `show_number` varchar(50) DEFAULT '1' COMMENT '1->yes , 0->no',
  `send_sms` varchar(50) DEFAULT '1' COMMENT '1->yes , 0->no',
  `allowed_food` int(2) NOT NULL COMMENT '0->no,1->yes',
  `allowed_pet` int(2) NOT NULL COMMENT '0->no,1->yes',
  `allowed_smoke` int(2) NOT NULL COMMENT '0->no,1->yes',
  `allowed_chat` int(2) NOT NULL COMMENT '0->no,1->yes',
  `allowed_music` int(2) NOT NULL COMMENT '0->no,1->yes',
  `user_gender` varchar(40) DEFAULT NULL,
  `user_country` varchar(40) DEFAULT NULL,
  `user_dob` varchar(50) NOT NULL,
  `communication_mobile` int(2) NOT NULL DEFAULT '0' COMMENT '0-->primary , 2-->secondary ',
  `communication_email` int(2) NOT NULL DEFAULT '0' COMMENT '0-->primary , 2-->secondary ',
  `login_type` int(10) NOT NULL COMMENT '0-->normal ,1-->facebook',
  `isactive` int(2) NOT NULL,
  `user_admin_status` int(11) NOT NULL DEFAULT '0',
  `user_created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lost_login` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `tbl_company_tbl_users` (`user_company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query


insert  into `tbl_country`(`country_id`,`country_name`,`country_code`,`is_active`,`created_date`) values (1,'India','IN',1,NULL),(2,'Malaysia','MAL',1,NULL),(3,'united state','us',1,NULL);

-- new query

CREATE TABLE IF NOT EXISTS `tbl_vechicle_types` (
  `vechicle_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `vechicle_type_name` varchar(40) DEFAULT NULL,
  `vechicle_image` varchar(64) NOT NULL,
  `category_id` int(14) NOT NULL,
  `vechicle_createdate` varchar(40) DEFAULT NULL,
  `isactive` int(2) NOT NULL,
  PRIMARY KEY (`vechicle_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_vehicle` (
  `vechicle_id` int(11) NOT NULL AUTO_INCREMENT,
  `vechicle_type_id` int(11) DEFAULT NULL,
  `vechicle_number` varchar(40) DEFAULT NULL,
  `vechicle_logo` varchar(50) NOT NULL,
  `vechiclecomfort` varchar(255) NOT NULL,
  `user_id` int(12) NOT NULL,
  `vechicle_createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`vechicle_id`),
  KEY `tbl_vechicle_types_tbl_vehicle` (`vechicle_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- new query

CREATE TABLE IF NOT EXISTS `tbl_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(255) NOT NULL,
  `widget_link` text NOT NULL,
  `widget_script` text NOT NULL,
  `widget_flag` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- new query

CREATE TABLE IF NOT EXISTS `tbl_logo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;



-- new query

INSERT INTO `tbl_logo` (`id`, `name`) VALUES
(1, 'user1_logo_1442642482.png');

