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

// Gotta do some math here!
if (true == $GLOBALS['isMobile'])
	$pics_per_row = 1;
else
	$pics_per_row = 3;
$total_images = count($images);
$rows = floor($total_images/$pics_per_row);
$i = 0;
?>
<?php UI::show_box_top(T_('Select New Album Art'), 'box box_album_art'); ?>
<table class="table-data">
<tr>
<?php


while ($i <= $rows) {
    $j=0;
	while ($j < $pics_per_row) {
		$key = $i*$pics_per_row+$j;
		$image_url = Config::get('web_path') . '/image.php?type=session&image_index=' . $key.'&dummy='.time();
		$Art = new Art('');
        $dimensions = Core::image_dimensions(Art::get_from_source($_SESSION['form']['images'][$key], 'album'));
        if (!isset($images[$key])) { echo "<td>&nbsp;</td>\n"; }
        else {
?>
            <td align="center">
                <a href="<?php echo $image_url; ?>" target="_blank"><img src="<?php echo $image_url; ?>" alt="<?php echo T_('Album Art'); ?>" border="0" height="175" width="175" /></a>
                <br />
                <p align="center">
                <?php if (is_array($dimensions)) { ?>
                [<?php echo intval($dimensions['width']); ?>x<?php echo intval($dimensions['height']); ?>]
                <?php } else { ?>
                <span class="error"><?php echo T_('Invalid'); ?></span>
                <?php } ?>
				[
			      <?php echo Ajax::text('?page=album&action=select_art&image='.$key.'&album_id='.intval($_REQUEST['album_id']),T_('Select'), 'select_album_art_'.$key); ?>
				]
                </p>
            </td>
<?php
        } // end else
        $j++;
    } // end while cells
    if($i < $rows) { echo "</tr>\n<tr>"; }
        else { echo "</tr>"; }
    $i++;
} // end while
?>
</table>
<?php UI::show_box_bottom(); ?>
