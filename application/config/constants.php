<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *
 * COLORS
 */
$colors = array(

    0 => '',

    // Red
    1 => '#F44336',
    2 => '#EF5350',
    3 => '#FF1744',
    4 => '#9C27B0',

    // GREEN
    5 => '#4CAF50',
    6 => '#66BB6A',
    7 => '#69F0AE',
    8 => '#009688',

    // BLUE
    9 => '#3F51B5',
    10 => '#2196F3',
    11 => '#03A9F4',
    12 => '#3D5AFE',

    // Yellow
    13 => '#FFC107',
    14 => '#FFD54F',
    15 => '#FBC02D',

    // Special
    16 => '#607D8B',
    17 => '#9E9E9E',
    18 => '#E0E0E0',
    19 => '#795548',
    20 => '#FF5722',
    21 => '#E91E63',
    23 => '#000000'
);
define('TASK_COLORS', serialize($colors));

$background_colors = array(

    0 => '#212121',

    1 => '#ffcdd2',
    2 => '#F8BBD0',
    3 => '#E1BEE7',
    4 => '#D1C4E9',
    5 => '#C5CAE9',
    6 => '#BBDEFB',
    7 => '#B3E5FC',
    8 => '#B2EBF2',
    9 => '#B2DFDB',
    10 => '#C8E6C9',
    11 => '#DCEDC8',
    12 => '#F0F4C3',
    13 => '#FFF9C4',
    14 => '#FFECB3',
    15 => '#FFE0B2',
    16 => '#FFCCBC',
    17 => '#D7CCC8',
    18 => '#F5F5F5',
    19 => '#CFD8DC',
);

define('BACKGROUND_COLORS', serialize($background_colors));

$navbar_colors = array(

    0 => '#101010',

    1 => '#b71c1c',
    2 => '#880E4F',
    3 => '#4A148C',
    4 => '#311B92',
    5 => '#1A237E',
    6 => '#0D47A1',
    7 => '#01579B',
    8 => '#006064',
    9 => '#004D40',
    10 => '#1B5E20',
    11 => '#33691E',
    12 => '#827717',
    13 => '#F57F17',
    14 => '#FF6F00',
    15 => '#E65100',
    16 => '#BF360C',
    17 => '#3E2723',
    18 => '#212121',
    19 => '#263238',
);

define('NAVBAR_COLORS', serialize($navbar_colors));


$container_colors = array(

    0 => '#101010',

    1 => '#f44336',
    2 => ' #E91E63',
    3 => '#9C27B0',
    4 => '#673AB7',
    5 => '#3F51B5',
    6 => '#2196F3',
    7 => '#03A9F4',
    8 => '#00BCD4',
    9 => '#009688',
    10 => '#4CAF50',
    11 => '#8BC34A',
    12 => '#CDDC39',
    13 => '#FFEB3B',
    14 => '#FFC107',
    15 => '#FF9800',
    16 => '#FF5722',
    17 => '#795548',
    18 => '#9E9E9E',
    19 => '#607D8B'
);

define('CONTAINER_COLORS', serialize($container_colors));

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

