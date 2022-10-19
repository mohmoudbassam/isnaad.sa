<?php
/**
 * App Cache implements an object cache.
 * The Object Cache stores all of the cache data to memory only for the duration of the request.
 */

/**
 * Adds data to the cache if it doesn't already exist.
 * @param int|string $key    What to call the contents in the cache.
 * @param mixed      $data   The contents to store in the cache.
 * @param string     $group  Optional. Where to group the cache contents. Default 'default'.
 * @return bool False if cache key and group already exist, true on success
 */
if ( ! function_exists( 'mh_app_cache_add' ) ) :
function mh_app_cache_add( $key, $data, $group = '' ) {
	return MH_App_Cache::add( $key, $data, $group );
}
endif;
/**
 * Sets the data contents into the cache.
 * The cache contents is grouped by the $group parameter followed by the
 * $key. This allows for duplicate ids in unique groups.
 * @param int|string $key    What to call the contents in the cache.
 * @param mixed      $data   The contents to store in the cache.
 * @param string     $group  Optional. Where to group the cache contents. Default 'default'.
 * @param int        $expire Not Used.
 * @return true Always returns true.
 */
if ( ! function_exists( 'mh_app_cache_set' ) ) :
function mh_app_cache_set( $key, $data, $group = '' ) {
	return MH_App_Cache::set( $key, $data, $group );
}
endif;
/**
 * Retrieves the cache contents, if it exists.
 * The contents will be first attempted to be retrieved by searching by the
 * key in the cache group. If the cache is hit (success) then the contents
 * are returned.
 * @param int|string $key    What the contents in the cache are called.
 * @param string     $group  Optional. Where the cache contents are grouped. Default 'default'.
 * @return false|mixed False on failure to retrieve contents or the cache contents on success.
 */
if ( ! function_exists( 'mh_app_cache_get' ) ) :
function mh_app_cache_get( $key, $group = '' ) {
	return MH_App_Cache::get( $key, $group );
}
endif;
/**
 * Retrieves the cache contents for entire group, if it exists.
 * If the cache is hit (success) then the contents of the group
 * are returned.
 * @param string     $group Where the cache contents are grouped.
 * @return false|mixed False on failure to retrieve contents or the cache contents on success.
 */
if ( ! function_exists( 'mh_app_cache_get_group' ) ) :
function mh_app_cache_get_group( $group ) {
	return MH_App_Cache::get_group( $group );
}
endif;
/**
 * Check the cache contents, if given key and (optional) group exists.
 * @param int|string $key   What the contents in the cache are called.
 * @param string     $group Optional. Where the cache contents are grouped. Default 'default'.
 * @return bool False on failure to retrieve contents or True on success.
 */
if ( ! function_exists( 'mh_app_cache_has' ) ) :
function mh_app_cache_has( $key, $group = '' ) {
	return MH_App_Cache::has( $key, $group );
}
endif;
/**
 * Removes the contents of the cache key in the group.
 * If the cache key does not exist in the group, then nothing will happen.
 * @param int|string $key   What the contents in the cache are called.
 * @param string     $group Optional. Where the cache contents are grouped. Default 'default'.
 * @return bool False if the contents weren't deleted and true on success.
 */
if ( ! function_exists( 'mh_app_cache_delete' ) ) :
function mh_app_cache_delete( $key, $group = '' ) {
	return MH_App_Cache::delete( $key, $group );
}
endif;
/**
 * Clears the object cache of all data.
 * @return true Always returns true.
 */
if ( ! function_exists( 'mh_app_cache_flush' ) ) :
function mh_app_cache_flush() {
	return MH_App_Cache::flush();
}
endif;