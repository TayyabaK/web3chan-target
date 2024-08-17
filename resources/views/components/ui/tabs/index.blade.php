@if (filled($slot))
    <div
        class="z-5 sticky top-[72px] flex items-center justify-center gap-4 bg-brand-darkest/95 text-center text-neutral md:top-[84px] lg:gap-16"
    >
        {{ $slot }}
    </div>
@endif
