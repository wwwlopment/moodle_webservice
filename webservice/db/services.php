<?php

/**
 * webservice Plugin to add a web service function that shows:
 *  - users list;
 *  - courses list;
 *  - enrolled users list with his rates;
 *
 * @package    local_webservice
 * @copyright  2021 Bogdan Stochanskyi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = array(
    'local_webservice_get_users' => array( // local_PLUGINNAME_FUNCTIONNAME is the name of the web service function that the client will call.
        'classname' => 'local_webservice_external', // create this class in componentdir/classes/external
        'methodname' => 'get_users', // implement this function into the above class
        'description' => 'Return users list',
        'type' => 'read', // the value is 'write' if your function does any database change, otherwise it is 'read'.
        'ajax' => false, // true/false if you allow this web service function to be callable via ajax
    ),

    'local_webservice_get_courses' => array( // local_PLUGINNAME_FUNCTIONNAME is the name of the web service function that the client will call.
        'classname' => 'local_webservice_external', // create this class in componentdir/classes/external
        'methodname' => 'get_courses', // implement this function into the above class
        'description' => 'Return courses list',
        'type' => 'read', // the value is 'write' if your function does any database change, otherwise it is 'read'.
        'ajax' => false, // true/false if you allow this web service function to be callable via ajax
    ),

    'local_webservice_get_enrolled_users' => array( // local_PLUGINNAME_FUNCTIONNAME is the name of the web service function that the client will call.
        'classname' => 'local_webservice_external', // create this class in componentdir/classes/external
        'methodname' => 'get_enrolled_users', // implement this function into the above class
        'description' => 'Return enrolled users list with his rates',
        'type' => 'read', // the value is 'write' if your function does any database change, otherwise it is 'read'.
        'ajax' => false, // true/false if you allow this web service function to be callable via ajax
    ),
);