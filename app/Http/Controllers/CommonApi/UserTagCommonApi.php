<?php

namespace App\Http\Controllers\CommonApi;

use App\Http\Controllers\ReturnCode;
use App\UserTag;

class UserTagCommonApi
{
    public static function addUserTag($user_id, $tag_id, $weight)
    {
        $retval = UserTag::create(['user_id' => $user_id, 'tag_id' => $tag_id, 
                                   'weight' => $weight]); 
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function updateUserTag($usertag_id, $weight)
    {
        $retval = UserTag::where(['id' => $usertag_id])->update(['weight' => $weight]); 
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function deleteUserTag($usertag_id)
    {
        $retval = UserTag::where(['id' => $usertag_id])->delete(); 
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }
}
