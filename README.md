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
### Attachments

implements [https://api.bookwhen.com/v2#tag/Attachment](https://api.bookwhen.com/v2#tag/Attachment)

Attachments

https://api.bookwhen.com/v2#tag/Attachment/paths/~1attachments/get

``` php

// Fetch attachments accessible by the API token.

$attachments = $bookwhen->attachments());
```

** Filters **

The filter parameters can be passed in as function parameters.

**title** - Filter on the file title text.

**fileName** - Filter on the file name.

**fileType** - Filter on the file type.

``` php

// Fetch attachments accessible by the API token.

$attachments = $bookwhen->attachments(fileName: 'CV'));

$attachments = $bookwhen->attachments(fileType: 'pdf'));

$attachments = $bookwhen->attachments(title: 'Title to filter by'));

$attachments = $bookwhen->attachments(fileName: 'CV', fileType: 'pdf', title: 'Title to filter by'));
```

Attachment

[https://api.bookwhen.com/v2#tag/Attachment/paths/~1attachments~1%7Battachment_id%7D/g](https://api.bookwhen.com/v2#tag/Attachment/paths/~1attachments~1%7Battachment_id%7D/get)

```
// Returns the attachment for the provided attachment ID.

$attachment = $bookwhen->attachment('ev-smij-20200530100000' );

```
###Class Passes###

implements [https://api.bookwhen.com/v2#tag/ClassPass](https://api.bookwhen.com/v2#tag/ClassPass)

ClassPasses

https://api.bookwhen.com/v2#tag/ClassPass/paths/~1class_passes/get

``` php

// Fetch class passes accessible by the API token.

$classPasses = $bookwhen->classPasses());

```

** Filters **

The filter parameters can be passed in as function parameters

**title** - Filter on the title text of the pass.

**detail** - Filter on the details text.

**usageType** - Filter on the type of the pass: personal or any.

**cost** - Filter on the cost with an exact value or use a comparison operator. e.g. filter[cost][gte]=2000

  **gt** - greater than

  **gte** - greater than or equal

  **lt** - less than

  **lte** - less than or equal

  **eq** - equal to

**usageAllowance** - Filter on pass usage allowance. This also accepts a comparison operator like cost.

**useRestrictedForDays** - Filter on pass days restriction. This also accepts a comparison operator like cost.

``` php

// Fetch class passes accessible by the API token.

$classPasses = $bookwhen->classPasses());

$classPasses = $bookwhen->classPasses(title: 'Title to filter by'));
```

ClassPass

https://api.bookwhen.com/v2#tag/ClassPass/paths/~1class_passes~1%7Bclass_pass_id%7D/get

``` php

// Returns the class pass for the provided class pass ID.

$classPass = $bookwhen->classPass('ev-smij-20200530100000');

```

### Events

[https://api.bookwhen.com/v2#tag/Event](https://api.bookwhen.com/v2#tag/Event)

Events

[https://api.bookwhen.com/v2#tag/Event/paths/~1events/get](https://api.bookwhen.com/v2#tag/Event/paths/~1events/get)

``` php

// Returns the event for the provided event ID.

$event = $bookwhen->events();

```

**Filters**

**calendar** - Restrict to events on the given calendars (schedule pages).

**entry** - Restrict to given entries.

**location** - Array of location slugs to include.

**tag** - Array of tag words to include.

**title** - Array of entry titles to search for.

**detail** - Array of entry details to search for.

**from** - Inclusive time to fetch events from in format YYYYMMDD or YYYYMMDDHHMISS. Defaults to today.

**to** - Non-inclusive time to fetch events until in format YYYYMMDD or YYYYMMDDHHMISS

**compact** - Boolean: Combine events in a course into a single virtual event.

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

$event = $bookwhen->events(title: 'Title to filter by'));

```

Event

[https://api.bookwhen.com/v2#tag/Event/paths/~1events~1%7Bevent_id%7D/get](https://api.bookwhen.com/v2#tag/Event/paths/~1events~1%7Bevent_id%7D/get)

``` php

// Returns the event for the provided event ID.

$event = $bookwhen->event('ev-smij-20200530100000');

```


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

**includeAttachments**
**includeLocation**
**includeTickets.class_passes**
**includeTickets.events**

for example to retrieve the event with its location and tickets.



``` php

// Fetch events accessible by the API token.

$events = $bookwhen->events(location: true, includeTickets: true);));

```


### Locations


Implements [https://api.bookwhen.com/v2#tag/Location](https://api.bookwhen.com/v2#tag/Location)

Locations

[https://api.bookwhen.com/v2#tag/Location/paths/~1locations/get](https://api.bookwhen.com/v2#tag/Location/paths/~1locations/get)

``` php

// Fetch events accessible by the API token.

$locations = $bookwhen->locations());

// Returns the location for the provided location ID.

```

**Filters**

**addressText** - Restrict to locations containing the address text filter.

**additionalInfo** - Filter by the text contained in the additional info.

``` php

// Fetch events accessible by the API token.

$locations = $bookwhen->locations(addressText: 'Remote'));

