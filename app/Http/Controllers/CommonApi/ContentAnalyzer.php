<?php

namespace App\Http\Controllers\CommonApi;

class ContentAnalyzer
{
    public static function getActivityDetail($title = '', $detail = '')
    {
        $content = $titile . $detail;
        $result = array();

        $so = scws_new();
        $so->set_dict();
        

        if ($content) {
            $so->send_text($title);
            while ($tmp = $so->get_result()) {
                print_r($tmp);
                $result[] = $tmp;
            }
        } 
   
        $so->close();

        return $result;

    } 
}
