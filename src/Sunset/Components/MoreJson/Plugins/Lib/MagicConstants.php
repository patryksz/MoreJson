<?php
namespace Sunset\Components\MoreJson\Plugins\Lib;
/**
 * @package Lib
 */
class MagicConstants {

	/**
	 * @var string
	 */
	private $filepath;

	/**
	 * @param string $filename json filename
	 */
	public function __construct($filepath) {
		$this->filepath = $filepath;
	}

	/**
	 * Get predefined vars
	 * @return array
	 */
	public function getConstants() {
		return array(
			"~DIR" => $this->filepath
		);
	}
}
