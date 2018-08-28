<?php

namespace App\Helpers;
use Carbon\Carbon;
use Cache;

class CacheHelper
{

    /**
     * TODO: GET CACHING NAME WITH SLUG AND ACTION NAME
     * @param $slug
     * @param $actionName
     * @return string
     */
    public  static  function objectCacheName($slug, $actionName){
        $_tmpCacheName = "";
        if(isset($slug) && isset($actionName)){
            $_tmpActionName = substr(class_basename($actionName), (strpos(class_basename($actionName), '@') + 1));
            $_tmpCacheName =  'movie_caching_' . $_tmpActionName . '_' . $slug;
        }
        return md5($_tmpCacheName);
    }

    /**
     * TODO: GET CACHING NAME WITH SLUG AND ACTION NAME
     * @param $slug
     * @param $actionName
     * @return string
     */
    public  static  function objectCaching($key, $value){
        $_tmpCacheValue = null;
        if (Cache::has($key)) {
            $entry = Cache::get($key, []);
        } else {
            CacheHelper::addObjectCache($key, $value);
        }

        return $value;
    }

    /**
     * @param $key
     * @param $value
     * @return string
     */
    public static function addObjectCache($key, $value){
        $tmpCacheTime = env('SHORT_CACHE_EXPIRED', 3600);
        $expiresAt = Carbon::now()->addMinutes($tmpCacheTime);
        Cache::add($key, $value, $expiresAt);
        return '' ;
    }

}