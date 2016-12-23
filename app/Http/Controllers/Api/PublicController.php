<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\CommonApi\ActivityCommonApi;

class PublicController extends Controller
{
    public function __construct()
    {
        //public
    }

    public function getActivitiesList(Request $request)
    {
        if ($request->has('start')) {
            $start = $request->input('start');
        } else {
            $start = 0;
        }

        if ($request->has('limit')) {
            $limit = $request->input('limit');
        } else {
            $limit = 10;
        }

        if ($request->has('search')) {
            $search = $request->input('search');
        } else {
            $search = '';
        }

        if ($request->has('user_id')) {
            $user_id = $request->input('user_id');
        } else {
            $user_id = NULL;
        }

        if ($request->has('lat') and $request->has('lng')) {
            $lat = floatval($request->input('lat'));
            $lng = floatval($request->input('lng'));
        } else {
            $lat = NULL;
            $lng = NULL;
        }
       
        $retval = ActivityCommonApi::getActivities($start, $limit, $search, 
                                                   'recruit_deadline', 'desc',
                                                   $user_id, $lat, $lng, 5000);

        return response()->json((new ResultFormat($retval[0], $retval[1]))->toArray()); 
    }

}
