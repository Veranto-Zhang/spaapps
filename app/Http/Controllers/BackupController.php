<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->files('SpaLab-Bintan');

        // Filter only .zip files and sort by date descending
        $backupFiles = collect($files)
            ->filter(fn($file) => str_ends_with($file, '.zip'))
            ->sortDesc()
            ->map(function ($file) use ($disk) {
                return [
                    'path' => $file,
                    'name' => basename($file),
                    'size' => $disk->size($file),
                    'date' => $disk->lastModified($file),
                ];
            });

        return view('backup.index', compact('backupFiles'));
    }

    // Run the backup
    public function run()
    {
        Artisan::call('backup:run --only-db');
        return back()->with('success', 'Database backup completed!');
    }

    // Download the latest backup zip
    public function download(Request $request)
{
    $fileName = $request->input('file');
    $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

    $filePath = 'SpaLab-Bintan/' . $fileName;

    if (!$disk->exists($filePath)) {
        return back()->with('error', 'Backup file not found.');
    }

    // Use Storage::path() to get full path
    return response()->download(Storage::path($filePath));
}

}

