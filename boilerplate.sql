-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2018 at 01:44 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boilerplate`
--

-- --------------------------------------------------------

--
-- Table structure for table `aauth_groups`
--

CREATE TABLE `aauth_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `definition` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_groups`
--

INSERT INTO `aauth_groups` (`id`, `name`, `definition`) VALUES
(1, 'Member', 'Member Default Access Group'),
(2, 'Super Administrator', 'Super Administrator Access Group'),
(100, 'Administrator', 'Administrator Access Group'),
(2001, 'Editor', 'Editor'),
(2010, 'Moderator', 'These people are for moderation ');

-- --------------------------------------------------------

--
-- Table structure for table `aauth_group_permissions`
--

CREATE TABLE `aauth_group_permissions` (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_group_permissions`
--

INSERT INTO `aauth_group_permissions` (`perm_id`, `group_id`) VALUES
(1, 1),
(2, 100),
(3, 100),
(4, 2001);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_login_attempts`
--

CREATE TABLE `aauth_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(40) NOT NULL DEFAULT '0',
  `timestamp` datetime DEFAULT NULL,
  `login_attempts` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_permissions`
--

CREATE TABLE `aauth_permissions` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `definition` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_permissions`
--

INSERT INTO `aauth_permissions` (`id`, `name`, `definition`) VALUES
(1, 'Control Panel', 'Control Panel'),
(2, 'System', 'System'),
(3, 'Users', 'Users'),
(4, 'Groups', 'Groups'),
(5, 'Permissions', 'Permissions');

-- --------------------------------------------------------

--
-- Table structure for table `aauth_pms`
--

CREATE TABLE `aauth_pms` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `receiver_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `date_sent` datetime DEFAULT NULL,
  `date_read` datetime DEFAULT NULL,
  `pm_deleted_sender` int(11) NOT NULL DEFAULT '0',
  `pm_deleted_receiver` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_sub_groups`
--

CREATE TABLE `aauth_sub_groups` (
  `group_id` int(11) UNSIGNED NOT NULL,
  `subgroup_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `aauth_users`
--

CREATE TABLE `aauth_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `banned` int(1) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `forgot_exp` text,
  `remember_time` datetime DEFAULT NULL,
  `remember_exp` text,
  `verification_code` text,
  `totp_secret` varchar(16) DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_users`
--

INSERT INTO `aauth_users` (`id`, `email`, `pass`, `username`, `fullname`, `banned`, `last_login`, `last_activity`, `date_created`, `forgot_exp`, `remember_time`, `remember_exp`, `verification_code`, `totp_secret`, `ip_address`) VALUES
(1, 'superadmin@gmail.com', '8b235284a9f7a82364468e52dab386f33844421b481113794e0b4d634c86d0f3', 'superadmin', 'Super Administrator', 0, '2017-07-22 20:24:03', '2017-07-22 21:13:33', '2017-07-19 08:20:23', NULL, NULL, NULL, NULL, NULL, '::1'),
(2, 'admin@no.com', '52b3a93aac36bd14b3a1c9e7118f79981d14d39c6fd5118884d7544e58232a8d', 'admin', 'Administrator', 0, '2017-07-19 11:33:22', '2017-07-19 11:34:02', '2017-07-19 08:20:23', NULL, NULL, NULL, NULL, NULL, '::1'),
(1001, 'rubim@mail.com', '569df70b025029830b909a8af8b0fcf3499cb1062830580f315b3f8580217452', 'rubim', 'Rubim Shrestha', 0, '2017-07-19 08:29:10', '2017-07-19 08:30:43', '2017-07-19 08:28:50', NULL, NULL, NULL, NULL, NULL, '::1'),
(1002, 'akasky70@gmail.com', '1fa371747a6a8031ae8744612c476a6ebfdf381982c33f75274f74004a2f0794', 'akash', 'Akash RAi ', 0, '2017-07-19 12:06:56', '2017-07-19 12:06:57', '2017-07-19 11:57:16', NULL, NULL, NULL, NULL, NULL, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_groups`
--

CREATE TABLE `aauth_user_groups` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_user_groups`
--

INSERT INTO `aauth_user_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 100),
(1001, 1),
(1001, 100),
(1002, 1),
(1002, 2001);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_permissions`
--

CREATE TABLE `aauth_user_permissions` (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aauth_user_permissions`
--

INSERT INTO `aauth_user_permissions` (`perm_id`, `user_id`) VALUES
(4, 1001);

-- --------------------------------------------------------

--
-- Table structure for table `aauth_user_variables`
--

CREATE TABLE `aauth_user_variables` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `data_key` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_activity_logs`
--

CREATE TABLE `project_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `table_pk` int(11) UNSIGNED NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `action_dttime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_audit_logs`
--

