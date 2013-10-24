<?
require '../../knoopvszombies.ini.php';
require '../../osundead.com/module/includes.php';

require '../../osundead.com/module/general.php';

$database = DATABASE;
$db_host = DATABASE_HOSTNAME;
$db_user = 'webengine';
$db_pwd = DATABASE_PASS_FOR_WEB;
mysql_connect($db_host, $db_user, $db_pwd);
mysql_select_db($database);

$result = mysql_query("select uid FROM user WHERE email_confirmed = 0");

while ($tmp = mysql_fetch_array($result)){
$GLOBALS['User']->SendEmailConfirmation($tmp['uid']);
}


?>
done
