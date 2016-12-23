<?php

namespace App\Http\Controllers\CommonApi;

class ContentAnalyzer
{
    public static function getTags($content = '')
    {
        $result = array(); 

        $sh = scws_open();
        scws_set_charset($sh, 'utf8');
        scws_set_dict($sh, 'TagDict.xdb');

        $result = array();

        if ($content) {
            scws_send_text($sh, $content);
            $top = scws_get_tops($sh, 5);
            foreach ($top as $value) {
                $result[] = $value['word'];
            }
        } 

        return $result;
    } 
}
