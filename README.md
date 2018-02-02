# Settings

[![Build Status](https://scrutinizer-ci.com/g/miBadger/miBadger.Settings/badges/build.png?b=master)](https://scrutinizer-ci.com/g/miBadger/miBadger.Settings/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/miBadger/miBadger.Settings/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/miBadger/miBadger.Settings/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/miBadger/miBadger.Settings/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/miBadger/miBadger.Settings/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/84d2800d-d808-4286-867c-53a27f091739/mini.png)](https://insight.sensiolabs.com/projects/84d2800d-d808-4286-867c-53a27f091739)

The Settings Component.

## Example

```php
<?php

use miBadger\Settings\Settings;

/**
 * Construct a settings object.
 */
$settings = new Settings();

/**
 * Load the settings file from the given location.
 */
$settings->load($path);

/**
 * Returns the value to which the specified key is mapped, or null if the settings map contains no mapping for the key.
 */
$settings->get('name'); // John Doe

/**
 * Associates the specified value with the specified key in the settings map.
 */
$settings->set('Jane Doe');

/**
 * Save the settings file at the given location.
 */
$settings->save($path);
```
