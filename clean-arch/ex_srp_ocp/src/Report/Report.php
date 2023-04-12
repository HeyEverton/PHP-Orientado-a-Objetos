<?php

namespace SOLID\Report;

use SOLID\Export\ExportInterface;

class Report
{
    public function __construct(public ExportInterface $export)
    {
    }

    public function viewReport()
    {
        $reportData = $this->getReport();

        return $this->export->doExport($reportData);
    }

    private function getReport(): array
    {
        return [
            'data', 'data2', 'insight 1'
        ];
    }

}
