# Api
A simple API client.

```php
use Jstewmc\Api;

// let's assume that example.com has a public api that simply responds to any GET
//     request with the json '{"foo":"bar"}'
//

// create a new GET request
$request = new Request\Get('http://example.com');

// create the JSON response
$response = new Response\Json();

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

```php
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

```php
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

Keep in mind, when you use the `setOptions()` method, the default options will be over-written, not merged. 

Because a request's options are set last, you can use a request's options to over-write anything about the request. For example, if you wanted to change a `POST` request to a `GET` request (for some reason), you could use the following code:

```php
use Jstewmc\Api;

// create a POST request
$request = new Request\Post('http://example.com');

// over-ride the request's method
$request->setOptions([CURLOPT_CUSTOMREQUEST => 'POST']);
```

Just be careful. It's important not to over-write the `CURLOPT_RETURNTRANSFER` option. Otherwise, the library will not work!

### Data

Unlike `Get` and `Delete` requests, `Put` and `Post` requests may include data, an associative array of key-value pairs to include in the request's body as [JSON](http://www.json.org). 

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


## Responses

A response is the data contained in the service's output.

This library supports JSON and XML responses with the `Json` and `Xml` response classes:

```php
use Jstewmc\Api;

// create a new JSON response
$json = new Response\Json();

// create a new XML response
$xml = new Response\Xml();
```

Either way, the response's data will automatically be parsed via the `parse()` method. 

Once the service's response has been parsed, the data is stored as an associative array in the response's data property. You can get and set the response's data with `getData()` and `setData()`, respectively:

```php
use Jstewmc\Api;

// create a new response
$reponse = new Response\Json();

// parse the service's output
$response->parse('{"foo":"bar"}');

// get the response's data
$response->getData();  // returns ['foo' => 'bar']

// set the response's data (for some reason)
$response->setData(['baz' => 'qux']);

// get the response's new data
$response->getData();  // returns ['baz' => 'qux']
```

Since responses can vary wildly between API's, it's up to you to know how to traverse the data you've received. 

## Client

The client manges the relationship between the request and the response. 

The client has two methods `send()` and `receive()`:

```php
use Jstewmc\Api;

// create a new GET request
$request = new Request\Get('http://example.com');

// create a new JSON response
$response = new Response\Json();

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

// using constructor and method chaining instead
$response = $client->send($request)->receive($response);
```

If everything goes ok, the `receive()` method will return the response with the service's data. Keep in mind, because PHP passes objects by reference, not value, you don't have to save the return value. You can just use the variable you passed into the method if you want. 

## Exceptions

If something goes wrong while connecting to the service, receiving the response, or parsing the output, the `receive()` method will throw an exception.

The following exceptions may be thrown by the `receive()` method:

- `ServiceUnavailable` if the service is unreachable (because of the request's settings) or unavailable (because of the service's status)
- `BadResponseStatus` if the reponse's status code is not `2XX` or `404`
- `BadResponseFormat` if the response is not valid XML or JSON (depending on response)
- `EntityNotFound` if the entity was not found

Every exception provides the service's (string) output and (integer) status code via the `getOutput()` and `getStatus()` methods.

The `EntityNotFound` exception includes the service's parsed output via the `getResponse()` method. 

## Tests

Heads up! This library uses the [API Tester](https://github.com/jstewmc/api-tester) for its unit tests. Be sure the API tester is installed (not a big deal) and running before running the tests. Otherwise, all the Client tests will fail!

## Version

### dev-master

- _Use API Tests_. Before, unit tests for the Client class finagled several public APIs. Now, it uses the API Tests library I wrote.
- _Add Xml response_. Before, every response was implicitly JSON. Now, you can (er, must) specify the response's format when instantiating the response class.

### 0.1.0 - September 29, 2015

- Initial release

## Author

[Jack Clayton](mailto:clayjs0@gmail.com)

## License

[MIT](https://github.com/jstewmc/api/blob/master/LICENSE)
