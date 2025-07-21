<x-app-layout>
    <div class="p-4 sm:ml-64">

        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4 ">

            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Manage Treatments
                </h2>
                <a href="{{ route('treatments.create') }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                    Add New
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg py-6 p-8 flex flex-col gap-y-4">

                @forelse($treatments as $treatment)
                <div class="item-card flex flex-row justify-between items-center gap-x-8">

                    <div class="flex flex-col items-start gap-y-3">

                    <div class="flex flex-row items-center gap-x-3">
                        <div class="text-indigo-950 text-xl font-bold w-6">{{ $treatments->firstItem() + $loop->index }}.</div>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $treatment->name }}</h3>
                    </div> 

                    <div class="flex flex-row items-center gap-x-3">
                    <p class=" text-slate-500 text-md text-justify">{{ $treatment->description }}</p>
                    </div>

                </div>

                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        <a href="{{route('treatments.edit', $treatment )}}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-full">
                            Edit
                        </a>
                        <form action="{{route('treatments.destroy', $treatment )}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold px-5 py-2.5 bg-red-700 text-white rounded-full">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                <hr>
                @empty
                <p>belum ada treatment yang diinput</p>
                @endforelse

                <div class="mt-4">
                    {{ $treatments->links('vendor.pagination.custom') }}
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>


</div>