<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Package;

class ProcessDeliveredPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-delivered-packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old delivered packages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Defina o limite de dias sem atualização do último evento
        $daysWithoutUpdate = env('DAYS_WITHOUT_UPDATE', 15);

        // Data limite para considerar um pacote como pronto para exclusão
        $limitDate = Carbon::now()->subDays($daysWithoutUpdate);

        // Status que estamos verificando
        $targetStatus = "Objeto entregue ao destinatário";

        // Busque os pacotes cujo último evento foi antes da data limite e traga apenas o último evento
        $oldPackages = Package::whereHas('packageEvent', function ($query) use ($limitDate) {
            $query->where('data', '<', $limitDate);
        })->with([
                    'packageEvent' => function ($query) {
                        $query->orderBy('data', 'desc')->take(1);
                    }
                ])->get();

        dump($oldPackages->count() . ' pacotes com mais de ' . $daysWithoutUpdate . ' dias sem atualização');

        $packagesToDelete = $oldPackages->filter(function ($package) use ($targetStatus) {
            return $package->packageEvent[0]->status == $targetStatus;

        });

        dump($packagesToDelete->count() . ' pacotes prontos para exclusão');

        $packagesToDelete->each(function ($package) {
            $package->delete();
        });

    }
}
