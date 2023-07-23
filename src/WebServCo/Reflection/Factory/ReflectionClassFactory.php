<?php

declare(strict_types=1);

namespace WebServCo\Reflection\Factory;

use OutOfRangeException;
use ReflectionClass;
use WebServCo\Reflection\Contract\ReflectionClassFactoryInterface;

use function class_exists;

final class ReflectionClassFactory implements ReflectionClassFactoryInterface
{
    /**
     * @return \ReflectionClass<object>
     */
    public function createReflectionClass(string $className): ReflectionClass
    {
        if (!class_exists($className)) {
            throw new OutOfRangeException('Class does not exist.');
        }

        return new ReflectionClass($className);
    }
}
