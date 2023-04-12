<?php

require __DIR__ . '/vendor/autoload.php';

use SOLID\Report\Report;

use SOLID\Export\{ExportBase, ExportHTML, ExportJSON};

// $export = new ExportHTML();
// $export = new ExportBase();
$export = new ExportJSON();

echo (new Report($export))->viewReport();
