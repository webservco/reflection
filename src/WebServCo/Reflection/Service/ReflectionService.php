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
     * @var array<string,\ReflectionClass<object>>
     */
    private array $reflectionClasses = [];

    public function __construct(private ReflectionClassFactoryInterface $reflectionClassFactory)
    {
    }

    public function getConstructor(string $className): ReflectionMethod
    {
        $constructor = $this->getReflectionClass($className)->getConstructor();
        if (!$constructor instanceof ReflectionMethod) {
            throw new UnexpectedValueException('Invalid instance.');
        }

        return $constructor;
    }

    public function getConstructorParameterAtIndex(string $className, int $index): ReflectionParameter
    {
        $constructor = $this->getConstructor($className);

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
    public function getConstructorParameterReflectionClassAtIndex(string $className, int $index): ReflectionClass
    {
        $constructorParameterType = $this->getConstructorParameterTypeAtIndex($className, $index);

        return $this->getReflectionClass($constructorParameterType);
    }

    public function getConstructorParameterTypeAtIndex(string $className, int $index): string
    {
        $reflectionParameter = $this->getConstructorParameterAtIndex($className, $index);
        $reflectionType = $reflectionParameter->getType();
        if (!$reflectionType instanceof ReflectionNamedType) {
            throw new UnexpectedValueException('Invalid instance.');
        }

        return $reflectionType->getName();
    }

    /**
     * @return \ReflectionClass<object>
     */
    public function getReflectionClass(string $className): ReflectionClass
    {
        if (!array_key_exists($className, $this->reflectionClasses)) {
            $this->reflectionClasses[$className] = $this->reflectionClassFactory->createReflectionClass($className);
        }

        return $this->reflectionClasses[$className];
    }
}
