/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 100130
 Source Host           : localhost:3306
 Source Schema         : jorani

 Target Server Type    : MySQL
 Target Server Version : 100130
 File Encoding         : 65001

 Date: 26/08/2019 15:11:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for actions
-- ----------------------------
DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions`  (
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mask` bit(16) NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'List of possible actions' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of actions
-- ----------------------------
INSERT INTO `actions` VALUES ('accept_requests', b'0011000100110010', 'Accept the request of my team members');
INSERT INTO `actions` VALUES ('admin_menu', b'0011000100110010', 'View admin menu');
INSERT INTO `actions` VALUES ('change_password', b'0011000100110010', 'Change password');
INSERT INTO `actions` VALUES ('create_leaves', b'0011000100110010', 'Create a new user leave request');
INSERT INTO `actions` VALUES ('create_user', b'0011000100110010', 'Create a new user');
INSERT INTO `actions` VALUES ('delete_user', b'0011000100110010', 'Delete an existing user');
INSERT INTO `actions` VALUES ('edit_leaves', b'0011000100110010', 'Edit a leave request');
INSERT INTO `actions` VALUES ('edit_settings', b'0011000100110010', 'Edit application settings');
INSERT INTO `actions` VALUES ('edit_user', b'0011000100110010', 'Edit a user');
INSERT INTO `actions` VALUES ('export_leaves', b'0011000100110010', 'Export the list of leave requests into an Excel file');
INSERT INTO `actions` VALUES ('export_user', b'0011000100110010', 'Export the list of users into an Excel file');
INSERT INTO `actions` VALUES ('hr_menu', b'0011000100110010', 'View HR menu');
INSERT INTO `actions` VALUES ('individual_calendar', b'0011000100110010', 'View my leaves in a calendar');
INSERT INTO `actions` VALUES ('list_leaves', b'0011000100110010', 'List my leave requests');
INSERT INTO `actions` VALUES ('list_requests', b'0011000100110010', 'List the request of my team members');
INSERT INTO `actions` VALUES ('list_users', b'0011000100110010', 'List users');
INSERT INTO `actions` VALUES ('reject_requests', b'0011000100110010', 'Reject the request of my team members');
INSERT INTO `actions` VALUES ('reset_password', b'0011000100110010', 'Modifiy the password of another user');
INSERT INTO `actions` VALUES ('team_calendar', b'0011000100110010', 'View the leaves of my team in a calendar');
INSERT INTO `actions` VALUES ('update_user', b'0011000100110010', 'Update a user');
INSERT INTO `actions` VALUES ('view_leaves', b'0011000100110010', 'View the details of a leave request');
INSERT INTO `actions` VALUES ('view_user', b'0011000100110010', 'View user\'s details');

