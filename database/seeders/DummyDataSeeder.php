<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProduksiHarian;
use App\Models\User;
use App\Models\AlatTambang;
use App\Models\LokasiTambang;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $operators = User::where('role', 'Operator')->get();
        if ($operators->isEmpty()) {
            $this->command->error('Operator tidak ditemukan!');
            return;
        }

        $alats = AlatTambang::where('tipe_alat', 'Dump Truck')->get();
        if ($alats->isEmpty()) {
            // Fallback just in case
            $alats = AlatTambang::where('nama_alat', 'like', '%Dump Truck%')->get();
            if ($alats->isEmpty()) {
                $this->command->error('Alat tambang tipe Dump Truck tidak ditemukan!');
                return;
            }
        }
        if ($alats->isEmpty()) {
            $this->command->error('Alat tambang tidak ditemukan!');
            return;
        }

        $lokasis = LokasiTambang::all();
        if ($lokasis->isEmpty()) {
            $lokasis = collect([(object)['nama_lokasi' => 'Pit Alpha'], (object)['nama_lokasi' => 'Pit Bravo']]);
        }

        $startDate = Carbon::create(2025, 1, 1);
        $endDate = Carbon::today();

        $this->command->info('Menghapus data lama...');
        ProduksiHarian::query()->delete();

        $this->command->info('Membuat data produksi realistis dari ' . $startDate->toDateString() . ' sampai ' . $endDate->toDateString());

        DB::beginTransaction();

        try {
            $currentDate = $startDate->copy();
            $count = 0;
            
            while ($currentDate->lte($endDate)) {
                // Di perusahaan besar, 1 hari bisa ada 5-10 laporan dari berbagai shift & alat
                $jumlahLaporan = rand(3, 8);
                
                for ($i = 0; $i < $jumlahLaporan; $i++) {
                    $randomOperator = $operators->random();
                    $randomAlat = $alats->random();
                    $randomLokasi = $lokasis->random();

                    // Logika: Jika material Overburden, biasanya dibawa ke Disposal. Jika Batu bara, ke Stockpile.
                    // Karena `lokasi` di laporan adalah tempat menggali/membawa, kita biarkan random atau sesuai Pit.
                    $material = rand(0, 1) ? 'Overburden' : 'Batu Bara';
                    
                    if (str_contains(strtolower($randomLokasi->nama_lokasi), 'disposal')) {
                        $material = 'Overburden';
                    } elseif (str_contains(strtolower($randomLokasi->nama_lokasi), 'stockpile')) {
                        $material = 'Batu Bara';
                    }

                    ProduksiHarian::create([
                        'user_id' => $randomOperator->id,
                        'alat_tambang_id' => $randomAlat->id,
                        'tanggal' => $currentDate->toDateString(),
                        'shift' => rand(0, 1) ? 'Shift Siang' : 'Shift Malam',
                        'material' => $material,
                        'volume' => rand(500, 1500) + (rand(0, 99) / 100),
                        'jarak_angkut' => rand(800, 3500), // jarak angkut lebih realistis (meter)
                        'jam_operasi' => rand(8, 12),
                        'lokasi_tambang_id' => $randomLokasi->id,
                        'bahan_bakar' => rand(200, 400),
                        'cuaca' => rand(1, 10) > 2 ? 'Cerah' : 'Hujan', // 80% cerah
                        'hambatan_operasional' => rand(1, 10) > 8 ? 'Hujan Deras / Slippery' : 'Tidak Ada',
                        'status_laporan' => 'Disetujui', // Disetujui agar muncul di grafik
                        'created_at' => $currentDate->copy()->addHours(rand(8, 23)),
                        'updated_at' => $currentDate->copy()->addHours(rand(8, 23)),
                    ]);
                    $count++;
                }
                
                $currentDate->addDay();
            }

            DB::commit();
            $this->command->info("Berhasil membuat $count baris data dummy realistis!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Gagal: ' . $e->getMessage());
        }
    }
}
