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
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/blocks/course_publish/facebook-php-sdk-v4-4.0-dev/autoload.php');
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

class block_course_publish extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_course_publish');
    }
    public function get_content() {
        global $CFG, $OUTPUT, $COURSE, $DB;
        $ischeck = "";
        if ($this->content !== null) {
            return $this->content;
        }
        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->text = '';
        $this->content->footer = '';
        $record = new stdClass();
        $record->courseid = $COURSE->id;
        $record->link = $CFG->wwwroot."/course/view.php?id=".$COURSE->id;
        $record->callbackurl = $CFG->wwwroot."/blocks/course_publish/postlink.php?courseid=".$COURSE->id;
        $currentcontext = $this->page->context->get_course_context(false);

        if (! empty($this->config->text)) {
            $this->content->text = $this->config->text;
        }
        if (empty($currentcontext)) {
            return $this->content;
        }
        if ($this->page->course->id == SITEID) {
            $this->context->text .= "site context";
        }
        if (! empty($this->config->text)) {
            $this->content->text .= $this->config->text;
        }
        if (! empty($this->config->appid)) {
            $record->appid = $this->config->appid;
        }
        if (! empty($this->config->secretkey)) {
            $record->secretkey = $this->config->secretkey;
        }
        if (! empty($this->config->picture)) {
            $record->picture = $this->config->picture;
        }
        if (! empty($this->config->message)) {
            $record->message = $this->config->message;
        }
        if (! empty($this->config->caption)) {
            $record->caption = $this->config->caption;
        }
        if (! empty($this->config->pageaccesstoken)) {
            $record->pageaccesstoken = $this->config->pageaccesstoken;
        }
        if (! empty($this->config->pageid)) {
            $record->pageid = $this->config->pageid;
        }
        if (! empty($this->config)) {
            $ischeck = $DB->get_record('block_course_publish', array('courseid' => $COURSE->id));
            if (empty($ischeck)) {
                $lastinsertid = $DB->insert_record('block_course_publish', $record, false);
            } else {
                $sql = 'update {block_course_publish} set appid = ?, secretkey = ?, callbackurl = ?, picture = ?, link = ?,
                message = ?, caption = ?, pageaccesstoken = ?, pageid = ? where courseid = ?';
                $DB->execute($sql, array($this->config->appid, $this->config->secretkey, $record->callbackurl,
                    $this->config->picture, $record->link, $this->config->message, $this->config->caption,
                    $this->config->pageaccesstoken, $this->config->pageid, $COURSE->id));
            }
        }
        $ischeck = $DB->get_record('block_course_publish', array('courseid' => $COURSE->id));
        if ($ischeck) {
                $helper = new FacebookRedirectLoginHelper($ischeck->callbackurl, $appid = $ischeck->appid,
                $appsecret = $ischeck->secretkey);
                $this->content->text .= html_writer::link($helper->getLoginUrl(),
                get_string('loginwithfacebook', 'block_course_publish'));
        }
        return $this->content;
    }
    public function applicable_formats() {
        return array('all' => false, 'site' => true, 'site-index' => true, 'course-view' => true,
        'course-view-social' => false, 'mod' => true, 'mod-quiz' => false);
    }
    public function instance_allow_multiple() {
        return true;
    }
    public function has_config() {
        return true;
    }
    public function cron() {
        mtrace( "Hey, my cron script is running" );
        return true;
    }
}
