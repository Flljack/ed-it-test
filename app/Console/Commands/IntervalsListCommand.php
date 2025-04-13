<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class IntervalsListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'intervals:list
                            {--left= : Left boundary of the interval}
                            {--right= : Right boundary of the interval}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find intervals intersecting with [N, M] range';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $left = $this->option('left');
        $right = $this->option('right');
        $this->validateInput($left, $right);

        $intersectingIntervals = $this->getIntersectingIntervals((int)$left, (int)$right);

        $this->displayResults($intersectingIntervals, $left, $right);
    }

    protected function validateInput($left, $right): void
    {
        if (!is_numeric($left) || !is_numeric($right)) {
            $this->error('Both --left and --right options must be numeric values');
            exit(1);
        }

        if ($right < $left) {
            $this->error('Right boundary must be greater than or equal to left boundary');
            exit(1);
        }
    }

    protected function getIntersectingIntervals(int $left, int $right): array
    {
        return DB::table('intervals')
            ->where(function (Builder $query) use ($left, $right) {
                $query->where('start', '<=', $right)
                    ->where(function (Builder $query) use ($left) {
                        $query->where('end', '>=', $left)
                            ->orWhereNull('end');
                    });
            })
            ->orWhere(function (Builder $query) use ($left, $right) {
                $query->where('start', '>=', $left)
                    ->where('end', '<=', $right);
            })
            ->orderBy('start')
            ->get()
            ->toArray();
    }

    protected function displayResults(array $intervals, $left, $right): void
    {
        $this->info("Intervals intersecting with [$left, $right]:");

        if (empty($intervals)) {
            $this->line('No intersecting intervals found');
            return;
        }

        $headers = ['ID', 'Start', 'End', 'Type'];
        $rows = [];

        foreach ($intervals as $interval) {
            $rows[] = [
                $interval->id,
                $interval->start,
                $interval->end ?? '∞',
                $this->getIntervalType($interval),
            ];
        }

        $this->table($headers, $rows);
        $this->line(sprintf('Total: %d intervals', count($intervals)));
    }

    protected function getIntervalType(object $interval): string
    {
        if (is_null($interval->end)) {
            return 'Infinite';
        }

        return 'Contained';
    }
}
