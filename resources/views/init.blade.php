<script>
    "use strict";

    $(function(){
        var formElement;
		if($('.ajaxForm:not(.inited)').length > 0){
			$('.ajaxForm:not(.inited)').ajaxForm({
				beforeSend: function(data, form) {
					var formElement = $(form);
				},
				uploadProgress: function(event, position, total, percentComplete) {
				},
				complete: function(xhr) {

					setTimeout(function(){
						distributeServerResponse(xhr.responseText);
					}, 400);

					if($('.ajaxForm.resetable').length > 0){
						$('.ajaxForm.resetable').map(function(index){
							$('.ajaxForm.resetable')[index].reset();
						});
					}
				},
				error: function(e)
				{
					console.log(e);
				}
			});
			$('.ajaxForm:not(.inited)').addClass('inited');
		}

    });

	$(function(){
		if($('select.select2:not(.inited)').length > 0){
			$('select.select2:not(.inited)').select2();
			$('select.select2:not(.inited)').addClass('inited');
		}

	});
</script>

    <script>
$(document).ready(function () {

    // when branch changes -> load departments
    $('#branch_id').on('change', function () {
        var branch_id = $(this).val();
        $('#department_id').html('<option value="">Loading...</option>');
        $('#designation_id').html('<option value="">--Select Designation--</option>');

        if (branch_id) {
            $.ajax({
                url: "{{ route('admin.getDepartmentsByBranch') }}",
                type: "GET",
                data: { branch_id: branch_id },
                success: function (data) {
                    $('#department_id').empty().append('<option value="" disabled selected>--Select Department--</option>');
                    $.each(data, function (key, value) {
                        $('#department_id').append('<option value="' + value.id + '">' + value.title + '</option>');
                    });
                }
            });
        }
    });

    // when department changes -> load designations
    $('#department_id').on('change', function () {
        var department_id = $(this).val();
        $('#designation_id').html('<option value="">Loading...</option>');

        if (department_id) {
            $.ajax({
                url: "{{ route('admin.getDesignationsByDepartment') }}",
                type: "GET",
                data: { department_id: department_id },
                success: function (data) {
                    $('#designation_id').empty().append('<option value="" disabled selected>--Select Designation--</option>');
                    $.each(data, function (key, value) {
                        $('#designation_id').append('<option value="' + value.id + '">' + value.title + '</option>');
                    });
                }
            });
        }
    });

});
</script>




<script>
    function removeUserPhoto() {
        if (!confirm('Are you sure you want to remove this photo?')) return;

        // mark for removal
        document.getElementById('remove_photo').value = 1;

        // clear file input (if user selected one)
        const photoInput = document.getElementById('photo');
        if (photoInput) photoInput.value = '';

        // hide preview UI
        const wrapper = document.getElementById('photo-preview-wrapper');
        if (wrapper) wrapper.remove();
    }
</script>



<script>
    $(document).ready(function () {
        $('select[name="status"]').on('change', function () {
            let status = $(this).val();

            if (status === 'call') {
                $('#call_schedule_box').removeClass('d-none');
            } else {
                $('#call_schedule_box').addClass('d-none');
            }
        });

        // trigger on load (important for edit case)
        $('select[name="status"]').trigger('change');
    });
</script>
