<?php
namespace Sunset\Components\Json\Plugins\Plugins;
use Sunset\Components\Json\Plugins\PluginInterface;

class Parameters implements PluginInterface {

	/**
	 * array with parameters from json
	 *
	 * @var array
	 */
	private $_parameters;

	/**
	 * Initialize parameters and include parameters in json
	 *
	 * @param array $input
	 * @param array $parameters
	 *
	 * @return mixed
	 */
	public function run($input, $parameters) {
		$this->_parameters = array_merge((array) $input['parameters'], $parameters);
		array_walk_recursive($input, array($this, '_replaceParameters'));
		$input['parameters'] = $this->_parameters;

		return array(
			"content" => $input,
			"parameters" => $this->_parameters
		);
	}

	private function _replaceParameters(&$item, $key){
		if (!empty($this->_parameters[$item])) {
			$item = $this->_parameters[$item];
		}
	}
}
