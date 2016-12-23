<?php

namespace App\Http\Controllers\CommonApi;

use App\Http\Controllers\ReturnCode;
use App\UserActivity;
use App\Activity;
use App\Http\Controllers\CommonApi\MessageCommonApi;

class UserActivityStatus
{
    const STATUS_APPLY   = 0;
    const STATUS_JOIN    = 1;
}

class UserActivityCommonApi
{
    public static function applyActivity($user_id, $activity_id)
    {
        $retval = UserActivity::where(['user_id' => $user_id, 'activity_id' => $activity_id])->first();
        
        if (!$retval) {
            $retval = UserActivity::updateOrCreate(['user_id' => $user_id, 'activity_id' => $activity_id, 
                                                    'status' => UserActivityStatus::STATUS_APPLY]); 
            if ($retval) {
                return ReturnCode::RET_SUCCESS;
            } else {
                return ReturnCode::RET_DATABASE_FAIL;
            }
        }
       
        return ReturnCode::RET_SUCCESS;
    }

    public static function quitActivity($user_id, $activity_id)
    {
        $retval = UserActivity::where(['user_id' => $user_id, 'activity_id' => $activity_id])->delete(); 
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function rejectedUser($user_id, $activity_id, $owner_id)
    {
        $retval = Activity::where(['owner_id' => $owner_id, 'activity_id' => $activity_id])->first();
        if (!$retval) {
            return ReturnCode::RET_ACTIVITY_NOT_EXIST;
        }

        $retval = UserActivity::where(['user_id' => $user_id, 'activity_id' => $activity_id])->delete(); 
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function joinActivity($user_id, $activity_id, $owner_id)
    {
        $retval = Activity::where(['owner_id' => $owner_id, 'activity_id' => $activity_id])->first();
        if (!$retval) {
            return ReturnCode::RET_ACTIVITY_NOT_EXIST;
        }

        $retval = UserActivity::updateOrCreate(['user_id' => $user_id, 'activity_id' => $activity_id, 
                                                'status' => UserActivityStatus::STATUS_JOIN]); 
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function getActivityApplicants($activity_id, $owner_id)
    {
        $retval = Activity::where(['owner_id' => $owner_id, 'activity_id' => $activity_id])->first();
        if (!$retval) {
            return ReturnCode::RET_ACTIVITY_NOT_EXIST;
        }

        $retval = UserActivity::where(['$activity_id' => $activity_id, 'status' => UserActivityStatus::STATUS_APPLY])
                  ->orderBy('CREATED_AT', 'desc')->get();
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function getActivityMemebers($activity_id, $owner_id)
    {
        $retval = Activity::where(['owner_id' => $owner_id, '$activity_id' => $activity_id])->first();
        if (!$retval) {
            return ReturnCode::RET_ACTIVITY_NOT_EXIST;
        }

        $retval = UserActivity::where(['$activity_id' => $activity_id, 'status' => UserActivityStatus::STATUS_JOIN])
                  ->orderBy('CREATED_AT', 'desc')->get();
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }
}
