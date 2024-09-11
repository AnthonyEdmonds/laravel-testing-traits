<?php

namespace AnthonyEdmonds\LaravelTestingTraits;

trait GetsRawCsvs
{
    public function processRawCsv(
        string $csv,
        string $delimiter = ',',
        bool $hasHeaders = true,
        ?string $rowIdentifier = null,
    ): array {
        $rows = [];
        $csv = explode("\n", $csv);

        foreach ($csv as $row) {
            $rows[] = str_getcsv($row, $delimiter);
        }

        if ($hasHeaders === true) {
            $headers = $rows[0];
            $data = array_slice($rows, 1);

            $rows = [];

            foreach ($data as $datum) {
                $row = [];

                foreach ($headers as $index => $key) {
                    $row[$key] = $datum[$index] ?? '';
                }

                if ($rowIdentifier !== null) {
                    $rows[$row[$rowIdentifier]] = $row;
                } else {
                    $rows[] = $row;
                }
            }
        }

        return $rows;
    }
}
