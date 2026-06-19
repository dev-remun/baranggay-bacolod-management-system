
@props([
    'label' => 'label',
    'onClick' => '',
    'is_active' => false,
    'is_finish' => false,
    'is_incomplete' => true,
    'class' => ''
])

@php

    # chip
    if($is_finish) {
        $circle_style = 'bg-green-400 border-green-200';
        $text_style = 'text-green-400';
    }

    else if($is_active) {
        $circle_style = 'bg-blue-400 border-blue-200';
        $text_style = 'text-blue-400';
    }

    else {
        $circle_style = 'bg-gray-400 border-gray-200';
        $text_style = 'text-gray-400';
    }
@endphp

<div class="flex items-center gap-x-[6px] cursor-pointer {{ $class }}">
    <div class=" {{ $circle_style }} w-[9px] h-[9px] md:w-[12px] md:h-[12px] rounded-full border-2"> </div>
    <p class="{{ $text_style }} font-inter text-[9px] md:text-[12px]">{{ $label }}</p>
</div>
