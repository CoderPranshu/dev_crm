<!-- ===================== CENTER MODAL ===================== -->
<div class="modal fade" id="centerModal" tabindex="-1" aria-labelledby="centerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title text-dark fs-6" id="centerModalTitle"></h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" id="centerModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border"></div>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- ===================== JS ===================== -->
<script>
"use strict";

// 🔥 CENTER MODAL (AJAX LOAD)
function modelcenter(url, title) {

    // Set title
    $('#centerModalTitle').text(title);

    // Loader
    $('#centerModalBody').html(`
        <div class="text-center py-5">
            <div class="spinner-border"></div>
        </div>
    `);

    // AJAX call
    $.ajax({
        type: 'GET',
        url: url,
        success: function(response) {
            $('#centerModalBody').html(response);
        },
        error: function() {
            $('#centerModalBody').html(`
                <div class="text-danger text-center py-5">
                    Failed to load content
                </div>
            `);
        }
    });

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('centerModal'));
    modal.show();
}



</script>
