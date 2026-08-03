<x-layouts.main.website>
    <x-slot:title>
        Laboratoriya Dashboard
    </x-slot:title>
    
    <style>
        /* ============================================= */
        /* DASHBOARD STYLES */
        /* ============================================= */

        .search-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid #e9ecef;
            margin-bottom: 0;
        }

        .search-card-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .search-card h4 {
            color: #1a2332;
            font-weight: 700;
            margin: 0;
            font-size: 20px;
        }

        .dashboard-date {
            color: #495057;
            font-size: 13px;
            background: #f8f9fa;
            padding: 8px 18px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            font-weight: 500;
            display: inline-block;
            white-space: nowrap;
        }

        .dashboard-wrapper {
            padding: 0 0 60px;
            background: #f0f2f5;
            min-height: 100vh;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0px auto;
            padding: 10px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-color: #0dcaf0;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-left: 0;
        }

        .stat-icon i {
            font-size: 14px;
            color: #ffffff;
        }

        .stat-icon.bg-primary { background: linear-gradient(135deg, #0dcaf0, #0aadcc); }
        .stat-icon.bg-info { background: linear-gradient(135deg, #0d6efd, #0a5cdb); }
        .stat-icon.bg-warning { background: linear-gradient(135deg, #ffc107, #e0a800); }
        .stat-icon.bg-success { background: linear-gradient(135deg, #198754, #157347); }
        .stat-icon.bg-danger { background: linear-gradient(135deg, #dc3545, #c82333); }
        .stat-icon.bg-secondary { background: linear-gradient(135deg, #6c757d, #5a6268); }

        .stat-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
            color: #1a2332;
            margin: 0;
            line-height: 1.2;
        }

        .stat-label {
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .dashboard-grid-appointments {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .dashboard-grid-medicine {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            border: 1px solid #e9ecef;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .dashboard-card-header {
            padding: 18px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafbfc;
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .card-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .card-icon {
            color: #0dcaf0;
            font-size: 15px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: #1a2332;
            margin: 0;
        }

        .badge {
            font-weight: 500;
            padding: 4px 10px;
            font-size: 10px;
            border-radius: 20px;
        }

        .badge.bg-primary { background: #0dcaf0 !important; color: #fff; }
        .badge.bg-success { background: #198754 !important; color: #fff; }
        .badge.bg-danger { background: #dc3545 !important; color: #fff; }
        .badge.bg-warning { background: #ffc107 !important; color: #fff; }
        .badge.bg-info { background: #0d6efd !important; color: #fff; }
        .badge.bg-secondary { background: #6c757d !important; color: #fff; }

        .btn-outline-primary {
            color: #0dcaf0;
            border-color: #0dcaf0;
            font-size: 11px;
            padding: 3px 12px;
            border-radius: 6px;
            background: transparent;
            border: 1px solid #0dcaf0;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #0dcaf0;
            color: #fff;
        }

        .dashboard-card-body {
            padding: 14px 18px;
        }

        .dashboard-card-body.p-0 {
            padding: 0;
        }

        /* Table */
        .table-appointments {
            margin: 0;
            width: 100%;
            border-collapse: collapse;
        }

        .table-appointments thead th {
            font-weight: 600;
            color: #6c757d;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 14px;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
            background: #fafbfc;
            text-align: left;
        }

        .table-appointments tbody td {
            font-size: 13px;
            color: #1a2332;
            padding: 10px 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
        }

        .table-appointments tbody tr:hover {
            background: #f8f9fa;
        }

        .table-appointments tbody tr:last-child td {
            border-bottom: none;
        }

        .appointment-time {
            font-weight: 600;
            color: #1a2332;
        }

        .patient-name, .doctor-name {
            font-weight: 500;
        }

        /* View Icon */
        .view-icon {
            font-size: 20px;
            color: #0dcaf0;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .view-icon:hover {
            color: #0aadcc;
            transform: scale(1.1);
        }

        .text-end {
            text-align: right !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .table-appointments thead th.text-end,
        .table-appointments tbody td.text-end {
            text-align: right !important;
        }

        /* ===== CALENDAR STYLES ===== */
        .calendar-wrapper {
            padding: 10px 0;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .calendar-header .month-year {
            font-size: 16px;
            font-weight: 600;
            color: #1a2332;
        }

        .calendar-header .nav-btn {
            background: none;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 4px 12px;
            cursor: pointer;
            font-size: 16px;
            color: #495057;
            transition: all 0.3s ease;
        }

        .calendar-header .nav-btn:hover {
            background: #0dcaf0;
            color: #fff;
            border-color: #0dcaf0;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            text-align: center;
        }

        .calendar-grid .day-name {
            font-size: 11px;
            font-weight: 600;
            color: #6c757d;
            padding: 6px 0;
            text-transform: uppercase;
        }

        .calendar-grid .day-cell {
            padding: 8px 0;
            font-size: 13px;
            font-weight: 500;
            color: #1a2332;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .calendar-grid .day-cell:hover {
            background: #e9ecef;
        }

        .calendar-grid .day-cell.other-month {
            color: #adb5bd;
        }

        .calendar-grid .day-cell.today {
            background: #0dcaf0;
            color: #ffffff;
            font-weight: 700;
        }

        .calendar-grid .day-cell.today:hover {
            background: #0aadcc;
        }

        .calendar-grid .day-cell.selected {
            background: #0d6efd;
            color: #ffffff;
            font-weight: 700;
        }

        .calendar-grid .day-cell.selected:hover {
            background: #0a5cdb;
        }

        .calendar-grid .day-cell.has-requests {
            position: relative;
        }

        .calendar-grid .day-cell.has-requests::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #0dcaf0;
        }

        .calendar-grid .day-cell.today.has-requests::after {
            background: #ffffff;
        }

        .calendar-grid .day-cell.selected.has-requests::after {
            background: #ffffff;
        }

        /* Status List */
        .status-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-info {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 130px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .status-name {
            font-size: 13px;
            color: #1a2332;
            font-weight: 500;
        }

        .status-bar {
            flex: 1;
            height: 6px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }

        .status-bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 1s ease;
        }

        .status-percent {
            font-size: 13px;
            font-weight: 600;
            color: #1a2332;
            min-width: 35px;
            text-align: right;
        }

        /* Medicine List */
        .medicine-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .medicine-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .medicine-item:hover {
            background: #e9ecef;
        }

        .medicine-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .medicine-name {
            font-size: 13px;
            font-weight: 500;
            color: #1a2332;
        }

        .medicine-stock {
            font-size: 11px;
            color: #6c757d;
        }

        .medicine-stock i {
            margin-right: 3px;
        }

        .medicine-sold {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .medicine-count {
            font-size: 15px;
            font-weight: 700;
            color: #198754;
        }

        .medicine-label {
            font-size: 10px;
            color: #6c757d;
            text-transform: uppercase;
        }

        .medicine-revenue {
            font-size: 12px;
            font-weight: 600;
            color: #0dcaf0;
            background: #e3f9ff;
            padding: 3px 10px;
            border-radius: 4px;
        }

        /* Chart Container */
        .chart-container {
            width: 100%;
            height: 180px;
        }

        .chart-container-donut {
            width: 100%;
            height: 220px;
        }

        /* Test Stats */
        .test-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .test-stat-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        .test-stat-item .test-name {
            font-weight: 600;
            font-size: 12px;
            color: #1a2332;
        }

        .test-stat-item .test-count {
            font-size: 20px;
            font-weight: 700;
            color: #0dcaf0;
        }

        .test-stat-item .test-percent {
            font-size: 11px;
            color: #6c757d;
        }

        /* Donut Chart 2 column legend */
        .donut-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .donut-chart-wrap {
            flex: 1;
            min-height: 200px;
        }

        .donut-legend-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 20px;
            margin-top: 10px;
            padding: 0 5px;
        }

        .donut-legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #1a2332;
        }

        .donut-legend-item .color-box {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        /* ============================================= */
        /* RESPONSIVE */
        /* ============================================= */

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .dashboard-grid-appointments {
                grid-template-columns: 1fr;
            }
            .dashboard-grid-medicine {
                grid-template-columns: 1fr;
            }
            .test-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .stat-number {
                font-size: 20px;
            }
            .stat-label {
                font-size: 11px;
            }
            .card-title {
                font-size: 14px;
            }
            .table-appointments tbody td {
                font-size: 13px;
            }
            .status-name {
                font-size: 13px;
            }
            .status-percent {
                font-size: 13px;
            }
            .medicine-name {
                font-size: 13px;
            }
            .medicine-count {
                font-size: 15px;
            }
            .badge {
                font-size: 10px;
            }
            .btn-outline-primary {
                font-size: 11px;
            }
            .dashboard-date {
                font-size: 13px;
            }
            .search-card h4 {
                font-size: 20px;
            }
        }

        @media (max-width: 768px) {
            .search-card {
                padding: 14px 18px;
            }
            .search-card-inner {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
            }
            .search-card h4 {
                font-size: 18px;
            }
            .dashboard-wrapper {
                padding: 0 0 30px;
            }
            .dashboard-container {
                padding: 5px;
                max-width: 100%;
                width: 96%;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            .stat-card {
                padding: 12px 14px;
                gap: 12px;
            }
            .stat-icon {
                width: 40px;
                height: 40px;
            }
            .stat-icon i {
                font-size: 17px;
            }
            .stat-number {
                font-size: 18px;
            }
            .stat-label {
                font-size: 10px;
            }
            .dashboard-date {
                font-size: 12px;
                padding: 5px 12px;
            }
            .dashboard-card-header {
                padding: 14px;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
                flex-wrap: wrap;
                gap: 6px;
            }
            .card-header-left {
                flex-shrink: 0;
            }
            .card-header-right {
                flex-shrink: 0;
                width: auto !important;
                justify-content: flex-end !important;
            }
            .dashboard-card-body {
                padding: 10px 14px;
            }
            .card-title {
                font-size: 13px;
            }
            .table-appointments thead th {
                font-size: 9px;
                padding: 8px 10px;
            }
            .table-appointments tbody td {
                font-size: 12px;
                padding: 8px 10px;
            }
            .status-info {
                min-width: 100px;
            }
            .status-name {
                font-size: 12px;
            }
            .status-percent {
                font-size: 12px;
                min-width: 30px;
            }
            .medicine-name {
                font-size: 12px;
            }
            .medicine-count {
                font-size: 14px;
            }
            .medicine-revenue {
                font-size: 11px;
                padding: 2px 8px;
            }
            .chart-container {
                height: 140px;
            }
            .chart-container-donut {
                height: 180px;
            }
            .badge {
                font-size: 9px;
                padding: 3px 8px;
            }
            .btn-outline-primary {
                font-size: 10px;
                padding: 2px 10px;
            }
            .view-icon {
                font-size: 18px;
            }
            .test-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .calendar-grid .day-cell {
                padding: 6px 0;
                font-size: 12px;
            }
            .donut-legend-grid {
                grid-template-columns: 1fr 1fr;
                gap: 3px 15px;
            }
            .donut-legend-item {
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .search-card {
                padding: 10px 14px;
            }
            .search-card-inner {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 8px;
            }
            .search-card h4 {
                font-size: 16px;
            }
            .stats-grid {
                grid-template-columns: 1fr 1fr 1fr;
                gap: 8px;
            }
            .stat-card {
                padding: 10px 12px;
                gap: 10px;
            }
            .stat-icon {
                width: 36px;
                height: 36px;
            }
            .stat-icon i {
                font-size: 15px;
            }
            .stat-number {
                font-size: 16px;
            }
            .stat-label {
                font-size: 9px;
            }
            .dashboard-date {
                font-size: 9px;
                padding: 4px 10px;
                white-space: nowrap;
            }
            .dashboard-card-header {
                padding: 12px;
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
                flex-wrap: wrap;
                gap: 4px;
            }
            .card-header-left {
                flex-shrink: 0;
            }
            .card-header-right {
                flex-shrink: 0;
                width: auto !important;
                justify-content: flex-end !important;
            }
            .badge {
                font-size: 9px;
                padding: 4px 6px;
            }
            .btn-outline-primary {
                font-size: 9px;
                padding: 2px 6px;
            }
            .chart-container {
                height: 120px;
            }
            .chart-container-donut {
                height: 150px;
            }
            .medicine-revenue {
                font-size: 10px;
                padding: 2px 6px;
            }
            .medicine-sold {
                gap: 5px;
            }
            .medicine-count {
                font-size: 13px;
            }
            .medicine-name {
                font-size: 11px;
            }
            .medicine-stock {
                font-size: 10px;
            }
            .status-name {
                font-size: 11px;
            }
            .status-percent {
                font-size: 11px;
                min-width: 25px;
            }
            .status-info {
                min-width: 80px;
            }
            .table-appointments tbody td {
                font-size: 11px;
                padding: 6px 8px;
            }
            .table-appointments thead th {
                font-size: 9px;
                padding: 6px 8px;
            }
            .card-title {
                font-size: 12px;
            }
            .card-icon {
                font-size: 14px;
            }
            .view-icon {
                font-size: 16px;
            }
            .test-stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            .calendar-grid .day-cell {
                padding: 4px 0;
                font-size: 11px;
            }
            .donut-legend-grid {
                grid-template-columns: 1fr 1fr;
                gap: 2px 10px;
            }
            .donut-legend-item {
                font-size: 9px;
            }
            .donut-legend-item .color-box {
                width: 8px;
                height: 8px;
            }
        }
    </style>

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>  
            </ol>
        </nav>

        <div class="search-card">
            <div class="search-card-inner">
                <h4 class="mb-0">Laboratoriya Dashboard</h4>
                <div class="dashboard-date">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{ now()->format('l, F d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-wrapper">
        <div class="dashboard-container">
            <!-- 1-QATOR: Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-flask"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $laboratoryTotalTests ?? 0 }}</h3>
                        <p class="stat-label">Jami Tahlillar</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $laboratoryCompletedTests ?? 0 }}</h3>
                        <p class="stat-label">Bajarilgan</p>  
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $laboratoryPendingTests ?? 0 }}</h3>
                        <p class="stat-label">Kutilmoqda</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $laboratoryUrgentTests ?? 0 }}</h3>
                        <p class="stat-label">Shoshilinch</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $laboratoryTotalPatients ?? 0 }}</h3>
                        <p class="stat-label">Bemorlar</p> 
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon bg-secondary">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $laboratoryTotalDoctors ?? 0 }}</h3>
                        <p class="stat-label">Shifokorlar</p> 
                    </div>
                </div>
            </div>

            <!-- 2-QATOR: Jadval + Kalendar -->
            <div class="dashboard-grid">
                <!-- Laboratory Requests Table -->
                <div class="dashboard-card card-appointments">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-vial card-icon"></i>
                            <h5 class="card-title">Laboratoriya So'rovlari</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary" id="requestCount">0</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Barchasi</a>
                        </div>
                    </div>
                    <div class="dashboard-card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-appointments" id="requestsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Bemor</th>
                                        <th style="width: 18%;">Tahlil</th>
                                        <th style="width: 15%;">Shifokor</th>
                                        <th style="width: 10%;">Muhimlik</th>
                                        <th style="width: 12%;">Holati</th>
                                        <th style="width: 12%;">So'ralgan</th>
                                        <th style="width: 8%;" class="text-end">Amal</th>
                                    </tr>
                                </thead>
                                <tbody id="requestsTableBody">
                                    @forelse($laboratoryRequests ?? [] as $request)
                                        <tr data-date="{{ $laboratorySelectedDate->format('Y-m-d') ?? now()->format('Y-m-d') }}">
                                            <td>{{ $request['id'] }}</td>
                                            <td>
                                                <span class="patient-name">{{ $request['patient'] }}</span>
                                                <br><small class="text-muted">ID: {{ $request['patient_id'] }}</small>
                                            </td>
                                            <td>{{ $request['test'] }}</td>
                                            <td>{{ $request['doctor'] }}</td>
                                            <td><span class="badge {{ $request['priority_config']['badge'] }}">{{ $request['priority_config']['text'] }}</span></td>
                                            <td><span class="badge {{ $request['status_config']['badge'] }}">{{ $request['status_config']['text'] }}</span></td>
                                            <td>{{ $request['requested_at'] }}</td>
                                            <td class="text-end">
                                                <a href="#" class="text-primary view-icon">
                                                    <i class="fa-regular fa-circle-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="fas fa-info-circle"></i> So'rovlar mavjud emas
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-calendar-alt card-icon"></i>
                            <h5 class="card-title">Kalendar</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary" id="calendarCount">0</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="calendar-wrapper">
                            <div class="calendar-header">
                                <button class="nav-btn" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                                <span class="month-year" id="currentMonthYear"></span>
                                <button class="nav-btn" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                            </div>
                            <div class="calendar-grid" id="calendarGrid">
                                <!-- Dinamik yuklanadi -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3-QATOR: Bajarilgan Tahlillar Charti + Test turlari statistikasi -->
            <div class="dashboard-grid-appointments">
                <!-- Chart -->
                <div class="dashboard-card card-chart">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-bar card-icon"></i>
                            <h5 class="card-title">Bajarilgan Tahlillar (Oxirgi 10 Kun)</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-success" id="totalCompletedBadge">0</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="chart-container">
                            <canvas id="completedTestsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Test turlari bo'yicha statistik -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-flask card-icon"></i>
                            <h5 class="card-title">Tahlil Turlari Bo'yicha</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary">{{ count($laboratoryTestCategories ?? []) }} tur</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="test-stats-grid">
                            @forelse($laboratoryTestCategories ?? [] as $category)
                                <div class="test-stat-item">
                                    <div class="test-name">{{ $category['name'] }}</div>
                                    <div class="test-count">{{ $category['count'] }}</div>
                                    <div class="test-percent">{{ $category['percentage'] }}%</div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4 col-span-3">
                                    <i class="fas fa-info-circle"></i> Ma'lumot mavjud emas
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4-QATOR: So'nggi natijalar + Eng ko'p buyurilgan testlar (Donut Chart) -->
            <div class="dashboard-grid-medicine">
                <!-- Recent Completed Results -->
                <div class="dashboard-card card-medicines">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-file-medical-alt card-icon"></i>
                            <h5 class="card-title">So'nggi Bajarilgan Natijalar</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-success">{{ count($laboratoryRecentResults ?? []) }} Yangi</span>
                            <a href="#" class="btn btn-sm btn-outline-primary">Barchasi</a>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="medicine-list">
                            @forelse($laboratoryRecentResults ?? [] as $result)
                                <div class="medicine-item">
                                    <div class="medicine-info">
                                        <span class="medicine-name"><strong>{{ $result['patient'] }}</strong></span>
                                        <span class="medicine-stock"><i class="fas fa-flask"></i> {{ $result['test'] }}</span>
                                    </div>
                                    <div class="medicine-sold">
                                        <span class="medicine-count">{{ $result['time'] }}</span>
                                        <span class="badge bg-success">Bajarildi</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle"></i> Natijalar mavjud emas
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Eng ko'p buyurilgan testlar (Donut Chart) -->
                <div class="dashboard-card">
                    <div class="dashboard-card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-pie card-icon"></i>
                            <h5 class="card-title">Eng Ko'p Buyurilgan Testlar</h5>
                        </div>
                        <div class="card-header-right">
                            <span class="badge bg-primary">{{ count($laboratoryTopTests ?? []) }} tur</span>
                        </div>
                    </div>
                    <div class="dashboard-card-body">
                        <div class="donut-wrapper">
                            <div class="donut-chart-wrap">
                                <canvas id="donutChart"></canvas>
                            </div>
                            <div class="donut-legend-grid" id="donutLegend">
                                <!-- Dinamik yuklanadi -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Bajarilgan tahlillar charti (Oxirgi 10 kun)
        const completedData = @json($laboratoryCompletedLast7Days ?? []);
        
        // 10 kunlik ma'lumot yaratish
        let chartLabels = [];
        let chartCounts = [];
        
        for (let i = 9; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            
            // 27 Jul uslubida formatlash
            const day = date.getDate();
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const month = monthNames[date.getMonth()];
            const label = day + ' ' + month;
            
            // Agar bor bo'lsa, mavjud ma'lumotni olish
            let count = 0;
            if (completedData.length > 0) {
                const found = completedData.find(item => {
                    const itemParts = item.day.split(' ');
                    const itemDay = parseInt(itemParts[0]);
                    const itemMonth = itemParts[1] ? itemParts[1] : '';
                    return itemDay === day && itemMonth === month;
                });
                if (found) {
                    count = found.count;
                }
            }
            
            chartLabels.push(label);
            chartCounts.push(count);
        }

        // Jami sonni hisoblash
        const totalCompleted = chartCounts.reduce((a, b) => a + b, 0);
        document.getElementById('totalCompletedBadge').textContent = totalCompleted;

        const ctx = document.getElementById('completedTestsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Bajarilgan tahlillar',
                    data: chartCounts,
                    backgroundColor: 'rgba(13, 202, 240, 0.7)',
                    borderColor: 'rgba(13, 202, 240, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11 } },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });

        // 2. Donut Chart (Eng ko'p buyurilgan testlar)
        const topTests = @json($laboratoryTopTests ?? []);
        const donutLabels = topTests.map(item => item.name);
        const donutData = topTests.map(item => item.count);
        const donutColors = topTests.map(item => item.color);

        const donutCtx = document.getElementById('donutChart').getContext('2d');
        
        // Legendni 2 ustunda ko'rsatish uchun
        const legendContainer = document.getElementById('donutLegend');
        if (topTests.length > 0) {
            let legendHtml = '';
            topTests.forEach(item => {
                legendHtml += `
                    <div class="donut-legend-item">
                        <span class="color-box" style="background: ${item.color}"></span>
                        ${item.name} (${item.count})
                    </div>
                `;
            });
            legendContainer.innerHTML = legendHtml;
        } else {
            legendContainer.innerHTML = '<div class="text-center text-muted py-2 col-span-2">Ma\'lumot mavjud emas</div>';
        }

        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: donutLabels.length ? donutLabels : ['Ma\'lumot yo\'q'],
                datasets: [{
                    data: donutData.length ? donutData : [1],
                    backgroundColor: donutColors.length ? donutColors : ['#6c757d'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '65%'
            }
        });

        // 3. Kalendar
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // So'rov bor kunlar
        const requestDates = @json($laboratoryRequestDates ?? []);

        // Locale bo'yicha oy va kun nomlari
        const locale = '{{ app()->getLocale() }}';
        const monthNamesLocale = locale === 'uz' 
            ? ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentyabr', 'Oktyabr', 'Noyabr', 'Dekabr']
            : locale === 'ru' 
                ? ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь']
                : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        const dayNamesLocale = locale === 'uz'
            ? ['Dush', 'Sesh', 'Chor', 'Pay', 'Juma', 'Shan', 'Yak']
            : locale === 'ru'
                ? ['Пнд', 'Втр', 'Срд', 'Чтв', 'Птн', 'Сбт', 'Вск']
                : ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        function renderCalendar(month, year) {
            const grid = document.getElementById('calendarGrid');
            const monthYear = document.getElementById('currentMonthYear');
            
            monthYear.textContent = monthNamesLocale[month] + ' ' + year;

            const firstDay = new Date(year, month, 1).getDay();
            let startDay = firstDay === 0 ? 6 : firstDay - 1;

            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();

            let html = '';

            dayNamesLocale.forEach(day => {
                html += `<div class="day-name">${day}</div>`;
            });

            for (let i = startDay - 1; i >= 0; i--) {
                const day = daysInPrevMonth - i;
                html += `<div class="day-cell other-month">${day}</div>`;
            }

            const todayStr = new Date().toISOString().split('T')[0];

            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const isToday = dateStr === todayStr;
                const hasRequest = requestDates.includes(dateStr);
                const isSelected = dateStr === @json($laboratorySelectedDate->format('Y-m-d') ?? now()->format('Y-m-d'));

                let classes = 'day-cell';
                if (isToday) classes += ' today';
                if (isSelected) classes += ' selected';
                if (hasRequest) classes += ' has-requests';

                html += `<div class="${classes}" data-date="${dateStr}" onclick="selectDate('${dateStr}')">${day}</div>`;
            }

            const totalCells = startDay + daysInMonth;
            const remaining = (7 - (totalCells % 7)) % 7;
            for (let day = 1; day <= remaining; day++) {
                html += `<div class="day-cell other-month">${day}</div>`;
            }

            grid.innerHTML = html;

            const count = requestDates.filter(d => d.startsWith(`${year}-${String(month + 1).padStart(2, '0')}`)).length;
            document.getElementById('calendarCount').textContent = count;
        }

        window.selectDate = function(dateStr) {
            const url = new URL(window.location.href);
            url.searchParams.set('date', dateStr);
            window.location.href = url.toString();
        };

        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });

        renderCalendar(currentMonth, currentYear);

        // 4. Jadvaldagi so'rovlar sonini yangilash
        function updateRequestCount() {
            const rows = document.querySelectorAll('#requestsTableBody tr');
            let count = 0;
            rows.forEach(row => {
                if (row.style.display !== 'none' && !row.classList.contains('text-center')) {
                    count++;
                }
            });
            document.getElementById('requestCount').textContent = count;
        }

        // Boshlang'ich qiymat
        setTimeout(updateRequestCount, 100);
    });
</script>

</x-layouts.main.website>