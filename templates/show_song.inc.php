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

$icon = $song->enabled ? 'disable' : 'enable';
$button_flip_state_id = 'button_flip_state_' . $song->id;
?>
<?php UI::show_box_top($song->title . ' ' . T_('Details'), 'box box_song_details'); ?>
<dl class="song_details">

<?php if (AmpConfig::get('ratings')) { ?>
    <?php $rowparity = UI::flip_class(); ?>
    <dt class="<?php echo $rowparity; ?>"><?php echo T_('Rating'); ?></dt>
    <dd class="<?php echo $rowparity; ?>">
        <div id="rating_<?php echo $song->id; ?>_song"><?php Rating::show($song->id,'song'); ?>
        </div>
    </dd>
<?php } ?>

<?php if (AmpConfig::get('userflags')) { ?>
    <?php $rowparity = UI::flip_class(); ?>
    <dt class="<?php echo $rowparity; ?>"><?php echo T_('Fav.'); ?></dt>
    <dd class="<?php echo $rowparity; ?>">
        <div id="userflag_<?php echo $song->id; ?>_song"><?php Userflag::show($song->id,'song'); ?>
        </div>
    </dd>
<?php } ?>
<?php if (AmpConfig::get('waveform')) { ?>
    <?php $rowparity = UI::flip_class(); ?>
    <dt class="<?php echo $rowparity; ?>"><?php echo T_('Waveform'); ?></dt>
    <dd class="<?php echo $rowparity; ?>">
        <div id="waveform_<?php echo $song->id; ?>">
            <img src="<?php echo AmpConfig::get('web_path'); ?>/waveform.php?song_id=<?php echo $song->id; ?>" />
        </div>
    </dd>
<?php } ?>
<?php $rowparity = UI::flip_class(); ?>
<dt class="<?php echo $rowparity; ?>"><?php echo T_('Action'); ?></dt>
    <dd class="<?php echo $rowparity; ?>">
        <?php if (AmpConfig::get('directplay')) { ?>
            <?php echo Ajax::button('?page=stream&action=directplay&playtype=song&song_id=' . $song->id, 'play', T_('Play'),'play_song_' . $song->id); ?>
            <?php if (Stream_Playlist::check_autoplay_append()) { ?>
                <?php echo Ajax::button('?page=stream&action=directplay&playtype=song&song_id=' . $song->id . '&append=true','play_add', T_('Play last'),'addplay_song_' . $song->id); ?>
            <?php } ?>
            <?php echo $song->show_custom_play_actions(); ?>
        <?php } ?>
        <?php echo Ajax::button('?action=basket&type=song&id=' . $song->id,'add', T_('Add to temporary playlist'),'add_song_' . $song->id); ?>
        <?php if (AmpConfig::get('sociable')) { ?>
            <a href="<?php echo AmpConfig::get('web_path'); ?>/shout.php?action=show_add_shout&type=song&id=<?php echo $song->id; ?>">
            <?php echo UI::get_icon('comment', T_('Post Shout')); ?>
            </a>
        <?php } ?>
        <?php if (AmpConfig::get('share')) { ?>
            <a href="<?php echo AmpConfig::get('web_path'); ?>/share.php?action=show_create&type=song&id=<?php echo $song->id; ?>"><?php echo UI::get_icon('share', T_('Share')); ?></a>
        <?php } ?>
        <?php if (Access::check_function('download')) { ?>
            <a href="<?php echo Song::play_url($song->id); ?>"><?php echo UI::get_icon('link', T_('Link')); ?></a>
            <a href="<?php echo AmpConfig::get('web_path'); ?>/stream.php?action=download&amp;song_id=<?php echo $song->id; ?>"><?php echo UI::get_icon('download', T_('Download')); ?></a>
        <?php } ?>
        <?php if (Access::check('interface','75')) { ?>
            <span id="<?php echo($button_flip_state_id); ?>">
            <?php echo Ajax::button('?page=song&action=flip_state&song_id=' . $song->id,$icon, T_(ucfirst($icon)),'flip_song_' . $song->id); ?>
            </span>
        <?php } ?>
    </dd>
