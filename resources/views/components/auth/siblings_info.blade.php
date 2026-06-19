@php
    $months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    $years = range(2026, 1960);
    $days = range(1, 31);
    $suffixes = [ "Jr.", "Sr.", "II", "III", "IV", "V", "VI", "VII", "VIII" ];
    $genders = [ "Male", "Female" ];
    $nationalities = [ "Filipino", "Afghan", "American", "Argentine", "Australian", "Bangladeshi", "Belgian", "Brazilian", "British", "Cambodian", "Canadian", "Chinese", "Danish", "Dutch", "Egyptian", "Filipino", "Finnish",
                       "French", "German", "Greek", "Hong Konger", "Indian", "Indonesian", "Irish", "Italian", "Japanese", "Korean", "Malaysian", "Mexican", "Myanmar", "Nepalese", "New Zealander", "Norwegian", "Pakistani", "Portuguese", "Russian", "Saudi Arabian", "Singaporean", "South African", "Spanish", "Sri Lankan", "Swedish", "Swiss", "Taiwanese", "Thai", "Turkish", "Ukrainian", "Vietnamese" ];
@endphp

<form action="{{ route('register.evalSiblingsInfo') }}" method="POST" class="flex flex-col gap-y-[24px] w-full">
    @csrf

    <div class="flex flex-col gap-y-[8px]">
        <h2 class="text-xl font-bold text-gray-800 font-inter">Siblings Information</h2>
        <p class="text-sm text-gray-500 font-inter">Add details for your siblings below. If you do not have any siblings, you can click Next to skip.</p>
    </div>

    <div id="siblings-container" class="flex flex-col gap-y-6 w-full"></div>

    <button type="button" id="add-sibling-btn" class="cursor-pointer font-inter bg-gray-200 text-gray-700 py-2 px-4 rounded hover:bg-gray-300 font-inter text-[14px] w-max font-medium transition-colors border border-gray-300">
        + Add Sibling
    </button>

    <template id="sibling-template">
        <div class="sibling-entry border border-gray-300 p-6 rounded relative flex flex-col gap-y-[28px] w-full bg-white shadow-sm">

            <button type="button" class="cursor-pointer remove-sibling-btn absolute top-4 right-4 text-red-500 hover:text-red-700 text-sm font-bold font-inter">
                Remove
            </button>

            <h3 class="text-md font-semibold text-gray-700 border-b pb-2 font-inter">Sibling Details</h3>

            <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full mt-2">
                <x-shared.text_field label="First Name" name="sibling_first_name[]" placeholder="First name" is_required=true />
                <x-shared.text_field label="Middle Name" name="sibling_middle_name[]" placeholder="Middle name" />
                <x-shared.text_field label="Last Name" name="sibling_last_name[]" placeholder="Last name" is_required=true />
            </div>

            <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
                <x-shared.dropdown_field label="Suffix" name="sibling_suffix[]" placeholder="Select suffix" :options="$suffixes" />
                <x-shared.dropdown_field label="Gender" name="sibling_gender[]" placeholder="Select gender" :options="$genders" is_required=true />
                <x-shared.dropdown_field label="Nationality" name="sibling_nationality[]" placeholder="Select nationality" :options="$nationalities" is_required=true />
            </div>

            <div class="flex flex-col gap-y-[28px] md:flex-row md:gap-x-[24px] w-full">
                <x-shared.dropdown_field label="Birth Month" name="sibling_birth_month[]" placeholder="Select month" :options="$months" is_required=true />
                <x-shared.dropdown_field label="Birth Date" name="sibling_birth_date[]" placeholder="Select date" :options="$days" is_required=true />
                <x-shared.dropdown_field label="Birth Year" name="sibling_birth_year[]" placeholder="Select year" :options="$years" is_required=true />
            </div>
        </div>
    </template>

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
        Next
    </button>

</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. SIBLING DOM ELEMENTS ---
    const siblingsContainer = document.getElementById('siblings-container');
    const addSiblingBtn = document.getElementById('add-sibling-btn');
    const siblingTemplate = document.getElementById('sibling-template');

    // --- 2. ADD SIBLING LOGIC ---
    addSiblingBtn.addEventListener('click', function() {
        const clone = siblingTemplate.content.cloneNode(true);
        siblingsContainer.appendChild(clone);
    });

    // --- 3. REMOVE SIBLING LOGIC (Event Delegation) ---
    siblingsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-sibling-btn')) {
            e.target.closest('.sibling-entry').remove();
        }
    });

    // --- 4. DYNAMIC DATE LOGIC ---
    const monthMap = {
        "January": 1, "February": 2, "March": 3, "April": 4,
        "May": 5, "June": 6, "July": 7, "August": 8,
        "September": 9, "October": 10, "November": 11, "December": 12
    };

    // Listen for changes inside the dynamically added siblings
    siblingsContainer.addEventListener('change', function(e) {
        const name = e.target.name;

        // Check if the user changed a month or year dropdown
        if (name === 'sibling_birth_month[]' || name === 'sibling_birth_year[]') {

            // Find the specific sibling wrapper
            const wrapper = e.target.closest('.sibling-entry');

            const monthSelect = wrapper.querySelector('[name="sibling_birth_month[]"]');
            const daySelect   = wrapper.querySelector('[name="sibling_birth_date[]"]');
            const yearSelect  = wrapper.querySelector('[name="sibling_birth_year[]"]');

            if (!monthSelect || !daySelect || !yearSelect) return;

            const monthName = monthSelect.value;
            const yearValue = yearSelect.value;
            const currentSelectedDay = daySelect.value;

            if (!monthName || !monthMap[monthName]) return;

            const month = monthMap[monthName];
            const year = yearValue ? parseInt(yearValue) : 2024; // Default to leap year

            const daysInMonth = new Date(year, month, 0).getDate();

            // Reset options
            daySelect.innerHTML = '<option value="" disabled selected>Select Date</option>';

            // Repopulate accurate days
            for (let i = 1; i <= daysInMonth; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;

                if (i == currentSelectedDay) {
                    option.selected = true;
                }

                daySelect.appendChild(option);
            }
        }
    });
});
</script>
