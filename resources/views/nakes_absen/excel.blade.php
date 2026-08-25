<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>NAMA</th>
            <th>INSTANSI</th>
            <th>VENUE</th>
            <th>CABOR</th>
            <th>BANK</th>
            <th>NO. REK</th>
        </tr>
    </thead>
    <tbody>
        @forelse($absens as $index => $absen)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $absen->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $absen->nama }}</td>
            <td>{{ $absen->instansi ?? '-' }}</td>
            <td>{{ $absen->nakesJaga->venue ?? '-' }}</td>
            <td>{{ $absen->nakesJaga->cabor ?? '-' }}</td>
            <td>{{ $absen->bank ?? '-' }}</td>
            <td>{{ $absen->norek ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Tidak ada data absensi.</td>
        </tr>
        @endforelse
    </tbody>
</table>
