<?php

namespace Matyx\Sentry;

use Nette;
use Nette\DI\CompilerExtension;

class SentryExtension extends CompilerExtension {
	/** @var  boolean Enable this extension? */
	private $enable = true;

	public function beforeCompile() {
		$config = $this->getConfig();

		if(!isset($config['dsn'])) {
			$this->enable = false;
			return;
		}

		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('ravenClient'))->setClass(\Raven_Client::class, [$config['dsn']]);
	}

	public function afterCompile(Nette\PhpGenerator\ClassType $class) {
		if(!$this->enable) return;

		$initialize = $class->methods['initialize'];

		$initialize->addBody('$ravenErrorHandler = new \Raven_ErrorHandler($this->getByType(\Raven_Client::class));');
		$initialize->addBody('$ravenErrorHandler->registerExceptionHandler();');
		$initialize->addBody('$ravenErrorHandler->registerErrorHandler();');
		$initialize->addBody('$ravenErrorHandler->registerShutdownFunction();');
	}

}