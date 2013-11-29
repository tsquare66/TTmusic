<?php
$web_path = Config::get('web_path');

debug_event('jplayer.php' ,
'Action:'.$_REQUEST['action'],
'5');

// Switch on actions
switch ($_REQUEST['action']) {
        default:
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
                debug_event('jplayer.php' ,        'Playlist : '.json_encode($jplaylist), '5');


                require_once Config::get('prefix') . '/modules/jplayer/show_jplayer.inc.php';
                break;
} // end switch


?>