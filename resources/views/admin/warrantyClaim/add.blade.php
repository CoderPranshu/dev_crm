@php
    $products = \App\Models\Product::where('category_id', '3')->latest()->get();
@endphp

<form action="{{ route('admin.warranty.claim.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Warranty Number --}}
    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Warranty No') }}</label>
        <div style="display:flex; gap:10px;">
            <input type="text" class="form-control eForm-control" name="warranty_no" id="warranty_no"
                placeholder="Enter warranty number">
            <button type="button" class="btn btn-info btn-sm" id="checkWarrantyBtn">
                Check Warranty
            </button>
        </div>

        <small id="warrantyMessage" style="color:red;"></small>
    </div>

    {{-- hidden ids --}}
    <input type="hidden" name="user_id" id="user_id">
    <input type="hidden" name="vendor_id" id="vendor_id">

    {{-- Name --}}
    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Customer Name') }}</label>
        <input type="text" class="form-control eForm-control" name="name" id="name" readonly>
    </div>

    {{-- Email --}}
    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Email') }}</label>
        <input type="email" class="form-control eForm-control" name="email" id="email" readonly>
    </div>

    {{-- Product --}}
    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Product') }}</label>

        <input type="text" class="form-control eForm-control" id="product_name" readonly>

        <input type="hidden" name="product_id" id="product_id">
    </div>

    {{-- Description --}}
    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Description') }}</label>
        <textarea name="description" class="form-control eForm-control" rows="4"
            placeholder="Describe your issue"></textarea>
    </div>

    {{-- File Upload --}}
    <div class="fpb-7">
        <label class="eForm-label">{{ get_phrase('Upload File') }}</label>
        <input type="file" class="form-control eForm-control" name="file">
    </div>

    {{-- Submit --}}
    <div class="fpb-7">
        <button type="submit" class="btn-form my-2 w-100">
            Submit Claim
        </button>
    </div>

</form>

<script>
document.getElementById('checkWarrantyBtn').addEventListener('click', function(){

    let warrantyNo = document.getElementById('warranty_no').value;
    let msg = document.getElementById('warrantyMessage');

    if(warrantyNo == ''){
        msg.innerText = "Please enter warranty number";
        return;
    }

    msg.innerText = "Checking warranty...";

    fetch("{{ route('admin.warranty.claim.fetch-warranty') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            warranty_no : warrantyNo
        })
    })
    .then(res => res.json())
    .then(data => {

        if(data.status){

            msg.style.color = "green";
            msg.innerText = "Warranty found";

            document.getElementById('user_id').value = data.data.user_id;
            document.getElementById('vendor_id').value = data.data.vendor_id;
            document.getElementById('product_id').value = data.data.product_id;

            document.getElementById('name').value = data.data.user_name;
            document.getElementById('email').value = data.data.user_email;
            document.getElementById('product_name').value = data.data.product_name;

        }else{

            msg.style.color = "red";
            msg.innerText = "Warranty not found";

        }

    });

});
</script>
