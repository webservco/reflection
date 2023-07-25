<?php

declare(strict_types=1);

namespace Tests\Unit\WebServCo\Reflection\Service;

use PHPUnit\Framework\TestCase;
use Tests\Unit\Mock\MockController;
use WebServCo\Reflection\Contract\ReflectionServiceInterface;
use WebServCo\Reflection\Factory\ReflectionClassFactory;
use WebServCo\Reflection\Service\ReflectionService;

abstract class AbstractReflectionServiceTester extends TestCase
{
    protected const CLASS_NAME = MockController::class;

    protected ?ReflectionServiceInterface $reflectionService = null;

    public function getReflectionService(): ReflectionServiceInterface
    {
        return new ReflectionService(new ReflectionClassFactory());
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
