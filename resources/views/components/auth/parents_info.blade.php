
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

    $parents_info = session('registration.parents_info', []);

@endphp

<form action="{{ route('register.evalParentsInfo') }}" method="POST" class="flex flex-col gap-y-[24px] w-full is">
    @csrf

    <!-- Father's Name -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.text_field label="Father's First Name" name="father_first_name" placeholder="Enter your father's first name" value="{{ old('father_first_name', $parents_info['father_first_name'] ?? '') }}" is_required=true />
        <x-shared.text_field label="Father's Middle Name" name="father_middle_name" placeholder="Enter your father's middle name" value="{{ old('father_middle_name', $parents_info['father_middle_name'] ?? '') }}" />
        <x-shared.text_field label="Father's Last Name" name="father_last_name" placeholder="Enter your father's last name" value="{{ old('father_last_name', $parents_info['father_last_name'] ?? '') }}" is_required=true />
    </div>
    <!-- Father's Birthdate -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.dropdown_field label="Father's Birth Month" name="father_birth_month" placeholder="Enter your father's birth month" :options="$months" selected="{{ old('father_birth_month', $parents_info['father_birth_month'] ?? '') }}" is_required=true />
        <x-shared.dropdown_field label="Father's Birth Date" name="father_birth_date" placeholder="Enter your father's birth date" :options="$days" selected="{{ old('father_birth_date', $parents_info['father_birth_date'] ?? '') }}" is_required=true />
        <x-shared.dropdown_field label="Father's Birth Year" name="father_birth_year" placeholder="Enter your father's birth year" :options="$years" selected="{{ old('father_birth_year', $parents_info['father_birth_year'] ?? '') }}" is_required=true />
    </div>
    <!-- Father's Additional Info -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.dropdown_field label="Father's Suffix" name="father_suffix" placeholder="Enter your father's suffix" selected="{{ old('father_suffix', $parents_info['father_suffix'] ?? '') }}" :options="$suffixes" />
        <x-shared.dropdown_field label="Father's Nationality" name="father_nationality" placeholder="Enter your father's nationality" selected="{{ old('father_nationality', $parents_info['father_nationality'] ?? '') }}" :options="$nationalities" is_required=true />
        <x-shared.text_field label="Father's Occupation" name="father_occupation" placeholder="Enter your father's occupation" value="{{ old('father_occupation', $parents_info['father_occupation'] ?? '') }}" is_required=true />
    </div>
    <!-- Mother's Name -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.text_field label="Mother's First Name" name="mother_first_name" placeholder="Enter your mother's first name" value="{{ old('mother_first_name', $parents_info['mother_first_name'] ?? '') }}" is_required=true />
        <x-shared.text_field label="Mother's Middle Name" name="mother_middle_name" placeholder="Enter your mother's middle name" value="{{ old('mother_middle_name', $parents_info['mother_middle_name'] ?? '') }}" />
        <x-shared.text_field label="Mother's Last Name" name="mother_last_name" placeholder="Enter your mother's last name" value="{{ old('mother_last_name', $parents_info['mother_last_name'] ?? '') }}" is_required=true />
    </div>
    <!-- Mother's Birthdate -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.dropdown_field label="Mother's Birth Month" name="mother_birth_month" placeholder="Enter your mother's birth month" selected="{{ old('mother_birth_month', $parents_info['mother_birth_month'] ?? '') }}" :options="$months" is_required=true />
        <x-shared.dropdown_field label="Mother's Birth Date" name="mother_birth_date" placeholder="Enter your mother's birth date" selected="{{ old('mother_birth_date', $parents_info['mother_birth_date'] ?? '') }}" :options="$days" is_required=true />
        <x-shared.dropdown_field label="Mother's Birth Year" name="mother_birth_year" placeholder="Enter your mother's birth year" selected="{{ old('mother_birth_year', $parents_info['mother_birth_year'] ?? '') }}" :options="$years" is_required=true />
    </div>
    <!-- Mother's Additional Info -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.dropdown_field label="Mother's Suffix" name="mother_suffix" placeholder="Enter your mother's suffix" :options="$suffixes" selected="{{ old('mother_suffix', $parents_info['mother_suffix'] ?? '') }}" />
        <x-shared.dropdown_field label="Mother's Nationality" name="mother_nationality" placeholder="Enter your mother's nationality" :options="$nationalities" selected="{{ old('mother_nationality', $parents_info['mother_nationality'] ?? '') }}" is_required=true />
        <x-shared.text_field label="Mother's Occupation" name="mother_occupation" placeholder="Enter your mother's occupation" value="{{ old('mother_occupation', $parents_info['mother_occupation'] ?? '') }}" is_required=true />
    </div>
    <div class="flex justify-between mt-[20px]">

    <button
        type="submit"
        formaction="{{ route('register.back') }}"
        formmethod="POST"
        name="step"
        value="1"
        class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 cursor-pointer"
    >
        Back
    </button>

    <button
        type="submit"
        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 cursor-pointer"
    >
        Next : Siblings Information
    </button>

</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Select the dropdown elements based on their name attributes
    const monthSelect = document.querySelector('[name="birth_month"]');
    const daySelect = document.querySelector('[name="birth_date"]');
    const yearSelect = document.querySelector('[name="birth_year"]');

    // Map month names to numbers (1-12) for the Date object
    const monthMap = {
        "January": 1, "February": 2, "March": 3, "April": 4,
        "May": 5, "June": 6, "July": 7, "August": 8,
        "September": 9, "October": 10, "November": 11, "December": 12
    };

    function updateDays() {
        const monthName = monthSelect.value;
        const yearValue = yearSelect.value;

        // Save the currently selected day so we don't clear the user's choice
        const currentSelectedDay = daySelect.value;

        // If no month is selected, do nothing
        if (!monthName || !monthMap[monthName]) return;

        const month = monthMap[monthName];
        // If year isn't selected yet, default to a non-leap year (e.g., 2023) just for standard 28-day Feb calculation
        const year = yearValue ? parseInt(yearValue) : 2023;

        // Get the total number of days in the selected month and year
        const daysInMonth = new Date(year, month, 0).getDate();

        // Clear existing options in the day dropdown
        daySelect.innerHTML = '<option value="" disabled selected></option>';

        // Populate with new correct days
        for (let i = 1; i <= daysInMonth; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;

            // Re-select the previously chosen day if it's still valid (e.g., didn't switch from Jan 31 to Feb)
            if (i == currentSelectedDay) {
                option.selected = true;
            }

            daySelect.appendChild(option);
        }
    }

    // Trigger the update when Month or Year changes
    monthSelect.addEventListener('change', updateDays);
    yearSelect.addEventListener('change', updateDays);
});
</script>
