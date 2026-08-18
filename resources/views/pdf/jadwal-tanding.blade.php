<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Pertandingan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Daftar Jadwal Pertandingan</h2>
    @if(request('filter_kegiatan'))
        <p><strong>Filter Kegiatan:</strong> {{ request('filter_kegiatan') }}</p>
    @endif
    @if(request('filter_cabor'))
        <p><strong>Filter Cabor:</strong> {{ request('filter_cabor') }}</p>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Cabang Olahraga</th>
                <th>Venue</th>
                <th>Nakes Jaga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwal_pertandingans as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $item->kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                <td>{{ $item->jenis_cabor }} {{ $item->kel_cabor ? '('.$item->kel_cabor.')' : '' }}</td>
                <td>{{ $item->venue }}</td>
                <td>
                    @if($item->nakesJagas->isNotEmpty())
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($item->nakesJagas as $nakesJaga)
                                <li>{{ $nakesJaga->nakes ? $nakesJaga->nakes->nama : 'N/A' }}</li>
                            @endforeach
                        </ul>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada jadwal tanding</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
