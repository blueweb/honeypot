<?php

namespace Blueweb\NetteHoneypot;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class HoneypotExtension extends CompilerExtension
{
	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'inline' => Expect::bool(TRUE),
		]);
	}

	public function afterCompile(ClassType $class)
	{
		$initialize = $class->methods['initialize'];
		$initialize->addBody('Blueweb\NetteHoneypot\Honeypot::register(?);', [
			$this->config->inline,
		]);
	}
}