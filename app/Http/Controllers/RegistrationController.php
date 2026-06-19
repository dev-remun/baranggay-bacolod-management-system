<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register', [
            'step' => session('registration.step', 1),
            'personalInfo' => session('registration.personal_info', []),
            'parentsInfo' => session('registration.parents_info', []),
            'siblingsInfo' => session('registration.siblings_info', []),
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming data first
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_month' => 'required|string',
            'birth_date' => 'required|string',
            'birth_year' => 'required|string',
            'gender' => 'required',
            'status' => 'required|string'
        ]);

        $validated['middle_name'] = !empty($request->middle_name) ? $request->middle_name : "N/A";

        // Access the validated data
        $firstName = $validated['first_name'];

        // Save to database or perform logic here...
        dd($validated);

        return back()->with('success', 'Registration successful!');
    }

    public function goBackRegistrationForms() {
        $step = session('registration.step', 1);

        if($step > 1) {
            session([
                'registration.step' => $step - 1
            ]);
        }

        return redirect()->route('register.create');
    }

    public function evaluatePersonalInfo(Request $request) {

        // Validate the incoming data first
        $validated = $request->validate([
            'first_name' => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'middle_name' => ['nullable', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'last_name' => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'birth_month' => 'required|string',
            'birth_date' => 'required|string',
            'birth_year' => 'required|string',
            'gender' => 'required',
            'status' => 'required|string'
        ]);

        $validated['middle_name'] = $validated['middle_name'] ?? 'N/A';
        $validated['suffix'] = !empty($request->suffix) ? $request->suffix : "N/A";

        session([
            'registration.personal_info' => $validated,
            'registration.step' => 2
        ]);

        return redirect()->route('register.create');

    }

    public function evaluateParentsInfo(Request $request) {

        // Validate the incoming data first
        $validated = $request->validate([
            'father_first_name' => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'father_middle_name' => ['nullable', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'father_last_name' => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'father_birth_month' => 'required|string',
            'father_birth_date' => 'required|string',
            'father_birth_year' => 'required|string',
            'father_nationality' => 'required',
            'father_occupation' => 'required',

            'mother_first_name' => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'mother_middle_name' => ['nullable', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'mother_last_name' => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],
            'mother_birth_month' => 'required|string',
            'mother_birth_date' => 'required|string',
            'mother_birth_year' => 'required|string',
            'mother_nationality' => 'required',
            'mother_occupation' => 'required'
        ]);

        $validated['father_middle_name'] = $validated['father_middle_name'] ?? 'N/A';
        $validated['father_suffix'] = $request->father_suffix ?? 'N/A';
        $validated['mother_middle_name'] = $validated['mother_middle_name'] ?? 'N/A';
        $validated['mother_suffix'] = $request->mother_suffix ?? 'N/A';

        session([
            'registration.parents_info' => $validated,
            'registration.step' => 3
        ]);

        return redirect()->route('register.create');
    }

    public function evaluateSiblingsInfo(Request $request)
    {
        // 1. Validate the incoming arrays using the .* syntax
        $validated = $request->validate([
            'sibling_first_name'      => 'nullable|array',
            'sibling_first_name.*'    => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],

            'sibling_middle_name'     => 'nullable|array',
            'sibling_middle_name.*'   => ['nullable', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],

            'sibling_last_name'       => 'nullable|array',
            'sibling_last_name.*'     => ['required', 'regex:/^[\p{L}\s]+$/u', 'string', 'max:255'],

            'sibling_gender'          => 'nullable|array',
            'sibling_gender.*'        => 'required|string',

            'sibling_birth_month'     => 'nullable|array',
            'sibling_birth_month.*'   => 'required|string',

            'sibling_birth_date'      => 'nullable|array',
            'sibling_birth_date.*'    => 'required|string',

            'sibling_birth_year'      => 'nullable|array',
            'sibling_birth_year.*'    => 'required|string',

            'sibling_suffix'          => 'nullable|array',
            'sibling_suffix.*'        => 'nullable|string',

            'sibling_nationality'     => 'nullable|array',
            'sibling_nationality.*'   => 'required|string',
        ]);

        $formattedSiblings = [];

        // 2. Check if any siblings were actually submitted
        if (!empty($validated['sibling_first_name'])) {

            // Loop through the first name array to group each sibling's data together
            foreach ($validated['sibling_first_name'] as $index => $firstName) {
                $formattedSiblings[] = [
                    'first_name'  => $firstName,
                    'middle_name' => $validated['sibling_middle_name'][$index] ?? 'N/A',
                    'last_name'   => $validated['sibling_last_name'][$index],
                    'gender'      => $validated['sibling_gender'][$index],
                    'birth_month' => $validated['sibling_birth_month'][$index],
                    'birth_date'  => $validated['sibling_birth_date'][$index],
                    'birth_year'  => $validated['sibling_birth_year'][$index],
                    'suffix'      => !empty($validated['sibling_suffix'][$index]) ? $validated['sibling_suffix'][$index] : 'N/A',
                    'nationality' => $validated['sibling_nationality'][$index],
                ];
            }
        }

        // 3. Store the properly formatted array into the session
        session([
            'registration.siblings_info' => $formattedSiblings,
            'registration.step' => 1 // Assuming this moves them to step 4
        ]);

        dd([
            session('registration.personal_info'),
            session('registration.parents_info'),
            session('registration.siblings_info'),
        ]);

        return redirect()->route('register.create');
    }
}
