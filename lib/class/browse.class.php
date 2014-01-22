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
 * Browse Class
 *
 * This handles all of the sql/filtering
 * on the data before it's thrown out to the templates
 * it also handles pulling back the object_ids and then
 * calling the correct template for the object we are displaying
 *
 */
class Browse extends Query {

    /**
     * set_simple_browse
     * This sets the current browse object to a 'simple' browse method
     * which means use the base query provided and expand from there
     */
    public function set_simple_browse($value) {

        $this->set_is_simple($value);

    } // set_simple_browse

    /**
     * add_supplemental_object
     * Legacy function, need to find a better way to do that
     */
    public function add_supplemental_object($class, $uid) {

        $_SESSION['browse']['supplemental'][$this->id][$class] = intval($uid);

        return true;

    } // add_supplemental_object

    /**
     * get_supplemental_objects
     * This returns an array of 'class','id' for additional objects that
     * need to be created before we start this whole browsing thing.
     */
    public function get_supplemental_objects() {

        $objects = $_SESSION['browse']['supplemental'][$this->id];

        if (!is_array($objects)) { $objects = array(); }

        return $objects;

    } // get_supplemental_objects

    /**
     * show_objects
     * This takes an array of objects
     * and requires the correct template based on the
     * type that we are currently browsing
     */
    public function show_objects($object_ids = null) {

        if ($this->is_simple() || ! is_array($object_ids)) {
            $object_ids = $this->get_saved();
        }
        else {
            $this->save_objects($object_ids);
        }

        $total_count = $this->get_total();
        
        // Limit is based on the user's preferences if this is not a 
        // simple browse because we've got too much here
        if ((count($object_ids) > $this->get_start()) && 
            ! $this->is_simple() &&
            ! $this->is_static_content()) {
            $object_ids = array_slice(
                $object_ids,
                $this->get_start(),
                $this->get_offset(), 
                true
            );
        }

        // Load any additional object we need for this
        $extra_objects = $this->get_supplemental_objects();
        $browse = $this;

        foreach ($extra_objects as $class_name => $id) {
            ${$class_name} = new $class_name($id);
        }

        $match = '';
        // Format any matches we have so we can show them to the masses
        if ($filter_value = $this->get_filter('alpha_match')) {
            $match = ' (' . $filter_value . ')';
        }
        elseif ($filter_value = $this->get_filter('starts_with')) {
            $match = ' (' . $filter_value . ')';
        } elseif ($filter_value = $this->get_filter('catalog')) {
            // Get the catalog title
            $catalog = new Catalog($filter_value);
            $match = ' (' . $catalog->name . ')';
        }

        $type = $this->get_type();

        // Set the correct classes based on type
        $class = "box browse_" . $type;

        Ajax::start_container('browse_content');
        // Switch on the type of browsing we're doing
        switch ($type) {
            case 'song':
				UI::show_box_top(T_('Songs').$match.' '.T_('Item count').':'.$total_count, $class);
                Song::build_cache($object_ids);
                require_once Config::get('prefix') . '/templates/show_songs.inc.php';
                UI::show_box_bottom();
            break;
            case 'album':
				UI::show_box_top(T_('Albums').$match.' '.T_('Item count').':'.$total_count, $class);
                Album::build_cache($object_ids,'extra');
                require_once Config::get('prefix') . '/templates/show_albums.inc.php';
                UI::show_box_bottom();
            break;
            case 'user':
                UI::show_box_top(T_('Manage Users') . $match.' '.T_('Item count').':'.$total_count, $class);
                require_once Config::get('prefix') . '/templates/show_users.inc.php';
                UI::show_box_bottom();
            break;
            case 'artist':
                UI::show_box_top(T_('Artists') . $match.' '.T_('Item count').':'.$total_count, $class);
                Artist::build_cache($object_ids,'extra');
                require_once Config::get('prefix') . '/templates/show_artists.inc.php';
                UI::show_box_bottom();
            break;
            case 'live_stream':
                require_once Config::get('prefix') . '/templates/show_live_stream.inc.php';
                UI::show_box_top(T_('Radio Stations') . $match, $class);
                require_once Config::get('prefix') . '/templates/show_live_streams.inc.php';
                UI::show_box_bottom();
            break;
            case 'playlist':
                Playlist::build_cache($object_ids);
                UI::show_box_top(T_('Playlists')  . $match.' '.T_('Item count').':'.$total_count, $class);
                require_once Config::get('prefix') . '/templates/show_playlists.inc.php';
                UI::show_box_bottom();
            break;
            case 'playlist_song':
                UI::show_box_top(T_('Playlist Songs')  . $match.' '.T_('Item count').':'.$total_count, $class);
                require_once Config::get('prefix') . '/templates/show_playlist_songs.inc.php';
                UI::show_box_bottom();
            break;
            case 'playlist_localplay':
                UI::show_box_top(T_('Current Playlist'));
                require_once Config::get('prefix') . '/templates/show_localplay_playlist.inc.php';
                UI::show_box_bottom();
            break;
            case 'smartplaylist':
                UI::show_box_top(T_('Smart Playlists') . $match, $class);
                require_once Config::get('prefix') . '/templates/show_smartplaylists.inc.php';
                UI::show_box_bottom();
            break;
            case 'catalog':
                UI::show_box_top(T_('Catalogs'), $class);
                require_once Config::get('prefix') . '/templates/show_catalogs.inc.php';
                UI::show_box_bottom();
            break;
            case 'shoutbox':
                UI::show_box_top(T_('Shoutbox Records'),$class);
                require_once Config::get('prefix') . '/templates/show_manage_shoutbox.inc.php';
                UI::show_box_bottom();
            break;
            case 'flagged':
                UI::show_box_top(T_('Flagged Records'),$class);
                require_once Config::get('prefix') . '/templates/show_flagged.inc.php';
                UI::show_box_bottom();
            break;
            case 'tag':
               /* Tag::build_cache($tags);
                UI::show_box_top(T_('Tag Cloud'),$class);
                require_once Config::get('prefix') . '/templates/show_tagcloud.inc.php';
                UI::show_box_bottom();*/
            	UI::show_box_top(T_('Songs').$match.' '.T_('Item count').':'.$total_count, $class);
            	Song::build_cache($object_ids);
            	require_once Config::get('prefix') . '/templates/show_songs.inc.php';
            	UI::show_box_bottom();
            break;
            case 'video':
                Video::build_cache($object_ids);
                UI::show_box_top(T_('Videos'),$class);
                require_once Config::get('prefix') . '/templates/show_videos.inc.php';
                UI::show_box_bottom();
            break;
            case 'democratic':
                UI::show_box_top(T_('Democratic Playlist'),$class);
                require_once Config::get('prefix') . '/templates/show_democratic_playlist.inc.php';
                UI::show_box_bottom();
            default:
                // Rien a faire
            break;
        } // end switch on type
        echo '<script type="text/javascript">';
        echo Ajax::action('?page=browse&action=get_filters&browse_id=' . $this->id, '');
        echo ';</script>';

        Ajax::end_container();

    } // show_object

    /**
      * set_filter_from_request
     * //FIXME
     */
    public function set_filter_from_request($request) {
        foreach($request as $key => $value) {
            //reinterpret v as a list of int
            $list = explode(',', $value);
            $ok = true;
            foreach($list as $item) {
                if (!is_numeric($item)) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) {
                if (sizeof($list) == 1) {
                    $this->set_filter($key, $list[0]);
                }
            }
            else {
                $this->set_filter($key, $list);
            }
        }
    } // set_filter_from_request

} // browse
