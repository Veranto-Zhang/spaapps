<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="mx-auto sm:px-4 lg:px-4">
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Spa Rooms Assignment
                </h2>
                @php
                    $currentDate = \Carbon\Carbon::parse(request('date', \Carbon\Carbon::today()));
                    $prevDate = $currentDate->copy()->subDay()->format('Y-m-d');
                    $nextDate = $currentDate->copy()->addDay()->format('Y-m-d');
                @endphp

                <form method="GET" action="{{ route('assignments.index') }}" class="inline-block">
                    <div class="flex items-center gap-4 border border-gray-300 rounded-lg px-2 bg-white shadow-sm">
                        <a href="{{ route('assignments.index', ['date' => $prevDate]) }}"
                        class="text-xl font-bold text-gray-600 hover:text-[#7d5f12] hover:bg-gray-100 rounded px-2 py-1 transition duration-150">
                            &lt; 
                        </a>

                        <span class="text-base font-semibold text-gray-800">
                          {{ $currentDate->format('F j, Y') }}
                        </span>

                        <a href="{{ route('assignments.index', ['date' => $nextDate]) }}"
                        class="text-xl font-bold text-gray-600 hover:text-[#7d5f12] hover:bg-gray-100 rounded px-2 py-1 transition duration-150">
                         &gt;
                        </a>
                    </div>
                </form>
                
                {{-- <form method="GET" action="{{ route('assignments.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <label for="date" class="font-bold text-gray-700">Select Date:</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}"
                        class="border border-gray-300 rounded px-3 py-1"
                    >
                    <button type="submit" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                        Filter
                    </button>
                </form> --}}
            </div>

            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8">
                <div class="flex flex-row justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">
                            Showing assignments for <span class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
                        </h2>
                    </div>
                    <div>
                        <a href="{{ route('assignments.cancelled') }}"
                           class="flex items-center p-2 rounded-lg font-medium text-blue-600 hover:underline">
                            Show Cancelled Assignments
                        </a>
                    </div>
                </div>

                <div class="relative overflow-x-auto mt-4 rounded-xl max-h-[800px]">
                    <table class="w-full table-fixed text-sm text-center text-gray-600 border border-gray-200 min-w-full whitespace-nowrap">
                        <thead class="text-white bg-[#7d5f12] sticky top-0 z-20">
                            <tr>
                                <th class="w-20 px-4 py-2 border border-white bg-[#7d5f12] sticky left-0 z-30">Time</th>
                                @foreach ($rooms as $room)
                                    <th class="w-32 px-4 py-2 border border-gray-200">
                                        {{ $room->name }}
                                        <div>
                                            <a href="{{ route('assignments.create', ['room_id' => $room->id]) }}"
                                               class="text-xs underline text-white">Add</a>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $rendered = []; $rowHeight = 37; @endphp
                            @foreach ($timeSlots as $slot)
                                <tr>
                                    <td class="px-2 py-2 text-center text-white border sticky left-0 bg-[#7d5f12] z-20">{{ $slot }}</td>
                                    @foreach ($rooms as $room)
                                        @php $cells = $assignmentMap[$slot][$room->id] ?? []; @endphp
                                        @if (!empty($cells))
                                            <td class="relative border p-1 text-left" style="vertical-align: top;">
                                                @foreach ($cells as $blockIndex => $assignmentGroup)
                                                    @php
                                                        $assignmentStart = \Carbon\Carbon::parse($assignmentGroup['start_time']);
                                                        $slotCarbon = \Carbon\Carbon::createFromFormat('H:i', $slot)->setDateFrom($assignmentStart);
                                                        $minuteOffset = $slotCarbon->diffInMinutes($assignmentStart);
                                                        $offsetTop = ($minuteOffset / 15) * $rowHeight;
                                                        $blockHeight = ($assignmentGroup['rowspan'] ?? 1) * $rowHeight - 4;
                                                        $offsetLeft = $blockIndex * 10;
                                                    @endphp
                                                    <div class="relative h-full">
                                                        <div
                                                            class="absolute bg-yellow-100 rounded p-1 shadow w-[95%] border border-yellow-500 overflow-hidden overlap-box"
                                                            style="top: {{ $offsetTop }}px; height: {{ $blockHeight }}px; left: {{ $offsetLeft }}px; z-index: {{ 10 + $blockIndex }};"
                                                            data-original-z="{{ 10 + $blockIndex }}"
                                                        >
                                                            <a href="{{ route('assignments.show', $assignmentGroup['assignment_id']) }}">
                                                                @foreach ($assignmentGroup['guests'] as $guest)
                                                                    <div class="mb-1 text-sm whitespace-normal break-words">
                                                                        <span class="font-semibold">{{ $guest->name }}</span> => {{ $guest->therapist->name }}
                                                                    </div>
                                                                @endforeach
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </td>
                                        @else
                                            <td class="border"></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.overlap-box').forEach(box => {
                box.addEventListener('mouseenter', () => {
                    box.style.zIndex = 999;
                });
                box.addEventListener('mouseleave', () => {
                    box.style.zIndex = box.dataset.originalZ;
                });
            });
        </script>
    @endpush
    @stack('scripts')
</x-app-layout>



