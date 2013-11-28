<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2013 Ampache.org
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

?>
<ul class="sb2" id="sb_admin">
  <li><h4><?php echo T_('Catalogs'); ?></h4>
   <ul class="sb3" id="sb_admin_catalogs">
    <li id="sb_admin_catalogs_Add">   <?php echo Ajax::text("?page=catalog&action=show_add_catalog", _('Add a Catalog'),'sb_admin_catalogs_Add'); ?></li>
	<li id="sb_admin_catalogs_Show">  <?php echo Ajax::text("?page=catalog&action=show_catalogs",_('Show Catalogs'),'sb_admin_catalogs_Show'); ?></li>
   </ul>
  </li>

  <li><h4><?php echo T_('User Tools'); ?></h4>
    <ul class="sb3" id="sb_admin_ut">
      <li id="sb_admin_ut_AddUser">     <?php echo Ajax::text("?page=users&action=show_add_user", _('Add User'),'sb_admin_ut_AddUsers'); ?></li>
	  <li id="sb_admin_ut_BrowseUsers"> <?php echo Ajax::text("?page=users&action=show",_('Browse Users'),'sb_admin_ut_BrowseUsers'); ?></li>
    </ul>
  </li>
  
  <?php if (false == $GLOBALS['isMobile'])  { ?>
  <li><h4><?php echoT_('Access Control'); ?></h4>
    <ul class="sb3" id="sb_admin_acl">
      <li id="sb_admin_acl_AddAccess"><a href="<?php echo $web_path; ?>/admin/access.php?action=show_add_advanced"><?php echo _('Add ACL'); ?></a></li>
      <li id="sb_admin_acl_ShowAccess"><a href="<?php echo $web_path; ?>/admin/access.php"><?php echo _('Show ACL(s)'); ?></a></li>
    </ul>
  </li>
  <?php } ?>
  
  
  <?php if (false == $GLOBALS['isMobile'])  { ?>
  <li><h4><?php echo T_('Other Tools'); ?></h4>
    <ul class="sb3" id="sb_admin_ot">
      <li id="sb_admin_ot_Debug"><a href="<?php echo $web_path; ?>/admin/system.php?action=show_debug"><?php echo T_('Ampache Debug'); ?></a></li>
      <li id="sb_admin_ot_ClearNowPlaying"><a href="<?php echo $web_path; ?>/admin/catalog.php?action=clear_now_playing"><?php echo T_('Clear Now Playing'); ?></a></li>
      <li id="sb_admin_ot_ExportCatalog"><a href="<?php echo $web_path; ?>/admin/export.php"><?php echo T_('Export Catalog'); ?></a></li>
      <?php if (Config::get('shoutbox')) { ?>
      <li id="sb_admin_ot_ManageShoutbox"><a href="<?php echo $web_path; ?>/admin/shout.php"><?php echo T_('Manage Shoutbox'); ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  
  
<?php if (Access::check('interface','100')) { ?>
  <li><h4><?php echo T_('Server Config'); ?></h4>
    <ul class="sb3" id="sb_preferences_sc">
<?php
	$catagories = Preference::get_catagories();
        foreach ($catagories as $name) {
                $f_name = ucfirst($name);
?>
	  <li id="sb_preferences_sc_<?php echo $f_name; ?>"> <?php echo Ajax::text("?page=preferences&action=admin&tab=".$name, 		T_($f_name),    'sb_preferences_sc_'. $f_name); ?></li>
<?php } ?>
    </ul>
  </li>
<?php } ?>
</ul>


