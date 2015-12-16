<?php
namespace Animail;

class BringApiErrorException extends BringApiException
{
  public function __construct($message = null, $code = 0, Exception $previous = null)
  {
    // make sure everything is assigned properly
    parent::__construct($message, $code, $previous);
  }
}
