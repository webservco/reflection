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
    private const CLASS_NAME = MockController::class;

    private ?ReflectionServiceInterface $reflectionService = null;

    public function getReflectionService(): ReflectionServiceInterface
    {
        return new ReflectionService(new ReflectionClassFactory());
    }

    public function testConstructor(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('__construct', $this->reflectionService->getConstructor(self::CLASS_NAME)->getName());
    }

    public function testConstructorParameterAtIndex1(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(
            'dependency',
            $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 1)->getName(),
        );
    }

    public function testConstructorParameterAtIndex2(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(
            'pdo',
            $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 2)->getName(),
        );
    }

    public function testConstructorParameterAtIndex3(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals(
            'string',
            $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 3)->getName(),
        );
    }

    public function testConstructorParameterAtIndex4ThrowsException(): void
    {
        $this->expectException(OutOfBoundsException::class);

        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $this->reflectionService->getConstructorParameterAtIndex(self::CLASS_NAME, 4);
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

    public function testImplementsInterface(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        $reflectionClassAtIndex1 = $this->reflectionService
        ->getConstructorParameterReflectionClassAtIndex(self::CLASS_NAME, 1);

        self::assertTrue($reflectionClassAtIndex1->implementsInterface(MockInterface::class));
    }

    protected function setUp(): void
    {
        $this->reflectionService = $this->getReflectionService();
    }

    protected function tearDown(): void
    {
        $this->reflectionService = null;
    }
}
