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

$web_path = Config::get('web_path');
$button = Ajax::button('?page=index&action=random_albums','random', T_('Refresh'),'random_refresh');
?>
<?php UI::show_box_top(T_('Albums of the Moment') . ' ' . $button, 'box box_random_albums'); ?>

	<table>
	<tr>
    <?php
    if ($albums) {
        foreach ($albums as $album_id) {
            $album = new Album($album_id);
            $album->format();
            $name = '[' . $album->f_artist . '] ' . scrub_out($album->full_name);
        ?>
        <td>
        <div class="random_album">
        <?php 
	        	$action = '?page=album&action=show&album='.$album_id;
	        	if (Art::is_enabled()) 
			    {
	            	$img_url = $web_path .'/image.php?thumb=3&id='.$album_id;
	            	echo Ajax::image($action, $img_url, '80', '','random_'.$album_id);
	            } 
	            else
	            {
	            	echo '[' . $album->f_artist . '] ' . $album->f_name;
	            }
			?>
            <?php
                if(Config::get('ratings')){
                        echo "<div id=\"rating_" . $album->id . "_album\">";
                        show_rating($album->id, 'album');
                        echo "</div>";
                }
                ?>
        </div>
                  <span class="play_album"><?php echo Ajax::button('?action=basket&type=album&id=' . $album->id,'add', T_('Play Album'),'play_full_' . $album->id); ?></span>
        </td>
        	<?php } // end foreach ?>
	<?php } // end if albums ?>
	</tr>
	</table>
	
	
<?php UI::show_box_bottom(); ?>
