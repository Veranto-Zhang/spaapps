<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">

            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">

                <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Assignment Detail
                </h2>
                    @if (session('error'))
                        <div class="pt-2 text-red-700">
                                {{ session('error') }}
                         </div>
                    @endif
                </div>
                <a href="{{ url()->previous() }}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-full">
                   Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg py-6 p-8 flex flex-col gap-y-6">

                <div class="flex flex-col md:flex-row justify-between">
                    <div class="flex flex-col gap-y-1">
                        <h3 class="text-slate-600 text-sm">Transaction No</h3>
                        <p class="text-indigo-950 text-lg font-bold">{{ $assignment->trx_no }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-y-1">
                        <h3 class="text-slate-600 text-sm">Date</h3>
                        <p class="text-indigo-950 text-lg font-bold">{{ \Carbon\Carbon::parse($assignment->date)->format('Y-m-d') }}</p>
                    </div>
                    
                    <div class="flex flex-col gap-y-1">
                        <h3 class="text-slate-600 text-sm">Start Time - Finish Time</h3>
                        <p class="text-indigo-950 text-lg font-bold">{{ \Carbon\Carbon::parse($assignment->start_time)->format('H:i') }} - {{ $finishTime }}</p>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <h3 class="text-slate-600 text-sm">Room</h3>
                        <p class="text-indigo-950 text-lg font-bold">{{ $assignment->room->name }}</p>
                    </div>
                </div>

                @if ($assignment->remark)
                <hr>
                
                <div class="flex flex-col md:flex-row justify-start">
                    <div class="flex flex-col gap-y-1">
                        <h3 class="text-slate-600 text-sm">Remark</h3>
                        <p class="text-indigo-950 text-lg font-bold">{{ $assignment->remark }}</p>
                    </div>
                </div>
                @endif

                <div class="border-t border-gray-200 pt-4 pb-4">

                    <table class="w-full text-md text-left text-gray-900 overflow-hidden">
                        <thead class="text-md uppercase">
                            <tr class="border-b">
                                <th scope="col" class="pr-2 py-4">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Guest
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Treatment
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    Spa Products
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignment->guests as $index => $guest)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="pr-2 py-4 pl-2">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-lg text-gray-900">{{ $guest->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $guest->duration_in_min }} mins {{ $guest->treatment->name}} - {{ $guest->therapist->name}}
                                </td>
                                <td class="px-6 py-4">
                                    @foreach ($guest->products as $product)
                                        {{ $product->name }} {{ !$loop->last ? ' | ' : '' }}
                                    @endforeach
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-400">No guests assigned.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="flex flex-row justify-between">
                    
                    
                    @if (!$assignment->trashed())
                    <div class="flex flex-row">
                        <a href="{{ route('assignments.edit', $assignment) }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">Edit</a>
                    </div>
                    <div class="flex flex-row">
                        <button onclick="confirmDelete({{ $assignment->id }})"
                            data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                            class="text-white bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-md px-4 py-2.5">
                            Cancel Assignment
                        </button>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div id="popup-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow ">
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                data-modal-hide="popup-modal">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 " fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 ">Are you sure you want to delete this assignment?</h3>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="popup-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700">
                        No, cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = "{{ url('/assignments') }}/" + id;
    }
</script>

</x-app-layout>
