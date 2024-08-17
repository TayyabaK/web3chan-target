import Editor from '../types/editor';
import { setContext } from './context';
import { getContentEditableElm, setContentEditableElm } from './content-editable';

const setup = (context: Editor) => {
    setContext(context);
    setContentEditableElm(context);

    getContentEditableElm().addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });

    window.addEventListener('lookup', (e: CustomEvent) => {
        if (e.detail.selected) {
            console.log(context.$el);
            context.replaceWithSelected(e.detail.selected);
        }
    });

    window.addEventListener('lookupNoResults', (e: CustomEvent) => {
        if (e.detail[0].lookup === context.currentLookup) {
            context.validateLookup();
        }
    });

    window.addEventListener('lookupExactMatch', (e: CustomEvent) => {
        if (e.detail[0].lookup === context.currentLookup) {
            console.log('Exact match:', e.detail[0].value);
            context.validateLookups[context.currentLookup].push(e.detail[0].value);
        }
    });

    setTimeout(() => {
        getContentEditableElm().focus();
    }, 100);
};

export { setup };
