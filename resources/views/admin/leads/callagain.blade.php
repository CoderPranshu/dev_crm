@extends('index')

@push('title', get_phrase('Call again Leads'))

@section('content')

<div class="container-fluid ca-page">

    <div class="ca-page-head">
        <div>
            <span class="ca-eyebrow">Lead Follow-Up</span>
            <h4>{{ get_phrase('Call again Leads') }}</h4>
            <p>Only leads currently marked as Call Again are shown here.</p>
        </div>

        <div class="ca-head-count">
            <i class="bi bi-telephone-forward"></i>
            {{ number_format($leads->count()) }} Leads
        </div>
    </div>

    <div class="ca-shell">

        <div class="ca-toolbar">
            <div class="ca-toolbar-actions">
                <a href="{{ route('admin.leads.export', request()->route('id')) }}" class="ca-btn ca-btn-success">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    Export CSV
                </a>

                @can('lead-create')
                    <button
                        type="button"
                        class="ca-btn ca-btn-primary"
                        onclick="showRightModal(
                            '{{ route('right_modal', ['view_path' => 'admin/leads/import']) }}',
                            '{{ get_phrase('Import leads') }}'
                        )"
                    >
                        <i class="bi bi-upload"></i>
                        Import CSV
                    </button>
                @endcan
            </div>

            <div class="ca-search">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    id="leadSearch"
                    class="form-control"
                    placeholder="Search name, phone, remarks, requirement, category..."
                >
            </div>
        </div>

        <div class="ca-tabs-wrap">
            <ul class="nav ca-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link {{ !request()->route('id') ? 'active' : '' }}"
                        href="{{ route('admin.leads.callagain') }}"
                    >
                        All
                        <span>{{ $totalCallAgain ?? $leads->count() }}</span>
                    </a>
                </li>

                @foreach ($categories as $cat)
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->route('id') == $cat->id ? 'active' : '' }}"
                            href="{{ route('admin.leads.callagain', $cat->id) }}"
                        >
                            {{ $cat->title }}
                            <span>{{ $categoryCounts[$cat->id] ?? 0 }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="ca-desktop">
            <div class="table-responsive">
                <table class="table ca-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ get_phrase('Title') }}</th>
                            <th>{{ get_phrase('Phone') }}</th>
                            <th>{{ get_phrase('Remarks') }}</th>
                            <th>{{ get_phrase('Requirement') }}</th>
                            <th>{{ get_phrase('Category') }}</th>
                            <th>{{ get_phrase('Status') }}</th>
                            <th>{{ get_phrase('Call Date') }}</th>
                            <th class="text-center">{{ get_phrase('Action') }}</th>
                        </tr>
                    </thead>

                    <tbody id="leadTableBody">
                        @forelse ($leads as $lead)
                            <tr
                                class="ca-search-row"
                                data-search="{{ strtolower(
                                    ($lead->name ?? '') . ' ' .
                                    ($lead->phone ?? '') . ' ' .
                                    ($lead->remarks ?? '') . ' ' .
                                    ($lead->requirement ?? '') . ' ' .
                                    ($lead->leadcat->title ?? '') . ' call again'
                                ) }}"
                            >
                                <td><span class="ca-no">{{ $loop->iteration }}</span></td>

                                <td>
                                    <div class="ca-person">
                                        <div class="ca-avatar">{{ strtoupper(substr($lead->name ?? 'L', 0, 1)) }}</div>
                                        <strong>{{ $lead->name ?? '-' }}</strong>
                                    </div>
                                </td>

                                <td>
                                    <a href="tel:{{ $lead->phone }}" class="ca-phone">
                                        <i class="bi bi-telephone"></i>
                                        {{ $lead->phone ?? '-' }}
                                    </a>
                                </td>

                                <td>
                                    <span class="ca-cut" title="{{ $lead->remarks ?? 'N/A' }}">
                                        {{ $lead->remarks ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ca-cut" title="{{ $lead->requirement ?? '-' }}">
                                        {{ $lead->requirement ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ca-category">{{ $lead->leadcat->title ?? '-' }}</span>
                                </td>

                                <td>
                                    <a
                                        href="javascript:void(0)"
                                        onclick="showRightModal(
                                            '{{ route('right_modal', ['view_path' => 'admin/leads/change_status', 'id' => $lead->id]) }}',
                                            '{{ get_phrase('Change status') }}'
                                        )"
                                        class="ca-status"
                                    >
                                        <span></span>
                                        Call Again
                                    </a>
                                </td>

                                <td>
                                    <div class="ca-date">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ $lead->call_schedule ? \Carbon\Carbon::parse($lead->call_schedule)->format('d M Y, h:i A') : 'N/A' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="ca-actions">
                                        <a href="javascript:void(0)"
                                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/edit', 'id' => $lead->id]) }}', '{{ get_phrase('Edit lead') }}')"
                                           class="ca-action" title="Edit">
                                            <i class="fi-rr-pencil"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/callagaindetails', 'id' => $lead->id, 'name' => 'callagain']) }}', '{{ get_phrase('Call Notes') }}')"
                                           class="ca-action" title="Call Notes">
                                            <i class="fi-rr-phone-call"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/leadschat', 'id' => $lead->id]) }}', '{{ get_phrase('History Chats') }}')"
                                           class="ca-action" title="History">
                                            <i class="fi-rr-eye"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/change_status', 'id' => $lead->id]) }}', '{{ get_phrase('Change status') }}')"
                                           class="ca-action" title="Change Status">
                                            <i class="fi-rr-refresh"></i>
                                        </a>

                                        @can('lead-delete')
                                            <a href="javascript:void(0)"
                                               onclick="confirmModal('{{ route('admin.leadcategory.delete', $lead->id) }}')"
                                               class="ca-action ca-action-danger" title="Delete">
                                                <i class="fi-rr-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    No Call Again leads found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ca-mobile" id="leadMobileList">
            @forelse ($leads as $lead)
                <article
                    class="ca-mobile-card ca-search-card"
                    data-search="{{ strtolower(
                        ($lead->name ?? '') . ' ' .
                        ($lead->phone ?? '') . ' ' .
                        ($lead->remarks ?? '') . ' ' .
                        ($lead->requirement ?? '') . ' ' .
                        ($lead->leadcat->title ?? '') . ' call again'
                    ) }}"
                >
                    <div class="ca-mobile-top">
                        <div class="ca-person">
                            <div class="ca-avatar ca-avatar-lg">{{ strtoupper(substr($lead->name ?? 'L', 0, 1)) }}</div>
                            <div>
                                <strong>{{ $lead->name ?? '-' }}</strong>
                                <small>Lead #{{ $lead->id }}</small>
                            </div>
                        </div>

                        <span class="ca-status">
                            <span></span>
                            Call Again
                        </span>
                    </div>

                    <a href="tel:{{ $lead->phone }}" class="ca-call-box">
                        <div class="ca-call-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <small>Phone</small>
                            <strong>{{ $lead->phone ?? '-' }}</strong>
                        </div>
                        <i class="bi bi-chevron-right"></i>
                    </a>

                    <div class="ca-mobile-grid">
                        <div class="ca-mobile-info">
                            <small>Category</small>
                            <strong>{{ $lead->leadcat->title ?? '-' }}</strong>
                        </div>

                        <div class="ca-mobile-info">
                            <small>Call Date</small>
                            <strong>
                                {{ $lead->call_schedule ? \Carbon\Carbon::parse($lead->call_schedule)->format('d M Y') : 'N/A' }}
                            </strong>
                            @if($lead->call_schedule)
                                <span>{{ \Carbon\Carbon::parse($lead->call_schedule)->format('h:i A') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="ca-mobile-copy">
                        <small>Requirement</small>
                        <p>{{ $lead->requirement ?? '-' }}</p>
                    </div>

                    @if(!empty($lead->remarks))
                        <div class="ca-mobile-copy">
                            <small>Remarks</small>
                            <p>{{ $lead->remarks }}</p>
                        </div>
                    @endif

                    <div class="ca-mobile-actions">
                        <a href="javascript:void(0)"
                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/edit', 'id' => $lead->id]) }}', '{{ get_phrase('Edit lead') }}')"
                           class="ca-mobile-btn">
                            <i class="fi-rr-pencil"></i><span>Edit</span>
                        </a>

                        <a href="javascript:void(0)"
                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/callagaindetails', 'id' => $lead->id, 'name' => 'callagain']) }}', '{{ get_phrase('Call Notes') }}')"
                           class="ca-mobile-btn">
                            <i class="fi-rr-phone-call"></i><span>Notes</span>
                        </a>

                        <a href="javascript:void(0)"
                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/leadschat', 'id' => $lead->id]) }}', '{{ get_phrase('History Chats') }}')"
                           class="ca-mobile-btn">
                            <i class="fi-rr-eye"></i><span>History</span>
                        </a>

                        <a href="javascript:void(0)"
                           onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/leads/change_status', 'id' => $lead->id]) }}', '{{ get_phrase('Change status') }}')"
                           class="ca-mobile-btn">
                            <i class="fi-rr-refresh"></i><span>Status</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="ca-mobile-empty">
                    <i class="bi bi-telephone-x"></i>
                    <strong>No Call Again leads found</strong>
                    <span>There are no leads waiting for another call.</span>
                </div>
            @endforelse
        </div>

        <div id="mobileNoResult" class="ca-mobile-empty d-none">
            <i class="bi bi-search"></i>
            <strong>No matching leads found</strong>
            <span>Try another search keyword.</span>
        </div>

    </div>
