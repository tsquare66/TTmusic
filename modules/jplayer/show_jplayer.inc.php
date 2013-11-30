
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


<?php  
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
	jQuery("#jplayer_inspector_1").jPlayerInspector({jPlayer:jQuery("#jquery_jplayer_1")});
},100);
</script>

		