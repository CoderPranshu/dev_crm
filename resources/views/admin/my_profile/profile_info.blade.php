@push('css')
<style>
    .cs-form-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 20px;
    }
    .cs-card{
        background: var(--cs-surface, #fff);
        border: 1px solid var(--cs-border, #E5E7EB);
        border-radius: var(--cs-radius, 14px);
        padding: 22px 22px 8px;
    }
    .cs-card-header{
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--cs-border, #E5E7EB);
    }
    .cs-card-icon{
        width: 30px; height: 30px;
        border-radius: 9px;
        background: rgba(var(--cs-primary-rgb, 15,142,163), 0.08);
        color: var(--cs-primary, #0F8EA3);
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .cs-card-header h6{
        font-size: 15px;
        font-weight: 650;
        margin: 0;
        color: var(--cs-dark, #1F2937);
    }
    .cs-card-header span{
        display: block;
        font-size: 12px;
        color: var(--cs-muted, #64748B);
        margin-top: 1px;
    }
    .cs-card-full{ grid-column: 1 / -1; }

    .cs-field{ margin-bottom: 16px; }
    .cs-field-row{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .cs-field label{
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--cs-dark, #1F2937);
        margin-bottom: 6px;
    }
    .cs-field label i{ color: var(--cs-muted, #64748B); font-size: 13px; }
    .cs-field .cs-input,
    .cs-field .form-control,
    .cs-field .form-select{
        border: 1px solid var(--cs-border, #E5E7EB);
        border-radius: 10px;
        padding: 10px 13px;
        font-size: 13.5px;
        color: var(--cs-dark, #1F2937);
        background: #FBFCFE;
        transition: border-color 160ms, box-shadow 160ms, background 160ms;
        width: 100%;
    }
    .cs-field .form-control:hover,
    .cs-field .form-select:hover{ border-color: #CBD5E1; }
    .cs-field .form-control:focus,
    .cs-field .form-select:focus{
        outline: none;
        border-color: var(--cs-primary, #0F8EA3);
        box-shadow: 0 0 0 3px rgba(var(--cs-primary-rgb, 15,142,163), 0.12);
        background: #fff;
    }
    .cs-field .form-control[readonly]{
        background: #F1F5F9;
        color: var(--cs-muted, #64748B);
        cursor: not-allowed;
    }
    .cs-field textarea.form-control{ min-height: 96px; resize: vertical; }
    .cs-helper{
        font-size: 11.5px;
        color: var(--cs-muted, #64748B);
        margin-top: 5px;
    }

    .cs-photo-row{
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }
    .cs-photo-preview{
        width: 64px; height: 64px;
        border-radius: 16px;
        object-fit: cover;
        border: 1px solid var(--cs-border, #E5E7EB);
        flex-shrink: 0;
    }
    .cs-photo-input-wrap{ flex: 1; min-width: 0; }

    .cs-form-actions{
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 4px 4px;
    }
    .cs-save-btn{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 10px;
        border: none;
        font-size: 13.5px;
        font-weight: 650;
        color: #fff;
        background: linear-gradient(180deg, var(--cs-secondary, #16B6C8), var(--cs-primary, #0F8EA3));
        box-shadow: 0 6px 16px -6px rgba(var(--cs-primary-rgb, 15,142,163), 0.55);
        cursor: pointer;
        transition: transform 160ms, box-shadow 160ms, opacity 160ms;
    }
    .cs-save-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 22px -8px rgba(var(--cs-primary-rgb, 15,142,163), 0.6); }
    .cs-save-btn:disabled{ opacity: .65; cursor: not-allowed; transform: none; }
    .cs-save-btn .spinner-border{ width: 14px; height: 14px; border-width: 2px; }

    @media (max-width: 767px){
        .cs-form-grid{ grid-template-columns: 1fr; }
        .cs-field-row{ grid-template-columns: 1fr; gap: 0; }
    }
</style>
@endpush

<form action="{{ route('admin.my.profile.update', $user->id) }}" method="post" enctype="multipart/form-data" id="csProfileForm">
    @csrf

    <div class="cs-form-grid">

        <!-- ===================== Personal Information ===================== -->
        <div class="cs-card">
            <div class="cs-card-header">
                <div class="cs-card-icon"><i class="bi bi-person"></i></div>
                <div>
                    <h6>{{ get_phrase('Personal Information') }}</h6>
                    <span>{{ get_phrase('Your name, photo and basic identity details') }}</span>
                </div>
            </div>

            <div class="cs-photo-row">
                <img class="cs-photo-preview" src="{{ get_image('uploads/user-image/' . $user->photo) }}" alt="{{ $user->name }}">
                <div class="cs-photo-input-wrap">
                    <div class="cs-field" style="margin-bottom:0;">
                        <label for="photo"><i class="bi bi-camera"></i>{{ get_phrase('Photo') }}</label>
                        <input type="file" name="photo" class="form-control eForm-control-file" id="photo" accept="image/*">
                        <p class="cs-helper">{{ get_phrase('JPG or PNG, square images look best') }}</p>
                    </div>
                </div>
            </div>

            <div class="cs-field">
                <label for="eInputName"><i class="bi bi-person"></i>{{ get_phrase('Name') }}</label>
                <input value="{{ $user->name }}" name="name" type="text" class="form-control eForm-control" id="eInputName"
                    placeholder="{{ get_phrase('Enter your name') }}" aria-label="{{ get_phrase('Enter your name') }}" required />
            </div>

            <div class="cs-field-row">
                <div class="cs-field">
                    <label for="eInputDate"><i class="bi bi-calendar-heart"></i>{{ get_phrase('Birthday') }}</label>
                    <input type="text" class="form-control eForm-control date-range-picket" id="eInputDate" name="birthday"
                        value="{{ $user->birthday ? date('m/d/Y', strtotime($user->birthday)) : '' }}" placeholder="MM/DD/YYYY" />
                </div>
                <div class="cs-field">
                    <label for="eGenderList"><i class="bi bi-gender-ambiguous"></i>{{ get_phrase('Gender') }}</label>
                    <select name="gender" id="eGenderList" class="form-select eForm-select select2" required>
                        <option value="male" @if (strtolower($user->gender ?? '') == 'male') selected @endif>{{ get_phrase('Male') }}</option>
                        <option value="female" @if (strtolower($user->gender ?? '') == 'female') selected @endif>{{ get_phrase('Female') }}</option>
                    </select>
                </div>
            </div>

            <div class="cs-field">
                <label for="eSectionList"><i class="bi bi-droplet"></i>{{ get_phrase('Blood group') }}</label>
                <select name="blood_group" id="eSectionList" class="form-select eForm-select select2" data-placeholder="{{ get_phrase('Select a blood group') }}">
                    <option value="">{{ get_phrase('Select a blood group') }}</option>
                    <option value="A+" @if ($user->blood_group == 'A+') selected @endif>{{ get_phrase('A Positive') }} (A+)</option>
                    <option value="A-" @if ($user->blood_group == 'A-') selected @endif>{{ get_phrase('A Negative') }} (A-)</option>
                    <option value="B+" @if ($user->blood_group == 'B+') selected @endif>{{ get_phrase('B Positive') }} (B+)</option>
                    <option value="B-" @if ($user->blood_group == 'B-') selected @endif>{{ get_phrase('B Negative') }} (B-)</option>
                    <option value="O+" @if ($user->blood_group == 'O+') selected @endif>{{ get_phrase('O Positive') }} (O+)</option>
                    <option value="O-" @if ($user->blood_group == 'O-') selected @endif>{{ get_phrase('O Negative') }} (O-)</option>
                    <option value="AB+" @if ($user->blood_group == 'AB+') selected @endif>{{ get_phrase('AB Positive') }} (AB+)</option>
                    <option value="AB-" @if ($user->blood_group == 'AB-') selected @endif>{{ get_phrase('AB Negative') }} (AB-)</option>
                </select>
            </div>
        </div>

        <!-- ===================== Contact Information ===================== -->
        <div class="cs-card">
            <div class="cs-card-header">
                <div class="cs-card-icon"><i class="bi bi-telephone"></i></div>
                <div>
                    <h6>{{ get_phrase('Contact Information') }}</h6>
                    <span>{{ get_phrase('How your team can reach you') }}</span>
                </div>
            </div>

            <div class="cs-field">
                <label for="eInputEmail"><i class="bi bi-envelope"></i>{{ get_phrase('Email') }}</label>
                <input value="{{ $user->email }}" name="email" type="email" class="form-control eForm-control" id="eInputEmail"
                    placeholder="{{ get_phrase('Enter your email address') }}" aria-label="{{ get_phrase('Enter your email address') }}" required />
            </div>

            <div class="cs-field">
                <label for="eClassList"><i class="bi bi-shield-check"></i>{{ get_phrase('Role2') }}</label>
                <input value="{{ auth()->user()->getRoleNames()->first() }}" type="text" class="form-control eForm-control" id="eClassList" readonly />
                <p class="cs-helper">{{ get_phrase('Your role is managed by an administrator') }}</p>
            </div>

            <div class="cs-field">
                <label for="eInputPhone"><i class="bi bi-telephone"></i>{{ get_phrase('Phone Number') }}</label>
                <input value="{{ $user->phone }}" name="phone" type="text" class="form-control eForm-control" id="eInputPhone"
                    placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
            </div>

            <div class="cs-field-row">
                <div class="cs-field">
                    <label for="alternative_phone"><i class="bi bi-telephone-plus"></i>{{ get_phrase('Alternative phone number') }}</label>
                    <input value="{{ $user->alternative_phone }}" name="alternative_phone" type="text" class="form-control eForm-control"
                        id="alternative_phone" placeholder="01XXXXXXXXX" aria-label="01XXXXXXXXX" />
                </div>
                <div class="cs-field">
                    <label for="rel_of_alternative_phone"><i class="bi bi-people"></i>{{ get_phrase('Relationship of Contact person') }}</label>
                    <input value="{{ $user->rel_of_alternative_phone }}" name="rel_of_alternative_phone" type="text" class="form-control eForm-control"
                        id="rel_of_alternative_phone" aria-label="{{ get_phrase('Relationship of Contact person') }}" />
                </div>
            </div>
        </div>

        <!-- ===================== Address ===================== -->
        <div class="cs-card">
            <div class="cs-card-header">
                <div class="cs-card-icon"><i class="bi bi-geo-alt"></i></div>
                <div>
                    <h6>{{ get_phrase('Address') }}</h6>
                    <span>{{ get_phrase('Where you currently live and your permanent address') }}</span>
                </div>
            </div>

            <div class="cs-field">
                <label for="eInputAddress"><i class="bi bi-house"></i>{{ get_phrase('Present Address') }}</label>
                <input value="{{ $user->present_address }}" name="present_address" type="text" class="form-control eForm-control" id="eInputAddress"
                    placeholder="{{ get_phrase('Enter your present address') }}" aria-label="{{ get_phrase('Enter your present address') }}" />
            </div>
            <div class="cs-field">
                <label for="eInputAddress2"><i class="bi bi-signpost"></i>{{ get_phrase('Permanent Address') }}</label>
                <input value="{{ $user->permanent_address }}" name="permanent_address" type="text" class="form-control eForm-control" id="eInputAddress2"
                    placeholder="{{ get_phrase('Enter your permanent address') }}" aria-label="{{ get_phrase('Enter your permanent address') }}" />
            </div>
        </div>

        <!-- ===================== About ===================== -->
        <div class="cs-card">
            <div class="cs-card-header">
                <div class="cs-card-icon"><i class="bi bi-chat-square-text"></i></div>
                <div>
                    <h6>{{ get_phrase('About') }}</h6>
                    <span>{{ get_phrase('A short bio your teammates will see on your profile') }}</span>
                </div>
            </div>

            <div class="cs-field">
                <label for="eInputTextarea"><i class="bi bi-card-text"></i>{{ get_phrase('Bio') }}</label>
                <textarea name="bio" class="form-control eForm-control" id="eInputTextarea"
                    placeholder="{{ get_phrase('Tell your team a little about yourself') }}">{{ $user->bio }}</textarea>
            </div>
        </div>

    </div>

    <div class="cs-form-actions">
        <button type="submit" class="cs-save-btn" id="csSaveBtn">
            <span class="cs-save-label"><i class="bi bi-check2"></i> {{ get_phrase('Save Changes') }}</span>
        </button>
    </div>
</form>

@push('js')
<script>
    (function () {
        var form = document.getElementById('csProfileForm');
        var saveBtn = document.getElementById('csSaveBtn');
        if (!form || !saveBtn) return;

        // Live preview of a newly selected photo before upload.
        var photoInput = document.getElementById('photo');
        var preview = document.querySelector('.cs-photo-preview');
        if (photoInput && preview) {
            photoInput.addEventListener('change', function () {
                var file = photoInput.files && photoInput.files[0];
                if (!file) return;
                var reader = new FileReader();
                reader.onload = function (ev) { preview.src = ev.target.result; };
                reader.readAsDataURL(file);
            });
        }

        // Button loading state on submit — degrades gracefully if JS is unavailable,
        // the form still posts normally via its action/method/CSRF as before.
        form.addEventListener('submit', function () {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> ' + {!! json_encode(get_phrase('Saving...')) !!};
        });
    })();
</script>
@endpush