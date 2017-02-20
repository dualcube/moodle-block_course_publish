<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Course_publish block caps.
 *
 * @package block_course_publish
 * @author Sandipa Mukherjee <sandipa@dualcube.com>
 * @copyright 2015 DUALCUBE {@link http://dualcube.com/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing tag block instances.
 *
 * @package block_course_publish
 * @author Sandipa Mukherjee <sandipa@dualcube.com>
 * @copyright 2015 DUALCUBE {@link http://dualcube.com/}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_course_publish_edit_form extends block_edit_form {
    /**
     * Called to define this moodle form
     *
     * @return void
     */
    protected function specific_definition($mform) {
        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        // A sample string variable with a default value.
        $mform->addElement('text', 'config_appid', get_string('appid', 'block_course_publish'));
        $mform->setType('config_appid', PARAM_INT);
        $mform->addRule('config_appid', null, 'required', null, 'appid');
        $mform->addElement('text', 'config_secretkey', get_string('secretkey', 'block_course_publish'));
        $mform->setType('config_secretkey', PARAM_TEXT);
        $mform->addRule('config_secretkey', null, 'required', null, 'secretkey');
        $mform->addElement('textarea', 'config_message', get_string('message', 'block_course_publish'));
        $mform->setType('config_message', PARAM_TEXT);
        $mform->addRule('config_message', null, 'required', null, 'message');
        $mform->addElement('text', 'config_pageaccesstoken', get_string('pageaccesstoken', 'block_course_publish'));
        $mform->setType('config_pageaccesstoken', PARAM_TEXT);
        $mform->addRule('config_pageaccesstoken', null, 'required', null, 'pageaccesstoken');
        $mform->addElement('text', 'config_pageid', get_string('pageid', 'block_course_publish'));
        $mform->setType('config_pageid', PARAM_INT);
        $mform->addRule('config_pageid', null, 'required', null, 'pageid');
    }
}
