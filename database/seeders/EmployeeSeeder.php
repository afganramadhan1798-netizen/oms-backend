<?php

namespace Database\Seeders;

use App\Models\User;
use DateTimeImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;
use SimpleXMLElement;
use ZipArchive;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->rowsFromSpreadsheet() as $row) {
            $email = $this->normalizeEmail($row['email'], $row['sn']);

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $row['name'],
                    'password' => Hash::make($this->formatDateOfBirth($row['date_of_birth'])),
                    'role' => $this->inferRole($row['position']),
                    'position' => $row['position'],
                    'status' => 'active',
                ]
            );
        }
    }

    /**
     * @return array<int, array{sn: string, name: string, position: string, date_of_birth: string, email: string}>
     */
    private function rowsFromSpreadsheet(): array
    {
        $path = base_path('Employee List - OMS.xlsx');

        if (! File::exists($path)) {
            throw new RuntimeException("Spreadsheet not found: {$path}");
        }

        $zip = new ZipArchive();

        if ($zip->open($path) !== true) {
            throw new RuntimeException("Unable to open spreadsheet: {$path}");
        }

        $sharedStrings = $this->sharedStrings($zip);
        $worksheet = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($worksheet === false) {
            throw new RuntimeException('Worksheet xl/worksheets/sheet1.xml was not found.');
        }

        $xml = simplexml_load_string($worksheet);

        if (! $xml instanceof SimpleXMLElement) {
            throw new RuntimeException('Unable to parse worksheet XML.');
        }

        $xml->registerXPathNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $rows = $xml->xpath('//main:sheetData/main:row') ?: [];
        $employees = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }

            $values = $this->rowValues($row, $sharedStrings);

            if ($this->isEmptyRow($values)) {
                continue;
            }

            $employees[] = [
                'sn' => trim($values['B'] ?? ''),
                'name' => trim($values['C'] ?? ''),
                'position' => trim($values['D'] ?? ''),
                'date_of_birth' => trim($values['E'] ?? ''),
                'email' => trim($values['F'] ?? ''),
            ];
        }

        return array_values(array_filter($employees, fn (array $employee) => $employee['name'] !== ''));
    }

    /**
     * @return array<int, string>
     */
    private function sharedStrings(ZipArchive $zip): array
    {
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');

        if ($sharedStringsXml === false) {
            return [];
        }

        $xml = simplexml_load_string($sharedStringsXml);

        if (! $xml instanceof SimpleXMLElement) {
            return [];
        }

        $xml->registerXPathNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $items = $xml->xpath('//main:si') ?: [];
        $strings = [];

        foreach ($items as $item) {
            $item->registerXPathNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $texts = $item->xpath('.//main:t') ?: [];
            $strings[] = implode('', array_map(
                static fn (SimpleXMLElement $text): string => (string) $text,
                $texts
            ));
        }

        return $strings;
    }

    /**
     * @param array<int, string> $sharedStrings
     * @return array<string, string>
     */
    private function rowValues(SimpleXMLElement $row, array $sharedStrings): array
    {
        $row->registerXPathNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $cells = $row->xpath('./main:c') ?: [];
        $values = [];

        foreach ($cells as $cell) {
            $cell->registerXPathNamespace('main', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $reference = (string) ($cell['r'] ?? '');
            $column = preg_replace('/\d+/', '', $reference) ?: '';
            $type = (string) ($cell['t'] ?? '');
            $valueNode = $cell->xpath('./main:v');
            $value = isset($valueNode[0]) ? (string) $valueNode[0] : '';

            if ($type === 's' && $value !== '') {
                $value = $sharedStrings[(int) $value] ?? '';
            }

            $values[$column] = trim($value);
        }

        return $values;
    }

    /**
     * @param array<string, string> $values
     */
    private function isEmptyRow(array $values): bool
    {
        foreach ($values as $value) {
            if ($value !== '') {
                return false;
            }
        }

        return true;
    }

    private function normalizeEmail(string $email, string $sn): string
    {
        $email = Str::lower(trim($email));

        if ($email !== '') {
            return $email;
        }

        return "employee-{$sn}@oms.local";
    }

    private function inferRole(string $position): string
    {
        $normalized = Str::lower(trim($position));

        if ($normalized === 'human resources') {
            return 'human_resource';
        }

        if (in_array($normalized, [
            'product manager',
            'project manager',
            'head of product',
        ], true)) {
            return 'product_manager';
        }

        return 'employee';
    }

    private function formatDateOfBirth(string $serial): ?string
    {
        $serial = trim($serial);

        if ($serial === '') {
            return null;
        }

        $date = new DateTimeImmutable('1899-12-30');
        $date = $date->modify('+' . (int) floor((float) $serial) . ' days');

        return $date->format('Ymd');
    }
}
