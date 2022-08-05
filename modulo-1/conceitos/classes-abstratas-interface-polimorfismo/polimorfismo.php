<?php

class Printer {
    public function toPrint()
    {
        return "Printing data...";
    }
}

class HpPrinter extends Printer {
    public function toPrint()
    {
        return "HP Printing data...";
    }
}

class EpsonPrinter extends Printer {
    public function toPrint()
    {
        return "Epson printing data...";
    }
}
$printer = new Printer();
print $printer->toPrint();

//mesmo método em classes diferentes 