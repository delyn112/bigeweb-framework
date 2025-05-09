composer/metadata-minifier
==========================

Small utility library that handles metadata minification and expansion.

This is used by [Composer](https://github.com/composer/composer)'s 2.x repository metadata protocol.


Installation
------------

Install the latest version with:

```bash
composer require composer/metadata-minifier
```


Requirements
------------

* PHP 5.3.2 is required but using the latest version of PHP is highly recommended.


Basic usage
-----------

### `Composer\MetadataMinifier\MetadataMinifier`

- `MetadataMinifier::expand()`: Expands an array of minified versions back to their original format
- `MetadataMinifier::minify()`: Minifies an array of versions into a set of version diffs

For example to expand the dev versions (note the ~dev in the URL) of Monolog you would do:

```php
$packageName = 'monolog/monolog';
$url = 'https://repo.packagist.org/p2/' . $packageName . '~dev.json';
$json = json_decode(file_get_contents($url), true);
$versions = \Composer\MetadataMinifier\MetadataMinifier::expand($json['packages'][$packageName]);
```

License
-------

composer/metadata-minifier is licensed under the MIT License, see the LICENSE file for details.
