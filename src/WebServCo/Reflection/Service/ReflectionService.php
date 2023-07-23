<?php

declare(strict_types=1);

namespace WebServCo\Reflection\Service;

use OutOfBoundsException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use UnexpectedValueException;
use WebServCo\Reflection\Contract\ReflectionClassFactoryInterface;
use WebServCo\Reflection\Contract\ReflectionServiceInterface;

use function array_key_exists;

/**
 * Reflection service.
 *
 * Not using className as parameter to individual functions in order to avoid creating multiple reflection interfaces.
 */
final class ReflectionService implements ReflectionServiceInterface
{
    /**
     * @var \ReflectionClass<object>
     */
    private ReflectionClass $reflectionClass;

    public function __construct(
        private string $className,
        private ReflectionClassFactoryInterface $reflectionClassFactory,
    ) {
        $this->reflectionClass = $this->reflectionClassFactory->createReflectionClass($this->className);
    }

    public function getConstructor(): ReflectionMethod
    {
        $constructor = $this->reflectionClass->getConstructor();
        if (!$constructor instanceof ReflectionMethod) {
            throw new UnexpectedValueException('Invalid instance.');
        }

        return $constructor;
    }

    public function getConstructorParameterAtIndex(int $index): ReflectionParameter
    {
        $constructor = $this->getConstructor();

        $parameters = $constructor->getParameters();

        // Translate index (parameter is real world number while array is zero-indexed).
        $index -= 1;

        if (!array_key_exists($index, $parameters)) {
            throw new OutOfBoundsException('Key does not exist in array.');
        }

        return $parameters[$index];
    }

    /**
     * @return \ReflectionClass<object>
     */
    public function getConstructorParameterReflectionClassAtIndex(int $index): ReflectionClass
    {
        $constructorParameterType = $this->getConstructorParameterTypeAtIndex($index);

        return $this->reflectionClassFactory->createReflectionClass($constructorParameterType);
    }

    public function getConstructorParameterTypeAtIndex(int $index): string
    {
        $reflectionParameter = $this->getConstructorParameterAtIndex($index);
        $reflectionType = $reflectionParameter->getType();
        if (!$reflectionType instanceof ReflectionNamedType) {
            throw new UnexpectedValueException('Invalid instance.');
        }

        return $reflectionType->getName();
    }
}
