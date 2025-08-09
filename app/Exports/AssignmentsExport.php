<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssignmentsExport implements FromCollection, WithHeadings, WithEvents, WithStyles
{
    protected $assignments;
    protected $dataRows = [];

    public function __construct($assignments)
    {
        $this->assignments = $assignments;
    }

    public function collection()
    {
        foreach ($this->assignments as $aIndex => $assignment) {
            $guestCount = $assignment->guests->count();

            foreach ($assignment->guests as $gIndex => $guest) {
                $this->dataRows[] = [
                    'no'        => $gIndex == 0 ? $aIndex + 1 : '',
                    'date'      => $gIndex == 0 ? $assignment->date->format('d F Y') : '',
                    'room'      => $gIndex == 0 ? $assignment->room->name : '',
                    'guest'     => $guest->name,
                    'treatment' => $guest->duration_in_min . ' mins of ' . ($guest->treatment->name ?? '-'),
                    'therapist' => $guest->therapist->name ?? '',
                    'contact'   => $gIndex == 0 ? $assignment->contact : '',
                    'remark'    => $gIndex == 0 ? $assignment->remark : '',
                    'merge_rows'=> $guestCount // used for merge in AfterSheet
                ];
            }
        }

        // Format for Excel (exclude merge_rows)
        $rows = array_map(function ($row) {
            return [
                $row['no'],
                $row['date'],
                $row['room'],
                $row['guest'],
                $row['treatment'],
                $row['therapist'],
                $row['contact'],
                $row['remark'],
            ];
        }, $this->dataRows);

        // Append total guests row
        $totalGuests = $this->assignments->sum(fn($a) => $a->guests->count());
        $rows[] = ['', '', '', 'Total Guests', $totalGuests, '', '', ''];

        return collect($rows);
    }

    public function headings(): array
    {
        return ['No', 'Date', 'Room Name', 'Guest', 'Treatment', 'Therapist', 'Contact', 'Remark'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header row
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $row = 2; // First row after headings
                foreach ($this->dataRows as $data) {
                    if (!empty($data['no']) && $data['merge_rows'] > 1) {
                        $mergeTo = $row + $data['merge_rows'] - 1;
                        $event->sheet->mergeCells("A{$row}:A{$mergeTo}"); // No
                        $event->sheet->mergeCells("B{$row}:B{$mergeTo}"); // Date
                        $event->sheet->mergeCells("C{$row}:C{$mergeTo}"); // Room
                        $event->sheet->mergeCells("G{$row}:G{$mergeTo}"); // Contact
                        $event->sheet->mergeCells("H{$row}:H{$mergeTo}"); // Remark
                        $event->sheet->getStyle("A{$row}:H{$mergeTo}")->getAlignment()->setVertical('center');
                    }
                    $row++;
                }

                // Style the total guests row (last row)
                $lastRow = count($this->dataRows) + 2; // +1 for heading, +1 for zero-index adjust
                $event->sheet->getStyle("A{$lastRow}:H{$lastRow}")->getFont()->setBold(true);
                $event->sheet->getStyle("A{$lastRow}:H{$lastRow}")->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
