<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2014 Ampache.org
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
<form style="display:inline;" name="f" method="get" action="<?php echo AmpConfig::get('web_path') . "/$action"; ?>" enctype="multipart/form-data">
    <label for="match" accesskey="S"><?php echo $text; ?></label>
    <input type="text" id="match" name="match" value="<?php echo $match; ?>" />
    <input type="hidden" name="action" value="<?php echo scrub_out($_REQUEST['action']); ?>">
</form>
