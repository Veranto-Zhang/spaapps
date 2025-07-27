<x-app-layout>
    <div class="p-4 sm:ml-64">

        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4 ">

            {{-- Box 1 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Categories
                </h2>
                <a href="{{ route('categories.create') }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                    Add New
                </a>
            </div>

            {{-- Box 2 --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg p-6 flex flex-col gap-y-4">

                <div class="overflow-hidden rounded-xl"> <!-- NEW wrapper for rounded corners -->
                    <table class="w-full text-md text-left text-gray-500 rounded-xl overflow-hidden">
                        <thead class="text-md text-white uppercase bg-[#7d5f12]">
                            <tr>
                                <th scope="col" class="pl-6 pr-2 py-4 rounded-tl-xl">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-4 rounded-tr-xl text-right">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 font-medium">
                                <td class="pl-6 pr-2 py-4">
                                    {{ $categories->firstItem() + $loop->index }}.
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-lg text-gray-900">{{ $category->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-row gap-x-3 justify-end">
                                        <a href="{{ route('categories.edit', $category) }}" class="font-medium text-blue-600 hover:underline">Edit</a> | 
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-blue-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">Belum ada Kategori yang diinput</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links('vendor.pagination.custom') }}
                </div>

            </div>

        </div>
    </div>
</x-app-layout>


</div>