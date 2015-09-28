# Api
A simple API client.

```php
use Jstewmc\Api;

// let's assume that example.com has a public api that simply responds to any GET
//     request with the json '{"foo":"bar"}'
//

// create the request (defaults to GET request)
$request = new Request('http://example.com');

// create the response
$response = new Response();

// create the api client 
$client = new Client($request, $response);

// execute the request
$client->execute();

// loop through the response's data
foreach ($client->getResponse()->getData() as $key => $value) {
	echo "{$key} = {$value}";
}
```

The example above would produce the following output:

```
foo = bar
```


## Tests

Heads up! The `test_execute_returnsVoid_ifOk` test will probably fail by the time you get this library. I used a temporary access key to call Facebook's Graph API for my public profile. Just head over to Facebook's [Graph API Explorer](https://developers.facebook.com/tools/explorer), ask for a new access key, plop it into the test, update the expectations based on your profile's data, and you should be good to go. 

