@props([
    'userName' => 'NikoDJ',
    'referralCode' => '3chan-' . md5('3chan'),
])

<x-ui.list.container :hasBackground="true">
    <x-slot name="heading">@lang('Invite friends, earn 3chans')</x-slot>

    <p class="mt-4 text-xs text-white">
        @lang('You and your friend each get 3chans if they sign up using your invitation link')
    </p>

    <div
        x-cloak
        x-data="initInviteLink"
    >
        <button
            type="button"
            class="mt-4 block w-full rounded-lg border border-brand-accent bg-black p-4 text-center font-semibold text-white"
            :class="{ 'bg-brand-accent': inviteLinkCopied === true }"
            @click="copyInviteLink"
        >
            <span x-text="inviteLinkCopied ? labels.copied : labels.copy"></span>
        </button>
    </div>

    @script
        <script>
            Alpine.data('initInviteLink', () => ({
                labels: {
                    copied: @js(__('Link Copied')),
                    copy: @js(__('Copy Invite Link')),
                },
                inviteLinkCopied: false,
                init() {
                    console.log('initInvite', this.inviteLinkCopied);
                },
                copyInviteLink() {
                    const inviteLink = @js(config('app.url')) + '/register/?referral=' + @js($userName) + '&referral_code=' + @js($referralCode);
                    navigator.clipboard.writeText(inviteLink);
                    this.inviteLinkCopied = true;

                    setTimeout(() => {
                        this.inviteLinkCopied = false;
                    }, 4000);
                },
            }));
        </script>
    @endscript
</x-ui.list.container>
