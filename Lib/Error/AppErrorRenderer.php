<?php 
class AppErrorRenderer {
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