-- ----------------------------
-- Table structure for ci_sessions
-- ----------------------------
DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions`  (
  `id` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  INDEX `ci_sessions_timestamp`(`timestamp`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'CodeIgniter sessions (you can empty this table without consequence)' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ci_sessions
-- ----------------------------
INSERT INTO `ci_sessions` VALUES ('cg8ag6shc4qothm72otk7kuudm8hgvh0', '::1', 1566806520, 0x5F5F63695F6C6173745F726567656E65726174657C693A313536363830363532303B6C616E67756167655F636F64657C733A323A22656E223B6C616E67756167657C733A373A22656E676C697368223B73616C747C733A31323A226441484E4741516A46513D3D223B6C6F67696E7C733A363A226262616C6574223B69647C733A313A2231223B66697273746E616D657C733A383A2242656E6A616D696E223B6C6173746E616D657C733A353A2242414C4554223B69735F6D616E616765727C623A313B69735F61646D696E7C623A303B69735F68727C623A313B6D616E616765727C733A313A2231223B72616E646F6D5F686173687C4E3B6C6F676765645F696E7C623A313B6C6173745F706167657C733A33383A22687474703A2F2F6C6F63616C686F73743A383838385C2F75736572732F6D7970726F66696C65223B6C6173745F706167655F706172616D737C733A303A22223B);
INSERT INTO `ci_sessions` VALUES ('mni6rh2mdcp0mgad8gfrsu2jkvn947mq', '127.0.0.1', 1566806318, 0x5F5F63695F6C6173745F726567656E65726174657C693A313536363830363331383B6C6173745F706167657C733A32313A22687474703A2F2F6A6F72616E692E6C6F63616C5C2F223B6C6173745F706167655F706172616D737C733A303A22223B6C616E67756167655F636F64657C733A323A22656E223B6C616E67756167657C733A373A22656E676C697368223B73616C747C733A31363A223163346F52705542706C73514B57307A223B);
INSERT INTO `ci_sessions` VALUES ('tte7nkk6b1qtgtkr39vj47ra97ig3tk0', '::1', 1566806887, 0x5F5F63695F6C6173745F726567656E65726174657C693A313536363830363838373B6C616E67756167655F636F64657C733A323A22656E223B6C616E67756167657C733A373A22656E676C697368223B73616C747C733A31323A226441484E4741516A46513D3D223B6C6F67696E7C733A363A226262616C6574223B69647C733A313A2231223B66697273746E616D657C733A383A2242656E6A616D696E223B6C6173746E616D657C733A353A2242414C4554223B69735F6D616E616765727C623A313B69735F61646D696E7C623A303B69735F68727C623A313B6D616E616765727C733A313A2231223B72616E646F6D5F686173687C4E3B6C6F676765645F696E7C623A313B6C6173745F706167657C733A33383A22687474703A2F2F6C6F63616C686F73743A383838385C2F75736572732F6D7970726F66696C65223B6C6173745F706167655F706172616D737C733A303A22223B);
INSERT INTO `ci_sessions` VALUES ('bjm1o9jehgap27t3brq3avbve9bm3641', '::1', 1566806952, 0x5F5F63695F6C6173745F726567656E65726174657C693A313536363830363838373B6C616E67756167655F636F64657C733A323A22656E223B6C616E67756167657C733A373A22656E676C697368223B73616C747C733A31323A226441484E4741516A46513D3D223B6C6F67696E7C733A363A226262616C6574223B69647C733A313A2231223B66697273746E616D657C733A383A2242656E6A616D696E223B6C6173746E616D657C733A353A2242414C4554223B69735F6D616E616765727C623A313B69735F61646D696E7C623A303B69735F68727C623A313B6D616E616765727C733A313A2231223B72616E646F6D5F686173687C4E3B6C6F676765645F696E7C623A313B6C6173745F706167657C733A33363A22687474703A2F2F6C6F63616C686F73743A383838385C2F636F6E74726163747479706573223B6C6173745F706167655F706172616D737C733A303A22223B);
INSERT INTO `ci_sessions` VALUES ('o3suphhkofefcpb31o9jt1lcpnpnrc24', '127.0.0.1', 1566807054, 0x5F5F63695F6C6173745F726567656E65726174657C693A313536363830373034373B6C6173745F706167657C733A32313A22687474703A2F2F6A6F72616E692E6C6F63616C5C2F223B6C6173745F706167655F706172616D737C733A303A22223B6C616E67756167655F636F64657C733A323A22656E223B6C616E67756167657C733A373A22656E676C697368223B73616C747C733A31323A22784E5A774F3165717241794F223B6C6F67696E7C733A363A226262616C6574223B69647C733A313A2231223B66697273746E616D657C733A383A2242656E6A616D696E223B6C6173746E616D657C733A353A2242414C4554223B69735F6D616E616765727C623A313B69735F61646D696E7C623A303B69735F68727C623A313B6D616E616765727C733A313A2231223B72616E646F6D5F686173687C4E3B6C6F676765645F696E7C623A313B);

-- ----------------------------
-- Table structure for contract_types
-- ----------------------------
DROP TABLE IF EXISTS `contract_types`;
CREATE TABLE `contract_types`  (
  `id` int(11) NOT NULL,
  `name` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contract_types
-- ----------------------------
INSERT INTO `contract_types` VALUES (1, 'fulltime', 'Full Time');
INSERT INTO `contract_types` VALUES (2, 'parttime', 'Part Time');

-- ----------------------------
-- Table structure for contracts
-- ----------------------------
DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of a contract',
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the contract',
  `startentdate` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Day and month numbers of the left boundary',
  `endentdate` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Day and month numbers of the right boundary',
  `weekly_duration` int(11) NULL DEFAULT NULL COMMENT 'Approximate duration of work per week (in minutes)',
  `daily_duration` int(11) NULL DEFAULT NULL COMMENT 'Approximate duration of work per day and (in minutes)',
  `default_leave_type` int(11) NULL DEFAULT NULL COMMENT 'default leave type for the contract (overwrite default type set in config file).',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'A contract groups employees having the same days off and entitlement rules' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of contracts
-- ----------------------------
INSERT INTO `contracts` VALUES (1, 'Global', '01/01', '12/31', 2400, 480, 1);

-- ----------------------------
-- Table structure for dayoffs
-- ----------------------------
DROP TABLE IF EXISTS `dayoffs`;
CREATE TABLE `dayoffs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contract` int(11) NOT NULL COMMENT 'Contract id',
  `date` date NOT NULL COMMENT 'Date of the day off',
  `type` int(11) NOT NULL COMMENT 'Half or full day',
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Description of day off',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `type`(`type`) USING BTREE,
  INDEX `contract`(`contract`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'List of non working days' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for delegations
-- ----------------------------
DROP TABLE IF EXISTS `delegations`;
CREATE TABLE `delegations`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id of delegation',
  `manager_id` int(11) NOT NULL COMMENT 'Manager wanting to delegate',
  `delegate_id` int(11) NOT NULL COMMENT 'Employee having the delegation',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `manager_id`(`manager_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Delegation of approval' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for entitleddays
