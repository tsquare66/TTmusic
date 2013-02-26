<?php
/* vim:set tabstop=4 softtabstop=4 shiftwidth=4 noexpandtab: */
/*
 Copyright 2009, 2010 Timothy John Wood, Paul Arthur MacIain

 This file is part of php_musicbrainz
 
 php_musicbrainz is free software: you can redistribute it and/or modify
 it under the terms of the GNU Lesser General Public License as published by
 the Free Software Foundation, either version 2.1 of the License, or
 (at your option) any later version.
 
 php_musicbrainz is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Lesser General Public License for more details.
 
 You should have received a copy of the GNU Lesser General Public License
 along with php_musicbrainz.  If not, see <http://www.gnu.org/licenses/>.
*/
class mbUser {
    private $name;
    private $showNag = false;
    private $types = array();

    public function __construct() {
    }

    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }

    public function getShowNag() {
        return $this->showNag;
    }

    public function setShowNag($value) {
        $this->setShowNag = $value;
    }

    public function addType($type) {
        $this->types[] = $type;
    }

    public function getNumTypes() {
        return count($this->types);
    }

    public function getType($i) {
        return $this->types[$i];
    }
}
?>
