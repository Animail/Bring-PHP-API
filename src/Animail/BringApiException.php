<?php
namespace Animail;

class BringApiException extends \Exception
{
  public function __construct($message = null, $code = 0, \Exception $previous = null)
  {
    // make sure everything is assigned properly
    parent::__construct($message, $code, $previous);
  }
}
