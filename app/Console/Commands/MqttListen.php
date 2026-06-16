<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen MQTT data';

    public function handle()
    {
        $server   = '2ab8fa55dfbb4297aadc19680815436a.s1.eu.hivemq.cloud';
        $port     = 1883;
        $clientId = 'laravel-client';

        $connectionSettings = (new ConnectionSettings)
            ->setUsername('USERNAME_KAMU')
            ->setPassword('PASSWORD_KAMU')
            ->setUseTls(false);

        $mqtt = new MqttClient($server, $port, $clientId);

        $mqtt->connect($connectionSettings, true);

        $this->info('MQTT Connected!');

        $mqtt->subscribe('telur/sensor', function ($topic, $message) {

            $this->info("Data masuk: " . $message);

            $data = json_decode($message, true);

            // 👉 SIMPAN KE DATABASE (contoh)
            \DB::table('telurs')->insert([
                'id_telur' => $data['id_telur'],
                'berat' => $data['berat'],
                'ir' => $data['ir'],
                'status' => $data['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }, 0);

        $mqtt->loop(true);
    }
}
