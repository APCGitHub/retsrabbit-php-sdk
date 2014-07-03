Rets Rabbit Client, PHP SDK for the Rets Rabbit API
==================

Rets Rabbit Client PHP SDK is a library that makes it easy to work with the [Rets Rabbit API](http://retsrabbit.com). The API simplifies working with real estate lisitng data.

The GitHub repository for the project is here [https://github.com/patpohler/retsrabbit-php-sdk.git](https://github.com/patpohler/retsrabbit-php-sdk.git).

	//New instance of the client
	$client = new Anecka\retsrabbit\RetsRabbitClient($access_token);
	
	//Get a listing from the MLS w/ an id of '5456655'
	$listing = $client->getListing($server_id, '5456655');
	
	//Run a search for listings on a price range
	$listings = $client->getSearchListings($server_id, array('ListPrice' => '90000-100000'));
	

### Installing via Composer

The recommended way to install the SDK is through [Composer](http://getcomposer.org).

	# Install Composer
	curl -sS https://getcomposer.org/installer | php
	
Next update your project's composer.json file to include the SDK

	"require": {
		"anecka/retsrabbit": "dev-master"
	}
	
Run `composer install` to install the library, after installing you need to require Composer's autoloader:

	require 'vendor/autoload.php';
	
### Authentication

In order to use the libary, you need to have valid client credentials to Rets Rabbit. You'll need the credentials to create an access token in order to sender requests to the API.

	$client = new Anecka\retsrabbit\RetsRabbitClient;
	
	$client->getAccessCode($client_id, $client_secret);
	
	//after you get the token you can save to a session variable for future requests, tokens are valid for 10 hours
	echo $client->access_token
	
	/* instantiating the client by passing an access_token */
	
	$client = new Anecka\retsrabbit\RetsRabbitClient($_SESSION['access_token']);
	
### Getting a list of servers

To get a list of rets servers registered to your account, you can use the following method.

	$servers = $client->getServers();
	
The return will be a multi-dimensional array. Here's an example

	[
		[
			"access_url": "http://rets.ranwrealtors.com:8080/wis/server/login",
            "server_hash": "6cb1ab75588f1af22098f4df183cb988",
            "listing_field": "MLSNumber",
            "created_at": "2014-06-23 15:52:05",
            "updated_at": "2014-06-23 15:52:05",
            "listing_date_field": "ModificationTimeStamp",
            "photo_class": "HQPhoto",
            "last_run": null
		],
		...
	]
	
`server_hash` is important as you'll need it to access listing information and run MLS searches. The hash will never change, so you can save this value in an environment variable or configuration setting in your application.

### Getting metadata for the server

Getting the metadata for a server can be done by using the following method.

	$metadatas = $client->getServerMetadata($server_hash);
	
### Running a property search

To run a search for properties, just call the `getSearchListings` method and pass the server hash and an array containing the search parameters. Since fields vary from board to board, you'll need to reference the metadata for your real estate board.

	$params = array(
			'ListPrice'	=> '90000-95000',
		);
	$listings = $client->getSearchListings($server_hash, $params);
	

The return will be a multi-dimensional of stdClass objects. You can access the listing data and photos by using the `fields` and `photos` attributes.

	foreach($listings as $listing) {
		echo $listing->fields->MLSNumber;
		echo $listing->fields->ListPrice;
		
		foreach($listing->photos as $photo) {
			echo $photo->url;
		}
	}
	
### Getting a single listing

To get a single listing, use the `getListing` method and pass the server hash and the unique MLS id for the listing.

	$listing = $rets_client->getListing('6cb1ab75588f1af22098f4df183cb988', '50077235');

The return will be a single stdClass object.


*****

&copy;2014 Anecka, LLC All rights reserved.
	