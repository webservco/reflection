<?php

declare(strict_types=1);

namespace Tests\Unit\WebServCo\Reflection\Service;

use OutOfBoundsException;
use PDO;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use WebServCo\Reflection\Contract\ReflectionServiceInterface;
use WebServCo\Reflection\Factory\ReflectionClassFactory;
use WebServCo\Reflection\Service\ReflectionService;

use function assert;

#[CoversClass(ReflectionService::class)]
#[UsesClass(ReflectionClassFactory::class)]
final class ReflectionServiceTest extends TestCase
{
    private ?ReflectionServiceInterface $reflectionService = null;

    public function getReflectionService(string $className): ReflectionServiceInterface
    {
        return new ReflectionService($className, new ReflectionClassFactory());
    }

    public function testConstructor(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('__construct', $this->reflectionService->getConstructor()->getName());
    }

    public function testConstructorParameterAtIndex1(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('dependency', $this->reflectionService->getConstructorParameterAtIndex(1)->getName());
    }

    public function testConstructorParameterAtIndex2(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('pdo', $this->reflectionService->getConstructorParameterAtIndex(2)->getName());
    }

    public function testConstructorParameterAtIndex3(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('string', $this->reflectionService->getConstructorParameterAtIndex(3)->getName());
    }

    public function testConstructorParameterAtIndex4ThrowsException(): void
    {
        $this->expectException(OutOfBoundsException::class);

        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $this->reflectionService->getConstructorParameterAtIndex(4);
    }

    public function testConstructorParameterTypeAtIndex1(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(MockDependency::class, $this->reflectionService->getConstructorParameterTypeAtIndex(1));
    }

    public function testConstructorParameterTypeAtIndex2(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(PDO::class, $this->reflectionService->getConstructorParameterTypeAtIndex(2));
    }

    public function testConstructorParameterTypeAtIndex3(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('string', $this->reflectionService->getConstructorParameterTypeAtIndex(3));
    }

    public function testImplementsInterface(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $reflectionClassAtIndex1 = $this->reflectionService->getConstructorParameterReflectionClassAtIndex(1);

        self::assertTrue($reflectionClassAtIndex1->implementsInterface(MockInterface::class));
    }

    protected function setUp(): void
    {
        $this->reflectionService = $this->getReflectionService(MockController::class);
    }

    protected function tearDown(): void
    {
        $this->reflectionService = null;
    }
}
