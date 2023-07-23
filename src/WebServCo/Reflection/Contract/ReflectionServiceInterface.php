<?php

declare(strict_types=1);

namespace WebServCo\Reflection\Contract;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

interface ReflectionServiceInterface
{
    public function getConstructor(string $className): ReflectionMethod;

    public function getConstructorParameterAtIndex(string $className, int $index): ReflectionParameter;

    /**
     * @return \ReflectionClass<object>
     */
    public function getConstructorParameterReflectionClassAtIndex(string $className, int $index): ReflectionClass;

    public function getConstructorParameterTypeAtIndex(string $className, int $index): string;

    /**
     * @return \ReflectionClass<object>
     */
    public function getReflectionClass(string $className): ReflectionClass;
}
