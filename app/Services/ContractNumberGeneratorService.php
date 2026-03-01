<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Project;
use Carbon\Carbon;

class ContractNumberGeneratorService
{
    /**
     * Generate a unique contract number
     * Format: K-{serial_number}/SSB-{user_code}/{month_in_roman}/{year}
     */
    public function generate(Project $project): string
    {
        $now = Carbon::now();
        $year = $now->year;
        $monthRoman = $this->getRomanMonth($now->month);
        $userCode = $project->user_code ?? 'PRJ'; // Default to PRJ if not set

        $serialNumber = $this->getNextSerialNumber($year);
        $paddedSerial = str_pad($serialNumber, 4, '0', STR_PAD_LEFT);

        return "K-{$paddedSerial}/SSB-{$userCode}/{$monthRoman}/{$year}";
    }

    /**
     * Get the next serial number for the given year
     */
    protected function getNextSerialNumber(int $year): int
    {
        $lastContract = Contract::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastContract) {
            return 1;
        }

        // Extract serial number from K-XXXX/...
        $parts = explode('/', $lastContract->contract_number);
        $serialPart = str_replace('K-', '', $parts[0]);

        return (int) $serialPart + 1;
    }

    /**
     * Convert month number to Roman numeral
     */
    protected function getRomanMonth(int $month): string
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $romans[$month] ?? 'I';
    }
}
