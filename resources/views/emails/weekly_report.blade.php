<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly Signup Report</title>
</head>
<body>
    <h2>📊 Weekly Signup Report</h2>

    <p><strong>Total Signups:</strong> {{ $total }}</p>

    <h3>Signups by Source:</h3>
    <ul>
        @foreach ($bySource as $source)
            <li>{{ $source->signup_source }}: {{ $source->total }}</li>
        @endforeach
    </ul>

    <h3>Peak Signup Day:</h3>
    <p>{{ $peakDay->date }} ({{ $peakDay->total }} signups)</p>

    <h3>Trends (last 30 days):</h3>
    <table border="1" cellpadding="6">
        <tr>
            <th>Date</th>
            <th>Signups</th>
        </tr>
        @foreach ($trends as $item)
            <tr>
                <td>{{ $item['date'] ?? $item['week'] }}</td>
                <td>{{ $item['total'] }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
