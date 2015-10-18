<?php
define('STATUS_ONLINE', 'online');
define('STATUS_OFFLINE', 'offline');
define('STATUS_WAIT', 0.2);

$sites = array(
	'websites'		=> array('94.247.4.53', '80'),
	'objectpaths'	=> array('94.247.4.54', '80'),
);
$services = array(
	'universe (via host)'=> array('awu.l3d.nl', '80'),
	'universe (via IP)'	=> array('94.247.4.55', '80'),
	'voice chat'	=> array('94.247.4.56', '80'),
	'presentations'	=> array('94.247.4.56', '443'),
);
$worldsrv = array(
	'intern'	=> array('94.247.4.55', '443'),
	'l3d'		=> array('94.247.4.51', '80'),
	'speciaal'	=> array('94.247.4.51', '443'),
	'school 1'	=> array('94.247.4.52', '80'),
	'school 2'	=> array('94.247.4.52', '443'),
);

echo '
<!DOCTYPE html>
<html><head>
<title>L3Daw status</title>
<style type="text/css">
body { font-family: Verdana; font-size: smaller; }
ul { float: left; margin-left: 0; margin-right: 3em; padding-left: 0; list-style-type: none; }
span { font-weight: bold; }
.online { color: green; }
.offline { color: red; }
</style>
</head>
<body>
';

echo '<h1>Status</h1>';
echo '<p>Status checker van L3Daw</p>';
echo '<p>(<em>offline</em> kan ook <em>langzaam</em> betekenen, de timeout bij het testen is '.STATUS_WAIT.'s)</p>';

function connect_test($hostport) {
	$host = $hostport[0];
	$port = $hostport[1];
	
	$f = @fsockopen($host, $port, $errno, $error, STATUS_WAIT);
	$status = ($f == false) ? STATUS_OFFLINE : STATUS_ONLINE;
	@fclose($f);
	
	return $status;
}

echo '<ul>';
echo '<h3>websites</h3>';
foreach ($sites as $service => $hostport) {
	$status = connect_test($hostport);
	echo '<li title="'.$hostport[0].':'.$hostport[1].'">'.$service.' is <span class="'.$status.'">'.$status.'</span></li>';
}
echo '</ul>';

echo '<ul>';
echo '<h3>uni services</h3>';
foreach ($services as $service => $hostport) {
	$status = connect_test($hostport);
	echo '<li title="'.$hostport[0].':'.$hostport[1].'">'.$service.' is <span class="'.$status.'">'.$status.'</span></li>';
}
echo '</ul>';

echo '<ul>';
echo '<h3>worldservers</h3>';
foreach ($worldsrv as $service => $hostport) {
	$status = connect_test($hostport);
	echo '<li title="'.$hostport[0].':'.$hostport[1].'">'.$service.' is <span class="'.$status.'">'.$status.'</span></li>';
}
echo '</ul>';

echo '
</body>
</html>';
?>