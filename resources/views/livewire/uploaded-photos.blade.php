<div>
    <table class="w-full">
        <tbody>
            <tr class="my-6">
                <td class="p-2">
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($this->photos as $photo)
                            <img src="{{ asset($photo) }}" class="" alt="">
                        @endforeach
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
