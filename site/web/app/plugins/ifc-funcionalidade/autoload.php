<?php

class AutoLoader{
	protected static $paths = array(
		"include/",
		"acfs/",
		"admin_menus/",
		"consultas/",
	);
	public static function load($class){
		$classPath = strtolower($class) . '.php';
		foreach (self::$paths as $path) {
			if (is_file(plugin_dir_path(__FILE__) . $path . $classPath)){
				require_once $path . $classPath;
				return;
			}
		}
	}
}

spl_autoload_register('AutoLoader::load');
