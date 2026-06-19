
@props(['header' => 'form header'])

<div class="bg-[#FAFAFA] shadow-md px-[20px] py-[20px] flex flex-col items-center justify-center shadow-md rounded-md w-full">
    <div class="w-full">
        <p class="font-inter font-bold text-[16px] text-[#4A4A4A]">{{ $header }}</p>
    </div>
    <div class="w-full border-b border-[#8F8F8F]"></div>
    {{ $slot }}
</div>
