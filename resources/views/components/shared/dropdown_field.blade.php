@props([
    "label",
    "name",
    "placeholder" => "Placeholder",
    "options" => [],
    "is_required" => false,
    "selected" => null
])

<div class="relative flex flex-col gap-y-[4px] w-full">
    <label for="{{ $name }}" class="font-inter text-[12px] text-[#4A4A4A] font-medium">
        {{$label}}

        @if($is_required)
            <span class="text-red-400 text-[12px]">*</span>
        @endif
    </label>

    <select name="{{ $name }}" id="{{ $name }}" {{ $attributes }} class="border border-[#8F8F8F] rounded py-[8px] px-[8px] pr-[20px] font-inter text-[12px] @error($name) border-red-400 @enderror" >

        <option value="" {{ old($name) ? '' : 'selected' }} class="text-[10px]"></option>

        @foreach($options as $option)
            <option value="{{ $option }}" {{ old("$name", $selected) == $option ? "selected" : "" }} class="text-[10px]" > {{ $option }} </option>
        @endforeach

    </select>

    @error($name)
        <span class="absolute top-[100%] right-0 mt-[2px] text-red-400 text-[10px] whitespace-nowrap font-inter">{{ $message }}</span>
    @enderror
</div>
