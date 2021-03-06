# Description

API wrapper for the [Crembl](http://www.crembl.be) web service.

Please note that we are in no way affiliated with neither Crembl nor bpost. Issues regarding this API wrapper can be filed
at our [GitHub page](https://github.com/torfs-ict/crembl/issues), while issues regarding to the actual API should be filed
with [Crembl](http://www.crembl.be/en/more/contact/).

# Usage

Before using this API make sure to check out the official [documentation](http://www.crembl.be/en/more/crembl-downloads).
The API only has three methods:

1. Creating a task (i.e. document to be sent): `createTask`.
2. Uploading a file for an existing task: `uploadFile` or `uploadFileFromString`.
3. Retrieve information about an existing task: `getTaskInfo`.

# Error handling

Whenever an error occurs, the client will throw an exception of type [`Crembl\Exception`](src/Exception/Exception.php), where you can find the
actual error information by calling the `getInfo()` method.

# Examples

```php
use bpost\Crembl\Client;
use bpost\Crembl\Config\TaskConfig;

$client = new Client('<secret>');
```

## Creating a task

```php
$task = new TaskConfig();
$task
    ->setDocumentTypeRegular()
    ->setAddresseeLine1('Microsoft Belgium')
    ->setAddresseeLine2('Corporate Village - Bayreuth Building')
    ->setAddressCountry('BE')
    ->setAddressZipCode('1935')
    ->setAddressCity('Zaventem')
    ->setAddressStreetName('Leonardo Da Vincilaan')
    ->setAddressStreetNumber('3');
$id = $client->createTask($task);
```

Returns the id generated by the Crembl API e.g. `A12345678910111213141516171819209`.

## Uploading a file

```php
$success = $client->uploadFile($id, __DIR__ . '/myletter.pdf');
```

Returns `TRUE` in case of success, or throws an error otherwise.

## Retrieve task information

```php
$task = $client->getTaskInfo($id);
var_dump($task);
```

Returns an object of type [`Crembl\Task\Info`](src/Task/Info.php).