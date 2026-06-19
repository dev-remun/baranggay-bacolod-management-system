
@php
    $months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

    $years = range(2026, 1960);

    $days = range(1, 31);

    $suffixes = [ "Jr.", "Sr.", "II", "III", "IV", "V", "VI", "VII", "VIII" ];

    $genders = [ "Male", "Female" ];

    $status = [ "Single", "Married", "Widowed", "Separated" ];

    $nationalities = [ "Filipino", "Afghan", "American", "Argentine", "Australian", "Bangladeshi", "Belgian", "Brazilian", "British", "Cambodian", "Canadian", "Chinese", "Danish", "Dutch", "Egyptian", "Filipino", "Finnish",
                       "French", "German", "Greek", "Hong Konger", "Indian", "Indonesian", "Irish", "Italian", "Japanese", "Korean", "Malaysian", "Mexican", "Myanmar", "Nepalese", "New Zealander", "Norwegian", "Pakistani", "Portuguese", "Russian", "Saudi Arabian", "Singaporean", "South African", "Spanish", "Sri Lankan", "Swedish", "Swiss", "Taiwanese", "Thai", "Turkish", "Ukrainian", "Vietnamese"
];

    $step = session('registration.step', 1 );
    $personal_info = session('registration.personal_info');
    $family_info = session('registration.parents_info');

    $is_personal_info_finish =
        !empty($personal_info['first_name']) &&
        !empty($personal_info['last_name']) &&
        !empty($personal_info['birth_month']) &&
        !empty($personal_info['birth_date']) &&
        !empty($personal_info['birth_year']) &&
        !empty($personal_info['gender']) &&
        !empty($personal_info['status']) &&
        !empty($personal_info['nationality']);

@endphp

<x-shared.form_card header="Registration">

    <div class="w-full flex justify-between items-center md:justify-center gap-x-[4px] my-[20px]">
        <x-shared.progress_chip label="Personal Info" :is_active="false" :is_finish="$is_personal_info_finish" />
        <div class="h-[2px] bg-gray-400 w-[20px] flex-1"> </div>
        <x-shared.progress_chip label="Family Info" />
        <div class="h-[2px] bg-gray-400 w-[20px] flex-1"> </div>
        <x-shared.progress_chip label="Account Info" />
        <div class="h-[2px] bg-gray-400 w-[20px] flex-1"> </div>
        <x-shared.progress_chip label="Review Info" />
    </div>

    @if($step == 1)
        <x-auth.personal_info > </x-auth.personal_info>
    @endif

    @if($step == 2)
        <x-auth.parents_info > </x-auth.parents_info>
    @endif

    @if($step == 3)
        <x-auth.siblings_info > </x-auth.siblings_info>
    @endif

</x-shared.form_card>

