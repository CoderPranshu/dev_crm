<?php

namespace App\Services;

use Generator;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class BacklinkFileReader
{
    // First row is always the header. First Excel worksheet only.
    public function inspect(string $path, string $extension): array
    {
        $headers = null;
        $preview = [];
        foreach ($this->rows($path, $extension) as $number => $row) {
            if ($number === 1) {
                $headers = array_map(function ($value) {
                    return trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $value));
                }, $row);
            } else {
                $preview[] = $row;
            }
            if (count($preview) >= 5) { break; }
        }
        if (!$headers || !count(array_filter($headers, fn ($v) => $v !== ''))) {
            throw ValidationException::withMessages(['csv' => 'File needs a non-empty header in its first row.']);
        }
        return compact('headers', 'preview');
    }

    public function rows(string $path, string $extension): Generator
    {
        if ($extension === 'csv') {
            $handle = fopen($path, 'rb');
            if (!$handle) { throw new \RuntimeException('Could not read uploaded file.'); }
            try {
                $first = fgets($handle);
                if ($first === false) { return; }
                $delimiter = ',';
                $best = 0;
                foreach ([',', ';', "\t"] as $candidate) {
                    $count = count(str_getcsv($first, $candidate, '"', ''));
                    if ($count > $best) { $best = $count; $delimiter = $candidate; }
                }
                rewind($handle);
                $number = 0;
                while (($row = fgetcsv($handle, 0, $delimiter, '"', '')) !== false) {
                    $number++;
                    if ($number > config('backlink_uploads.max_rows', 100000) + 1 ||
                        count($row) > config('backlink_uploads.max_columns', 100)) {
                        throw ValidationException::withMessages(['csv' => 'File exceeds the row/column limit.']);
                    }
                    yield $number => $row;
                }
            } finally { fclose($handle); }
            return;
        }

        $type = $extension === 'xlsx' ? 'Xlsx' : 'Xls';
        // Restrict reader to the actual selected Excel format.
        IOFactory::identify($path, [$type]);
        $reader = IOFactory::createReader($type);
        $reader->setReadDataOnly(true);
        $info = $reader->listWorksheetInfo($path);
        if (!$info) { throw new \RuntimeException('Workbook has no worksheets.'); }
        $sheetInfo = $info[0];
        $totalRows = (int) $sheetInfo['totalRows'];
        $totalColumns = (int) $sheetInfo['totalColumns'];
        if ($totalRows > config('backlink_uploads.max_rows', 100000) + 1 ||
            $totalColumns > config('backlink_uploads.max_columns', 100)) {
            throw ValidationException::withMessages(['csv' => 'Excel exceeds the row/column limit.']);
        }
        if ($totalRows < 1 || $totalColumns < 1) { return; }
        $reader->setLoadSheetsOnly($sheetInfo['worksheetName']);
        $chunk = (int) config('backlink_uploads.excel_chunk_rows', 1000);
        for ($start = 1; $start <= $totalRows; $start += $chunk) {
            $end = min($totalRows, $start + $chunk - 1);
            $reader->setReadFilter(new class($start, $end) implements IReadFilter {
                private $start;
                private $end;
                public function __construct(int $start, int $end) { $this->start = $start; $this->end = $end; }
                public function readCell(string $columnAddress, int $row, string $worksheetName = ''): bool
                { return $row >= $this->start && $row <= $this->end; }
            });
            $book = $reader->load($path);
            try {
                $sheet = $book->getSheetByName($sheetInfo['worksheetName']);
                for ($number = $start; $number <= $end; $number++) {
                    $row = [];
                    for ($column = 1; $column <= $totalColumns; $column++) {
                        // Raw values; do not execute Excel formulas or external links.
                        $value = $sheet->getCell(Coordinate::stringFromColumnIndex($column).$number)->getValue();
                        $row[] = is_scalar($value) || $value === null ? $value : (string) $value;
                    }
                    yield $number => $row;
                }
            } finally { $book->disconnectWorksheets(); unset($book); }
        }
    }
}
