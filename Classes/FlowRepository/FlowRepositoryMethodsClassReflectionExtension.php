<?php
namespace Kleisli\Flow\PhpStan\FlowRepository;

use Kleisli\Flow\PhpStan\DefaultMethodReflection;
use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\ShouldNotHappenException;

class FlowRepositoryMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{
    public function __construct(private ReflectionProvider $reflectionProvider)
    {
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        // Check if the class extends Neos\Flow\Persistence\Repository
        if (!in_array('Neos\Flow\Persistence\Repository', $classReflection->getParentClassesNames())) {
            return false;
        }

        if (!preg_match('/^findBy([A-Z][a-zA-Z0-9_]*)$/', $methodName, $matches)
            && !preg_match('/^findOneBy([A-Z][a-zA-Z0-9_]*)$/', $methodName, $matches)
            && !preg_match('/^countBy([A-Z][a-zA-Z0-9_]*)$/', $methodName, $matches)) {
            return false;
        }

        $propertyName = lcfirst($matches[1]);

        $entityClassName = $this->getEntityClassName($classReflection);
        if($entityClassName == null || !$this->reflectionProvider->hasClass($entityClassName)){
            return false;
        }

        // Check if the entity class has the property and it is accessible
        $entityReflection = $this->reflectionProvider->getClass($entityClassName);
        if (!$entityReflection->hasInstanceProperty($propertyName)) {
            return false;
        }
        $property = $entityReflection->getInstanceProperty($propertyName, new OutOfClassScope());
        if ($property->isReadable()) {
            return true;
        }

        // default
        return false;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        if (!$this->hasMethod($classReflection, $methodName)) {
            throw new ShouldNotHappenException();
        }

        return new DefaultMethodReflection($classReflection, $methodName);
    }

    private function getEntityClassName(ClassReflection $classReflection): ?string
    {
        $repositoryClassName = $classReflection->getName();
        if (!defined("$repositoryClassName::ENTITY_CLASSNAME")) {
            $entityClassName = preg_replace(['/\\\Repository\\\/', '/Repository$/'], ['\\Model\\', ''], $repositoryClassName);
        } else {
            $entityClassName = constant("$repositoryClassName::ENTITY_CLASSNAME");
        }
        return is_string($entityClassName) ? $entityClassName : null;
    }
}
