<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PackageUpdateService;
use App\Models\Package;

class UpdatePackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all packages statuses';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $packages = Package::all();

        $codigos = $packages->pluck('codigo');

        $service = new PackageUpdateService();

        $service->trackAndSyncPackages($codigos->toArray());
    }
}
