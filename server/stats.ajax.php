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

/**
 * Sub-Ajax page, requires AJAX_INCLUDE
 */

require_once("../lib/init.php");
session_start();

debug_event('stats.ajax.php' , 'Page: '.$page.' Action:'.$_REQUEST['action'], '5');

if (!defined('AJAX_INCLUDE')) { exit; }

if (true == $GLOBALS['isMobile'])
	$target = 'sidebar-page';
else
	$target = 'content';

ob_start();
require_once Config::get('prefix') . '/stats.php';
$results[$target] = ob_get_clean();

// We always do this
echo xml_from_array($results);
?>
