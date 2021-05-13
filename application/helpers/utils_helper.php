<?php

function e($string, $ucfirst = false) {

    if (lang($string)) {

        if ($ucfirst)
            return ucfirst(lang($string));
        else
            return lang($string);

    } else {
        
        /*
        $CI = & get_instance();

        echo "***";
        $add = '$lang[\'' . str_replace('\"', '"', addslashes($string)) . '\'] = \'' . str_replace('\"', '"', addslashes($string)) . '\';' . PHP_EOL;

        $language = $CI->config->item('language');

        file_put_contents('./application/language/' . $language . '/'.$language.'_lang.php', $add, FILE_APPEND | LOCK_EX);

        $CI->lang->is_loaded = array();

        $CI->load->language($language, $language);
        */

        if ($ucfirst)
            return ucfirst($string);
        else
            return $string;

    }


}

function print_date($input)
{
    $CI = &get_instance();  //get instance, access the CI superobject
    $format = $CI->session->userdata('conf_date_format');

    if ($format == 1) {

        $converted = date("Y-m-d H:i", strtotime($input));

    } else if ($format == 2) {

        $converted = date("d-m-Y H:i", strtotime($input));

    } else if ($format == 3) {

        $converted = date("m-d-Y h:i A", strtotime($input));

    }

    return $converted;
}

function get_datetimepicker_format()
{
    $CI = &get_instance();  //get instance, access the CI superobject
    $format = $CI->session->userdata('conf_date_format');

    if ($format == 1) {

        $converted = 'YYYY-MM-DD H:mm';

    } else if ($format == 2) {

        $converted = 'DD-MM-YYYY H:mm';

    } else if ($format == 3) {

        $converted = 'MM-DD-YYYY H:mm';

    }

    return $converted;
}


?>