<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="mx-auto sm:px-4 lg:px-4">
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Reports
                </h2>
                
                <form method="GET" action="{{ route('reports.assignments') }}" class="flex flex-col sm:flex-row sm:items-center gap-2">

                    <label>Start Date:</label>
                    <input type="date" name="start_date" value="{{ request('start_date' )}}" class="border border-gray-300 rounded px-3 py-1">
                    <label>End Date:</label>
                    <input type="date" name="end_date" value="{{ request('end_date' )}}" class="border border-gray-300 rounded px-3 py-1">
    
                    <button type="submit" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                        Filter
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 ">

                <div class="mt-4 flex flex-row justify-between gap-x-8 items-center pr-4">
                
                <p class="font-bold text-xl">
                    Total Guests: {{ $assignments->sum(fn($assignment) => $assignment->guests->count()) }}
                </p>
                <a href="{{ route('reports.assignments.export', request()->only('start_date','end_date')) }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                    Export to Excel
                </a>
                
                </div>

                <div class="relative overflow-x-auto mt-8 rounded-xl max-h-[800px]">
                    
                    <table class="w-full table-auto text-md text-center text-gray-600 border border-gray-800 min-w-full">
                        <thead class="text-white bg-[#7d5f12] sticky top-0 z-20">
                            <tr>
                                <th class="px-4 py-3 border bg-[#7d5f12]">No</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Date</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Room Name</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Guest</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Treatment</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Therapist</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Contact</th>
                                <th class="px-4 py-3 border bg-[#7d5f12]">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $index => $assignment)
                                @php $guestCount = $assignment->guests->count(); @endphp
                                @foreach($assignment->guests as $gIndex => $guest)
                                    <tr>
                                        @if($gIndex == 0)
                                            <td rowspan="{{ $guestCount }}" class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                                            <td rowspan="{{ $guestCount }}" class="border border-gray-300 px-4 py-2 text-center">
                                                {{ \Carbon\Carbon::parse($assignment->date)->format('d F Y') }}
                                            </td>
                                            <td rowspan="{{ $guestCount }}" class="border border-gray-300 px-4 py-2">{{ $assignment->room->name }}</td>
                                        @endif
                        
                                        <td class="border border-gray-300 px-4 py-2">{{ $guest->name }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $guest->duration_in_min }} mins of {{ $guest->treatment->name ?? '-' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $guest->therapist->name ?? '-' }}</td>
                        
                                        @if($gIndex == 0)
                                            <td rowspan="{{ $guestCount }}" class="border border-gray-300 px-4 py-2">{{ $assignment->contact }}</td>
                                            <td rowspan="{{ $guestCount }}" class="border border-gray-300 px-4 py-2">{{ $assignment->remark }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        
                        
                    </table>
                </div>

            </div>


</x-app-layout>