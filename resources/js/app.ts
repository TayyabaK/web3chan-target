import './bootstrap';
import 'preline';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm.js';

import PostContentEditorComponentAlpinePlugin from './components/post-content-editor';
import PhantomWalletComponentAlpinePlugin from './components/phantom-wallet';

document.addEventListener('alpine:init', () => {
    Alpine.plugin(PostContentEditorComponentAlpinePlugin);
    Alpine.plugin(PhantomWalletComponentAlpinePlugin);

    // Prevents conflict with preline tabs
    document.querySelectorAll('.fi-tabs').forEach((el) => {
        el.removeAttribute('role');
    });
});

document.addEventListener('livewire:navigated', () => {
    // Prevents conflict with preline tabs
    document.querySelectorAll('.fi-tabs').forEach((el) => {
        el.removeAttribute('role');
    });

    // @ts-ignore
    window.HSStaticMethods.autoInit();
});

Livewire.start();
