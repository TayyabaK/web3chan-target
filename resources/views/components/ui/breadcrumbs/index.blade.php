@props([
    'hasBackText' => true,
    'hrefBack' => null,
])

<nav {{ $attributes->merge(['class' => 'flex-center mx-4 sticky md:top-[84px] z-5 bg-brand-darkest/95 py-4']) }}>
    <ol class="flex flex-wrap items-center gap-x-4">
        <li class="mr-6">
            <a
                href="{{ $hrefBack }}"
                wire:navigate
            >
                <span class="flex-center gap-2">
                    <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M11.7068 7.70857C11.8943 7.52088 11.9997 7.2663 11.9998 7.00083C11.9997 6.80287 11.9411 6.60937 11.8312 6.44479C11.7213 6.28021 11.5651 6.15194 11.3824 6.07619C11.1997 6.00044 10.9987 5.98062 10.8048 6.01922C10.6108 6.05783 10.4326 6.15314 10.2928 6.29309L5.39196 11.199C5.35725 11.2256 5.32415 11.2546 5.29289 11.2859C5.10536 11.4737 5 11.7283 5 11.9938C5 11.9958 5.00001 11.9979 5.00002 11.9999C5.00001 12.002 5 12.004 5 12.006C5 12.2715 5.10532 12.5261 5.29279 12.7138L10.2928 17.719C10.4814 17.9013 10.734 18.0022 10.9962 18C11.2584 17.9977 11.5092 17.8924 11.6946 17.7068C11.88 17.5212 11.9852 17.2701 11.9875 17.0077C11.9897 16.7452 11.8889 16.4923 11.7068 16.3035L8.40152 12.9948L18 12.9948C18.2652 12.9948 18.5196 12.8893 18.7071 12.7016C18.8946 12.5139 19 12.2593 19 11.9938C19 11.7283 18.8946 11.4737 18.7071 11.2859C18.5196 11.0982 18.2652 10.9927 18 10.9927L8.42605 10.9927L11.7068 7.70857Z"
                            fill="#F6F6F6"
                        />
                    </svg>
                    @if ($hasBackText)
                        <span class="font-bold text-white">Back</span>
                    @endif
                </span>
            </a>
        </li>

        {{ $slot }}
    </ol>
</nav>
