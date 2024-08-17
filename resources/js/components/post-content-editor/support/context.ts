import Editor from '../types/editor';

let contextEditor: Editor;

export const setContext = (value: Editor): void => {
    contextEditor = value;
};

export const getContext = (): Editor => {
    if (!contextEditor) {
        throw new Error('Context has not been set yet!');
    }
    return contextEditor;
};
