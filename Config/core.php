<?php

	Configure::write('debug', 2);

	/*
	Configure::write('Error', array(
		'handler' => 'ErrorHandler::handleError',
		'level' => E_ALL & ~E_DEPRECATED,
		'trace' => true
	));

	Configure::write('Exception', array(
		'handler' => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	));
 	*/


	/*  
	*/ 

	Configure::write('Error', array(
		'handler'  => 'UhOhHandler::handleError',
		'level'    => E_ALL & ~E_DEPRECATED,
		'renderer' => 'AppErrorRenderer', 
		'trace' => true
	)); 

	Configure::write('Exception', array(
		'handler'  => 'UhOhHandler::handleException',
		'renderer' => 'AppExceptionRenderer', 
		'log' => true
	));

	Configure::write('App.encoding', 'UTF-8');
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));
	//Configure::write('App.fullBaseUrl', 'http://example.com');
	//Configure::write('App.imageBaseUrl', 'img/');
	//Configure::write('App.cssBaseUrl', 'css/');
	//Configure::write('App.jsBaseUrl', 'js/');

	//Configure::write('Routing.prefixes', array('y'));

	//Configure::write('Cache.disable', true);
	Configure::write('Cache.check', true);
	//Configure::write('Cache.viewPrefix', 'prefix');

	Configure::write('Security.level','medium');
	Configure::write('Session', array(
		'defaults'      => 'cake',
	    'timeout' 	    => 2880,      // auto logout after 60 minutes x 44
	    'cookieTimeout' => 2880,	  // auto logout after 60 minutes x 48
        'checkAgent'     => false,
        'autoRegenerate' => true,
	)); 

	Configure::write('Security.salt',   	 'dfiu74DmruiF16dl2495lkjLKdfg043Ar33gs0i24CORES');
	Configure::write('Security.cipherSeed',  '4900233251448133669963366');
	//Configure::write('Security.salt', 		 'Ba9r9RJ1opdifs8fds8241ngDfgd9jfgd1wrC9mi');
	//Configure::write('Security.cipherSeed',  '19473479814654146314742404547');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */


    Configure::write('Security.secret',  'AlTu6aewruif3Kdl4395lkjLKdfg043Ar33gs0i2SalTed');
    Configure::write('Security.frontend','kVOamBtMyuM8Un3MWTeK6ZmXCBd3qsXsNY2bLDX7v1x6jw2Bd2N95j97');
	Configure::write('Security.key',     '5afb6dd4ff886b51968f197aa8b379c6'); //32 bit length

	//Configure::write('Asset.timestamp', true);
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

	date_default_timezone_set('Asia/Jakarta');

/**
 *
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'File', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 * 		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 		'lock' => false, //[optional]  use file locking
 * 		'serialize' => true, //[optional]
 * 		'mask' => 0664, //[optional]
 *	));
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Apc', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Xcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *		'user' => 'user', //user from xcache.admin.user settings
 *		'password' => 'password', //plaintext password (xcache.admin.pass)
 *	));
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Memcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'persistent' => true, // [optional] set this to false for non-persistent connections
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *	));
 *
 *  Wincache (http://php.net/wincache)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Wincache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 */

/**
 * Configure the cache handlers that CakePHP will use for internal
 * metadata like class maps, and model schema.
 *
 * By default File is used, but for improved performance you should use APC.
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in bootstrap.php for more info on the cache engines available
 *       and their settings.
 */
$engine = 'File';

if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
    $engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') > 0) {
	$duration = '+10 seconds';
}

// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'myapp_';

/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

/**
 * Configure the cache for model and datasource caches. This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_model_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

    Cache::config('_app_model_', array(
        'engine'    => $engine,
        'prefix'    => 'model_cache_',
        'path'      => CACHE . 'persistent' . DS,
        'serialize' => ($engine === 'File'),
        'duration'  => '+3 days'
    ));

    Cache::config('oneday', array(
        'engine'    => $engine,
        'prefix'    => 'oneday',
        'path'      => CACHE . 'persistent' . DS,
        'serialize' => ($engine === 'File'),
        'duration'  => '+1 days'
    ));
    
    Cache::config('threedays', array(
        'engine'    => $engine,
        'prefix'    => 'threedays',
        'path'      => CACHE . 'persistent' . DS,
        'serialize' => ($engine === 'File'),
        'duration'  => '+3 days'
    ));
    
    Cache::config('_user_model_cache', array(
        'engine'    => $engine,
        'prefix'    => '_user_model_cache',
        'path'      => CACHE . 'persistent' . DS,
        'serialize' => ($engine === 'File'),
        'duration'  => '+1 days'
    )); 

Configure::load('settings');
