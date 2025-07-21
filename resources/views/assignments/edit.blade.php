<x-app-layout>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="py-4">
                <div class="max-w-3xl mx-auto sm:px-8 lg:px-10">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between p-8 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Edit Assigned Room 
                            </h3>
                            <a href="{{ url()->previous() }}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-full">
                                Back
                             </a>
                        </div>

                        <form class="p-6" method="POST" action="{{ route('assignments.update', $assignment) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid gap-6 mb-6 grid-cols-2">
                                <!-- Room info -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Room</label>
                                    <input type="text" name="room_name" value="{{ $room->name }} | {{ $room->type }}" disabled class="bg-gray-200 border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                </div>

                                {{-- @if ($errors->has('guests'))
                                    <div class="col-span-full text-red-600 text-sm">
                                        {{ $errors->first('guests') }}
                                    </div>
                                @endif --}}

                                @if ($errors->any())
                                    <div class="col-span-2 mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach
                                    </div>
                                @endif

                                <!-- Date -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Date</label>
                                    <input type="date" name="date" value="{{ $assignment->date->toDateString() }}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <!-- Start Time -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Start Time</label>
                                    <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($assignment->start_time)->format('H:i') }}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                                </div>

                                <!-- Transaction No -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Transaction No</label>
                                    <input type="text" name="trx_no" value="{{ $assignment->trx_no }}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('trx_no')" class="mt-2" />
                                </div>

                                <!-- Remark -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Remark</label>

                                    <textarea name="remark" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">{{ $assignment->remark }}</textarea>

                                    <x-input-error :messages="$errors->get('remark')" class="mt-2" />
                                </div>


                            </div>

                            <!-- Guests Container -->
                            <div id="guests-wrapper" class="mt-10">
                                
                            </div>

                            <!-- Add Guest + Submit -->
                            <div class="flex flex-row justify-between items-center mb-4">
                                <button type="button" id="add-guest" class="text-white inline-flex items-center bg-[#7d5f12] font-medium rounded-lg text-md px-5 py-2.5">+ Add Guest</button>
                                <button type="submit" class="text-white inline-flex items-center bg-[#7d5f12] font-medium rounded-lg text-md px-5 py-2.5">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const oldGuests = @json(old('guests', []));
        const validationErrors = @json($errors->toArray());
    </script>
    
<!-- Dynamic Guest Script -->
    <script>
        let guestIndex = 0;
        const wrapper = document.getElementById('guests-wrapper');
        const addGuestBtn = document.getElementById('add-guest');

        const treatments = @json($treatments);
        const therapists = @json($therapists);

        function addGuestForm(data = {}, index = guestIndex) {
            const div = document.createElement('div');
            div.classList.add('guest-form', 'border', 'p-4', 'rounded-lg', 'mb-4');

            let treatmentOptions = `<option value="">Select Treatment</option>`;
            treatments.forEach(t => {
                const selected = data.treatment_id == t.id ? 'selected' : '';
                treatmentOptions += `<option value="${t.id}" ${selected}>${t.name}</option>`;
            });

            // let therapistOptions = `<option value="">Select Therapist</option>`;
            // therapists.forEach(t => {
            //     const selected = data.therapist_id == t.id ? 'selected' : '';
            //     therapistOptions += `<option value="${t.id}" ${selected}>${t.name}</option>`;
            // });

            let therapistOptions = `<option value="">Select Therapist</option>`;

            therapists
                .filter(t => t.is_available == 1) // only available therapists
                .forEach(t => {
                    const selected = data.therapist_id == t.id ? 'selected' : '';
                    therapistOptions += `<option value="${t.id}" ${selected}>${t.name}</option>`;
                });

            div.innerHTML = `
                <div class="flex flex-row justify-between">
                    <h4 class="text-md font-medium mb-4">Guest ${index + 1}</h4>
                    ${index > 0 ? `<button type="button" class="px-4 py-1 text-md bg-red-500 text-white rounded remove-guest">Remove</button>` : ''}
                </div>
                <div class="mt-4">
                    <label class="block text-md mb-2">Name</label>
                    <input type="text" name="guests[${index}][name]" value="${data.name ?? ''}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                    ${renderError(`guests.${index}.name`)}
                </div>
                <div class="mt-4">
                    <label class="block text-md mb-2">Treatment</label>
                    <select name="guests[${index}][treatment_id]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5" required>
                        ${treatmentOptions}
                    </select>
                    ${renderError(`guests.${index}.treatment_id`)}
                </div>
                <div class="mt-4">
                    <label class="block text-md mb-2">Therapist</label>
                    <select name="guests[${index}][therapist_id]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5" required>
                        ${therapistOptions}
                    </select>
                    ${renderError(`guests.${index}.therapist_id`)}
                </div>
                <div class="mt-4">
                    <label class="block text-md mb-2">Duration (minutes)</label>
                    <input type="number" name="guests[${index}][duration_in_min]" value="${data.duration_in_min ?? ''}" min="1" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                    ${renderError(`guests.${index}.duration_in_min`)}
                </div>
            `;

            wrapper.appendChild(div);
            guestIndex++;
        }

        function renderError(fieldKey) {
            if (validationErrors[fieldKey]) {
                return `<p class="text-red-500 text-sm mt-2">${validationErrors[fieldKey][0]}</p>`;
            }
            return '';
        }

        addGuestBtn.addEventListener('click', function () {
            addGuestForm();
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-guest')) {
                e.target.closest('.guest-form').remove();
                reindexGuests();
            }
        });

        function reindexGuests() {
            const guestForms = wrapper.querySelectorAll('.guest-form');
            guestForms.forEach((form, index) => {
                form.querySelector('h4').textContent = `Guest ${index + 1}`;
                form.querySelectorAll('input, select').forEach((input) => {
                    const field = input.name.match(/\[\d+\]\[([a-z_]+)\]/)?.[1];
                    if (field) {
                        input.name = `guests[${index}][${field}]`;
                    }
                });
            });
            guestIndex = guestForms.length;
        }

        // Initial load: from old() if validation failed, otherwise from assignment data
        const existingGuests = @json($assignment->guests);

        if (oldGuests.length > 0) {
            oldGuests.forEach((guest, index) => {
                addGuestForm(guest, index);
            });
        } else if (existingGuests.length > 0) {
            existingGuests.forEach((guest, index) => {
                addGuestForm({
                    name: guest.name,
                    treatment_id: guest.treatment_id,
                    therapist_id: guest.therapist_id,
                    duration_in_min: guest.duration_in_min,
                }, index);
            });
        } else {
            addGuestForm(); // fallback
        }
    </script>
</x-app-layout>
