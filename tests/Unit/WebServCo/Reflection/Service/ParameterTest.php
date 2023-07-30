<?php

declare(strict_types=1);

namespace Tests\Unit\WebServCo\Reflection\Service;

use OutOfBoundsException;
use OutOfRangeException;
use PDO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Tests\Unit\Mock\MockDependency;
use WebServCo\Reflection\Contract\ReflectionServiceInterface;
use WebServCo\Reflection\Factory\ReflectionClassFactory;
use WebServCo\Reflection\Service\ReflectionService;

use function assert;

#[CoversClass(ReflectionService::class)]
#[UsesClass(ReflectionClassFactory::class)]
final class ParameterTest extends AbstractReflectionServiceTester
{
    public function testConstructorParameterAtIndex1(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $constructorParameter = $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 1);

        self::assertFalse($constructorParameter->allowsNull());

        self::assertEquals('dependency', $constructorParameter->getName());
    }

    public function testConstructorParameterAtIndex2(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $constructorParameter = $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 2);

        self::assertFalse($constructorParameter->allowsNull());

        self::assertEquals('pdo', $constructorParameter->getName());
    }

    public function testConstructorParameterAtIndex3(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $constructorParameter = $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 3);

        self::assertTrue($constructorParameter->allowsNull());

        self::assertEquals('string', $constructorParameter->getName());
    }

    public function testConstructorParameterAtIndex4ThrowsException(): void
    {
        $this->expectException(OutOfBoundsException::class);

        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 4);
    }

    public function testConstructorParameterReflectionClassAtIndex1(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $reflectionClass = $this->reflectionService->getConstructorParameterReflectionClassAtIndex(self::CLASS_NAME, 1);

        self::assertEquals(MockDependency::class, $reflectionClass->getName());
    }

    public function testConstructorParameterReflectionClassAtIndex2(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $reflectionClass = $this->reflectionService->getConstructorParameterReflectionClassAtIndex(self::CLASS_NAME, 2);

        self::assertEquals(PDO::class, $reflectionClass->getName());
    }

    public function testConstructorParameterReflectionClassAtIndex3(): void
    {
        // Param 3 is a string and not a class.

        $this->expectException(OutOfRangeException::class);

        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $this->reflectionService->getConstructorParameterReflectionClassAtIndex(self::CLASS_NAME, 3);
    }

    public function testConstructorParameterTypeAtIndex1(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(
            MockDependency::class,
            $this->reflectionService->getConstructorParameterTypeAtIndex(self::CLASS_NAME, 1),
        );
    }

    public function testConstructorParameterTypeAtIndex2(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(
            PDO::class,
            $this->reflectionService->getConstructorParameterTypeAtIndex(self::CLASS_NAME, 2),
        );
    }

    public function testConstructorParameterTypeAtIndex3(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(
            'string',
            $this->reflectionService->getConstructorParameterTypeAtIndex(self::CLASS_NAME, 3),
        );
    }
}
