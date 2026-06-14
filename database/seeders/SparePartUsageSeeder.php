<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SparePartUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SparePartUsageSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        if ($projects->isEmpty()) {
            $this->command->warn("No projects found, skipping SparePartUsageSeeder.");
            return;
        }

        $user = User::first();
        $userId = $user ? $user->id : 1;

        $parts = [
            ['name' => 'Oil Filter Donaldson', 'cat' => 'Filters', 'uom' => 'PCS', 'price' => 150000],
            ['name' => 'Hydraulic Hose 1/2"', 'cat' => 'Hydraulics', 'uom' => 'PCS', 'price' => 450000],
            ['name' => 'Track Link Assembly', 'cat' => 'Tires & Tracks', 'uom' => 'SET', 'price' => 12500000],
            ['name' => 'V-Belt Fan', 'cat' => 'Engine', 'uom' => 'PCS', 'price' => 180000],
            ['name' => 'Starter Motor 24V', 'cat' => 'Electrical', 'uom' => 'PCS', 'price' => 2200000],
            ['name' => 'Brake Pad Front', 'cat' => 'Brakes', 'uom' => 'SET', 'price' => 350000],
            ['name' => 'Fuel Filter Cummins', 'cat' => 'Filters', 'uom' => 'PCS', 'price' => 250000],
            ['name' => 'Alternator 60A', 'cat' => 'Electrical', 'uom' => 'PCS', 'price' => 1850000],
            ['name' => 'Air Filter Outer', 'cat' => 'Filters', 'uom' => 'PCS', 'price' => 320000],
            ['name' => 'Grease Shell Gadus', 'cat' => 'Filters', 'uom' => 'PAIL', 'price' => 1200000],
            ['name' => 'Engine Oil SAE 15W-40', 'cat' => 'Engine', 'uom' => 'LITER', 'price' => 65000],
            ['name' => 'Hydraulic Oil ISO 68', 'cat' => 'Hydraulics', 'uom' => 'LITER', 'price' => 75000],
            ['name' => 'Radiator Coolant', 'cat' => 'Engine', 'uom' => 'GAL', 'price' => 140000],
            ['name' => 'Headlamp LED 24V', 'cat' => 'Electrical', 'uom' => 'PCS', 'price' => 350000],
            ['name' => 'Bucket Tooth EX-200', 'cat' => 'Tires & Tracks', 'uom' => 'PCS', 'price' => 850000],
        ];

        $units = [
            ['name' => 'Excavator EX-200', 'code' => 'EQ-EX200'],
            ['name' => 'Dump Truck DT-05', 'code' => 'EQ-DT05'],
            ['name' => 'Bulldozer DZ-01', 'code' => 'EQ-DZ01'],
            ['name' => 'Wheel Loader WL-02', 'code' => 'EQ-WL02'],
        ];

        $vendors = ['PT. United Tractors', 'PT. Hexindo Adiperkasa', 'Toko Berkat Motor', 'CV. Mandiri Teknik'];

        // Let's seed 30 items
        for ($i = 0; $i < 30; $i++) {
            $part = $parts[array_rand($parts)];
            $unit = $units[array_rand($units)];
            $project = $projects->random();
            $qty = rand(1, 5);
            $price = $part['price'] * (1 + (rand(-10, 10) / 100)); // Add small price variation
            $price = round($price, -3); // round to nearest thousand

            // Generate date in the current month (June 2026)
            $day = rand(1, 11);
            $date = Carbon::create(2026, 6, $day)->toDateString();

            $status = ['DRAFT', 'SUBMITTED', 'APPROVED', 'APPROVED', 'APPROVED'][rand(0, 4)];

            $spu = new SparePartUsage();
            $spu->uid = (string) Str::uuid();
            $spu->usage_number = SparePartUsage::generateNumber();
            $spu->project_id = $project->id;
            $spu->unit_name = $unit['name'];
            $spu->equipment_code = $unit['code'];
            $spu->usage_date = $date;
            $spu->part_name = $part['name'];
            $spu->part_number = 'PN-' . rand(10000, 99999);
            $spu->part_category = $part['cat'];
            $spu->quantity = $qty;
            $spu->unit_of_measure = $part['uom'];
            $spu->unit_price = $price;
            $spu->total_price = $qty * $price;
            $spu->vendor_name = $vendors[array_rand($vendors)];
            $spu->purchase_order_number = 'PO-2026-' . rand(1000, 9999);
            $spu->status = $status;
            $spu->description = 'Penggantian rutin / perbaikan unit pada proyek ' . $project->project_name;
            $spu->created_by = $userId;
            
            if ($status === 'APPROVED') {
                $spu->approved_by = $userId;
                $spu->approved_at = Carbon::parse($date)->addHours(rand(1, 24));
            }

            $spu->save();
        }

        $this->command->info("Seeded 30 Spare Part Usage entries successfully!");
    }
}
