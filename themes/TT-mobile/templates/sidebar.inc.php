
<?php

$web_path = Config::get('web_path');
$ajax_url = Config::get('ajax_url');

require_once Config::get('prefix') . '/themes/tt-mobile/templates/topnavbar.inc.php';

if ($_SESSION['state']['sidebar_tab'] == "basket")
{
	echo '<div id="sidebar-page">';
	echo '<div id="rightbar">';
	require_once Config::get('prefix') . '/templates/rightbar.inc.php';
	echo '</div>';
	echo '</div>';
}
else
{
	if ($_REQUEST['action'] == 'sidebar')
	{
		echo '<div id="sidebar-page">';
		require_once Config::get('prefix') . '/templates/sidebar_' . $_SESSION['state']['sidebar_tab'] . '.inc.php';
		echo '</div>';
	}
}

