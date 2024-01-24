<!-- resources/views/exports/airdrops.blade.php -->

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    a {
        color: #3490dc;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .status-done {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .status-undone {
        background-color: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }
</style>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Title</th>
            <th>Link</th>
            <th>Frekuensi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($airdrops as $index => $airdrop)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $airdrop->nama }}</td>
                <td><a href="{{ $airdrop->link }}" target="_blank">{{ $airdrop->link }}</a></td>
                <td>{{ $airdrop->frekuensi }}</td>
                <td class="{{ $airdrop->selesai ? 'status-done' : 'status-undone' }}">
                    {{ $airdrop->selesai ? 'DONE' : 'UNDONE' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
