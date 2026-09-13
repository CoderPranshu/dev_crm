<script>
$(document).ready(function() {

    const selectedBranch = "{{ $user->branch_id }}";
    const selectedDepartment = "{{ $user->department_id }}";
    const selectedDesignation = "{{ $user->designation_id }}";

    if (selectedBranch) {
        loadDepartments(selectedBranch, selectedDepartment, selectedDesignation);
    }

    $('#branch_id').on('change', function() {
        const branch_id = $(this).val();
        $('#department_id').html('<option value="">Loading...</option>');
        $('#designation_id').html('<option value="">--Select Designation--</option>');
        loadDepartments(branch_id);
    });

    $('#department_id').on('change', function() {
        const department_id = $(this).val();
        $('#designation_id').html('<option value="">Loading...</option>');
        loadDesignations(department_id, selectedDesignation);
    });

    // ----------------------
    // Load Departments
    // ----------------------
    function loadDepartments(branch_id, selectedDept = null, selectedDesig = null) {
        if (!branch_id) return;

        $.ajax({
            url: "{{ route('admin.getDepartmentsByBranch') }}",
            type: "GET",
            data: { branch_id: branch_id },
            success: function(data) {
                $('#department_id').empty().append('<option value="" disabled>--Select Department--</option>');

                let deptSelected = false;
                $.each(data, function(_, value) {
                    const isSelected = selectedDept && value.id == selectedDept ? 'selected' : '';
                    if (isSelected) deptSelected = true;
                    $('#department_id').append(`<option value="${value.id}" ${isSelected}>${value.title}</option>`);
                });

                // ✅ If department is preselected, now load its designations
                if (deptSelected && selectedDept) {
                    // Delay a bit to ensure dropdown renders first
                    setTimeout(function() {
                        loadDesignations(selectedDept, selectedDesig);
                    }, 200);
                } else {
                    $('#designation_id').html('<option value="" disabled selected>--Select Designation--</option>');
                }
            }
        });
    }

    // ----------------------
    // Load Designations
    // ----------------------
    function loadDesignations(department_id, selectedDesig = null) {
        if (!department_id) return;

        $.ajax({
            url: "{{ route('admin.getDesignationsByDepartment') }}",
            type: "GET",
            data: { department_id: department_id },
            success: function(data) {
                $('#designation_id').empty().append('<option value="" disabled>--Select Designation--</option>');

                let desigMatched = false;
                $.each(data, function(_, value) {
                    const isSelected = selectedDesig && value.id == selectedDesig ? 'selected' : '';
                    if (isSelected) desigMatched = true;
                    $('#designation_id').append(`<option value="${value.id}" ${isSelected}>${value.title}</option>`);
                });

                // If select2 is used, re-initialize so preselected value shows
                if ($('.select2').length) {
                    $('#designation_id').trigger('change.select2');
                }
            }
        });
    }

});
</script>
