# Nette Honeypot Extension

Adds support for honeypot input in Nette Forms.

## Installation

Best way to install this is using composer:

```shell
composer require blueweb/nette-honeypot
```
	
Then register extension:
	
```yaml
extensions:
    honeypot: Blueweb\NetteHoneypot\HoneypotExtension
```
        
## Usage

```php
$form->addHoneypot($name, $caption, $errorMessage);
```

Parameter `$name` should be something yummy for robot, like additional_email.

In `$caption` you should write something for user, which for some reason has not this field hidden.

In `$message` you may change default error message.
	 
You can also specify your own error callback:

```php
$honeypot = $form->addHoneypot('email');
$honeypot->onError[] = function($control){ .... };
```
