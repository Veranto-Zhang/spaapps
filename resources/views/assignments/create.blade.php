<x-app-layout>

    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="py-4">
                <div class="max-w-5xl mx-auto sm:px-8 lg:px-10">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between p-8 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Assign Room 
                            </h3>
                            <a href="{{ route('assignments.index') }}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-full">
                                Back
                             </a>
                        </div>

                        <form class="p-6" method="POST" action="{{ route('assignments.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid gap-6 mb-6 grid-cols-2">
                                <!-- Room info -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Room</label>
                                    <input type="text" name="room_name" value="{{ $room->name }} | {{ $room->type }}" disabled class="bg-gray-100 border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">

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
                                    <input type="date" name="date" value="{{ old('date',now()->toDateString()) }}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                                </div>

                                <!-- Start Time -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Start Time</label>
                                    <input type="time" name="start_time" value="{{ old('start_time',now()->format('H:i') )}}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                                </div>

                                <!-- Transaction No -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Transaction No</label>
                                    <input type="text" name="trx_no" value="{{ old('trx_no')}}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('trx_no')" class="mt-2" />
                                </div>

                                <!-- Contact -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Contact</label>
                                    <input type="text" name="contact" value="{{ old('contact')}}" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                    <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                                </div>

                                <!-- Remark -->
                                <div class="col-span-2">
                                    <label class="block mb-2 text-md font-medium text-gray-900">Remark</label>

                                    <textarea name="remark" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">{{ old('remark') }}</textarea>

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
        const products = @json($products);
        const therapists = @json($therapists);

        function addGuestForm(data = {}, index = guestIndex) {
            const div = document.createElement('div');
            div.classList.add('guest-form', 'border', 'p-4', 'bg-gray-50','rounded-lg', 'mb-4');

            let treatmentOptions = `<option value="">Select Treatment</option>`;
            treatments.forEach(t => {
                const selected = data.treatment_id == t.id ? 'selected' : '';
                treatmentOptions += `<option value="${t.id}" ${selected}>${t.name}</option>`;
            });

            let productOptions1 = `<option value="">Select Product</option>`;
            products.forEach(p => {
                if (p.product_category_id == 1) {
                    const selected = (data.products && data.products[1] == p.id) ? 'selected' : '';
                    productOptions1 += `<option value="${p.id}" ${selected}>${p.name}</option>`;
                }
            });

            let productOptions2 = `<option value="">Select Product</option>`;
            products.forEach(p => {
                if (p.product_category_id == 2) {
                    const selected = (data.products && data.products[2] == p.id) ? 'selected' : '';
                    productOptions2 += `<option value="${p.id}" ${selected}>${p.name}</option>`;
                }
            });

            let productOptions3 = `<option value="">Select Product</option>`;
            products.forEach(p => {
                if (p.product_category_id == 3) {
                    const selected = (data.products && data.products[3] == p.id) ? 'selected' : '';
                    productOptions3 += `<option value="${p.id}" ${selected}>${p.name}</option>`;
                }
            });

            let productOptions4 = `<option value="">Select Product</option>`;
            products.forEach(p => {
                if (p.product_category_id == 4) {
                    const selected = (data.products && data.products[4] == p.id) ? 'selected' : '';
                    productOptions4 += `<option value="${p.id}" ${selected}>${p.name}</option>`;
                }
            });

            let therapistOptions = `<option value="">Select Therapist</option>`;

            therapists
                .filter(t => t.is_available == 1) // only available therapists
                .forEach(t => {
                    const selected = data.therapist_id == t.id ? 'selected' : '';
                    therapistOptions += `<option value="${t.id}" ${selected}>${t.name}</option>`;
                });



            div.innerHTML = `
                <div class="flex flex-row justify-between">
                    <h4 class="text-xl font-medium mb-2">Guest ${index + 1}</h4>
                    ${index > 0 ? `<button type="button" class="px-4 py-1 text-md bg-red-500 text-white rounded remove-guest">Remove</button>` : ''}
                </div>
                <div class="mt-4">
                    <label class="block text-md mb-2">Name</label>
                    <input type="text" name="guests[${index}][name]" value="${data.name ?? ''}" required class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                    ${renderError(`guests.${index}.name`)}
                </div>
                <hr class="mt-6 mb-2">
                <div class="mt-4">
                    <label class="block text-md mb-2">Treatment</label>
                    <select name="guests[${index}][treatment_id]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5" required>
                        ${treatmentOptions}
                    </select>
                    ${renderError(`guests.${index}.treatment_id`)}
                </div>
                <div class="mt-4">
                    <div class="flex gap-8">

                        <div class="w-1/4">
                            <label class="block text-md mb-2">Massage Oil</label>
                            <select name="guests[${index}][products][1]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5" required>
                                ${productOptions1}
                            </select>
                        </div>
                        <div class="w-1/4">
                            <label class="block text-md mb-2">Body Mask</label>
                            <select name="guests[${index}][products][2]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                ${productOptions2}
                            </select>
                        </div>
                        <div class="w-1/4">
                            <label class="block text-md mb-2">Body Scrub</label>
                            <select name="guests[${index}][products][3]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                ${productOptions3}
                            </select>
                        </div>
                        <div class="w-1/4">
                            <label class="block text-md mb-2">Body Butter</label>
                            <select name="guests[${index}][products][4]" class="border border-gray-300 text-gray-900 text-md rounded-lg block w-full p-2.5">
                                ${productOptions4}
                            </select>
                        </div>
                        
                    </div>
                </div>
                <hr class="mt-6 mb-2">
                
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
                    form.querySelectorAll('input, select').forEach((input) => {
                        input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                    });
                    if (field) {
                        input.name = `guests[${index}][${field}]`;
                    }
                });
            });
            guestIndex = guestForms.length;
        }

        

        // Initial load: restore old guests if validation failed
        if (oldGuests.length > 0) {
            oldGuests.forEach((guest, index) => {
                addGuestForm(guest, index);
            });
        } else {
            addGuestForm(); // Add one by default
        }
    </script>
</x-app-layout>
