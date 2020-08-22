# inShore.je - Bookwhen PHP API SDK

[![Latest Version](https://img.shields.io/github/release/inshore/bookwhen.svg?style=flat-square)](https://github.com/inshore/bookwhen/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/inshore/bookwhen/master.svg?style=flat-square)](https://travis-ci.org/inshore/bookwhen)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/inshore/bookwhen.svg?style=flat-square)](https://scrutinizer-ci.com/g/inshore/bookwhen/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/inshore/bookwhen.svg?style=flat-square)](https://scrutinizer-ci.com/g/inshore/bookwhen)
[![Total Downloads](https://img.shields.io/packagist/dt/inshore/bookwhen.svg?style=flat-square)](https://packagist.org/packages/inshore/bookwhen)

SDK kit for the Bookwhen API.

https://www.bookwhen.com

https://api.bookwhen.com/v2

## Install

### Requirements

PHP 7.2 and later.

**Composer**

``` bash
$ composer require inshore/booknow
```

## Usage

``` php

$token = xxxx;

$client = new Client($token)

```

**Events**

``` php

// Fetch events accessible by the API token.

$client->getEvents();

// Returns the event for the provided event ID.

$eventId = 'ev-smij-20200530100000';

$client->getEvents($eventId);

```

**Locations**

``` php

// Fetch locations for the given query params.

$client->locations();

// Retrieve a single location.

$locationId = xxxx;

$client->locations($locationId)

``` 

**Attachments**

``` php

// Fetch attachments for the given query params.

$client->attachments();

// Retrieve a single attachment.

$attachmentId = '9v06h1cbv0en';

$client->attachments($attachmentId);

```

**Tickets**

``` php

// Fetch tickets for the given event.

$eventId = 'ev-smij-20200530100000';

$client->tickets($eventId);

// Retrieve a single ticket.

$ticketId = 'ti-sboe-20200320100000-tk1m';

$client->ticket($ticketId);

```

**Class Passes**

``` php

// Fetch class passes for the given query params.

$client->classPasses;

// Retrieve a single class pass.

$classPassId = xxxx;

$client->classPasses($classPassId);

```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see https://github.com/inshore/bookwhen for details.

## Credits

- Daniel Mullin inshore@danielmullin.com
- Brandon Lubbehusen inshore@danielmullin.com

## License

MIT
https://github.com/inshore/bookwhen/blob/master/LICENSE.md


