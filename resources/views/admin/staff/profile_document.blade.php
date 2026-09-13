@php
    $branches = DB::table('branches')->get();
@endphp

<form action="{{ route('admin.staff.doc.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="fpb-7">
                <label class="eForm-label">Upload Documents</label>
                <input name="document[]" type="file" class="form-control eForm-control" multiple />
                <small class="text-muted">You can select multiple files</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="fpb-7">
                <label class="eForm-label">Aadhar Card</label>
                <input type="file" class="form-control eForm-control" name="aadhar_image">
            </div>
        </div>

        <div class="col-md-6">
            <div class="fpb-7">
                <label class="eForm-label">Pan Card</label>
                <input type="file" class="eForm-control form-control" name="pan_image">
            </div>
        </div>

        <div class="col-md-6">
            <div class="fpb-7">
                <label class="eForm-label">Bank Acc Details</label>
                <input type="file" class="eForm-control form-control" name="bank_acc_image">
            </div>
        </div>
    </div>

    {{-- ================= EXISTING DOCUMENTS ================= --}}
    <div class="mt-4">
        <h6 class="eForm-label">Uploaded Documents:</h6>
        <div class="row">

            {{-- AADHAR --}}
            @if ($user->aadhar_image)
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                        <a class="text-info" href="{{ asset('uploads/document/' . $user->aadhar_image) }}"
                            target="_blank">
                            Aadhar Card
                        </a>

                        <a href="#" onclick="confirmModal('{{ route('admin.staff.doc.delete', $user->id) }}')"
                            class="btn p-0 px-1">
                            <i class="fi-rr-trash"></i>
                        </a>
                    </div>
                </div>
            @endif

            {{-- PAN --}}
            @if ($user->pan_image)
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                        <a class="text-info" href="{{ asset('uploads/document/' . $user->pan_image) }}" target="_blank">
                            Pan Card
                        </a>

                        <a href="#" onclick="confirmModal('{{ route('admin.staff.doc.delete', $user->id) }}')"
                            class="btn p-0 px-1">
                            <i class="fi-rr-trash"></i>
                        </a>
                    </div>
                </div>
            @endif

            {{-- BANK --}}
            @if ($user->bank_acc_image)
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                        <a class="text-info" href="{{ asset('uploads/document/' . $user->bank_acc_image) }}"
                            target="_blank">
                            Bank Details
                        </a>

                        <a href="#" onclick="confirmModal('{{ route('admin.staff.doc.delete', $user->id) }}')"
                            class="btn p-0 px-1">
                            <i class="fi-rr-trash"></i>
                        </a>
                    </div>
                </div>
            @endif

        </div>

        {{-- MULTIPLE DOCUMENTS --}}
        @foreach ($user->documents as $doc)
            <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                <a class="text-info" href="{{ asset('uploads/document/' . $doc->document) }}" target="_blank">
                    View Document
                </a>

                <a href="#" onclick="confirmModal('{{ route('admin.staff.doc.delete', $doc->id) }}')"
                    class="btn p-0 px-1">
                    <i class="fi-rr-trash"></i>
                </a>
            </div>
        @endforeach
    </div>

    <div class="fpb-7 mt-4">
        <button type="submit" class="eBtn btn-primary">Save Changes</button>
    </div>
</form>
