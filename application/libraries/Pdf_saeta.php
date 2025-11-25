<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    var $PiePaginaImagenDefault = true;
    
	//Page header
	public function Header() {
		$PaginaWidth = $this->getPageWidth();
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		// Logo
		$image_file = K_PATH_IMAGES.'ifjs-logo.png';

		//$this->Image($image_file, 10, 5, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->Image($image_file, 15, 5, 45, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', '', 12);
		// Title
		$this->SetX(30);
		$this->Cell(0, 0, 'CONTROL DE OBRAS DE TEATRO', 0, false, 'R', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', '', 10);
		$this->SetY(10);
		$this->SetX(30);
		$this->Cell(0, 0, 'INSTITUTO FRANCISCO JAVIER SAETA IAP.', 0, false, 'R', 0, '', 0, false, 'M', 'M');
		$this->SetY(15);
		$this->SetFont('helvetica', '', 9);
		$this->SetX(30);
		$this->Cell(0, 0, '', 0, false, 'R', 0, '', 0, false, 'M', 'M');
		if ($PaginaWidth < 211) {
			$this->Line(10,25,205,25);
		}
		else {
			$this->Line(10,25,287,25);
		}

	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$PaginaWidth = $this->getPageWidth();
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
/*		$image_file = K_PATH_IMAGES.'logo2.png';
		if ($PaginaWidth < 211) {
			$UbicaLogo=100;
		}
		else{
			$UbicaLogo=150;	
		}
		if($this->PiePaginaImagenDefault)
		{
			$this->Image($image_file, $UbicaLogo, 277, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}else
		{
			$this->Image($image_file, $UbicaLogo, 194, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
*/
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		if ($PaginaWidth < 211) {
			$this->Cell(350, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
		else{
			$this->Cell(520, 10, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');			
		}

	}
}