<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Exports\AssignmentsExport;
use Maatwebsite\Excel\Facades\Excel;

class AssignmentReportController extends Controller
{
    // Shared query for HTML and Excel
    protected function getFilteredAssignments($start_date = null, $end_date = null)
    {
        return Assignment::with(['room', 'guests.treatment', 'guests.therapist'])
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->orderBy('date')
            ->get();
    }

    public function index(Request $request)
    {
        $assignments = collect(); // empty collection by default

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $assignments = $this->getFilteredAssignments($request->start_date, $request->end_date);
        }

        return view('reports.assignments', compact('assignments'));

    }

    public function exportExcel(Request $request)
    {
        if (!$request->filled('start_date') || !$request->filled('end_date')) {
            return back()->with('error', 'Please select a date range before exporting.');
        }
    
        return Excel::download(
            new AssignmentsExport($this->getFilteredAssignments($request->start_date, $request->end_date)),
            'SpaLab Bintan Report' . '.xlsx'
        );
    }
}
