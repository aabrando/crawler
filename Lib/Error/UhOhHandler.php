<?php 

class UhOhHandler { 
    public static function handleException($error) {  
    	if (method_exists($error, 'getAttributes')) {
    		$attr = $error->getAttributes();
	    	if (isset($attr['controller'])){
	    		$attr['controller'] = strtolower(str_replace("Controller", "", $attr['controller']));
	    	}
    	}

    	$url  = @Router::url($attr);
		$msg   = PHP_EOL . 'File: '.$error->getFile() .PHP_EOL . 'Line no: '.$error->getLine() . PHP_EOL . 'Message: '. $error->getMessage();
    	$msg  .= ($url) ? PHP_EOL . 'Referral: '.$url : '';

    	$request = Router::getRequest();
		CakeLog::error($msg);

		echo $error->getMessage();
		
		if ($request->header('User-Agent') == "WebAPI"){
			echo ResponseManager::asJson(array(
				'code'		=> 404,
				'message'	=> "API: ($url) ".$error->getMessage()
				)); 
		}
		//else? keep silent
	}


    public static function handleError($code, $description, $file = null,
        $line = null, $context = null) {
    	
        list(, $level) = ErrorHandler::mapErrorCode($code);
        
        // Ignore fatal error. It will keep the PHP error message only
        // debug: 0: supress error from user, 2: show error
        if ($level === LOG_ERR) {
            return false;
        }

        return ErrorHandler::handleError(
            $code,
            $description,
            $file,
            $line,
            $context
        );
    }

}