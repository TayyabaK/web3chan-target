import Editor from '../types/editor';

let contentEditableElm: HTMLElement;
export const setContentEditableElm = (context: Editor): void => {
    if ('querySelector' in context.$el) {
        contentEditableElm = context.$el.querySelector('[contenteditable="true"]');
    }
};

export const getContentEditableElm = (): HTMLElement => {
    if (!contentEditableElm) {
        throw new Error('Contenteditable element has not been set yet!');
    }
    return contentEditableElm;
};
