
CREATE TABLE IF NOT EXISTS `#__tlptestimonial_testimonial` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `testimonial` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `#__tlptestimonial_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `#__tlptestimonial_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagepath` varchar(255) NOT NULL DEFAULT 'images/testimonial',
  `smallwidth` varchar(255) NOT NULL DEFAULT '160',
  `smallheight` varchar(255) NOT NULL DEFAULT '160',
  `mediumwidth` varchar(255) NOT NULL DEFAULT '340',
  `mediumheight` varchar(255) NOT NULL DEFAULT '340',
  `largewidth` varchar(255) NOT NULL DEFAULT '1080',
  `largeheight` varchar(255) NOT NULL DEFAULT '1080',
  `display_no` int(11) NOT NULL,
  `enable_bootstrap_css` tinyint(4) NOT NULL,
  `detailpage_image_grid` int(11) NOT NULL,
  `detailpage_content_grid` int(11) NOT NULL,
  `enable_read_more` tinyint(4) NOT NULL DEFAULT '0',
  `character_limit` int(11) NOT NULL DEFAULT '150',
  `email` varchar(100) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `#__tlptestimonial_settings`
--

INSERT INTO `#__tlptestimonial_settings` (`id`, `imagepath`, `smallwidth`, `smallheight`, `mediumwidth`, `mediumheight`, `largewidth`, `largeheight`, `display_no`, `enable_bootstrap_css`, `detailpage_image_grid`, `detailpage_content_grid`, `enable_read_more`, `character_limit`, `email`, `state`, `checked_out`, `checked_out_time`, `created_by`) VALUES
(1, 'images/tlptestimonial', '80', '80', '340', '340', '1080', '1080', 1, 1, 2, 0, 0, 100, 'info@yourwebsite.com', 1, 0, '0000-00-00 00:00:00', 0);
