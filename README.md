![example workflow](https://github.com/webasics/csv-parser/actions/workflows/php.yml/badge.svg)
[![codecov](https://codecov.io/gh/webasics/csv-parser/branch/main/graph/badge.svg?token=P0Y8PPHJ64)](https://codecov.io/gh/webasics/csv-parser)

# CSV Parser for PHP

Parse .csv files into a key associated array.

## Installation

```bash
composer require webasics/csv-parser
```

## Usage

You can pass the CSV file directly via:

```php
$data = CSV::parseFromFile('./your-csv-file.csv');
```

Or you can pass the contents of the file directly via:

```php
$data = CSV::parseFromString('lastname,firstname,birthdate,city,zipcode');
```

## Tests

The tests are by far not complete currently.
It's missing expected fails like:
- What if the amount of columns doesn't match the header length
- What if the columns have different separators
- What if the enclosure doesn't match when it got another enclosure char in it

```bash
vendor/bin/phpunit -c phpunit.xml
```

## Contributing

- Fork the repository
- Submit your changes 
- Create a pull request against webasics/csv-parser
- After it's reviewed successfully, your changes are getting merged

Please provide tests as I'm only accepting fully covered changes. A bonus would be if you're also providing tests for cases which aren't that usual, like the examples in the "Tests" section above.
