<x-app-layout>
    <div class="p-4 sm:ml-64">

        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4 ">

            {{-- Box 1 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Manage Guest
                </h2>
            
                <form method="GET" action="{{ route('guests.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <input type="date" id="date" name="date"
                        value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}"
                        class="border border-gray-300 rounded px-3 py-1"
                    >
                    <button type="submit" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Box 2 --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg p-6 flex flex-col gap-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">
                        Showing guests for <span class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
                    </h2>

                <div class="overflow-hidden rounded-xl">
                    <table class="w-full text-md text-left text-gray-500 rounded-xl overflow-hidden">
                        <thead class="text-md text-white uppercase bg-[#7d5f12]">
                            <tr>
                                <th scope="col" class="pl-6 pr-2 py-4 rounded-tl-xl">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Treatment
                                </th>
                                <th scope="col" class="px-6 py-4 rounded-tr-xl">
                                    Therapist
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guests as $guest)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 font-medium">
                                <td class="pl-6 pr-2 py-4">
                                    {{ $guests->firstItem() + $loop->index }}.
                                </td>
                                <th class="px-6 py-4">
                                    <div class="uppercase text-lg text-gray-900">{{ $guest->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $guest->duration_in_min }} Mins of {{ $guest->treatment->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $guest->therapist->name }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">Belum ada Tamu</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $guests->appends(['date' => request('date')])->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>

            
            
        </div>
    </div>
</x-app-layout>