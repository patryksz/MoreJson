<?php

use Sunset\Components\MoreJson\MoreJson;

class JsonTest extends  \PHPUnit_Framework_TestCase {

	/**
	 * @var MoreJson
	 */
	private $object;

	/**
	 * @var array
	 */
	private $decodedJson;

	public function setUp(){
		$this->object = new MoreJson();
		$this->decodedJson = $this->object->parse(__DIR__."/Resources/Fixtures/sample.json");
	}

	public function testImport(){
		$this->assertEquals('bar', $this->decodedJson['foo']);
	}

	/**
 	 * @expectedException Sunset\Components\MoreJson\MoreJsonException
	 */
	public function testUnknownFile(){
		$this->object->parse(__DIR__."/Resources/Fixtures/non-existing.json");
	}
}
