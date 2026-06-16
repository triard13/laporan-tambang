<?php

namespace App\Exports;

use App\Models\ProduksiHarian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = ProduksiHarian::with(['user', 'alatTambang', 'lokasiTambang'])->orderBy('created_at', 'desc');

        if (!empty($this->filters['tanggal_mulai'])) {
            $query->whereDate('tanggal', '>=', $this->filters['tanggal_mulai']);
        }
        if (!empty($this->filters['tanggal_akhir'])) {
            $query->whereDate('tanggal', '<=', $this->filters['tanggal_akhir']);
        }
        if (!empty($this->filters['status_laporan'])) {
            $query->where('status_laporan', $this->filters['status_laporan']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Shift',
            'Lokasi Tambang',
            'Kode Alat',
            'Alat Tambang',
            'Operator',
            'Material',
            'Volume (BCM)',
            'Jarak Angkut (m)',
            'Jam Operasi',
            'Bahan Bakar (L)',
            'Cuaca',
            'Status Laporan'
        ];
    }

    public function map($laporan): array
    {
        return [
            $laporan->id,
            $laporan->tanggal,
            $laporan->shift,
            $laporan->lokasiTambang->nama_lokasi ?? '-',
            $laporan->alatTambang->kode_alat ?? '-',
            $laporan->alatTambang->nama_alat ?? '-',
            $laporan->user->nama_lengkap ?? '-',
            $laporan->material,
            $laporan->volume,
            $laporan->jarak_angkut,
            $laporan->jam_operasi,
            $laporan->bahan_bakar,
            $laporan->cuaca,
            $laporan->status_laporan,
        ];
    }
}
