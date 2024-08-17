import type { KeyStrategiesInterface } from '../support/key-strategies';
import type { MouseEventsInterface } from '../support/mouse-events';
import type { RemainingCounterInterface } from '../support/remaining-counter';
import type { LookupsInterface } from '../support/lookups';
import type { DomManipulationInterface } from '../support/dom-manipulation';

export default interface Editor
    extends KeyStrategiesInterface,
        MouseEventsInterface,
        RemainingCounterInterface,
        LookupsInterface,
        DomManipulationInterface {
    content: string;
    editorFor: string;
    currentLookup: any;
    currentLookupValue: any;
    init: () => void;
    closeAllDropdowns: () => void;
    triggerMentions: (event: KeyboardEvent) => void;
    triggerTopics: (event: KeyboardEvent) => void;
    triggerChannels: (event: KeyboardEvent) => void;
    $wire?: {
        set: (key: string, value: string) => void;
    };
    $el?: HTMLElement;
}
