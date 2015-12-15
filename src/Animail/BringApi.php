<?php
namespace Animail;

use \GuzzleHttp\Client;
use \GuzzleHttp\Exception\RequestException;

class BringApi
{
  protected $guzzle;
  protected $uid;
  protected $key;
  protected $clientUrl;

  public function __construct($uid, $key, $clientUrl)
  {
    $this->uid = $uid;
    $this->key = $key;
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
    // Call the API.
    try {
      $results = $this->guzzle()->get('/tracking.json', ['query' => ['q' => $query]]);
    } catch (\Exception $e) {
      throw new BringApiException($e->getMessage(), $e->getCode(), $e);
    }

    // Wasn't kidding about always returning an array.
    return array();
  }

  /**
   * Low-level internal methods
   */

  protected function guzzle()
  {
    if(is_null($this->guzzle))
    {
      $this->guzzle = new Client([
        'base_url' => 'https://tracking.bring.com',
        'defaults' => [
          'headers' => [
            'X-MyBring-API-Uid' => $this->uid,
            'X-MyBring-API-Key' => $this->key,
            'X-Bring-Client-URL' => $this->clientUrl
          ]
        ]
      ]);
    }
    return $this->guzzle;
  }
}
