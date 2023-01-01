<?php

namespace Tests;

use App\Models\User;

trait PrepareAdminUser 
{
    private ?User $admin;

    protected function createAdmin(): void
    {
        parent::setUp();

        $this->admin ??= User::factory()
            ->admin()
            ->create();
    }
}
