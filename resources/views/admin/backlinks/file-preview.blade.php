@extends('index')

@push('title', get_phrase('Backlink File Preview'))

@push('css')

<style>
    .excel-preview-page {
        --excel-green: #107c41;
        --excel-green-dark: #0b5f31;
        --excel-green-soft: #e9f4ee;
        --excel-grid: #d8dde3;
        --excel-head: #f3f3f3;
        --excel-text: #202124;
        color: var(--excel-text);
    }

    .excel-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
    }

    .excel-file-heading {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
    }

    .excel-file-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        color: #fff;
        background: linear-gradient(145deg, #188c4c, var(--excel-green));
        box-shadow: 0 8px 20px rgba(16, 124, 65, .20);
        font-size: 21px;
    }

    .excel-file-heading h4 {
        max-width: 680px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        margin: 0 0 3px;
        font-size: 20px;
        font-weight: 750;
    }

    .excel-file-heading small { color: #697386; }

    .excel-header-actions { display: flex; gap: 9px; flex-wrap: wrap; }

    .excel-btn {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 15px;
        border: 1px solid #d9dee5;
        border-radius: 9px;
        color: #303846;
        background: #fff;
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
        transition: .15s ease;
    }

    .excel-btn:hover { color: var(--excel-green); border-color: var(--excel-green); }

    .excel-btn.is-primary { color: #fff; border-color: var(--excel-green); background: var(--excel-green); }

    .excel-btn.is-primary:hover { color: #fff; border-color: var(--excel-green-dark); background: var(--excel-green-dark); }

    .excel-window {
        overflow: hidden;
        border: 1px solid #cfd5dc;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
    }

    .excel-titlebar {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 7px 14px;
        color: #fff;
        background: var(--excel-green);
    }

    .excel-titlebar-name {
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
        font-weight: 650;
    }

    .excel-titlebar-name span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .excel-titlebar-meta { flex: 0 0 auto; font-size: 11px; opacity: .88; }

    .excel-ribbon-tabs {
        min-height: 37px;
        display: flex;
        align-items: flex-end;
        gap: 4px;
        padding: 0 12px;
        border-bottom: 1px solid #e1e5ea;
        background: #fff;
    }

    .excel-ribbon-tab {
        padding: 10px 12px 8px;
        border-bottom: 2px solid transparent;
        color: #505967;
        font-size: 12px;
        font-weight: 600;
    }

    .excel-ribbon-tab.is-active { color: var(--excel-green); border-bottom-color: var(--excel-green); }

    .excel-toolbar {
        min-height: 52px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 13px;
        border-bottom: 1px solid #dfe3e8;
        background: #fafafa;
    }

    .excel-tool {
        width: 32px;
        height: 32px;
        display: grid;
        place-items: center;
        border: 1px solid transparent;
        border-radius: 5px;
        color: #4d5663;
        background: transparent;
        font-size: 12px;
    }

    .excel-tool:hover { border-color: #d8dde3; background: #fff; }

    .excel-tool-separator { width: 1px; height: 28px; margin: 0 3px; background: #d9dde2; }

    .excel-font-box {
        height: 32px;
        display: flex;
        align-items: center;
        padding: 0 10px;
        border: 1px solid #d8dde3;
        border-radius: 5px;
        color: #4d5663;
        background: #fff;
        font-size: 12px;
    }

    .excel-formula-bar {
        min-height: 39px;
        display: grid;
        grid-template-columns: 78px 38px minmax(0, 1fr);
        border-bottom: 1px solid #cfd5dc;
        background: #fff;
    }

    .excel-name-box,
    .excel-fx,
    .excel-formula-value {
        display: flex;
        align-items: center;
        min-width: 0;
        padding: 7px 10px;
        border-right: 1px solid #d8dde3;
        font-size: 12px;
    }

    .excel-name-box { justify-content: center; font-weight: 650; }

    .excel-fx { justify-content: center; color: #667085; font-family: Georgia, serif; font-style: italic; font-size: 15px; }

    .excel-formula-value {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-right: 0;
        color: #3d4653;
    }

    .excel-grid-wrap {
        position: relative;
        width: 100%;
        max-height: 64vh;
        overflow: auto;
        background: #fff;
        scrollbar-color: #b7bec8 #f1f3f5;
        scrollbar-width: thin;
    }

    .excel-grid-wrap::-webkit-scrollbar { width: 13px; height: 13px; }
    .excel-grid-wrap::-webkit-scrollbar-track { background: #f1f3f5; }
    .excel-grid-wrap::-webkit-scrollbar-thumb { background: #b7bec8; border: 3px solid #f1f3f5; border-radius: 8px; }

    .excel-grid {
        width: max-content;
        min-width: 100%;
        table-layout: fixed;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
        font-family: Calibri, Arial, sans-serif;
        font-size: 13px;
    }

    .excel-grid th,
    .excel-grid td {
        height: 30px;
        min-width: 150px;
        max-width: 360px;
        padding: 5px 8px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-right: 1px solid var(--excel-grid);
        border-bottom: 1px solid var(--excel-grid);
        background: #fff;
        font-weight: 400;
        cursor: cell;
    }

    .excel-grid .excel-row-number,
    .excel-grid .excel-corner {
        min-width: 48px;
        width: 48px;
        max-width: 48px;
        padding: 0;
        text-align: center;
        color: #5f6875;
        background: var(--excel-head);
        cursor: default;
        user-select: none;
    }

    .excel-grid .excel-column-letter {
        position: sticky;
        top: 0;
        z-index: 5;
        height: 27px;
        padding: 3px 8px;
        text-align: center;
        color: #4f5865;
        background: var(--excel-head);
        font-size: 12px;
        font-weight: 600;
        cursor: default;
        user-select: none;
    }

    .excel-grid .excel-corner {
        position: sticky;
        top: 0;
        left: 0;
        z-index: 8;
    }

    .excel-grid tbody .excel-row-number {
        position: sticky;
        left: 0;
        z-index: 3;
    }

    .excel-grid .excel-header-cell { font-weight: 700; background: #f9fbfa; }

    .excel-grid td.excel-selected {
        position: relative;
        overflow: visible;
        outline: 2px solid var(--excel-green);
        outline-offset: -2px;
        z-index: 2;
    }

    .excel-grid td.excel-selected::after {
        content: '';
        position: absolute;
        right: -3px;
        bottom: -3px;
        width: 6px;
        height: 6px;
        border: 1px solid #fff;
        background: var(--excel-green);
    }

    .excel-grid tr:hover td:not(.excel-row-number) { background: #fbfefc; }

    .excel-sheetbar {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0 13px;
        border-top: 1px solid #d8dde3;
        background: #f7f8f9;
    }

    .excel-sheet-left { align-self: stretch; display: flex; align-items: center; gap: 6px; }

    .excel-sheet-nav { color: #68717e; font-size: 11px; }

    .excel-sheet-tab {
        align-self: stretch;
        display: flex;
        align-items: center;
        padding: 0 20px;
        border-bottom: 3px solid var(--excel-green);
        color: var(--excel-green-dark);
        background: #fff;
        font-size: 12px;
        font-weight: 700;
    }

    .excel-sheet-status { color: #68717e; font-size: 11.5px; }

    .excel-empty {
        padding: 55px 20px;
        text-align: center;
        color: #77808e;
    }

    /* CSV viewer */

    .csv-window {
        overflow: hidden;
        border: 1px solid #d5dce5;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
    }

    .csv-titlebar {
        min-height: 58px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 10px 16px;
        color: #fff;
        background: linear-gradient(135deg, #087f8c, #0f9dab);
    }

    .csv-title-left { min-width: 0; display: flex; align-items: center; gap: 11px; }

    .csv-badge {
        flex: 0 0 auto;
        padding: 6px 9px;
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 7px;
        background: rgba(255,255,255,.14);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .06em;
    }

    .csv-title-name {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 700;
    }

    .csv-title-meta { flex: 0 0 auto; font-size: 11px; opacity: .9; }

    .csv-info-bar {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
        min-height: 46px;
        padding: 8px 14px;
        border-bottom: 1px solid #dfe4ea;
        background: #f8fafb;
    }

    .csv-info-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        border: 1px solid #dce3e9;
        border-radius: 7px;
        color: #596474;
        background: #fff;
        font-size: 11.5px;
        font-weight: 600;
    }

    .csv-grid-wrap {
        width: 100%;
        max-height: 64vh;
        overflow: auto;
        scrollbar-color: #b7bec8 #f1f3f5;
        scrollbar-width: thin;
    }

    .csv-grid-wrap::-webkit-scrollbar { width: 13px; height: 13px; }
    .csv-grid-wrap::-webkit-scrollbar-track { background: #f1f3f5; }
    .csv-grid-wrap::-webkit-scrollbar-thumb { background: #b7bec8; border: 3px solid #f1f3f5; border-radius: 8px; }

    .csv-grid {
        width: max-content;
        min-width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
        color: #273142;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 12px;
    }

    .csv-grid th,
    .csv-grid td {
        height: 36px;
        min-width: 160px;
        max-width: 420px;
        padding: 7px 11px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-right: 1px solid #e0e5eb;
        border-bottom: 1px solid #e0e5eb;
        text-align: left;
    }

    .csv-grid thead th {
        position: sticky;
        top: 0;
        z-index: 4;
        color: #075f69;
        background: #e9f7f8;
        font-weight: 800;
    }

    .csv-grid .csv-row-number {
        position: sticky;
        left: 0;
        z-index: 3;
        width: 58px;
        min-width: 58px;
        max-width: 58px;
        padding: 0;
        text-align: center;
        color: #77808d;
        background: #f5f7f9;
        font-weight: 600;
        user-select: none;
    }

    .csv-grid thead .csv-row-number { z-index: 6; color: #075f69; background: #dff2f4; }

    .csv-grid tbody tr:nth-child(even) td:not(.csv-row-number) { background: #fafcfd; }
    .csv-grid tbody tr:hover td:not(.csv-row-number) { background: #f0fafb; }

    .csv-footer {
        min-height: 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 8px 14px;
        border-top: 1px solid #dce2e8;
        color: #687384;
        background: #f8fafb;
        font-size: 11.5px;
    }

    @media (max-width: 768px) {
        .excel-page-header { align-items: flex-start; flex-direction: column; }
        .excel-header-actions { width: 100%; }
        .excel-header-actions .excel-btn { flex: 1; }
        .excel-toolbar { overflow-x: auto; }
        .excel-titlebar-meta { display: none; }
        .excel-grid-wrap { max-height: 58vh; }
        .csv-title-meta { display: none; }
        .csv-grid-wrap { max-height: 58vh; }
        .csv-footer { align-items: flex-start; flex-direction: column; }
    }
</style>

@endpush

@section('content')

@php
    $headers = is_array($upload->headers) ? $upload->headers : [];
    $isExcel = in_array(strtolower($upload->extension), ['xls', 'xlsx'], true);

    $columnLetter = function (int $index): string {
        $letter = '';
        $number = $index + 1;

        while ($number > 0) {
            $number--;
            $letter = chr(65 + ($number % 26)) . $letter;
            $number = intdiv($number, 26);
        }

        return $letter;
    };
@endphp

<div class="excel-preview-page">

    <div class="excel-page-header">

        <div class="excel-file-heading">

            <span class="excel-file-icon">
                <i class="fa-solid {{ $isExcel ? 'fa-file-excel' : 'fa-file-csv' }}"></i>
            </span>

            <div class="min-width-0">
                <h4 title="{{ $upload->original_name }}">{{ $upload->original_name }}</h4>
                <small>
                    {{ $isExcel
                        ? 'Excel workbook preview · First 100 data rows · First worksheet'
                        : 'CSV data preview · First 100 data rows · Comma-separated values' }}
                </small>
            </div>

        </div>

        <div class="excel-header-actions">

            <a href="{{ route('admin.backlinks.index') }}" class="excel-btn">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>

            <a href="{{ route('admin.backlinks.files.download', $upload) }}" class="excel-btn is-primary">
                <i class="fa-solid fa-download"></i> Download Original
            </a>

        </div>

    </div>

    @if($isExcel)

        <div class="excel-window">

        <div class="excel-titlebar">

            <div class="excel-titlebar-name">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>{{ $upload->original_name }}</span>
            </div>

            <div class="excel-titlebar-meta">Preview mode · Read only</div>

        </div>

        <div class="excel-ribbon-tabs" aria-hidden="true">
            <span class="excel-ribbon-tab">File</span>
            <span class="excel-ribbon-tab is-active">Home</span>
            <span class="excel-ribbon-tab">Insert</span>
            <span class="excel-ribbon-tab">Data</span>
            <span class="excel-ribbon-tab">View</span>
        </div>

        <div class="excel-toolbar" aria-hidden="true">
            <span class="excel-tool"><i class="fa-solid fa-paste"></i></span>
            <span class="excel-tool"><i class="fa-solid fa-scissors"></i></span>
            <span class="excel-tool"><i class="fa-regular fa-copy"></i></span>
            <span class="excel-tool-separator"></span>
            <span class="excel-font-box">Calibri</span>
            <span class="excel-font-box">11</span>
            <span class="excel-tool"><i class="fa-solid fa-bold"></i></span>
            <span class="excel-tool"><i class="fa-solid fa-italic"></i></span>
            <span class="excel-tool"><i class="fa-solid fa-underline"></i></span>
            <span class="excel-tool-separator"></span>
            <span class="excel-tool"><i class="fa-solid fa-align-left"></i></span>
            <span class="excel-tool"><i class="fa-solid fa-align-center"></i></span>
            <span class="excel-tool"><i class="fa-solid fa-align-right"></i></span>
        </div>

        <div class="excel-formula-bar">
            <div class="excel-name-box" id="excelCellName">A1</div>
            <div class="excel-fx">fx</div>
            <div class="excel-formula-value" id="excelCellValue">{{ $headers[0] ?? '' }}</div>
        </div>

        @if(count($headers))

            <div class="excel-grid-wrap">

                <table class="excel-grid" id="excelPreviewGrid">

                    <thead>
                        <tr>
                            <th class="excel-corner"></th>

                            @foreach($headers as $columnIndex => $header)
                                <th class="excel-column-letter">{{ $columnLetter($columnIndex) }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <th class="excel-row-number">1</th>

                            @foreach($headers as $columnIndex => $header)
                                <td
                                    class="excel-cell excel-header-cell {{ $loop->first ? 'excel-selected' : '' }}"
                                    data-cell="{{ $columnLetter($columnIndex) }}1"
                                    data-value="{{ $header ?: '(Unnamed)' }}"
                                    title="{{ $header ?: '(Unnamed)' }}">
                                    {{ $header ?: '(Unnamed)' }}
                                </td>
                            @endforeach
                        </tr>

                        @forelse($rows as $row)

                            <tr>
                                <th class="excel-row-number">{{ $loop->iteration + 1 }}</th>

                                @foreach($headers as $columnIndex => $header)
                                    @php($cellValue = $row[$columnIndex] ?? '')

                                    <td
                                        class="excel-cell"
                                        data-cell="{{ $columnLetter($columnIndex) }}{{ $loop->parent->iteration + 1 }}"
                                        data-value="{{ $cellValue }}"
                                        title="{{ $cellValue }}">
                                        {{ $cellValue }}
                                    </td>
                                @endforeach
                            </tr>

                        @empty

                            <tr>
                                <th class="excel-row-number">2</th>
                                <td colspan="{{ count($headers) }}" class="excel-empty">No data rows found in this file.</td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        @else

            <div class="excel-empty">
                <i class="fa-solid fa-table-cells-large fa-2x mb-3"></i>
                <div>No columns were found in this file.</div>
            </div>

        @endif

        <div class="excel-sheetbar">

            <div class="excel-sheet-left">
                <span class="excel-sheet-nav"><i class="fa-solid fa-backward-step"></i></span>
                <span class="excel-sheet-nav"><i class="fa-solid fa-caret-left"></i></span>
                <span class="excel-sheet-tab">Sheet1</span>
            </div>

            <div class="excel-sheet-status">
                {{ count($rows) }} data {{ count($rows) === 1 ? 'row' : 'rows' }} · {{ count($headers) }} {{ count($headers) === 1 ? 'column' : 'columns' }}
            </div>

        </div>

        </div>

    @else

        <div class="csv-window">

            <div class="csv-titlebar">

                <div class="csv-title-left">
                    <span class="csv-badge">CSV</span>
                    <span class="csv-title-name">{{ $upload->original_name }}</span>
                </div>

                <div class="csv-title-meta">Data preview · Read only</div>

            </div>

            <div class="csv-info-bar">
                <span class="csv-info-chip"><i class="fa-solid fa-code"></i> Delimiter: Comma (,)</span>
                <span class="csv-info-chip"><i class="fa-solid fa-heading"></i> First row: Header</span>
                <span class="csv-info-chip"><i class="fa-solid fa-table-columns"></i> {{ count($headers) }} columns</span>
                <span class="csv-info-chip"><i class="fa-solid fa-list-ol"></i> {{ count($rows) }} data rows shown</span>
            </div>

            @if(count($headers))

                <div class="csv-grid-wrap">

                    <table class="csv-grid">

                        <thead>
                            <tr>
                                <th class="csv-row-number">Line</th>

                                @foreach($headers as $header)
                                    <th title="{{ $header ?: '(Unnamed)' }}">{{ $header ?: '(Unnamed)' }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($rows as $row)

                                <tr>
                                    <td class="csv-row-number">{{ $loop->iteration + 1 }}</td>

                                    @foreach($headers as $columnIndex => $header)
                                        @php($cellValue = $row[$columnIndex] ?? '')

                                        <td title="{{ $cellValue }}">{{ $cellValue }}</td>
                                    @endforeach
                                </tr>

                            @empty

                                <tr>
                                    <td class="csv-row-number">2</td>
                                    <td colspan="{{ count($headers) }}" class="excel-empty">No data rows found in this CSV file.</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            @else

                <div class="excel-empty">
                    <i class="fa-solid fa-file-csv fa-2x mb-3"></i>
                    <div>No columns were found in this CSV file.</div>
                </div>

            @endif

            <div class="csv-footer">
                <span><i class="fa-solid fa-circle-info me-1"></i> CSV files contain plain-text tabular data.</span>
                <span>{{ count($rows) }} rows displayed · {{ count($headers) }} columns</span>
            </div>

        </div>

    @endif

</div>

@endsection

@push('js')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('excelPreviewGrid');
    const nameBox = document.getElementById('excelCellName');
    const valueBox = document.getElementById('excelCellValue');

    if (!grid || !nameBox || !valueBox) {
        return;
    }

    grid.addEventListener('click', function (event) {
        const cell = event.target.closest('.excel-cell');

        if (!cell) {
            return;
        }

        const selectedCell = grid.querySelector('.excel-selected');

        if (selectedCell) {
            selectedCell.classList.remove('excel-selected');
        }

        cell.classList.add('excel-selected');
        nameBox.textContent = cell.dataset.cell || '';
        valueBox.textContent = cell.dataset.value || '';
    });
});
</script>

@endpush