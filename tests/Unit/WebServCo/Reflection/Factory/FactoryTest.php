<?php

declare(strict_types=1);

namespace Tests\Unit\WebServCo\Reflection\Factory;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Mock\MockController;
use Tests\Unit\Mock\MockInterface;
use WebServCo\Reflection\Factory\ReflectionClassFactory;

#[CoversClass(ReflectionClassFactory::class)]
final class FactoryTest extends TestCase
{
    public function testCreateReflectionClassWorksWithClass(): void
    {
        $reflectionClassFactory = new ReflectionClassFactory();

        $reflectionClass = $reflectionClassFactory->createReflectionClass(MockController::class);

        self::assertEquals(MockController::class, $reflectionClass->getName());
    }

    public function testCreateReflectionClassWorksWithInterface(): void
    {
        $reflectionClassFactory = new ReflectionClassFactory();

        $reflectionClass = $reflectionClassFactory->createReflectionClass(MockInterface::class);

        self::assertEquals(MockInterface::class, $reflectionClass->getName());
    }
}
