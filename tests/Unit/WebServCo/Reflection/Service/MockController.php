<?php

declare(strict_types=1);

namespace Tests\Unit\WebServCo\Reflection\Service;

use PDO;

final class MockController
{
    public function __construct(private MockDependency $dependency, private PDO $pdo, private string $string)
    {
    }

    public function getDependency(): MockDependency
    {
        return $this->dependency;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function getString(): string
    {
        return $this->string;
    }
}
