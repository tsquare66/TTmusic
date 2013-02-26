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
?>
<td class="cel_catalog"><?php echo $catalog->f_name_link; ?></td>
<?php if (false == $GLOBALS['isMobile'])  { ?>
<td class="cel_path"><?php echo scrub_out($catalog->f_path); ?></td>
<td class="cel_lastverify"><?php echo scrub_out($catalog->f_update); ?></td>
<td class="cel_lastadd"><?php echo scrub_out($catalog->f_add); ?></td>
<td class="cel_lastclean"><?php echo scrub_out($catalog->f_clean); ?></td>
<?php } ?>
<td class="cel_action">
		 <?php echo Ajax::text_update('?page=catalog&action=add_to_catalog&catalogs[]='.$catalog->id, T_('Add'),$catalog->id.'1'); ?>
	<br> <?php echo Ajax::text_update('?page=catalog&action=update_catalog&catalogs[]='.$catalog->id, T_('Verify'),$catalog->id.'2'); ?>
    <br> <?php echo Ajax::text_update('?page=catalog&action=clean_catalog&catalogs[]='.$catalog->id, T_('Clean'),$catalog->id.'3'); ?>
	<br> <?php echo Ajax::text_update('?page=catalog&action=full_service&catalogs[]='.$catalog->id, T_('Update'),$catalog->id.'4'); ?>
	<br> <?php echo Ajax::text_update('?page=catalog&action=gather_album_art&catalogs[]='.$catalog->id, T_('Gather Art'),$catalog->id.'5'); ?>
	<br> <?php echo Ajax::text('?page=catalog&action=show_delete_catalog&catalog_id='.$catalog->id, T_('Delete'),$catalog->id.'6'); ?>
</td>
