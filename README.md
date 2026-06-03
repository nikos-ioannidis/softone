<h1 align="center">
    Softone Web Services PHP Laravel Package
</h1>

<p align="center">
    A Laravel package that makes it easy to consume Softone ERP Web Services REST API.
</p>

<p align="center">
    <strong>Disclaimer:</strong> This is not an official package. Forked and extended from <a href="https://github.com/asikam/softone">asikam/softone</a>.
</p>

## Table of Contents

- [Introduction](#introduction)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Using SoftoneBrowser](#using-softonebrowser)
  - [Building Requests Step by Step](#building-requests-step-by-step)
- [Available Methods](#available-methods)
  - [SoftoneBrowser Methods](#softonebrowser-methods)
  - [Softone Core Methods](#softone-core-methods)
- [Examples](#examples)
- [Contributing](#contributing)
- [License](#license)

## Introduction

This package provides a simple and elegant way to interact with the Softone Web Services REST API in your Laravel applications. It handles authentication, request building, and response parsing, allowing you to focus on your application logic.

Official Softone Web Services documentation: [https://www.softone.gr/ws/](https://www.softone.gr/ws/)

## Requirements

- PHP 8.2 or higher
- Laravel 10.0 or higher

## Installation

You can install the package via composer:

```bash
composer require nikos-ioannidis/softone
```

After installing, publish the configuration file:

```bash
php artisan vendor:publish --provider="NikosIoannidis\Softone\SoftoneServiceProvider"
```

## Configuration

After publishing the configuration file, you can find it at `config/softone.php`. You'll need to set the following environment variables in your `.env` file:

```
COMPANY_AFM=your_company_afm
SOFTONE_URL=your_softone_url
SOFTONE_USER=your_username
SOFTONE_PASS=your_password
SOFTONE_APPID=your_app_id
SOFTONE_COMPANY=your_company_id
SOFTONE_BRANCH=your_branch_id
SOFTONE_MODULE=your_module_id
SOFTONE_REFID=your_ref_id
```

## Usage

### Using SoftoneBrowser

The `SoftoneBrowser` class provides a simplified interface for common operations:

```php
use NikosIoannidis\Softone\SoftoneBrowser;

// Create a new instance
$softone = new SoftoneBrowser();

// Search for customers with a specific tax ID
$softone->search("CUSTOMER", 'CUSTOMER.AFM=000000000*=;');

// Or with named parameters
$softone->search(
    object: "CUSTOMER",
    filters: 'AFM=000000000=;',
    list: 'Web',
    start: 0,
    limit: 30
);

// Access the response data
foreach ($softone->responseData as $item) {
    echo $item['CUSTOMER.AFM'] . "\n";
    echo $item['CUSTOMER.NAME'] . "\n";
}
```

### Building The Request

For more control, you can use the core `Softone` class to build your requests:

```php
use NikosIoannidis\Softone\Softone;

// Create a new instance
$softone = new Softone();

// Get browser information
$softone->setService('getBrowserInfo');
$softone->setObject('CUSTOMER');
$softone->setFilters('CUSTOMER.AFM=000000*=;');
$softone->send();

// Get browser data using the request ID from the previous request
$softone->setService('getBrowserData');
$softone->setReqId($softone->reqID);
$softone->limit(10);
$softone->send();

// Access the response data
foreach ($softone->responseData as $item) {
    echo $item['CUSTOMER.NAME'] . "\n";
    echo $item['CUSTOMER.AFM'] . "\n";
}
```

### Selector Services

```php
use NikosIoannidis\Softone\SoftoneBrowser;

$softone = new SoftoneBrowser();

// Get selector data
$softone->getSelectorData('CUSTOMER', 'search term');

// Get specific fields from a table record
$softone->selectorFields('CUSTOMER', 'CUSTID', 27, 'NAME,AFM');
```

## Available Methods

### SoftoneBrowser Methods

- `search($object, $filters, $list, $start, $limit)`: Combines getBrowserInfo and getBrowserData in one call
- `info($object, $filters, $list)`: Gets browser information for a specific object
- `getBrowserInfo($object, $filters, $list)`: Gets browser information for a specific object
- `getBrowserData($start, $limit)`: Gets browser data with pagination
- `getData($object, $key)`: Gets data for a specific object with a key
- `getSelectorData($editor, $value)`: Returns data from a Selector of the application
- `selectorFields($tableName, $keyName, $keyValue, $resultFields)`: Returns specific fields from a table record

### Softone Core Methods

The core `Softone` class provides numerous methods for building and sending requests:

- `setService($service)`: Sets the service to call (e.g., getBrowserInfo, getBrowserData)
- `setUsername($username)`: Sets the username for authentication
- `setPass($password)`: Sets the password for authentication
- `setAppId($appId)`: Sets the application ID
- `setCompany($company)`: Sets the company ID
- `setBranch($branch)`: Sets the branch ID
- `setModule($module)`: Sets the module ID
- `setRefid($refid)`: Sets the reference ID
- `setClientID($clientID)`: Sets the client ID
- `setObject($object)`: Sets the object to query (e.g., CUSTOMER, ITEM)
- `setKey($key)`: Sets the key for getData requests
- `setFilters($filters)`: Sets the filters for browser requests
- `setList($list)`: Sets the list for browser requests
- `locate($locate)`: Sets the locate info softone parameter
- `start($start)`: Sets the start parameter for pagination
- `limit($limit)`: Sets the limit parameter for pagination
- `setReqId($reqID)`: Sets the request ID for getBrowserData requests
- `setRequestData($data)`: Sets the request data
- `setEditor($editor)`: Sets the editor key for getSelectorData
- `setEditorValue($value)`: Sets the editor value for getSelectorData
- `setTableName($tableName)`: Sets the table name for selectorFields
- `setKeyName($keyName)`: Sets the key field name for selectorFields
- `setKeyValue($keyValue)`: Sets the key field value for selectorFields
- `setResultFields($resultFields)`: Sets comma-separated result fields for selectorFields
- `send()`: Sends the request to the Softone Web Services API

## Examples

### Searching for Customers

```php
use NikosIoannidis\Softone\SoftoneBrowser;

$softone = new SoftoneBrowser();
$softone->search("CUSTOMER", 'CUSTOMER.NAME=*Company*=;');

foreach ($softone->responseData as $item) {
    echo "Customer ID: " . $item['CUSTOMER.CODE'] . "\n";
    echo "Customer Name: " . $item['CUSTOMER.NAME'] . "\n";
    echo "Tax ID: " . $item['CUSTOMER.AFM'] . "\n";
    echo "-------------------\n";
}
```

### Getting a Specific Customer by ID

```php
use NikosIoannidis\Softone\SoftoneBrowser;

$softone = new SoftoneBrowser();
$softone->getData('CUSTOMER', '1001');

$customer = $softone->response;
echo "Customer Name: " . $customer->NAME . "\n";
echo "Tax ID: " . $customer->AFM . "\n";
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

Originally forked from [asikam/softone](https://github.com/asikam/softone).
