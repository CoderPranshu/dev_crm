<script>
    document.getElementById('bom_id').addEventListener('change', function() {

        let bomId = this.value;

        if (!bomId) {
            document.getElementById('finished_product_name').value = '';
            document.getElementById('finished_product_id').value = '';
            return;
        }

        fetch(`/admin/bom/get-finished-product/${bomId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('finished_product_name').value = data.product_name;
                document.getElementById('finished_product_id').value = data.product_id;
            });
    });
</script>
