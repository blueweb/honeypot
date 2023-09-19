<?php

namespace Blueweb\NetteHoneypot;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Blueweb\NetteHoneypot\Honeypot;

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
		$class->getMethod('initialize')->addBody('Honeypot::register(?);', [
			$this->config->inline,
		]);
	}
}