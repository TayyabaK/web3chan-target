import { AlpineComponent } from 'alpinejs';
import type Editor from '../types/editor';

const TEXT_BRAND_PRIMARY_CLASS = 'text-brand-primary';
const HIGHLIGHTED_LOOKUP_CLASS = 'highlighted-lookup';

export interface DomManipulationInterface {
    cancelSpecialChar(): void;
    insertSpecialCharLookup(char: string, lookupName: string, dropdownId: string): void;
    checkHighlightLink(event: KeyboardEvent): void;
}

const createSpanNode = (textContent: string, lookup?: string): HTMLSpanElement => {
    const spanNode = document.createElement('span');
    spanNode.className = `${TEXT_BRAND_PRIMARY_CLASS} ${HIGHLIGHTED_LOOKUP_CLASS}`;
    spanNode.textContent = textContent;
    if (lookup) spanNode.dataset.lookup = lookup;
    return spanNode;
};

const domManipulation: DomManipulationInterface | AlpineComponent<Editor> = {
    cancelSpecialChar() {
        this.updateRemaining();
        console.log('Special char cancelled.');
        if (this.validatePreviousLookup()) {
            this.isSpecialChar = false;
            document.execCommand('insertHTML', false, '<span>&nbsp;</span>');
            this.stopCapturingLookup();
            this.closeAllDropdowns();
        }
    },
    insertSpecialCharLookup(char, lookupName, dropdownId) {
        const selection = window.getSelection();
        const clickedTextNode = selection.anchorNode;
        if (clickedTextNode && selection.anchorOffset > 0) {
            const prevChar = clickedTextNode.textContent.charAt(selection.anchorOffset - 1);
            const alphaNumericCheck = /^[0-9a-zA-Z@:#\/]+$/;
            if (alphaNumericCheck.test(prevChar)) {
                document.execCommand('insertHTML', false, char);
                this.updateRemaining();
                return;
            }
        }
        this.isSpecialChar = true;
        const htmlContent = `<span data-lookup="${lookupName}" class="${TEXT_BRAND_PRIMARY_CLASS} ${HIGHLIGHTED_LOOKUP_CLASS}">${char}</span>`;
        document.execCommand('insertHTML', false, htmlContent);
        this.updateRemaining();
        this.$dispatch('open-dropdown', {
            id: dropdownId,
            cursor: window.getSelection().getRangeAt(0).getBoundingClientRect(),
        });
        this.startCapturingLookup(lookupName);
    },
    checkHighlightLink(event) {
        const selection = window.getSelection();
        const clickedTextNode = selection.anchorNode;
        if (clickedTextNode && selection.anchorOffset > 0) {
            const currentWord = clickedTextNode.textContent.slice(0, selection.anchorOffset);
            const urlCheck = /(https?:\/\/[^\s]*|www\.[^\s]*)/g;
            const words = currentWord.split(' ');
            const lastWord = words[words.length - 1];
            if (urlCheck.test(lastWord)) {
                const remainingText = clickedTextNode.textContent.slice(selection.anchorOffset, clickedTextNode.length);
                const remainingTextNode = document.createTextNode(remainingText);
                if (clickedTextNode.parentNode.nodeName !== 'SPAN') {
                    clickedTextNode.textContent = clickedTextNode.textContent.slice(
                        0,
                        currentWord.length - lastWord.length,
                    );
                    const spanNode = createSpanNode(lastWord, 'link');
                    clickedTextNode.parentNode.insertBefore(spanNode, clickedTextNode.nextSibling);
                    clickedTextNode.parentNode.insertBefore(remainingTextNode, spanNode.nextSibling);
                    const position = event.key === ' ' ? 1 : 0;
                    selection.collapse(remainingTextNode, position);
                }
            }
        }
    },
};

export { domManipulation };
