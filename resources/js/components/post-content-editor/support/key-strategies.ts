import { AlpineComponent } from 'alpinejs';
import type Editor from '../types/editor';

export interface KeyStrategiesInterface {
    modKeyDown: boolean;
    shiftKeyDown: boolean;
    isSpecialChar: boolean;
    keyStrategies: Record<string, Function>;
    onKeydown(event: KeyboardEvent): void;
    onKeyup(event: KeyboardEvent): void;
    resize(): void;
    triggerUndoShortcut(): void;
    triggerRedoShortcut(): void;
    handlePaste(event: ClipboardEvent): void;
}

const keyStrategiesEvents: KeyStrategiesInterface | AlpineComponent<Editor> = {
    modKeyDown: false,
    shiftKeyDown: false,
    isSpecialChar: false,
    keyStrategies: {
        Control: function () {
            this.modKeyDown = true;
        },
        Meta: function () {
            this.modKeyDown = true;
        },
        Shift: function () {
            this.shiftKeyDown = true;
        },
        z: function () {
            if (this.modKeyDown) {
                this.shiftKeyDown ? this.triggerRedoShortcut() : this.triggerUndoShortcut();
            }
        },
        y: function () {
            this.modKeyDown && this.triggerRedoShortcut();
        },
        ' ': function (event) {
            event.preventDefault();
            this.cancelSpecialChar(event);
        },
        '@': function (event) {
            event.preventDefault();
            this.triggerMentions(event);
        },
        '#': function (event) {
            event.preventDefault();
            this.triggerTopics(event);
        },
        '/': function (event) {
            event.preventDefault();
            this.triggerChannels(event);
        },
    },
    onKeydown(event) {
        const key = event.key;
        if (this.keyStrategies[key]) {
            this.keyStrategies[key].call(this, event);
        } else {
            this.isSpecialChar = false;
            this.updateRemaining();
        }
    },
    onKeyup(event) {
        if (event.key === 'Shift') this.shiftKeyDown = false;
        if (event.key === 'Control' || event.key === 'Meta') this.modKeyDown = false;

        if (this.currentLookup) {
            this.updateRemaining();
            this.syncLookupValue();
        }

        this.checkHighlightLink(event);
    },
    resize() {
        const editableContent = this.$refs.editableContent;
        editableContent.style.height = '5px';
        editableContent.style.height = editableContent.scrollHeight + 'px';

        if (editableContent.scrollHeight > 200) {
            editableContent.style.height = '200px';
            editableContent.style.overflowY = 'scroll';
        }
    },
    triggerUndoShortcut() {
        console.log('Undo shortcut pressed.');
        this.updateRemaining();
    },
    triggerRedoShortcut() {
        console.log('Redo shortcut pressed.');
        this.updateRemaining();
    },
    handlePaste(event) {
        event.preventDefault();

        const lookupMapping = {
            '@': 'mention',
            '#': 'topic',
            '/': 'channel',
        };

        let text = event.clipboardData.getData('text/plain');
        const urlCheck = /(https?:\/\/[^\s]*|www\.[^\s]*)/g;

        text = text
            .replace(/([@#]\S*)/g, (match) => {
                const lookup = lookupMapping[match[0]]; // get the corresponding lookup
                return `<span data-lookup="${lookup}" class="text-brand-primary">${match}</span>`;
            })
            .replace(urlCheck, (url) => `<span data-lookup="link" class="text-brand-primary">${url}</span>`);

        document.execCommand('insertHTML', false, text);
        this.updateRemaining();
    },
};

export { keyStrategiesEvents };
