import { getContext } from './context';
import { getContentEditableElm } from './content-editable';
import { AlpineComponent } from 'alpinejs';
import type Editor from '../types/editor';

export interface MouseEventsInterface {
    onClick(): void;
    onClickOutside(): void;
}

const mouseEvents: MouseEventsInterface | AlpineComponent<Editor> = {
    onClick() {
        const selection: Selection = window.getSelection();
        const clickedTextNode: Node = selection.anchorNode;
        this.closeAllDropdowns();

        if (clickedTextNode && (clickedTextNode.parentNode as HTMLElement).classList.contains('highlighted-lookup')) {
            this.triggerLookup(clickedTextNode.parentNode);
            if (window.getSelection().rangeCount > 0 && this.currentLookup) {
                const range = window.getSelection().getRangeAt(0);
                range.setStart(clickedTextNode, 0);
                range.setEnd(clickedTextNode, clickedTextNode.length);
                this.syncLookupValue();
            }
        }
    },
    onClickOutside() {
        this.updateRemaining();
        this.$wire?.set('content', getContentEditableElm().innerText.replace(/\u00a0/g, ' '));
    },
};

export { mouseEvents };
