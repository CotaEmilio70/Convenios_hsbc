<?php
	
	function ActiveMenuAction($Controller, $Action)
	{
		$ci=& get_instance();
		$ci->load->helper("url");

		$ActualController = strtolower($ci->uri->segment(1));
		$ActualAction = strtolower($ci->uri->segment(2));
		if(is_array($Action))
		{
			$Class = "";
			for($i = 0; $i < count($Action); $i++)
			{
				if(strtolower($Controller) == $ActualController && $ActualAction == strtolower($Action[$i]))
				{
					$Class = "active";
				}
			}
			return $Class;
		}else
		{
			return strtolower($Controller) == $ActualController && strtolower($Action) == $ActualAction ? "active" : "";
		}
    }

	function ActiveMenu($Controller)
	{
		$ci=& get_instance();
		$ci->load->helper("url");

		$ActualController = strtolower($ci->uri->segment(1));
		if(is_array($Controller))
		{
			$Class = "";
			for($i = 0; $i < count($Controller); $i++)
			{
				if(strtolower($Controller[$i]) == $ActualController)
				{
					$Class = "active";
				}
			}
			return $Class;
		}else
		{
			return strtolower($Controller) == $ActualController ? "active" : "";
		}
    }

    function VerificarAccionesControlador($IdUsuario, $Controlador)
    {
    	$ci=& get_instance();
	    $ci->load->database();
	    $ci->db->select('*');

	    $ci->db->where('Claveusuario', $IdUsuario);
	    $ci->db->where("Active", true);

	    $ListaPermisos = $ci->db->get('permisosusuarios')->result();
	    $MenuValido = false;
	    foreach($ListaPermisos as $Item)
	    {
	    	$ci->db->where("Id", $Item->Idpermiso);
	    	$Permiso = $ci->db->get("permisosweb")->row();
	    	if($Permiso && $Permiso->Controlador == $Controlador)
	    	{
	    		$MenuValido = true;
	    	}
	    }
	    return $MenuValido;
    }

    function VerificarPermisos($IdUsuario, $Controlador, $Accion)
    {
    	$ci=& get_instance();
	    $ci->load->database();
	    $ci->db->select('*');

	    $ci->db->where('Claveusuario', $IdUsuario);
	    $ci->db->where("Active", true);

	    $ListaPermisos = $ci->db->get('permisosusuarios')->result();
	    $TienePermiso = false;
	    foreach($ListaPermisos as $Item)
	    {
	    	$ci->db->where("Id", $Item->Idpermiso);
	    	$Permiso = $ci->db->get("permisosweb")->row();
	    	if(($Permiso && $Permiso->Controlador == $Controlador && $Permiso->Accion == $Accion) || ($Permiso && $Permiso->Controlador == $Controlador && $Accion == "Index"))
	    	{
	    		$TienePermiso = true;
	    	}
	    }
	    return $TienePermiso;
    }

    function GetObra($Obra)
    {
	    $ci=& get_instance();
	    $ci->load->database();
	    $ci->db->select('*');

	    $ci->db->where('Clave', $Obra);

	    $row = $ci->db->get('obras')->row();

	    $Obra = $row;

	    return $Obra;
    }

    function ConvertirNumeroALetra($num, $fem = false, $dec = true) { 
	   $matuni[2]  = "dos"; 
	   $matuni[3]  = "tres"; 
	   $matuni[4]  = "cuatro"; 
	   $matuni[5]  = "cinco"; 
	   $matuni[6]  = "seis"; 
	   $matuni[7]  = "siete"; 
	   $matuni[8]  = "ocho"; 
	   $matuni[9]  = "nueve"; 
	   $matuni[10] = "diez"; 
	   $matuni[11] = "once"; 
	   $matuni[12] = "doce"; 
	   $matuni[13] = "trece"; 
	   $matuni[14] = "catorce"; 
	   $matuni[15] = "quince"; 
	   $matuni[16] = "dieciseis"; 
	   $matuni[17] = "diecisiete"; 
	   $matuni[18] = "dieciocho"; 
	   $matuni[19] = "diecinueve"; 
	   $matuni[20] = "veinte"; 
	   $matunisub[2] = "dos"; 
	   $matunisub[3] = "tres"; 
	   $matunisub[4] = "cuatro"; 
	   $matunisub[5] = "quin"; 
	   $matunisub[6] = "seis"; 
	   $matunisub[7] = "sete"; 
	   $matunisub[8] = "ocho"; 
	   $matunisub[9] = "nove"; 

	   $matdec[2] = "veint"; 
	   $matdec[3] = "treinta"; 
	   $matdec[4] = "cuarenta"; 
	   $matdec[5] = "cincuenta"; 
	   $matdec[6] = "sesenta"; 
	   $matdec[7] = "setenta"; 
	   $matdec[8] = "ochenta"; 
	   $matdec[9] = "noventa"; 
	   $matsub[3]  = 'mill'; 
	   $matsub[5]  = 'bill'; 
	   $matsub[7]  = 'mill'; 
	   $matsub[9]  = 'trill'; 
	   $matsub[11] = 'mill'; 
	   $matsub[13] = 'bill'; 
	   $matsub[15] = 'mill'; 
	   $matmil[4]  = 'millones'; 
	   $matmil[6]  = 'billones'; 
	   $matmil[7]  = 'de billones'; 
	   $matmil[8]  = 'millones de billones'; 
	   $matmil[10] = 'trillones'; 
	   $matmil[11] = 'de trillones'; 
	   $matmil[12] = 'millones de trillones'; 
	   $matmil[13] = 'de trillones'; 
	   $matmil[14] = 'billones de trillones'; 
	   $matmil[15] = 'de billones de trillones'; 
	   $matmil[16] = 'millones de billones de trillones'; 
	   
	   //Zi hack
	   $float=explode('.',$num);
	   $num=$float[0];

	   $num = trim((string)@$num); 
	   if ($num[0] == '-') { 
	      $neg = 'menos '; 
	      $num = substr($num, 1); 
	   }else 
	      $neg = ''; 
	   while ($num[0] == '0') $num = substr($num, 1); 
	   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
	   $zeros = true; 
	   $punt = false; 
	   $ent = ''; 
	   $fra = ''; 
	   for ($c = 0; $c < strlen($num); $c++) { 
	      $n = $num[$c]; 
	      if (! (strpos(".,'''", $n) === false)) { 
	         if ($punt) break; 
	         else{ 
	            $punt = true; 
	            continue; 
	         } 

	      }elseif (! (strpos('0123456789', $n) === false)) { 
	         if ($punt) { 
	            if ($n != '0') $zeros = false; 
	            $fra .= $n; 
	         }else 

	            $ent .= $n; 
	      }else 

	         break; 

	   } 
	   $ent = '     ' . $ent; 
	   if ($dec and $fra and ! $zeros) { 
	      $fin = ' coma'; 
	      for ($n = 0; $n < strlen($fra); $n++) { 
	         if (($s = $fra[$n]) == '0') 
	            $fin .= ' cero'; 
	         elseif ($s == '1') 
	            $fin .= $fem ? ' una' : ' un'; 
	         else 
	            $fin .= ' ' . $matuni[$s]; 
	      } 
	   }else 
	      $fin = ''; 
	   if ((int)$ent === 0) return 'Cero ' . $fin; 
	   $tex = ''; 
	   $sub = 0; 
	   $mils = 0; 
	   $neutro = false; 
	   while ( ($num = substr($ent, -3)) != '   ') { 
	      $ent = substr($ent, 0, -3); 
	      if (++$sub < 3 and $fem) { 
	         $matuni[1] = 'una'; 
	         $subcent = 'as'; 
	      }else{ 
	         $matuni[1] = $neutro ? 'un' : 'uno'; 
	         $subcent = 'os'; 
	      } 
	      $t = ''; 
	      $n2 = substr($num, 1); 
	      if ($n2 == '00') { 
	      }elseif ($n2 < 21) 
	         $t = ' ' . $matuni[(int)$n2]; 
	      elseif ($n2 < 30) { 
	         $n3 = $num[2]; 
	         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
	         $n2 = $num[1]; 
	         $t = ' ' . $matdec[$n2] . $t; 
	      }else{ 
	         $n3 = $num[2]; 
	         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
	         $n2 = $num[1]; 
	         $t = ' ' . $matdec[$n2] . $t; 
	      } 
	      $n = $num[0]; 
	      if ($n == 1) { 
	         $t = ' ciento' . $t; 
	      }elseif ($n == 5){ 
	         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
	      }elseif ($n != 0){ 
	         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
	      } 
	      if ($sub == 1) { 
	      }elseif (! isset($matsub[$sub])) { 
	         if ($num == 1) { 
	            $t = ' mil'; 
	         }elseif ($num > 1){ 
	            $t .= ' mil'; 
	         } 
	      }elseif ($num == 1) { 
	         $t .= ' ' . $matsub[$sub] . '?n'; 
	      }elseif ($num > 1){ 
	         $t .= ' ' . $matsub[$sub] . 'ones'; 
	      }   
	      if ($num == '000') $mils ++; 
	      elseif ($mils != 0) { 
	         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
	         $mils = 0; 
	      } 
	      $neutro = true; 
	      $tex = $t . $tex; 
	   } 
	   $tex = $neg . substr($tex, 1) . $fin; 
	   //Zi hack --> return ucfirst($tex);
	   $float1 = isset($float[1]) ? $float[1] : "00";
	   $end_num=ucfirst($tex).' pesos '.$float1.'/100 M.N.';
	   return $end_num; 
	}

	function RepetirReportes($pdf,$header_tabla,$datos,$w)
	{
		$pdf->SetFontSize(9);
        for ($i=0; $i < count($datos); $i++) { 
        	$pdf->Write(5,$datos[$i]["texto"], $enlace="", $fondo=false, $alineacion=$datos[$i]["alineacion"], $nueva_linea=$datos[$i]["nueva_linea"]);
        }
        
        $pdf->SetFontSize(10);
        
        
        $pdf->SetFillColor(77, 77, 255);
        $pdf->SetTextColor(255);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('', 'B');
       
        //$w = array(20, 20, 20, 20, 20, 20, 20, 20, 20);
        $num_headers = count($header_tabla);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell($w[$i], 7, $header_tabla[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();

        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
	}

    // Funcion con la que validamos el formato de correo electronico
    function is_valid_email($str)
    {
      return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
    }

	function EnviarCorreoGeneral( $email, $subject , $message , $attachment, $emailcc)

	{

		$ci=& get_instance();
		// Cargamos libreria PHPMailer
		$ci->load->library('phpmailer_lib');
		// Cargamos objeto PHPMailer
		$mail = $ci->phpmailer_lib->load();
		// Nivel de debug por consola
		$mail->SMTPDebug = 0;
		// Config de SMTP
	    $mail->isSMTP();
	    $mail->Host = 'smtp.gmail.com';
	    $mail->SMTPAuth = true;
	    $mail->Username = 'cotaemilio70@gmail.com';
	    // $mail->Username = 'eventos.saeta@gmail.com';
	    $mail->Password = 'bjwj yxbn zrpu zqvi';
	    // $mail->Password = 'zxbu xsou xcjh gmlt';
	    $mail->SMTPSecure = 'ssl';     
	    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;                    
	    $mail->Port = 465;                                   
	    // $mail->Port = 25;                                   

	    // Para gmail no se usa
	    // $mail->SMTPOptions = array(
		   //  'ssl' => array(
		   //  'verify_peer' => false,
		   //  'verify_peer_name' => false,
		   //  'allow_self_signed' => true
		   //  )
	    // );
    		
		$mail->setFrom('eventos.saeta@gmail.com', 'IFJSAETA Registro de boletos');

		//$mail->addReplyTo('info@example.com', 'Programacion.net'); // Si se requiere Reply diferente al setFrom

		// Agregamos correos destinatarios, si son mas de 1 se separan con coma
		$mail->addAddress($email);
		
		// Aqui se agregan cc o bcc
		$mail->addCC($emailcc);

		// Asunto del correo
		$mail->Subject = $subject;

		// Si se requiere enviar en formato HTML
		$mail->isHTML(true);
		// Cuerpo del mensaje
		$mailContent = $message;

		// $mail->AddEmbeddedImage(‘unavailable_image.jpg’,’logosaeta’,’unavailable_image.jpg’,’base64′,’image/jpeg’);
		// $mail->AddEmbeddedImage('./includes/img/.unavailable_image.jpg', 'logosaeta'); 

		$mail->Body = $mailContent;

		$mail->CharSet = 'UTF-8';

		// Enviar el correo o reportar el error si es el caso
		if(!$mail->send()){
			//echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		}else{
			//echo 'Message has been sent';
			return true;
		}
	}

?>