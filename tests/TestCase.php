<?php
use Anecka\retsrabbit;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class TestCase extends PHPUnit_Framework_TestCase {
  public function _setupMockClient($body, $response_code = 200) {
    $rets_client = new Anecka\retsrabbit\RetsRabbitClient("123");
    $resp = new Response($response_code, [], Stream::factory($body));

    $mock = new Mock([
      $resp
    ]);

    $rets_client->returnClient()->getEmitter()->attach($mock);

    return $rets_client;
  }
}
