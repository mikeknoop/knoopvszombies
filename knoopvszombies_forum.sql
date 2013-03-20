-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 19, 2013 at 07:46 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `muzombies_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Activity`
--

CREATE TABLE IF NOT EXISTS `GDN_Activity` (
  `ActivityID` int(11) NOT NULL AUTO_INCREMENT,
  `CommentActivityID` int(11) DEFAULT NULL,
  `ActivityTypeID` int(11) NOT NULL,
  `ActivityUserID` int(11) DEFAULT NULL,
  `RegardingUserID` int(11) DEFAULT NULL,
  `Story` text COLLATE utf8_unicode_ci,
  `Route` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  PRIMARY KEY (`ActivityID`),
  KEY `FK_Activity_CommentActivityID` (`CommentActivityID`),
  KEY `FK_Activity_ActivityUserID` (`ActivityUserID`),
  KEY `FK_Activity_InsertUserID` (`InsertUserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=966 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_ActivityType`
--

CREATE TABLE IF NOT EXISTS `GDN_ActivityType` (
  `ActivityTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `AllowComments` tinyint(4) NOT NULL DEFAULT '0',
  `ShowIcon` tinyint(4) NOT NULL DEFAULT '0',
  `ProfileHeadline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FullHeadline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `RouteCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Notify` tinyint(4) NOT NULL DEFAULT '0',
  `Public` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ActivityTypeID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Category`
--

CREATE TABLE IF NOT EXISTS `GDN_Category` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `ParentCategoryID` int(11) DEFAULT NULL,
  `CountDiscussions` int(11) NOT NULL DEFAULT '0',
  `AllowDiscussions` tinyint(4) NOT NULL DEFAULT '1',
  `Name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `UrlCode` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime NOT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `FK_Category_InsertUserID` (`InsertUserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Comment`
--

CREATE TABLE IF NOT EXISTS `GDN_Comment` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `DiscussionID` int(11) NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `DeleteUserID` int(11) DEFAULT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime DEFAULT NULL,
  `DateDeleted` datetime DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `Flag` tinyint(4) NOT NULL DEFAULT '0',
  `Score` float DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`CommentID`),
  KEY `FK_Comment_DiscussionID` (`DiscussionID`),
  KEY `FK_Comment_InsertUserID` (`InsertUserID`),
  KEY `FK_Comment_DateInserted` (`DateInserted`),
  FULLTEXT KEY `TX_Comment` (`Body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=947 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Conversation`
--

CREATE TABLE IF NOT EXISTS `GDN_Conversation` (
  `ConversationID` int(11) NOT NULL AUTO_INCREMENT,
  `Contributors` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FirstMessageID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime DEFAULT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `CountMessages` int(11) NOT NULL,
  `LastMessageID` int(11) NOT NULL,
  PRIMARY KEY (`ConversationID`),
  KEY `FK_Conversation_FirstMessageID` (`FirstMessageID`),
  KEY `FK_Conversation_InsertUserID` (`InsertUserID`),
  KEY `FK_Conversation_DateInserted` (`DateInserted`),
  KEY `FK_Conversation_UpdateUserID` (`UpdateUserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_ConversationMessage`
--

CREATE TABLE IF NOT EXISTS `GDN_ConversationMessage` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `ConversationID` int(11) NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  PRIMARY KEY (`MessageID`),
  KEY `FK_ConversationMessage_ConversationID` (`ConversationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Discussion`
--

CREATE TABLE IF NOT EXISTS `GDN_Discussion` (
  `DiscussionID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(11) NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `LastCommentID` int(11) DEFAULT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CountComments` int(11) NOT NULL DEFAULT '1',
  `CountBookmarks` int(11) DEFAULT NULL,
  `CountViews` int(11) NOT NULL DEFAULT '1',
  `Closed` tinyint(4) NOT NULL DEFAULT '0',
  `Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Sink` tinyint(4) NOT NULL DEFAULT '0',
  `DateInserted` datetime DEFAULT NULL,
  `DateUpdated` datetime NOT NULL,
  `DateLastComment` datetime DEFAULT NULL,
  `LastCommentUserID` int(11) DEFAULT NULL,
  `Score` float DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`DiscussionID`),
  KEY `FK_Discussion_CategoryID` (`CategoryID`),
  KEY `FK_Discussion_InsertUserID` (`InsertUserID`),
  KEY `IX_Discussion_DateLastComment` (`DateLastComment`),
  FULLTEXT KEY `TX_Discussion` (`Name`,`Body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Draft`
--

CREATE TABLE IF NOT EXISTS `GDN_Draft` (
  `DraftID` int(11) NOT NULL AUTO_INCREMENT,
  `DiscussionID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Closed` tinyint(4) NOT NULL DEFAULT '0',
  `Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Sink` tinyint(4) NOT NULL DEFAULT '0',
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`DraftID`),
  KEY `FK_Draft_DiscussionID` (`DiscussionID`),
  KEY `FK_Draft_CategoryID` (`CategoryID`),
  KEY `FK_Draft_InsertUserID` (`InsertUserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=436 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Invitation`
--

CREATE TABLE IF NOT EXISTS `GDN_Invitation` (
  `InvitationID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `AcceptedUserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`InvitationID`),
  KEY `FK_Invitation_InsertUserID` (`InsertUserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Message`
--

CREATE TABLE IF NOT EXISTS `GDN_Message` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AllowDismiss` tinyint(4) NOT NULL DEFAULT '1',
  `Enabled` tinyint(4) NOT NULL DEFAULT '1',
  `Application` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AssetTarget` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CssClass` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`MessageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Permission`
--

CREATE TABLE IF NOT EXISTS `GDN_Permission` (
  `PermissionID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleID` int(11) NOT NULL DEFAULT '0',
  `JunctionTable` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `JunctionColumn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `JunctionID` int(11) DEFAULT NULL,
  `Garden.Email.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Settings.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Routes.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Messages.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Applications.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Plugins.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Themes.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.SignIn.Allow` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Registration.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Applicants.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Roles.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Activity.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Activity.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Profiles.View` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Settings.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Categories.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Spam.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.View` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Sink` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Close` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Plugins.Poll.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Plugins.Poll.View` tinyint(4) NOT NULL DEFAULT '0',
  `Plugins.Poll.Delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PermissionID`),
  KEY `FK_Permission_RoleID` (`RoleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=89 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Photo`
--

CREATE TABLE IF NOT EXISTS `GDN_Photo` (
  `PhotoID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  PRIMARY KEY (`PhotoID`),
  KEY `FK_Photo_InsertUserID` (`InsertUserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Poll`
--

CREATE TABLE IF NOT EXISTS `GDN_Poll` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discussion_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_PollAnswers`
--

CREATE TABLE IF NOT EXISTS `GDN_PollAnswers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_PollRecords`
--

CREATE TABLE IF NOT EXISTS `GDN_PollRecords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Role`
--

CREATE TABLE IF NOT EXISTS `GDN_Role` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  `Deletable` tinyint(4) NOT NULL DEFAULT '1',
  `CanSession` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`RoleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_Tag`
--

CREATE TABLE IF NOT EXISTS `GDN_Tag` (
  `TagID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unique',
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `CountDiscussions` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagID`),
  KEY `FK_Tag_InsertUserID` (`InsertUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_TagDiscussion`
--

CREATE TABLE IF NOT EXISTS `GDN_TagDiscussion` (
  `TagID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  PRIMARY KEY (`TagID`,`DiscussionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_User`
--

CREATE TABLE IF NOT EXISTS `GDN_User` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HashMethod` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `About` text COLLATE utf8_unicode_ci,
  `Email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ShowEmail` tinyint(4) NOT NULL DEFAULT '0',
  `Gender` enum('m','f') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'm',
  `CountVisits` int(11) NOT NULL DEFAULT '0',
  `CountInvitations` int(11) NOT NULL DEFAULT '0',
  `CountNotifications` int(11) DEFAULT NULL,
  `InviteUserID` int(11) DEFAULT NULL,
  `DiscoveryText` text COLLATE utf8_unicode_ci,
  `Preferences` text COLLATE utf8_unicode_ci,
  `Permissions` text COLLATE utf8_unicode_ci,
  `Attributes` text COLLATE utf8_unicode_ci,
  `DateSetInvitations` datetime DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `DateFirstVisit` datetime DEFAULT NULL,
  `DateLastActive` datetime DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `HourOffset` int(11) NOT NULL DEFAULT '0',
  `Score` float DEFAULT NULL,
  `Admin` tinyint(4) NOT NULL DEFAULT '0',
  `Deleted` tinyint(4) NOT NULL DEFAULT '0',
  `CountUnreadConversations` int(11) DEFAULT NULL,
  `CountDiscussions` int(11) DEFAULT NULL,
  `CountUnreadDiscussions` int(11) DEFAULT NULL,
  `CountComments` int(11) DEFAULT NULL,
  `CountDrafts` int(11) DEFAULT NULL,
  `CountBookmarks` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `FK_User_Name` (`Name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2240 ;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserAuthentication`
--

CREATE TABLE IF NOT EXISTS `GDN_UserAuthentication` (
  `ForeignUserKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ProviderKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ForeignUserKey`,`ProviderKey`),
  KEY `FK_UserAuthentication_UserID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserAuthenticationNonce`
--

CREATE TABLE IF NOT EXISTS `GDN_UserAuthenticationNonce` (
  `Nonce` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Nonce`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserAuthenticationProvider`
--

CREATE TABLE IF NOT EXISTS `GDN_UserAuthenticationProvider` (
  `AuthenticationKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `AuthenticationSchemeAlias` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `URL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AssociationSecret` text COLLATE utf8_unicode_ci NOT NULL,
  `AssociationHashMethod` enum('HMAC-SHA1','HMAC-PLAINTEXT') COLLATE utf8_unicode_ci NOT NULL,
  `AuthenticateUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RegisterUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SignInUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SignOutUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PasswordUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProfileUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`AuthenticationKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserAuthenticationToken`
--

CREATE TABLE IF NOT EXISTS `GDN_UserAuthenticationToken` (
  `Token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ProviderKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignUserKey` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TokenSecret` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `TokenType` enum('request','access') COLLATE utf8_unicode_ci NOT NULL,
  `Authorized` tinyint(4) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Lifetime` int(11) NOT NULL,
  PRIMARY KEY (`Token`,`ProviderKey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserComment`
--

CREATE TABLE IF NOT EXISTS `GDN_UserComment` (
  `UserID` int(11) NOT NULL,
  `CommentID` int(11) NOT NULL,
  `Score` float DEFAULT NULL,
  `DateLastViewed` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`,`CommentID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserConversation`
--

CREATE TABLE IF NOT EXISTS `GDN_UserConversation` (
  `UserID` int(11) NOT NULL,
  `ConversationID` int(11) NOT NULL,
  `CountReadMessages` int(11) NOT NULL DEFAULT '0',
  `LastMessageID` int(11) DEFAULT NULL,
  `DateLastViewed` datetime DEFAULT NULL,
  `DateCleared` datetime DEFAULT NULL,
  `Bookmarked` tinyint(4) NOT NULL DEFAULT '0',
  `Deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`ConversationID`),
  KEY `FK_UserConversation_LastMessageID` (`LastMessageID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserDiscussion`
--

CREATE TABLE IF NOT EXISTS `GDN_UserDiscussion` (
  `UserID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  `Score` float DEFAULT NULL,
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `DateLastViewed` datetime DEFAULT NULL,
  `Dismissed` tinyint(4) NOT NULL DEFAULT '0',
  `Bookmarked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`DiscussionID`),
  KEY `FK_UserDiscussion_DiscussionID` (`DiscussionID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserMeta`
--

CREATE TABLE IF NOT EXISTS `GDN_UserMeta` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`UserID`,`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GDN_UserRole`
--

CREATE TABLE IF NOT EXISTS `GDN_UserRole` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`RoleID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
