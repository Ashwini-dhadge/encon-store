<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/tcpdf/tcpdf.php';


class Pdf extends TCPDF {
    protected $pdf;

    // public function __construct() {
    //     parent::__construct();
//     // }
// protected $pdf;


    public function __construct() {
        parent::__construct();
        $this->pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false, false);
        // Set page margins
        $this->pdf->SetMargins(0, 0, 0);

        // Set auto page break
        //$this->pdf->SetAutoPageBreak(TRUE, 10);

        // Set font
        $this->pdf->SetFont('helvetica', '', 8);
        // Additional TCPDF configurations or customizations can be done here
    }

   
    // Add any custom functions or settings here...

}

?>