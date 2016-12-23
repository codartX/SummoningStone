<?php

namespace App\Http\Controllers\CommonApi;

use App\Http\Controllers\ReturnCode;
use App\Comment;

class CommentCommonApi
{
    public static function addComment($user_id, $activity_id, $content)
    {
        $retval = Comment::create(['user_id' => $user_id, 'activity_id' => $activity_id, 'content' => $content]);
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function updateComment($user_id, $comment_id, $content)
    {
        $retval = Comment::where(['id' => $comment_id, 'user_id' => $user_id])->update(['content' => $content]);
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function deleteComment($user_id, $comment_id)
    {
        $retval = Comment::where(['id' => $comment_id, 'user_id' => $user_id])->delete();
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }
 
    public static function getComments($start = 0, $limit = 10, $activity_id)
    {
        $comments = Comment::where(['activity_id' => $activity_id])->orderBy('created_at', 'desc')->skip($start)->take($limit)->get();
        return array(ReturnCode::RET_SUCCESS, $comments);
    }
}
