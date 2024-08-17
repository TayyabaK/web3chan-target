<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Niko De Jonghe',
                'username' => 'niko',
                'email' => 'de.jonghe.niko@icloud.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
            [
                'name' => 'Adam Lee',
                'username' => 'adam_clx',
                'email' => 'adam@codelabx.ltd',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
        ])->each(fn ($user) => User::create($user));
    }
}
