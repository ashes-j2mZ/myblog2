<?php
    // last edited 2020年6月22日 月曜日 15:37
    namespace classes\common;

    /**
    * throws system error exceptions
    */
    class SystemErrorException extends \Exception
    {
        /**
        * constructor
        */
        public function __construct($code, array $args = [])
        {
            $message = vsprintf( ExceptionCode::getMessage($code), $args );
            self::writeLog( vsprintf($message, $args) );
            self::sendMail( vsprintf($message, $args) );
            parent::__construct($message, $code);
        }

        /**
        * email admin
        * @param type $message
        */
        private static function sendMail($message)
        {
            // todo
        }

        /**
        * record error log
        * @param type $message
        */
        private static function writeLog($message) {
            // todo
        }
    }

 ?>
