<?php

namespace App\Http\Controllers\CommonApi;

use Phaza\LaravelPostgis\Geometries\Point;
use App\Http\Controllers\ReturnCode;
use App\Activity;
use App\User;
use App\Tag;
use App\ActivityTag;
use App\UserActivity;

class ActivityCommonApi
{
    public static function getActivityDetail($id) 
    {
        $activity = Activity::where(['id' => $id])->first();
        if (!$activity) {
            return array(ReturnCode::RET_ACTIVITY_NOT_EXIST, NULL);
        }
        return array(ReturnCode::RET_SUCCESS, $activity);
    }
    
    public static function getActivities($start = 0, $limit = 10, $search = '',
                                         $sort_col = 'recruit_deadline', $sort_dir = 'desc',
                                         $user_id = NULL, $lat = NULL, $lng = NULL, $radius = 5000)
    {
        $q = Activity::orderBy($sort_col, $sort_dir)
                   ->skip($start)->take($limit);

        if ($search) {
            $items = explode(' ', $search);
            foreach ($items as $key => $value) {
                $q = $q->where(function ($query) use ($value) {
                                   $query->where('title', 'like', '%'.$value.'%')
                                         ->orWhere('detail', 'like', '%'.$value.'%');
                               });
            }
        }

        if ($user_id != NULL) {
            $tags = UserTag::where(['user_id' => $user_id])->get();
            $q = $q->whereHas('tags', function ($query) use ($tags) {
                               $query->whereIn('name', $tags);
                               });
        }

        if ($lat != NULL and $lng != NULL and $radius != NULL) {
            $q = $q->whereRaw('ST_DWithin(location, ST_SetSRID(ST_MakePoint(?, ?), 4326), ?)', [$lng, $lat, $radius]);
        }

        $activities = $q->get();

        return array(ReturnCode::RET_SUCCESS, $activities);
    }

    public static function addActivity($title, $detail, $headcount, $recruit_deadline, 
                                       $start_time, $end_time, $lat, $lng, $owner_id) 
    {
        $attrs['title'] = $title;
        $attrs['detail'] = $detail;
        $attrs['headcount'] = $headcount;
        $attrs['member_count'] = 0;
        $attrs['recruit_deadline'] = date("Y-m-d H:i:s", $recruit_deadline);
        $attrs['start_time'] = date("Y-m-d H:i:s", $start_time);
        $attrs['end_time'] = date("Y-m-d H:i:s", $end_time);
        $attrs['owner_id'] = $owner_id;

        if ($lat != NULL and $lng != NULL) {
            $attrs['lat'] = floatval($lat);
            $attrs['lng'] = floatval($lng);
            $attrs['location'] = new Point(floatval($lat), floatval($lng));
        }
 
        $activity = Activity::create($attrs);
        if ($activity) {
            $sh = scws_open();
            scws_set_charset($sh, 'utf8');
            scws_set_dict($sh, 'TagDict.xdb');
            $title .= ' ';
            scws_send_text($sh, $title.$detail);
            $top = scws_get_tops($sh, 5);
            foreach ($top as $value) {
                $tag = Tag::firstOrCreate($value); 
                if ($tag) {
                    ActivityTag::firstOrCreate(['activity_id' => $activity->id, 'tag_id' => $tag->id]);
                }
            }
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function updateActivity($id, $title, $detail, $headcount, $member_count, $recruit_deadline, 
                                          $start_time, $end_time, $lat, $lng, $owner_id) 
    {
        $attrs = array();
        if ($title) {
            $attrs['title'] = $title;
        }
        if ($detail) {
            $attrs['detail'] = $detail;
        }
        if ($headcount) {
            $attrs['headcount'] = $headcount;
        }
        if ($member_count) {
            $attrs['member_count'] = $member_count;
        }
        if ($recruit_deadline) {
            $attrs['recruit_deadline'] = $recruit_deadline;
        }
        if ($start_time) {
            $attrs['start_time'] = $start_time;
        }
        if ($end_time) {
            $attrs['end_time'] = $end_time;
        }
        if ($lat != NULL and $lng != NULL) {
            $attrs['lat'] = floatval($lat);
            $attrs['lng'] = floatval($lng);
            $attrs['location'] = new Point(floatval($lat), floatval($lng));
        }

        if ($attrs) {
            $activity = Activity::where(['id' => $id, 'owner_id' => $owner_id])->update($attrs); 
            if ($activity) {
                if ($title or $detail) {
                    $sh = scws_open();
                    scws_set_charset($sh, 'utf8');
                    scws_set_dict($sh, 'TagDict.xdb');
                    $title = $activity->title.' ';
                    scws_send_text($sh, $title.$activity->detail);
                    $top = scws_get_tops($sh, 5);
                    ActivityTag::where(['activity_id' => $activity->id])->delete(); 
                    foreach ($top as $value) {
                        $tag = Tag::firstOrCreate($value);
                        if ($tag) {
                            ActivityTag::firstOrCreate(['activity_id' => $activity->id, 'tag_id' => $tag->id]);
                        }
                    }

                }
                return ReturnCode::RET_SUCCESS;
            } else {
                return ReturnCode::RET_DATABASE_FAIL;
            }
        }
        return ReturnCode::RET_SUCCESS;
    }

    public static function deleteActivity($id, $owner_id)
    {
        $retval = Activity::where(['id' => $id, 'owner_id' => $owner_id])->delete();
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }
}
