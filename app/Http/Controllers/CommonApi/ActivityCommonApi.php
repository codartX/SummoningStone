<?php

namespace App\Http\Controllers\CommonApi;

use Phaza\LaravelPostgis\Geometries\Point;
use App\Http\Controllers\ReturnCode;
use App\Activity;

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
    
    public static function getActivities($group_name = NULL, $start = 0, $limit = 10, $search = '',
                                         $sort_col = 'dev_eui', $sort_dir = 'asc')
    {
        $q = Node::orderBy($sort_col, $sort_dir)
                   ->skip($start)->take($limit);

        if ($group_name) {
            $q = $q->where('group_name', $group_name);
        }

        if ($search) {
            $q = $q->where(function ($query) use ($search) {
                               $query->where('dev_eui', 'like', '%'.$search.'%')
                                     ->orWhere('dev_addr', 'like', '%'.$search.'%')
                                     ->orWhere('description', 'like', '%'.$search.'%')
                                     ->orWhere('route_profile_name', 'like', '%'.$search.'%')
                                     ->orWhere('node_profile_name', 'like', '%'.$search.'%');
                           });
        }

        $nodes = $q->get();

        return array(ReturnCode::RET_SUCCESS, $nodes);
    }

    public static function addActivity($dev_eui, $group_name, $node_profile_name = NULL, $route_profile_name = NULL, $description = NULL,
                                       $app_key = NULL, $dev_addr = NULL, $network_session_key = NULL, $lat = NULL, $lng = NULL) 
    {
        $node = Node::where('dev_eui', $dev_eui)->first();
        if ($node) {
            return ReturnCode::RET_NODE_EXIST;
        }
        $attrs['dev_eui'] = $dev_eui;

        $attrs['group_name'] = $group_name;

        if ($node_profile_name) {
            $node_profile = NodeProfile::where('name', $node_profile_name)->first();
            if (!$node_profile) {
                return ReturnCode::RET_NODE_PROFILE_NOT_EXIST;
            }
            $attrs['node_profile_name'] = $node_profile_name;
        }

        if ($route_profile_name) {
            $route_profile = RouteProfile::where('name', $route_profile_name)->first();
            if (!$route_profile) {
                return ReturnCode::RET_ROUTE_PROFILE_NOT_EXIST;
            }
            $attrs['route_profile_name'] = $route_profile_name;
        }

        if ($description) {
            $attrs['description'] = $description;
        }

        if ($app_key) {
            $attrs['app_key'] = $app_key;
        }

        if ($dev_addr) {
            $attrs['dev_addr'] = $dev_addr;
        }

        if ($network_session_key) {
            $attrs['network_session_key'] = $network_session_key;
        }

        if ($lat != NULL and $lng != NULL) {
            $attrs['location'] = new Point(floatval($lat), floatval($lng));
        }
 
        $retval = Node::create($attrs);
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

    public static function updateActivity($dev_eui, $group_name, $node_profile_name = NULL, $route_profile_name = NULL, $description = NULL,
                                          $app_key = NULL, $dev_addr = NULl, $network_session_key = NULL, $lat = NULL, $lng = NULL) 
    {
        $node = Node::where(['dev_eui' => $dev_eui, 'group_name' => $group_name])->first();
        if (!$node) {
            return ReturnCode::RET_NODE_NOT_EXIST;
        }

        $attrs = array();

        if ($node_profile_name) {
            $node_profile = NodeProfile::where('name', $node_profile_name)->first();
            if (!$node_profile) {
                return ReturnCode::RET_NODE_PROFILE_NOT_EXIST;
            }
            $attrs['node_profile_name'] = $node_profile_name;
        }

        if ($route_profile_name) {
            $route_profile = RouteProfile::where('name', $route_profile_name)->first();
            if (!$route_profile) {
                return ReturnCode::RET_ROUTE_PROFILE_NOT_EXIST;
            }
            $attrs['route_profile_name'] = $route_profile_name;
        }

        if ($description) {
            $attrs['description'] = $description;
        }

        if ($app_key) {
            $attrs['app_key'] = $app_key;
        }

        if ($dev_addr) {
            $attrs['dev_addr'] = $dev_addr;
        }

        if ($network_session_key) {
            $attrs['network_session_key'] = $network_session_key;
        }

        if ($lat != NULL and $lng != NULL) {
            $attrs['location'] = new Point(floatval($lat), floatval($lng));
        }
 
        if ($attrs) {
            $retval = Node::where(['dev_eui' => $dev_eui, 'group_name' => $group_name])->update($attrs); 
            if ($retval) {
                return ReturnCode::RET_SUCCESS;
            } else {
                return ReturnCode::RET_DATABASE_FAIL;
            }
        }
        return ReturnCode::RET_SUCCESS;
    }

    public static function deleteActivity($id, $owner_id)
    {
        $activity = Activity::where(['id' => $id, 'owner_id' => $owner_id])->first();
        if (!$activity) {
            return ReturnCode::RET_NODE_NOT_EXIST;
        }

        $retval = Activity::where(['id' => $id, 'owner_id' => $owner_id])->delete();
        if ($retval) {
            return ReturnCode::RET_SUCCESS;
        } else {
            return ReturnCode::RET_DATABASE_FAIL;
        }
    }

}
