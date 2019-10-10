-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2019 at 10:57 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jorani`
--

DELIMITER $$
--
-- Functions
--
CREATE FUNCTION `GetAcronym` (`str` TEXT) RETURNS TEXT CHARSET utf8 READS SQL DATA
    SQL SECURITY INVOKER
BEGIN
    declare result text default '';
    set result = GetInitials( str, '[[:alnum:]]' );
    return result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetAncestry` (`GivenID` INT) RETURNS VARCHAR(1024) CHARSET utf8 READS SQL DATA
    SQL SECURITY INVOKER
BEGIN
    DECLARE rv VARCHAR(1024);
    DECLARE cm CHAR(1);
    DECLARE ch INT;

    SET rv = '';
    SET cm = '';
    SET ch = GivenID;
    WHILE ch > 0 DO
        SELECT IFNULL(parent_id,-1) INTO ch FROM
        (SELECT parent_id FROM organization WHERE id = ch) A;
        IF ch > 0 THEN
            SET rv = CONCAT(rv,cm,ch);
            SET cm = ',';
        END IF;
    END WHILE;
    RETURN rv;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetFamilyTree` (`GivenID` INT) RETURNS VARCHAR(1024) CHARSET utf8 READS SQL DATA
    SQL SECURITY INVOKER
BEGIN

    DECLARE rv,q,queue,queue_children VARCHAR(1024);
    DECLARE queue_length,front_id,pos INT;

    SET rv = '';
    SET queue = GivenID;
    SET queue_length = 1;

    WHILE queue_length > 0 DO
        SET front_id = FORMAT(queue,0);
        IF queue_length = 1 THEN
            SET queue = '';
        ELSE
            SET pos = LOCATE(',',queue) + 1;
            SET q = SUBSTR(queue,pos);
            SET queue = q;
        END IF;
        SET queue_length = queue_length - 1;

        SELECT IFNULL(qc,'') INTO queue_children
        FROM (SELECT GROUP_CONCAT(id) qc
        FROM organization WHERE parent_id = front_id) A;

        IF LENGTH(queue_children) = 0 THEN
            IF LENGTH(queue) = 0 THEN
                SET queue_length = 0;
            END IF;
        ELSE
            IF LENGTH(rv) = 0 THEN
                SET rv = queue_children;
            ELSE
                SET rv = CONCAT(rv,',',queue_children);
            END IF;
            IF LENGTH(queue) = 0 THEN
                SET queue = queue_children;
            ELSE
                SET queue = CONCAT(queue,',',queue_children);
            END IF;
            SET queue_length = LENGTH(queue) - LENGTH(REPLACE(queue,',','')) + 1;
        END IF;
    END WHILE;
    RETURN rv;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetInitials` (`str` TEXT, `expr` TEXT) RETURNS TEXT CHARSET utf8 READS SQL DATA
    SQL SECURITY INVOKER
BEGIN
    declare result text default '';
    declare buffer text default '';
    declare i int default 1;
    if(str is null) then
        return null;
    end if;
    set buffer = trim(str);
    while i <= length(buffer) do
        if substr(buffer, i, 1) regexp expr then
            set result = concat( result, substr( buffer, i, 1 ));
            set i = i + 1;
            while i <= length( buffer ) and substr(buffer, i, 1) regexp expr do
                set i = i + 1;
            end while;
            while i <= length( buffer ) and substr(buffer, i, 1) not regexp expr do
                set i = i + 1;
            end while;
        else
            set i = i + 1;
        end if;
    end while;
    return result;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `GetParentIDByID` (`GivenID` INT) RETURNS INT(11) READS SQL DATA
    SQL SECURITY INVOKER
