# Kleisli.Flow.PhpStan
Reflection Extensions for static analysis of Flow classes with magic methods

## Installation
```shell
composer require --dev kleisli/flow-phpstan
```

In the `phpstan.neon` file add 
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
Currently, it only checks for the default flow query operations, because I didn't manage to lod 
all available operations via reflection.

## PHPStan documentation for this feature
https://phpstan.org/developing-extensions/class-reflection-extensions#methods-class-reflection-extensions
