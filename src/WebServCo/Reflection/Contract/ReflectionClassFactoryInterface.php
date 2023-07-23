<?php

declare(strict_types=1);

namespace WebServCo\Reflection\Contract;

use ReflectionClass;

interface ReflectionClassFactoryInterface
{
    /**
     * @return \ReflectionClass<object>
     */
    public function createReflectionClass(string $className): ReflectionClass;
}