// Returns the location for the provided location ID.

```

Location

[https://api.bookwhen.com/v2#tag/Location/paths/~1locations~1%7Blocation_id%7D/get](https://api.bookwhen.com/v2#tag/Location/paths/~1locations~1%7Blocation_id%7D/get)

```php
// Returns the location for the provided location ID.

$location = $bookwhen->location('ev-smij-20200530100000');

```

### Tickets

Implements [https://api.bookwhen.com/v2#tag/Ticket](https://api.bookwhen.com/v2#tag/Ticket)

Tickets

[https://api.bookwhen.com/v2#tag/Ticket/paths/~1tickets/get](https://api.bookwhen.com/v2#tag/Ticket/paths/~1tickets/get)


``` php

// Fetch tickets for the given event.

$eventId = 'ev-smij-20200530100000';

$client->tickets($eventId);
```

**Includes**

By default the tickets will NOT have its attachments, evetns and location populated.

To retrieve an event withg the included relationships,
simply pass boolean true for the relationship that is required. 

**includeAttachments**
**includeLocation**
**includeTickets.class_passes**
**includeTickets.events**

``` php

// Fetch tickets for the given event.

$eventId = 'ev-smij-20200530100000';

$client->tickets($eventId, includeAttachments: true);
```

Ticket

[https://api.bookwhen.com/v2#tag/Ticket/paths/~1tickets~1%7Bticket_id%7D/get](https://api.bookwhen.com/v2#tag/Ticket/paths/~1tickets~1%7Bticket_id%7D/get)

``` php
// Retrieve a single ticket.

$ticketId = 'ti-sboe-20200320100000-tk1m';

$client->ticket($ticketId);

```

**Includes**

By default the tickets will NOT have its attachments, evetns and location populated.

To retrieve an event withg the included relationships,
simply pass boolean true for the relationship that is required. 

**includeAttachments**
**includeLocation**
**includeTickets.class_passes**
**includeTickets.events**

``` php
// Retrieve a single ticket.

$client->ticket('ti-sboe-20200320100000-tk1m', includeAttachments: true););

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

If you require assistance with this package or implementing in your own project or business...

[https://bookwhen.com/inshore](https://bookwhen.com/inshore)

<script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="danielmullin" data-color="#FFDD00" data-emoji="" data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>

[https://www.buymeacoffee.com/danielmullin](https://www.buymeacoffee.com/danielmullin)

## Credits

- Daniel Mullin inshore@danielmullin.com
- Brandon Lubbehusen inshore@danielmullin.com

This package was heavily influenced by Nuno Maduro and the https://github.com/openai-php/client package.

## License

MIT
https://github.com/inshore/bookwhen/blob/master/LICENSE.md

