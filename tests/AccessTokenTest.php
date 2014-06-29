<?php

use Anecka\retsrabbit;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class AccessTokenTest extends TestCase {

  public function testValidAccessToken() {
    //mock the response
    $json = '{"access_token":"123"}';
    $rets_client = $this->_setupMockClient($json, 200);

    //this is the actual test
    $access_token = $rets_client->getAccessCode("id", "secret");

    $this->assertTrue($access_token == '123');
  }

  public function testInvalidAccessToken() {
    //mock the response

    $json = '{"error":"invalid_client", "error_description": "Client authentication failed"}';
    $rets_client = $this->_setupMockClient($json, 401);

    $this->setExpectedException('GuzzleHttp\Exception\ClientException');
    //this is the actual test
    $access_token = $rets_client->getAccessCode("id", "secret");
    $this->assertTrue($access_token == '123');
  }


}
