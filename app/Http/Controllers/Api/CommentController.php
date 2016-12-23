<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use LucaDegasperi\OAuth2Server\Authorizer;

use App\Http\Controllers\ReturnCode;
use App\Http\Controllers\CommonApi\ActivityCommonApi;
use App\Http\Controllers\CommonApi\CommentCommonApi;
use App\User;

class CommentController extends Controller
{
    public function __construct()
    {
    }

    public function createComment(Request $request, Authorizer $authorizer, $activity_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();
 
        if (!$request->has('content')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $content = $request->input('content');

        $retval = CommentCommonApi::addComment($user->id, $activity_id, $content);

        return response()->json((new ResultFormat($retval, NULL))->toArray());
    }

    public function updateComment(Request $request, Authorizer $authorizer, $activity_id, $comment_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();
 
        if (!$request->has('content')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $content = $request->input('content');

        $retval = CommentCommonApi::updateComment($user->id, $comment_id, $content);

        return response()->json((new ResultFormat($retval, NULL))->toArray());
    }

    public function deleteComment(Request $request, Authorizer $authorizer, $activity_id, $comment_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        $retval = CommentCommonApi::deleteComment($user->id, $comment_id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray()); 

    }

    public function getComments(Request $request, Authorizer $authorizer, $activity_id)
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

        $retval = CommentCommonApi::getComments($start, $limit, $activity_id);
 
        return response()->json((new ResultFormat($retval[0], $retval[1]))->toArray()); 
        
    }
}
