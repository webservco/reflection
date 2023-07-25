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
final class ConstructorTest extends AbstractReflectionServiceTester
{
    public function testConstructor(): void
    {
        assert($this->reflectionService instanceof ReflectionServiceInterface);

        self::assertEquals('__construct', $this->reflectionService->getConstructor(self::CLASS_NAME)->getName());
    }
}
