<?php

use Sunset\Components\Json\Json;

class JsonTest extends  \PHPUnit_Framework_TestCase {

	/**
	 * @var Json
	 */
	private $object;

	/**
	 * @var stdClass
	 */
	private $decodedJson;

	public function setUp(){
		$this->object = new \Sunset\Components\Json\Json();
		$this->decodedJson = $this->object->parse(__DIR__."/Resources/Fixtures/sample.json");
	}

	public function testImport(){
		$this->assertEquals('bar', $this->decodedJson['foo']);
	}
}
