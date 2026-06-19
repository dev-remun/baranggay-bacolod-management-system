@props([
    "label",
    "name",
    "placeholder" => "Placeholder",
    "type" => "text",
    "is_required" => false,
    "value" => ''
])

<div class="relative flex flex-col gap-y-[4px] w-full">
    <label for="{{ $name }}" class="font-inter text-[12px] text-[#4A4A4A] font-medium">
        {{$label}}

        @if($is_required)
            <span class="text-red-400 text-[12px]">*</span>
        @endif
    </label>

    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" {{ $attributes }} class="border border-[#8F8F8F] rounded text-[12px] py-[8px] px-[8px] font-inter @error($name) border-red-500 @enderror">

    @error($name)
        <span class="absolute top-[100%] right-0 mt-[2px] text-red-500 text-[10px] whitespace-nowrap font-inter">{{ $message }}</span>
    @enderror
</div>
