<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="py-4">
                <div class="max-w-3xl mx-auto sm:px-8 lg:px-10">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between p-8 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Create New Room
                            </h3>
                        </div>

                        <form class="p-6" method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid gap-6 mb-6 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-md font-medium text-gray-900">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required
                                    >
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <label for="type" class="block mb-2 text-md font-medium text-gray-900">Type</label>
                                    <select
                                        id="type"
                                        name="type"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        required
                                    >
                                        <option value="" disabled {{ old('type') ? '' : 'selected' }}>Select Type</option>
                                        <option value="Single" {{ old('type') == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Double" {{ old('type') == 'Double' ? 'selected' : '' }}>Double</option>
                                        <option value="Sharing" {{ old('type') == 'Sharing' ? 'selected' : '' }}>Sharing Room</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <label for="bed_count" class="block mb-2 text-md font-medium text-gray-900">Bed Count</label>
                                    <input
                                        type="number"
                                        name="bed_count"
                                        id="bed_count"
                                        value="{{ old('bed_count') }}"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required
                                    >
                                    <x-input-error :messages="$errors->get('bed_count')" class="mt-2" />
                                </div>
                            </div>

                            <button type="submit" class="text-white inline-flex items-center bg-[#7d5f12] font-medium rounded-lg text-md px-5 py-2.5 text-center">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Add new room
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
