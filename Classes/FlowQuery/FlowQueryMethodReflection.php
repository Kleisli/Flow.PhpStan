<?php

namespace Kleisli\Flow\PhpStan\FlowQuery;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\Type\CallableType;
use PHPStan\Type\ObjectType;

class FlowQueryMethodReflection extends \Kleisli\Flow\PhpStan\DefaultMethodReflection
{
    private bool $operationIsFinal;

    public function __construct(ClassReflection $declaringClass,
                                string $name,
                                bool $operationIsFinal)
    {
        parent::__construct($declaringClass, $name);
        $this->operationIsFinal = $operationIsFinal;
    }

    public function getVariants(): array
    {
        if(!$this->operationIsFinal) {
            return [new CallableType(returnType: new ObjectType("Neos\Eel\FlowQuery\FlowQuery"))];
        }else{
            return [new TrivialParametersAcceptor()];
        }
    }
}
