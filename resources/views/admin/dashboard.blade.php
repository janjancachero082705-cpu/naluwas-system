<!DOCTYPE html>
<html>
<head>
    <title>Church Admin Dashboard</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .card h2 {
            margin: 0;
            font-size: 18px;
        }

        .value {
            font-size: 28px;
            margin-top: 10px;
            font-weight: bold;
        }

        .section {
            margin-top: 30px;
        }

        .box {
            background: white;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }

        a {
            display: inline-block;
            margin-right: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<h1>👑 Church Admin Dashboard</h1>

<!-- STATS -->
<div class="grid">

    <div class="card">
        <h2>📦 Inventory Items</h2>
        <div class="value">{{ $totalItems }}</div>
    </div>

    <div class="card">
        <h2>💰 Total Value</h2>
        <div class="value">₱{{ $totalValue }}</div>
    </div>

    <div class="card">
        <h2>🎶 Choir Members</h2>
        <div class="value">{{ $totalMembers }}</div>
    </div>

</div>

<!-- SCHEDULE -->
<div class="section">
    <h2>📅 Latest Church Schedule</h2>

    <div class="box">
        @if($latestSchedule)
            <p><b>Type:</b> {{ $latestSchedule->event_type }}</p>
            <p><b>Date:</b> {{ $latestSchedule->service_date }}</p>
            <p><b>Songs:</b> {{ $latestSchedule->songs }}</p>
        @else
            <p>No schedule yet</p>
        @endif
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="section">
    <h2>⚡ Quick Actions</h2>

    <a href="/inventory">📦 Inventory</a>
    <a href="/choir-members">🎶 Choir</a>
    <a href="/choir-schedules">📅 Schedules</a>
    <a href="/members">👥 Members</a>
</div>

</body>
</html>