<?php
    // last edited 2020年6月22日 月曜日 15:37
    namespace classes\common;

    /**
    * class defining exception codes for application
    */
    class ExceptionCode
    {
        // error codes
        const INVALID_ERR = 1000;
        const INVALID_LOGIN_FAIL = 1001;
        const APPLICATION_ERR = 2000;
        const SYSTEM_ERR = 3000;
        const TEMPLATE_ERR = 3001;
        const TEMPLATE_ARG_ERR = 3002;

        // list of error message as array
        static private $errMessage = array (
            self::INVALID_ERR => 'An error occurred.',
            self::INVALID_LOGIN_FAIL => 'Failed to login.',
            self::APPLICATION_ERR => 'An application error occurred.',
            self::SYSTEM_ERR => 'A system error occurred. The administrator will be notified.',
            self::TEMPLATE_ERR => 'Cannot find template [%s].',
            self::TEMPLATE_ARG_ERR => 'Cannot use [%s] as an argument.'
        );

        // return error message depending on type of exception caught
        static public function getMessage($error_code)
        {
            if (array_key_exists($error_code, self::$errMessage)) {
                return self::$errMessage[$error_code];
            }
        }
    }

 ?>
