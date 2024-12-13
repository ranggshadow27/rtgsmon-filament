<!DOCTYPE html>
<html>

<head>
    <title>records</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Watermark styling */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0.1;
        }

        h3 {
            display: inline-block;
        }

        .logo-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            width: 90px;
        }

        .record-row {
            margin-bottom: 20px;
        }

        pre {
            white-space: pre-wrap;
            /* Untuk menjaga format baris baru */
            font-family: Arial, sans-serif;
            /* Gaya font untuk teks multiline */
        }
    </style>
</head>

<body>

    <h3>RTGS Monitor Report</h3>

    @foreach ($records as $record)
        <table class="record-row">
            {{-- <tr>
                <th>record Number</th>
                <td>{{ $record->record_number }}</td>
            </tr> --}}
            <tr>
                <th>Terminal ID</th>
                <td>{{ $record->terminal_id }}</td>
            </tr>
            <tr>
                <th>Nama Site</th>
                <td>{{ $record->sitecode }}</td>
            </tr>
            {{-- <tr>
                <th>Modem</th>
                <td><strong>{{ $record->modem }}</strong> {{ $record->modem_last_up }}</td>
            </tr>
            <tr>
                <th>Router</th>
                <td><strong>{{ $record->router }}</strong> {{ $record->router_last_up }}</td>
            </tr>
            <tr>
                <th>Access Point 1</th>
                <td><strong>{{ $record->ap1 }}</strong> {{ $record->ap1_last_up }}</td>
            </tr>
            <tr>
                <th>Access Point 1</th>
                <td><strong>{{ $record->ap2 }}</strong> {{ $record->ap2_last_up }}</td>
            </tr> --}}
            <tr>
                <th>Status</th>
                <td>{{ $record->status }}</td>
            </tr>
        </table>
    @endforeach

</body>

</html>
