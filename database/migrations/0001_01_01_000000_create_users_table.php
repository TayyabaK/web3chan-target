<?php

declare(strict_types=1);

use App\Enums\User\FinanceType;
use App\Enums\User\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // @todo Temp solution for now will add spatie roles later
            $table->boolean('is_admin')->default(false);

            // @todo Replace later with spatie media library
            $table->string('image')->nullable();
            $table->string('banner')->nullable();

            $table->enum(
                column: 'status',
                allowed: array_column(UserStatus::cases(), 'value'),
            )->default(UserStatus::Active);

            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_activity_at')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table): void {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('user_finance', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('receiver_id')->constrained('users');
            $table->foreignId('sender_id')->constrained('users');
            $table->integer('amount');
            $table->string('description')->nullable();
            $table->string('reference')->nullable();

            $table->enum(
                column: 'type',
                allowed: array_column(FinanceType::cases(), 'value'),
            )->default(FinanceType::Wallet);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_finance');
    }
};
