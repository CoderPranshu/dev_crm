@extends('index')

@push('title', get_phrase('Add Subscription'))

@push('css')
<style>
    #subscriptionForm .domain-card {
        border: 1px solid #dfe7ef;
        border-radius: 14px;
        background: #f9fbfd;
        padding: 20px;
        margin-bottom: 18px;
    }

    #subscriptionForm .domain-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #183041;
    }

    #subscriptionForm .serviceRow {
        border-top: 1px solid #e5edf3;
        padding-top: 15px;
        margin-top: 15px;
    }

    #subscriptionForm .domain-subtotal {
        color: #526778;
        font-size: 14px;
        font-weight: 600;
    }

    #subscriptionForm .removeService {
        min-width: 40px;
    }

    #subscriptionForm .serviceRow .addService {
        min-width: 40px;
    }

    #subscriptionForm .removeService:disabled,
    #subscriptionForm .removeDomain:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    @media (max-width: 767px) {
        #subscriptionForm .domain-card { padding: 15px; }
        #subscriptionForm .serviceRow > div { margin-bottom: 10px; }
    }
</style>
@endpush

@section('content')
<div class="mainSection-title">
    <h4>{{ get_phrase('Add Subscription') }}</h4>
</div>

<div class="eSection-wrap">
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="subscriptionForm" action="{{ route('admin.subscriptions.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="company_id">Company</label>
                <select name="company_id" id="company_id" class="form-select" required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="client_name">Client Name</label>
                <input type="text" name="client_name" id="client_name" class="form-control"
                       value="{{ old('client_name') }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="mobile">Mobile</label>
                <input type="tel" name="mobile" id="mobile" class="form-control"
                       value="{{ old('mobile') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="{{ old('email') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="purchase_date">Purchase Date</label>
                <input type="date" name="purchase_date" id="purchase_date" class="form-control"
                       value="{{ old('purchase_date', date('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label" for="duration_months">Duration (Months)</label>
                <input type="number" name="duration_months" id="duration_months"
                       class="form-control" min="1" step="1" value="{{ old('duration_months', 12) }}" required>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label" for="renew_before_days">Renew Before Days</label>
                <input type="number" name="renew_before_days" id="renew_before_days"
                       class="form-control" min="0" step="1" value="{{ old('renew_before_days', 3) }}">
            </div>
        </div>

        <hr>
        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
            <h5 class="mb-0">Domains &amp; Services</h5>
            <button type="button" id="addDomain" class="btn btn-outline-primary">
                + Add Domain
            </button>
        </div>

        <div id="domainGroups"></div>

        <div class="row mb-4">
            <div class="col-md-4">
                <label class="form-label" for="totalAmount">Total Amount</label>
                <input type="text" id="totalAmount" class="form-control" value="0.00" readonly>
            </div>
        </div>

        {{-- Keep the original flat arrays so the existing store action can still read services. --}}
        <div id="legacyServiceFields"></div>

        <button type="submit" class="btn btn-primary">Save Subscription</button>
    </form>
</div>

<template id="domainTemplate">
    <section class="domain-card" data-domain-index="__D__" data-next-service-index="0">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
            <div class="domain-card-title">Domain <span class="domainNumber"></span></div>
            <button type="button" class="btn btn-outline-danger btn-sm removeDomain">Remove Domain</button>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label" for="domain-name-__D__">Domain Name</label>
                <input type="text" id="domain-name-__D__"
                       name="domains[__D__][domain_name]" class="form-control domainName"
                       placeholder="example.com" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="domain-status-__D__">Domain Status</label>
                <select id="domain-status-__D__" name="domains[__D__][status]"
                        class="form-select domainStatus" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="servicesContainer"></div>

        <div class="d-flex justify-content-end mt-3">
            <span class="domain-subtotal">Domain subtotal: ₹<span class="subtotalValue">0.00</span></span>
        </div>
    </section>
</template>

<template id="serviceRowTemplate">
    <div class="row align-items-end serviceRow" data-service-index="__S__">
        <div class="col-md-4">
            <label class="form-label">Category</label>
            <select name="domains[__D__][services][__S__][category_id]"
                    class="form-select categorySelect" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Service</label>
            <select name="domains[__D__][services][__S__][service_type_id]"
                    class="form-select serviceTypeSelect" required>
                <option value="">Select Service</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" min="0"
                   name="domains[__D__][services][__S__][price]"
                   class="form-control priceInput" readonly>
        </div>

        <div class="col-md-1">
            <button type="button" class="btn btn-success addService" aria-label="Add service to this domain"
                    title="Add service to this domain">+</button>
        </div>

        <div class="col-md-1">
            <button type="button" class="btn btn-danger removeService" aria-label="Remove service">×</button>
        </div>
    </div>
</template>

<script type="application/json" id="oldSubscriptionDomains">@json(old('domains', []))</script>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('subscriptionForm');
    const domainGroups = document.getElementById('domainGroups');
    const domainTemplate = document.getElementById('domainTemplate');
    const serviceTemplate = document.getElementById('serviceRowTemplate');
    const legacyFields = document.getElementById('legacyServiceFields');
    const serviceUrl = "{{ url('admin/get-service-types') }}";
    const companyUrl = "{{ url('admin/company-details') }}";
    let nextDomainIndex = 0;
    let companyRequest = 0;

    function valuesOf(data) {
        return data && typeof data === 'object' ? Object.values(data) : [];
    }

    function createFromTemplate(template, replacements) {
        let markup = template.innerHTML;
        for (const [key, value] of Object.entries(replacements)) {
            markup = markup.replaceAll(key, String(value));
        }
        const wrapper = document.createElement('div');
        wrapper.innerHTML = markup.trim();
        return wrapper.firstElementChild;
    }

    function updateTotals() {
        let total = 0;
        domainGroups.querySelectorAll('.domain-card').forEach(card => {
            let subtotal = 0;
            card.querySelectorAll('.priceInput').forEach(input => {
                subtotal += Number.parseFloat(input.value) || 0;
            });
            card.querySelector('.subtotalValue').textContent = subtotal.toFixed(2);
            total += subtotal;
        });
        document.getElementById('totalAmount').value = total.toFixed(2);
    }

    function updateControls() {
        const cards = [...domainGroups.querySelectorAll('.domain-card')];
        cards.forEach((card, index) => {
            card.querySelector('.domainNumber').textContent = index + 1;
            card.querySelector('.removeDomain').disabled = cards.length === 1;

            const rows = [...card.querySelectorAll('.serviceRow')];
            rows.forEach(row => {
                row.querySelector('.removeService').disabled = rows.length === 1;
            });
        });
    }

    async function loadServices(row, categoryId, selectedServiceId = '') {
        const select = row.querySelector('.serviceTypeSelect');
        select.replaceChildren(new Option('Loading services...', ''));

        try {
            const response = await fetch(serviceUrl + '/' + encodeURIComponent(categoryId), {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Could not load services');
            const result = await response.json();
            if (!row.isConnected || row.querySelector('.categorySelect').value !== String(categoryId)) return;

            const services = Array.isArray(result) ? result : (result.data || []);
            select.replaceChildren(new Option('Select Service', ''));
            services.forEach(item => {
                const option = new Option(item.name, item.id);
                option.dataset.price = item.price ?? 0;
                select.add(option);
            });
            if (selectedServiceId !== '') {
                select.value = String(selectedServiceId);
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }
        } catch (error) {
            if (row.isConnected && row.querySelector('.categorySelect').value === String(categoryId)) {
                select.replaceChildren(new Option('Unable to load services. Try again.', ''));
            }
        }
    }

    function addService(card, initial = {}) {
        const domainIndex = card.dataset.domainIndex;
        const serviceIndex = Number(card.dataset.nextServiceIndex);
        card.dataset.nextServiceIndex = serviceIndex + 1;

        const row = createFromTemplate(serviceTemplate, {
            '__D__': domainIndex,
            '__S__': serviceIndex
        });
        card.querySelector('.servicesContainer').appendChild(row);

        if (initial.category_id) {
            row.querySelector('.categorySelect').value = String(initial.category_id);
            loadServices(row, initial.category_id, initial.service_type_id || '');
        }
        updateControls();
        updateTotals();
    }

    function addDomain(initial = {}) {
        const domainIndex = nextDomainIndex++;
        const card = createFromTemplate(domainTemplate, { '__D__': domainIndex });
        domainGroups.appendChild(card);
        card.querySelector('.domainName').value = initial.domain_name || '';
        card.querySelector('.domainStatus').value = initial.status === 'inactive' ? 'inactive' : 'active';

        const services = valuesOf(initial.services);
        if (services.length) {
            services.forEach(service => addService(card, service));
        } else {
            addService(card);
        }
        updateControls();
        return card;
    }

    document.getElementById('addDomain').addEventListener('click', () => addDomain());

    domainGroups.addEventListener('click', function (event) {
        const card = event.target.closest('.domain-card');
        if (!card) return;

        if (event.target.closest('.addService')) {
            addService(card);
        } else if (event.target.closest('.removeService')) {
            event.target.closest('.serviceRow').remove();
            updateControls();
            updateTotals();
        } else if (event.target.closest('.removeDomain')) {
            card.remove();
            updateControls();
            updateTotals();
        }
    });

    domainGroups.addEventListener('change', function (event) {
        const row = event.target.closest('.serviceRow');
        if (!row) return;

        if (event.target.matches('.categorySelect')) {
            row.querySelector('.priceInput').value = '';
            row.querySelector('.serviceTypeSelect').replaceChildren(new Option('Select Service', ''));
            updateTotals();
            if (event.target.value) loadServices(row, event.target.value);
        } else if (event.target.matches('.serviceTypeSelect')) {
            const price = event.target.selectedOptions[0]?.dataset.price;
            row.querySelector('.priceInput').value = event.target.value && price !== undefined
                ? (Number.parseFloat(price) || 0).toFixed(2) : '';
            updateTotals();
        }
    });

    document.getElementById('company_id').addEventListener('change', async function () {
        const companyId = this.value;
        const requestNumber = ++companyRequest;
        ['client_name', 'mobile', 'email'].forEach(id => {
            document.getElementById(id).value = '';
        });
        if (!companyId) return;

        try {
            const response = await fetch(companyUrl + '/' + encodeURIComponent(companyId), {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Could not load company');
            const result = await response.json();
            if (requestNumber !== companyRequest) return;
            const details = result.data || result;
            document.getElementById('client_name').value = details.name || '';
            document.getElementById('mobile').value = details.phone || '';
            document.getElementById('email').value = details.email || '';
        } catch (error) {
            // Fields remain editable if company details cannot be loaded.
        }
    });

    function addHidden(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        legacyFields.appendChild(input);
    }

    form.addEventListener('submit', function () {
        legacyFields.replaceChildren();
        domainGroups.querySelectorAll('.domain-card').forEach(card => {
            const domainName = card.querySelector('.domainName').value.trim();
            card.querySelectorAll('.serviceRow').forEach(row => {
                addHidden('category_id[]', row.querySelector('.categorySelect').value);
                addHidden('service_type_id[]', row.querySelector('.serviceTypeSelect').value);
                addHidden('price[]', row.querySelector('.priceInput').value);
                addHidden('domain_name[]', domainName);
                addHidden('domain_group_id[]', card.dataset.domainIndex);
            });
        });
    });

    let oldDomains = [];
    try {
        oldDomains = valuesOf(JSON.parse(document.getElementById('oldSubscriptionDomains').textContent));
    } catch (error) {
        oldDomains = [];
    }
    if (oldDomains.length) oldDomains.forEach(domain => addDomain(domain));
    else addDomain();
});
</script>
@endpush