</div>

@endsection

@push('css')
<style>
.ca-page{--ca:#0F8EA3;--cad:#0B7386;--dark:#1F2937;--muted:#667085;--light:#98A2B3;--border:#E5E7EB;--bg:#F8FAFC;padding-bottom:30px}
.ca-page *{box-sizing:border-box}
.ca-page-head{display:flex;align-items:flex-end;justify-content:space-between;gap:15px;flex-wrap:wrap;margin-bottom:18px}
.ca-eyebrow{display:block;color:var(--ca);font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;margin-bottom:4px}
.ca-page-head h4{margin:0;color:var(--dark);font-size:25px;font-weight:750}
.ca-page-head p{margin:5px 0 0;color:var(--muted);font-size:11px}
.ca-head-count{min-height:36px;padding:0 11px;border:1px solid #DCECEF;border-radius:9px;background:#F3FCFD;color:var(--cad);display:flex;align-items:center;gap:7px;font-size:10px;font-weight:700}
.ca-shell{overflow:hidden;border:1px solid var(--border);border-radius:15px;background:#fff}
.ca-toolbar{padding:14px 16px;border-bottom:1px solid #EDF0F4;display:flex;align-items:center;justify-content:space-between;gap:12px}
.ca-toolbar-actions{display:flex;gap:7px;flex-wrap:wrap}
.ca-btn{min-height:37px;padding:0 12px;border:1px solid transparent;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;gap:6px;text-decoration:none!important;font-size:10px;font-weight:700}
.ca-btn-success{border-color:#B7E4CA;background:#F0FDF4;color:#15803D}
.ca-btn-primary{border-color:var(--ca);background:linear-gradient(180deg,var(--ca),var(--cad));color:#fff}
.ca-search{position:relative;width:min(390px,100%)}
.ca-search>i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--light)}
.ca-search input{height:39px;padding-left:34px;border:1px solid var(--border);border-radius:9px;box-shadow:none!important;font-size:10px}
.ca-tabs-wrap{overflow-x:auto;padding:9px 12px 0;border-bottom:1px solid #EDF0F4}
.ca-tabs{display:flex;flex-wrap:nowrap;gap:4px;min-width:max-content}
.ca-tabs .nav-link{padding:8px 10px;border:0;border-bottom:2px solid transparent;color:#667085;display:flex;align-items:center;gap:5px;font-size:9px;font-weight:700;white-space:nowrap}
.ca-tabs .nav-link span{min-width:18px;height:18px;padding:0 5px;border-radius:999px;background:#F2F4F7;display:inline-flex;align-items:center;justify-content:center;font-size:8px}
.ca-tabs .nav-link.active{border-bottom-color:var(--ca);background:#F4FCFD;color:var(--cad)}
.ca-table{min-width:1180px;font-size:10px}
.ca-table thead th{padding:10px 12px;border-bottom:1px solid #DDE2E8;background:#F8FAFC;color:#667085;font-size:8px;font-weight:800;text-transform:uppercase;white-space:nowrap}
.ca-table tbody td{padding:10px 12px;border-bottom:1px solid #EEF1F4;color:#475467;vertical-align:middle}
.ca-table tbody tr:hover td{background:#FCFDFE}
.ca-no{min-width:28px;height:25px;padding:0 6px;border:1px solid #E4E7EC;border-radius:6px;background:#F9FAFB;display:inline-flex;align-items:center;justify-content:center;font-size:8px}
.ca-person{display:flex;align-items:center;gap:8px;min-width:0}
.ca-avatar{width:30px;height:30px;border-radius:8px;background:#ECFEFF;color:var(--cad);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:9px;font-weight:800}
.ca-person strong{display:block;max-width:160px;overflow:hidden;color:#344054;font-size:10px;font-weight:700;text-overflow:ellipsis;white-space:nowrap}
.ca-person small{display:block;margin-top:2px;color:var(--light);font-size:8px}
.ca-phone{color:#344054;display:inline-flex;align-items:center;gap:5px;text-decoration:none;white-space:nowrap}.ca-phone i{color:var(--ca)}
.ca-cut{display:block;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.ca-category{padding:4px 7px;border:1px solid #D7F0F4;border-radius:6px;background:#F3FCFD;color:var(--cad);font-size:8px;font-weight:700;white-space:nowrap}
.ca-status{padding:5px 7px;border:1px solid #FDE7B0;border-radius:999px;background:#FFFBEB;color:#B45309;display:inline-flex;align-items:center;gap:5px;text-decoration:none!important;font-size:8px;font-weight:800;white-space:nowrap}
.ca-status>span{width:5px;height:5px;border-radius:50%;background:currentColor}
.ca-date{display:flex;align-items:center;gap:5px;white-space:nowrap}.ca-date i{color:var(--light)}
.ca-actions{display:flex;justify-content:center;gap:3px}.ca-action{width:29px;height:29px;border:1px solid #E4E7EC;border-radius:7px;background:#fff;color:#667085;display:inline-flex;align-items:center;justify-content:center;text-decoration:none!important}.ca-action:hover{border-color:var(--ca);background:#F3FCFD;color:var(--cad)}.ca-action-danger:hover{border-color:#FECACA;background:#FEF2F2;color:#DC2626}
.ca-mobile{display:none}
@media(max-width:767px){
.ca-page{padding-left: 0px;padding-right: 0px}.ca-page-head{align-items:flex-start}.ca-page-head h4{font-size:21px}.ca-head-count{width:100%;justify-content:center}
.ca-toolbar{align-items:stretch;flex-direction:column;padding:11px}.ca-toolbar-actions{width:100%}.ca-btn{flex:1}.ca-search{width:100%}
.ca-desktop{display:none}.ca-mobile{display:grid;gap:10px;padding:10px;background:#F8FAFC}
.ca-mobile-card{overflow:hidden;border:1px solid #E5E7EB;border-radius:13px;background:#fff}
.ca-mobile-top{padding:12px;display:flex;align-items:flex-start;justify-content:space-between;gap:8px}.ca-avatar-lg{width:36px;height:36px;border-radius:10px;font-size:11px}
.ca-call-box{margin:0 12px;padding:9px;border:1px solid #D8F0F3;border-radius:9px;background:#F4FCFD;color:var(--cad);display:flex;align-items:center;gap:9px;text-decoration:none!important}
.ca-call-icon{width:30px;height:30px;border-radius:8px;background:var(--ca);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0}.ca-call-box>div:nth-child(2){flex:1}.ca-call-box small,.ca-mobile-info small,.ca-mobile-copy small{display:block;color:var(--light);font-size:7px}.ca-call-box strong{display:block;color:#344054;font-size:11px}.ca-call-box>i:last-child{font-size:10px;color:var(--light)}
.ca-mobile-grid{display:grid;grid-template-columns:1fr 1fr;gap:7px;padding:10px 12px 0}.ca-mobile-info{padding:8px;border:1px solid #EDF0F4;border-radius:8px;background:#FAFBFC}.ca-mobile-info strong{display:block;margin-top:2px;color:#344054;font-size:9px}.ca-mobile-info span{display:block;color:#667085;font-size:7px}
.ca-mobile-copy{margin:8px 12px 0;padding:8px 9px;border-top:1px solid #EEF1F4}.ca-mobile-copy p{margin:3px 0 0;color:#475467;font-size:9px;line-height:1.5;word-break:break-word}
.ca-mobile-actions{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:5px;margin-top:9px;padding:9px 12px;border-top:1px solid #EEF1F4;background:#FCFDFE}.ca-mobile-btn{min-height:38px;border:1px solid #E4E7EC;border-radius:8px;background:#fff;color:#667085;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:3px;text-decoration:none!important;font-size:7px;font-weight:700}
.ca-mobile-empty{padding:40px 18px;text-align:center}.ca-mobile-empty>i{width:48px;height:48px;margin:0 auto 9px;border-radius:12px;background:#ECFEFF;color:var(--ca);display:flex;align-items:center;justify-content:center;font-size:18px}.ca-mobile-empty strong,.ca-mobile-empty span{display:block}.ca-mobile-empty strong{color:#344054;font-size:11px}.ca-mobile-empty span{margin-top:3px;color:var(--light);font-size:8px}
}
@media(max-width:390px){.ca-mobile-top{flex-direction:column}.ca-mobile-actions{grid-template-columns:repeat(2,minmax(0,1fr))}}
</style>
@endpush

@push('js')
<script>
document.addEventListener("DOMContentLoaded",function(){
    const searchInput=document.getElementById("leadSearch");
    const rows=document.querySelectorAll(".ca-search-row");
    const cards=document.querySelectorAll(".ca-search-card");
    const mobileNoResult=document.getElementById("mobileNoResult");
    if(!searchInput)return;
    searchInput.addEventListener("input",function(){
        const value=this.value.toLowerCase().trim();
        let vr=0,vc=0;
        rows.forEach(function(row){
            const ok=(row.dataset.search||"").toLowerCase().includes(value);
            row.style.display=ok?"":"none";
            if(ok)vr++;
        });
        cards.forEach(function(card){
            const ok=(card.dataset.search||"").toLowerCase().includes(value);
            card.style.display=ok?"":"none";
            if(ok)vc++;
        });
        let nr=document.getElementById("leadNoResultRow");
        if(rows.length && vr===0){
            if(!nr){
                const tbody=document.getElementById("leadTableBody");
                if(tbody){
                    nr=document.createElement("tr");
                    nr.id="leadNoResultRow";
                    nr.innerHTML='<td colspan="9" class="text-center text-muted py-4">No matching leads found</td>';
                    tbody.appendChild(nr);
                }
            }
        }else if(nr){nr.remove()}
        if(mobileNoResult){
            mobileNoResult.classList.toggle("d-none",!(cards.length&&vc===0));
        }
    });
});
</script>
@endpush
