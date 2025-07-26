<x-app-layout>
    <div class="p-4 sm:ml-64">

        <div class="mx-auto sm:px-4 lg:px-4">

            {{-- Box 1 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Therapist Schedule
                </h2>
                <a href="{{ route('therapists.therapistslist') }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                    Therapists List
                </a>

                
            </div>

            {{-- Box 2 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8">

                <div class="flex flex-row items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">
                    Showing therapist schedule for <span class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
                </h2>

                @php
                    $currentDate = \Carbon\Carbon::parse(request('date', \Carbon\Carbon::today()));
                    $prevDate = $currentDate->copy()->subDay()->format('Y-m-d');
                    $nextDate = $currentDate->copy()->addDay()->format('Y-m-d');
                    $date = $currentDate->format('Y-m-d');
                @endphp

                <form method="GET" action="{{ route('therapists.index') }}" class="inline-block">
                    <div class="flex items-center gap-4 border border-gray-300 rounded-lg px-2 bg-white shadow-sm">
                        <a href="{{ route('therapists.index', ['date' => $prevDate]) }}"
                        class="text-xl font-bold text-gray-600 hover:text-[#7d5f12] hover:bg-gray-100 rounded px-2 py-1 transition duration-150">
                            &lt; 
                        </a>

                        <span class="text-base font-semibold text-gray-800">
                          {{ $currentDate->format('F j, Y') }}
                        </span>

                        <a href="{{ route('therapists.index', ['date' => $nextDate]) }}"
                        class="text-xl font-bold text-gray-600 hover:text-[#7d5f12] hover:bg-gray-100 rounded px-2 py-1 transition duration-150">
                         &gt;
                        </a>
                    </div>
                </form>
                </div>


                <div class="relative overflow-x-auto mt-4 rounded-xl max-h-[800px]">
                    <table class="w-full table-fixed text-sm text-center text-gray-600 border border-gray-200 min-w-full whitespace-nowrap">
                        <thead class="text-white bg-[#7d5f12] sticky top-0 z-20">
                            <tr>
                                <th class="w-20 px-4 py-2 border border-white bg-[#7d5f12] sticky left-0 z-30">Time</th>
                                @foreach ($therapists as $therapist)
                                    <th class="w-32 px-4 py-2 border border-gray-200">
                                        {{ $therapist->name }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $rowHeight = 37; @endphp
                            @foreach ($timeSlots as $slot)
                                <tr>
                                    <td class="px-2 py-2 text-center text-white border sticky left-0 bg-[#7d5f12] z-20">{{ $slot }}</td>
                                    @foreach ($therapists as $therapist)
                                        @php $cells = $assignmentMap[$slot][$therapist->id] ?? []; @endphp
                                        @if (!empty($cells))
                                            <td class="relative border p-1 text-left" style="vertical-align: top;">
                                                @foreach ($cells as $blockIndex => $assignment)
                                                    @php
                                                        $assignmentStart = \Carbon\Carbon::parse($assignment['start_time']);
                                                        $slotCarbon = \Carbon\Carbon::createFromFormat('H:i', $slot)->setDateFrom($assignmentStart);
                                                        $minuteOffset = $slotCarbon->diffInMinutes($assignmentStart);
                                                        $offsetTop = ($minuteOffset / 15) * $rowHeight;
                                                        $blockHeight = ($assignment['rowspan'] ?? 1) * $rowHeight - 4;
                                                        $offsetLeft = $blockIndex * 10;
                                                    @endphp
                                                    <div class="relative h-full">
                                                        <div
                                                            class="absolute bg-yellow-100 rounded p-1 shadow w-[95%] border border-yellow-500 overflow-hidden overlap-box"
                                                            style="top: {{ $offsetTop }}px; height: {{ $blockHeight }}px; left: {{ $offsetLeft }}px; z-index: {{ 10 + $blockIndex }};"
                                                            data-original-z="{{ 10 + $blockIndex }}"
                                                        >
                                                            <a href="{{ route('assignments.show', $assignment['assignment_id']) }}">
                                                                <div class="mb-1 text-sm whitespace-normal break-words">
                                                                    <span class="font-semibold">{{ $assignment['guest']->name }}</span><br>
                                                                    <span class="text-xs">Room: {{ $assignment['room']->name }}</span>
                                                                </div>
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
