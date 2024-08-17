@props([
    "editorFor" => "post",
    "placeholder" => "Anything new to share?",
])

<div>
    <div
        class="editorWrap"
        x-data="postContentEditorComponent"
    >
        <!-- prettier-ignore -->
        <div
            editorFor="{{ $editorFor }}"
            contenteditable="true"
            @paste="handlePaste($event)"
            placeholder="{{ $placeholder }}"
            rows="1"
            placeholder="Anything new to share?"
            @class([
                "no-border-focus relative w-full resize-none bg-transparent p-4 pb-0 text-left text-sm placeholder:text-neutral",
                "min-h-8 pb-4" => $editorFor === "dm",
            ])
            @if ($editorFor === "post")
                x-data="{
                    resize: () => {
                        $el.style.height = '5px'
                        $el.style.height = $el.scrollHeight + 'px'
                        if ($el.scrollHeight > 200) {
                            $el.style.height = '200px'
                            $el.style.overflowY = 'scroll'
                        }
                    } <!-- prettier-ignore -->
                }"
            @endif
            :maxlength="limit"
            @keydown="onKeydown($event)"
            @keyup="onKeyup($event)"
            @click.outside="onClickOutside($event)"
            @click="onClick($event)"
            @input="resize"
        >{!! $this->contentParsed !!}</div>

        @if ($editorFor === "post")
            <p
                x-ref="remaining"
                class="p-2 text-right text-xs text-brand-primary"
            >
                <span
                    x-text="remaining"
                    class="text-brand-primary"
                    :class="{
                'text-red-600': remaining < 0,
            }"
                ></span>
                /
                <span
                    x-text="limit"
                    class="text-brand-primary"
                ></span>
            </p>
        @endif
    </div>
</div>
