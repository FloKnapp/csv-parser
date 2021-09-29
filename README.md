![example workflow](https://github.com/webasics/csv-parser/actions/workflows/php.yml/badge.svg)
[![codecov](https://codecov.io/gh/webasics/csv-parser/branch/main/graph/badge.svg?token=P0Y8PPHJ64)](https://codecov.io/gh/webasics/csv-parser)

# CSV Parser for PHP

Parse CSV files into an array. 

This library doesn't provide any advanced functions such as line counts or automatic detection of a header.
Therefore, it's super-fast and simple to use.

## Installation

```bash
composer require webasics/csv-parser
```

## Usage

You have two options to provide your data. One is to provide a filepath and the other is to provide the CSV contents directly.

You can pass the CSV file directly via:

```php
$data = CSV::parseFromFile('./your-csv-file.csv');
```

Or you can pass the contents of the file directly via:

```php
$data = CSV::parseFromString('firstname,lastname,birthdate,city,country');
```

You can also determine if a header row is present in your data with the second argument ```$hasHeader``` set to true, which is the default setting.

When your dataset is providing a header, the resulting output would contain the header columns as keys according to the column count.

#### Example

```php
array(5) {
    ["firstname"] => string(4) "John"
    ["lastname"]  => string(3) "Doe"
    ["birthdate"] => string(10) "01.01.1970"
    ["city"]      => string(6) "Munich"
    ["country"]   => string(7) "Germany"
}
```

When your dataset doesn't provide a header row, you'll get the output as an indexed array. Note that you'll have to set the parameter `$hasHeader` to `false`. Otherwise you'll receive the actual column values from the first row as the keys.

#### Example

```php
array(5) {
    [0] => string(4) "John"
    [1] => string(3) "Doe"
    [2] => string(10) "01.01.1970"
    [3] => string(6) "Munich"
    [4] => string(7) "Germany"
}
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

Thank you in advance if you're considering contributing to this project!
