

<x-app-layout>
    <div class="p-4 sm:ml-64">

        <div class="mx-auto sm:px-4 lg:px-4 ">

            {{-- Box 1 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <a href="{{ route('therapists.index') }}" class="font-bold px-5 py-2.5 bg-indigo-700 text-white rounded-lg">
                    Back
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Manage Therapists
                </h2>
                <a href="{{ route('therapists.create') }}" class="font-bold px-5 py-2.5 bg-[#7d5f12] text-white rounded-lg">
                    Add New
                </a>
            </div>


            {{-- Box 3 --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg p-6 flex flex-col gap-y-4">

                <div class="overflow-hidden rounded-xl">
                    <table class="w-full text-md text-left text-gray-500 rounded-xl overflow-hidden">
                        <thead class="text-md text-white uppercase bg-[#7d5f12]">
                            <tr>
                                <th scope="col" class="pl-6 pr-2 py-4 rounded-tl-xl w-[5%]">
                                    No
                                </th>
                                <th scope="col" class="px-8 py-4 w-[35%]">
                                    Name
                                </th>
                                <th scope="col" class="px-8 py-4 w-[35%]">
                                    Is Working Today?
                                </th>
                                <th scope="col" class="px-8 py-4 rounded-tr-xl w-[25%]">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($therapists as $therapist)
                            <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 font-medium">
                                <td class="pl-6 pr-2 py-4">
                                    {{ $therapists->firstItem() + $loop->index }}.
                                </td>
                                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 gap-x-6">
                                    <img class="w-10 h-10 rounded-full" src="{{ Storage::url($therapist->image) }}" alt="">
                                    <div class="text-lg">{{ $therapist->name }}</div>
                                </th>
                                <td class="px-6 py-4 items-center justify-between">
                                    <div x-data="{ available: {{ $therapist->is_available ? 'true' : 'false' }} }" class="hidden md:flex flex-col">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input 
                                                type="checkbox" 
                                                class="sr-only peer" 
                                                :checked="available"
                                                @change="toggleAvailability({{ $therapist->id }})"
                                            >
                                            <div class="relative w-11 h-6 bg-gray-200 rounded-full
                                                peer-focus:ring-4 peer-focus:ring-blue-300
                                                peer-checked:bg-blue-600
                                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                                after:bg-white after:border-gray-300 after:border after:rounded-full
                                                after:h-5 after:w-5 after:transition-all
                                                peer-checked:after:translate-x-5">
                                            </div>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-row gap-x-3">
                                        <a href="{{ route('therapists.show', $therapist) }}" class="font-medium text-blue-600 hover:underline">Details</a> |
                                        <a href="{{ route('therapists.edit', $therapist) }}" class="font-medium text-blue-600 hover:underline">Edit</a> | 
                                        <form action="{{ route('therapists.destroy', $therapist) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-blue-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">Belum ada Therapist yang diinput</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $therapists->links('vendor.pagination.custom') }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>


</div>


{{-- <div x-data="{ available: {{ $therapist->is_available ? 'true' : 'false' }} }" class="hidden md:flex flex-col">
    <label class="inline-flex items-center cursor-pointer">
        <input 
            type="checkbox" 
            class="sr-only peer" 
            :checked="available"
            @change="toggleAvailability({{ $therapist->id }})"
        >
        <div class="relative w-11 h-6 bg-gray-200 rounded-full
            peer-focus:ring-4 peer-focus:ring-blue-300
            peer-checked:bg-blue-600
            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
            after:bg-white after:border-gray-300 after:border after:rounded-full
            after:h-5 after:w-5 after:transition-all
            peer-checked:after:translate-x-5">
        </div>
    </label>
</div> --}}

<script>
    function toggleAvailability(id) {
        fetch(`/therapists/${id}/toggle`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) throw new Error('Toggle failed');
            return response.json();
        })
        .then(data => {
            console.log('Status updated:', data);
        })
        .catch(error => {
            alert('Failed to update availability');
            console.error(error);
        });
    }
</script>