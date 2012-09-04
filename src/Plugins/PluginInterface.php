<?php
namespace Sunset\Components\Json\Plugins;

interface PluginInterface {

	/**
	 * Run plugin process returning input
	 *
	 * @param mixed $input
	 *
	 * @return mixed
	 */
	public function run($input);
}
