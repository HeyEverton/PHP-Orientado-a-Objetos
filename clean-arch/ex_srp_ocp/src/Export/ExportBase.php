<?php

namespace SOLID\Export;

class ExportBase implements ExportInterface
{
    public function doExport(array $data): string
    {
        return implode(', ', $data);
    }
}