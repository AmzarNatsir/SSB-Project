<?php

namespace Database\Seeders;

use App\Models\PettyCashExpenseCategory;
use Illuminate\Database\Seeder;

class PettyCashExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => 'BBM',         'name' => 'BBM / Bahan Bakar',          'description' => 'Bahan bakar kendaraan / alat berat operasional.'],
            ['code' => 'KONSUMSI',    'name' => 'Konsumsi',                   'description' => 'Makan, minum, snack untuk tim project.'],
            ['code' => 'TRANSPORT',   'name' => 'Transportasi',               'description' => 'Ongkos perjalanan dinas, taksi, parkir, tol.'],
            ['code' => 'ATK',         'name' => 'Alat Tulis Kantor',          'description' => 'Pulpen, kertas, tinta printer, dll.'],
            ['code' => 'KOMUNIKASI',  'name' => 'Komunikasi',                 'description' => 'Pulsa, paket data lapangan.'],
            ['code' => 'MAT-KECIL',   'name' => 'Material Kecil',             'description' => 'Sparepart kecil, baut, kabel, lampu, dll.'],
            ['code' => 'PERIZINAN',   'name' => 'Perizinan / Administrasi',   'description' => 'Biaya legalisir, fotokopi dokumen, materai.'],
            ['code' => 'LAINNYA',     'name' => 'Lainnya',                    'description' => 'Biaya operasional kecil di luar kategori standar.'],
        ];

        foreach ($categories as $cat) {
            if (PettyCashExpenseCategory::where('code', $cat['code'])->exists()) continue;
            PettyCashExpenseCategory::create([
                'code'        => $cat['code'],
                'name'        => $cat['name'],
                'description' => $cat['description'],
                'is_active'   => true,
            ]);
        }

        $this->command->info('Petty Cash Expense Categories seeded.');
    }
}
