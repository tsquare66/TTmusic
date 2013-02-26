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

UI::show_box_top(T_('Starting Update from Tags'), 'box box_update_items');
Catalog::update_single_item($type,$object_id);
?>
<br />
<strong><?php echo T_('Update from Tags Complete'); ?></strong>&nbsp;&nbsp;

<form method="post" id="update_form" action="javascript.void(0);">
	<input type="button" id="update_continue" value="<?php echo _('Continue'); ?>" />
	<?php 
		echo Ajax::observe('update_continue','click',Ajax::action($next_action,_('Continue'), 'update_continue','update_form')); 
	?>
</form>


<?php UI::show_box_bottom(); ?>
