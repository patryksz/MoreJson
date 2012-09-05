<?php
namespace Sunset\Components\Json\Plugins;

interface PluginInterface {

	/**
	 * Run plugin process returning input
	 *
	 * @param array $input
	 * @param array $parameters
	 *
	 * @return mixed
	 */
	public function run($input, $parameters);
}
