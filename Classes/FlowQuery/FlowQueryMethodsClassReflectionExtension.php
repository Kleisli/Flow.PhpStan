<?php
namespace Kleisli\Flow\PhpStan\FlowQuery;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\ShouldNotHappenException;

class FlowQueryMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{
    private array $operations = [
        "cacheLifetime", "children", "closest", "context", "filter", "find", "has", "nextAll", "next", "nextUntil",
        "parent","parents","parentsUntil","prevAll","prev","prevUntil","property","siblings","add","count","first",
        "get", "is","last","remove","slice","unique","sort","neosUiDefaultNodes","neosUiFilteredChildren","search"];

    private array $finalOperations = ["cacheLifetime","property","count","get","is"];

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if ($classReflection->getName() !== "Neos\Eel\FlowQuery\FlowQuery") {
            return false;
        }

        if (in_array($methodName, $this->operations)) {
            return true;
        }
        return false;

    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        if (!$this->hasMethod($classReflection, $methodName)) {
            throw new ShouldNotHappenException();
        }

        return new FlowQueryMethodReflection($classReflection, $methodName, in_array($methodName, $this->finalOperations));
    }
}
