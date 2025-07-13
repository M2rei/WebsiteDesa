<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Ternak</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peternaks as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->alamat }}</td>
                <td>
                    @foreach ($p->ternaks as $t)
                        {{ $t->jenis_ternak }} - {{ $t->pivot->jenis_kelamin }} ({{ $t->pivot->jumlah }})<br>
                    @endforeach
                </td>
                <td>{{ $p->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
