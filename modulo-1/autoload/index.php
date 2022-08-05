<?php
// require __DIR__. '/class/JsonExport.php';
// require __DIR__. '/class/XmlExport.php';
require __DIR__.'/autoload_psr4.php';



if ($_GET['export'] == 'xml') {
    print (new XmlExport()) ->doExport();
}
if ($_GET['export'] == 'json') {
    print (new JsonExport()) ->doExport();
}

