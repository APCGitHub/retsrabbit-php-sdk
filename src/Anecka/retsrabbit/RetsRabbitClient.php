<?php
namespace Anecka\retsrabbit;

#require __DIR__.'/../../../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class RetsRabbitClient {

  var $endpoint = "https://api.retsrabbit.com/";
  var $access_token = "";
  var $client = null;
  var $assoc;
  var $hasError = false;
  var $errorMsg = "";

  public function __construct($access_token = "", $associate = false) {
    $this->client = new Client;

    $this->assoc = $associate;
    if($access_token != "") $this->setAccessToken($access_token);
  }

  public function _obj($response) {
    if($response != null && $response->getStatusCode() == "200") {
      $this->hasError = false;
      $this->errorMsg = "";

      $resObj = json_decode($response->getBody(), $this->assoc);
      return $resObj;
    } else {
      return null;
    }
  }

  public function _get($resource, $body = array()) {
    $body_opts = array_merge($body, ['access_token' => $this->access_token]);
    $response = null;

    try {
        $response = $this->client->get($this->endpoint.$resource, [
          "query"  => $body_opts
        ]);
    } catch(ClientException $e) {
        $this->hasError = true;
        $this->errorMsg = $e->getMessage();
    } catch(ServerException $e) {
        $this->hasError = true;
        $this->errorMsg = $e->getMessage();
    }

    return $response;
  }

  public function setEndpoint($url) {
    $this->endpoint = $url;
  }

  public function setAccessToken($access_token) {
    $this->access_token = $access_token;
  }

  public function returnClient() {
    return $this->client;
  }

  public function getHasError() {
      return $this->hasError;
  }

  public function getErrorMsg() {
      return $this->errorMsg;
  }

  public function getAccessCode($client_id, $client_secret, $scope = "scope1") {

    $response = $this->client->post($this->endpoint."oauth/access_token", [
      "body" => [
          "grant_type"     => "client_credentials",
          "client_id"      => $client_id,
          "client_secret"  => $client_secret,
          "scope"          => $scope
      ]
    ]);

    if($response->getStatusCode() == "200") {
      $resObj = json_decode($response->getBody());
      $this->setAccessToken($resObj->access_token);

      return $resObj->access_token;
    } else {
      return null;
    }
  }

  public function getServers() {
    $response = $this->_get("v1/server");

    return $this->_obj($response);
  }

  public function getServerMetadata($server_hash) {
    $response = $this->_get("v1/$server_hash/metadata");

    return $this->_obj($response);
  }

  public function getListing($server_hash, $listing_id) {
    $response = $this->_get("v1/$server_hash/listing/$listing_id");

    return $this->_obj($response);
  }

  public function getPhotosForListing($server_hash, $listing_id) {
    $response = $this->_get("v1/$server_hash/listing/$listing_id/photos");

    return $this->_obj($response);
  }

  public function getSearchListings($server_hash, $search) {
    $response = $this->_get("v1/$server_hash/listing/search", $search);

    return $this->_obj($response);
  }

  public function getOpenHousesForListing($server_hash, $listing_id) {
      $response = $this->_get("v1/$server_hash/open_house/$listing_id");

      return $this->_obj($response);
  }

  public function getSearchOpenHouses($server_hash, $search) {
      $response = $this->_get("v1/$server_hash/open_house/search", $search);

      return $this->_obj($response);
  }
}
