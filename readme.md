Email on Acid SDK
=================

## Installation

composer require "kiwicom/email-on-acid-sdk"

## Usage

Create ApiFactory with required parameters - `apikey` and `password` can be obtained in `Account` section on https://www.emailonacid.com 

```php
$apiFactory = new \EmailOnAcid\ApiFactory('yourapikey', 'yourpassword', $timeout);
```

Creating of Email testing api example:

```php
$emailTestsApi = $apiFactory->createEmailTesting()
```

Creating new test require EmailTestRequest as argument , filling required data where one of url / html must be provided as email content and returning Response\NewEmailTest with data about your new test

```php
try {
    $newEmailTest = $emailTestsApi->createEmailTest(
		new \EmailOnAcid\Request\EmailTestRequest(
			'Email subject to test',
			'<html>Html of your email to test</html>'
		)
	);
} catch (\EmailOnAcid\Ecxception\EmailOnAcidException $e) {
    // handle exception
}
```

Results of API calls are immutable objects from `\EmailOnAcid\Response` namespace or simple string[].

Fetching tests results example:

For fetching test results you need testId which is provided in Response\NewEmailTest (testId is used for operations like links test, email content test, spam test, code analysis so you probably want to store it somewhere after creating new test)

```php
$testInfo = $emailTestApi->getTestInfo(
	$newEmailTest->getId()
);
```

## Exception types

`\EmailOnAcid\Ecxception\ApiRequestException` - unexpected api errors

`\EmailOnAcid\Ecxception\UnsuccessfulActionException` - some of api calls provides only true|false result without any additional data; `UnsuccessfulActionException` is thrown in case of false result

`\EmailOnAcid\Ecxception\NotFoundException` - can be thrown in cases where requested content is not found (mostly related to functions that require test id as parameter and it does not exist on api)
