<div>
    <ul class="space-y-1">
        @foreach ($this->getSteps as $item)
            <li class="relative">
                <div class="block w-full">
                    {{-- Action is like an invisible layer should not include the item details or status --}}
                    <button
                        type="button"
                        @class([
                            "block w-full p-2 text-left",
                            "disabled cursor-not-allowed" => session()->has($item["sessionName"]),
                            "btn-retro cursor-pointer hover:bg-brand-primary" => ! session()->has(
                                $item["sessionName"],
                            ),
                        ])
                        size="md"
                        @if (session()->has($item["sessionName"]))
                            disabled
                        @endif
                        @if ($item["actionType"] === \App\Enums\User\OnboardingStepActionType::Modal)
                            wire:click="mountAction('{{ $item["actionName"] }}')"
                        @elseif ($item["actionType"] === \App\Enums\User\OnboardingStepActionType::Emit)
                            wire:click="$dispatch('{{ $item["actionName"] }}')"
                        @endif
                    >
                        <div class="flex gap-2">
                            <div class="z-[5] mr-2 flex-shrink-0">
                                @if (session()->has($item["sessionName"]))
                                    <x-icons.check fill="success" />
                                @else
                                    <img
                                        src="{{ asset($item["icon"]) }}"
                                        class="size-8"
                                        alt=""
                                    />
                                @endif
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold text-white">
                                    {{ $item["label"] }}
                                </h4>
                                <span class="text-left">+{{ $item["earnableTokens"] }} tokens</span>
                            </div>
                        </div>
                    </button>
                </div>
                {{-- List item (Status icon / step name) --}}
            </li>
        @endforeach
    </ul>

    <x-filament-actions::modals />
</div>
