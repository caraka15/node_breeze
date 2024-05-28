<?php

namespace App\Exports;

use App\Models\Airdrop;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class UserAirdropsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{
    protected $totalSalary;
    protected $userName;

    public function __construct()
    {
        $this->totalSalary = Airdrop::where('user_id', Auth::user()->id)->sum('salary');
        $this->userName = Auth::user()->name;
    }

    public function collection()
    {
        $airdrops = Airdrop::where('user_id', Auth::user()->id)
            ->latest('updated_at')
            ->get()
            ->map(function ($airdrop, $index) {
                return [
                    'NO' => $index + 1,
                    'Nama' => $airdrop->nama,
                    'Link' => $airdrop->link,
                    'Frekuensi' => $airdrop->frekuensi,
                    'Sudah Dikerjakan' => $airdrop->sudah_dikerjakan ? 'sudah' : 'belum',
                    'Selesai' => $airdrop->selesai ? 'selesai' : 'belum',
                    'Salary' => $airdrop->salary,
                ];
            });

        // Tambahkan total salary di akhir koleksi
        $airdrops->push([
            'NO' => '',
            'Nama' => '',
            'Link' => '',
            'Frekuensi' => '',
            'Sudah Dikerjakan' => '',
            'Selesai' => 'Total Salary',
            'Salary' => $this->totalSalary,
        ]);

        return $airdrops;
    }

    public function headings(): array
    {
        return [
            ['List Airdrop ' . $this->userName],
            [],
            [
                'NO',
                'Nama',
                'Link',
                'Frekuensi',
                'Sudah Dikerjakan',
                'Selesai',
                'Salary',
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                // Merge cell for the title
                $event->sheet->getDelegate()->mergeCells('A1:G1');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                // Center align the title
                $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Styling for heading
                $event->sheet->getDelegate()->getStyle('A3:G3')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
                $event->sheet->getDelegate()->getStyle('A3:G3')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('4CAF50');

                // Applying borders to all cells
                $cellRange = 'A1:G' . $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000');
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]], // Mengatur gaya untuk judul
            3    => ['font' => ['bold' => true]], // Mengatur gaya untuk heading
        ];
    }
}