BEGIN
    DECLARE rv INT;

    SELECT IFNULL(parent_id,-1) INTO rv FROM
    (SELECT parent_id FROM organization WHERE id = GivenID) A;
    RETURN rv;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mask` bit(16) NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of possible actions';

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`name`, `mask`, `Description`) VALUES
('accept_requests', b'0011000100110010', 'Accept the request of my team members'),
('admin_menu', b'0011000100110010', 'View admin menu'),
('change_password', b'0011000100110010', 'Change password'),
('create_leaves', b'0011000100110010', 'Create a new user leave request'),
('create_user', b'0011000100110010', 'Create a new user'),
('delete_user', b'0011000100110010', 'Delete an existing user'),
('edit_leaves', b'0011000100110010', 'Edit a leave request'),
('edit_settings', b'0011000100110010', 'Edit application settings'),
('edit_user', b'0011000100110010', 'Edit a user'),
('export_leaves', b'0011000100110010', 'Export the list of leave requests into an Excel file'),
('export_user', b'0011000100110010', 'Export the list of users into an Excel file'),
('hr_menu', b'0011000100110010', 'View HR menu'),
('individual_calendar', b'0011000100110010', 'View my leaves in a calendar'),
('list_leaves', b'0011000100110010', 'List my leave requests'),
('list_requests', b'0011000100110010', 'List the request of my team members'),
('list_users', b'0011000100110010', 'List users'),
('reject_requests', b'0011000100110010', 'Reject the request of my team members'),
('reset_password', b'0011000100110010', 'Modifiy the password of another user'),
('team_calendar', b'0011000100110010', 'View the leaves of my team in a calendar'),
('update_user', b'0011000100110010', 'Update a user'),
('view_leaves', b'0011000100110010', 'View the details of a leave request'),
('view_user', b'0011000100110010', 'View user\'s details');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='CodeIgniter sessions (you can empty this table without consequence)';

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('q2af2umk6hunav1ldqvh0uqupdpt93tu', '127.0.0.1', 1569306128, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393330363132383b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a32343a227664763755546730767a4951524733464a74552f6c322f44223b6c6f67696e7c733a353a2261646d696e223b69647c733a313a2231223b66697273746e616d657c733a353a2241646d696e223b6c6173746e616d657c733a363a2253797374656d223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2231223b72616e646f6d5f686173687c4e3b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32383a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f3134223b6c6173745f706167655f706172616d737c733a303a22223b),
('25aglm0pcouemeej5oj4qpmej1bcnndv', '127.0.0.1', 1569308895, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393330383839353b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('7671tjruhhkkslqdqh09kurt68ovs436', '127.0.0.1', 1569309229, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393330393232393b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('b5tpk1ki767iofotc612lb89qdkj806b', '127.0.0.1', 1569309587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393330393538373b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('uu7ak95hkqg5sbco1hm4t9v114cahv73', '127.0.0.1', 1569309916, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393330393931363b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('34qqo2dmk3ug99mv5rghuvikofdd7tqe', '127.0.0.1', 1569310354, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331303335343b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('7j39vuktqabjbjp5q9fh0sap8746eano', '127.0.0.1', 1569310668, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331303636383b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('i1sg3stmls9c8l87h9uv5necpkata1k9', '127.0.0.1', 1569311154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331313135343b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32383a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f3134223b6c6173745f706167655f706172616d737c733a303a22223b),
('skj25c2fnrjcs20mpcbtkhov10a2ai03', '127.0.0.1', 1569311464, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331313436343b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('8enslvq5jdt136f0q8c9438rvjt9022d', '127.0.0.1', 1569312204, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331323230343b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('2osvcpo5shfuekf1r4mi4fq5hdq2slr0', '127.0.0.1', 1569312570, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331323537303b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b6d73677c623a303b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226f6c64223b7d),
('33fc2kcjunmpv6av3nndpp1up3f5p0hf', '127.0.0.1', 1569312970, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331323937303b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('k0qgalveipthd7lvtn9l4b9e1311a3c3', '127.0.0.1', 1569313518, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331333531383b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('rau1cd3k5ggd1bh3jf9hldfdha1o0b0o', '127.0.0.1', 1569313830, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331333833303b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b6d73677c623a303b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226e6577223b7d),
('5iturhusabfmolq77glmn83phpq8a51b', '127.0.0.1', 1569314275, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331343237353b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b),
('n5idqpm6hdhqbg30pgfoh8ea0qgk1ojr', '127.0.0.1', 1569314643, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331343634333b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b6d73677c623a303b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226e6577223b7d),
('sc9rqold7el5dj0ea4qhaahibgm3e82b', '127.0.0.1', 1569315008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331353030383b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b6d73677c623a303b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226e6577223b7d),
('eaoh6sp3mqd3o9aajks1rdu3cqfhrpk7', '127.0.0.1', 1569315033, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536393331353030383b6c616e67756167655f636f64657c733a323a22656e223b6c616e67756167657c733a373a22656e676c697368223b73616c747c733a31363a22756a51754a436c3857537168476d6e67223b6c6f67696e7c733a353a2274686f6c65223b69647c733a313a2238223b66697273746e616d657c733a333a2274686f223b6c6173746e616d657c733a323a224c45223b69735f6d616e616765727c623a313b69735f61646d696e7c623a313b69735f68727c623a313b6d616e616765727c733a313a2235223b72616e646f6d5f686173687c733a32343a2244304d65344d7646644a6842394873546658484e51533666223b6c6f676765645f696e7c623a313b6c6173745f706167657c733a32373a22687474703a2f2f6c65617665746f6f6c5c2f626f6f6b696e672f31223b6c6173745f706167655f706172616d737c733a303a22223b6d73677c623a303b5f5f63695f766172737c613a313a7b733a333a226d7367223b733a333a226e6577223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of a contract',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the contract',
  `startentdate` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Day and month numbers of the left boundary',
  `endentdate` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Day and month numbers of the right boundary',
  `weekly_duration` int(11) DEFAULT NULL COMMENT 'Approximate duration of work per week (in minutes)',
  `daily_duration` int(11) DEFAULT NULL COMMENT 'Approximate duration of work per day and (in minutes)',
  `default_leave_type` int(11) DEFAULT NULL COMMENT 'default leave type for the contract (overwrite default type set in config file).'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='A contract groups employees having the same days off and entitlement rules';

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `name`, `startentdate`, `endentdate`, `weekly_duration`, `daily_duration`, `default_leave_type`) VALUES
(1, 'Global', '01/01', '12/31', 2400, 480, 1),
(2, 'Lê Thanh Bình', '01/01', '12/31', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contract_types`
--

