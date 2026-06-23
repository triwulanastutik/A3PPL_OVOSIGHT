<?php

namespace App\Console\Commands;

use App\Models\SensorLog;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';

    protected $description = 'Listen MQTT sensor data and save it to sensor_logs';

    public function handle()
    {
        $this->info('Listening MQTT sensor data...');

        MQTT::subscribe('ovosight/sensor', function (string $topic, string $message) {
            $data = json_decode($message, true);

            if (!is_array($data)) {
                $this->error('Invalid MQTT payload: ' . $message);
                return;
            }

            $status = strtolower($data['status'] ?? '');

            if (!in_array($status, ['layak', 'tidak'])) {
                $this->error('Invalid status: ' . ($data['status'] ?? '-'));
                return;
            }

            SensorLog::create([
                'id_kandang' => $data['id_kandang'] ?? 'BATCH-001',
                'tanggal'    => now()->toDateString(),
                'waktu'      => now()->format('H:i:s'),
                'berat'      => $data['berat'] ?? 0,
                'cahaya'     => $data['ir'] ?? ($data['cahaya'] ?? 0),
                'status'     => $status,
            ]);

            $this->info('Data sensor berhasil disimpan: ' . json_encode($data));
        });
    }
}