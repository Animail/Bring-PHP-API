<?php
namespace Animail;

class BringApi
{
  protected $guzzle;
  protected $uid;
  protected $key;
  protected $clientUrl;

  /**
   * Setters
   */

  public function setUid($uid)
  {
    $this->uid = $uid;
  }

  public function setKey($key)
  {
    $this->key = $key;
  }

  public function setClientUrl($clientUrl)
  {
    $this->clientUrl = $clientUrl;
  }

  /**
   * Getters
   */

  public function getUid()
  {
    return $this->uid;
  }

  public function getKey()
  {
    return $this->key;
  }

  public function getClientUrl()
  {
    return $this->clientUrl;
  }

  /**
   * Actual API wrapping
   */

  public function track($query)
  {
    // Wasn't kidding about always returning an array.
    return array();
  }
}
