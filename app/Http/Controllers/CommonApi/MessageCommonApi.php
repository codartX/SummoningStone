<?php

namespace App\Http\Controllers\CommonApi;

use App\Http\Controllers\ReturnCode;
use App\Message;

class MessageCommonApi
{
    public static function addMessage($from_id, $to_id, $title, $content)
    {
        $retval = Message::create(['from_id' => $from_id, 'to_id' => $activity_id, 'title' => $title,
                                   'content' => $content]);
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function openMessage($to_id, $message_id)
    {
        $retval = Message::where(['id' => $message_id, 'to_id' => $to_id])->update(['opened' => True]);
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function deleteMessage($to_id, $message_id)
    {
        $retval = Message::where(['id' => $message_id, 'to_id' => $to_id])->delete();
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function getMessages($start = 0, $limit = 10, $to_id)
    {
        $messages = Message::where(['to_id' => $to_id])->orderBy('created_at', 'desc')->skip($start)->take($limit)->get();
        return array(ReturnCode::RET_SUCCESS, $messages);
    }
}
