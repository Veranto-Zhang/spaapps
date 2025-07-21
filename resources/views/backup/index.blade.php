<x-app-layout>
    <div class="p-4 sm:ml-64">

        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4 ">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

            {{-- Box 1 --}}
            <div class="bg-white shadow-sm rounded-md sm:rounded-lg p-6 mb-8 flex flex-row justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Database Backup
                </h2>
                <div class="flex flex-rw2 gap-x-3">

                    <!-- Run Backup Button -->
                    <form action="{{ route('backup.run') }}" method="GET">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Run Database Backup
                        </button>
                    </form>

                </div>
            </div>

            {{-- Box 2 --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg p-6 flex flex-col gap-y-4">

                <h3 class="text-lg font-semibold text-gray-700">Available Backup Files:</h3>

                <table class="w-full text-left table-auto border mt-4">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-2 px-4 border">Filename</th>
                            <th class="py-2 px-4 border">Size</th>
                            <th class="py-2 px-4 border">Date</th>
                            <th class="py-2 px-4 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backupFiles as $file)
                            <tr class="border-t">
                                <td class="py-2 px-4 border">{{ $file['name'] }}</td>
                                <td class="py-2 px-4 border">{{ number_format($file['size'] / 1024 / 1024, 2) }} MB</td>
                                <td class="py-2 px-4 border">{{ \Carbon\Carbon::createFromTimestamp($file['date'])->format('Y-m-d H:i:s') }}</td>
                                <td class="py-2 px-4 border">
                                    <a href="{{ route('backup.download', ['file' => $file['name']]) }}" class="text-blue-500 hover:underline">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-2 px-4 text-center text-gray-500">No backups found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>



            </div>

        </div>
    </div>
</x-app-layout>


</div>