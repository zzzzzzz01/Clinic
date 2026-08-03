<x-layouts.main.website>
    <x-slot:title>
        @lang('words.pharmacist.sales.title')
    </x-slot:title>
    <link rel="stylesheet" href="{{ asset('temp2/css/pharmacist-sales.css') }}" />

    <div class="container-custom">
        {{-- Breadcrumb --}} 
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i> @lang('words.main.page')
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#" style="color: #808080;" class="text-decoration-none">
                        @lang('words.pharmacist.sales.title')
                    </a>
                </li>
            </ol>
        </nav>
        
        <div class="search-wrapper">
            <div class="search-card">
                <div class="row align-items-center" style="width: 63%;">
                    <div class="col-md-6">
                        <h4 class="mb-md-0">@lang('words.pharmacist.sales.title')</h4>
                    </div>
                </div>
                <button class="btn-history" id="historyBtn">
                    <i class="fas fa-clock-rotate-left"></i> @lang('words.pharmacist.sales.sales_history')
                </button> 
            </div>
        </div>  

        <div class="row-g-3">
            {{-- CHAP QISM: DORILAR --}}
            <div class="col-lg-7">
                <div class="sell-card card">
                    <div class="card-header-custom">
                        <span>@lang('words.pharmacist.sales.medicine_list')</span>
                        <span class="badge-count">{{ $data->count() }} ta</span>
                    </div>
                    <div class="card-body-custom">

                    {{-- Qidirish qismi --}}
                    <div class="mb-3">
                        <div class="search-section">
                            <div class="search-col-input">
                                <div class="search-wrapper"> 
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="@lang('words.pharmacist.sales.search_placeholder')"
                                        autocomplete="off"
                                        value="{{ request('search') }}">
                                </div>
                            </div> 
                            <div class="search-col-btn">
                                <button type="button" class="btn-search" id="searchBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="search-col-btn" id="clearSearchBtn" style="display: {{ request('search') ? 'flex' : 'none' }};">
                                <button type="button" class="btn-search" style="background: #dc3545;" id="clearSearchButton">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                        {{-- Jadval --}}
                        <div class="table-medicine">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="table-col-id">#</th>
                                        <th>@lang('words.pharmacist.sales.medicine_name')</th>
                                        <th class="table-col-strength">@lang('words.pharmacist.sales.dose')</th>
                                        <th class="table-col-stock">@lang('words.pharmacist.sales.stock')</th>
                                        <th class="table-col-price">@lang('words.pharmacist.sales.price')</th>
                                        <th class="table-col-action">@lang('words.pharmacist.sales.sell')</th>
                                    </tr>
                                </thead>
                                <tbody id="medicineTableBody"> 
                                    @include('partials.table-body.sales')
                                </tbody>
                            </table>
                        </div> 

                        <!-- Pagination -->
                        @include('partials.paginations.sales')
                    </div>
                </div>
            </div>

            {{-- O'NG QISM: SAVATLAR --}}
            <div class="col-lg-5">
                {{-- JORIY SAVAT --}}
                <div class="sell-card card card-mb-3" id="currentCart">
                    <div class="card-header-custom">
                        <span>@lang('words.pharmacist.sales.current_cart')
                            <span class="badge-primary ms-1" id="cartItemCount">0</span>
                        </span>
                        <div>
                            <button class="cart-close-btn" id="closeCartBtn" title="@lang('words.pharmacist.sales.clear_cart')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body-custom" id="cartBody"  style="padding: 16px;">
                        {{-- Savat itemlar --}}
                        <div id="cartItems">
                            <!-- Dinamik ravishda qo'shiladi -->
                        </div>

                        {{-- Jami va Tozalash --}}
                        <div class="cart-total-wrapper">
                            <div class="cart-total">
                                <span class="cart-total-label">@lang('words.pharmacist.sales.total')</span>
                                <span class="cart-total-amount" id="cartTotal">$0.00</span>
                            </div>
                            <button class="btn-clear-cart" id="clearCartBtn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        {{-- Chegirma va to'lov --}}
                        <div class="row-g-2 mt-3"> 
                            <div class="col-12">
                                <div class="form-group">
                                <label class="notification-label">@lang('words.pharmacist.sales.payment_method')</label>
                                    <select class="form-control" id="paymentMethod">
                                        <option value="cash">@lang('words.pharmacist.sales.cash')</option>
                                        <option value="card">@lang('words.pharmacist.sales.card')</option>
                                        <option value="transfer">@lang('words.pharmacist.sales.transfer')</option>
                                        <option value="insurance">@lang('words.pharmacist.sales.insurance')</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Tugmalar yonma-yon --}}
                        <div class="cart-actions-row">
                            <button class="btn-secondary" style="width: 100%;" id="moveToQueueBtn">
                                <i class="fas fa-arrow-left me-1"></i> @lang('words.pharmacist.sales.add_to_queue')
                            </button>
                            <button class="btn-primary" style="width: 100%;" id="completeSaleBtn">
                                <i class="fas fa-check-circle me-2"></i>@lang('words.pharmacist.sales.sell_now')
                            </button>
                        </div>
                    </div>
                </div>

                {{-- NAVBATDAGI SAVATLAR --}}
                <div class="sell-card card">
                    <div class="card-header-custom">
                        <span>@lang('words.pharmacist.sales.pending_carts')</span>
                        <span class="badge-pending" id="pendingCount">0 ta</span>
                    </div>
                    <div class="card-body-custom" id="pendingBaskets">
                        <!-- Dinamik ravishda qo'shiladi -->
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <!-- NOTIFICATION MODAL (Dori qo'shish) - DIALOG -->
    @include('partials.modals.create-modals.sales')

    <!-- CHECKOUT MODAL (Sotishni tasdiqlash) - DIALOG -->
    @include('partials.modals.others.sales-checkout')

    <!-- HISTORY MODAL (Bugungi sotuvlar) - DIALOG -->
    @include('partials.modals.others.sales-history')

    {{-- JavaScript --}}
    <script>
        window.searchRoute = '{{ route("pharmacist.search.medicines") }}';
        window.translations = {
            no_medicines: '{{ __('words.pharmacist.sales.no_medicines') }}'
        };
    </script>
    <script src="{{ asset('temp2/js/pharmacist-sales.js') }}"></script>
</x-layouts.main.website>