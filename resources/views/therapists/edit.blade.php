<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="py-4">
                <div class="max-w-3xl mx-auto sm:px-8 lg:px-10">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between p-8 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Edit {{ $therapist->name }}
                            </h3>
                        </div>

                        <form class="p-6" method="POST" action="{{ route('therapists.update', $therapist) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf


                            <div class="grid gap-6 mb-6 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-md font-medium text-gray-900">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ $therapist->name }}"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required
                                    >
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    
                                    <label class="block text-md font-medium" for="image">Upload file</label>
                                    <img src="{{ Storage::url($therapist->image) }}" class="h-32 w-32 my-4 rounded-xl" alt="">
                                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-non " name="image" id="image" type="file">
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <label for="bed_count" class="block mb-2 text-md font-medium text-gray-900">Phone Number</label>
                                    <input
                                        type="number"
                                        name="phone"
                                        id="phone"
                                        value="{{ $therapist->phone }}"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required
                                    >
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            

                            {{-- <div class="col-span-2">
                                <label for="type" class="block mb-2 text-md font-medium text-gray-900">Available</label>
                                <select
                                    id="is_available"
                                    name="is_available"
                                    class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    required
                                >
                                    <option value="" disabled selected }}>Select One</option>
                                    <option value="1" }}>Available</option>
                                    <option value="0" }}>Not Available</option>
                                </select>
                                <x-input-error :messages="$errors->get('is_available')" class="mt-2" />
                            </div> --}}
                            <input type="hidden" name="is_available" value="1">
                        </div>

                            <button type="submit" class="text-white inline-flex items-center bg-[#7d5f12] font-medium rounded-lg text-md px-5 py-2.5 text-center">
                                </svg>
                                Update therapist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
