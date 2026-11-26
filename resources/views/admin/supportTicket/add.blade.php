@php
    $user = Auth::user();
    // Each option represents one domain within one subscription. A domain may
    // have several services, so use one service item ID as its stable option ID.
    $subscriptionDomains = \App\Support\SubscriptionDomainAccess::domainItemsFor($user)
        ->selectRaw('MIN(item.id) as id, item.subscription_id, item.domain_name, subscription.company_name')
        ->groupBy('item.subscription_id', 'item.domain_name', 'subscription.company_name')
        ->orderBy('item.domain_name')
        ->get();
    $formId = 'cs-ticket-' . \Illuminate\Support\Str::uuid();
    $initial = \Illuminate\Support\Str::upper(
        \Illuminate\Support\Str::substr($user->name, 0, 1)
    );
@endphp

{{-- Inline CSS: this view is loaded inside your existing right-side modal. --}}
<style>
    [data-cs-ticket] {
        --cs-primary: #137d83;
        --cs-accent: #15aebb;
        --cs-dark: #282828;
        --cs-muted: #607575;
        --cs-border: #deebeb;
        --cs-soft: #edf7f7;
        color: var(--cs-dark);
        background: #f5f9f9;
        border: 1px solid var(--cs-border);
        border-radius: 20px;
        width: 100%;
        min-width: 0;
        font: inherit;
        line-height: 1.5;
        isolation: isolate;
    }
    [data-cs-ticket] *, [data-cs-ticket] *::before, [data-cs-ticket] *::after { box-sizing: border-box; }
    [data-cs-ticket] :is(input, select, textarea, button) { font: inherit; }
    [data-cs-ticket] :is(input, select, textarea, button, summary):focus-visible { outline: 3px solid var(--cs-accent); outline-offset: 3px; }
    [data-cs-ticket] .cs-hero { padding: 25px 22px; border-radius: 19px 19px 0 0; background: #222e2f; color: #fff; position: relative; overflow: hidden; }
    [data-cs-ticket] .cs-hero::after { content: ''; position: absolute; width: 150px; height: 150px; border: 26px solid #ffffff06; border-radius: 50%; right: -55px; top: -45px; pointer-events: none; }
    [data-cs-ticket] .cs-brand { display: flex; align-items: center; gap: 8px; color: #7cdae0; font-size: 10px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; margin-bottom: 17px; }
    [data-cs-ticket] .cs-brand::before { content: ''; width: 7px; height: 7px; background: var(--cs-accent); border-radius: 50%; }
    [data-cs-ticket] .cs-hero h3 { color: #fff; font-size: 25px; line-height: 1.2; font-weight: 700; letter-spacing: -.035em; margin: 0 0 9px; position: relative; z-index: 1; }
    [data-cs-ticket] .cs-hero p { color: #c2d2d2; font-size: 12px; margin: 0; max-width: 350px; }
    [data-cs-ticket] .cs-ticket-note { display: inline-flex; align-items: center; gap: 7px; border: 1px solid #527375; background: #2c4445; color: #c8f2f3; padding: 6px 10px; border-radius: 7px; font-size: 10px; margin-top: 17px; }
    [data-cs-ticket] .cs-body { display: grid; gap: 16px; padding: 18px; }
    [data-cs-ticket] .cs-person { border: 1px solid var(--cs-border); border-radius: 13px; padding: 16px; background: #fff; }
    [data-cs-ticket] .cs-person-head { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
    [data-cs-ticket] .cs-avatar { display: grid; place-items: center; flex: 0 0 39px; height: 39px; border-radius: 12px; background: var(--cs-soft); color: var(--cs-primary); font-weight: 700; font-size: 16px; }
    [data-cs-ticket] .cs-person-title { flex: 1; min-width: 0; }
    [data-cs-ticket] .cs-person-title strong { display: block; font-size: 12px; }
    [data-cs-ticket] .cs-person-title span { color: var(--cs-muted); font-size: 10px; }
    [data-cs-ticket] .cs-lock { color: var(--cs-primary); font-size: 17px; }
    [data-cs-ticket] .cs-profile-fields { display: flex; flex-wrap: wrap; gap: 12px; }
    [data-cs-ticket] .cs-profile-fields > div { flex: 1 1 170px; min-width: 0; }
    [data-cs-ticket] .cs-profile-fields label { display: block; font-size: 9px; font-weight: 700; letter-spacing: .08em; color: var(--cs-muted); text-transform: uppercase; margin: 0 0 5px; }
    [data-cs-ticket] .cs-readonly { display: block; width: 100%; min-width: 0; background: #f5f9f9; border: 1px solid #e6eeee; border-radius: 7px; padding: 9px 10px; font-size: 12px; color: #405454; }
    [data-cs-ticket] .cs-section { background: #fff; border: 1px solid var(--cs-border); border-radius: 13px; padding: 18px; }
    [data-cs-ticket] .cs-section-head { display: flex; align-items: flex-start; gap: 11px; padding-bottom: 15px; margin-bottom: 17px; border-bottom: 1px solid #edf3f3; }
    [data-cs-ticket] .cs-step { width: 29px; height: 29px; flex: 0 0 29px; display: grid; place-items: center; color: var(--cs-primary); background: var(--cs-soft); border-radius: 8px; font-size: 11px; font-weight: 700; }
    [data-cs-ticket] .cs-section-head h4 { font-size: 13px; color: var(--cs-dark); font-weight: 700; margin: 0 0 3px; }
    [data-cs-ticket] .cs-section-head p { font-size: 11px; color: var(--cs-muted); margin: 0; }
    [data-cs-ticket] .cs-field + .cs-field { margin-top: 18px; }
    [data-cs-ticket] .cs-label-line { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 8px; }
    [data-cs-ticket] .cs-label-line label { color: #354646; font-size: 12px; font-weight: 600; margin: 0; }
    [data-cs-ticket] .cs-required { color: #b43749; }
    [data-cs-ticket] .cs-optional { background: #f0f5f5; color: #5e7272; font-size: 9px; padding: 3px 7px; border-radius: 5px; }
    [data-cs-ticket] .cs-control { width: 100%; min-height: 46px; padding: 11px 12px; border: 1px solid #cfdfdf; border-radius: 9px; background: #fff; color: var(--cs-dark); font-size: 13px; box-shadow: 0 1px 2px #173c3c03; }
    [data-cs-ticket] .cs-control::placeholder { color: #718585; opacity: 1; }
    [data-cs-ticket] .cs-control:focus { border-color: var(--cs-primary); }
    [data-cs-ticket] select.cs-control { cursor: pointer; }
    [data-cs-ticket] textarea.cs-control { min-height: 150px; resize: vertical; line-height: 1.7; }
    [data-cs-ticket] .cs-hint { color: var(--cs-muted); font-size: 10px; line-height: 1.6; margin: 7px 0 0; }
    [data-cs-ticket] .cs-error { color: #b02e43; font-size: 11px; margin: 6px 0 0; }
    [data-cs-ticket] .cs-error:empty { display: none; }
    [data-cs-ticket] [aria-invalid="true"] { border-color: #c13a50; }
    [data-cs-ticket] .cs-help { margin-top: 12px; background: #f6fafa; border: 1px solid #e5eeee; border-radius: 8px; padding: 10px 12px; font-size: 11px; }
    [data-cs-ticket] .cs-help summary { cursor: pointer; color: var(--cs-primary); font-weight: 600; }
    [data-cs-ticket] .cs-help p { color: var(--cs-muted); margin: 8px 0 0; line-height: 1.7; }
    [data-cs-ticket] .cs-upload { border: 1px dashed #96c6c9; background: #f4fbfb; border-radius: 11px; padding: 17px; }
    [data-cs-ticket] .cs-upload-title { display: flex; align-items: center; gap: 10px; margin-bottom: 13px; }
    [data-cs-ticket] .cs-upload-title > i { width: 35px; height: 35px; flex: 0 0 35px; display: grid; place-items: center; background: #e1f1f2; color: var(--cs-primary); border-radius: 9px; font-size: 17px; }
    [data-cs-ticket] .cs-upload-title label { display: block; font-size: 12px; font-weight: 600; color: #365354; margin: 0; }
    [data-cs-ticket] .cs-upload-title span { color: var(--cs-muted); font-size: 10px; }
    [data-cs-ticket] .cs-file { display: block; width: 100%; min-width: 0; border: 1px solid #c9dede; border-radius: 8px; padding: 6px; background: #fff; color: #506b6c; font-size: 11px; }
    [data-cs-ticket] .cs-file::file-selector-button { border: 0; border-radius: 5px; padding: 8px 10px; margin-right: 9px; background: #e6f3f3; color: #106d72; font: inherit; font-weight: 600; cursor: pointer; }
    [data-cs-ticket] .cs-file::file-selector-button:hover { background: #d1ebec; }
    [data-cs-ticket] .cs-footer { position: sticky; bottom: 0; z-index: 2; background: #fff; border-top: 1px solid var(--cs-border); border-radius: 0 0 19px 19px; padding: 16px 18px 18px; box-shadow: 0 -6px 18px #1c484805; }
    [data-cs-ticket] .cs-submit { width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; min-height: 48px; padding: 12px 18px; border: 1px solid var(--cs-primary); border-radius: 10px; background: var(--cs-primary); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 10px #137d8320; }
    [data-cs-ticket] .cs-submit:hover { background: #0e676c; border-color: #0e676c; }
    [data-cs-ticket] .cs-footer p { text-align: center; color: var(--cs-muted); font-size: 10px; margin: 9px 0 0; }
    [data-cs-ticket] .cs-alert { background: #fff2f4; color: #9d3042; border: 1px solid #f0cbd2; border-radius: 10px; padding: 12px; font-size: 12px; }
    [data-cs-ticket] .cs-alert ul { padding-left: 18px; margin: 7px 0 0; }
    @media (max-width: 480px) {
        [data-cs-ticket] .cs-body { padding: 12px; gap: 12px; }
        [data-cs-ticket] .cs-hero { padding: 22px 17px; }
        [data-cs-ticket] .cs-section { padding: 14px; }
        [data-cs-ticket] .cs-control { font-size: 16px; }
    }
</style>

<form id="{{ $formId }}" data-cs-ticket
    action="{{ route('admin.support.store') }}"
    method="POST" enctype="multipart/form-data"
    aria-labelledby="{{ $formId }}-title">
    @csrf

    <header class="cs-hero">
        <div class="cs-brand">Code Sparrow / {{ get_phrase('Support') }}</div>
        <h3 id="{{ $formId }}-title">{{ get_phrase('How can we help?') }}</h3>
        <p>{{ get_phrase('Choose the subscription domain and describe your request.') }}</p>
        <div class="cs-ticket-note">
            <i class="bi bi-ticket-perforated" aria-hidden="true"></i>
            {{ get_phrase('6-digit ticket number assigned after submission') }}
        </div>
    </header>

    <div class="cs-body">
        @if ($errors->any())
            <div class="cs-alert" role="alert">
                <strong>{{ get_phrase('Please check the following details.') }}</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Account identity: visually separate from editable request fields. --}}
        <section class="cs-person" aria-labelledby="{{ $formId }}-identity">
            <div class="cs-person-head">
                <span class="cs-avatar" aria-hidden="true">{{ $initial }}</span>
                <div class="cs-person-title">
                    <strong id="{{ $formId }}-identity">{{ get_phrase('Request raised by') }}</strong>
                    <span>{{ get_phrase('Your signed-in account') }}</span>
                </div>
                <i class="bi bi-lock cs-lock" aria-hidden="true"></i>
            </div>
            <div class="cs-profile-fields">
                <div>
                    <label for="{{ $formId }}-name">{{ get_phrase('Name') }}</label>
                    <input id="{{ $formId }}-name" name="name" type="text"
                        class="cs-readonly" value="{{ $user->name }}" readonly>
                </div>
                <div>
                    <label for="{{ $formId }}-email">{{ get_phrase('Email') }}</label>
                    <input id="{{ $formId }}-email" name="email" type="email"
                        class="cs-readonly" value="{{ $user->email }}" readonly>
                </div>
            </div>
        </section>

        {{-- Section 01 --}}
        <section class="cs-section" aria-labelledby="{{ $formId }}-details-title">
            <div class="cs-section-head">
                <span class="cs-step" aria-hidden="true">01</span>
                <div>
                    <h4 id="{{ $formId }}-details-title">{{ get_phrase('Request details') }}</h4>
                    <p>{{ get_phrase('Give your ticket a clear starting point.') }}</p>
                </div>
            </div>
            <div class="cs-field">
                <div class="cs-label-line">
                    <label for="{{ $formId }}-subject">{{ get_phrase('Subject') }} <span class="cs-required" aria-hidden="true">*</span></label>
                </div>
                <input id="{{ $formId }}-subject" name="subject" type="text"
                    class="cs-control" value="{{ old('subject') }}" maxlength="255" required
                    placeholder="{{ get_phrase('e.g. Unable to update product images') }}"
                    aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                    aria-describedby="{{ $formId }}-subject-hint {{ $formId }}-subject-error">
                <p id="{{ $formId }}-subject-hint" class="cs-hint">{{ get_phrase('Summarize the issue in one line. Maximum 255 characters.') }}</p>
                <p id="{{ $formId }}-subject-error" class="cs-error">@error('subject'){{ $message }}@enderror</p>
            </div>
            <div class="cs-field">
                <div class="cs-label-line">
                    <label for="{{ $formId }}-subscription-item">{{ get_phrase('Subscription Plan') }} <span class="cs-required" aria-hidden="true">*</span></label>
                </div>
                <select id="{{ $formId }}-subscription-item" name="subscription_item_id" class="cs-control" required
                    aria-invalid="{{ $errors->has('subscription_item_id') ? 'true' : 'false' }}"
                    aria-describedby="{{ $formId }}-subscription-item-hint {{ $formId }}-subscription-item-error">
                    <option value="">{{ get_phrase('Choose a domain') }}</option>
                    @foreach ($subscriptionDomains as $domain)
                        <option value="{{ $domain->id }}" @selected(old('subscription_item_id') == $domain->id)>
                            {{ $domain->domain_name }} — {{ $domain->company_name ?: get_phrase('Subscription') }} #{{ $domain->subscription_id }}
                        </option>
                    @endforeach
                </select>
                <p id="{{ $formId }}-subscription-item-hint" class="cs-hint">
                    @if ($subscriptionDomains->isEmpty())
                        {{ get_phrase('No active domain is linked to your subscription. Check your subscription email or ask an administrator to activate the domain.') }}
                    @else
                        {{ get_phrase('Only your active subscription domains are shown.') }}
                    @endif
                </p>
                <p id="{{ $formId }}-subscription-item-error" class="cs-error">@error('subscription_item_id'){{ $message }}@enderror</p>
            </div>
        </section>

        {{-- Section 02 --}}
        <section class="cs-section" aria-labelledby="{{ $formId }}-message-title">
            <div class="cs-section-head">
                <span class="cs-step" aria-hidden="true">02</span>
                <div>
                    <h4 id="{{ $formId }}-message-title">{{ get_phrase('Tell us what happened') }}</h4>
                    <p>{{ get_phrase('The right context helps us understand your request.') }}</p>
                </div>
            </div>
            <div class="cs-field">
                <div class="cs-label-line">
                    <label for="{{ $formId }}-message">{{ get_phrase('Message') }} <span class="cs-required" aria-hidden="true">*</span></label>
                </div>
                <textarea id="{{ $formId }}-message" name="message" class="cs-control" rows="6" required
                    placeholder="{{ get_phrase('Describe the issue, what you expected, and any error message you received...') }}"
                    aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                    aria-describedby="{{ $formId }}-message-hint {{ $formId }}-message-error">{{ old('message') }}</textarea>
                <p id="{{ $formId }}-message-hint" class="cs-hint">{{ get_phrase('Do not include passwords, OTPs or payment card details.') }}</p>
                <p id="{{ $formId }}-message-error" class="cs-error">@error('message'){{ $message }}@enderror</p>
            </div>
            <details class="cs-help">
                <summary>{{ get_phrase('What details should I include?') }}</summary>
                <p>{{ get_phrase('Mention the affected page or feature, the steps that led to the issue, and what happened instead of the expected result.') }}</p>
            </details>
        </section>

        {{-- Section 03 --}}
        <section class="cs-section" aria-labelledby="{{ $formId }}-attachment-title">
            <div class="cs-section-head">
                <span class="cs-step" aria-hidden="true">03</span>
                <div>
                    <h4 id="{{ $formId }}-attachment-title">{{ get_phrase('Supporting attachment') }}</h4>
                    <p>{{ get_phrase('Add a screenshot or document for context.') }}</p>
                </div>
            </div>
            <div class="cs-label-line">
                <span class="cs-hint">{{ get_phrase('One file per ticket') }}</span>
                <span class="cs-optional">{{ get_phrase('Optional') }}</span>
            </div>
            <div class="cs-upload">
                <div class="cs-upload-title">
                    <i class="bi bi-paperclip" aria-hidden="true"></i>
                    <div>
                        <label for="{{ $formId }}-file">{{ get_phrase('Attach a file') }}</label>
                        <span>{{ get_phrase('Choose a file from your device') }}</span>
                    </div>
                </div>
                <input id="{{ $formId }}-file" name="file" type="file" class="cs-file"
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                    aria-invalid="{{ $errors->has('file') ? 'true' : 'false' }}"
                    aria-describedby="{{ $formId }}-file-hint {{ $formId }}-file-error">
                <p id="{{ $formId }}-file-hint" class="cs-hint">{{ get_phrase('JPG, JPEG, PNG, PDF, DOC or DOCX. Maximum 10 MB.') }}</p>
                <p id="{{ $formId }}-file-error" class="cs-error">@error('file'){{ $message }}@enderror</p>
            </div>
        </section>
    </div>

    <footer class="cs-footer">
        <button class="cs-submit" type="submit" @if ($subscriptionDomains->isEmpty()) disabled @endif>
            <span>{{ get_phrase('Create Support Ticket') }}</span>
            <i class="bi bi-arrow-right" aria-hidden="true"></i>
        </button>
        <p><span class="cs-required">*</span> {{ get_phrase('Required fields. Your ticket number is generated after submission.') }}</p>
    </footer>
</form>

