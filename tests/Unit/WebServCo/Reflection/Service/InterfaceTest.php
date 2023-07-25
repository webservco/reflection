<?php

declare(strict_types=1);

namespace Tests\Unit\WebServCo\Reflection\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use WebServCo\Reflection\Contract\ReflectionServiceInterface;
use WebServCo\Reflection\Factory\ReflectionClassFactory;
use WebServCo\Reflection\Service\ReflectionService;

use function assert;

#[CoversClass(ReflectionService::class)]
#[UsesClass(ReflectionClassFactory::class)]
final class InterfaceTest extends AbstractReflectionServiceTester
{
    public function testImplementsInterface(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $reflectionClassAtIndex1 = $this->reflectionService
        ->getConstructorParameterReflectionClassAtIndex(self::CLASS_NAME, 1);

        self::assertTrue($reflectionClassAtIndex1->implementsInterface(MockInterface::class));
    }
}
