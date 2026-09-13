@extends('index')
@push('title', get_phrase('Dashboard'))
@push('meta')
@endpush

@push('css')
    <style>
        .ds_item_icon.info {
            border-radius: 10px;
            background-color: #0dcaf031;
            padding: 8px;
        }

        .success,
        .warning,
        .info,
        .primary {
            padding: 4px !important;
        }

        .title {
            font-size: 14px !important;
            font-weight: 600 !important;
        }

        .dashboard_ShortListItem {
            padding: 10px !important;
        }

        .graph-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
        }

        .filter-form .form-select,
        .filter-form .btn {
            min-width: 140px;
        }


        .analytics-wrap {
            background: #f7f8fc;
            border: 1px solid #eceef5;
            border-radius: 16px;
            padding: 18px;
        }

        .analytics-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .analytics-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e1e2d;
            margin-bottom: 3px;
        }

        .analytics-subtitle {
            font-size: 12px;
            color: #7a7f9a;
            margin: 0;
        }

        .analytics-filter-card {
            background: #ffffff;
            border: 1px solid #eceef5;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
        }

        .analytics-filter-card .form-select {
            border-radius: 10px;
            border: 1px solid #dfe4ee;
            min-height: 42px;
            font-size: 14px;
            box-shadow: none !important;
        }

        .analytics-filter-card .btn {
            min-width: 110px;
            min-height: 42px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .analytics-filter-card .btn-primary {
            background: linear-gradient(135deg, #16a3fa, #0d8cf1);
            border: none;
            box-shadow: 0 8px 18px rgba(13, 140, 241, 0.18);
        }

        .analytics-filter-card .btn-light {
            background: #f3f5f9;
            border: 1px solid #dfe4ee;
            color: #333;
        }

        .analytics-chart-card {
            background: #ffffff;
            border: 1px solid #eceef5;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
            margin-bottom: 18px;
        }

        .analytics-chart-title {
            font-size: 14px;
            font-weight: 700;
            color: #2a2e3a;
            margin-bottom: 2px;
        }

        .analytics-chart-subtitle {
            font-size: 12px;
            color: #8b90a7;
            margin-bottom: 14px;
        }

        .erp-stats-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 14px;
            margin-bottom: 18px;
        }

        .erp-stat-card {
            background: #ffffff;
            border: 1px solid #eceef5;
            border-radius: 14px;
            padding: 14px 16px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.04);
            transition: all 0.2s ease;
        }

        .erp-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.07);
        }

        .erp-stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .erp-stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #7b8198;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .erp-stat-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .erp-stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .erp-stat-value {
            font-size: 20px;
            line-height: 1;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }

        .erp-stat-note {
            font-size: 12px;
            color: #8b90a7;
        }

        .erp-stat-card.received .erp-stat-dot {
            background: #22a06b;
        }

        .erp-stat-card.received .erp-stat-icon {
            background: #e9f8f0;
            color: #22a06b;
        }

        .erp-stat-card.received .erp-stat-value {
            color: #0f5132;
        }

        .erp-stat-card.paid .erp-stat-dot {
            background: #e5484d;
        }

        .erp-stat-card.paid .erp-stat-icon {
            background: #fff0f1;
            color: #e5484d;
        }

        .erp-stat-card.paid .erp-stat-value {
            color: #7f1d1d;
        }

        .erp-chart-area {
            position: relative;
            height: 340px;
        }

        @media (max-width: 768px) {
            .erp-stats-row {
                grid-template-columns: 1fr;
            }

            .analytics-head {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@section('content')

    @php
        // dd(auth()->user()->getRoleNames());
    @endphp
    @php
        use Carbon\Carbon;

        $modules = [
            [
                'title' => 'Employee Leave',
                'route' => route('admin.leave.report'),
                'icon' => 'bi-calendar2-minus',
                'permission' => 'leave-report-list',
            ],
            [
                'title' => 'Attendance',
                'route' => route('admin.atten.index'),
                'icon' => 'bi-calendar-check',
                'permission' => 'attendence',
            ],
            [
                'title' => 'Candidates',
                'route' => route('admin.candidate.index'),
                'icon' => 'bi-people-fill',
                'permission' => 'candidate-list',
            ],
            [
                'title' => 'Jobs Recruitment',
                'route' => route('admin.recruitment.index'),
                'icon' => 'bi-briefcase-fill',
                'permission' => 'candidate-list',
            ],
            [
                'title' => 'Invoice',
                'route' => route('admin.invoice.index'),
                'icon' => 'bi-receipt',
                'permission' => 'invoice-list',
            ],
            [
                'title' => 'Create Invoice',
                'route' => route('admin.invoice.create'),
                'icon' => 'bi-receipt-cutoff',
                'permission' => 'invoice-create',
            ],
            [
                'title' => 'Receivable',
                'route' => route('admin.receivable.show'),
                'icon' => 'bi-cash-coin',
                'permission' => 'invoice-list',
            ],
            [
                'title' => 'Suspense Entry',
                'route' => route('admin.suspense.index'),
                'icon' => 'bi-credit-card-2-front-fill',
                'permission' => 'suspense-entry-list',
            ],
            [
                'title' => 'Leads',
                'route' => route('admin.leads.index'),
                'icon' => 'bi-bullseye',
                'permission' => 'lead-list',
            ],
            [
                'title' => 'Call Again Leads',
                'route' => route('admin.leads.callagain'),
                'icon' => 'bi-telephone-fill',
                'permission' => 'lead-list',
            ],
            [
                'title' => 'Subscribers',
                'route' => route('admin.subscriber.index'),
                'icon' => 'bi-person-check-fill',
                'permission' => 'subscriber-list',
            ],
            [
                'title' => 'Email Automation',
                'route' => route('admin.emailautomation.index'),
                'icon' => 'bi-envelope-paper-fill',
                'permission' => 'email-automation-list',
            ],
            [
                'title' => 'Inventory',
                'route' => route('admin.product.index'),
                'icon' => 'bi bi-archive',
                'permission' => 'product-list',
            ],
            [
                'title' => 'Production Order',
                'route' => route('admin.productionorder.index'),
                'icon' => 'bi bi-wrench-adjustable',
                'permission' => 'production-order-list',
            ],
            [
                'title' => 'BOM',
                'route' => route('admin.bom.index'),
                'icon' => 'bi bi-collection',
                'permission' => 'bom-list',
            ],
            [
                'title' => 'GRN',
                'route' => route('admin.grn.index'),
                'icon' => 'bi bi-box-arrow-up',
                'permission' => 'grn-list',
            ],
            [
                'title' => 'Production Cons',
                'route' => route('admin.productionconsumption.index'),
                'icon' => 'bi bi-box2',
                'permission' => 'production-consumption-list',
            ],
            [
                'title' => 'Proforma',
                'route' => route('admin.proforma.index'),
                'icon' => 'bi bi-file-earmark-text',
                'permission' => 'performa-list',
            ],
            [
                'title' => 'Create Proforma',
                'route' => route('admin.proforma.create'),
                'icon' => ' bi bi-file-earmark-plus',
                'permission' => 'performa-create',
            ],
            [
                'title' => 'Sales Order',
                'route' => route('admin.salesorder.store'),
                'icon' => 'bi bi-cart-check',
                'permission' => 'sales-order-list',
            ],
            [
                'title' => 'Delivery',
                'route' => route('admin.delivery.ready'),
                'icon' => 'bi bi-truck',
                'permission' => 'delivery-list',
            ],
            [
                'title' => 'Purchase Req',
                'route' => route('admin.purchase.index'),
                'icon' => 'bi bi-clipboard-plus',
                'permission' => 'purchase-requisition-list',
            ],
            [
                'title' => 'Bills',
                'route' => route('admin.purchase.bills'),
                'icon' => 'bi bi-receipt-cutoff',
                'permission' => 'purchase-bill-list',
            ],
            [
                'title' => 'Support',
                'route' => route('admin.support.index'),
                'icon' => 'bi bi-headset',
                'permission' => 'support-tickets',
            ],
            [
                'title' => 'My Projects',
                'route' => route('user.projects.index'),
                'icon' => 'bi bi-headset',
                'permission' => 'project-my-project',
            ],
        ];

        $filteredModules = collect($modules)->filter(function ($module) {
            return auth()->user()->can($module['permission']);
        });

        $colors = ['success', 'primary', 'warning', 'info'];

        $selectedYear = request('year', now()->year);
        $selectedMonth = request('month');

        $years = collect()
            ->merge(
                \App\Models\Proforma::selectRaw('YEAR(proforma_date) as year')
                    ->whereNotNull('proforma_date')
                    ->pluck('year'),
            )
            ->merge(
                \App\Models\ProformaPayment::selectRaw('YEAR(payment_date) as year')
                    ->whereNotNull('payment_date')
                    ->pluck('year'),
            )
            ->merge(
                \App\Models\VendorPayment::selectRaw('YEAR(payment_date) as year')
                    ->whereNotNull('payment_date')
                    ->pluck('year'),
            )
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        if ($years->isEmpty()) {
            $years = collect([now()->year]);
        }

        $labels = [];

        $orderCounts = [];
        $orderAmounts = [];

        $receivedAmounts = [];
        $paidAmounts = [];

        $ordersGraphTitle = '';
        $paymentsGraphTitle = '';

        if (!empty($selectedMonth)) {
            $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->daysInMonth;

            $proformaData = \App\Models\Proforma::whereYear('proforma_date', $selectedYear)
                ->whereMonth('proforma_date', $selectedMonth)
                ->selectRaw(
                    'DAY(proforma_date) as day, COUNT(*) as total_orders, COALESCE(SUM(total),0) as total_amount',
                )
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

            $receivedData = \App\Models\ProformaPayment::whereYear('payment_date', $selectedYear)
                ->whereMonth('payment_date', $selectedMonth)
                ->selectRaw('DAY(payment_date) as day, COALESCE(SUM(amount),0) as total_received')
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

            $paidData = \App\Models\VendorPayment::whereYear('payment_date', $selectedYear)
                ->whereMonth('payment_date', $selectedMonth)
                ->selectRaw('DAY(payment_date) as day, COALESCE(SUM(amount),0) as total_paid')
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->keyBy('day');

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $labels[] = $day;

                $orderCounts[] = isset($proformaData[$day]) ? (int) $proformaData[$day]->total_orders : 0;
                $orderAmounts[] = isset($proformaData[$day]) ? (float) $proformaData[$day]->total_amount : 0;

                $receivedAmounts[] = isset($receivedData[$day]) ? (float) $receivedData[$day]->total_received : 0;
                $paidAmounts[] = isset($paidData[$day]) ? (float) $paidData[$day]->total_paid : 0;
            }

            $monthName = Carbon::create()->month($selectedMonth)->format('F');
            $ordersGraphTitle = 'Daily Proforma Orders - ' . $monthName . ' ' . $selectedYear;
            $paymentsGraphTitle = 'Daily Received vs Paid - ' . $monthName . ' ' . $selectedYear;
        } else {
            $proformaData = \App\Models\Proforma::whereYear('proforma_date', $selectedYear)
                ->selectRaw(
                    'MONTH(proforma_date) as month, COUNT(*) as total_orders, COALESCE(SUM(total),0) as total_amount',
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            $receivedData = \App\Models\ProformaPayment::whereYear('payment_date', $selectedYear)
                ->selectRaw('MONTH(payment_date) as month, COALESCE(SUM(amount),0) as total_received')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            $paidData = \App\Models\VendorPayment::whereYear('payment_date', $selectedYear)
                ->selectRaw('MONTH(payment_date) as month, COALESCE(SUM(amount),0) as total_paid')
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->keyBy('month');

            for ($month = 1; $month <= 12; $month++) {
                $labels[] = Carbon::create()->month($month)->format('M');

                $orderCounts[] = isset($proformaData[$month]) ? (int) $proformaData[$month]->total_orders : 0;
                $orderAmounts[] = isset($proformaData[$month]) ? (float) $proformaData[$month]->total_amount : 0;

                $receivedAmounts[] = isset($receivedData[$month]) ? (float) $receivedData[$month]->total_received : 0;
                $paidAmounts[] = isset($paidData[$month]) ? (float) $paidData[$month]->total_paid : 0;
            }

            $ordersGraphTitle = 'Month Wise Proforma Orders - ' . $selectedYear;
            $paymentsGraphTitle = 'Month Wise Received vs Paid - ' . $selectedYear;
        }
    @endphp

    @php
        $totalReceived = array_sum($receivedAmounts);
        $totalPaid = array_sum($paidAmounts);
    @endphp

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Dashboard') }}</h4>
                <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @foreach ($filteredModules as $index => $module)
                    @php $color = $colors[$index % count($colors)]; @endphp
                    <div class="col-md-3 mb-2">
                        <div class="dashboard_ShortListItem">
                            <div class="dsHeader d-flex justify-content-between align-items-center">
                                <div class="ds_item_icon {{ $color }}">
                                    <i class="bi {{ $module['icon'] }} text-{{ $color }}"
                                        style="font-size:15px;"></i>
                                </div>
                                <h5 class="title text-dark">
                                    {{ get_phrase($module['title']) }}
                                </h5>
                                <a href="{{ $module['route'] }}" class="ds_link">
                                    <i class="bi bi-arrow-right-short text-{{ $color }}"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-12 pt-3">
            <div class="row">
                @php
                    $current = now();
                    $candidates = \App\Models\Candidate::get();
                    $selectedcandi = \App\Models\Candidate::where('cand_type', 'selected')->get();
                    $rejected = \App\Models\Candidate::where('cand_type', 'rejected')->get();
                    $jobs = \App\Models\Recruitment::where('end_date', '>=', $current)->get();
                @endphp
                @can('candidate-list')
                    <div class="col-md-3">
                        <div class="erp-stat-card">
                            <div class="erp-stat-top">
                                <div class="erp-stat-label">
                                    <span class="erp-stat-dot bg-primary"></span>
                                    All Candidates
                                </div>
                                <div class="erp-stat-icon text-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                            <div class="erp-stat-value">{{ $candidates->count() }}</div>
                            <div class="erp-stat-note">Total candidates in the system</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="erp-stat-card ">
                            <div class="erp-stat-top">
                                <div class="erp-stat-label">
                                    <span class="erp-stat-dot bg-success"></span>
                                    Selected Candidates
                                </div>
                                <div class="erp-stat-icon text-success">
                                    <i class="bi bi-person-check-fill"></i>
                                </div>
                            </div>
                            <div class="erp-stat-value">{{ $selectedcandi->count() }}</div>
                            <div class="erp-stat-note">Candidates successfully hired</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="erp-stat-card danger p-3">
                            <div class="erp-stat-top">
                                <div class="erp-stat-label">
                                    <span class="erp-stat-dot bg-danger"></span>
                                    Rejected Candidates
                                </div>
                                <div class="erp-stat-icon text-danger">
                                    <i class="bi bi-person-x-fill"></i>
                                </div>
                            </div>
                            <div class="erp-stat-value">{{ $rejected->count() }}</div>
                            <div class="erp-stat-note">Candidates not selected</div>
                        </div>
                    </div>
                @endcan

                @can('recuritment-list')
                    <div class="col-md-3">
                        <div class="erp-stat-card">
                            <div class="erp-stat-top">
                                <div class="erp-stat-label">
                                    <span class="erp-stat-dot bg-warning"></span>
                                    Job Posts
                                </div>
                                <div class="erp-stat-icon text-warning">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                            </div>
                            <div class="erp-stat-value">{{ $jobs->count() }}</div>
                            <div class="erp-stat-note">Total active job openings</div>
                        </div>
                    </div>
                @endcan

                <div class="col-md-12 pt-2">
                    <div class="row">
                        @php
                            $leads = \App\Models\Lead::get();
                            $callagain = \App\Models\Lead::where('status', 'call')->get();
                            $lost = \App\Models\Lead::where('stage', 'Lost')->get();
                            $won = \App\Models\Lead::where('stage', 'Won')->get();
                        @endphp
                        @can('lead-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-primary"></span>
                                            All Leads
                                        </div>
                                        <div class="erp-stat-icon text-primary">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $leads->count() }}</div>
                                    <div class="erp-stat-note">Total leads in pipeline</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-info"></span>
                                            Call Again Leads
                                        </div>
                                        <div class="erp-stat-icon text-info">
                                            <i class="bi bi-telephone-forward-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $callagain->count() }}</div>
                                    <div class="erp-stat-note">Leads requiring follow-up</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-danger"></span>
                                            Lost Leads
                                        </div>
                                        <div class="erp-stat-icon text-danger">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $lost->count() }}</div>
                                    <div class="erp-stat-note">Leads that didn’t convert</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-success"></span>
                                            Won Leads
                                        </div>
                                        <div class="erp-stat-icon text-success">
                                            <i class="bi bi-trophy-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $won->count() }}</div>
                                    <div class="erp-stat-note">Successfully converted leads</div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    <div class="row">
                        @php
                            $warehouse = \App\Models\Warehouse::get();
                            $productionOrder = \App\Models\ProductionOrder::get();
                            $bom = \App\Models\Bom::get();
                            $inventory = \App\Models\Inventory::get();
                        @endphp
                        @can('product-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card ">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-primary"></span>
                                            Inventory
                                        </div>
                                        <div class="erp-stat-icon text-primary">
                                            <i class="bi bi-box-seam-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $inventory->count() }}</div>
                                    <div class="erp-stat-note">Total items in inventory</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card ">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-info"></span>
                                            Warehouse
                                        </div>
                                        <div class="erp-stat-icon text-info">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $warehouse->count() }}</div>
                                    <div class="erp-stat-note">Total warehouse locations</div>
                                </div>
                            </div>
                        @endcan


                        @can('production-order-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card ">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-warning"></span>
                                            Production Orders
                                        </div>
                                        <div class="erp-stat-icon text-warning">
                                            <i class="bi bi-gear-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $productionOrder->count() }}</div>
                                    <div class="erp-stat-note">Ongoing production</div>
                                </div>
                            </div>
                        @endcan

                        @can('bom-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card ">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-secondary"></span>
                                            BOM (Bill of Materials)
                                        </div>
                                        <div class="erp-stat-icon text-secondary">
                                            <i class="bi bi-diagram-3-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $bom->count() }}</div>
                                    <div class="erp-stat-note">Defined product structures</div>
                                </div>
                            </div>
                        @endcan


                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    <div class="row">
                        @php
                            $pr = \App\Models\PurchaseRequisition::get();
                            $rfq = \App\Models\Rfq::get();
                            $vendorquotations = \App\Models\VendorQuotation::get();
                            $purchaseOrders = \App\Models\PurchaseOrder::get();
                        @endphp
                        @can('purchase-requisition-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-primary"></span>
                                            Purchase Requisition
                                        </div>
                                        <div class="erp-stat-icon text-primary">
                                            <i class="bi bi-file-earmark-text-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $pr->count() }}</div>
                                    <div class="erp-stat-note">Request raised for materials</div>
                                </div>
                            </div>
                        @endcan

                        @can('purchase-order-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-info"></span>
                                            RFQ
                                        </div>
                                        <div class="erp-stat-icon text-info">
                                            <i class="bi bi-envelope-paper-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $rfq->count() }}</div>
                                    <div class="erp-stat-note">Requests sent to vendors</div>
                                </div>
                            </div>
                        @endcan

                        @can('purchase-order-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card ">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-warning"></span>
                                            Quotations Submitted
                                        </div>
                                        <div class="erp-stat-icon text-warning">
                                            <i class="bi bi-receipt-cutoff"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $vendorquotations->count() }}</div>
                                    <div class="erp-stat-note">Vendor responses received</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card ">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-success"></span>
                                            Purchase Orders
                                        </div>
                                        <div class="erp-stat-icon text-success">
                                            <i class="bi bi-cart-check-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $purchaseOrders->count() }}</div>
                                    <div class="erp-stat-note">Confirmed orders to vendors</div>
                                </div>
                            </div>
                        @endcan


                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    @php
                        $supportdep = \App\Models\SupportDepartment::get();
                        $opensupport = \App\Models\SupportTicket::where('status', 'open')->get();
                        $progressSupport = \App\Models\SupportTicket::where('status', 'in_progress')->get();
                        $closedSupport = \App\Models\SupportTicket::where('status', 'closed')->get();
                    @endphp
                    <div class="row">
                        @can('support-department-list')
                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-primary"></span>
                                            Support Departments
                                        </div>
                                        <div class="erp-stat-icon text-primary">
                                            <i class="bi bi-building-gear"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $supportdep->count() }}</div>
                                    <div class="erp-stat-note">Total support teams available</div>
                                </div>
                            </div>
                        @endcan

                        @can('support-tickets')
                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-danger"></span>
                                            Open Supports
                                        </div>
                                        <div class="erp-stat-icon text-danger">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $opensupport->count() }}</div>
                                    <div class="erp-stat-note">New and unresolved tickets</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-warning"></span>
                                            In Progress
                                        </div>
                                        <div class="erp-stat-icon text-warning">
                                            <i class="bi bi-tools"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $progressSupport->count() }}</div>
                                    <div class="erp-stat-note">Tickets being worked on</div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="erp-stat-card">
                                    <div class="erp-stat-top">
                                        <div class="erp-stat-label">
                                            <span class="erp-stat-dot bg-success"></span>
                                            Closed Tickets
                                        </div>
                                        <div class="erp-stat-icon text-success">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                    <div class="erp-stat-value">{{ $closedSupport->count() }}</div>
                                    <div class="erp-stat-note">Successfully resolved issues</div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>

            </div>
        </div>

        @if (auth()->user()->hasRole(['Admin', 'Sales']))
            <div class="col-md-12 mt-3">
                <div class="eSection-wrap graph-card">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="analytics-wrap">
                                <div class="analytics-head">
                                    <div>
                                        <div class="analytics-title">{{ get_phrase('Dashboard Analytics') }}</div>
                                        <p class="analytics-subtitle">
                                            {{ get_phrase('Track orders, received amounts, and paid amounts.') }}</p>
                                    </div>

                                    <div class="analytics-filter-card">
                                        <form method="GET" action="" class="d-flex gap-2 flex-wrap">
                                            <select name="year" class="form-select">
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}"
                                                        {{ (string) $selectedYear === (string) $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <select name="month" class="form-select">
                                                <option value="">{{ get_phrase('All Months') }}</option>
                                                @for ($m = 1; $m <= 12; $m++)
                                                    <option value="{{ $m }}"
                                                        {{ (string) $selectedMonth === (string) $m ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <button type="submit" class="btn btn-primary">
                                                {{ get_phrase('Filter') }}
                                            </button>

                                            <a href="{{ url()->current() }}" class="btn btn-light">
                                                {{ get_phrase('Reset') }}
                                            </a>
                                        </form>
                                    </div>
                                </div>

                                <div class="analytics-chart-card">
                                    <div class="analytics-chart-title">{{ $ordersGraphTitle }}</div>
                                    <div class="analytics-chart-subtitle">
                                        {{ get_phrase('Line graph showing proforma order count.') }}</div>

                                    <div class="erp-chart-area">
                                        <canvas id="ordersChart"></canvas>
                                    </div>
                                </div>

                                <div class="erp-stats-row">
                                    <div class="erp-stat-card received">
                                        <div class="erp-stat-top">
                                            <div class="erp-stat-label">
                                                <span class="erp-stat-dot"></span>
                                                {{ get_phrase('Total Received') }}
                                            </div>
                                            <div class="erp-stat-icon">
                                                <i class="bi bi-arrow-down-left-circle"></i>
                                            </div>
                                        </div>
                                        <div class="erp-stat-value">{{ number_format($totalReceived, 2) }}</div>
                                        <div class="erp-stat-note">{{ get_phrase('Amount received for selected filter') }}
                                        </div>
                                    </div>

                                    <div class="erp-stat-card paid">
                                        <div class="erp-stat-top">
                                            <div class="erp-stat-label">
                                                <span class="erp-stat-dot"></span>
                                                {{ get_phrase('Total Paid') }}
                                            </div>
                                            <div class="erp-stat-icon">
                                                <i class="bi bi-arrow-up-right-circle"></i>
                                            </div>
                                        </div>
                                        <div class="erp-stat-value">{{ number_format($totalPaid, 2) }}</div>
                                        <div class="erp-stat-note">{{ get_phrase('Amount paid for selected filter') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="analytics-chart-card mb-0">
                                    <div class="analytics-chart-title">{{ $paymentsGraphTitle }}</div>
                                    <div class="analytics-chart-subtitle">
                                        {{ get_phrase('Line graph showing received and paid amounts.') }}</div>

                                    <div class="erp-chart-area">
                                        <canvas id="paymentsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-12">
            {{-- <div class="eSection-wrap table-responsive mt-4">
                <p class="column-title mb-2">
                    {{ get_phrase('Inventory items') }}
                </p>
                <table class="table eTable">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="">{{get_phrase('Type')}}</th>
                            <th class="">{{get_phrase('Quantity')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Inventory::get() as $key => $inventory)
                            <tr>
                                <td>
                                    {{ ++$key }}
                                </td>
                                <td>
                                    {{ $inventory->title }}
                                </td>
                                <td>
                                    {{ App\Models\Inventory_item::orderBy('title')->where('type_id', $inventory->id)->count() }} {{ $inventory->title }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.inventory.item', ['item_type' => $inventory->id]) }}" class="btn btn p-0 px-1" title="{{ get_phrase('Item list') }}"
                                        data-bs-toggle="tooltip">
                                        <i class="fi-rr-clipboard-list"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($labels);
            const orderCounts = @json($orderCounts);
            const orderAmounts = @json($orderAmounts);
            const receivedAmounts = @json($receivedAmounts);
            const paidAmounts = @json($paidAmounts);

            const ordersCanvas = document.getElementById('ordersChart');
            const paymentsCanvas = document.getElementById('paymentsChart');

            if (ordersCanvas) {
                const ordersCtx = ordersCanvas.getContext('2d');

                const ordersGradient = ordersCtx.createLinearGradient(0, 0, 0, 360);
                ordersGradient.addColorStop(0, 'rgba(13, 110, 253, 0.30)');
                ordersGradient.addColorStop(1, 'rgba(13, 110, 253, 0.03)');

                new Chart(ordersCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Orders Count',
                            data: orderCounts,
                            borderColor: '#0d6efd',
                            backgroundColor: ordersGradient,
                            fill: true,
                            tension: 0.42,
                            borderWidth: 3,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBorderWidth: 3,
                            pointHoverBackgroundColor: '#ffffff',
                            pointHoverBorderColor: '#0d6efd'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 10,
                                right: 10,
                                left: 10,
                                bottom: 0
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'center',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    boxHeight: 8,
                                    padding: 20,
                                    color: '#374151',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#ffffff',
                                bodyColor: '#e5e7eb',
                                borderColor: 'rgba(255,255,255,0.08)',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: true,
                                usePointStyle: true,
                                callbacks: {
                                    label: function(context) {
                                        return 'Orders: ' + Number(context.raw).toLocaleString();
                                    },
                                    afterLabel: function(context) {
                                        const index = context.dataIndex;
                                        return 'Order Amount: ' + Number(orderAmounts[index])
                                            .toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: '{{ !empty($selectedMonth) ? 'Days of Month' : 'Months of Year' }}',
                                    color: '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    padding: {
                                        top: 10
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    precision: 0,
                                    callback: function(value) {
                                        return Number(value).toLocaleString();
                                    },
                                    font: {
                                        size: 12
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Orders Count',
                                    color: '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            if (paymentsCanvas) {
                const paymentsCtx = paymentsCanvas.getContext('2d');

                const receivedGradient = paymentsCtx.createLinearGradient(0, 0, 0, 360);
                receivedGradient.addColorStop(0, 'rgba(25, 135, 84, 0.30)');
                receivedGradient.addColorStop(1, 'rgba(25, 135, 84, 0.02)');

                const paidGradient = paymentsCtx.createLinearGradient(0, 0, 0, 360);
                paidGradient.addColorStop(0, 'rgba(220, 53, 69, 0.28)');
                paidGradient.addColorStop(1, 'rgba(220, 53, 69, 0.02)');

                new Chart(paymentsCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Received Amount',
                                data: receivedAmounts,
                                borderColor: '#198754',
                                backgroundColor: receivedGradient,
                                fill: true,
                                tension: 0.42,
                                borderWidth: 3,
                                pointRadius: 0,
                                pointHoverRadius: 6,
                                pointHoverBorderWidth: 3,
                                pointHoverBackgroundColor: '#ffffff',
                                pointHoverBorderColor: '#198754'
                            },
                            {
                                label: 'Paid Amount',
                                data: paidAmounts,
                                borderColor: '#dc3545',
                                backgroundColor: paidGradient,
                                fill: true,
                                tension: 0.42,
                                borderWidth: 3,
                                pointRadius: 0,
                                pointHoverRadius: 6,
                                pointHoverBorderWidth: 3,
                                pointHoverBackgroundColor: '#ffffff',
                                pointHoverBorderColor: '#dc3545'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 10,
                                right: 10,
                                left: 10,
                                bottom: 0
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'center',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    boxHeight: 8,
                                    padding: 20,
                                    color: '#374151',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#ffffff',
                                bodyColor: '#e5e7eb',
                                borderColor: 'rgba(255,255,255,0.08)',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: true,
                                usePointStyle: true,
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + Number(context.raw)
                                            .toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: '500'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: '{{ !empty($selectedMonth) ? 'Days of Month' : 'Months of Year' }}',
                                    color: '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    },
                                    padding: {
                                        top: 10
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.15)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    callback: function(value) {
                                        return Number(value).toLocaleString();
                                    },
                                    font: {
                                        size: 12
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Amount',
                                    color: '#6b7280',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
