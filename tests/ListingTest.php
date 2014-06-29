<?php

use Anecka\retsrabbit;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class ListingTest extends TestCase {

  public function testGetListing() {

    $json = '[
        {
          "AcresTotal": "",
          "AdCode": "",
          "AddressCity2": "Fond du Lac, City of",
          "AddressState": "WI",
          "AddressStreetDirection": "E",
          "AddressSubdivisionName": "",
          "AddressUnitNumber": "",
          "AgeApproximate": "75+ YEARS",
          "AppliancesIncluded": "Oven/Range-Elec.,Refrigerator,Dishwasher",
          "Architecture": "Victorian / Federal"
        }
    ]';

    $rets_client = $this->_setupMockClient($json, 200);

    //this is the actual test
    $listing = $rets_client->getListing('123', '123');

    $this->assertTrue($listing != null);
  }

  public function testGetListingPhoto() {

    $json = '[
              {
                  "id": 149,
                  "mls_id": "50077235",
                  "filename": "https://s3.amazonaws.com/rets_press_bucket//6cb1ab75588f1af22098f4df183cb988/50077235_1.jpg",
                  "created_at": "2014-06-06 00:15:59",
                  "updated_at": "2014-06-06 00:15:59"
              },
              {
                  "id": 154,
                  "mls_id": "50077235",
                  "filename": "https://s3.amazonaws.com/rets_press_bucket//6cb1ab75588f1af22098f4df183cb988/50077235_2.jpg",
                  "created_at": "2014-06-06 00:15:59",
                  "updated_at": "2014-06-06 00:15:59"
              }
            ]';

    $rets_client = $this->_setupMockClient($json, 200);

    //this is the actual test
    $photos = $rets_client->getPhotosForListing('123', '123');

    $this->assertTrue(sizeof($photos) > 0);
  }

  public function testSearchListings() {
    $json = '[
       {
        "AcresTotal": "",
        "AdCode": "",
        "AddressCity2": "Fond du Lac, City of",
        "AddressState": "WI",
        "AddressStreetDirection": "E",
        "AddressSubdivisionName": "",
        "AddressUnitNumber": "",
        "AgeApproximate": "75+ YEARS",
        "AppliancesIncluded": "Oven/Range-Elec.,Refrigerator,Dishwasher",
        "Architecture": "Victorian / Federal"
      },
      {
        "AcresTotal": "3.84",
        "AdCode": "",
        "AddressCity2": "Oshkosh, City of",
        "AddressState": "WI",
        "AddressStreetDirection": "N",
        "AddressSubdivisionName": "",
        "AddressUnitNumber": "C",
        "AgeApproximate": "21 - 30 YEARS",
        "AppliancesIncluded": "Oven/Range-Elec.,Refrigerator,Dishwasher,Washer,Dryer-Electric,Disposal,Microwave",
        "Architecture": "Other",
        "AVMIDXYN": "No",
        "AVMVOWYN": "No"
      }
    ]';

    $rets_client = $this->_setupMockClient($json, 200);

    $listings = $rets_client->getSearchListings('123',
      array('ListPrice', '90000-100000'));

    $this->assertTrue(sizeof($listings) > 0, 200);
  }
}
