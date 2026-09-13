@extends('index')
@push('title', get_phrase('My Profile'))
@push('meta')
@endpush
@push('css')
    <style>
        .eForm-label {
            font-weight: 600;
            font-size: 15px;
            margin: 0px;
        }

        .basic-details {
            color: #a3a5af;
            font-size: 14px;
            font-weight: 500;
        }

        .tabs-container {
            border-radius: 20px;
            padding: 25px;
            color: #fff;
        }

        .tabs {
            color: black;
            display: flex;
            gap: 25px;
            border-bottom: 2px solid rgba(94, 88, 88, 0.2);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .tab {
            cursor: pointer;
            padding: 10px;
            font-size: 18px;
            transition: 0.3s ease;
            position: relative;
        }

        .tab.active {
            font-weight: 600;
        }

        .tab.active::after {
            content: "";
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 100%;
            height: 3px;
            background: black;

            border-radius: 50px;
        }

        .tab-content {
            display: none;
            animation: fade 0.4s ease-in-out;
        }

        .tab-content.active {
            display: flex;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .eBreadcrumb-2 li::before {
            color: black;
        }
    </style>
@endpush

@push('js')
    <script>
        const tabs = document.querySelectorAll(".tab");
        const contents = document.querySelectorAll(".tab-content");

        tabs.forEach(tab => {
            tab.addEventListener("click", () => {

                tabs.forEach(t => t.classList.remove("active"));
                contents.forEach(c => c.classList.remove("active"));

                tab.classList.add("active");
                document.getElementById(tab.dataset.tab).classList.add("active");
            });
        });
    </script>
@endpush

@section('content')
    <div class="tabs-container card">

        <div class="mainSection-title">
            <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                <div class="d-flex flex-column">
                    <h4>{{ get_phrase('Candidate') }}</h4>
                    <ul class="d-flex align-items-center eBreadcrumb-2">
                        <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.candidate.index') }}">{{ get_phrase('Candidate') }}</a></li>
                        <li><a href="#">{{ get_phrase('View') }}</a></li>

                    </ul>
                </div>
            </div>
        </div>


        <div class="tabs">
            <div class="tab active" data-tab="home">Basic Infomation</div>
            <div class="tab" data-tab="profile">Resume view</div>
        </div>

        <!-- Start User Profile area -->
        <div class="row tab-content active" id="home">
            <div class="col-md-4 col-xl-3">
                <!-- Left side -->
                <div class="user-profile-area" style="border: 1px solid #eeeef1;">
                    <div class="user-info d-flex flex-column mw-unset">
                        <div class="user-info-basic d-flex flex-column justify-content-center">
                            <div class="user-graphic-element-1">
                                <img src="{{ get_image('assets/images/sprial_1.png') }}" alt="" />
                            </div>
                            <div class="user-graphic-element-2">
                                <img src="{{ get_image('assets/images/polygon_1.png') }}" alt="" />
                            </div>
                            <div class="user-graphic-element-3">
                                <img src="{{ get_image('assets/images/circle_1.png') }}" alt="" />
                            </div>
                            <div class="userImg">
                                <img width="100%" src="{{ get_image('uploads/user-image/' . $candidate->photo) }}"
                                    alt="" />
                            </div>
                            <div class="userContent text-center">
                                <h4 class="title">{{ $candidate->name }}</h4>
                                <p class="info">{{ $candidate->designation }}</p>
                                <p class="user-status-verify">{{ ucfirst($candidate->role) }}</p>
                            </div>
                        </div>
                        <div class="user-info-edit">
                            <div class="user-edit-title d-flex justify-content-between align-items-center">
                                <h3 class="title">{{ get_phrase('Details info') }}</h3>
                            </div>
                            <div class="user-info-edit-items">
                                <div class="item">
                                    <p class="eForm-label ">{{ get_phrase('Email') }}</p>
                                    <p class="basic-details">{{ $candidate->email }}</p>
                                </div>

                                @if ($candidate->phone)
                                    <div class="item">
                                        <p class="eForm-label">{{ get_phrase('Phone Number') }}</p>
                                        <p class="basic-details">{{ $candidate->phone }}</p>
                                    </div>
                                @endif

                                @if ($candidate->present_address)
                                    <div class="item">
                                        <p class="eForm-label">{{ get_phrase('Present Address') }}</p>
                                        <p class="basic-details">{{ $candidate->present_address }}</p>
                                    </div>
                                @endif

                                @if ($candidate->gender)
                                    <div class="item">
                                        <p class="eForm-label">{{ get_phrase('Gender') }}</p>
                                        <p class="basic-details">{{ ucfirst($candidate->gender) }}</p>
                                    </div>
                                @endif

                                @if ($candidate->blood_group)
                                    <div class="item">
                                        <p class="eForm-label">{{ get_phrase('Blood group') }}</p>
                                        <p class="basic-details">{{ $candidate->blood_group }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-xl-9">
                <div class="card">
                    <div class="card-header" style="color: black;">
                        <b>Basic details </b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="eForm-label">{{ get_phrase('Source') }}</label>
                                    <p class="basic-details">{{ $candidate->source }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="eForm-label">{{ get_phrase('Date of birth') }}</label>
                                    <p class="basic-details">{{ $candidate->dob }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="eForm-label">{{ get_phrase('Phone') }}</label>
                                    <p class="basic-details">{{ $candidate->phone }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="eForm-label">{{ get_phrase('Applied job') }}</label>
                                    <p class="basic-details">{{ $candidate->job_name ?? 'N/A' }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="eForm-label">{{ get_phrase('Stage') }}</label>
                                    <p class="basic-details">{{ $candidate->stage->title ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="fpb-7 mb-3">
                                    <label for="" class="eForm-label">{{ get_phrase('Country') }}</label>
                                    <p class="basic-details">{{ $candidate->country }}</p>
                                </div>

                                <div class="fpb-7 mb-3">
                                    <label for="" class="eForm-label">{{ get_phrase('State') }}</label>
                                    <p class="basic-details">{{ $candidate->state }}</p>
                                </div>

                                <div class="fpb-7 mb-3">
                                    <label for="" class="eForm-label">{{ get_phrase('Address') }}</label>
                                    <p class="basic-details">{{ $candidate->address }}</p>
                                </div>

                            </div>
                            <div class="col-4">

                                <div class="fpb-7 mb-3">
                                    <label for="" class="eForm-label">{{ get_phrase('Resume') }}</label><br>
                                    <div>
                                        <a href="{{ asset('uploads/resume/' . $candidate->resume) }}" target="_blank"
                                            style="color: blue;">Download Resume</a>
                                    </div>
                                </div>

                                <div class="fpb-7 mb-3">
                                    <label for="" class="eForm-label">{{ get_phrase('Document') }}</label><br>
                                    <div>
                                        <a href="{{ asset('uploads/resume/' . $candidate->document) }}" target="_blank"
                                            style="color: blue;">Download Document</a>
                                    </div>
                                </div>

                                <div class="fpb-7">
                                    <label for="" class="eForm-label">{{ get_phrase('Final') }}</label>
                                    <p class="basic-details">{{ $candidate->is_final ?? 'Processing' }}</p>
                                </div>

                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End User Profile area -->

        <div class="row tab-content" id="profile">

            <div class="col-12">
                <iframe src="{{ asset('uploads/resume/' . $candidate->resume) }}" width="100%" height="600px"
                    style="border:none;">
                </iframe>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>

    </style>
@endsection
