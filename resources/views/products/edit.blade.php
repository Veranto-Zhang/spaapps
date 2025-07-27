<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="py-4">
                <div class="max-w-3xl mx-auto sm:px-8 lg:px-10">
                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between p-8 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Edit {{ $product->name }}
                            </h3>
                        </div>

                        <form class="p-6" method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid gap-6 mb-6 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2 text-md font-medium text-gray-900">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ $product->name }}"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required
                                    >
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <label for="type" class="block mb-2 text-md font-medium text-gray-900">Category</label>
                                    <select
                                        id="product_category_id"
                                        name="product_category_id"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        required
                                    >
                                        <option value="" disabled {{ old('product_category_id') ? '' : 'selected' }}>Select Category</option>

                                        @foreach ($productCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach

                                    </select>
                                    <x-input-error :messages="$errors->get('product_category_id')" class="mt-2" />
                                </div>

                                <div class="col-span-2 hidden">
                                    <label for="stock" class="block mb-2 text-md font-medium text-gray-900">Stock</label>
                                    <input
                                        type="number"
                                        name="stock"
                                        id="stock"
                                        value="{{ $product->stock }}"
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        disabled
                                    >
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>
                            </div>

                            <button type="submit" class="text-white inline-flex items-center bg-[#7d5f12] font-medium rounded-lg text-md px-5 py-2.5 text-center">
                                Update product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
