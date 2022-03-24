<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class Pdf
{
    function createPDF($html, $filename = '', $download = TRUE, $paper = 'A4', $orientation = 'portrait')
    {
        $dompdf = new Dompdf\Dompdf();
        $dompdf->load_html($html);
        $customPaper = array(0, 0, 800, 1000);
        $dompdf->set_paper($customPaper);
        //$dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents($filename . '.pdf', $output);
    }
}
