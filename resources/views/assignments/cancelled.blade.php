<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">

            {{-- Box 1 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Cancelled Assignment
                </h2>
                <a href="{{ route('assignments.index') }}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-full">
                   Back
                </a>
            </div>

            {{-- Box 2 --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg p-6 flex flex-col gap-y-4">
                <div class="overflow-hidden rounded-xl">
                    <table class="w-full text-md text-left text-gray-500 rounded-xl overflow-hidden">
                        <thead class="text-md text-white uppercase bg-[#7d5f12]">
                            <tr>
                                <th class="pl-6 pr-2 py-4 rounded-tl-xl">No</th>
                                <th class="px-6 py-4">Transaction No</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Room</th>
                                <th class="px-6 py-4">Cancelled On</th>
                                <th class="px-6 py-4 rounded-tr-xl">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 font-medium">
                                    <td class="pl-6 pr-2 py-4">
                                        {{ $assignments->firstItem() + $loop->index }}.
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $assignment->trx_no }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($assignment->date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $assignment->room->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $assignment->deleted_at ? $assignment->deleted_at->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('assignments.show', $assignment) }}" class="font-medium text-blue-600 hover:underline">
                                            Details
                                        <a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400">No cancelled assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $assignments->links('vendor.pagination.custom') }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
