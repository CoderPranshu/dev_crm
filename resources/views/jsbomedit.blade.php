<!-- JS for Add/Remove Rows -->
<script>
let i = {{ count($bom->items) }};

document.getElementById('addRow').addEventListener('click', () => {
    let row = `
        <tr>
            <td>
                <select name="items[${i}][raw_product_id]" class="eForm-control form-control" required>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="number" step="1" name="items[${i}][quantity]"
                       class="eForm-control form-control" required>
            </td>

            <td>
                <input type="number" step="1" name="items[${i}][wastage_percent]"
                       class="eForm-control form-control">
            </td>

            <td>
                <button type="button" class="btn-form btn-sm btn-danger removeRow">X</button>
            </td>
        </tr>
    `;
    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', row);
    i++;
});

document.addEventListener('click', function(e){
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>
