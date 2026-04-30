@php   
    $cards = [
        [
            'title' => 'Home',
            'desc' => 'loraempom  1  lora adqwfd dad lora adqwfd dadlora adqwfd dadlora adqwfd dadlora adqwfd dad',
        ],
        [
            'title' => 'About',
            'desc' => 'loraempom  1  lora adqwfd dad lora adqwfd dadlora adqwfd dadlora adqwfd dadlora adqwfd dad',
        ],
        [
            'title' => 'Contact',
            'desc' => 'loraempom  1  lora adqwfd dad lora adqwfd dadlora adqwfd dadlora adqwfd dadlora adqwfd dad',
        ],
        [
            'title' => 'Services',
            'desc' => 'loraempom  1  lora adqwfd dad lora adqwfd dadlora adqwfd dadlora adqwfd dadlora adqwfd dad',
        ],
    ];

@endphp

@foreach ($cards as $card)

<div>
    <h1>{{ $card['title'] }}</h1>
    <p>{{ $card['desc'] }}</p>
</div>
    
@endforeach
