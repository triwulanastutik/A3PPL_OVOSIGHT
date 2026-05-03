@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-bold mb-6">Log Kejadian Sensor</h1>

    <div class="bg-white rounded-xl shadow p-6">

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Waktu</th>
                    <th class="p-3 text-left">Sensor</th>
                    <th class="p-3 text-left">Batch</th>
                    <th class="p-3 text-left">Jumlah</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($logs as $log)
                <tr class="border-b">
                    <td class="p-3">{{ $log->waktu }}</td>
                    <td class="p-3">{{ $log->sensor_id }}</td>
                    <td class="p-3">{{ $log->batch }}</td>
                    <td class="p-3 font-semibold">{{ $log->jumlah_telur }} unit</td>
                    <td class="p-3">
                        @if($log->status == 'layak')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">
                                Layak
                            </span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs">
                                Tidak Layak
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
@endsection