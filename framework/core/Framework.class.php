<?php

// framework/core/Framework.class.pph

/**
* 
*/
class Framework{
	
	public static function run(){
	 	
		self::init();

		self::Requirement();

		self::autoload();

		self::dispatch();
		
		
	}

	private static function init(){

		//define path constants

		define('DS', DIRECTORY_SEPARATOR);

		define('ROOT', getcwd() . DS);

		define('APP_PATH', ROOT.'application'.DS);

		define('FRAMEWORK_PATH', ROOT.'framework'.DS);

		define('PUBLIC_PATH', ROOT.'public'.DS);

		define('CONFIG_PATH', APP_PATH.'config'.DS);

		define('CONTROLLER_PATH', APP_PATH.'controllers'.DS);

		define('MODEL_PATH', APP_PATH.'models'.DS);

		define('VIEW_PATH', APP_PATH.'views'.DS);

		define('CORE_PATH', FRAMEWORK_PATH.'core'.DS);

		define('DB_PATH', FRAMEWORK_PATH.'databases'.DS);

		define('LIB_PATH', FRAMEWORK_PATH.'libraries'.DS);

		define('HELPER_PATH', FRAMEWORK_PATH.'helpers'.DS);

		define('UPLOAD_PATH', FRAMEWORK_PATH.'uploads'.DS);
		
		
		//define platform, controller, action, for example :

		//index.php?p=admin&c=Goods&a=add

		define('PLATFORM', isset($_REQUEST['p'])? $_REQUEST['p'] : 'home');

		define('CONTROLLER', (isset($_REQUEST['page']) && !empty($_REQUEST['page']))? $_REQUEST['page'] : 'Home');

		define('ACTION', isset($_REQUEST['act'])? $_REQUEST['act'] : 'index');


		define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);

    	define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

		//load configuration file

		$GLOBALS['config'] = include CONFIG_PATH.'config.php';

		//start session

		session_start();


	}

	//autoloading

	private static function autoload(){

		spl_autoload_register(array(__CLASS__,'load'));

	}

	//define a custom load method

	

	private static function load($classname){
		// Here simply autoload app&requo;s controller and model classes

		if (substr($classname, -10) == "Controller") {

			// controller 
			//require_once CURR_CONTROLLER_PATH.'$classname.class.php';

		}elseif (substr($classname, -5) == "Model") {

			//Model
			require_once MODEL_PATH.'$classname.class.php';

		}
	}



	//Routing and dispatching

	private static function dispatch(){
		// Instantiate the controller class and call its action method

		$controller_name 	= ucfirst(CONTROLLER);
		//. "Controller";
		$action_name		= ACTION;


		if (class_exists($controller_name)) {

    		$controller = new $controller_name;

    		$controller->$action_name();

		}else{

			self::Error('404');
		}
	}

	private static function Requirement(){

		// load core classes

		require CORE_PATH.'Loader.class.php';

		require CORE_PATH.'Mysql.class.php';
		
		require CORE_PATH.'Model.class.php';

		require CORE_PATH.'Controller.class.php';

		//load all file Controllers

		self::fetchAll(CONTROLLER_PATH);

		//load all file Models

		self::fetchAll(MODEL_PATH);

	}

	function fetchAll($folder=''){
		
		if (scandir($folder)) {
			foreach (scandir($folder) as $filename) {
    		$path 	= $folder . $filename;
    			if (is_file($path)) {
        			require $path;
    			}
			}
		}

	}

	function Error($code=''){
		$page_path	= VIEW_PATH.'/error.'.$code.'.php';

		if (file_exists($page_path)) {

			ob_start();
			require($page_path);
			echo ob_get_clean();

		}else{

			echo "undefined";

		}
	}

}
