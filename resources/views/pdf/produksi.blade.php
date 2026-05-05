<h2>Laporan Produksi Telur</h2>

<p>Periode: {{ $start }} sampai {{ $end }}</p>

<hr>

<p>Total Produksi: {{ $total }}</p>
<p>Layak: {{ $layak }}</p>
<p>Tidak Layak: {{ $tidak }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Waktu</th>
            <th>Sensor</th>
            <th>Batch</th>
            <th>Jumlah</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>{{ $log->created_at }}</td>
            <td>{{ $log->sensor_id }}</td>
            <td>{{ $log->batch }}</td>
            <td>{{ $log->units }}</td>
            <td>{{ $log->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>