<?php
namespace Kleisli\Flow\PhpStan\FlowQuery;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\ShouldNotHappenException;

class FlowQueryMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{

    /** @var string[] Default operations from Neos */
    private array $operations = [
        "cacheLifetime", "children", "closest", "context", "filter", "find", "has", "nextAll", "next", "nextUntil",
        "parent","parents","parentsUntil","prevAll","prev","prevUntil","property","siblings","add","count","first",
        "get", "is","last","remove","slice","unique","sort","neosUiDefaultNodes","neosUiFilteredChildren","search"];

    /** @var string[] Default final operations from Neos */
    private array $finalOperations = ["cacheLifetime","property","count","get","is"];

    /**
     * @param string[] $flowQueryOperations
     * @param string[] $finalFlowQueryOperations
     */
    public function __construct(array $flowQueryOperations, array $finalFlowQueryOperations)
    {
        $this->operations = array_merge($this->operations, $flowQueryOperations);
        $this->finalOperations = array_merge($this->finalOperations, $finalFlowQueryOperations);
    }

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if ($classReflection->getName() === "Neos\Eel\FlowQuery\FlowQuery" && in_array($methodName, $this->operations)) {
            return true;
        }
        return false;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        if (!$this->hasMethod($classReflection, $methodName)) {
            throw new ShouldNotHappenException();
        }

        $isFinalOperation = in_array($methodName, $this->finalOperations);
        return new FlowQueryOperationMethodReflection($classReflection, $methodName, $isFinalOperation);
    }
}
