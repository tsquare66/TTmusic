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

/**
 * Sub-Ajax page, requires AJAX_INCLUDE
 */

require_once '../modules/getid3/getid3.php';
require_once '../modules/getid3/getid3.lib.php';
require_once '../modules/getid3/write.php';

if (!defined('AJAX_INCLUDE')) { exit; }


debug_event('tag.ajax.php' , 'Action:'.$_REQUEST['action'].' Browse ID:'.$_GET['browse_id'].' Tag ID:'.$_POST['tag_id'], '5');


switch ($_REQUEST['action']) {
    case 'show_add_tag':

    break;
    case 'add_tag':
        Tag::add_tag_map($_GET['type'],$_GET['object_id'],$_GET['tag_id']);
    break;
    case 'remove_tag':
        $tag = new Tag($_GET['tag_id']);
        $tag->remove_map($_GET['type'],$_GET['object_id']);
    break;
    case 'browse_type':
        $browse = new Browse($_GET['browse_id']);
        $browse->set_filter('object_type', $_GET['type']);
        $browse->store();
    break;
    case 'add_filter':
        $browse = new Browse($_GET['browse_id']);
        $browse->set_filter('tag', $_POST['tag_id']);
        $object_ids = $browse->get_objects();
        ob_start();
        $browse->show_objects($object_ids);
        $results['browse_content'] = ob_get_clean();
        $browse->store();
        // Retrieve current objects of type based on combined filters
    break;
	case 'save_tag':
		$new_tag = new Tag($_POST['tag_id']);
		$song_id = $_GET['song_id'];
		$new_tag->update_tag_map('song',$song_id,$new_tag->id);		
		$song = new Song($_GET['song_id']);
		$song->format();
		$id3 = new vainfo($song->file);
		$data['genre'] = $new_tag->name;
		$id3->write_id3($data);					
		break;
    default:
        $results['rfc3514'] = '0x1';
    break;
} // switch on action;


// We always do this
echo xml_from_array($results);
?>
