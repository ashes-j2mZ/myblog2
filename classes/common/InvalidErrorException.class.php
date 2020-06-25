<?php
// last edited 2020年6月18日 木曜日 17:56
  namespace classes\common;
  /**
   *
   */
  class InvalidErrorException extends \Exception
  {

    function __construct($code, \Exception $previous = null)
    {
      $message = ExceptionCode::getMessage($code);
      parent::__construct($message, $code, $previous);
    }
  }

 ?>
