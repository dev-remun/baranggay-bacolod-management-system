
@props([
    'active_part' => '',
    'finish_part' => '',
    'incomplete_part' => '',
])

@php

    #chip bar
    $is_personal_info_active = false;
    $is_family_info_active = false;
    $is_account_info_active = false;
    $is_review_info_active = false;

    $is_personal_info_finish = false;
    $is_family_info_finish = false;
    $is_account_info_finish = false;
    $is_review_info_finish = false;

    if($active_part === "personal info") {
        $is_personal_info_active = true;
    }

    else if($active_part === "family info") {
        $is_family_info_active = true;
    }

    else if($active_part === "account info") {
        $is_account_info_active = true;
    }

    else {
        $is_review_info_active = true;
    }

    if($finish_part === "personal info") {
        $is_personal_info_finish = true;
    }

    else if($finish_part === "family info") {
        $is_family_info_finish = true;
    }

    else if($finish_part === "account info") {
        $is_account_info_finish = true;
    }

    else if(($finish_part === "review info")) {
        $is_review_info_finish = true;
    }


@endphp

<div x-data="{ active_part: 'personal info' }" class="w-full flex justify-between items-center md:justify-center gap-x-[4px] my-[20px]">
    <x-shared.progress_chip label="Test" :is_active="$is_personal_info_active" :is_finish="$is_personal_info_finish" />
    <div class="h-[2px] bg-gray-400 w-[20px] flex-1"> </div>
    <x-shared.progress_chip label="Testasdadasdas" :is_active="$is_family_info_active" :is_finish="$is_family_info_finish" />
    <div class="h-[2px] bg-gray-400 w-[20px] flex-1"> </div>
    <x-shared.progress_chip label="Test" :is_active="$is_account_info_active" :is_finish="$is_account_info_finish" />
    <div class="h-[2px] bg-gray-400 w-[20px] flex-1"> </div>
    <x-shared.progress_chip label="Test" :is_active="$is_review_info_active" :is_finish="$is_review_info_finish" />
</div>
