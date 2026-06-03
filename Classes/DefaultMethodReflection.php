<?php
declare (strict_types=1);
namespace Kleisli\Flow\PhpStan;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;

class DefaultMethodReflection implements MethodReflection
{
    private ClassReflection $declaringClass;
    private string $name;

    public function __construct(ClassReflection $declaringClass, string $name)
    {
        $this->declaringClass = $declaringClass;
        $this->name = $name;
    }
    public function getDeclaringClass(): ClassReflection
    {
        return $this->declaringClass;
    }
    public function isStatic(): bool
    {
        return \false;
    }
    public function isPrivate(): bool
    {
        return \false;
    }
    public function isPublic(): bool
    {
        return \true;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }
    public function getVariants(): array
    {
        return [new TrivialParametersAcceptor()];
    }

    public function isDeprecated(): TrinaryLogic
    {
        return TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription(): ?string
    {
        return null;
    }
    public function isFinal(): TrinaryLogic
    {
        return TrinaryLogic::createMaybe();
    }
    public function isInternal(): TrinaryLogic
    {
        return TrinaryLogic::createMaybe();
    }

    public function getThrowType(): ?Type
    {
        return null;
    }
    public function hasSideEffects(): TrinaryLogic
    {
        return TrinaryLogic::createMaybe();
    }
    public function getDocComment(): ?string
    {
        return null;
    }
}
