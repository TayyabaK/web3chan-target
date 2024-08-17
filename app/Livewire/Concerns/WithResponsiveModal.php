<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

trait WithResponsiveModal
{
    public bool $modalStickyFooter = false;

    public bool $modalSlideover = false;

    public string $modalWidth = '2xl';

    public function mountWithResponsiveModal(): void
    {
        if ($this->isMobile()) {
            $this->modalStickyFooter = true;
            $this->modalSlideover = true;
            $this->modalWidth = 'full';
        }
    }

    private function isMobile(): bool
    {
        return (bool) preg_match('/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', (string) request()->userAgent());
    }
}