<?php
  $songprops[gettext_noop('Title')]   = scrub_out($song->title);
  $songprops[gettext_noop('Artist')]  = $song->f_artist_link;
  $songprops[gettext_noop('Album')]   = $song->f_album_link;
  $songprops[gettext_noop('Albumartist')]   = $song->band;
  $songprops[gettext_noop('Year')]    = scrub_out($song->year);
  $songprops[gettext_noop('Genre')]   = $song->f_tags;
  $songprops[gettext_noop('Length')]  = scrub_out($song->f_time);
  $songprops[gettext_noop('Comment')] = scrub_out($song->comment);
  $songprops[gettext_noop('Label')]   = scrub_out($song->label);
  $songprops[gettext_noop('Song Language')]= scrub_out($song->language);
  $songprops[gettext_noop('Catalog Number')]   = scrub_out($song->catalog_number);
  $songprops[gettext_noop('Bitrate')]   = scrub_out($song->f_bitrate);
  if (Access::check('interface','75')) {
	    $songprops[gettext_noop('Filename')]   = scrub_out(utf8_encode($song->file)) . " " . $song->f_size;
	  }
  
  if ($song->update_time) {
    $songprops[gettext_noop('Last Updated')]   = date("d/m/Y H:i",$song->update_time);
  }
  $songprops[gettext_noop('Added')]   = date("d/m/Y H:i",$song->addition_time);
  if (AmpConfig::get('show_played_times')) {
    $songprops[gettext_noop('# Played')]   = scrub_out($song->object_cnt);
  }

  if (AmpConfig::get('show_lyrics')) {
     $songprops[gettext_noop('Lyrics')]   = $song->f_lyrics;
  }

    foreach ($songprops as $key => $value) 
    {
        if (trim($value) or $key == 'Genre') 
        {
          $rowparity = UI::flip_class();
	      if ($key == 'Genre' and Access::check('interface','25'))
	      {
	        $box = '<form method="post" id="song_genre_form" action="javascript.void(0);">';
	      	$box .= '<select id="song_genre" name="tag_id">';
	      	$tags = Tag::get_tag_names();
		    foreach ($tags as $tag) 
			{     	
				if ($tag['name'] == $value)
	      			$box .= '<option selected value="'.$tag['id'].'">'.$tag['name'].'</option>';
				else
	      			$box .= '<option value="'.$tag['id'].'">'.$tag['name'].'</option>';
			}
	      	$box .= '</select>';
	      	$box .= Ajax::observe('song_genre','change',Ajax::action('?page=tag&action=save_tag&song_id=' . $song->id ,'song_genre','song_genre_form'));
	      	$box .= '</form>';
	      	
	      	echo "<dt class=\"".$rowparity."\">" . _($key) . "</dt><dd class=\"".$rowparity."\">" . $box . "</dd>";
	      }
	      else
	      {
	      echo "<dt class=\"".$rowparity."\">" . T_($key) . "</dt><dd class=\"".$rowparity."\">" . $value . "</dd>";
	      }
        }
      }

  $images = Song::get_art_from_tag($song->file);
  if (count($images)) {
  	$rowparity = UI::flip_class();
  	echo "<dt class=" . $rowparity .">" . "Cover in mp3-Tag" . "</dt>";
  	$image_url = AmpConfig::get('web_path') . '/image.php?type=song_tag&song_id=' . $song->id .'&dummy='.time();
  	$Art = new Art('');
  	$dimensions = Core::image_dimensions(Art::get_from_source($images, 'album'));
  
  	echo("<dd class=\"".$rowparity."\">");
  	echo('<div id="mp3_cover">');
  	echo Ajax::text('?page=musicbrainz&action=show_mp3_cover&song_id=' . $song->id,"Show",'song_cover_' . $song->id);
  	echo('</div>');
  	
  	if (is_array($dimensions)) {
  		echo(intval($dimensions['width']).'x'.intval($dimensions['height']));
  	}
  	echo("</dd>\n");
  }
  
  
  if (Access::check('interface','75')) {
  	
  	  if (!empty($song->band) && !empty($song->album) ) 
  	  {
  		$album = new Album($song->album);
  		$album_name = $album->name;
  		if ($album_name <> T_('Unknown (Orphaned)')) {
	  		$album_path = AmpConfig::get('album_path') . get_allowed_dirname($song->band) . "\\" . get_allowed_dirname($album_name);
	  		
		    $filename = utf8_encode($song->file);
		    $filename = substr(strrchr($filename, '\\'), 1);
		    $file_target = $album_path.'\\'.$filename;
		    $target = utf8_decode($file_target);
		    if ($target <> $song->file)
	  		{	  	
	  			$rowparity = UI::flip_class();
		  		echo "<dt class=" . $rowparity .">" . "Move file to" . "</dt>";	
		  		echo('<dd>');
		  		echo('<div id="mp3_cover">');
		  		echo Ajax::text('?page=musicbrainz&action=move_file&song_id=' . $song->id,$album_path,'move_file_' . $song->id);
		  		echo('</div>');
		  		echo("</dd>\n");
  			}
  		}
  	  }
  	
	  echo "<dt class=" . UI::flip_class() .">" . "Search" . "</dt>";
	  echo "<dd class=\"".$rowparity."\">" .  Ajax::text('?page=musicbrainz&action=search_song&song_id=' . $song->id,"Musicbrainz",'musicbrainz_song_' . $song->id) . "<br>";
	  if ($_SESSION['with_compilation'] == TRUE)
	  {
	  	echo T_('With Compilations') . '<input type="checkbox" id="id_compilation" checked="checked"  />'. "</dd>";
	  }
	  else
	  {
	  	echo T_('With Compilations') . '<input type="checkbox" id="id_compilation" />'. "</dd>";
	  }
	  echo Ajax::observe('id_compilation', 'click', Ajax::action('?page=musicbrainz&action=switch_compilation',''));
  }
  
  
?>
</dl>


<?php UI::show_box_bottom(); ?>

<div id="MusicbrainzContent"></div>

