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

UI::show_box_top(T_('Search Ampache') . "...", 'box box_advanced_search');
?>
<form id="search" name="search" method="post" action="javascript.void(0);" enctype="multipart/form-data" style="Display:inline">
<table class="tabledata" cellpadding="3" cellspacing="0">
	<tr id="search_location">
	<td><?php if ($_REQUEST['type'] != 'song') {echo Ajax::text('?page=search&type=song',T_('Songs'),'search_songs');} else { echo '<b>'.T_('Songs').'</b>'; }?></td>
	<td><?php if ($_REQUEST['type'] != 'album') {echo Ajax::text('?page=search&type=album',T_('Albums'),'search_albums');} else { echo '<b>'.T_('Albums').'</b>'; }?></td>
	<td><?php if ($_REQUEST['type'] != 'artist') {echo Ajax::text('?page=search&type=artist',T_('Artists'),'search_artists');} else { echo '<b>'.T_('Artists').'</b>'; }?></td>
	<td><?php if ($_REQUEST['type'] != 'video') {echo Ajax::text('?page=search&type=video',T_('Videos'),'search_video');} else { echo '<b>'.T_('Videos').'</b>'; }?></td>
    </tr>
    <tr id="search_blank_line"><td>&nbsp;</td></tr>
</table>
<table class="tabledata" cellpadding="3" cellspacing="0">
    <tr id="search_max_results">
    <td><?php echo T_('Maximum Results'); ?></td>
        <td>
                <select name="limit">
                        <option value="0"><?php echo T_('Unlimited'); ?></option>
                        <option value="25" <?php if($_REQUEST['limit']=="25") echo "selected=\"selected\""?>>25</option>
                        <option value="50" <?php if($_REQUEST['limit']=="50") echo "selected=\"selected\""?>>50</option>
                        <option value="100" <?php if($_REQUEST['limit']=="100") echo "selected=\"selected\""?>>100</option>
                        <option value="500" <?php if($_REQUEST['limit']=="500") echo "selected=\"selected\""?>>500</option>
                </select>
        </td>
    </tr>
</table>

<?php require Config::get('prefix') . '/templates/show_rules.inc.php'; ?>

<div class="formValidation">
  <input class="button" type="button" id="id_search_button" value="<?php echo T_('Search'); ?>" />
<?php if ($_REQUEST['type'] == 'song' || ! $_REQUEST['type']) { ?>
		<input id="savesearchbutton" class="button" type="button" value="<?php echo T_('Save as Smart Playlist'); ?>" onClick="$('hiddenaction').setValue('save_as_smartplaylist');" />&nbsp;&nbsp;
<?php } ?>
            <input type="hidden" id="hiddenaction" name="action" value="search" />
</div>
</form>
<?php 
$type = $_REQUEST['type'] ? $_REQUEST['type'] : 'song';
echo Ajax::observe('id_search_button','click',Ajax::action('?page=search&type='. $type,'id_search_button','search'),'1'); 
echo Ajax::observe('savesearchbutton','click',Ajax::action('?page=search&type='. $type,'savesearchbutton','search'),'1'); 
?>

<?php UI::show_box_bottom(); ?>
