<!DOCTYPE html>
<html>
<head>
    <title>Database Viewer</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        h2 { color: #333; margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Database Contents</h1>
    
    @foreach($data as $tableName => $rows)
        <h2>Table: {{ $tableName }}</h2>
        
        @if(count($rows) > 0)
            <table>
                <thead>
                    <tr>
                        @foreach((array)$rows[0] as $column => $value)
                            <th>{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            @foreach((array)$row as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No records found.</p>
        @endif
    @endforeach
</body>
</html>