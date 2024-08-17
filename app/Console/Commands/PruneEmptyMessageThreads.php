<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\MessageThread;
use Illuminate\Console\Command;

class PruneEmptyMessageThreads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-empty-message-threads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune empty message threads';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->components->info('Pruning empty message threads...');

        $emptyThreads = MessageThread::doesntHave('messages')->get();

        if ($emptyThreads->isEmpty()) {
            $this->components->warn('No empty message threads found.');

            return;
        }

        $emptyThreads->each(
            fn (MessageThread $thread): bool => $thread->created_at->diffInHours(now()) > 1 && $thread->delete(),
        );

        $this->components->info('Empty message threads have been pruned.');
    }
}
