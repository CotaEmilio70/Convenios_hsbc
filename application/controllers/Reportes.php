<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {
    function __construct(){
        parent::__construct();
        date_default_timezone_set("US/Arizona");
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
    }
    //
    // Corte por fecha y usuario
    //
    function ExportaConvenios()
    {
        if(!VerificarPermisos($this->session->UID, "Reportes", "ExportaConvenios")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }

        // $Usuarioactual = $this->session->UID;
        // $Usuarios = $this->Users_model->GetList();

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y");

        // $Data['Usuarios'] = $Usuarios;
        // $Data['Claveusuarioprimero'] = $Usuarioactual;
        $Data['Fechadefault'] = $TodayDate;
        $Data['title'] = "Exportar convenios";

        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Reportes/ExportaConvenios', $Data);
        $this->load->view('layouts/footer');
    }

    function ExcelConvenios()
    {
        if($this->input->post())
        {
            //
            // Tomamos los rangos de las variables del post y obtenemosla informacion de la
            // tabla
            //
            
            $Cliente = $this->input->post("Cliente");

            $FechaFtmpI = $this->input->post("FechaInicial");
            $FechaI = substr($FechaFtmpI,6,4)."-".substr($FechaFtmpI,3,2)."-".substr($FechaFtmpI,0,2);

            $FechaFtmpF = $this->input->post("FechaFinal");
            $FechaF = substr($FechaFtmpF,6,4)."-".substr($FechaFtmpF,3,2)."-".substr($FechaFtmpF,0,2)." 23:59:59";

            $Convenios = $this->Convenios_model->GetByDateCustom($FechaI,$FechaF,$Cliente);

            // Starting the PHPExcel library
            $this->load->library('Excel');
     
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle("Convenios");

            $this->excel->getActiveSheet()->setCellValue('A1', 'Cuenta');
            $this->excel->getActiveSheet()->setCellValue('B1', 'Saldo act.');
            $this->excel->getActiveSheet()->setCellValue('C1', 'Capital');
            $this->excel->getActiveSheet()->setCellValue('D1', 'Impuestos');
            $this->excel->getActiveSheet()->setCellValue('E1', 'Intereses');
            $this->excel->getActiveSheet()->setCellValue('F1', 'Comisiones');
            $this->excel->getActiveSheet()->setCellValue('G1', 'Fecha neg.');
            $this->excel->getActiveSheet()->setCellValue('H1', 'Q. max.');
            $this->excel->getActiveSheet()->setCellValue('I1', 'Cliente');
            $this->excel->getActiveSheet()->setCellValue('J1', 'PAN');
            $this->excel->getActiveSheet()->setCellValue('K1', 'Sucursal');
            $this->excel->getActiveSheet()->setCellValue('L1', 'Fecha emi.');
            $this->excel->getActiveSheet()->setCellValue('M1', 'Segmento');
            $this->excel->getActiveSheet()->setCellValue('N1', 'Nombre');
            $this->excel->getActiveSheet()->setCellValue('O1', 'Direccion');
            $this->excel->getActiveSheet()->setCellValue('P1', 'Colonia');
            $this->excel->getActiveSheet()->setCellValue('Q1', 'Ciudad');
            $this->excel->getActiveSheet()->setCellValue('R1', 'Estado');
            $this->excel->getActiveSheet()->setCellValue('S1', 'CP');
            $this->excel->getActiveSheet()->setCellValue('T1', 'Pago total');
            $this->excel->getActiveSheet()->setCellValue('U1', 'Creado por');
            $this->excel->getActiveSheet()->setCellValue('V1', 'Creado fecha');
            $this->excel->getActiveSheet()->setCellValue('W1', 'Modificado por');
            $this->excel->getActiveSheet()->setCellValue('X1', 'Modificado fecha');

            $this->excel->getActiveSheet()->setCellValue('Y1', 'Pago 1');
            $this->excel->getActiveSheet()->setCellValue('Z1', 'Fecha pag. 1');
            $this->excel->getActiveSheet()->setCellValue('AA1', 'Pago 2');
            $this->excel->getActiveSheet()->setCellValue('AB1', 'Fecha pag. 2');
            $this->excel->getActiveSheet()->setCellValue('AC1', 'Pago 3');
            $this->excel->getActiveSheet()->setCellValue('AD1', 'Fecha pag. 3');

            $this->excel->getActiveSheet()->getStyle('A1:AD1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('A1:AD1')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth('13');
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth('8');
            $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth('7');
            $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth('17');
            $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth('8');
            $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth('11');
            $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth('10');
            $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth('40');
            $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth('42');
            $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth('20');
            $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth('20');
            $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth('20');
            $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth('7');
            $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth('12');
            $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth('15');
            $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth('20');
            $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth('15');
            $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth('20');

            $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth('8');
            $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth('12');
            $this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth('8');
            $this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth('12');
            $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth('8');
            $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth('12');
            //
            // Inicamos en el renglon 2 y barremos el arreglo generando cada registro en la tabla de Excel
            //


            $row = 2;
            foreach($Convenios as $Convenio) {

                // *********************************************************************************************
                // * Con este ejemplo se puede convertir una fecha a un formato TimeStamp de Unix
                // * Este es un numero entero que representa la fecha y que puede ser interpreado por Excel para
                // * darle tratamiento como fecha en la hoja de calculo
                // **********************************************************************************************
                // $date = date_create($Convenio->Fecha_neg);
                // $Fechaneg = $date->getTimestamp();
                // if (is_int($Fechaneg))
                // {
                //     $this->excel->getActiveSheet()->setCellValueExplicit('G'.$row, PHPExcel_Shared_Date::PHPToExcel( $Fechaneg ) , PHPExcel_Cell_DataType::TYPE_NUMERIC);
                //     $this->excel->getActiveSheet()->getStyle('G'.$row)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
                // }else{
                //     $this->excel->getActiveSheet()->setCellValueExplicit('G'.$row, $Fechaneg, PHPExcel_Cell_DataType::TYPE_STRING);
                // }

                // * Con estas lineas solamente convertimos la fecha de mysql al formato dd-mm-aaaa
                // * Excel le dará tratamiento como texto
                $date = date_create($Convenio->Fecha_neg);
                $Fechaneg=date_format($date, 'd/m/Y');

                $date = date_create($Convenio->Fecha_emi);
                $Fechaemi=date_format($date, 'd/m/Y');

                $this->excel->getActiveSheet()->setCellValueExplicit('A'.$row, $Convenio->Cuenta_12d, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('B'.$row, $Convenio->Saldo_act, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $this->excel->getActiveSheet()->setCellValueExplicit('C'.$row, $Convenio->Saldo_cap, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $this->excel->getActiveSheet()->setCellValueExplicit('D'.$row, $Convenio->Impuestos, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $this->excel->getActiveSheet()->setCellValueExplicit('E'.$row, $Convenio->Intereses, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $this->excel->getActiveSheet()->setCellValueExplicit('F'.$row, $Convenio->Comisiones, PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $this->excel->getActiveSheet()->setCellValueExplicit('G'.$row, $Fechaneg, PHPExcel_Cell_DataType::TYPE_STRING);

                $this->excel->getActiveSheet()->setCellValueExplicit('H'.$row, $Convenio->Quitamax, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $this->excel->getActiveSheet()->setCellValueExplicit('I'.$row, $Convenio->Cliente, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('J'.$row, $Convenio->Cuenta_pan, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('K'.$row, $Convenio->Sucursal, PHPExcel_Cell_DataType::TYPE_STRING);

                $this->excel->getActiveSheet()->setCellValueExplicit('L'.$row, $Fechaemi, PHPExcel_Cell_DataType::TYPE_STRING);

                $this->excel->getActiveSheet()->setCellValueExplicit('M'.$row, $Convenio->Segmento, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('N'.$row, $Convenio->Nombre, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('O'.$row, $Convenio->Calle_num, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('P'.$row, $Convenio->Colonia, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('Q'.$row, $Convenio->Ciudad, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('R'.$row, $Convenio->Estado, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('S'.$row, $Convenio->Cp, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('T'.$row, $Convenio->Total_pago, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $this->excel->getActiveSheet()->setCellValueExplicit('U'.$row, $Convenio->CreatedBy, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('V'.$row, $Convenio->CreatedDate, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('W'.$row, $Convenio->UpdatedBy, PHPExcel_Cell_DataType::TYPE_STRING);
                $this->excel->getActiveSheet()->setCellValueExplicit('X'.$row, $Convenio->UpdatedDate, PHPExcel_Cell_DataType::TYPE_STRING);

                $Pagos = $this->Convdeta_model->GetDetailsById($Convenio->Id);
                if($Pagos){
                    $ColumnP = ["Y","AA","AC"];
                    $ColumnD = ["Z","AB","AD"];
                    $ncount = 0;
                    foreach($Pagos as $Pago) {
                        $date = date_create($Pago->Fecha_pago);
                        $Fechapag=date_format($date, 'd/m/Y');
                        $this->excel->getActiveSheet()->setCellValueExplicit($ColumnP[$ncount].$row, $Pago->Importe_pago, PHPExcel_Cell_DataType::TYPE_NUMERIC);
                        $this->excel->getActiveSheet()->setCellValueExplicit($ColumnD[$ncount].$row, $Fechapag, PHPExcel_Cell_DataType::TYPE_STRING);
                        $ncount++;
                    }
                }

                $row++;
            }

            $filename='ConveniosFalabella.xls';
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
                         
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        }
    }

}