<?php

declare(strict_types=1);

namespace WebServCo\Reflection\Factory;

use OutOfRangeException;
use ReflectionClass;
use WebServCo\Reflection\Contract\ReflectionClassFactoryInterface;

use function class_exists;
use function interface_exists;

final class ReflectionClassFactory implements ReflectionClassFactoryInterface
{
    /**
     * @return \ReflectionClass<object>
     */
    public function createReflectionClass(string $className): ReflectionClass
    {
        if (!class_exists($className, true) && !interface_exists($className, true)) {
            // Not class nor interface
            throw new OutOfRangeException('Class or interface has not been defined.');
        }

        return new ReflectionClass($className);
    }
}
