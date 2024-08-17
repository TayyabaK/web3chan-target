<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Str;

class ContentParser
{
    /**
     * @var array<string, string>
     */
    private array $lookupMapping = [
        '@' => 'mention',
        '#' => 'topic',
        '/' => 'channel',
    ];

    public function __construct(private readonly mixed $routeLookupFunction = null) {}

    public function parse(string $content): string
    {
        $content = Str::of($content);

        $content = $content->replaceMatches('/([@#\/]|https?:\/\/|www\.)[^\s]*/', function ($match) {
            $symbol = substr((string) $match[0], 0, 1);
            $value = $match[0];

            if (($symbol === 'h' || $symbol === 'w')) {
                $route = strtolower(substr($value, 0, 4)) === 'www.' ? "http://$value" : $value;

                return $this->formatLink($route, $value, '_blank');
            }

            if (isset($this->lookupMapping[$symbol])) {
                $lookup = $this->lookupMapping[$symbol];
                if ($lookup !== 'link') {
                    $route = ($this->routeLookupFunction)($lookup, substr($value, 1));

                    return $this->formatLink($route, $value);
                }

                return $this->formatLookupSpan($lookup, $value);
            }

            return $value;
        });

        return $content->value();
    }

    private function formatLink(string $url, string $value, string $target = ''): string
    {
        $target = $target !== '' && $target !== '0' ? "target=\"$target\"" : 'wire:navigate';

        return "<a href=\"$url\" $target class=\"text-brand-primary hover:text-brand-accent\">$value</a>";
    }

    private function formatLookupSpan(string $lookup, string $value): string
    {
        return "<span data-lookup=\"$lookup\" class=\"text-brand-primary hover:text-brand-accent\">$value</span>";
    }
}
