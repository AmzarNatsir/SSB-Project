<?php

namespace App\Console\Commands;

use App\Models\QuotationItem;
use App\Services\WorkshopApiService;
use Illuminate\Console\Command;

class BackfillQuotationItemUidUnit extends Command
{
    /**
     * Backfill kolom uid_unit pada quotation_items lama dengan UID dari API Workshop.
     *
     * Idempotent — hanya proses row yang uid_unit-nya NULL dan unit_id-nya ada.
     * Bisa di-rerun aman.
     */
    protected $signature = 'quotations:backfill-uid-unit
                            {--dry-run : Tampilkan rencana tanpa menulis ke DB}
                            {--chunk=200 : Jumlah baris per chunk}';

    protected $description = 'Backfill uid_unit pada quotation_items lama berdasarkan unit_id (lookup ke API Workshop).';

    public function handle(WorkshopApiService $workshop): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $chunkSize = max(50, (int) $this->option('chunk'));

        $total = QuotationItem::whereNull('uid_unit')->whereNotNull('unit_id')->count();

        if ($total === 0) {
            $this->info('Tidak ada quotation_items yang perlu di-backfill. Semua sudah memiliki uid_unit.');
            return self::SUCCESS;
        }

        $this->info("Ditemukan {$total} quotation_items yang perlu di-backfill.");
        if ($dryRun) {
            $this->warn('Mode DRY-RUN aktif — tidak akan menulis ke DB.');
        }

        // Ambil semua unit_id unik agar lookup ke Workshop API hanya 1× via cache
        $uniqueIds = QuotationItem::whereNull('uid_unit')
            ->whereNotNull('unit_id')
            ->pluck('unit_id')
            ->unique()
            ->values()
            ->all();

        $this->info('Pre-fetch ' . count($uniqueIds) . ' unique unit_id dari API Workshop...');
        $unitsMap = $workshop->findMany($uniqueIds); // keyed by id

        $updated = 0;
        $missing = 0;
        $skipped = 0;

        $progress = $this->output->createProgressBar($total);
        $progress->start();

        QuotationItem::whereNull('uid_unit')
            ->whereNotNull('unit_id')
            ->orderBy('id')
            ->chunkById($chunkSize, function ($items) use (&$updated, &$missing, &$skipped, $unitsMap, $dryRun, $progress) {
                foreach ($items as $item) {
                    $unit = $unitsMap[$item->unit_id] ?? null;

                    if (! $unit || empty($unit['uid'])) {
                        $missing++;
                        $progress->advance();
                        continue;
                    }

                    if ((string) $item->uid_unit === (string) $unit['uid']) {
                        $skipped++;
                        $progress->advance();
                        continue;
                    }

                    if (! $dryRun) {
                        // Update tanpa trigger boot/saving (hindari recalculate total_price)
                        QuotationItem::where('id', $item->id)->update(['uid_unit' => $unit['uid']]);
                    }
                    $updated++;
                    $progress->advance();
                }
            });

        $progress->finish();
        $this->newLine(2);

        $this->table(
            ['Status', 'Jumlah'],
            [
                ['Updated',        $updated],
                ['Missing di API', $missing],
                ['Skipped (sudah sama)', $skipped],
                ['Total diperiksa', $updated + $missing + $skipped],
            ]
        );

        if ($missing > 0) {
            $this->warn("{$missing} item tidak ditemukan di API Workshop (unit_id mungkin sudah tidak valid). Cek log untuk detail.");
        }

        if ($dryRun) {
            $this->comment('DRY-RUN: tidak ada perubahan ditulis. Jalankan tanpa --dry-run untuk apply.');
        } else {
            $this->info("Backfill selesai. {$updated} baris diperbarui.");
        }

        return self::SUCCESS;
    }
}
