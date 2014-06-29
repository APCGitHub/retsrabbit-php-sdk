<?php

use Anecka\retsrabbit;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class ServerTest extends TestCase {

  public function testGetServers() {

    $json = '[
        {
            "access_url": "http://rets.ranwrealtors.com:8080/wis/server/login",
            "server_hash": "6cb1ab75588f1af22098f4df183cb988",
            "listing_field": "MLSNumber",
            "created_at": "2014-06-23 15:52:05",
            "updated_at": "2014-06-23 15:52:05",
            "listing_date_field": "ModificationTimeStamp",
            "photo_class": "HQPhoto",
            "last_run": null
        }
    ]';

    $rets_client = $this->_setupMockClient($json, 200);

    //this is the actual test
    $servers = $rets_client->getServers();

    $this->assertTrue(sizeof($servers) == 1 && $servers[0]->server_hash != "");
  }

  public function testGetMetadata() {
    $json = '[
              {
                  "Resource": "Agent",
                  "Data": [
                      {
                          "ClassName": "Agent",
                          "VisibleName": "Agent",
                          "StandardName": "Agent",
                          "Description": "AGT",
                          "TableVersion": "1.0.1"
                        }
                  ]
                }
              ]';

    $rets_client = $this->_setupMockClient($json, 200);

    //this is the actual test
    $metadatas = $rets_client->getServerMetadata('blah_hash');

    $this->assertTrue(sizeof($metadatas) == 1 && $metadatas[0]->Resource != "");
  }
}
