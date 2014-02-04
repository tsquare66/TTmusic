<?php
/* vim:set tabstop=4 softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2013 Ampache.org
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

header('Cache-Control: no-cache');
header('Pragma: no-cache');
header('Expires: ' . gmdate(DATE_RFC1123, time()-1));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
<title><?php echo Config::get('site_title'); ?></title>

<?php require_once Config::get('prefix') . '/templates/stylesheets.inc.php'; ?>

<?php  if (true == $GLOBALS['isMobile']) 
{ ?>
   <link rel="stylesheet" href="<?php echo Config::get('web_path'); ?>/modules/jplayer/skins/blue.monday/mobile.playlist.css" type="text/css" media="screen" />
<?php 
} 
else 
{ ?>
   <link rel="stylesheet" href="<?php echo Config::get('web_path'); ?>/modules/jplayer/skins/blue.monday/jplayer.blue.monday.css" type="text/css" media="screen" />
<?php 
} ?>


<script src="<?php echo Config::get('web_path'); ?>/modules/prototype/prototype.js" language="javascript" type="text/javascript"></script>
<script src="<?php echo Config::get('web_path'); ?>/modules/jplayer/extras/jquery-1.8.2-ajax-deprecated.min.js" type="text/javascript"></script>
<script src="<?php echo Config::get('web_path'); ?>/modules/jplayer/jquery.jplayer.min.js" type="text/javascript"></script>
<script src="<?php echo Config::get('web_path'); ?>/modules/jplayer/add-on/jplayer.playlist.min.js" type="text/javascript"></script>
<script src="<?php echo Config::get('web_path'); ?>/modules/jplayer/add-on/jquery.jplayer.inspector.js" type="text/javascript"></script>
<script type="text/javascript">jQuery.noConflict();</script>

<script type="text/javascript">
(function() {
	var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
	s.type = 'text/javascript';
	s.async = true;
	s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
	t.parentNode.insertBefore(s, t);
})();
</script>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-3557377-9']);
	_gaq.push(['_trackPageview']);

	(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>

<div id="maincontainer">

<?php
                $media_ids = $GLOBALS['user']->playlist->get_items();
                $playlist = new Stream_Playlist();
                $playlist->add($media_ids);
                
                $jplaylist = "";
                $delimiter = "";
                foreach($playlist->urls as $item)
                {
                        $title = $item->title;
                        debug_event('jplayer.php' ,        'Title : '.$title, '5');
                        $artist = $item->author;
                        $location = $item->url;
                        $image = $item->image_url;
                        
                        $jplaylist .= $delimiter;
                        $jplaylist .= "{";
                        $jplaylist .=        " title: \"".$title."\",\n";
                        $jplaylist .=        " artist: \"".$artist."\",\n";
                        $jplaylist .=        " mp3: \"".$location."\",\n";
                        $jplaylist .=        " poster: \"".$image."\"\n";
                        $jplaylist .= "}";
                        $delimiter = ",\n";
                }


  
	include Config::get('prefix') . '/modules/jplayer/mediaplaylist.php';
?>

<div id="jplayer_inspector_1"></div>

		

<script type="text/javascript">

window.setTimeout(function(){
	new jPlayerPlaylist(
	{
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
	}, 
	[<?php echo $jplaylist; ?> ],
	{
	    playlistOptions: 
	    {
	        autoPlay: true,
	        loopOnPrevious: false,
	        shuffleOnLoop: true,
	        enableRemoveControls: false,
	        displayTime: 'slow',
	        addTime: 'fast',
	        removeTime: 'fast',
	        shuffleTime: 'slow'
	    },
		size: {
				width: "285px",
				height: "285px",
				cssClass: "jp-video-270p"
		},
		errorAlerts: false,
	    warningAlerts:false,
	    swfPath: "<?php echo $web_path; ?>/modules/jplayer/",
	    supplied: 'webmv, mp3',
		solution:"html, flash",
		preload: "auto",
		wmode: "window"
	});
	
	jQuery("#jquery_jplayer_1").jPlayer('setMedia', <?php echo $jplaylist; ?>);
},100);
</script>

</div><!-- End maincontainer -->
		