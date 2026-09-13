<script>
    $(document).ready(function() {
        $('#recruitmentSelect').change(function() {

            let recruitmentId = $(this).val();
            let stageDropdown = $('#stageDropdown');
            stageDropdown.html('<option selected disabled>Loading...</option>');

            $.ajax({
                url: '/admin/recruitment/' + recruitmentId + '/stages',
                type: 'GET',
                success: function(response) {

                    stageDropdown.html('');

                    if (response.stages.length === 0) {
                        stageDropdown.html('<option disabled>No stages found</option>');
                        return;
                    }

                    $.each(response.stages, function(index, stage) {
                        let selected = index === 0 ? 'selected' : '';
                        stageDropdown.append(
                            `<option value="${stage.id}" ${selected}>${stage.title}</option>`
                        );
                    });
                },
                error: function() {
                    stageDropdown.html('<option disabled>Error loading stages</option>');
                }
            });

        });

    });
</script>


<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#email_template')).catch(error => console.error(error));
</script>


<script>
    ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));
</script>
