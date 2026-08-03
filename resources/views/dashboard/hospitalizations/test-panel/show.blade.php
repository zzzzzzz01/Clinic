<x-layouts.main.website>
    <x-slot:title>
    Test Panel Natijalari - {{ $data['panelName'] }}
    </x-slot:title>

    <link rel="stylesheet" href="{{ asset('temp2/css/suppliers.css') }}" />

    <!-- <style>
        :root {
            --primary-color: #00BFFF;
            --primary-dark: #0099CC;
            --secondary-color: #2ecc71;
            --secondary-dark: #27ae60;
            --danger-color: #e74c3c;
            --danger-dark: #c0392b;
            --warning-color: #f39c12;
            --warning-dark: #e67e22;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --gray-color: #95a5a6;
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            color: #333;
            min-height: 100vh;
            transition: var(--transition);
        }
        
        .main-content {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: var(--light-color);
            color: var(--dark-color);
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            margin-bottom: 20px;
            text-decoration: none;
        }
        
        .back-btn:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }
        
        .panel-header-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            padding: 25px;
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .panel-title {
            font-size: 24px;
            color: var(--dark-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .panel-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
            padding: 15px;
            background: var(--light-color);
            border-radius: 8px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            color: var(--gray-color);
            font-size: 12px;
            margin-bottom: 4px;
            font-weight: 500;
        }
        
        .info-value {
            color: var(--dark-color);
            font-weight: 600;
            font-size: 14px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-in-progress {
            background-color: #cce5ff;
            color: #004085;
        }
        
        /* TEST NATIJALARI JADVALI - YANGI DIZAYN */
        .test-results-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .results-header {
            padding: 18px 20px;
            background: var(--light-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .results-header h3 {
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            margin: 0;
        }

        .test-count {
            background: var(--primary-color);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .results-body {
            padding: 0;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .results-table th {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
            font-weight: 600;
            position: relative;
            cursor: pointer;
            user-select: none;
        }

        .results-table th:hover {
            background-color: var(--primary-dark);
        }

        .results-table th i {
            margin-left: 5px;
            font-size: 12px;
            opacity: 0.7;
        }

        .results-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            white-space: nowrap;
        }

        .results-table tbody tr {
            transition: var(--transition);
        }

        .results-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .result-value {
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .result-unit {
            font-weight: normal;
            color: var(--gray-color);
            font-size: 12px;
        }

        .normal-range {
            font-size: 12px;
            color: var(--gray-color);
            margin-top: 4px;
        }

        .result-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            min-width: 80px;
            text-align: center;
            display: inline-block;
        }

        .status-normal {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--secondary-dark);
        }

        .status-low {
            background-color: rgba(243, 156, 18, 0.2);
            color: var(--warning-dark);
        }

        .status-high {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger-dark);
        }

        .status-pending {
            background-color: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }
        
        .actions-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            padding: 20px;
            background: var(--light-color);
            border-radius: var(--border-radius);
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 191, 255, 0.2);
        }
        
        .btn-success {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .btn-success:hover {
            background-color: var(--secondary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(46, 204, 113, 0.2);
        }
        
        .btn-info {
            background-color: var(--info-color);
            color: white;
        }
        
        .btn-info:hover {
            background-color: #138496;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(23, 162, 184, 0.2);
        }
        
        .btn-outline {
            background: white;
            color: var(--dark-color);
            border: 1px solid #ddd;
            padding: 10px 20px;
        }
        
        .btn-outline:hover {
            background: #f8f9fa;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray-color);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.3;
        }
        
        .empty-state h4 {
            font-size: 16px;
            margin-bottom: 8px;
            color: var(--dark-color);
        }
        
        .empty-state p {
            margin-bottom: 15px;
            max-width: 350px;
            margin-left: auto;
            margin-right: auto;
            font-size: 14px;
        }
        
        /* Print styles */
        @media print {
            .back-btn,
            .actions-container {
                display: none;
            }
            
            .panel-header-card,
            .test-results-container {
                box-shadow: none;
                border: 1px solid #ddd;
            }
            
            body {
                background: white;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }
            
            .panel-title {
                font-size: 20px;
            }
            
            .results-table {
                display: block;
                overflow-x: auto;
            }
            
            .results-table th,
            .results-table td {
                padding: 10px;
                font-size: 13px;
            }
            
            .panel-info {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .actions-container {
                flex-direction: column;
                padding: 15px;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
                padding: 10px 20px;
            }
        }
        
        @media (max-width: 480px) {
            .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .panel-title {
                font-size: 18px;
            }
            
            .results-header {
                padding: 15px;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style> -->

    <div class="container pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="fas fa-home"></i> Asosiy sahifa
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('hospitalizations.index') }}">
                        Statsional bemorlar
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('hospitalizations.show', $hospitalization) }}">
                    {{ $hospitalization->appointment->patient->user->name }} {{ $hospitalization->appointment->patient->user->last_name }}
                    </a>
                </li>
                <li class="breadcrumb-item active" style="margin-top: 3px;">
                    Test natijalari ( {{ $data['panelName'] }} )
                </li>
            </ol>
        </nav>

        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">{{ $hospitalization->appointment->patient->user->name }} {{ $hospitalization->appointment->patient->user->last_name }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>  

    <div class="container">

        {{-- HEADER --}}
        <div class="info-section">

            <div class="section-header-test"> 
                <h3>{{ $data['panelName'] }} ({{ count($data['results']) }} ta test)</h3>

                <span class="status-badge"
                    style="
                        color: {{ $data['status']['color'] }};
                        background-color: {{ $data['status']['bg_color'] }};
                    ">
                    <i class="{{ $data['status']['icon'] }}"></i>
                    {{ $data['status']['text'] }}
                </span>
            </div>

            {{-- INFO --}}
            <style>
                .info-result-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 16px;
                }
                
                .info-result-row {
                    display: flex;
                    flex-direction: column;
                    gap: 4px;
                }
                
                .info-result-label {
                    font-weight: 600;
                    color: #4a5568;
                    font-size: 14px;
                    display: flex;
                    align-items: center;
                    flex-shrink: 0;
                }
                
                .info-result-value {
                    color: #1a202c;
                    font-size: 14px;
                    font-weight: 500; 
                    align-items: center;
                    gap: 10px;
                    flex-wrap: wrap; 
                    flex: 1; 
                }
                
                /* Mobile ekran uchun */
                @media (max-width: 768px) {
                    .info-result-grid {
                        grid-template-columns: 1fr;
                        gap: 12px;
                    }
                }

                @media (max-width: 576px) {
                    .info-result-row {
                        display: flex;
                        justify-content: space-between;
                        flex-direction: row;
                        border-bottom: 1px solid #e2e8f0;
                        padding: 6px 0;
                    }

                    .info-result-value {
                        display: flex;
                        justify-content: flex-end;
                    }
                }
            </style>

            <div class="info-result-grid">
                <div class="info-result-row">
                    <span class="info-result-label">Test Panel Kodi:</span>
                    <span class="info-result-value">{{ $data['panelCode'] }}</span>
                </div>

                <div class="info-result-row">
                    <span class="info-result-label">Buyurtma Sana:</span>
                    <span class="info-result-value">{{ $data['orderedAt'] }}</span>
                </div>

                <div class="info-result-row">
                    <span class="info-result-label">Buyurtma Qilgan:</span>
                    <span class="info-result-value">{{ $data['doctorName'] }}</span>
                </div>

                <div class="info-result-row">
                    <span class="info-result-label">Bemor:</span>
                    <span class="info-result-value">{{ $data['patientName'] }}</span>
                </div>
            </div>
        </div>

        {{-- RESULTS --}}
        <div class="test-results-container"> 
            <div class="table-header">
                <div class="table-actions"></div>
            </div>

            <div class="results-body">

                @if(count($data['results']) > 0)

                <table class="results-table">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Nomi</th>
                            <th>Natija</th>
                            <th>Norma</th>
                            <th>Birlik</th>
                            <th>Holat</th>
                            <th>Izoh</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data['results'] as $result)

                        <tr>
                            <td>
                                <div class="" style="font-weight:600;">
                                    {{ $result['test_name'] }}
                                </div>
                                <div class="login-display" style="text-align: left;">
                                    Kod: {{ $result['test_code'] }}
                                </div>
                            </td>

                            <td>
                                <div class="hire-day">
                                    {{ $result['value'] ?? '—' }} 
                                </div>
                            </td>

                            <td>
                                @if($result['min'] !== null && $result['max'] !== null)
                                    <div class="hire-day">
                                        {{ $result['min'] }} - {{ $result['max'] }}
                                    </div>
                                @else
                                    <span style="color:#95a5a6;">—</span>
                                @endif
                            </td>

                            <td>
                                <span class="hire-day">
                                    {{ $result['unit'] ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="status-badge" style=" color: {{ $result['status_color'] }};
                                        background-color: {{ $result['status_bg_color'] }};">
                                    <i class="{{ $result['status_icon'] }}"></i>
                                    {{ $result['status_text'] }}
                                </span>
                            </td>

                            <td>
                                <span style="font-size:12px; color:#95a5a6;">
                                    {{ $result['notes'] ?? '—' }}
                                </span>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

                @else
                    <div class="empty-state">
                        <i class="fas fa-vial"></i>
                        <h4>Natijalar topilmadi</h4>
                        <p>Bu test paneli uchun hali natijalar kiritilmagan.</p>
                    </div>
                @endif

            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="submit-section">
            <div class="submit-actions">
                <button class="btn-primary" onclick="window.print()">
                    Chop etish
                </button>

                <button class="btn-success">
                     Yuklab olish
                </button>
            </div>
        </div> 

    </div>
    
    <script>
        // Jadval sort funksiyasi
        document.addEventListener('DOMContentLoaded', function() {
            const headers = document.querySelectorAll('.results-table th[data-sort]');
            let currentSort = { column: null, direction: 'asc' };
            
            headers.forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.getAttribute('data-sort');
                    let direction = 'asc';
                    
                    if (currentSort.column === column) {
                        direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                    }
                    
                    sortTable(column, direction);
                    currentSort = { column, direction };
                    
                    // Icon larni yangilash
                    headers.forEach(h => {
                        const icon = h.querySelector('i');
                        if (h === this) {
                            icon.className = direction === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down';
                        } else {
                            icon.className = 'fas fa-sort';
                        }
                    });
                });
            });
            
            function sortTable(column, direction) {
                const table = document.querySelector('.results-table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                rows.sort((a, b) => {
                    let aValue, bValue;
                    
                    switch(column) {
                        case 'test':
                            aValue = a.cells[0].querySelector('div:first-child').textContent.trim();
                            bValue = b.cells[0].querySelector('div:first-child').textContent.trim();
                            break;
                        case 'result':
                            aValue = a.cells[1].querySelector('.result-value').textContent.trim();
                            bValue = b.cells[1].querySelector('.result-value').textContent.trim();
                            break;
                        case 'range':
                            aValue = a.cells[2].textContent.trim();
                            bValue = b.cells[2].textContent.trim();
                            break;
                        case 'unit':
                            aValue = a.cells[3].textContent.trim();
                            bValue = b.cells[3].textContent.trim();
                            break;
                        case 'status':
                            aValue = a.cells[4].querySelector('.result-status').textContent.trim();
                            bValue = b.cells[4].querySelector('.result-status').textContent.trim();
                            break;
                        default:
                            return 0;
                    }
                    
                    // Raqamli qiymatlarni tekshirish
                    if (!isNaN(parseFloat(aValue)) && !isNaN(parseFloat(bValue))) {
                        aValue = parseFloat(aValue);
                        bValue = parseFloat(bValue);
                    }
                    
                    if (direction === 'asc') {
                        return aValue > bValue ? 1 : aValue < bValue ? -1 : 0;
                    } else {
                        return aValue < bValue ? 1 : aValue > bValue ? -1 : 0;
                    }
                });
                
                // Yangi tartibda qatorlarni qo'shish
                rows.forEach(row => tbody.appendChild(row));
            }
            
            // Jadval hover effekti
            const tableRows = document.querySelectorAll('.results-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8fafc';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });

        function exportResults() {
            const panelName = "{{ $item->panelTest->panel->name ?? 'Test Panel' }}";
            const patientName = "{{ $hospitalization->appointment->patient->user->name }} {{ $hospitalization->appointment->patient->user->last_name }}";
            const date = "{{ \Carbon\Carbon::parse($item->order->ordered_at)->format('d.m.Y') }}";
            
            alert(`📥 Natijalar PDF formatida yuklab olinmoqda...\n\n` +
                  `Panel: ${panelName}\n` +
                  `Bemor: ${patientName}\n` +
                  `Sana: ${date}`);
            
            // Haqiqiy implementatsiya uchun:
            // window.location.href = "";
        }
        
        // Print uchun qo'shimcha sozlashlar
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.innerHTML = `
                @media print {
                    @page {
                        margin: 20mm;
                        size: A4;
                    }
                    
                    body {
                        font-size: 12pt;
                    }
                    
                    .panel-header-card {
                        page-break-after: avoid;
                    }
                    
                    .test-results-container {
                        page-break-inside: avoid;
                    }
                    
                    .results-table {
                        font-size: 10pt;
                    }
                    
                    .results-table th {
                        background-color: #f0f0f0 !important;
                        -webkit-print-color-adjust: exact;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</x-layouts.main.website>