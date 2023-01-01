<?php

namespace Tests;


use App\Models\User;

class FeatureTestCase extends TestCase
{
    use CreatesApplication;

    protected ?User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin ??= User::factory()
            ->admin()
            ->create();
    }
}