CREATE TABLE `project_audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `table_pk` int(11) UNSIGNED NOT NULL,
  `column_name` varchar(255) DEFAULT NULL,
  `old_value` varchar(1000) DEFAULT NULL,
  `new_value` varchar(1000) DEFAULT NULL,
  `action_dttime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_migrations`
--

CREATE TABLE `project_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_migrations`
--

INSERT INTO `project_migrations` (`version`) VALUES
(11);

-- --------------------------------------------------------

--
-- Table structure for table `project_sessions`
--

CREATE TABLE `project_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_sessions`
--

INSERT INTO `project_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('061807c3a7bd8d87f0f80b85f61c73478548e9ad', '::1', 1500695713, '__ci_last_regenerate|i:1500695713;'),
('0bba763635c05d7cd7d79dff9f677af6f269820c', '::1', 1500432058, '__ci_last_regenerate|i:1500432058;'),
('26ca4c076f1e4b1ddc769f118b052deb9f138495', '::1', 1500698527, '__ci_last_regenerate|i:1500698527;'),
('2c98965430ce6dcabd3fa14243f878b9a42a0b37', '::1', 1500698793, '__ci_last_regenerate|i:1500698781;'),
('4570d66ec152d398f7a36260c26c28ac0cc2731c', '::1', 1500433657, '__ci_last_regenerate|i:1500433652;'),
('463f2119ade45706e0318af5d282ddce5a9308eb', '::1', 1500708504, '__ci_last_regenerate|i:1500708471;'),
('4e96675cd9e8f48b8de566693ed34cc162a39ca1', '::1', 1500697739, '__ci_last_regenerate|i:1500697739;'),
('5e530964dcd116c9047c88e433226490b47a7e5f', '::1', 1500515481, '__ci_last_regenerate|i:1500515481;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('60c682114e4000c83848755dfc35b275ce350ee4', '::1', 1500516112, '__ci_last_regenerate|i:1500515828;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('6473994b3e2cf55f25625cedafea28be1caa7880', '::1', 1500737313, '__ci_last_regenerate|i:1500737202;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('6984c6c006fea9e7b53dc9170149d829181ff8e2', '::1', 1500515828, '__ci_last_regenerate|i:1500515828;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('6e38ecccd78baa6390a42be21d012a25e0a6d990', '::1', 1500445388, '__ci_last_regenerate|i:1500445324;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('76a25382a19ca734b57a7500ee7d5bb30f46053d', '::1', 1500454548, '__ci_last_regenerate|i:1500454546;'),
('7e912db6ccbb18588107f8927c2b87f776ce8b82', '::1', 1500432338, '__ci_last_regenerate|i:1500432058;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('9139104f98aa5b5382b8476cc43f23a22efbbfa3', '::1', 1500697422, '__ci_last_regenerate|i:1500697422;'),
('9b6c53d373cf24ae3a22744d4b660ec860d07c17', '::1', 1500737202, '__ci_last_regenerate|i:1500737202;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('abcf631b212053ef264912390f4ae4d9fef6eb02', '::1', 1500443871, '__ci_last_regenerate|i:1500443871;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('b2a4748b95dd9a250b870e85ecf0c6f372166d38', '::1', 1500444695, '__ci_last_regenerate|i:1500444695;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('b7fb41b0d519797ce2e789277c89b4590dfb45e8', '::1', 1500445304, '__ci_last_regenerate|i:1500445304;'),
('d77df85b736b0e230932e5fc59bb67b6bdbed547', '::1', 1500734885, '__ci_last_regenerate|i:1500734885;id|s:1:"1";username|s:10:"superadmin";email|s:20:"superadmin@gmail.com";loggedin|b:1;'),
('faa0c37be07d9554ac5f7419a3c004d00c474e75', '::1', 1500433651, '__ci_last_regenerate|i:1500433651;id|s:4:"1001";username|s:5:"rubim";email|s:14:"rubim@mail.com";loggedin|b:1;'),
('fe138b7994d0569322ea3b02920d48bb8a18d81f', '::1', 1500716095, '__ci_last_regenerate|i:1500716092;');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_group_permissions`
--
CREATE TABLE `view_group_permissions` (
`group_id` int(11) unsigned
,`perm_id` int(11) unsigned
,`permission` varchar(100)
,`group_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_users`
--
CREATE TABLE `view_users` (
`id` int(11) unsigned
,`email` varchar(100)
,`pass` varchar(255)
,`username` varchar(100)
,`fullname` varchar(255)
,`banned` int(1)
,`last_login` datetime
,`last_activity` datetime
,`date_created` datetime
,`forgot_exp` text
,`remember_time` datetime
,`remember_exp` text
,`verification_code` text
,`totp_secret` varchar(16)
,`ip_address` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user_groups`
--
CREATE TABLE `view_user_groups` (
`user_id` int(11) unsigned
,`group_id` int(11) unsigned
,`group_name` varchar(100)
,`username` varchar(100)
,`email` varchar(100)
,`fullname` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_user_permissions`
--
CREATE TABLE `view_user_permissions` (
`user_id` int(11) unsigned
,`perm_id` int(11) unsigned
,`permission` varchar(100)
,`username` varchar(100)
,`email` varchar(100)
,`fullname` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `view_group_permissions`
--
DROP TABLE IF EXISTS `view_group_permissions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_group_permissions`  AS  (select `gp`.`group_id` AS `group_id`,`gp`.`perm_id` AS `perm_id`,`perm`.`name` AS `permission`,`grp`.`name` AS `group_name` from ((`aauth_group_permissions` `gp` join `aauth_groups` `grp` on((`grp`.`id` = `gp`.`group_id`))) join `aauth_permissions` `perm` on((`perm`.`id` = `gp`.`perm_id`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_users`
--
DROP TABLE IF EXISTS `view_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_users`  AS  (select `u`.`id` AS `id`,`u`.`email` AS `email`,`u`.`pass` AS `pass`,`u`.`username` AS `username`,`u`.`fullname` AS `fullname`,`u`.`banned` AS `banned`,`u`.`last_login` AS `last_login`,`u`.`last_activity` AS `last_activity`,`u`.`date_created` AS `date_created`,`u`.`forgot_exp` AS `forgot_exp`,`u`.`remember_time` AS `remember_time`,`u`.`remember_exp` AS `remember_exp`,`u`.`verification_code` AS `verification_code`,`u`.`totp_secret` AS `totp_secret`,`u`.`ip_address` AS `ip_address` from `aauth_users` `u`) ;

-- --------------------------------------------------------

--
-- Structure for view `view_user_groups`
--
DROP TABLE IF EXISTS `view_user_groups`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_groups`  AS  (select `ug`.`user_id` AS `user_id`,`ug`.`group_id` AS `group_id`,`g`.`name` AS `group_name`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`fullname` AS `fullname` from ((`aauth_user_groups` `ug` join `aauth_users` `u` on((`u`.`id` = `ug`.`user_id`))) join `aauth_groups` `g` on((`g`.`id` = `ug`.`group_id`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `view_user_permissions`
--
DROP TABLE IF EXISTS `view_user_permissions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_user_permissions`  AS  (select `up`.`user_id` AS `user_id`,`up`.`perm_id` AS `perm_id`,`perm`.`name` AS `permission`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`fullname` AS `fullname` from ((`aauth_user_permissions` `up` join `aauth_users` `u` on((`u`.`id` = `up`.`user_id`))) join `aauth_permissions` `perm` on((`perm`.`id` = `up`.`perm_id`)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aauth_groups`
--
ALTER TABLE `aauth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_group_permissions`
--
ALTER TABLE `aauth_group_permissions`
  ADD PRIMARY KEY (`perm_id`,`group_id`);

--
-- Indexes for table `aauth_login_attempts`
--
ALTER TABLE `aauth_login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `aauth_permissions`
--
ALTER TABLE `aauth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_pms`
--
ALTER TABLE `aauth_pms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sender_id_receiver_id_date_read` (`id`,`sender_id`,`receiver_id`,`date_read`);

--
-- Indexes for table `aauth_sub_groups`
--
ALTER TABLE `aauth_sub_groups`
  ADD PRIMARY KEY (`group_id`,`subgroup_id`);

--
-- Indexes for table `aauth_users`
--
ALTER TABLE `aauth_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aauth_user_groups`
--
ALTER TABLE `aauth_user_groups`
  ADD PRIMARY KEY (`user_id`,`group_id`);

--
-- Indexes for table `aauth_user_permissions`
--
ALTER TABLE `aauth_user_permissions`
  ADD PRIMARY KEY (`perm_id`,`user_id`);

--
-- Indexes for table `aauth_user_variables`
--
ALTER TABLE `aauth_user_variables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `project_activity_logs`
--
ALTER TABLE `project_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `project_audit_logs`
--
ALTER TABLE `project_audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `project_sessions`
--
ALTER TABLE `project_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aauth_groups`
--
ALTER TABLE `aauth_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2011;
--
-- AUTO_INCREMENT for table `aauth_login_attempts`
--
ALTER TABLE `aauth_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aauth_permissions`
--
ALTER TABLE `aauth_permissions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `aauth_pms`
--
ALTER TABLE `aauth_pms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `aauth_users`
--
ALTER TABLE `aauth_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1003;
--
-- AUTO_INCREMENT for table `aauth_user_variables`
--
ALTER TABLE `aauth_user_variables`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_activity_logs`
--
ALTER TABLE `project_activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_audit_logs`
--
ALTER TABLE `project_audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