CREATE TABLE `contract_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contract_types`
--

INSERT INTO `contract_types` (`id`, `name`, `alias`, `description`) VALUES
(1, 'Part Time', '', ''),
(2, 'Full Time', 'f', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `dayoffs`
--

CREATE TABLE `dayoffs` (
  `id` int(11) NOT NULL,
  `contract` int(11) NOT NULL COMMENT 'Contract id',
  `date` date NOT NULL COMMENT 'Date of the day off',
  `type` int(11) NOT NULL COMMENT 'Half or full day',
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Description of day off'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of non working days';

-- --------------------------------------------------------

--
-- Table structure for table `delegations`
--

CREATE TABLE `delegations` (
  `id` int(11) NOT NULL COMMENT 'Id of delegation',
  `manager_id` int(11) NOT NULL COMMENT 'Manager wanting to delegate',
  `delegate_id` int(11) NOT NULL COMMENT 'Employee having the delegation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Delegation of approval';

-- --------------------------------------------------------

--
-- Table structure for table `entitleddays`
--

CREATE TABLE `entitleddays` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of an entitlement',
  `contract` int(11) DEFAULT NULL COMMENT 'If entitlement is credited to a contract, Id of contract',
  `employee` int(11) DEFAULT NULL COMMENT 'If entitlement is credited to an employee, Id of employee',
  `overtime` int(11) DEFAULT NULL COMMENT 'Optional Link to an overtime request, if the credit is due to an OT',
  `startdate` date DEFAULT NULL COMMENT 'Left boundary of the credit validity',
  `enddate` date DEFAULT NULL COMMENT 'Right boundary of the credit validity. Duration cannot exceed one year',
  `type` int(11) NOT NULL COMMENT 'Leave type',
  `days` decimal(10,2) NOT NULL COMMENT 'Number of days (can be negative so as to deduct/adjust entitlement)',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Description of a credit / debit (entitlement / adjustment)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Add or substract entitlement on employees or contracts (can be the result of an OT)';

--
-- Dumping data for table `entitleddays`
--

INSERT INTO `entitleddays` (`id`, `contract`, `employee`, `overtime`, `startdate`, `enddate`, `type`, `days`, `description`) VALUES
(1, 2, NULL, NULL, '2019-01-01', '2019-12-31', 1, '1.00', 'Gia đình'),
(10, NULL, 9, NULL, '2019-08-01', '2019-08-02', 1, '2.00', ''),
(11, NULL, 9, 8, '2019-01-01', '2019-12-31', 0, '2.00', 'Catch up 2019-08-31'),
(12, NULL, 8, NULL, '2019-08-29', '2019-08-31', 1, '3.00', ''),
(13, 9, NULL, NULL, '2019-08-30', '2019-08-30', 1, '1.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `roomid` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `uid`, `roomid`, `title`, `start`, `end`) VALUES
(59, 8, 1, 'Header', '2019-09-23 00:30:00', '2019-09-23 02:00:00'),
(87, 8, 15, 'test', '2019-09-25 00:00:00', '2019-09-25 00:30:00'),
(88, 1, 1, '', '2019-09-25 02:00:00', '2019-09-25 03:00:00'),
(90, 8, 1, '', '2019-10-01 00:00:00', '2019-10-02 00:00:00'),
(110, 8, 1, 'Header', '2019-09-25 08:30:00', '2019-09-25 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `excluded_types`
--

CREATE TABLE `excluded_types` (
  `id` int(11) NOT NULL COMMENT 'Id of exclusion',
  `contract_id` int(11) NOT NULL COMMENT 'Id of contract',
  `type_id` int(11) NOT NULL COMMENT 'Id of leave ype to be excluded to the contract'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Exclude a leave type from a contract';

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the leave request',
  `startdate` date DEFAULT NULL COMMENT 'Start date of the leave request',
  `enddate` date DEFAULT NULL COMMENT 'End date of the leave request',
  `status` int(11) DEFAULT NULL COMMENT 'Identifier of the status of the leave request (Requested, Accepted, etc.). See status table.',
  `employee` int(11) DEFAULT NULL COMMENT 'Employee requesting the leave request',
  `cause` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Reason of the leave request',
  `startdatetype` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Morning/Afternoon',
  `enddatetype` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Morning/Afternoon',
  `duration` decimal(10,3) DEFAULT NULL COMMENT 'Length of the leave request',
  `type` int(11) DEFAULT NULL COMMENT 'Identifier of the type of the leave request (Paid, Sick, etc.). See type table.',
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comments on leave request (JSon)',
  `document` blob DEFAULT NULL COMMENT 'Optional supporting document'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Leave requests';

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `startdate`, `enddate`, `status`, `employee`, `cause`, `startdatetype`, `enddatetype`, `duration`, `type`, `comments`, `document`) VALUES
(5, '2019-08-29', '2019-08-29', 3, 7, 'Gia đình', 'Morning', 'Afternoon', '1.000', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"5\",\"value\":\"Leave \\u0111\\u01b0\\u1ee3c chuy\\u1ec3n t\\u1edbi HR\",\"date\":\"2019-8-28\"},{\"type\":\"comment\",\"author\":\"5\",\"value\":\"T\\u00f4i \\u0111\\u1ed3ng \\u00fd cho Ngh\\u1ec9\",\"date\":\"2019-8-28\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-28\"}]}', NULL),
(27, '2019-08-30', '2019-08-30', 3, 9, '', 'Morning', 'Afternoon', '1.000', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"}]}', NULL),
(28, '2019-08-30', '2019-08-30', 4, 9, '', 'Morning', 'Afternoon', '1.000', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-30\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"},{\"type\":\"comment\",\"author\":\"8\",\"value\":\"test\",\"date\":\"2019-8-30\"},{\"type\":\"change\",\"status_number\":4,\"date\":\"2019-8-30\"}]}', NULL),
(29, '2019-08-30', '2019-08-30', 3, 2, '', 'Morning', 'Afternoon', '1.000', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":5,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"}]}', NULL),
(30, '2019-08-31', '2019-08-31', 3, 9, '', 'Morning', 'Morning', '0.500', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"}]}', NULL),
(31, '2019-08-31', '2019-08-31', 2, 9, '', 'Morning', 'Morning', '0.500', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":\"2\",\"date\":\"2019-8-30\"},{\"type\":\"comment\",\"author\":\"9\",\"value\":\"test\",\"date\":\"2019-9-9\"}]}', NULL),
(32, '2019-08-28', '2019-08-30', 2, 8, '', 'Morning', 'Afternoon', '3.000', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"8\",\"value\":\"my feedback\",\"date\":\"2019-9-9\"}]}', NULL),
(33, '2019-09-07', '2019-09-07', 1, 8, '', 'Morning', 'Afternoon', '1.000', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"8\",\"value\":\"test\",\"date\":\"2019-9-9\"}]}', NULL),
(34, '2019-09-09', '2019-09-10', 1, 9, 'test', 'Morning', 'Afternoon', '2.000', 1, 'null', NULL),
(36, '2019-09-10', '2019-09-10', 1, 9, '', 'Morning', 'Afternoon', '1.000', 1, NULL, NULL),
(37, '2019-09-20', '2019-09-20', 2, 9, '', 'Morning', 'Afternoon', '1.000', 1, NULL, NULL),
(38, '2019-09-21', '2019-09-21', 1, 1, '', 'Morning', 'Afternoon', '1.000', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaves_history`
--

CREATE TABLE `leaves_history` (
  `id` int(11) NOT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `employee` int(11) DEFAULT NULL,
  `cause` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startdatetype` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enddatetype` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` decimal(10,2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Comments on leave request',
  `document` blob DEFAULT NULL COMMENT 'Optional supporting document',
  `change_id` int(11) NOT NULL,
  `change_type` int(11) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of changes in leave requests table';

--
-- Dumping data for table `leaves_history`
--

INSERT INTO `leaves_history` (`id`, `startdate`, `enddate`, `status`, `employee`, `cause`, `startdatetype`, `enddatetype`, `duration`, `type`, `comments`, `document`, `change_id`, `change_type`, `changed_by`, `change_date`) VALUES
(5, '2019-08-29', '2019-08-29', 2, 7, 'Gia đình', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 9, 1, 7, '2019-08-28 08:13:52'),
(5, '2019-08-29', '2019-08-29', 2, 7, 'Gia đình', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"5\",\"value\":\"Leave \\u0111\\u01b0\\u1ee3c chuy\\u1ec3n t\\u1edbi HR\",\"date\":\"2019-8-28\"}]}', NULL, 10, 2, 5, '2019-08-28 08:18:41'),
(5, '2019-08-29', '2019-08-29', 2, 7, 'Gia đình', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"5\",\"value\":\"Leave \\u0111\\u01b0\\u1ee3c chuy\\u1ec3n t\\u1edbi HR\",\"date\":\"2019-8-28\"},{\"type\":\"comment\",\"author\":\"5\",\"value\":\"T\\u00f4i \\u0111\\u1ed3ng \\u00fd cho Ngh\\u1ec9\",\"date\":\"2019-8-28\"}]}', NULL, 11, 2, 5, '2019-08-28 08:21:20'),
(5, '2019-08-29', '2019-08-29', 3, 7, 'Gia đình', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"5\",\"value\":\"Leave \\u0111\\u01b0\\u1ee3c chuy\\u1ec3n t\\u1edbi HR\",\"date\":\"2019-8-28\"},{\"type\":\"comment\",\"author\":\"5\",\"value\":\"T\\u00f4i \\u0111\\u1ed3ng \\u00fd cho Ngh\\u1ec9\",\"date\":\"2019-8-28\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-28\"}]}', NULL, 12, 2, 5, '2019-08-28 08:21:30'),
(27, '2019-08-30', '2019-08-30', 2, 9, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 64, 1, 9, '2019-08-29 09:11:40'),
(28, '2019-08-30', '2019-08-30', 2, 9, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 65, 1, 9, '2019-08-29 09:11:54'),
(29, '2019-08-30', '2019-08-30', 2, 2, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 66, 1, 2, '2019-08-29 09:30:49'),
(29, '2019-08-30', '2019-08-30', 3, 2, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"}]}', NULL, 67, 2, 5, '2019-08-29 09:35:26'),
(29, '2019-08-30', '2019-08-30', 5, 2, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":5,\"date\":\"2019-8-29\"}]}', NULL, 68, 2, 2, '2019-08-29 09:35:38'),
(29, '2019-08-30', '2019-08-30', 6, 2, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":5,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-29\"}]}', NULL, 69, 2, 5, '2019-08-29 09:35:56'),
(29, '2019-08-30', '2019-08-30', 3, 2, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":5,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-29\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-29\"}]}', NULL, 70, 2, 5, '2019-08-29 09:36:41'),
(30, '2019-08-31', '2019-08-31', 1, 9, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 71, 1, 9, '2019-08-30 09:01:01'),
(30, '2019-08-31', '2019-08-31', 1, 9, '', 'Afternoon', 'Afternoon', '0.25', 1, 'null', NULL, 72, 2, 9, '2019-08-30 09:05:44'),
(30, '2019-08-31', '2019-08-31', 1, 9, '', 'Morning', 'Morning', '0.50', 1, 'null', NULL, 73, 2, 9, '2019-08-30 09:17:01'),
(27, '2019-08-30', '2019-08-30', 3, 9, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"}]}', NULL, 74, 2, 8, '2019-08-30 09:26:23'),
(30, '2019-08-31', '2019-08-31', 3, 9, '', 'Morning', 'Morning', '0.50', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"}]}', NULL, 75, 2, 8, '2019-08-30 09:27:00'),
(28, '2019-08-30', '2019-08-30', 6, 9, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-30\"}]}', NULL, 76, 2, 9, '2019-08-30 09:27:32'),
(28, '2019-08-30', '2019-08-30', 3, 9, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-30\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"}]}', NULL, 77, 2, 8, '2019-08-30 09:28:37'),
(28, '2019-08-30', '2019-08-30', 4, 9, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":6,\"date\":\"2019-8-30\"},{\"type\":\"change\",\"status_number\":3,\"date\":\"2019-8-30\"},{\"type\":\"comment\",\"author\":\"8\",\"value\":\"test\",\"date\":\"2019-8-30\"},{\"type\":\"change\",\"status_number\":4,\"date\":\"2019-8-30\"}]}', NULL, 78, 2, 8, '2019-08-30 09:29:23'),
(31, '2019-08-31', '2019-08-31', 1, 9, '', 'Morning', 'Morning', '0.50', 1, NULL, NULL, 79, 1, 9, '2019-08-30 09:37:50'),
(31, '2019-08-31', '2019-08-31', 2, 9, '', 'Morning', 'Morning', '0.50', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":\"2\",\"date\":\"2019-8-30\"}]}', NULL, 80, 2, 9, '2019-08-30 09:38:15'),
(32, '2019-08-28', '2019-08-30', 2, 8, '', 'Morning', 'Afternoon', '3.00', 1, NULL, NULL, 81, 1, 8, '2019-09-03 03:51:36'),
(33, '2019-09-07', '2019-09-07', 1, 8, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 82, 1, 8, '2019-09-04 04:16:15'),
(34, '2019-09-05', '2019-09-05', 1, 9, '', 'Morning', 'Morning', '0.50', 5, NULL, NULL, 83, 1, 9, '2019-09-04 06:58:11'),
(34, '2019-09-05', '2019-09-05', 1, 9, '', 'Morning', 'Morning', '0.50', 1, 'null', NULL, 84, 2, 9, '2019-09-04 06:58:26'),
(35, '2019-09-05', '2019-09-06', 1, 9, '', 'Morning', 'Afternoon', '2.00', 6, NULL, NULL, 85, 1, 9, '2019-09-04 10:00:00'),
(34, '2019-09-05', '2019-09-09', 1, 9, '', 'Morning', 'Afternoon', '5.00', 1, 'null', NULL, 86, 2, 9, '2019-09-05 02:43:10'),
(35, '2019-09-05', '2019-09-06', 1, 9, '', 'Morning', 'Afternoon', '2.00', 6, NULL, NULL, 87, 3, 9, '2019-09-05 02:56:59'),
(34, '2019-09-05', '2019-09-08', 1, 9, '', 'Morning', 'Morning', '3.50', 1, 'null', NULL, 88, 2, 9, '2019-09-05 02:58:15'),
(34, '2019-09-05', '2019-09-08', 1, 9, '', 'Morning', 'Morning', '0.25', 1, 'null', NULL, 89, 2, 9, '2019-09-05 03:02:16'),
(34, '2019-09-05', '2019-09-08', 1, 9, '', 'Morning', 'Morning', '0.50', 1, 'null', NULL, 90, 2, 9, '2019-09-05 03:03:36'),
(33, '2019-09-07', '2019-09-07', 1, 8, '', 'Morning', 'Afternoon', '1.00', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"8\",\"value\":\"test\",\"date\":\"2019-9-9\"}]}', NULL, 91, 2, 8, '2019-09-09 02:28:51'),
(31, '2019-08-31', '2019-08-31', 2, 9, '', 'Morning', 'Morning', '0.50', 1, '{\"comments\":[{\"type\":\"change\",\"status_number\":\"2\",\"date\":\"2019-8-30\"},{\"type\":\"comment\",\"author\":\"9\",\"value\":\"test\",\"date\":\"2019-9-9\"}]}', NULL, 92, 2, 9, '2019-09-09 03:36:43'),
(32, '2019-08-28', '2019-08-30', 2, 8, '', 'Morning', 'Afternoon', '3.00', 1, '{\"comments\":[{\"type\":\"comment\",\"author\":\"8\",\"value\":\"my feedback\",\"date\":\"2019-9-9\"}]}', NULL, 93, 2, 8, '2019-09-09 03:38:13'),
(34, '2019-09-05', '2019-09-08', 1, 9, 'test', 'Morning', 'Morning', '0.50', 1, 'null', NULL, 94, 2, 9, '2019-09-09 03:40:31'),
(34, '2019-09-08', '2019-09-08', 1, 9, 'test', 'Morning', 'Morning', '0.50', 1, 'null', NULL, 95, 2, 9, '2019-09-09 07:18:16'),
(34, '2019-09-09', '2019-09-10', 1, 9, 'test', 'Morning', 'Afternoon', '2.00', 1, 'null', NULL, 96, 2, 9, '2019-09-09 07:19:12'),
(36, '2019-09-10', '2019-09-10', 1, 9, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 97, 1, 9, '2019-09-09 09:01:41'),
(37, '2019-09-20', '2019-09-20', 2, 9, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 98, 1, 9, '2019-09-18 04:48:21'),
(38, '2019-09-21', '2019-09-21', 1, 1, '', 'Morning', 'Afternoon', '1.00', 1, NULL, NULL, 99, 1, 1, '2019-09-18 08:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_applications`
--

CREATE TABLE `oauth_applications` (
  `user` int(11) NOT NULL COMMENT 'Identifier of Jorani user',
  `client_id` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identifier of an application using OAuth2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of allowed OAuth2 applications';

-- --------------------------------------------------------

--
-- Table structure for table `oauth_authorization_codes`
--

CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) DEFAULT NULL,
  `redirect_uri` varchar(2000) NOT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `user_id` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_jwt`
--

CREATE TABLE `oauth_jwt` (
  `client_id` varchar(80) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `scope` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `scope` text DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the department',
  `name` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Name of the department',
  `parent_id` int(11) DEFAULT NULL COMMENT 'Parent department (or -1 if root)',
  `supervisor` int(11) DEFAULT NULL COMMENT 'This user will receive a copy of accepted and rejected leave requests'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tree of the organization';

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `name`, `parent_id`, `supervisor`) VALUES
(1, 'LMS root', -1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `org_lists`
--

CREATE TABLE `org_lists` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of a list',
  `user` int(11) NOT NULL COMMENT ' Identifier of Jorani user owning the list',
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Custom lists of employees are an alternative to organization';

-- --------------------------------------------------------

--
-- Table structure for table `org_lists_employees`
--

CREATE TABLE `org_lists_employees` (
  `list` int(11) NOT NULL COMMENT 'Id of the list',
  `user` int(11) NOT NULL COMMENT 'id of an employee',
  `orderlist` int(11) NOT NULL COMMENT 'order in the list'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Children table of org_lists (custom list of employees)';

--
-- Dumping data for table `org_lists_employees`
--

INSERT INTO `org_lists_employees` (`list`, `user`, `orderlist`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the overtime request',
  `employee` int(11) NOT NULL COMMENT 'Employee requesting the OT',
  `date` date NOT NULL COMMENT 'Date when the OT was done',
  `duration` decimal(10,3) NOT NULL COMMENT 'Duration of the OT',
  `cause` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Reason why the OT was done',
  `status` int(11) NOT NULL COMMENT 'Status of OT (Planned, Requested, Accepted, Rejected)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Overtime worked (extra time)';

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employee`, `date`, `duration`, `cause`, `status`) VALUES
(8, 9, '2019-08-31', '2.000', 'tesr', 3);

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scope` int(11) NOT NULL COMMENT 'Either global(0) or user(1) scope',
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'PHP/serialize value',
  `entity_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Entity ID (eg. user id) to which the parameter is applied'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Application parameters';

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the position',
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the position',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Description of the position'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Position (job position) in the organization';

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `description`) VALUES
(1, 'Employee', 'Employee'),
(2, 'PM', 'Project Manager'),
(4, 'TL', 'team lead'),
(5, 'Junior', '');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Roles in the application (system table)' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'User'),
(8, 'HR Officier / Local HR Manager'),
(16, 'HR Manager'),
(25, 'Can access to HR functions'),
(32, 'General Manager'),
(64, 'Global Manager');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`) VALUES
(1, 'room 1'),
(13, 'room 3'),
(14, 'room 5'),
(15, 'room 4');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Status of the Leave Request (system table)';

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Planned'),
(2, 'Requested'),
(3, 'Accepted'),
(4, 'Rejected'),
(5, 'Cancellation'),
(6, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the type',
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the leave type',
  `acronym` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Acronym of the leave type',
  `deduct_days_off` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Deduct days off when computing the balance of the leave type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of leave types (LoV table)';

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `acronym`, `deduct_days_off`) VALUES
(1, 'paid leave', NULL, 0),
(2, 'maternity leave', NULL, 0),
(3, 'paternity leave', 'p', 0),
(4, 'special leave', NULL, 0),
(5, 'Sick leave', NULL, 0),
(6, 'compensate', 'c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Unique identifier of the user',
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'First name',
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Last name',
  `login` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Identfier used to login (can be an email address)',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email address',
  `password` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Password encrypted with BCRYPT or a similar method',
  `role` int(11) DEFAULT NULL COMMENT 'Role of the employee (binary mask). See table roles.',
  `manager` int(11) DEFAULT NULL COMMENT 'Employee validating the requests of the employee',
  `country` int(11) DEFAULT NULL COMMENT 'Country code (for later use)',
  `organization` int(11) DEFAULT 0 COMMENT 'Entity where the employee has a position',
  `contract` int(11) DEFAULT NULL COMMENT 'Contract of the employee',
  `position` int(11) DEFAULT NULL COMMENT 'Position of the employee',
  `datehired` date DEFAULT NULL COMMENT 'Date hired / Started',
  `identifier` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Internal/company identifier',
  `language` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'Language ISO code',
  `ldap_path` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'LDAP Path for complex authentication schemes',
  `active` tinyint(1) DEFAULT 1 COMMENT 'Is user active',
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Timezone of user',
  `calendar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'External Calendar address',
  `random_hash` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Obfuscate public URLs',
  `user_properties` text COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Entity ID (eg. user id) to which the parameter is applied',
  `picture` blob DEFAULT NULL COMMENT 'Profile picture of user for tabular calendar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='List of employees / users having access to Jorani' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `login`, `email`, `password`, `role`, `manager`, `country`, `organization`, `contract`, `position`, `datehired`, `identifier`, `language`, `ldap_path`, `active`, `timezone`, `calendar`, `random_hash`, `user_properties`, `picture`) VALUES
(0, 'Hr Manager', 'Manager', 'hrmanager', 'hrmanager@admin.com', '$2a$08$7eOLRXMAKeBmC6JC9S8.feQrqSUwN5ughbsCPg8plzPbJvt1.cI8W', 25, 1, NULL, 1, 1, 1, '2019-08-28', '', 'en', NULL, 0, 'Europe/Paris', NULL, 'Wp-JjGY8fadzwhxpldudxOo3', NULL, NULL),
(1, 'Admin', 'System', 'admin', 'admin@admin.com', '$2a$08$.RK0wUFvJQZeGK1TRkB7UuuZiuegyJPQvKpToQwokcNvx9Jn0P/j.', 25, 1, NULL, 1, 1, 1, '2019-06-27', 'TOOL0001', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, NULL, NULL, NULL),
(2, 'User', 'System', 'user', 'user@admin.com', '$2a$08$kNQ7R9i5hH1i2avQ9OyAn.saAPRt1SwpCz5qp5c6DDuajovQUVUGi', 2, 5, NULL, 1, 1, 1, '2019-08-28', 'TOOL0002', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'tlqMA6FU2BfrjSvCmc-0J6MN', NULL, NULL),
(3, 'HR', 'System', 'hr', 'hr@admin.com', '$2a$08$i5KC.pAg3JCqsN3.UxqG2uYoCfb26Vnpr7kklMUB3p6h6jhIErnGu', 25, 4, NULL, 1, 1, 1, '2019-08-28', 'TOOL0003', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 't1SAzeWiAS4bUEML_8HHppty', NULL, NULL),
(5, 'General', 'Manager', 'general', 'general@admin.com', '$2a$08$gWgtfbi33TVmm52vrv3koOufFAosx3queIAVO7MdTjIt1T3SeGobq', 32, 5, NULL, 1, 1, 2, '2019-08-28', '', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'mMjCOyFIz9UP_hIykxLaZORv', NULL, NULL),
(6, 'Global', 'Manager', 'global', 'global@admin.com', '$2a$08$X1ZAt3dufkmGWqgZokt4geMRkDJPEGuIt7HdmUPv5/pggl1CkbswG', 64, 6, NULL, 0, 1, NULL, '2019-08-28', '', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'K_i_sEjoU2HUisaeHA5C3chJ', NULL, NULL),
(7, 'Thanh', 'Bình', 'ltbinh', 'songviytuong@gmail.com', '$2a$08$MZmzVSRAYdM6Gis63qJ9H.954iH74bj7CrgSALsbrwry1F4OAyhS6', 2, 5, NULL, 1, 1, 1, '2019-08-28', '', 'en', NULL, 1, 'Asia/Hong_Kong', NULL, 'NuCcv7-0vPw9d7uriKVctuUM', NULL, NULL),
(8, 'tho', 'LE', 'thole', 'duy.tho@primelabo.com.vn', '$2a$08$/mqpeCdb.wmC3ViUDVE3BOosp4Ur4xQQSZ1E41TPxwMXE/TpteS7.', 25, 5, NULL, 1, 1, NULL, '2019-08-28', '027', 'en', NULL, 1, 'Europe/Paris', NULL, 'D0Me4MvFdJhB9HsTfXHNQS6f', NULL, NULL),
(9, 'Phan', 'DINH', 'pdinh', 'abc@gmail.com', '$2a$08$DdlNbHnyPExSTPd/O.wh8OBVie/YblNh7gmlaK1utPhbIYHQZRF4e', 2, 8, NULL, 1, 1, 1, '2018-11-30', '52', 'en', NULL, 1, 'Europe/Paris', NULL, 'a9pTRcWO_c_fOaVtFwGNUtTy', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`name`) USING BTREE;

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract_types`
--
ALTER TABLE `contract_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dayoffs`
--
ALTER TABLE `dayoffs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `contract` (`contract`);

--
-- Indexes for table `delegations`
--
ALTER TABLE `delegations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Indexes for table `entitleddays`
--
ALTER TABLE `entitleddays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract` (`contract`),
  ADD KEY `employee` (`employee`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excluded_types`
--
ALTER TABLE `excluded_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contract_id` (`contract_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `employee` (`employee`);

--
-- Indexes for table `leaves_history`
--
ALTER TABLE `leaves_history`
  ADD PRIMARY KEY (`change_id`),
  ADD KEY `changed_by` (`changed_by`),
  ADD KEY `change_date` (`change_date`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`access_token`);

--
-- Indexes for table `oauth_applications`
--
ALTER TABLE `oauth_applications`
  ADD KEY `user` (`user`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `oauth_authorization_codes`
--
ALTER TABLE `oauth_authorization_codes`
  ADD PRIMARY KEY (`authorization_code`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_jwt`
--
ALTER TABLE `oauth_jwt`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`refresh_token`);

--
-- Indexes for table `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `org_lists`
--
ALTER TABLE `org_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_lists_user` (`user`);

--
-- Indexes for table `org_lists_employees`
--
ALTER TABLE `org_lists_employees`
  ADD KEY `org_list_id` (`list`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `employee` (`employee`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD KEY `param_name` (`name`,`scope`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `manager` (`manager`) USING BTREE,
  ADD KEY `organization` (`organization`) USING BTREE,
  ADD KEY `contract` (`contract`) USING BTREE,
  ADD KEY `position` (`position`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of a contract', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contract_types`
--
ALTER TABLE `contract_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dayoffs`
--
ALTER TABLE `dayoffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delegations`
--
ALTER TABLE `delegations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id of delegation', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `entitleddays`
--
ALTER TABLE `entitleddays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of an entitlement', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `excluded_types`
--
ALTER TABLE `excluded_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id of exclusion';

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the leave request', AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `leaves_history`
--
ALTER TABLE `leaves_history`
  MODIFY `change_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the department', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `org_lists`
--
ALTER TABLE `org_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of a list', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the overtime request', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the position', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the type', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the user', AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
