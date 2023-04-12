<?php
namespace SOLID\Export;

interface ExportInterface
{
    public function doExport(array $data): string;
}