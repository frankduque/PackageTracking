<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\Package;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PackageUpdateService
{
    protected $client;
    protected $baseUrl;
    protected $user;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('CORREIOS_API_BASE_URL');
        $this->user = env('CORREIOS_API_USER');
        $this->token = env('CORREIOS_API_TOKEN');
        $this->client = new Client();
    }
    public function trackAndSyncPackages(array $codes)
    {
        // Chamar a API dos Correios para rastrear os pacotes
        $trackingData = $this->trackPackages($codes);

        // Sincronizar os dados no banco de dados
        $this->syncPackages($trackingData);
    }

    public function trackPackages(array $codes)
    {
        $url = $this->baseUrl . '/rastreio';
        $data = [
            'user' => $this->user,
            'token' => $this->token,
            'codigos' => $codes,
        ];

        try {
            $response = $this->client->request('POST', $url, [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);

            // Retorna a resposta
            return $responseData;
        } catch (\Exception $e) {
            // Loga a exceção
            Log::error('Exceção na chamada da API dos Correios: ' . $e->getMessage());
            return [];
        }
    }

    protected function syncPackages($trackingData)
    {

        foreach ($trackingData as $packageData) {
            //checa se houve erro na resposta da API
            if (isset($packageData['error']) && $packageData['error']) {
                Log::error('Erro ao rastrear o pacote ' . $packageData['rastreio']['codigo'] . ': ' . $packageData['error']);
                continue;
            }

            $ultimo = isset($packageData['rastreio']['ultimo']) ? Carbon::parse($packageData['rastreio']['ultimo'])->toDateTimeString() : null;
            $package = Package::updateOrCreate(
                ['codigo' => $packageData['rastreio']['codigo']],
                [
                    'host' => $packageData['rastreio']['host'],
                    'time' => $packageData['rastreio']['time'],
                    'quantidade' => $packageData['rastreio']['quantidade'],
                    'servico' => $packageData['rastreio']['servico'],
                    'ultimo' => $ultimo,
                    'updated_at' => now(),
                ]
            );

            // Dentro do loop que cria os eventos
            $eventsData = $packageData['rastreio']['eventos'];

            $events = [];

            foreach ($eventsData as $eventData) {
                $dateTime = Carbon::createFromFormat('d/m/Y H:i:s', $eventData['data'] . ' ' . $eventData['hora']);

                $event = [
                    'data' => $dateTime->toDateTimeString(),
                    'local' => $eventData['local'],
                    'status' => $eventData['status'],
                    'sub_status' => isset($eventData['subStatus']) ? json_encode($eventData['subStatus']) : null,
                ];

                $events[] = $event;
            }


            // Atualizar os eventos de rastreamento associados ao pacote, se necessário
            if ($events) {
                $package->packageEvent()->delete();
                $package->packageEvent()->createMany($events);
            }
        }
    }


}
