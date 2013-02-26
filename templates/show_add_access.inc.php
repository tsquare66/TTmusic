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
 */
?>
<?php UI::show_box_top(T_('Add Access Control List'), 'box box_add_access'); ?>
<?php Error::display('general'); ?>
<form name="update_access" method="post" enctype="multipart/form-data" action="<?php echo Config::get('web_path'); ?>/admin/access.php?action=add_host">
<table class="tabledata" cellpadding="5" cellspacing="0">
<tr>
    <td><?php echo T_('Name'); ?>:</td>
    <td colspan="3">
        <input type="text" name="name" value="<?php echo scrub_out($_REQUEST['name']); ?>" size="20" />
    </td>
</tr>
<tr>
    <td><?php echo T_('Level'); ?>:</td>
    <td colspan="3">
        <input name="level" type="radio" checked="checked" value="5" /> <?php echo T_('View'); ?>
        <input name="level" type="radio" value="25" /> <?php echo T_('Read'); ?>
        <input name="level" type="radio" value="50" /> <?php echo T_('Read/Write'); ?>
        <input name="level" type="radio" value="75" /> <?php echo T_('All'); ?>
    </td>
</tr>
<tr>
    <td><?php echo T_('User'); ?>:</td>
    <td colspan="3">
        <?php show_user_select('user'); ?>
    </td>
</tr>
<tr>   
        <td valign="top"><?php echo T_('ACL Type'); ?>:</td>
        <td colspan="3">
<?php if ($action == 'show_add_rpc') { ?>
        <input type="hidden" name="type" value="rpc" />
        <select name="addtype">
            <option value="rpc"><?php echo T_('API/RPC'); ?></option>
            <option selected="selected" value="stream"><?php printf(T_('%s + %s'), T_('API/RPC'), T_('Stream Access')); ?></option>
            <option value="all"><?php printf(T_('%s + %s'), T_('API/RPC'), T_('All')); ?></option>
<?php } else if ($action == 'show_add_local') { ?>
        <input type="hidden" name="type" value="local" />
        <select name="addtype">
            <option value="network"><?php echo T_('Local Network Definition'); ?></option>
            <option value="stream"><?php printf(T_('%s + %s'), T_('Local Network Definition'), T_('Stream Access')); ?></option>
            <option selected="selected" value="all"><?php printf(T_('%s + %s'), T_('Local Network Definition'), T_('All')); ?></option>

<?php } else { ?>
        <select name="type">
            <option selected="selected" value="stream"><?php echo T_('Stream Access'); ?></option>
            <option value="interface"><?php echo T_('Web Interface'); ?></option>
            <option value="network"><?php echo T_('Local Network Definition'); ?></option>
            <option value="rpc"><?php echo T_('API/RPC'); ?></option>
<?php } ?>
        </select>
    </td>
</tr>
<tr>
    <td colspan="4"><h3><?php echo T_('IPv4 or IPv6 Addresses'); ?></h3>
        <span class="information">(255.255.255.255) / (ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff)</span>
    </td>
</tr>
<tr>
    <td><?php echo T_('Start'); ?>:</td>
    <td>
        <?php Error::display('start'); ?>
        <input type="text" name="start" value="<?php 
        if($action == 'show_add_current') {
            echo scrub_out($_SERVER['REMOTE_ADDR']);
        }
        else {
            echo scrub_out($_REQUEST['start']);
        } ?>" size="20" maxlength="15" />
    </td>
    <td><?php echo T_('End'); ?>:</td>
    <td>
        <?php Error::display('end'); ?>
        <input type="text" name="end" value="<?php 
        if($action == 'show_add_current') {
            echo scrub_out($_SERVER['REMOTE_ADDR']);
        }
        else {
            echo scrub_out($_REQUEST['end']);
        } ?>" size="20" maxlength="15" />
    </td>
</tr>
</table>
<div class="formValidation">
        <?php echo Core::form_register('add_acl'); ?>
        <input class="button" type="submit" value="<?php echo T_('Create ACL'); ?>" />
</div>
</form>
<?php UI::show_box_bottom(); ?>
