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
      // GuzzleHttp\Message\Response
      $response = $this->guzzle()->get('/tracking.json', ['query' => ['q' => $query]]);
      if ($body = $response->getBody()) {
        // Body is actually a stream but its ok because json_decode casts it to string
        $json = json_decode($body, TRUE);

        // consignmentSet is always set, but the first entry might tell us about an error. (404, usually.)
        if(isset($json['consignmentSet'][0]) && isset($json['consignmentSet'][0]['error']))
        {
          // We promised to always return an array, so we'll deal with
          // 404 messages ourselves but throw exceptions for other ones.
          if($json['consignmentSet'][0]['error']['code'])
          {
            throw new BringApiErrorException($json['consignmentSet'][0]['error']['message'], $json['consignmentSet'][0]['error']['code']);
          }
          // No "else" because this trickles down to the default return value at the end of the method.
        }
        else
        {
          return $json;
        }
      }
      else
      {
        throw new BringApiClientException('Could not load response body', 500);
      }
    } catch (\Exception $e) {
      throw new BringApiClientException($e->getMessage(), $e->getCode(), $e);
    }

    // Wasn't kidding about always returning an array.
    return array(
      'consignmentSet' => array()
    );
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
