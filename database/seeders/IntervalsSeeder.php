<?php

namespace Database\Seeders;

use App\Models\Interval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class IntervalsSeeder extends Seeder
{
    private const TOTAL_RECORDS = 10_000;
    private const BATCH_SIZE = 500;


    public function run(): void
    {
        $this->command->info("Generating " . self::TOTAL_RECORDS . " interval records...");
        $progressBar = $this->command->getOutput()->createProgressBar(
            ceil(self::TOTAL_RECORDS / self::BATCH_SIZE)
        );

        $progressBar->start();

        Interval::factory()
            ->count(10_000)
            ->make()
            ->chunk(self::BATCH_SIZE)
            ->each(function ($chunk) use ($progressBar) {
                Interval::insert($chunk->toArray());
                $progressBar->advance();
            });

        $progressBar->finish();
        $this->command->newLine(2);
        $this->command->info("\nCompleted!");
    }
}
