<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            <div class="py-4">
                <div class="max-w-3xl mx-auto sm:px-8 lg:px-10">

                    <div class="relative bg-white rounded-lg shadow-sm">
                        <div class="flex items-center justify-between p-8 md:p-5 border-b rounded-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900">
                                Edit {{ $product->name }} Stock
                            </h3>
                        </div>

                        <form class="p-6" method="POST" action="{{ route('products.updateStock', $product) }}" enctype="multipart/form-data">
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
                                        required disabled 
                                    >
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="col-span-1">
                                    <label for="old_stock" class="block mb-2 text-md font-medium text-gray-900">Old Stock</label>
                                    <input
                                        type="number"
                                        value="{{ $product->stock }}"
                                        class=" border border-gray-300 text-gray-500 bg-gray-200 cursor-not-allowed text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        disabled
                                    >
                                </div>
                                <div class="col-span-1">
                                    <label for="stock" class="block mb-2 text-md font-medium text-gray-900">New Stock</label>
                                    <input
                                        type="number"
                                        name="stock"
                                        id="stock"
                                        value=""
                                        class="border border-gray-300 text-gray-900 text-md rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required
                                    >
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>
                            </div>

                            <button type="submit" class="text-white inline-flex items-center bg-[#7d5f12] font-medium rounded-lg text-md px-5 py-2.5 text-center">
                                Update Stock
                            </button>
                        </form>
                    </div>
            </div>

            <div class="relative bg-white rounded-lg shadow-sm mt-10">
                <div class="flex items-center justify-between p-8 md:p-5 rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">
                        Stock Logs
                    </h3>
                </div>
                <div class="px-4">    

                    <table class="w-full text-md text-left text-gray-500 rounded-xl overflow-hidden">
                        <thead class="text-md text-white uppercase bg-[#7d5f12]">
                            <tr>
                                <th scope="col" class="pl-6 pr-2 py-4 rounded-tl-xl">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Old Stock
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    New Stock
                                </th>
                                <th scope="col" class="px-6 py-4 rounded-tr-xl">
                                    Changed By
                                </th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            @forelse($stockLogs as $log)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 font-medium">
                                <td class="pl-6 pr-2 py-4">
                                    {{ $loop->iteration }}.
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-lg text-gray-900">{{ $log->created_at->format('j F Y - H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $log->old_stock }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $log->new_stock }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $log->user->name ?? 'Unknown' }}
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">Belum ada Stock Log yang diinput</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="py-8">
                        {{ $stockLogs->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
