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

require_once '../lib/init.php';

if (!Access::check('interface','100')) {
    UI::access_denied();
    exit;
}

//if (!defined('AJAX_INCLUDE')) { exit; }

debug_event('catalog.ajax.php' , 'Action:'.$_REQUEST['action'].' Catalog ID:'. json_encode($_REQUEST['catalog_id']), '5');

if (true == $GLOBALS['isMobile'])
	$target = 'sidebar-page';
else
	$target = 'content';

ob_start();
$results[$target] = "";


/* Big switch statement to handle various actions */
switch ($_REQUEST['action']) {
    case 'fixed':
        /* Does this use now? */
        delete_flagged($flag);
        $type = 'show_flagged_songs';
        require Config::get('prefix') . '/templates/flag.inc';
    break;
	case 'add_to_all_catalogs':
		$catalog = new Catalog();
		$_REQUEST['catalogs'] = $catalog->get_catalog_ids();
	case 'add_to_catalog':
		make_visible('ajax-loading');
		Ajax::flush();
		if (Config::get('demo_mode')) { break; }
		if ($_REQUEST['catalogs'] ) {
			foreach ($_REQUEST['catalogs'] as $catalog_id) {
				$catalog = new Catalog($catalog_id);
				$catalog->add_to_catalog();
			}
		}
		$url 	= '?page=catalog';
		$title 	= T_('Catalog Updated');
		$body	= '';
		show_confirmation($title,$body,$url);
		make_invisible('ajax-loading');
		Ajax::flush();
		return;
		break;
	case 'update_all_catalogs':
		$_REQUEST['catalogs'] = Catalog::get_catalog_ids();
	case 'update_catalog':
		make_visible('ajax-loading');
		Ajax::flush();
		/* If they are in demo mode stop here */
		if (Config::get('demo_mode')) { break; }

		if (isset($_REQUEST['catalogs'])) {
			foreach ($_REQUEST['catalogs'] as $catalog_id) {
				$catalog = new Catalog($catalog_id);
				$catalog->verify_catalog();
			}
		}
		$url	= '?page=catalog';
		$title	= T_('Catalog Updated');
		$body	= '';
		show_confirmation($title,$body,$url);
		make_invisible('ajax-loading');
		Ajax::flush();
		return;
		break;
	case 'full_service':
		make_visible('ajax-loading');
		Ajax::flush();
		/* Make sure they aren't in demo mode */
        if (Config::get('demo_mode')) { UI::access_denied(); break; }

		if (!$_REQUEST['catalogs']) {
			$_REQUEST['catalogs'] = Catalog::get_catalog_ids();
		}
		/* This runs the clean/verify/add in that order */
		foreach ($_REQUEST['catalogs'] as $catalog_id) {
			debug_event('catalog.ajax.php' , 'Full service Catalog ID:'.$catalog_id, '5');
			$catalog = new Catalog($catalog_id);
			$catalog->clean_catalog();
			Ajax::flush();
			$catalog->count = 0;
			$catalog->verify_catalog();
			Ajax::flush();
			$catalog->count = 0;
			$catalog->add_to_catalog();
			Ajax::flush();
		}
        Dba::optimize_tables();
		$url	= '?page=catalog';
		$title	= T_('Catalog Updated');
		$body	= '';
		show_confirmation($title,$body,$url);
		make_invisible('ajax-loading');
		Ajax::flush();
		return;
		break;
    case 'delete_catalog':
        /* Make sure they aren't in demo mode */
            if (Config::get('demo_mode')) { break; }

        if (!Core::form_verify('delete_catalog')) {
            UI::access_denied();
            exit;
        }

		/* Delete the sucker, we don't need to check perms as thats done above */
		Catalog::delete($_GET['catalog_id']);
		$next_url = '?page=catalog';
		show_confirmation(T_('Catalog Deleted'), T_('The Catalog and all associated records have been deleted'),$next_url);
	break;
	case 'remove_disabled':
        if (Config::get('demo_mode')) { break; }

		$song = $_REQUEST['song'];

		if (count($song)) {
			$catalog->remove_songs($song);
			$body = T_ngettext('Song Removed', 'Songs Removed', count($song));
		}
		else {
			$body = T_('No Songs Removed');
		}
		$url	= '?page=catalog';
		$title	= T_ngettext('Disabled Song Processed','Disabled Songs Processed',count($song));
		show_confirmation($title,$body,$url);
	break;
	case 'clean_all_catalogs':
		$catalog = new Catalog();
		$_REQUEST['catalogs'] = Catalog::get_catalog_ids();
	case 'clean_catalog':
		echo $target."^";
		make_visible('ajax-loading');
		Ajax::flush();
		/* If they are in demo mode stop them here */
		if (Config::get('demo_mode')) { break; }

		// Make sure they checked something
		if (isset($_REQUEST['catalogs'])) {
			foreach($_REQUEST['catalogs'] as $catalog_id) {
				$catalog = new Catalog($catalog_id);
				$catalog->clean_catalog();
			} // end foreach catalogs
            Dba::optimize_tables();
        }

		$url 	= '?page=catalog';
		$title	= T_('Catalog Cleaned');
		$body	= '';
		show_confirmation($title,$body,$url);
		make_invisible('ajax-loading');
		Ajax::flush();
		return;
		break;
	case 'update_catalog_settings':
		/* No Demo Here! */
		if (Config::get('demo_mode')) { break; }

		/* Update the catalog */
		Catalog::update_settings($_POST);

		$url 	= '?page=catalog';
		$title 	= T_('Catalog Updated');
		$body	= '';
		show_confirmation($title,$body,$url);
	break;
	case 'update_from':
		if (Config::get('demo_mode')) { break; }

		// First see if we need to do an add
		if ($_POST['add_path'] != '/' AND strlen($_POST['add_path'])) {
			if ($catalog_id = Catalog::get_from_path($_POST['add_path'])) {
				$catalog = new Catalog($catalog_id);
				$catalog->run_add(array('subdirectory'=>$_POST['add_path']));
			}
		} // end if add

		// Now check for an update
		if ($_POST['update_path'] != '/' AND strlen($_POST['update_path'])) {
			if ($catalog_id = Catalog::get_from_path($_POST['update_path'])) {
				$songs = Song::get_from_path($_POST['update_path']);
				foreach ($songs as $song_id) { Catalog::update_single_item('song',$song_id); }
			}
		} // end if update

	break;
	case 'add_catalog':
		/* Wah Demo! */
		if (Config::get('demo_mode')) { break; }

		ob_end_flush();

		if (!strlen($_POST['path']) || !strlen($_POST['name'])) {
			Error::add('general', T_('Error: Name and path not specified'));
		}

		if (substr($_POST['path'],0,7) != 'http://' && $_POST['type'] == 'remote') {
			Error::add('general', T_('Error: Remote selected, but path is not a URL'));
		}
		if ($POST['type'] == 'remote' AND (!strlen($POST['remote_username']) OR !strlen($POST['remote_password']))) {
			Error::add('general', T_('Error: Username and Password Required for Remote Catalogs'));
		}

		if (!Core::form_verify('add_catalog','post')) {
            UI::access_denied();
			exit;
		}

		// Make sure that there isn't a catalog with a directory above this one
		if (Catalog::get_from_path($_POST['path'])) {
			Error::add('general', T_('Error: Defined Path is inside an existing catalog'));
		}

		// If an error hasn't occured
		if (!Error::occurred()) {

			$catalog_id = Catalog::create($_POST);

			if (!$catalog_id) {
				require Config::get('prefix') . '/templates/show_add_catalog.inc.php';
				break;
			}

			$catalog = new Catalog($catalog_id);

			// Run our initial add
			$catalog->run_add($_POST);

            UI::show_box_top(T_('Catalog Created'), 'box box_catalog_created');
            echo "<h2>" .  T_('Catalog Created') . "</h2>";
            Error::display('general');
            Error::display('catalog_add');
            UI::show_box_bottom();

			show_confirmation('','', '?page=catalog');

		}
		else {
			require Config::get('prefix') . '/templates/show_add_catalog.inc.php';
		}
	break;
	case 'clear_stats':
        if (Config::get('demo_mode')) { UI::access_denied(); break; }
        Stats::clear();
		$url	= '?page=catalog';
		$title	= T_('Catalog statistics cleared');
		$body	= '';
		show_confirmation($title,$body,$url);
	break;
	default:
	case 'show_catalogs':
		require_once Config::get('prefix') . '/templates/show_manage_catalogs.inc.php';
	break;
	case 'show_add_catalog':
		require Config::get('prefix') . '/templates/show_add_catalog.inc.php';
	break;
	case 'clear_now_playing':
        if (Config::get('demo_mode')) { UI::access_denied(); break; }
		Stream::clear_now_playing();
		show_confirmation(T_('Now Playing Cleared'), T_('All now playing data has been cleared'),'?page=catalog');
		break;
	case 'show_disabled':
		/* Stop the demo hippies */
        if (Config::get('demo_mode')) { break; }

        $songs = Song::get_disabled();
		if (count($songs)) {
            require Config::get('prefix') . '/templates/show_disabled_songs.inc.php';
		}
		else {
			echo "<div class=\"error\" align=\"center\">" . T_('No Disabled songs found') . "</div>";
		}
	break;
	case 'show_delete_catalog':
		/* Stop the demo hippies */
        if (Config::get('demo_mode')) { UI::access_denied(); break; }

		$catalog = new Catalog($_REQUEST['catalog_id']);
		$nexturl = '?page=catalog&action=delete_catalog&catalog_id=' . scrub_out($_REQUEST['catalog_id']);
		show_confirmation(T_('Delete Catalog'), T_('Do you really want to delete this catalog?') . " -- $catalog->name ($catalog->path)",$nexturl,1,'delete_catalog');
	break;
	case 'show_customize_catalog':
		$catalog = new Catalog($_REQUEST['catalog_id']);
		require_once Config::get('prefix') . '/templates/show_edit_catalog.inc.php';
	break;
	case 'gather_all_album_art':
		$catalog = new Catalog();
		$_REQUEST['catalogs'] = Catalog::get_catalog_ids();
	case 'gather_album_art':
		make_visible('ajax-loading');
		Ajax::flush();
		$catalogs = $_REQUEST['catalogs'] ? $_REQUEST['catalogs'] : Catalog::get_catalogs();
		// Itterate throught the catalogs and gather as needed
		foreach ($catalogs as $catalog_id) {
			$catalog = new Catalog($catalog_id);
			$catalog->get_art('',1);
		}
		$url 	= '?page=catalog';
		$title 	= T_('Album Art Search Finished');
		$body	= '';
		show_confirmation($title,$body,$url);
		make_invisible('ajax-loading');
		Ajax::flush();
		return;
		break;
} // end switch

$results[$target] = ob_get_clean();
echo xml_from_array($results);
?>
