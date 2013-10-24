<?php if (!defined('APPLICATION')) exit();

// Conversations
$Configuration['Conversations']['Version'] = '2.0.16';

// Database
$Configuration['Database']['Name'] = 'hvz_lab';
$Configuration['Database']['Host'] = 'mysql.osundead.com';
$Configuration['Database']['User'] = 'webengine';
$Configuration['Database']['Password'] = 'amberlamps';

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
$Configuration['Garden']['Title'] = 'Osundead Humans vs. Zombies';
$Configuration['Garden']['Cookie']['Salt'] = 'ZUZXZ1UHSX';
$Configuration['Garden']['Cookie']['Domain'] = 'http://osundead.com/';
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
$Configuration['Garden']['Errors']['MasterView'] = 'deverror.master.php';

// Modules
$Configuration['Modules']['Vanilla']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';
$Configuration['Modules']['Conversations']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Discussion'] = '1';
$Configuration['Plugins']['GettingStarted']['Profile'] = '1';
$Configuration['Plugins']['EmbedVanilla']['RemoteUrl'] = 'http://osundead.com/forums/';
$Configuration['Plugins']['EmbedVanilla']['ForceRemoteUrl'] = FALSE;
$Configuration['Plugins']['EmbedVanilla']['EmbedDashboard'] = FALSE;

// Routes
$Configuration['Routes']['DefaultController'] = 'discussions';

// Skeleton
$Configuration['Skeleton']['Version'] = '1.0';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.0.16';
$Configuration['Vanilla']['Categories']['Use'] = TRUE;

// Last edited by Lars Paulson (128.193.152.160)2013-10-20 19:53:10
