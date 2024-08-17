import { getContentEditableElm } from './content-editable';
import { AlpineComponent } from 'alpinejs';
import type Editor from '../types/editor';

export interface LookupsInterface {
    currentLookup: string | null;
    currentLookupValue: string | null;
    currentCaretPosition: number | null;
    validateLookups: {
        mention: string[];
        topic: string[];
        channel: string[];
    };
    syncLookupValue(): void;
    triggerLookup(node: Node): void;
    startCapturingLookup(lookupName: string): void;
    stopCapturingLookup(): void;
    replaceWithSelected(selected: string): void;
    validateLookup(): void;
    validatePreviousLookup(): boolean;
}

const lookups: LookupsInterface | AlpineComponent<Editor> = {
    currentLookup: null,
    currentLookupValue: null,
    currentCaretPosition: null,
    validateLookups: {
        mention: [],
        topic: [],
        channel: [],
    },
    syncLookupValue() {
        this.currentLookupValue = window.getSelection().anchorNode.textContent;

        let sel = window.getSelection();
        if (sel.rangeCount > 0) {
            let range = sel.getRangeAt(0);
            let editableContent = getContentEditableElm();
            if (editableContent) {
                let preCaretRange = range.cloneRange();
                preCaretRange.selectNodeContents(editableContent);
                preCaretRange.setEnd(sel.anchorNode, sel.anchorOffset);
                this.currentCaretPosition = preCaretRange.toString().length;
            }
        }
        console.log('Content:', this.currentLookupValue, this.currentCaretPosition, this.currentLookup);

        this.$dispatch('update-lookup-value', {
            lookup: this.currentLookup,
            value: this.currentLookupValue,
        });
    },
    triggerLookup(element: HTMLElement) {
        if (element && element.hasAttribute('data-lookup')) {
            console.log('Lookup attribute value:', element.getAttribute('data-lookup'));
            const dropdownId = `${element.getAttribute('data-lookup')}s-dropdown`;
            this.$dispatch('open-dropdown', {
                id: dropdownId,
                cursor: window.getSelection().getRangeAt(0).getBoundingClientRect(),
            });
        }
    },
    startCapturingLookup(lookupName) {
        this.currentLookup = lookupName;
    },
    stopCapturingLookup() {
        this.currentLookup = null;
    },
    replaceWithSelected(selected) {
        console.log('Selected:', selected, this.currentLookup, this.currentLookupValue, this.currentCaretPosition);
        this.closeAllDropdowns();

        this.$dispatch('replace-lookup-value', {
            lookup: this.currentLookup,
            value: this.currentLookupValue,
            currentCaretPosition: this.currentCaretPosition,
            selected,
        });

        console.log('replace-lookup-value', {
            lookup: this.currentLookup,
            value: this.currentLookupValue,
            currentCaretPosition: this.currentCaretPosition,
            selected,
        });

        this.validateLookups[this.currentLookup].push(selected);

        console.log('validateLookups:', this.validateLookups);
        this.stopCapturingLookup();
    },
    validateLookup() {
        const selection = window.getSelection();
        const clickedTextNode = selection.anchorNode;

        if (clickedTextNode && (<Element>clickedTextNode.parentNode).classList.contains('highlighted-lookup')) {
            if (window.getSelection().rangeCount > 0 && this.currentLookup) {
                clickedTextNode.textContent = clickedTextNode.textContent.charAt(0);
                this.triggerLookup(clickedTextNode.parentNode);

                const range = document.createRange();
                range.setStart(clickedTextNode, 1);
                range.setEnd(clickedTextNode, 1);

                selection.removeAllRanges();
                selection.addRange(range);
                this.syncLookupValue();
            }
        }
    },
    validatePreviousLookup(): boolean {
        if (this.currentLookup === 'topic') {
            return true;
        }

        const selection = window.getSelection();
        const clickedTextNode = selection.anchorNode;

        if (clickedTextNode && (<Element>clickedTextNode.parentNode).classList.contains('highlighted-lookup')) {
            if (window.getSelection().rangeCount > 0 && this.currentLookup) {
                if (!this.validateLookups[this.currentLookup].includes(clickedTextNode.textContent)) {
                    clickedTextNode.textContent = clickedTextNode.textContent.charAt(0);
                    this.triggerLookup(clickedTextNode.parentNode);
                    const range = document.createRange();
                    range.setStart(clickedTextNode, 1);
                    range.setEnd(clickedTextNode, 1);

                    selection.removeAllRanges();
                    selection.addRange(range);
                    this.syncLookupValue();

                    return false;
                }
            }
        }

        return true;
    },
};

export { lookups };
