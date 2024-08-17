<?php

declare(strict_types=1);

use App\Enums\Post\PostStatus;
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
        Schema::create('posts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('posts')->cascadeOnDelete();
            $table->foreignId('channel_id')->nullable()->constrained('channels')->cascadeOnDelete();
            $table->unsignedInteger('depth')->default(0);
            $table->json('blocks');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_highlighted')->default(false);

            $table->enum(
                column: 'status',
                allowed: array_column(PostStatus::cases(), 'value'),
            )->default(PostStatus::Active);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
