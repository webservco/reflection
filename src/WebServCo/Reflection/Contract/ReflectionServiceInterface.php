<?php

declare(strict_types=1);

namespace WebServCo\Reflection\Contract;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

interface ReflectionServiceInterface
{
    public function getConstructor(): ReflectionMethod;

    public function getConstructorParameterAtIndex(int $index): ReflectionParameter;

    /**
     * @return \ReflectionClass<object>
     */
    public function getConstructorParameterReflectionClassAtIndex(int $index): ReflectionClass;

    public function getConstructorParameterTypeAtIndex(int $index): string;
}
