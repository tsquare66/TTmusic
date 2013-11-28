<?php

if (!$_SESSION['state']['sidebar_tab']) 
{
	$_SESSION['state']['sidebar_tab'] = 'home'; 
}

$class_name = 'sidebar_' . $_SESSION['state']['sidebar_tab'];
${$class_name} = ' active';

// List of buttons ( id, title, icon, access level)
$sidebar_items[] = array('id'=>'home', 'title'=>'Home', 'icon'=>'home', 'access'=>5);
//$sidebar_items[] = array('id'=>'localplay', 'title'=>_('Localplay'), 'icon'=>'volumeup', 'access'=>5);
$sidebar_items[] = array('id'=>'preferences', 'title'=>'Setup', 'icon'=>'setup', 'access'=>5);
//$sidebar_items[] = array('id'=>'modules','title'=>_('Modules'),'icon'=>'plugin','access'=>100);
$sidebar_items[] = array('id'=>'basket', 'title'=>'Basket', 'icon'=>'feed', 'access'=>5);
$sidebar_items[] = array('id'=>'admin', 'title'=>'Admin', 'icon'=>'admin', 'access'=>100);

$web_path = Config::get('web_path');
$ajax_url = Config::get('ajax_url');

?>

<div id="sidebar-tabs">

<?php
$weite = " style=\"width:20%\" ";

	foreach ($sidebar_items as $item)
	{
		if (Access::check('interface',$item['access']))
		{
		$li_params = "id='sb_tab_" . $item['id'] . "' class='sb1" . ${'sidebar_'.$item['id'] } . "'";
		$li_params .= $weite;
		?><li <?php echo $li_params; ?>>
	      		<?php
	        	// Button
	        	echo Ajax::textbutton("?page=index&action=sidebar&button=".$item['id'],$item['icon'],$item['title'],'sidebar_'.$item['id']);
	        	?></li><?php
		}
	}
	?>
	<li id="sb_tab_logout" class="sb1" <?php echo $weite; ?> >
	<a href="<?php echo Config::get('web_path'); ?>/logout.php" id="sidebar_logout" >
		<?php echo UI::get_icon('logout',_('Logout')).' Logout'; ?>
		</a>
	</li>
</div>


