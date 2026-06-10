# Kleisli.Flow.PhpStan
Reflection Extensions for static analysis of Flow classes with magic methods

## Installation
```shell
composer require --dev kleisli/flow-phpstan
```

Install the [PHPStan Extension Installer](https://github.com/phpstan/extension-installer#usage) or add
the following to your `phpstan.neon` file 
```
includes:
    - Build/Kleisli.Flow.PhpStan/phpstan.neon
```

## Description
When you use FlowQuery in PHP or the magic repository methods in Flow (`findOneBy` etc), 
you either have to ignore the static analysis errors or implement custom extensions for PHPStan.

This package currently provides two MethodClassReflectionExtensions:

### For magic repository methods
When a magic method like `findOneBy<Property>` is called, the extension checks if the property exists and 
is readable. and only marks the method as callable if it is.

### For FlowQuery
By default it only checks for the Neos flow query operations, but if you have custom operations, you can add them as
parameters to your `phpstan.neon` file
```
parameters:
    flowQueryOperations: []
    finalFlowQueryOperations: []
```

## PHPStan documentation
### method class reflection extensions
https://phpstan.org/developing-extensions/class-reflection-extensions#methods-class-reflection-extensions
### custom parameters
https://phpstan.org/config-reference#custom-parameters
