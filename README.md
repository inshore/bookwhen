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

PHP 8.1 and later.

**Composer**

``` bash
$ composer require inshore/bookwhen

```

## Usage

Simply expose your Bookwhen API key as the environment property 

INSHORE_BOOKWHEN_API_KEY 

via .env or how you prefer.


``` php
$bookwhen = new Bookwhen();
```
###Attachments###

``` php

// Fetch attachments accessible by the API token.

$attachments = $bookwhen->attachments());

// Returns the attachment for the provided attachment ID.

$attachment = $bookwhen->attachment('ev-smij-20200530100000');

```
###Class Passes###

``` php

// Fetch class passes accessible by the API token.

$classPasses = $bookwhen->classPasses());

// Returns the class pass for the provided class pass ID.

$classPass = $bookwhen->classPass('ev-smij-20200530100000');

```

###Event###

``` php

// Returns the event for the provided event ID.

$event = $bookwhen->event('ev-smij-20200530100000');

```

**Includes**

By default the event will NOT have its attachments, location and tickets populated.

To retrieve an event with the included relationships,
simply pass boolean true for the relationship that is required. 

includeAttachments
includeLocation
includeTickets
includeTickets.class_passes
includeTickets.events

for example to retrieve the event with its location and tickets.

``` php

// Returns the event for the provided event ID.

$event = $bookwhen->event(eventId: 'ev-smij-20200530100000', includeLocation: true, includeTickets: true);

```

###Events###

``` php

// Fetch events accessible by the API token.

$events = $bookwhen->events());

```

**Filters**

The event list can be filtered as per the api documentation

**Includes**

By default the event will NOT have its attachments, location and tickets populated.

To retrieve an event withg the included relationships,
simply pass boolean true for the relationship that is required. 

includeAttachments
includeLocation
includeTickets
includeTickets.class_passes
includeTickets.events

for example to retrieve the event with its location and tickets.



``` php

// Fetch events accessible by the API token.

$events = $bookwhen->events(location: true, includeTickets: true);));

```


###Locations###

``` php

// Fetch events accessible by the API token.

$locations = $bookwhen->location());

// Returns the location for the provided location ID.

$location = $bookwhen->location('ev-smij-20200530100000');

```
###Tickets###

``` php

// Fetch tickets for the given event.

$eventId = 'ev-smij-20200530100000';

$client->tickets($eventId);

// Retrieve a single ticket.

$ticketId = 'ti-sboe-20200320100000-tk1m';

$client->ticket($ticketId);

```

## Logging

Full syslog level logging is available and can be enabled by passing a level in when instatiating the Client. As illustrated in RFC 5424 which describes the syslog protocol, the following levels of intensity are applied.

DEBUG: Detailed debugging information.
INFO: Handles normal events. Example: SQL logs
NOTICE: Handles normal events, but with more important events
WARNING: Warning status, where you should take an action before it will become an error.
ERROR: Error status, where something is wrong and needs your immediate action
CRITICAL: Critical status. Example: System component is not available
ALERT: Immediate action should be exercised. This should trigger some alerts and wake you up during night time.
EMERGENCY: It is used when the system is unusable.

$bookwhen = new Bookwhen()->debug('Debug');


## Testing

``` bash
$ phpunit
```

## Contributing

Please see https://github.com/inshore/bookwhen for details.

## Support ##

<script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="danielmullin" data-color="#FFDD00" data-emoji="" data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>

[https://www.buymeacoffee.com/danielmullin](https://www.buymeacoffee.com/danielmullin)

## Credits

- Daniel Mullin inshore@danielmullin.com
- Brandon Lubbehusen inshore@danielmullin.com


## License

MIT
https://github.com/inshore/bookwhen/blob/master/LICENSE.md

