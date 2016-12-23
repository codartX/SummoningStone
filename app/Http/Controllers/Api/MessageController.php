<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use LucaDegasperi\OAuth2Server\Authorizer;

use App\Http\Controllers\ReturnCode;
use App\Http\Controllers\CommonApi\MessageCommonApi;
use App\User;

class MessageController extends Controller
{
    public function __construct()
    {
    }

    public function createMessage(Request $request, Authorizer $authorizer)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();
 
        if (!$request->has('to_id')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $to_id = $request->input('to_id');

        if (!$request->has('title')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $title = $request->input('title');

        if (!$request->has('content')) {
            return response()->json((new ResultFormat(ReturnCode::RET_INVALID_ARGS))->toArray());
        }
        $content = $request->input('content');

        $retval = MessageCommonApi::addMessage($user->id, $to_id, $title, $content);

        return response()->json((new ResultFormat($retval, NULL))->toArray());
    }

    public function openMessage(Request $request, Authorizer $authorizer, $message_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();
 
        $retval = MessageCommonApi::openMessage($user->id, $message_id);

        return response()->json((new ResultFormat($retval, NULL))->toArray());
        
    }

    public function deleteMessage(Request $request, Authorizer $authorizer, $message_id)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

        $retval = MessageCommonApi::deleteMessage($user->id, $message_id);
 
        return response()->json((new ResultFormat($retval, NULL))->toArray()); 

    }

    public function getMessages(Request $request, Authorizer $authorizer)
    {
        $client_id = $authorizer->getClientId();
        $user = User::where('client_id', $client_id)->first();

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

        $retval = MessageCommonApi::getMessages($start, $limit, $user->id);
 
        return response()->json((new ResultFormat($retval[0], $retval[1]))->toArray()); 
        
    }
}
