#  Bookwhen

[![Latest Version](https://img.shields.io/github/release/thephpleague/skeleton.svg?style=flat-square)](https://github.com/thephpleague/skeleton/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/thephpleague/skeleton/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/skeleton)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/skeleton/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/skeleton)
[![Total Downloads](https://img.shields.io/packagist/dt/league/skeleton.svg?style=flat-square)](https://packagist.org/packages/league/skeleton)


SDK kit for bookwhen using version 2.0 or greater.


## Install

Via Composer

``` bash
$ composer require inshore/booknow
```

## Usage

``` php



$token = xxxx;

$client = new Client($token)

//For finding all available events

$client->getEvents();

//For finding a specific event

$client->getSingleEvent(event_id);

//For purchasing tickets

$client->ticket();

//For viewing details of specific ticket

$client->ticket(ticket_id);

```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see https://github.com/inshore-packages/bookwhen for details.

## Credits

- Daniel Mullin
- Brandon Lubbehusen

## License


