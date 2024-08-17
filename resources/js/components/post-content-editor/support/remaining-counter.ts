import { AlpineComponent } from 'alpinejs';
import type Editor from '../types/editor';
import { getContentEditableElm } from './content-editable';

export interface RemainingCounterInterface {
    limit: number;
    remaining: number;
    updateRemaining(): void;
}

const remainingCounter: RemainingCounterInterface | AlpineComponent<Editor> = {
    limit: 300,
    remaining: 0,
    updateRemaining() {
        this.remaining =
            this.limit -
            getContentEditableElm()
                .innerText.replace(/\u00a0/g, ' ')
                .replace(/\s+/g, '').length;
    },
};

export { remainingCounter };
