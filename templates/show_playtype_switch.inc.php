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
<div id="play_type_switch">
<?php
$name = "is_" . Config::get('play_type');
${$name} = 'selected="selected" ';

if (Preference::has_access('play_type')) {
?>
<form method="post" id="play_type_form" action="javascript.void(0);">
<select id="play_type_select" name="type">
    <?php if (Config::get('allow_stream_playback')) { ?>
        <option value="stream" <?php echo $is_stream; ?>><?php echo T_('Stream'); ?></option>
    <?php } if (Config::get('allow_localplay_playback')) { ?>
        <option value="localplay" <?php echo $is_localplay; ?>><?php echo T_('Localplay'); ?></option>
    <?php } if (Config::get('allow_democratic_playback')) { ?>
        <option value="democratic" <?php echo $is_democratic; ?>><?php echo T_('Democratic'); ?></option>
    <?php } ?>
    <option value="html5_player" <?php echo $is_html5_player; ?>><?php echo T_('HTML5 Player'); ?></option>
	<option value="jplayer" <?php echo $is_jplayer; ?>><?php echo 'JPlayer'; ?></option>
</select>
<?php echo Ajax::observe('play_type_select','change',Ajax::action('?page=stream&action=set_play_type','play_type_select','play_type_form'),'1'); ?>
</form>
<?php
} // if they have access
// Else just show what it currently is
else { echo T_(ucwords(Config::get('play_type'))); }
?>
</div>
