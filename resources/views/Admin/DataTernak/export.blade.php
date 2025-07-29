<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Periode</th>
            <th>Tahun</th>
            <th>Jenis Ternak</th>
            <th>Jumlah</th>
            <th>Total Ternak</th>
            <th>Riwayat Penyakit</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php $shownTotalJenis = []; @endphp
        @foreach ($groupedPeternaks as $index => $peternak)
            @php
                $groupedTernak = $peternak->ternaks->groupBy('jenis_ternak');
                $totalTernak = $peternak->ternaks->count();
            @endphp
            @for ($i = 0; $i < $totalTernak; $i++)
                <tr>
                    @if ($i === 0)
                        <td rowspan="{{ $totalTernak }}">{{ $loop->iteration }}</td>
                        <td rowspan="{{ $totalTernak }}">{{ $peternak->nama }}</td>
                        <td rowspan="{{ $totalTernak }}">{{ $peternak->alamat }}</td>
                        <td rowspan="{{ $totalTernak }}">{{ $peternak->periode }}</td>
                        <td rowspan="{{ $totalTernak }}">{{ $peternak->tahun }}</td>
                    @endif

                    @php $ternak = $peternak->ternaks[$i]; @endphp
                    <td>{{ $ternak->jenis_ternak }} ({{ $ternak->jenis_kelamin }})</td>
                    <td>{{ $ternak->jumlah }}</td>
                    <td>
                        @php $key = $ternak->peternak_id . '_' . $ternak->jenis_ternak; @endphp
                        @if (!in_array($key, $shownTotalJenis))
                            {{ $ternak->total_jumlah }}
                            @php $shownTotalJenis[] = $key; @endphp
                        @endif
                    </td>
                    <td>{{ $ternak->riwayat_penyakit ?? '-' }}</td>
                    <td>{{ $ternak->keterangan ?? '-' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
