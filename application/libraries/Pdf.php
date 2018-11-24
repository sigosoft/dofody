<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
class Pdf extends DOMPDF
{
    function __construct()
    {
        parent::__construct();
    }
}
/*Author:Tutsway.com */  
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */