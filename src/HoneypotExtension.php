<?php

namespace Blueweb\NetteHoneypot;


use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;

class HoneypotExtension extends CompilerExtension
{

	protected $defaultConfig = [
		"inline" => TRUE,
	];

	public
	function afterCompile(ClassType $class)
	{
		$config = $this->getConfig($this->defaultConfig);
		$inline = strtoupper($config['inline']);

		$initialize = $class->methods['initialize'];
		$initialize->addBody('Blueweb\NetteHoneypot\Honeypot::register(?);', [$inline]);
	}
}