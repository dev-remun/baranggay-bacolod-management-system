
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
    $personal = session('registration.personal_info', []);

    $is_personal_info_finish =
        !empty($personal['first_name']) &&
        !empty($personal['last_name']) &&
        !empty($personal['birth_month']) &&
        !empty($personal['birth_date']) &&
        !empty($personal['birth_year']) &&
        !empty($personal['gender']) &&
        !empty($personal['status']) &&
        !empty($personal['nationality']);

@endphp

<form action="{{ route('register.evalPersonalInfo') }}" method="POST" class="flex flex-col gap-y-[24px] w-full is">
    @csrf
    <!-- Name -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.text_field label="First Name" name="first_name" placeholder="Enter your first name" value="{{ old('first_name', $personal['first_name'] ?? '') }}" is_required=true />
        <x-shared.text_field label="Middle Name" name="middle_name" value="{{ old('middle_name', $personal['middle_name'] ?? '') }}" placeholder="Enter your middle name" />
        <x-shared.text_field label="Last Name" name="last_name" value="{{ old('last_name', $personal['last_name'] ?? '') }}" placeholder="Enter your last name" is_required=true />
    </div>
    <!-- Suffixes Genders, and Status -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.dropdown_field label="Suffix" name="suffix" placeholder="Enter your suffix" selected="{{ old('suffix', $personal['suffix'] ?? '') }}" :options="$suffixes" />
        <x-shared.dropdown_field label="Gender" name="gender" placeholder="Enter your gender" selected="{{ old('gender', $personal['gender'] ?? '') }}" :options="$genders" is_required=true />
        <x-shared.dropdown_field label="Status" name="status" placeholder="Enter your status" selected="{{ old('status', $personal['status'] ?? '') }}" :options="$status" is_required=true />
    </div>
    <!-- Birthdate -->
    <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
        <x-shared.dropdown_field label="Birth Month" name="birth_month" placeholder="Enter your birth month" selected="{{ old('birth_month', $personal['birth_month'] ?? '') }}" :options="$months" is_required=true />
        <x-shared.dropdown_field label="Birth Date" name="birth_date" placeholder="Enter your birth date" selected="{{ old('birth_date', $personal['birth_date'] ?? '') }}" :options="$days" is_required=true />
        <x-shared.dropdown_field label="Birth Year" name="birth_year" placeholder="Enter your birth year" selected="{{ old('birth_year', $personal['birth_year'] ?? '') }}" :options="$years" is_required=true />
    </div>
    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 mt-[20px] font-inter text-[14px]">
        Next
    </button>
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
