<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2014 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

if (!$_SESSION['state']['sidebar_tab']) {
    $_SESSION['state']['sidebar_tab'] = 'home';
}
$class_name = 'sidebar_' . $_SESSION['state']['sidebar_tab'];

// List of buttons ( id, title, icon, access level)
$sidebar_items[] = array('id'=>'home', 'title' => T_('Home'), 'icon'=>'home', 'access'=>5);
$sidebar_items[] = array('id'=>'localplay', 'title' => T_('Localplay'), 'icon'=>'volumeup', 'access'=>5);
if (true == $GLOBALS['isMobile']){
	$sidebar_items[] = array('id'=>'basket', 'title'=>'Basket', 'icon'=>'feed', 'access'=>5);
}
$sidebar_items[] = array('id'=>'preferences', 'title' => T_('Preferences'), 'icon'=>'edit', 'access'=>5);
$sidebar_items[] = array('id'=>'modules','title' => T_('Modules'),'icon'=>'plugin','access'=>100);
$sidebar_items[] = array('id'=>'admin', 'title' => T_('Admin'), 'icon'=>'admin', 'access'=>100);

$web_path = AmpConfig::get('web_path');
?>

<ul id="sidebar-tabs">
<?php
foreach ($sidebar_items as $item) {
    if (Access::check('interface', $item['access'])) {

        $active = ('sidebar_'.$item['id'] == $class_name) ? ' active' : '';
        $li_params = "id='sb_tab_" . $item['id'] . "' class='sb1" . $active . "'";
?>
    <li <?php echo $li_params; ?>>
<?php
        echo Ajax::button("?page=index&action=sidebar&button=".$item['id'],$item['icon'],$item['title'],'sidebar_'.$item['id']);
        
       if (false == $GLOBALS['isMobile'])
       {        
        if ($item['id']==$_SESSION['state']['sidebar_tab']) 
        {
?>
        	<div id="sidebar-page" class="sidebar-page-<?php echo AmpConfig::get('ui_fixed') ? 'fixed' : 'float'; ?>">
            <?php require_once AmpConfig::get('prefix') . '/templates/sidebar_' . $_SESSION['state']['sidebar_tab'] . '.inc.php'; ?>
        	</div>
<?php
        }
	   }
?>
    </li>
<?php
    }
    }
?>
    <li id="sb_tab_logout" class="sb1">
        <a target="_top" href="<?php echo AmpConfig::get('web_path'); ?>/logout.php" id="sidebar_logout" >
        <?php echo UI::get_icon('logout', T_('Logout')); ?>
        </a>
    </li>
</ul>
<script>
$(function() {
    $(".header").click(function () {

        $header = $(this);
        //getting the next element
        $content = $header.next();
        //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
        $content.slideToggle(500, function() {
            $header.children().toggleClass("expanded collapsed");
            var sbstate = "expanded";
            if ($header.children().hasClass("collapsed")) {
                sbstate = "collapsed";
            }
            $.cookie('sb_' + $header.children().attr('id'), sbstate, { expires: 30, path: '/'});
        });

    });
});

$(document).ready(function() {
    // Get a string of all the cookies.
    var cookieArray = document.cookie.split(";");
    var result = new Array();
    // Create a key/value array with the individual cookies.
    for (var elem in cookieArray) {
        var temp = cookieArray[elem].split("=");
        // We need to trim whitespaces.
        temp[0] = $.trim(temp[0]);
        temp[1] = $.trim(temp[1]);
        // Only take sb_* cookies (= sidebar cookies)
        if (temp[0].substring(0, 3) == "sb_") {
            result[temp[0].substring(3)] = temp[1];
        }
    }
    // Finds the elements and if the cookie is collapsed, it
    // collapsed the found element.
    for (var key in result) {
        if ($("#" + key).length && result[key] == "collapsed") {
            $("#" + key).parent().next().slideToggle(0);
        }
    }
});
</script>

<?php if (true == $GLOBALS['isMobile']){
	if ($_REQUEST['action'] == 'sidebar')
	{
		if ($_SESSION['state']['sidebar_tab'] == "basket")
		{
			echo '<div id="sidebar-page">';
			echo '<div id="rightbar">';
			require_once AmpConfig::get('prefix') . '/templates/rightbar.inc.php';
			echo '</div><!-- End rightbar -->';
			echo '</div><!-- End sidebar-page -->';
			echo '</div><!-- End sidebar -->';
		}
		else
		{
			echo '<div id="sidebar-page">';
			require_once AmpConfig::get('prefix') . '/templates/sidebar_' . $_SESSION['state']['sidebar_tab'] . '.inc.php';
			echo '</div><!-- End sidebar-page -->';
			echo '</div><!-- End sidebar -->';
		}
	}
}
?>

