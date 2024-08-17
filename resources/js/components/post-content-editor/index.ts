import type Editor from './types/editor';

import { setup } from './support/setup';
import { keyStrategiesEvents } from './support/key-strategies';
import { mouseEvents } from './support/mouse-events';
import { remainingCounter } from './support/remaining-counter';
import { lookups } from './support/lookups';
import { domManipulation } from './support/dom-manipulation';
import { AlpineComponent } from 'alpinejs';

const editorInstance: Editor | AlpineComponent<Editor> = {
    content: '',
    editorFor: 'post',
    ...keyStrategiesEvents,
    ...mouseEvents,
    ...remainingCounter,
    ...lookups,
    ...domManipulation,
    init() {
        this.$nextTick(() => {
            setup(this as Editor);
            this.updateRemaining();
        });
    },
    closeAllDropdowns() {
        this.$dispatch('close-dropdown', { id: 'mentions-dropdown' });
        this.$dispatch('close-dropdown', { id: 'topics-dropdown' });
        this.$dispatch('close-dropdown', { id: 'channels-dropdown' });
    },
    triggerMentions(event: KeyboardEvent) {
        this.insertSpecialCharLookup(event.key, 'mention', 'mentions-dropdown');
    },
    triggerTopics(event) {
        this.insertSpecialCharLookup(event.key, 'topic', 'topics-dropdown');
    },
    triggerChannels(event) {
        this.insertSpecialCharLookup(event.key, 'channel', 'channels-dropdown');
    },
};

export default (Alpine: AlpineComponent<any>) => {
    Alpine.data('postContentEditorComponent', () => ({ ...editorInstance }));
};
