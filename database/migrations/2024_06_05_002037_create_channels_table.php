<?php

declare(strict_types=1);

use App\Enums\Channel\ChannelStatus;
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
        Schema::create('channels', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('owner_id')->constrained('users');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_private')->default(false);
            $table->json('rules')->nullable();

            // @todo Replace later with spatie media library
            $table->string('image')->nullable();
            $table->string('banner')->nullable();

            $table->enum(
                column: 'status',
                allowed: array_column(ChannelStatus::cases(), 'value'),
            )->default(ChannelStatus::Active);

            $table->timestamps();
        });

        Schema::create('channel_member', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('role', ['moderator', 'member', 'admin'])->default('member');
            $table->timestamp('joined_at')->useCurrent();
            $table->index(['channel_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('channels');
        Schema::dropIfExists('channel_member');
    }
};
