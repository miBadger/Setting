<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 */

namespace miBadger\Settings;

use miBadger\File\File;

/**
 * The settings class.
 *
 * @since 1.0.0
 */
class Settings implements \IteratorAggregate
{
	const DEFAULT_FILENAME = '.settings.json';

	/** @var array The settings */
	private $data;

	/**
	 * Construct a settings object with the given data.
	 *
	 * @param $data = []
	 */
	public function __construct($data = [])
	{
		$this->data = $data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->data);
	}

	/**
	 * Returns the number of key-value mappings in the settings map.
	 *
	 * @return int the number of key-value mappings in the settings map.
	 */
	public function count()
	{
		return count($this->data);
	}

	/**
	 * Returns true if the settings map contains no key-value mappings.
	 *
	 * @return bool true if the settings map contains no key-value mappings.
	 */
	public function isEmpty()
	{
		return empty($this->data);
	}

	/**
	 * Returns true if the settings map contains a mapping for the specified key.
	 *
	 * @param string $key
	 * @return bool true if the settings map contains a mapping for the specified key.
	 */
	public function containsKey($key)
	{
		return isset($this->data[$key]);
	}

	/**
	 * Returns true if the settings map maps one or more keys to the specified value.
	 *
	 * @param string $value
	 * @return bool true if the settings map maps one or more keys to the specified value.
	 */
	public function containsValue($value)
	{
		return in_array($value, $this->data);
	}

	/**
	 * Returns the value to which the specified key is mapped, or null if the settings map contains no mapping for the key.
	 *
	 * @param string $key
	 * @return string the value to which the specified key is mapped, or null if the settings map contains no mapping for the key.
	 */
	public function get($key)
	{
		return $this->containsKey($key) ? $this->data[$key] : null;
	}

	/**
	 * Associates the specified value with the specified key in the settings map.
	 *
	 * @param string $key
	 * @param string $value
	 * @return $this
	 */
	public function set($key, $value)
	{
		$this->data[$key] = $value;

		return $this;
	}

	/**
	 * Removes the mapping for the specified key from the settings map if present.
	 *
	 * @param string $key
	 * @return $this
	 */
	public function remove($key)
	{
		unset($this->data[$key]);

		return $this;
	}

	/**
	 * Removes all of the mappings from the settings map.
	 *
	 * @return $this
	 */
	public function clear()
	{
		$this->data = [];

		return $this;
	}

	/**
	 * Load the settings file from the given location.
	 *
	 * @param $path = self::DEFAULT_FILENAME
	 * @return $this
	 * @throws FileException on failure.
	 * @throws \UnexpectedValueException on failure.
	 */
	public function load($path = self::DEFAULT_FILENAME)
	{
		$file = new File($path);

		if (($data = json_decode($file->read(), true)) === null) {
			throw new \UnexpectedValueException('Invalid JSON.');
		}

		$this->data = (array) $data;

		return $this;
	}

	/**
	 * Save the settings file at the given location.
	 *
	 * @param $path = self::DEFAULT_FILENAME
	 * @return $this
	 * @throws FileException on failure.
	 */
	public function save($path = self::DEFAULT_FILENAME)
	{
		$file = new File($path);

		$file->write(json_encode($this->data));

		return $this;
	}
}
