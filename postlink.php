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

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_login();
require_once($CFG->dirroot.'/blocks/course_publish/facebook-php-sdk-v4-4.0-dev/autoload.php');
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;
GLOBAL $DB;
$plugin = 'block_course_publish';
$courseid = optional_param('courseid', 0, PARAM_INT);
if ($courseid != 0) {
    $coursepublish = $DB->get_record('block_course_publish', array('courseid' => $courseid));
    $coursenamepublish = $DB->get_record('course', array('id' => $courseid));
    $coursecontext = context_course::instance($courseid);
    $isfile = $DB->get_records_sql("Select * from {files} where contextid = ? and filename != ? and filearea = ?", array($coursecontext->id, ".", "overviewfiles"));
    if ($isfile) {
        foreach ($isfile as $key1 => $isfilevalue) {
            $courseimage = $CFG->wwwroot . "/pluginfile.php/" . $isfilevalue->contextid . "/" . $isfilevalue->component . "/" . $isfilevalue->filearea . "/" . $isfilevalue->filename;
        }
    }
    if (!empty($courseimage)) {
        $coursepublishpicture = $courseimage;
    } else {
        $coursepublishpicture = $CFG->wwwroot . "/blocks/course_publish/image/nopic.jpg";
    }
    FacebookSession::setDefaultApplication($coursepublish->appid, $coursepublish->secretkey);
    // If you already have a valid access token.
    $session = new FacebookSession($coursepublish->pageaccesstoken);
    if ($session) {
        try {
            $response = (new FacebookRequest(
            $session, 'POST', '/'.$coursepublish->pageid.'/feed', array(
            'link' => $coursepublish->link,
            'message' => $coursepublish->message,
            'picture' => $coursepublishpicture,
            'caption' => $coursenamepublish->fullname
            )))->execute()->getGraphObject();
            echo 'Successfully Posted ';
            echo "Posted with id: " . $response->getProperty('id');
        } catch (FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
        }
    }
    redirect($CFG->wwwroot.'/course/view.php?id='.$courseid);
}
redirect($CFG->wwwroot);
