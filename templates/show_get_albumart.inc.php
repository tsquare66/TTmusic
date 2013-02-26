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
<?php UI::show_box_top(T_('Customize Search'), 'box box_get_albumart'); ?>
<form method="post" id="coverart" action="javascript.void(0);">
<table>
<tr>
	<td>
		<?php echo T_('Artist'); ?>&nbsp;
	</td>
	<?php if (true == $GLOBALS['isMobile'])  { echo '<tr></tr>';}?>
	<td>
		<input type="text" size="20" id="artist_name" name="artist_name" value="<?php echo scrub_out(unhtmlentities($artistname)); ?>" />
	</td>
</tr>
<tr>
	<td>
	 	<?php echo T_('Album'); ?>&nbsp;
	</td>
	<?php if (true == $GLOBALS['isMobile'])  { echo '<tr></tr>';}?>
	<td>
		<input type="text" size="20" id="album_name" name="album_name" value="<?php echo $albumname; ?>" />
	</td>
</tr>
<tr>
	<td>
		<?php echo T_('Direct URL to Image'); ?>
	</td>
	<?php if (true == $GLOBALS['isMobile'])  { echo '<tr></tr>';}?>
	<td>
		<input type="text" size="40" id="id_url_cover" name="url_cover" value="" />
	</td>
</tr>
<tr>
	<td>
		<?php echo T_('Local Image'); ?>
	</td>
	<?php if (true == $GLOBALS['isMobile'])  { echo '<tr></tr>';}?>
	<td>
		<input type="file" size="40" id="file" name="file" value="" />
	</td>
</tr>
</table>
	<input type="button" id="id_submit" value="<?php echo _('Get Art'); ?>" />
	<?php echo  Ajax::observe('id_submit','click',Ajax::action('?page=album&action=find_art&album_id=' . $album->id ,'url_cover','coverart'),'1'); ?>
	
</form>
<?php UI::show_box_bottom(); ?>
