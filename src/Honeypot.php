<?php

namespace Blueweb\NetteHoneypot;

use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Nette\Utils\Html;

class Honeypot extends BaseControl
{
	const MODE_CSS = "css";
	const MODE_JS = "js";

	/**
	 * @var bool
	 */
	private $inline;

	/**
	 * @var string
	 */
	private $jsContent = <<<JS
(function(){elems=document.body.querySelectorAll('.bw-additional-data');for(var i=0;i<elems.length;++i){var elem=elems[i];elem.setAttribute('style', 'display:none !important;')}})();
JS;


	/**
	 * @var string
	 */
	private $cssContent = <<<CSS
.bw-additional-data{display:none !important;}
CSS;

	/**
	 * @var string
	 */
	private $mode;

	/**
	 * @var null|string
	 */
	private $message;

	/**
	 * @var array
	 */
	public $onError = [];

	public function __construct($caption = NULL, $message = NULL, $mode = self::MODE_JS, $inline = TRUE)
	{
		parent::__construct($caption);

		if (is_null($message)) {
			$message = "Please, don't fill this field";
		}

		$this->control->type = "text";
		$this->mode = $mode;
		$this->inline = $inline;
		$this->message = $message;

		$this->onError[] = function ($control) {
			$control->addError($this->message);
		};
	}

	public function getControl()
	{
		$control = parent::getControl();
		$label = parent::getLabel();

		$container = Html::el('div', [
			'id'    => $control->id . '-container',
			'class' => 'bw-additional-data',
		]);
		$container->addHtml($label);
		$container->addHtml($control);

		if ($this->inline) {
			if ($this->mode == self::MODE_JS) {
				$script = Html::el('script')
					->setType('text/javascript')
					->setHtml($this->jsContent);
				$container->addHtml($script);
			} elseif ($this->mode == self::MODE_CSS) {
				$style = Html::el('style')
					->setText($this->cssContent);
				$container->addHtml($style);
			}
		}

		return $container;
	}

	public function getLabel($caption = NULL)
	{
		return NULL;
	}

	public function validate(): void
	{
		parent::validate();

		$value = $this->getValue();
		if (!empty($value)) {
			$this->onError($this);
		}
	}

	public static function register($inline = TRUE): void
	{
		Container::extensionMethod('addHoneypot', function ($container, $name, $caption = NULL, $message = NULL, $mode = self::MODE_JS) use ($inline) {
			return $container[$name] = new self($caption, $message, $mode, $inline);
		});
	}
}