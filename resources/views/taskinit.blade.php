<script>
    "use strict";

    /**
     * KRA AJAX FORM HANDLER
     */
    $(function() {

        if ($('.ajaxForm:not(.inited)').length > 0) {

            $('.ajaxForm:not(.inited)').ajaxForm({

                beforeSend: function(data, form) {
                    // optional loader hook
                    let formElement = $(form);
                    formElement.addClass('submitting');
                },

                uploadProgress: function(event, position, total, percentComplete) {
                    // optional progress
                },

                complete: function(xhr) {

                    setTimeout(function() {
                        distributeServerResponse(xhr.responseText);
                    }, 300);

                    // Reset only resetable forms
                    $('.ajaxForm.resetable').each(function() {
                        this.reset();
                    });

                    $('.ajaxForm').removeClass('submitting');
                },

                error: function(e) {
                    console.error('KRA AJAX Error:', e);
                }
            });

            $('.ajaxForm:not(.inited)').addClass('inited');
        }
    });


    $(function() {
        if ($('select.select2:not(.inited)').length > 0) {
            $('select.select2:not(.inited)').select2();
            $('select.select2:not(.inited)').addClass('inited');
        }
    });
</script>


<script>
    $(document).ready(function() {

        // when branch changes -> load departments
        $('#branch_id').on('change', function() {
            var branch_id = $(this).val();
            $('#department_id').html('<option value="">Loading...</option>');
            $('#designation_id').html('<option value="">--Select Designation--</option>');

            if (branch_id) {
                $.ajax({
                    url: "{{ route('admin.getDepartmentsByBranch') }}",
                    type: "GET",
                    data: {
                        branch_id: branch_id
                    },
                    success: function(data) {
                        $('#department_id').empty().append(
                            '<option value="" disabled selected>--Select Department--</option>'
                            );
                        $.each(data, function(key, value) {
                            $('#department_id').append('<option value="' + value
                                .id + '">' + value.title + '</option>');
                        });
                    }
                });
            }
        });

        // when department changes -> load designations
        $('#department_id').on('change', function() {
            var department_id = $(this).val();
            $('#designation_id').html('<option value="">Loading...</option>');

            if (department_id) {
                $.ajax({
                    url: "{{ route('admin.getDesignationsByDepartment') }}",
                    type: "GET",
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        $('#designation_id').empty().append(
                            '<option value="" disabled selected>--Select Designation--</option>'
                            );
                        $.each(data, function(key, value) {
                            $('#designation_id').append('<option value="' + value
                                .id + '">' + value.title + '</option>');
                        });
                    }
                });
            }
        });

    });
</script>
