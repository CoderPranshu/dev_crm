<div class="table-responsive">
    <table class="table eTable">
        <thead>
            <tr>
                <th class="">#</th>
                <th class="">{{ get_phrase('Product') }}</th>
                <th class="">{{ get_phrase('Warehouse') }}</th>
                <th class="">{{ get_phrase('Movement type') }}</th>
                <th class="">{{ get_phrase('Quantity') }}</th>
                <th class="">{{ get_phrase('Before/After') }}</th>
                <th class="">{{ get_phrase('Reference Type') }}</th>
                <th class="">{{ get_phrase('Reference Id') }}</th>
                <th class="">{{ get_phrase('Note') }}</th>
                <th class="text-center">{{ get_phrase('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movements as $move)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $move->product->name ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $move->warehouse->name ?? 'Global Stock' }}
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ ucfirst(str_replace('_', ' ', $move->movement_type)) }}
                        </span>
                    </td>
                    <td>{{ number_format($move->quantity, 2) }}</td>

                    <td>
                        {{ number_format($move->quantity_before, 2) }}
                        →
                        {{ number_format($move->quantity_after, 2) }}
                    </td>
                    <td>{{ $move->reference_type }}</td>
                    <td>{{ $move->reference_id }}</td>
                    <td>{{ $move->note }}</td>
                    <td class="text-center">
                        @can('stockmovement-edit')
                            <a href="#"
                                onclick="showRightModal('{{ route('right_modal', ['view_path' => 'admin/stockmovement/edit', 'id' => $move->id]) }}', '{{ get_phrase('Edit subscriber') }}')"
                                class="btn btn p-0 px-1" title="{{ get_phrase('Edit') }}" data-bs-toggle="tooltip">
                                <i class="fi-rr-pencil"></i>
                            </a>
                        @endcan

                        @can('stockmovement-delete')
                            <a href="#"
                                onclick="confirmModal('{{ route('admin.stockmovement.delete', $move->id) }}')"
                                class="btn btn p-0 px-1" title="{{ get_phrase('Delete') }}" data-bs-toggle="tooltip">
                                <i class="fi-rr-trash"></i>
                            </a>
                        @endcan

                        @can('stockmovement-show')
                            <a href="{{ route('admin.stockmovement.show', $move->id) }}" class="btn btn p-0 px-1"
                                title="{{ get_phrase('View') }}" data-bs-toggle="tooltip">
                                <i class="fi-rr-eye"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3 ajax-pagination">
    {{ $movements->appends(request()->query())->links() }}
</div>
