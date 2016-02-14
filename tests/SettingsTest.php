<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0.0
 */

namespace miBadger\Settings;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * The settings test class.
 *
 * @since 1.0.0
 */
class SettingsTest extends \PHPUnit_Framework_TestCase
{
	/** @var array The data. */
	private $data;

	/** @var Settings The settings. */
	private $settings;

	public function setUp()
	{
		$this->data = ['key' => 'value'];
		$this->settings = new Settings($this->data);
	}

	public function testGetIterator()
	{
		$this->assertEquals(new \ArrayIterator($this->data), $this->settings->getIterator());
	}

	public function testCount()
	{
		$this->assertEquals(1, $this->settings->count());
	}

	public function testIsEmpty()
	{
		$this->assertFalse($this->settings->isEmpty());
	}

	public function testContainsKey()
	{
		$this->assertTrue($this->settings->containsKey('key'));
	}

	public function testContainsValue()
	{
		$this->assertTrue($this->settings->containsValue('value'));
	}

	public function testGet()
	{
		$this->assertEquals('value', $this->settings->get('key'));
	}

	/**
	 * @depends testGet
	 */
	public function testSet()
	{
		$this->assertEquals($this->settings, $this->settings->set('key', 'value'));
		$this->assertEquals('value', $this->settings->get('key'));
	}

	/**
	 * @depends testContainsKey
	 */
	public function testRemove()
	{
		$this->assertEquals($this->settings, $this->settings->remove('key'));
		$this->assertFalse($this->settings->containsKey('key'));
	}

	/**
	 * @depends testIsEmpty
	 */
	public function testClear()
	{
		$this->assertEquals($this->settings, $this->settings->clear());
		$this->assertTrue($this->settings->isEmpty());
	}

	/**
	 * @depends testGet
	 */
	public function testLoad()
	{
		vfsStreamWrapper::register();
		vfsStreamWrapper::setRoot(new vfsStreamDirectory('test'));
		vfsStreamWrapper::getRoot()->addChild(new vfsStreamFile('.settings.json'));
		$path = vfsStream::url('test' . DIRECTORY_SEPARATOR . '.settings.json');

		$this->assertTrue((bool) file_put_contents($path, '{"key": "value2"}'));
		$this->assertEquals($this->settings, $this->settings->load($path));
		$this->assertEquals('value2', $this->settings->get('key'));
	}

	/**
	 * @depends testLoad
	 * @expectedException miBadger\File\FileException
	 * @expectedExceptionMessage Can't read the content.
	 */
	public function testLoadFileException()
	{
		vfsStreamWrapper::register();
		vfsStreamWrapper::setRoot(new vfsStreamDirectory('test'));
		$path = vfsStream::url('test' . DIRECTORY_SEPARATOR . Settings::DEFAULT_FILENAME);

		$this->settings->load($path);
	}

	/**
	 * @depends testLoad
	 * @expectedException UnexpectedValueException
	 * @expectedExceptionMessage Invalid JSON.
	 */
	public function testLoadUnexpectedValueException()
	{
		vfsStreamWrapper::register();
		vfsStreamWrapper::setRoot(new vfsStreamDirectory('test'));
		vfsStreamWrapper::getRoot()->addChild(new vfsStreamFile('.settings.json'));
		$path = vfsStream::url('test' . DIRECTORY_SEPARATOR . '.settings.json');

		$this->assertTrue((bool) file_put_contents($path, '{{"invalid": "json"}'));
		$this->settings->load($path);
	}

	/**
	 * @depends testLoad
	 */
	public function testSave()
	{
		vfsStreamWrapper::register();
		vfsStreamWrapper::setRoot(new vfsStreamDirectory('test'));
		vfsStreamWrapper::getRoot()->addChild(new vfsStreamFile('.settings.json'));
		$path = vfsStream::url('test' . DIRECTORY_SEPARATOR . '.settings.json');

		// Succes
		$this->settings->set('key', 'value2');
		$this->assertEquals($this->settings, $this->settings->save($path));
		$this->assertEquals($this->settings, $this->settings->clear());
		$this->assertEquals($this->settings, $this->settings->load($path));
		$this->assertEquals('value2', $this->settings->get('key'));
	}
}
