<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">

            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <div class="flex flex-row justify-between items-center gap-x-4">
                    <img src="{{ Storage::url($therapist->image) }}" class="rounded-lg w-20 h-20" alt="">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $therapist->name }}
                    </h2>
                </div>
                <a href="{{ route('therapists.index') }}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-lg">
                   Back
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg py-6 p-8 flex flex-col gap-y-6">

                <div class="flex flex-row justify-between items-center">
                    <h3 class="text-xl text-indigo-950 font-bold">Guest List</h3>
                    <form method="GET" action="{{ route('therapists.show', $therapist->id) }}" class="flex flex-col sm:flex-row sm:items-center gap-2">
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
                        <a href="{{ route('therapists.show', $therapist->id) }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                            Show All
                        </a>
                    </form>
                </div>
                <hr>

                        @forelse ($guests as $index => $guest)

                        <div class="flex flex-row justify-between items-center gap-x-3">
                            <div class="flex flex-row items-center gap-x-4">
                                <div class="text-indigo-950 text-xl font-bold w-6">{{ $index + 1 }}.</div>
                                <div class="flex flex-col">
                                    <h4 class="text-indigo-950 text-xl font-bold">{{ $guest->name }}</h4>
                                    <p class="text-slate-500 text-md">
                                        {{ \Carbon\Carbon::parse($guest->assignment->date)->format('Y-m-d') }}
                                        at
                                        {{ \Carbon\Carbon::parse($guest->assignment->start_time)->format('H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col ">
                                <h4 class="text-indigo-950 text-xl font-bold">{{ $guest->treatment->name ?? '-' }}</h4>
                                <p class="text-slate-500 text-md">Duration: {{ $guest->duration_in_min }} mins</p>
                            </div>
                            
                            <div class="flex flex-col mr-8">
                            </div>

                        </div> 
                    @empty
                        <p>No guests found for this date.</p>
                    @endforelse
                    <div class="mt-4">
                        {{ $guests->appends(['date' => request('date')])->links() }}
                    </div>

            </div>
        </div>
    </div>
</x-app-layout>
