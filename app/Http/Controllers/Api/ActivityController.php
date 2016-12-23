<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use LucaDegasperi\OAuth2Server\Authorizer;

use App\Http\Controllers\ReturnCode;
use App\Http\Controllers\CommonApi\ActivityCommonApi;
use App\Http\Controllers\CommonApi\UserActivityCommonApi;
use App\User;

class ActivityController extends Controller
{
    public function __construct()
    {
    }

    public function getActivity(Request $request, Authorizer $authorizer, $activity_id)
    {
        $retval = ActivityCommonApi::getActivityDetail($activity_id);

        return response()->json((new ResultFormat($retval[0], $retval[1]))->toArray());
    }

    public function createActivity(Request $request, Authorizer $authorizer)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();
 
        if (!$request->has('title')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $title = $request->input('title');

        if ($request->has('detail')) {
            $detail = $request->input('detail');
        } else {
            $detail = NULL;
        }

        if (!$request->has('headcount')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $headcount = $request->input('headcount');

        if (!$request->has('recruit_deadline')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $recruit_deadline = strtotime($request->input('recruit_deadline'));
        if (!$recruit_deadline) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }

        if (!$request->has('start_time')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $start_time = strtotime($request->input('start_time'));
        if (!$start_time) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }

        if (!$request->has('end_time')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $end_time = strtotime($request->input('end_time'));
        if (!$end_time) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }

        if (!$request->has('lat') or !$request->has('lng')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $lat = floatval($request->input('lat'));
        $lng = floatval($request->input('lng'));

        $retval = ActivityCommonApi::addActivity($title, $detail, $headcount, $recruit_deadline, 
                                                 $start_time, $end_time, $lat, $lng, $user->id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray());
    }

    public function updateActivity(Request $request, Authorizer $authorizer, $activity_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        if ($request->has('title')) {
            $title = $request->input('title');
        } else {
            $title = NULL;
        }

        if ($request->has('detail')) {
            $detail = $request->input('detail');
        } else {
            $detail = NULL;
        }

        if ($request->has('headcount')) {
            $headcount = $request->input('headcount');
        } else {
            $headcount = NULL;
        }

        if ($request->has('recruit_deadline')) {
            $recruit_deadline = $request->input('recruit_deadline');
        } else {
            $recruit_deadline = NULL;
        }

        if ($request->has('start_time')) {
            $start_time = $request->input('start_time');
        } else {
            $start_time = NULL;
        }

        if ($request->has('end_time')) {
            $end_time = $request->input('end_time');
        } else {
            $end_time = NULL;
        }

        if ($request->has('lat')) {
            $lat = $request->input('lat');
        } else {
            $lat = NULL;
        }

        if ($request->has('lng')) {
            $lng = $request->input('lng');
        } else {
            $lng = NULL;
        }

        if ($request->has('member_count')) {
            $member_count = $request->input('member_count');
        } else {
            $member_count = NULL;
        }

        $retval = ActivityCommonApi::updateActivity($activity_id, $title, $detail, $headcount, $member_count, 
                                                    $recruit_deadline, $start_time, $end_time, $lat, $lng, $user->id);

        return response()->json((new ResultFormat($retval, NULL))->toArray());
    }

    public function deleteActivity(Request $request, Authorizer $authorizer, $activity_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();
 
        $retval = ActivityCommonApi::deleteActivity($activity_id, $user->id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray()); 
    }

    public function applyActivity(Request $request, Authorizer $authorizer, $activity_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        $retval = ActivityCommonApi::applyActivity($user->id, $activity_id);

        return response()->json((new ResultFormat($retval, NULL))->toArray());
    }

    public function quitActivity(Request $request, Authorizer $authorizer, $activity_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        $retval = ActivityCommonApi::quitActivity($user->id, $activity_id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray()); 
    }

    public function joinActivity(Request $request, Authorizer $authorizer, $user_id, $activity_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        $retval = ActivityCommonApi::joinActivity($user_id, $activity_id, $user->id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray()); 
    }

    public function rejectActivity(Request $request, Authorizer $authorizer, $user_id, $activity_id, $owner_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        $retval = ActivityCommonApi::rejectActivity($user_id, $activity_id, $user->id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray()); 
    }
}