-- ----------------------------
DROP TABLE IF EXISTS `entitleddays`;
CREATE TABLE `entitleddays`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of an entitlement',
  `contract` int(11) NULL DEFAULT NULL COMMENT 'If entitlement is credited to a contract, Id of contract',
  `employee` int(11) NULL DEFAULT NULL COMMENT 'If entitlement is credited to an employee, Id of employee',
  `overtime` int(11) NULL DEFAULT NULL COMMENT 'Optional Link to an overtime request, if the credit is due to an OT',
  `startdate` date NULL DEFAULT NULL COMMENT 'Left boundary of the credit validity',
  `enddate` date NULL DEFAULT NULL COMMENT 'Right boundary of the credit validity. Duration cannot exceed one year',
  `type` int(11) NOT NULL COMMENT 'Leave type',
  `days` decimal(10, 2) NOT NULL COMMENT 'Number of days (can be negative so as to deduct/adjust entitlement)',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Description of a credit / debit (entitlement / adjustment)',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract`(`contract`) USING BTREE,
  INDEX `employee`(`employee`) USING BTREE,
  INDEX `type`(`type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Add or substract entitlement on employees or contracts (can be the result of an OT)' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for excluded_types
-- ----------------------------
DROP TABLE IF EXISTS `excluded_types`;
CREATE TABLE `excluded_types`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id of exclusion',
  `contract_id` int(11) NOT NULL COMMENT 'Id of contract',
  `type_id` int(11) NOT NULL COMMENT 'Id of leave ype to be excluded to the contract',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contract_id`(`contract_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Exclude a leave type from a contract' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for leaves
-- ----------------------------
DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the leave request',
  `startdate` date NULL DEFAULT NULL COMMENT 'Start date of the leave request',
  `enddate` date NULL DEFAULT NULL COMMENT 'End date of the leave request',
  `status` int(11) NULL DEFAULT NULL COMMENT 'Identifier of the status of the leave request (Requested, Accepted, etc.). See status table.',
  `employee` int(11) NULL DEFAULT NULL COMMENT 'Employee requesting the leave request',
  `cause` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Reason of the leave request',
  `startdatetype` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Morning/Afternoon',
  `enddatetype` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Morning/Afternoon',
  `duration` decimal(10, 3) NULL DEFAULT NULL COMMENT 'Length of the leave request',
  `type` int(11) NULL DEFAULT NULL COMMENT 'Identifier of the type of the leave request (Paid, Sick, etc.). See type table.',
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Comments on leave request (JSon)',
  `document` blob NULL COMMENT 'Optional supporting document',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `employee`(`employee`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Leave requests' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for leaves_history
-- ----------------------------
DROP TABLE IF EXISTS `leaves_history`;
CREATE TABLE `leaves_history`  (
  `id` int(11) NOT NULL,
  `startdate` date NULL DEFAULT NULL,
  `enddate` date NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `employee` int(11) NULL DEFAULT NULL,
  `cause` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `startdatetype` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `enddatetype` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `duration` decimal(10, 2) NULL DEFAULT NULL,
  `type` int(11) NULL DEFAULT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Comments on leave request',
  `document` blob NULL COMMENT 'Optional supporting document',
  `change_id` int(11) NOT NULL AUTO_INCREMENT,
  `change_type` int(11) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `change_date` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`change_id`) USING BTREE,
  INDEX `changed_by`(`changed_by`) USING BTREE,
  INDEX `change_date`(`change_date`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'List of changes in leave requests table' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens`  (
  `access_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expires` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`access_token`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_applications
-- ----------------------------
DROP TABLE IF EXISTS `oauth_applications`;
CREATE TABLE `oauth_applications`  (
  `user` int(11) NOT NULL COMMENT 'Identifier of Jorani user',
  `client_id` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identifier of an application using OAuth2',
  INDEX `user`(`user`) USING BTREE,
  INDEX `client_id`(`client_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'List of allowed OAuth2 applications' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_authorization_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_authorization_codes`;
CREATE TABLE `oauth_authorization_codes`  (
  `authorization_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `redirect_uri` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expires` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`authorization_code`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients`  (
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_secret` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `redirect_uri` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `grant_types` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `scope` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_jwt
-- ----------------------------
DROP TABLE IF EXISTS `oauth_jwt`;
CREATE TABLE `oauth_jwt`  (
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `subject` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `public_key` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`client_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens`  (
  `refresh_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `expires` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`refresh_token`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_scopes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_scopes`;
CREATE TABLE `oauth_scopes`  (
  `scope` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `is_default` tinyint(1) NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for oauth_users
-- ----------------------------
DROP TABLE IF EXISTS `oauth_users`;
CREATE TABLE `oauth_users`  (
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for org_lists
-- ----------------------------
DROP TABLE IF EXISTS `org_lists`;
CREATE TABLE `org_lists`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of a list',
  `user` int(11) NOT NULL COMMENT ' Identifier of Jorani user owning the list',
  `name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `org_lists_user`(`user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Custom lists of employees are an alternative to organization' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for org_lists_employees
-- ----------------------------
DROP TABLE IF EXISTS `org_lists_employees`;
CREATE TABLE `org_lists_employees`  (
  `list` int(11) NOT NULL COMMENT 'Id of the list',
  `user` int(11) NOT NULL COMMENT 'id of an employee',
  `orderlist` int(11) NOT NULL COMMENT 'order in the list',
  INDEX `org_list_id`(`list`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Children table of org_lists (custom list of employees)' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for organization
-- ----------------------------
DROP TABLE IF EXISTS `organization`;
CREATE TABLE `organization`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the department',
  `name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Name of the department',
  `parent_id` int(11) NULL DEFAULT NULL COMMENT 'Parent department (or -1 if root)',
  `supervisor` int(11) NULL DEFAULT NULL COMMENT 'This user will receive a copy of accepted and rejected leave requests',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Tree of the organization' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of organization
-- ----------------------------
INSERT INTO `organization` VALUES (0, 'LMS root', -1, NULL);

-- ----------------------------
-- Table structure for overtime
-- ----------------------------
DROP TABLE IF EXISTS `overtime`;
CREATE TABLE `overtime`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the overtime request',
  `employee` int(11) NOT NULL COMMENT 'Employee requesting the OT',
  `date` date NOT NULL COMMENT 'Date when the OT was done',
  `duration` decimal(10, 3) NOT NULL COMMENT 'Duration of the OT',
  `cause` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Reason why the OT was done',
  `status` int(11) NOT NULL COMMENT 'Status of OT (Planned, Requested, Accepted, Rejected)',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `employee`(`employee`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Overtime worked (extra time)' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for parameters
-- ----------------------------
DROP TABLE IF EXISTS `parameters`;
CREATE TABLE `parameters`  (
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `scope` int(11) NOT NULL COMMENT 'Either global(0) or user(1) scope',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'PHP/serialize value',
  `entity_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Entity ID (eg. user id) to which the parameter is applied',
  INDEX `param_name`(`name`, `scope`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Application parameters' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for positions
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the position',
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the position',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Description of the position',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Position (job position) in the organization' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES (1, 'Employee', 'Employee.');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Roles in the application (system table)' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'admin');
INSERT INTO `roles` VALUES (2, 'user');
INSERT INTO `roles` VALUES (8, 'HR admin');

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status`  (
  `id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'Status of the Leave Request (system table)' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES (1, 'Planned');
INSERT INTO `status` VALUES (2, 'Requested');
INSERT INTO `status` VALUES (3, 'Accepted');
INSERT INTO `status` VALUES (4, 'Rejected');
INSERT INTO `status` VALUES (5, 'Cancellation');
INSERT INTO `status` VALUES (6, 'Canceled');

-- ----------------------------
-- Table structure for types
-- ----------------------------
DROP TABLE IF EXISTS `types`;
CREATE TABLE `types`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the type',
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Name of the leave type',
  `acronym` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Acronym of the leave type',
  `deduct_days_off` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Deduct days off when computing the balance of the leave type',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'List of leave types (LoV table)' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of types
-- ----------------------------
INSERT INTO `types` VALUES (0, 'compensate', NULL, 0);
INSERT INTO `types` VALUES (1, 'paid leave', NULL, 0);
INSERT INTO `types` VALUES (2, 'maternity leave', NULL, 0);
INSERT INTO `types` VALUES (3, 'paternity leave', NULL, 0);
INSERT INTO `types` VALUES (4, 'special leave', NULL, 0);
INSERT INTO `types` VALUES (5, 'Sick leave', NULL, 0);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier of the user',
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'First name',
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Last name',
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Identfier used to login (can be an email address)',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Email address',
  `password` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Password encrypted with BCRYPT or a similar method',
  `role` int(11) NULL DEFAULT NULL COMMENT 'Role of the employee (binary mask). See table roles.',
  `manager` int(11) NULL DEFAULT NULL COMMENT 'Employee validating the requests of the employee',
  `country` int(11) NULL DEFAULT NULL COMMENT 'Country code (for later use)',
  `organization` int(11) NULL DEFAULT 0 COMMENT 'Entity where the employee has a position',
  `contract` int(11) NULL DEFAULT NULL COMMENT 'Contract of the employee',
  `position` int(11) NULL DEFAULT NULL COMMENT 'Position of the employee',
  `datehired` date NULL DEFAULT NULL COMMENT 'Date hired / Started',
  `identifier` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Internal/company identifier',
  `language` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en' COMMENT 'Language ISO code',
  `ldap_path` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'LDAP Path for complex authentication schemes',
  `active` tinyint(1) NULL DEFAULT 1 COMMENT 'Is user active',
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Timezone of user',
  `calendar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'External Calendar address',
  `random_hash` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'Obfuscate public URLs',
  `user_properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT 'Entity ID (eg. user id) to which the parameter is applied',
  `picture` blob NULL COMMENT 'Profile picture of user for tabular calendar',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `manager`(`manager`) USING BTREE,
  INDEX `organization`(`organization`) USING BTREE,
  INDEX `contract`(`contract`) USING BTREE,
  INDEX `position`(`position`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'List of employees / users having access to Jorani' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Benjamin', 'BALET', 'bbalet', 'benjamin.balet@gmail.com', '$2a$08$LeUbaGFqJjLSAN7to9URsuHB41zcmsMBgBhpZuFp2y2OTxtVcMQ.C', 8, 1, NULL, 0, 1, 1, '2013-10-28', 'PNC0025', 'en', NULL, 1, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Function structure for GetAcronym
-- ----------------------------
DROP FUNCTION IF EXISTS `GetAcronym`;
delimiter ;;
CREATE FUNCTION `GetAcronym`(str text)
 RETURNS text CHARSET utf8
  READS SQL DATA 
  SQL SECURITY INVOKER
BEGIN
    declare result text default '';
    set result = GetInitials( str, '[[:alnum:]]' );
    return result;
END
;;
delimiter ;

-- ----------------------------
-- Function structure for GetAncestry
-- ----------------------------
DROP FUNCTION IF EXISTS `GetAncestry`;
delimiter ;;
CREATE FUNCTION `GetAncestry`(GivenID INT)
 RETURNS varchar(1024) CHARSET utf8
  READS SQL DATA 
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
END
;;
delimiter ;

-- ----------------------------
-- Function structure for GetFamilyTree
-- ----------------------------
DROP FUNCTION IF EXISTS `GetFamilyTree`;
delimiter ;;
CREATE FUNCTION `GetFamilyTree`(`GivenID` INT)
 RETURNS varchar(1024) CHARSET utf8
  READS SQL DATA 
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
END
;;
delimiter ;

-- ----------------------------
-- Function structure for GetInitials
-- ----------------------------
DROP FUNCTION IF EXISTS `GetInitials`;
delimiter ;;
CREATE FUNCTION `GetInitials`(str text, expr text)
 RETURNS text CHARSET utf8
  READS SQL DATA 
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
END
;;
delimiter ;

-- ----------------------------
-- Function structure for GetParentIDByID
-- ----------------------------
DROP FUNCTION IF EXISTS `GetParentIDByID`;
delimiter ;;
CREATE FUNCTION `GetParentIDByID`(GivenID INT)
 RETURNS int(11)
  READS SQL DATA 
  SQL SECURITY INVOKER
BEGIN
    DECLARE rv INT;

    SELECT IFNULL(parent_id,-1) INTO rv FROM
    (SELECT parent_id FROM organization WHERE id = GivenID) A;
    RETURN rv;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
