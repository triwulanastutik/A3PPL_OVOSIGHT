<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen MQTT data';

    public function handle()
    {
        $server = '2ab8fa55dfbb4297aadc19680815436a.s1.eu.hivemq.cloud';
        $port = 8883;
        $clientId = uniqid('laravel-');

        $connectionSettings = (new ConnectionSettings)
            ->setUsername('IdGs2063')
            ->setPassword('IdGs2063&')
            ->setUseTls(true)
            ->setTlsSelfSignedAllowed(true)
            ->setTlsVerifyPeer(false);

        $mqtt = new MqttClient($server, $port, $clientId);
    try {
        $mqtt->connect($connectionSettings);

        $this->info('MQTT Connected!');

        $mqtt->subscribe('telur/sensor', function ($topic, $message) {

            $this->info("Data masuk: " . $message);

            $data = json_decode($message, true);

            DB::table('sensor_logs')->insert([
                'id_telur' => $data['id_telur'] ?? null,
                'berat' => $data['berat'] ?? 0,
                'cahaya' => $data['ir'] ?? 0,
                'status' => $data['status'] ?? 'tidak',
                'tanggal' => now()->toDateString(),
                'waktu' => now()->format('H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->info('Data berhasil disimpan.');
        }, 0);

        $mqtt->loop(true);

    } catch (\Exception $e) {
        $this->error("MQTT ERROR: " . $e->getMessage());
    }
    }
}
