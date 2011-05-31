<?php if (!defined('APPLICATION')) exit();

// Conversations
$Configuration['Conversations']['Version'] = '2.0.16';

// Database
$Configuration['Database']['Name'] = FORUM_DATABASE;
$Configuration['Database']['Host'] = 'localhost';
$Configuration['Database']['User'] = 'web';
$Configuration['Database']['Password'] = 'ap1be4t1fa80adfa4';

// EnabledApplications
$Configuration['EnabledApplications']['Skeleton'] = 'skeleton';
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledPlugins
$Configuration['EnabledPlugins']['GettingStarted'] = 'GettingStarted';
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['embedvanilla'] = 'embedvanilla';
$Configuration['EnabledPlugins']['Poll'] = 'Poll';

// Garden
$Configuration['Garden']['Title'] = 'Mizzou Humans vs. Zombies';
$Configuration['Garden']['Cookie']['Salt'] = 'ZUZXZ1UHSX';
$Configuration['Garden']['Cookie']['Domain'] = 'http://'.DOMAIN.'/';
$Configuration['Garden']['Version'] = '2.0.16';
$Configuration['Garden']['RewriteUrls'] = TRUE;
$Configuration['Garden']['CanProcessImages'] = TRUE;
$Configuration['Garden']['Installed'] = TRUE;
$Configuration['Garden']['Errors']['MasterView'] = 'error.master.php';
$Configuration['Garden']['RequiredUpdates'] = 'a:0:{}';
$Configuration['Garden']['UpdateCheckDate'] = 1296504566;
$Configuration['Garden']['Theme'] = 'default';
$Configuration['Garden']['Registration']['DefaultRoles'] = 'a:1:{i:0;s:1:"8";}';
$Configuration['Garden']['Registration']['ApplicantRoleID'] = '';

// Modules
$Configuration['Modules']['Vanilla']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';
$Configuration['Modules']['Conversations']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Discussion'] = '1';
$Configuration['Plugins']['GettingStarted']['Profile'] = '1';
$Configuration['Plugins']['EmbedVanilla']['RemoteUrl'] = 'http://'.DOMAIN.'/forums/';
$Configuration['Plugins']['EmbedVanilla']['ForceRemoteUrl'] = FALSE;
$Configuration['Plugins']['EmbedVanilla']['EmbedDashboard'] = FALSE;

// Routes
$Configuration['Routes']['DefaultController'] = 'discussions';

// Skeleton
$Configuration['Skeleton']['Version'] = '1.0';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.0.16';
$Configuration['Vanilla']['Categories']['Use'] = TRUE;

// Last edited by Mike Knoop (173.26.93.156)2011-01-31 15:09:26