<?php

/**
 * webservice external file
 *
 * @package    component
 * @category   external
 * @copyright  2021 Bogdan Stochanskyi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/externallib.php");
require_once("$CFG->dirroot/grade/querylib.php");
require_once("$CFG->libdir/gradelib.php");


class local_webservice_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_users_parameters() {
        return new external_function_parameters(
            array()
        );
    }

    /**
     * The function itself
     * @return string welcome message
     */
    public static function get_users() {
        return get_users();
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_users_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_RAW, 'some user id'),
                    'username' => new external_value(PARAM_TEXT, 'multilang compatible username'),
                    'firstname' => new external_value(PARAM_TEXT, 'multilang compatible firstname'),
                    'lastname' => new external_value(PARAM_TEXT, 'multilang compatible lastname'),
                    'city' => new external_value(PARAM_TEXT, 'multilang compatible city'),
                    'description' => new external_value(PARAM_RAW, 'just some text'),
                    'email' => new external_value(PARAM_EMAIL, 'email'),
                )
            )
        );
    }


    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_courses_parameters() {
        return new external_function_parameters(
            array()
        );
    }

    /**
     * The function itself
     * @return string welcome message
     */
    public static function get_courses() {
        return get_courses();
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_courses_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_RAW, 'some user id'),
                    'fullname' => new external_value(PARAM_TEXT, 'multilang compatible fullname'),
                    'format' => new external_value(PARAM_TEXT, 'multilang compatible format'),
                    'category' => new external_value(PARAM_INT, 'category'),
                    'startdate' => new external_value(PARAM_INT, 'startdate'),
                    'enddate' => new external_value(PARAM_INT, 'enddate'),
                )
            )
        );
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_enrolled_users_parameters() {
        return new external_function_parameters(
            array()
        );
    }

    /**
     * The function itself
     * @return string welcome message
     */
    public static function get_enrolled_users() {
        $users = get_users();
        $enrolled_users = array();
        foreach ($users as $user) {
            $user_courses = enrol_get_users_courses($user->id);
            if (count($user_courses) === 0) {
                continue;
            }
            $enrolled_users[$user->id]['userid'] = $user->id;
            $enrolled_users[$user->id]['courses'] = $user_courses;
            foreach ($user_courses as $course) {
                $enrolled_users[$user->id]['courses'][$course->id]->grade = grade_get_course_grade($user->id,
                    $course->id);
            }
        }

        return $enrolled_users;
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_enrolled_users_returns() {
        return new external_multiple_structure(
            new external_single_structure(array(
                    'userid' => new external_value(PARAM_RAW, 'id of user'),
                    'courses' => new external_multiple_structure(
                        new external_single_structure(
                            array(
                                'id' => new external_value(PARAM_RAW, 'id of course'),
                                'shortname' => new external_value(PARAM_RAW, 'short name of course'),
                                'fullname' => new external_value(PARAM_RAW, 'long name of course'),
                                'visible' => new external_value(PARAM_RAW, '1 means visible, 0 means hidden course'),
                                'grade' => new external_single_structure(
                                    array(
                                        'item' => new external_single_structure(
                                            array(
                                                'scaleid' => new external_value(PARAM_INT,
                                                    'The ID of the custom scale or 0'),
                                                'name' => new external_value(PARAM_RAW, 'The module name'),
                                                'grademin' => new external_value(PARAM_FLOAT, 'Minimum grade'),
                                                'grademax' => new external_value(PARAM_FLOAT, 'Maximum grade'),
                                                'gradepass' => new external_value(PARAM_FLOAT,
                                                    'The passing grade threshold'),
                                                'locked' => new external_value(PARAM_BOOL,
                                                    'false means not locked, true is a lock'),
                                                'hidden' => new external_value(PARAM_BOOL,
                                                    'false means not hidden, true hide until'),

                                            )
                                        ),
                                        'str_grade' => new external_value(PARAM_RAW, 'String declaration of grade'),
                                        'str_long_grade' => new external_value(PARAM_RAW,
                                            'String declaration of grade'),
                                        'str_feedback' => new external_value(PARAM_RAW, 'String declaration of grade'),
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );
    }
}