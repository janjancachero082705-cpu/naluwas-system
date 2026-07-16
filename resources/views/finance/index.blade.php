@extends('layouts.app')

@section('header', 'Finance Dashboard')

@section('content')
<style>
    /* ============================================
       FINANCE DASHBOARD - CLEAN & MODERN
    ============================================ */
    
    .finance-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .finance-stat-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .finance-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    
    .finance-stat-card .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    
    .finance-stat-card .stat-icon.income {
        background: #E1F5EE;
        color: #0F6E56;
    }
    
    .finance-stat-card .stat-icon.expense {
        background: #FCEBEB;
        color: #A32D2D;
    }
    
    .finance-stat-card .stat-icon.balance {
        background: #EEEDFE;
        color: #534AB7;
    }
    
    .finance-stat-card .stat-icon.churches {
        background: #E6F1FB;
        color: #185FA5;
    }
    
    .finance-stat-card .stat-info {
        flex: 1;
        min-width: 0;
    }
    
    .finance-stat-card .stat-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: var(--text-muted);
        font-weight: 600;
    }
    
    .finance-stat-card .stat-value {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .finance-stat-card .stat-value.positive {
        color: #0F6E56;
    }
    
    .finance-stat-card .stat-value.negative {
        color: #A32D2D;
    }
    
    .finance-stat-card .stat-sub {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    .church-selector {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .church-selector label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .church-selector label i {
        color: #534AB7;
    }
    
    .church-selector select {
        padding: 0.5rem 1rem;
        border: 0.5px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.85rem;
        min-width: 220px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .church-selector select:focus {
        outline: none;
        border-color: #534AB7;
        box-shadow: 0 0 0 3px rgba(83, 74, 183, 0.1);
    }
    
    .church-selector .selected-church-info {
        margin-left: auto;
        font-size: 0.75rem;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        border: 0.5px solid var(--border-color);
    }
    
    .church-selector .selected-church-info strong {
        color: #534AB7;
    }
    
    .church-detail-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .church-detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #534AB7, #7C3AED);
    }
    
    .church-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .church-detail-header .church-name-large {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .church-detail-header .church-name-large i {
        color: #534AB7;
        margin-right: 8px;
    }
    
    .church-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.8rem;
    }
    
    .church-detail-item {
        background: var(--bg-tertiary);
        border-radius: 10px;
        padding: 0.8rem;
        text-align: center;
        border: 0.5px solid var(--border-color);
    }
    
    .church-detail-item .label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: var(--text-muted);
        font-weight: 600;
    }
    
    .church-detail-item .value {
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: 0.2rem;
    }
    
    .church-detail-item .value.income {
        color: #0F6E56;
    }
    
    .church-detail-item .value.expense {
        color: #A32D2D;
    }
    
    .church-detail-item .value.balance {
        color: #534AB7;
    }
    
    .category-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        margin-top: 0.5rem;
    }
    
    .category-tag {
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.65rem;
        border: 0.5px solid var(--border-color);
        background: var(--bg-tertiary);
        color: var(--text-muted);
    }
    
    .category-tag.income-tag {
        background: #E1F5EE;
        color: #0F6E56;
        border-color: rgba(15, 110, 86, 0.15);
    }
    
    .category-tag.expense-tag {
        background: #FCEBEB;
        color: #A32D2D;
        border-color: rgba(163, 45, 45, 0.15);
    }
    
    .chart-container {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .chart-container .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .chart-container .chart-header h6 {
        font-size: 0.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    
    .chart-container .chart-header h6 i {
        font-size: 0.85rem;
        color: #0F6E56;
    }
    
    .chart-legend {
        display: flex;
        gap: 16px;
        margin-bottom: 8px;
    }
    
    .leg-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    
    .leg-dot {
        width: 10px;
        height: 10px;
        border-radius: 2px;
    }
    
    .chart-box {
        height: 220px;
        position: relative;
    }
    
    .chart-box canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    .all-churches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }
    
    .church-mini-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 10px;
        padding: 0.9rem 1rem;
        transition: all 0.2s ease;
        cursor: default;
        position: relative;
    }
    
    .church-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        border-color: #534AB7;
    }
    
    .church-mini-card .church-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.2rem;
    }
    
    .church-mini-card .church-name i {
        color: #534AB7;
        margin-right: 6px;
    }
    
    .church-mini-card .mini-balance {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .church-mini-card .mini-balance.positive {
        color: #0F6E56;
    }
    
    .church-mini-card .mini-balance.negative {
        color: #A32D2D;
    }
    
    .church-mini-card .mini-details {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.3rem;
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .church-mini-card .mini-details span {
        background: var(--bg-tertiary);
        padding: 1px 8px;
        border-radius: 10px;
        border: 0.5px solid var(--border-color);
    }
    
    .church-mini-card .status-dot {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .church-mini-card .status-dot.surplus {
        background: #0F6E56;
    }
    
    .church-mini-card .status-dot.deficit {
        background: #A32D2D;
    }
    
    .btn-view-church {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 6px;
        background: #EEEDFE;
        color: #534AB7;
        font-size: 0.6rem;
        font-weight: 600;
        border: 0.5px solid rgba(83, 74, 183, 0.15);
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        margin-top: 6px;
    }
    
    .btn-view-church:hover {
        background: #534AB7;
        color: white;
        transform: translateY(-1px);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .finance-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .church-detail-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .all-churches-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .finance-stats-grid {
            grid-template-columns: 1fr;
        }
        .church-detail-grid {
            grid-template-columns: 1fr;
        }
        .all-churches-grid {
            grid-template-columns: 1fr;
        }
        .church-selector {
            flex-direction: column;
            align-items: stretch;
        }
        .church-selector select {
            width: 100%;
        }
        .church-selector .selected-church-info {
            margin-left: 0;
            text-align: center;
        }
        .chart-box {
            height: 180px;
        }
    }
</style>

<div class="container-fluid px-0">
 

    <!-- ============================================ -->
    <!-- STATS CARDS - ALWAYS SHOW ALL CHURCHES (Global) -->
    <!-- ============================================ -->
    <div class="finance-stats-grid">
        <div class="finance-stat-card">
            <div class="stat-icon income">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Income</div>
                <div class="stat-value positive">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
                <div class="stat-sub">All churches</div>
            </div>
        </div>
        <div class="finance-stat-card">
            <div class="stat-icon expense">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Expenses</div>
                <div class="stat-value negative">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
                <div class="stat-sub">All churches</div>
            </div>
        </div>
        <div class="finance-stat-card">
            <div class="stat-icon balance">
                <i class="fas fa-scale-balanced"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Overall Balance</div>
                <div class="stat-value {{ ($overallBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    ₱{{ number_format(abs($overallBalance ?? 0), 2) }}
                </div>
                <div class="stat-sub">{{ ($overallBalance ?? 0) >= 0 ? 'Surplus' : 'Deficit' }}</div>
            </div>
        </div>
        <div class="finance-stat-card">
            <div class="stat-icon churches">
                <i class="fas fa-church"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Churches</div>
                <div class="stat-value">{{ $churches->count() ?? 0 }}</div>
                <div class="stat-sub">Connected churches</div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- CHURCH SELECTOR -->
    <!-- ============================================ -->
    <div class="church-selector">
        <label for="churchSelect">
            <i class="fas fa-church"></i> Select Church:
        </label>
        <select id="churchSelect" onchange="window.location.href='{{ route('finance.index') }}?church=' + this.value">
            <option value="">-- Choose a Church --</option>
            @foreach($churches as $church)
                <option value="{{ $church->id }}" {{ ($selectedChurchId ?? '') == $church->id ? 'selected' : '' }}>
                    {{ $church->name }}
                </option>
            @endforeach
        </select>
        
        @if($selectedChurch)
            <div class="selected-church-info">
                <i class="fas fa-building"></i> Currently viewing: <strong>{{ $selectedChurch->name }}</strong>
            </div>
        @endif
    </div>

    @if($selectedChurch)
        <!-- ============================================ -->
        <!-- CHURCH DETAIL - FILTERED BY SELECTED CHURCH -->
        <!-- ============================================ -->
        <div class="church-detail-card">
            <div class="church-detail-header">
                <div class="church-name-large">
                    <i class="fas fa-church"></i> {{ $selectedChurch->name }}
                </div>
                <span style="font-size: 0.65rem; color: var(--text-muted); background: var(--bg-tertiary); padding: 3px 10px; border-radius: 20px; border: 0.5px solid var(--border-color);">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('F d, Y') }}
                </span>
            </div>
            
            <!-- CHURCH INCOME, EXPENSES, BALANCE (FILTERED BY CHURCH) -->
            <div class="church-detail-grid">
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-arrow-down" style="color: #0F6E56;"></i> Total Income</div>
                    <div class="value income">₱{{ number_format($churchIncome ?? 0, 2) }}</div>
                </div>
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-arrow-up" style="color: #A32D2D;"></i> Total Expenses</div>
                    <div class="value expense">₱{{ number_format($churchExpenses ?? 0, 2) }}</div>
                </div>
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-scale-balanced" style="color: #534AB7;"></i> Balance</div>
                    <div class="value balance" style="color: {{ ($churchBalance ?? 0) >= 0 ? '#0F6E56' : '#A32D2D' }}">
                        ₱{{ number_format(abs($churchBalance ?? 0), 2) }}
                        <span style="font-size: 0.65rem; font-weight: 600; display: block; color: var(--text-muted);">
                            {{ ($churchBalance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- CATEGORIES - FILTERED BY SELECTED CHURCH -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 0.8rem; padding-top: 0.8rem; border-top: 0.5px solid var(--border-color);">
                <div>
                    <div style="font-size: 0.6rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem;">
                        <i class="fas fa-tags" style="color: #0F6E56;"></i> Income Categories
                    </div>
                    <div class="category-tags">
                        @forelse($incomeTypes ?? [] as $type)
                            <span class="category-tag income-tag">
                                {{ $type->category ?? 'Uncategorized' }}: ₱{{ number_format($type->total, 2) }}
                            </span>
                        @empty
                            <span style="font-size: 0.7rem; color: var(--text-muted);">No income categories</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.6rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem;">
                        <i class="fas fa-tags" style="color: #A32D2D;"></i> Expense Categories
                    </div>
                    <div class="category-tags">
                        @forelse($expenseTypes ?? [] as $type)
                            <span class="category-tag expense-tag">
                                {{ $type->category ?? 'Uncategorized' }}: ₱{{ number_format($type->total, 2) }}
                            </span>
                        @empty
                            <span style="font-size: 0.7rem; color: var(--text-muted);">No expense categories</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART - FILTERED BY SELECTED CHURCH -->
        <div class="chart-container">
            <div class="chart-header">
                <h6>
                    <i class="fas fa-chart-line"></i> Monthly Income vs Expenses - {{ $selectedChurch->name }}
                </h6>
                <span style="font-size: 0.65rem; color: var(--text-muted);">Last 6 months</span>
            </div>
            <div class="chart-legend">
                <span class="leg-item">
                    <span class="leg-dot" style="background: #0F6E56;"></span> Income
                </span>
                <span class="leg-item">
                    <span class="leg-dot" style="background: #A32D2D; border: 1px dashed #A32D2D; background: none; width: 18px; height: 2px; border-radius: 0;"></span> Expenses
                </span>
            </div>
            <div class="chart-box">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    @else
        <!-- ============================================ -->
        <!-- ALL CHURCHES OVERVIEW (When No Church Selected) -->
        <!-- ============================================ -->
        <div style="margin-bottom: 1rem;">
            <p style="color: var(--text-muted); font-size: 0.8rem;">
                <i class="fas fa-info-circle"></i> Select a church above to view its detailed financial information.
            </p>
        </div>
        
        <div class="all-churches-grid">
            @foreach($churchBalances ?? [] as $data)
            <div class="church-mini-card">
                <div class="status-dot {{ $data['status'] }}"></div>
                <div class="church-name">
                    <i class="fas fa-church"></i> {{ $data['church']->name }}
                </div>
                <div class="mini-balance {{ $data['status'] == 'surplus' ? 'positive' : 'negative' }}">
                    ₱{{ number_format(abs($data['balance']), 2) }}
                    {{ $data['balance'] >= 0 ? '↑' : '↓' }}
                </div>
                <div class="mini-details">
                    <span><i class="fas fa-arrow-down" style="color: #0F6E56;"></i> ₱{{ number_format($data['income'], 2) }}</span>
                    <span><i class="fas fa-arrow-up" style="color: #A32D2D;"></i> ₱{{ number_format($data['expense'], 2) }}</span>
                </div>
                <a href="{{ route('finance.index') }}?church={{ $data['church']->id }}" class="btn-view-church">
                    <i class="fas fa-eye"></i> View Details
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // CHART - FILTERED BY SELECTED CHURCH
        const canvas = document.getElementById('financeChart');
        if (canvas) {
            let monthlyData = @json($monthlyData ?? []);
            let months = monthlyData.map(item => item.month);
            let incomeData = monthlyData.map(item => item.income);
            let expenseData = monthlyData.map(item => item.expense);

            if (!Array.isArray(months) || months.length === 0) {
                months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                incomeData = [0, 0, 0, 0, 0, 0];
                expenseData = [0, 0, 0, 0, 0, 0];
            }

            while (incomeData.length < months.length) incomeData.push(0);
            while (expenseData.length < months.length) expenseData.push(0);

            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
            const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';
            const ttBg = isDark ? '#2a2a2a' : '#ffffff';
            const ttTitle = isDark ? '#e0e0e0' : '#1e293b';
            const ttBody = isDark ? '#aaaaaa' : '#475569';
            const ttBorder = isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0';
            const ptBorder = isDark ? '#1e1e1e' : '#ffffff';

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Income',
                            data: incomeData,
                            borderColor: '#0F6E56',
                            backgroundColor: 'rgba(15, 110, 86, 0.07)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#0F6E56',
                            pointBorderColor: ptBorder,
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#0F6E56',
                            pointHoverBorderColor: ptBorder,
                            pointHoverBorderWidth: 2
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: '#A32D2D',
                            backgroundColor: 'rgba(163, 45, 45, 0.05)',
                            borderWidth: 2,
                            borderDash: [5, 3],
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#A32D2D',
                            pointBorderColor: ptBorder,
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#A32D2D',
                            pointHoverBorderColor: ptBorder,
                            pointHoverBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: ttBg,
                            titleColor: ttTitle,
                            bodyColor: ttBody,
                            borderColor: ttBorder,
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.dataset.label + ': ₱' + ctx.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                },
                                font: { size: 10 },
                                color: tickColor
                            },
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 10 },
                                color: tickColor
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }
    });
</script>
@endsection