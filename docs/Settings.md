# Settings

The settings class.

## Example(s)

```php
<?php

use miBadger\Settings\Settings;

/**
 * Contruct a settings object with the given data.
 */
$settings = new Settings($data = []);

/**
 * {@inheritdoc}
 */
$settings->getIterator();

/**
 * Returns the number of key-value mappings in the settings map.
 */
$settings->count();

/**
 * Returns true if the settings map contains no key-value mappings.
 */
$settings->isEmpty();

/**
 * Returns true if the settings map contains a mapping for the specified key.
 */
$settings->containsKey($key);

/**
 * Returns true if the settings map maps one or more keys to the specified value.
 */
$settings->containsValue($value);

/**
 * Returns the value to which the specified key is mapped, or null if the settings map contains no mapping for the key.
 */
$settings->get($key);

/**
 * Associates the specified value with the specified key in the settings map.
 */
$settings->set($key, $value);

/**
 * Removes the mapping for the specified key from the settings map if present.
 */
$settings->remove($key);

/**
 * Removes all of the mappings from the settings map.
 */
$settings->clear();

/**
 * Load the settings file from the given location.
 */
$settings->load($path = self::DEFAULT_FILENAME);

/**
 * Save the settings file at the given location.
 */
$settings->save($path = self::DEFAULT_FILENAME);
```
