# Api
A simple API client.

```php
use Jstewmc\Api;

// let's assume that example.com has a public api that simply responds to any GET
//     request with the json '{"foo":"bar"}'
//

// create a new GET request
$request = new Request\Get('http://example.com');

// create the response
$response = new Response();

// create the client 
$client = new Client();

// send the request and receive the response
$response = $client->send($request)->receive($response);

// loop through the response's data
foreach ($response->getData() as $key => $value) {
	echo "{$key} = {$value}";
}
```

The example above would produce the following output:

```
foo = bar
```

## Requests

A request is set of *options* (and maybe *data*) sent to a *url* via a *method*. There are four types of requests - `Get`, `Post`, `Put`, and `Delete` - named for the HTTP methods of the same name.

### Url

Every request requires a URL when it's instantiated. 

You can get a request's URL with `getUrl()`:

```
use Jstewmc\Api;

// create a new GET request
$request = new Request\Get('http://example.com');

// get the request's url
$request->getUrl();  // returns "http://example.com"
```

If you find dealing with string URL's a pain, there are plenty of object-oriented URL libraries out there. I even made one myself, [Jsewmc\Url](https://github.com/jstewmc/url).

### Method

Every request has an HTTP method name that's the same as its classname. 

You can get a request's method name with `getMethod()`:

```
use Jstewmc\Api;

// create a new request
$request = new Request\Get('http://example.com');

// get the request's method name
$request->getMethod();  // returns "GET"
```

### Options

Every request can include options, an associative array of values indexed by [curl_setopt()](http://php.net/manual/en/function.curl-setopt.php) constants or their integer equivalents.

```php
use Jstewmc\Api;

// create a new request
$request = new Request\Get('http://example.com');

// set the request's auto-referer option
$request->setOptions([CURLOPT_AUTOREFERER => true]);
``` 

The default options are:

- `CURLOPT_HEADER` is `false` (don't include the header in the response)
- `CURLOPT_RETURNTRANSFER` is `true` (do return the output as a string)
- `CURLOPT_HTTPHEADER` is `['Accept: application/json', 'Content-type: application/json']` (do send/receive JSON)

Keep in mind, when you use the `setOptions()` method, the default options will be over-written, not merged. It's important not to over-write the `CURLOPT_RETURNTRANSFER` option. Otherwise, the library will not work!

Also, because a request's options are set last, you can use a request's options to over-write anything about the request. For example, if you wanted to change a `POST` request to a `GET` request (for some reason), you could use the following code:

```php
use Jstewmc\Api;

// create a POST request
$request = new Request\Post('http://example.com');

// over-ride the request's method
$request->setOptions([CURLOPT_CUSTOMREQUEST => 'POST']);
```

### Data

Unlike `Get` and `Delete` requests, `Put` and `Post` requests may include data, an associative array of data to include in the request's body. 

You can get and set the request's data with `getData()` and `setData()`, respectively:

```php
use Jstewmc\Api;

// create a new request
$request = new Request\Post('http://example.com');

// set the request's data
$request->setData(['foo' => 'bar', 'baz' => 'qux']);

// get the request's data
$request->getData();  // returns ['foo' => 'bar', 'baz' => 'qux']
```

The data will always be encoded as [JSON](http://www.json.org). 


## Responses

A response is the data from the service's output.

You can parse the service's output using the `parse()` method:

```php
use Jstewmc\Api;

// create a new response
$response = new Response();

// parse the service's output
// keep in mind, this would normally be handled for you by the client
//
$response->parse('{"foo":"bar"}');
```

Once you've parsed the service's response, the data is stored in the response's data property.

You can get and set the response's data with `getData()` and `setData()`, respectively:

```php
use Jstewmc\Api;

// create a new response
$reponse = new Response();

// parse the service's output
// keep in mind, this would normally be handled for you by the client
//
$response->parse('{"foo":"bar"}');

// get the response's data
$response->getData();  // returns ['foo' => 'bar']

// set the response's data (for some reason)
$response->setData(['baz' => 'qux']);

// get the response's new data
$response->getData();  // returns ['baz' => 'qux']
```

A response's data is always parsed as an associative array, not an object. 

Since responses can vary wildly between API's, it's up to you to know how to traverse the data you've received. 

## Client

The client manges the relationship between the service request and the service response. 

It has two methods `send()` and `receive()`:

```php
use Jstewmc\Api;

// create a new GET request
$request = new Request\Get('http://example.com');

// create a new response
$response = new Response();

// create a client
$client = new Client();

// send the request
$client->send($request);

// receive the response
$response = $client->receive($response);
```

The `send()` method will store the service's raw output and return the client object to allow method chaining:

```php
use Jstewmc\Api;

... instead of separate method calls like above

// use constructor and method chaining
$response = $client->send($request)->receive($response);
```

If everything goes ok, the `receive()` method will return the response with the service's data. Keep in mind, because PHP passes objects by reference, not value, you don't have to save the return value. You can just use the variable you passed into the method if you want. 

If something goes wrong while connecting to the service, receiving the response, or parsing the output, the `receive()` method will throw an exception.

## Exceptions

The following exceptions may be thrown by the `receive()` method:

- `ServiceUnavailable` if the service is unreachable (because of the request's settings) or unavailable (because of the service's status)
- `BadResponseStatus` if the reponse's status code is not `2XX` or `404`
- `BadResponseFormat` if the response is not valid JSON
- `EntityNotFound` if the entity was not found

Every exception provides the service's (string) output and (integer) status code via the `getOutput()` and `getStatus()` methods.

The `EntityNotFound` exception includes the service's parsed output via the `getResponse()` method. 

## Tests

Heads up! Before running the tests:

1. Go to [Graph API Explorer](https://developers.facebook.com/tools/explorer);
2. Get a new API GET url with a fresh access token;
3. Replace the url in the `urlFound` property of the `ClientTest` class; and, 
4. update the expectations in the `test_receive_returnsResponse_ifEntityIsFound` test.

Sorry, but I couldn't find a public API that didn't require an access token.

## Version

### dev-master

Hmm, we're not stable enough for a release quite yet.

## Author

[Jack Clayton](mailto:clayjs0@gmail.com)

## License

[MIT](https://github.com/jstewmc/api/blob/master/LICENSE)
