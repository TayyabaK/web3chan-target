<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Support\ContentParser;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

trait InteractsWithContentParser
{
    #[Computed]
    public function contentParsed(): string
    {
        $parser = new ContentParser([$this, 'routeLookup']);

        return $parser->parse($this->content);
    }

    public function tempContentAccessor(string $content): string
    {
        $parser = new ContentParser([$this, 'routeLookup']);

        return $parser->parse($content);
    }

    public function routeLookup(string $lookup, string $value): string
    {
        return match ($lookup) {
            'mention' => route('profile', Str::after($value, '@')),
            'topic' => route('topic', Str::after($value, '#')),
            'channel' => route('channel', Str::after($value, '/')),
            default => '',
        };
    }

    protected function replaceWord(string $search, string $replace, int $currentCaretPosition): string
    {
        $beforeCaret = substr($this->content, 0, $currentCaretPosition);
        $pos = strrpos($beforeCaret, $search);

        if ($pos === false) {
            return $this->content;
        }

        $this->content = substr_replace($beforeCaret, $replace, $pos, strlen($search)).substr($this->content, $currentCaretPosition);

        return $this->content;
    }

    protected function extractLookups(string $content): Collection
    {
        $lookups = [];
        $pattern = '/([@#\/])(\S+)/';

        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $type = match ($match[1]) {
                    '@' => 'mention',
                    '#' => 'topic',
                    '/' => 'channel',
                    default => 'unknown'
                };
                $lookups[$type][] = $match[2];
            }
        }

        return collect($lookups);
    }
}
