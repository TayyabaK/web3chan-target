<?php

declare(strict_types=1);

namespace Database\Factories\Concerns;

trait WithBlocks
{
    /**
     * @return array<string, mixed>
     */
    private function defineBlocks(): array
    {
        $blocks = collect([
            'content' => $this->faker->realText(random_int(100, 300)),
            'poll' => [
                'question' => $this->faker->sentence,
                'options' => [
                    $this->faker->sentence,
                    $this->faker->sentence,
                    $this->faker->sentence,
                    $this->faker->sentence,
                ],
            ],
        ]);

        $this->faker->boolean
            ? $blocks->put('media', $this->randomMedia()) // @phpstan-ignore-line
            : $blocks->put('giphy', $this->randomGiphy());

        return $blocks->toArray();
    }

    /**
     * @return array<string, string>
     */
    private function randomMedia(): array
    {
        return collect([
            ['type' => 'image', 'url' => 'https://fastly.picsum.photos/id/1037/600/400.jpg?hmac=E7oV9MlYzBUFFygTj04kbdysY_Yu8n2jqR9o-hXekyU'],
            ['type' => 'image', 'url' => 'https://fastly.picsum.photos/id/638/600/400.jpg?hmac=8VrBDjauAXP1SKQLTJROxss4oSvNdclueX9HtzD739U'],
            ['type' => 'image', 'url' => 'https://fastly.picsum.photos/id/701/600/400.jpg?hmac=JL-FnBwl5mr0M13Xus0vj6sufNiRo9P-Wm3pp6H_nTs'],
            ['type' => 'video', 'url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'],
            ['type' => 'image', 'url' => 'https://fastly.picsum.photos/id/546/600/400.jpg?hmac=DihO_j-eFueKyqEievwZ3-je4TfIFY3mQF1YiEANknk'],
            ['type' => 'video', 'url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4'],
            ['type' => 'image', 'url' => 'https://fastly.picsum.photos/id/524/600/400.jpg?hmac=dHi4SzGwI6OXIEY7vXNpt6ohHGoDaZevHE0lBuB85xU'],
            ['type' => 'video', 'url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4'],
            ['type' => 'image', 'url' => 'https://fastly.picsum.photos/id/549/600/400.jpg?hmac=Gh6Z6E0cjQrKlCHA9WKAhTdaSOd4vvqBHG_IKhWcch0'],
        ])->random();
    }

    private function randomGiphy(): string
    {
        return collect([
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExY2VwNDIzMjBobnR1dG5oZ3A4cXc3b205d2M2M3YycWo1cGdremlpcCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/ZtcfojuInM5pINYAEh/giphy.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExY2dhMGxmY3pjYnM0OWdwcmpyNXVnY2syYWh2YTN4cmQ5dmMxbWdndSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/PUedWFeSyE27WkDNO1/giphy.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExemZ6bjh5MjRkOTRlaGI5dXdoMDl5bHN3ODYxbDh4ZW5qbW50dTYyYiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/szHPD0K5SZu2Wfiv8T/giphy.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExZmRtMzA2Mm82aTJocDh4cjE3Ym9qMTZrdGxuY3R1YzBremZxeWUweCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/5b43CXUqqkvGL4nhq9/giphy.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExa2kzOWl1d2xycXNiZ2p1dzdoOXdvYmZiYWI5M3VzYzE1ejFhemlmOCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/xFbfVbbQf2v0O9OLLE/giphy.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3liaXV3MGR6bTJyMHFybGM5cjA2Ynkxam5zMm1pcHhlbHN6emptNSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/6e78TTPO5qz9B4DKok/giphy.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExd3J1MDMxc2c5ZXo0ZXpmYWk2aWlhNTk4MmdheTN4bGxscmVydzR5cCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/VRKheDy4DkBMrQm66p/giphy-downsized-large.gif',
            'https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExd2Vsajc5cHQ1MGNycG42bjJqNGM0amRsbnFqdTg3OGRmcnF4aW1kaSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/ZfPDNUToHFbNstchdZ/giphy.gif',
            'https://media3.giphy.com/media/MF232H4EVhfTv1h6pf/200.webp?cid=790b7611u95wp5sdtotz23r3ee8m3s7sp6mv1kdwerr8f1rt&ep=v1_gifs_search&rid=200.webp&ct=g',
            'https://media0.giphy.com/media/utJKJmadD3dZFJ01XR/200.webp?cid=ecf05e4788mub8fmafztonse6fvr4r7nomy7s9x8anb4ib64&ep=v1_gifs_search&rid=200.webp&ct=g',
            'https://media4.giphy.com/media/fTtNMQ737dqZCkg4dk/giphy.webp?cid=790b7611tcwqynfe17yep2b85srbtchufmgxr2c3r5rqu6zg&ep=v1_gifs_search&rid=giphy.webp&ct=g',
            'https://media4.giphy.com/media/lNY0a9aJgFcCaDn1nw/giphy.webp?cid=ecf05e47yeynr7f09ncoz2n1i3qf02wqhklj2xj50zs1mhi1&ep=v1_gifs_search&rid=giphy.webp&ct=g',
        ])->random();
    }
}
