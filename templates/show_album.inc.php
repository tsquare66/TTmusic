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

// Title for this album
$title = scrub_out($album->name) . '&nbsp;(' . $album->year . ')';
if ($album->disk) {
    $title .= "<span class=\"discnb disc" . $album->disk . "\">, " . T_('Disk') . " " . $album->disk . "</span>";
}
$title .= '&nbsp;-&nbsp;' . $album->f_artist_link;
?>
<?php UI::show_box_top($title,'info-box'); ?>
<div class="album_art">
    <?php
    if ($album->name != T_('Unknown (Orphaned)')) {
        $name = '[' . $album->f_artist . '] ' . scrub_out($album->full_name);

            $aa_url = $web_path . "/image.php?id=" . $album->id . "&amp;type=popup&amp;sid=" . session_id();
            echo "<a target=\"_blank\" href=\"$aa_url\" onclick=\"popupWindow('$aa_url'); return false;\">";
            echo "<img src=\"" . $web_path . "/image.php?id=" . $album->id . "&amp;thumb=2\" alt=\"".$name."\" title=\"".$name."\" height=\"128\" width=\"128\" />";
            echo "</a>\n";
    }
    ?>
</div>
<div id="information_actions">
<div style="display:table-cell;" id="rating_<?php echo $album->id; ?>_album">
        <?php Rating::show($album->id,'album'); ?>
</div>
<h3><?php echo T_('Actions'); ?>:</h3>
<ul>
    <li>
        <?php echo Ajax::textbutton('?action=basket&type=album&id=' . $album->id,'add', T_('Add'),'play_full_' . $album->id); ?>
    </li>
    <li>
        <?php echo Ajax::textbutton('?action=basket&type=album_random&id=' . $album->id,'random', T_('Random'),'play_random_' . $album->id); ?>
    </li>
    <?php if (Access::check('interface','75')) { ?>
    <li>
        <?php echo Ajax::textbutton('?page=album&action=clear_art&album_id='.$album->id,'delete', T_('Reset Album Art'),'reset_album_art_' . $album->id); ?>
    </li>
    <?php } ?>
    <li>
	    <?php echo Ajax::textbutton('?page=album&action=find_art&album_id=' . $album->id,'view',T_('Find Album Art'), 'find_album_art_' . $album->id); ?>
    </li>
    <?php  if ((Access::check('interface','50'))) { ?>
    <li>
	    <?php echo Ajax::textbutton('?page=album&action=update_from_tags&album_id=' . $album->id,'cog',T_('Update from tags'), 'Update from tags' . $album->id); ?>
    </li>
    <?php  } ?>
    <?php if (Access::check_function('batch_download')) { ?>
    <li>
        <a href="<?php echo $web_path; ?>/batch.php?action=album&amp;id=<?php echo $album->id; ?>"><?php echo UI::get_icon('batch_download', T_('Download')); ?></a>
        <a href="<?php echo $web_path; ?>/batch.php?action=album&amp;id=<?php echo $album->id; ?>"><?php echo T_('Download'); ?></a>
    </li>
    <?php } ?>
</ul>
</div>
<?php UI::show_box_bottom(); ?>
<div id="additional_information">
&nbsp;
</div>
<?php
    $browse = new Browse();
    $browse->set_type('song');
    $browse->set_simple_browse(true);
    $browse->set_filter('album', $album->id);
    $browse->set_sort('track', 'ASC');
     $browse->get_objects();
    $browse->show_objects();
    $browse->store();
?>
