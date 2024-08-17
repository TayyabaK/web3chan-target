<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if ($this->authenticatedInNamespaces()) {
            $this->actingAs($this->createUser());
        }
    }

    protected function createUser(): User
    {
        return User::factory()->create();
    }

    protected function authenticatedInNamespaces(): bool
    {
        return Str::of(get_class($this))->contains([
            'Livewire',
        ]);
    }
}
