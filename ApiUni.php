<?php
class ApiUni
   {
      public function __construct(){

         $this->Token= '';

      }

      public function token(){
         $fields = array('rutfull' => '0','usuariosistema' => 'capitalhumano', 'clave' => 'PhYg=bsIV1GxG/POj5UjpWc5','aplicacion' => 3);
         $fields_string = json_encode($fields);
         $ch = curl_init();

         curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ControlAcceso/Token_Obtener");
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

         $server_output = json_decode(curl_exec($ch));

         curl_close ($ch);

         $this->Token=$server_output->token;
         return  $server_output;
      }

      public function login($Usuario, $Pass){
         $fields = array('usuario' => $Usuario, 'clave' => $Pass, 'aplicacion' => 1);
         $fields_string = json_encode($fields);
         $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
         curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ControlAcceso/Login");
         curl_setopt($ch, CURLOPT_POST, 1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

         $server_output = json_decode(curl_exec($ch));

         curl_close ($ch);
         return  $server_output;
      }

      /* ============================== CURSOS SSO N ============================== */

      public function ListarCursosSSO($contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSO($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function DescargaCursosSSO($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_DescargaBD");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->DescargaCursosSSO($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoSSOxId($idCursoCursado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => intval($idCursoCursado));
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoSSOxId($idCursoCursado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoSSOxNombre($descripcion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $descripcion);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Descripcion_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoSSOxNombre($descripcion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateCursoSSO($idCursoCursado, $rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => $idCursoCursado, 'rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => $idCurso, 'idEmpresa' => $idEmpresa, 'idGerencia' => $idGerencia, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado, 'cursoinstitucion_id' => $cursoinstitucion_id, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCursoSSO($idCursoCursado, $rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoSSOxRut($Rut,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoSSOxRut($Rut,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoSSO($rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => $idCurso, 'idEmpresa' => $idEmpresa, 'idGerencia' => $idGerencia, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado, 'cursoinstitucion_id' => $cursoinstitucion_id, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoSSO($rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoSSOMasiva($rutfull, $pasaporte, $nombre, $curso, $empresa, $gerenciasigla, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $institucion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'nombrefull' => $nombre, 'curso' => $curso, 'empresa' => $empresa, 'gerenciasigla' => $gerenciasigla, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado, 'cursoinstitucion_nombre' => $institucion,  'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Masiva_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoSSOMasiva($rutfull, $pasaporte, $nombre, $curso, $empresa, $gerenciasigla, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $institucion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function EliminarCursoSSO($IdCursoSSO, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => $IdCursoSSO, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Eliminar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->EliminarCursoSSO($IdCursoSSO, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosSSOMantenedor($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSOMantenedor($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosSSOBasicos($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/Revision_Basicos_Consulta");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSOBasicos($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosSSOEspecificos($Rut, $Area, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'idArea' => $Area);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/Revision_JerarquiaAreaCargo_Consulta");
            // curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/Revision_AreaCargo_Consulta");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSOEspecificos($Rut, $Area, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosSSOMant($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSOMant($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosSSOMantId($Id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCurso' => $Id);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSOMantId($Id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateCursoSSOMant($Curso, $Descripcion, $Inducción_horas, $Validez_año, $IdCursoTipo, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCurso' => $Curso, 'descripcion' => $Descripcion, 'induccionhoras' => $Inducción_horas, 'validezanio' => $Validez_año, 'idCursoTipo' => $IdCursoTipo, 'vigencia' => $Vigencia, 'orden' => $Orden);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCursoSSOMant($Curso, $Descripcion, $Inducción_horas, $Validez_año, $IdCursoTipo, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== Asignar Curso Area Cargo SSO ============================== */

      public function ListarCursosSSOAsignadosAreaCargoVigente($Area, $Cargo, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area, 'idCargo' => $Cargo);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoAreaCargo_AreaCargo_Listar_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSOAsignadosAreaCargoVigente($Area, $Cargo, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosSSONoAsignadosAreaCargoVigente($Area, $Cargo, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area, 'idCargo' => $Cargo);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_No_Asociado_AreaCargo_Listar_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosSSONoAsignadosAreaCargoVigente($Area, $Cargo, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function AsociarCursoSSOAreaCargo($AreaCargoCurso, $Area, $Cargo, $Curso, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idAreaCargoCurso' => $AreaCargoCurso, 'idArea' => $Area, 'idCargo' => $Cargo, 'idCurso' => $Curso,  'vigencia' => $Vigencia);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoAreaCargo_Asociar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->AsociarCursoSSOAreaCargo($AreaCargoCurso, $Area, $Cargo, $Curso, $Vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function QuitarCursoSSOAreaCargo($AreaCargoCurso, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idAreaCargoCurso' => $AreaCargoCurso, 'vigencia' => $Vigencia);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoAreaCargo_Asociar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this-> QuitarCursoSSOAreaCargo($AreaCargoCurso, $Vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Cursos Técnicos N ============================== */

      public function ListarCursosTecnicos($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosTecnicos($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosTecnicosTodos($contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosTecnicosTodos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoTecnicosMasiva($rutfull, $pasaporte, $nombre, $curso, $empresa, $gerenciasigla, $fechainicio, $fechatermino, $horas, $asistencia, $evaluacion, $resultado, $institucion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'nombrefull' => $nombre, 'curso' => $curso, 'empresa' => $empresa, 'gerenciasigla' => $gerenciasigla, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'horascapacitacion'=> $horas,'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado, 'cursoinstitucion_nombre' => $institucion,  'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Masiva_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoTecnicosMasiva($rutfull, $pasaporte, $nombre, $curso, $empresa, $gerenciasigla, $fechainicio, $fechatermino, $horas, $asistencia, $evaluacion, $resultado, $institucion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoTecnicosxNombre($descripcion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $descripcion);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_Descripcion_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoTecnicosxNombre($descripcion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoTecnicosxRut($Rut,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoTecnicosxRut($Rut,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoTecnico($rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $horas, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => $idCurso, 'idEmpresa' => $idEmpresa, 'idGerencia' => $idGerencia, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'horascapacitacion' => $horas, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado, 'cursoinstitucion_id' => $cursoinstitucion_id, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoTecnico($rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $horas, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoTecnicoxId($idCursoCursado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => intval($idCursoCursado));
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoTecnicoxId($idCursoCursado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function EliminarCursoTecnico($IdCursoSSO, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => $IdCursoSSO, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Eliminar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->EliminarCursoTecnico($IdCursoSSO, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      public function UpdateCursoTecnico($idCursoCursado, $rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $horas, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => $idCursoCursado, 'rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => $idCurso, 'idEmpresa' => $idEmpresa, 'idGerencia' => $idGerencia, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'horascapacitacion' => $horas, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado, 'cursoinstitucion_id' => $cursoinstitucion_id, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCursoTecnico($idCursoCursado, $rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $horas, $asistencia, $evaluacion, $resultado, $cursoinstitucion_id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function DescargaCursosTecnicos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CursosTecnicos/CursoCursado_DescargaBD");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->DescargaCursosTecnicos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoTecnicosMant($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoTecnicosMant($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoTecnicosVigentesMant($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoTecnicosVigentesMant($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoTecnicoMant($Descripcion, $Inducción_horas, $Validez_año, $Vigencia, $Obligatorio, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'induccionhoras' => $Inducción_horas, 'validezanio' => $Validez_año, 'vigencia' => $Vigencia, 'obligatorio' => $Obligatorio);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoTecnicoMant($Descripcion, $Inducción_horas, $Validez_año, $Vigencia, $Obligatorio, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoTecnicoMantId($Id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCurso' => $Id);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoTecnicoMantId($Id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateCursoTecnicoMant($Curso, $Descripcion, $Inducción_horas, $Validez_año, $Vigencia, $Obligatorio, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCurso' => $Curso, 'descripcion' => $Descripcion, 'induccionhoras' => $Inducción_horas, 'validezanio' => $Validez_año, 'vigencia' => $Vigencia, 'obligatorio' => $Obligatorio);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCursoTecnicoMant($Curso, $Descripcion, $Inducción_horas, $Validez_año, $Vigencia, $Obligatorio, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== Asignar Curso Area Cargo Tecnicos ============================== */

      public function ListarCursosTecnicoAsignadosAreaCargoVigente($Area, $Cargo, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area, 'idCargo' => $Cargo);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnicoAreaCargo_AreaCargo_Listar_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosTecnicoAsignadosAreaCargoVigente($Area, $Cargo, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursosTecnicoNoAsignadosAreaCargoVigente($Area, $Cargo, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area, 'idCargo' => $Cargo);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnico_No_Asociado_AreaCargo_Listar_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursosTecnicoNoAsignadosAreaCargoVigente($Area, $Cargo, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function AsociarCursoTecnicoAreaCargo($AreaCargoCurso, $Area, $Cargo, $Curso, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idAreaCargoCurso' => $AreaCargoCurso, 'idArea' => $Area, 'idCargo' => $Cargo, 'idCurso' => $Curso,  'vigencia' => $Vigencia);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnicoAreaCargo_Asociar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->AsociarCursoTecnicoAreaCargo($AreaCargoCurso, $Area, $Cargo, $Curso, $Vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function QuitarCursoTecnicoAreaCargo($AreaCargoCurso, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idAreaCargoCurso' => $AreaCargoCurso, 'vigencia' => $Vigencia);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnicoAreaCargo_Asociar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this-> QuitarCursoTecnicoAreaCargo($AreaCargoCurso, $Vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Instituciones Cursos N ============================== */

      public function ListarInstitucionesCursosVigentes($contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoInstitucion_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionesCursosVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarInstitucionesCursosTodas($contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoInstitucion_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionesCursosTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarInstitucionesCursosxId($IdInstitucionCurso, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $fields = array('idCursoInstitucion' => $IdInstitucionCurso);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoInstitucion_ConsultaID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionesCursosxId($IdInstitucionCurso, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateInstitucionCurso($id, $Descripcion, $Vigencia, $Aprobado, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $fields = array('idCursoInstitucion' => $id, 'nombre' => $Descripcion, 'vigencia' => $Vigencia, 'aprobado' => $Aprobado, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoInstitucion_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateInstitucionCurso($id, $Descripcion, $Vigencia, $Aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertInstitucionCurso($Descripcion, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $fields = array('nombre' => $Descripcion, 'usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoInstitucion_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertInstitucionCurso($Descripcion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarInstitucionesCursosTVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTecnicoInstitucion_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionesCursosTVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== Persona / Trabajador N ============================== */

      public function ListarTrabajadoresVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/General_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarTrabajador($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarTrabajadoresVigentesxEmpresa($Rut,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/EmpresaAdmin_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarTrabajadoresVigentesxEmpresa($Rut,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarInformacionTrabajador($Rut, $Fecha, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'fechaconsulta' => $Fecha);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/CabeceraEscaner");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInformacionTrabajador($Rut, $Fecha, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarInformacionTrabajadorDetalle($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Curriculum/Cabecera");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInformacionTrabajadorDetalle($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateDatosPersonalesTrabajador($rutfull, $nacionalidad, $genero, $estado_civil, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'nacionalidad' => $nacionalidad, 'genero' => $genero, 'estado_civil' => $estado_civil);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Informacion_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateDatosPersonalesTrabajador($rutfull, $nacionalidad, $genero, $estado_civil, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateDatosContactoTrabajador($rutfull, $telefono, $pais_codigo, $cutcomuna, $calle, $email, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
               $fields = array('rutfull' => $rutfull, 'telefono' => $telefono, 'pais_codigo' => $pais_codigo, 'cutcomuna' => $cutcomuna, 'calle' => $calle, 'email' => $email);
               $fields_string = json_encode($fields);
               $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
               curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Contacto_Actualizar");
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

               $server_output = json_decode(curl_exec($ch));

               curl_close ($ch);
               if(isset($server_output->detalle)){
                  $detalle = $server_output->detalle;
                  if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->UpdateDatosContactoTrabajador($rutfull, $telefono, $pais_codigo, $cutcomuna, $calle, $email, $contador);
                  }else{
                     return  $server_output;
                  }
               }else{
                  return  $server_output;
               }
         }
      }

      public function ListarTrabajadoresTodos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CatalogoLaboral/General_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarTrabajadoresTodos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarTrabajadoresEmpresa($Rut, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CatalogoLaboral/EmpresaAdmin_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarTrabajadoresEmpresa($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Organización N ============================== */

      public function ListarGerenciasVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Gerencia_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarGerenciasVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarGerenciaSuptciasVigentes($IdGerencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idGerencia' => $IdGerencia);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/SuptciaGerencia_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarGerenciaSuptciasVigentes($IdGerencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarSuptciaAreasVigentes($IdSuptcia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idSuptciaGerencia' => $IdSuptcia);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/AreaSuptcia_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarAreasVigentes($IdSuptcia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarAreasVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Area_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarAreasVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== Experiencia Laboral N ============================== */

      public function ListarUltimasExperienciasLaborales($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Ultima");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarUltimasExperienciasLaborales($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarTotalAñosExperinciaLaboral($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/PersonaAcumulado");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarTotalAñosExperinciaLaboral($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarExperienciaLaboralTrabajador($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Lista_Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarExperienciaLaboralTrabajador($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertarExperienciaLaboral($Rut, $cargo, $especialidad, $pais, $fecha_inicio, $fecha_termino, $empresa, $actividad_empresa, $division, $cmarea, $cmproceso, $cmsubproceso, $descripcion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'cargo' => $cargo, 'especialidad' => $especialidad, 'pais' => $pais, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'empresa' => $empresa, 'actividad_empresa' => $actividad_empresa, 'division' => $division, 'cmarea' => $cmarea, 'cmproceso' => $cmproceso, 'cmsubproceso' => $cmsubproceso, 'descripcion' => $descripcion, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertarExperienciaLaboral($Rut, $cargo, $especialidad, $pais, $fecha_inicio, $fecha_termino, $empresa, $actividad_empresa, $division, $cmarea, $cmproceso, $cmsubproceso, $descripcion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarExperienciaLaboralxId($idFLExperienciaGeneral, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFLExperienciaGeneral' => $idFLExperienciaGeneral);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarExperienciaLaboralxId($idFLExperienciaGeneral, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateExperienciaLaboral($idFLExperienciaGeneral, $Rut, $cargo, $especialidad, $pais, $fecha_inicio, $fecha_termino, $empresa, $actividad_empresa, $division, $cmarea, $cmproceso, $cmsubproceso, $descripcion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFLExperienciaGeneral' => $idFLExperienciaGeneral, 'rutfull' => $Rut, 'cargo' => $cargo, 'especialidad' => $especialidad, 'pais' => $pais, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'empresa' => $empresa, 'actividad_empresa' => $actividad_empresa, 'division' => $division, 'cmarea' => $cmarea, 'cmproceso' => $cmproceso, 'cmsubproceso' => $cmsubproceso, 'descripcion' => $descripcion, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateExperienciaLaboral($idFLExperienciaGeneral, $Rut, $cargo, $especialidad, $pais, $fecha_inicio, $fecha_termino, $empresa, $actividad_empresa, $division, $cmarea, $cmproceso, $cmsubproceso, $descripcion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function DeleteExperienciaLaboral($idFLExperienciaGeneral, $vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFLExperienciaGeneral' => $idFLExperienciaGeneral, 'vigencia' => $vigencia, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Estado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->DeleteExperienciaLaboral($idFLExperienciaGeneral, $vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Formación Académica N ============================== */

      public function InsertarFormacionAcademica($Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'idFANivel' => $nivel, 'idFAEstado' => $estado, 'FACarrera' => $carrera, 'FAEspecialidad' => $especialidad, 'FAInstitucion' => $institucion, 'pais_codigo' => $pais_codigo, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertarFormacionAcademica($Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertarFormacionAcademicaMasiva($Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'nivel_descripcion' => $nivel, 'estado_descripcion' => $estado, 'carrera_descripcion' => $carrera, 'especialidad_descripcion' => $especialidad, 'institucion_descripcion' => $institucion, 'pais_descripcion' => $pais_codigo, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Masiva_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertarFormacionAcademicaMasiva($Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateFormacionAcademica($idFAPersona, $Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAPersona' => $idFAPersona, 'rutfull' => $Rut, 'nivel_descripcion' => $nivel, 'estado_descripcion' => $estado, 'carrera_descripcion' => $carrera, 'especialidad_descripcion' => $especialidad, 'institucion_descripcion' => $institucion, 'pais_descripcion' => $pais_codigo, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateFormacionAcademica($idFAPersona, $Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarFormacionAcademicaTrabajador($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Lista_Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarFormacionAcademicaTrabajador($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ConsultarFormacionAcademica($idFAPersona, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAPersona' => intval($idFAPersona));
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ConsultarFormacionAcademica($idFAPersona, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function DeleteFormacionAcademica($idFAPersona, $vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAPersona' => $idFAPersona, 'vigencia' => $vigencia, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Estado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->DeleteFormacionAcademica($idFAPersona, $vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Idiomas N ============================== */

      public function ListarIdiomasTrabajador($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Idioma/Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarIdiomasTrabajador($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarNivelesIdioma($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/IdiomaNivel_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarNivelesIdioma($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarIdiomas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Idioma_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarIdiomas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertarIdioma($Rut, $idIdioma, $idNivelEscrito, $idNivelOral, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'idIdioma' => $idIdioma, 'idIdiomaNivelEscrito' => $idNivelEscrito, 'idIdiomaNivelOral' => $idNivelOral, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Idioma/Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertarIdioma($Rut, $idIdioma, $idNivelEscrito, $idNivelOral, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarIdiomaXId($idIdiomaPersona, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idIdiomaPersona' => $idIdiomaPersona);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Idioma/Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarIdiomaXId($idIdiomaPersona, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateIdioma($Id, $idNivelEscrito, $idNivelOral, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idIdiomaPersona' => $Id, 'idIdiomaNivelEscrito' => $idNivelEscrito, 'idIdiomaNivelOral' => $idNivelOral, 'idNivelOral' => $Id, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Idioma/Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateIdioma($Id, $idNivelEscrito, $idNivelOral, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function EliminarIdioma($Id, $vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idIdiomaPersona' => $Id, 'vigencia' => $vigencia, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Idioma/Estado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->EliminarIdioma($Id, $vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Empresas N ============================== */

      public function ListarEmpresasVigente($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEmpresasVigente($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarEmpresaVigentesCH($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Listar_Vigente_CH");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEmpresaVigentesCH($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarEmpresasTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEmpresasTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ConsultarEmpresaxNombre($nombre, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('nombre' => $nombre);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Nombre_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ConsultarEmpresaxNombre($nombre, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== Instituciones N ============================== */

      public function ListarInstitucionesVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{

            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionesVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function ListarInstitucionesTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{

            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionesTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function UpdateInstitucion($id, $Descripcion, $Vigencia, $Nivel_1, $Nivel_2, $Nivel_3, $Nivel_4, $Nivel_5, $Nivel_6, $Nivel_7, $Orden, $Aprobado,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAInstitucion' => $id, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'nivel_1' => $Nivel_1, 'nivel_2' => $Nivel_2, 'nivel_3' => $Nivel_3, 'nivel_4' => $Nivel_4, 'nivel_5' => $Nivel_5, 'nivel_6' => $Nivel_6, 'nivel_7' => $Nivel_7, 'orden' => $Orden, 'aprobado' => $Aprobado);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateInstitucion($id, $Descripcion, $Vigencia, $Nivel_1, $Nivel_2, $Nivel_3, $Nivel_4, $Nivel_5, $Nivel_6, $Nivel_7, $Orden, $Aprobado,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ConsultaInstitucion($id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAInstitucion' => $id);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_ConsultaID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ConsultaInstitucion($id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarInstitucionxNivelEstudio($NivelEstudio, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFANivel' => $NivelEstudio);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_ConsultaNivel");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarInstitucionxNivelEstudio($NivelEstudio, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Carreras N ============================== */

      public function ListarCarrerasTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FACarrera_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCarrerasTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function ListarCarreraxId($id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFACarrera' => $id);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FACarrera_ConsultaID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCarreraxId($id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== Especialidad N ============================== */

      public function ListarEspecilidadesVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEspecilidadesVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function ListarEspecialidadesTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEspecialidadesTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function ListarEspecialidadxId($id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAEspecialidad' => $id);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEspecialidadxId($id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateEspecialidad($id, $Descripcion, $Vigencia, $Orden, $Aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('id' => $id, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden, 'aprobado' => $Aprobado,);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateEspecialidad($id, $Descripcion, $Vigencia, $Orden, $Aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertEspecialidad($Descripcion, $Vigencia, $Orden, $Aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array( 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden, 'aprobado' => $Aprobado);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertEspecialidad($Descripcion, $Vigencia, $Orden, $Aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Niveles N ============================== */

      public function ListarNivelesTodos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FANivel_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarNivelesTodos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function ListarNivelxId($id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFANivel' => $id);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FANivel_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarNivelxId($id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateNivel($id, $Descripcion, $Vigencia, $Orden,$Grado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array( 'idFANivel' => $id,'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden, 'grado' => $Grado);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FANivel_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateNivel($id, $Descripcion, $Vigencia, $Orden,$Grado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertNivel($Descripcion, $Vigencia, $Orden, $Grado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden, 'grado' => $Grado);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FANivel_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->InsertNivel($Descripcion, $Vigencia, $Orden,$Grado,$contador);
               }else{
                     return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Estados N ============================== */

      public function ListarEstadosTodos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEstado_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->ListarEstadosTodos($contador);
               }else{
                     return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function UpdateEstado($id, $Descripcion, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('id' => $id, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEstado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->UpdateEstado($id, $Descripcion, $Vigencia, $contador);
               }else{
                     return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertEstado($Descripcion, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'vigencia' => $Vigencia);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEstado_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->InsertEstado($Descripcion, $Vigencia,$contador);
               }else{
                     return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarEstadoxId($id, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAEstado' => $id);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEstado_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEstadoxId($id, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      

      /* ============================== Cargos N ============================== */

      public function ListarCargosTodos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCargosTodos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateCargo($idCargo, $descripcion, $vigencia, $orden, $aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCargo' => $idCargo, 'descripcion' => $descripcion, 'vigencia' => $vigencia, 'orden' => $orden, 'aprobado' => $aprobado);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCargo($idCargo, $descripcion, $vigencia, $orden, $aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Otros N ============================== */

      public function ListarNacionalidad($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Nacionalidad_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarNacionalidad($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarPaises($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Pais_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarPaises($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarRegiones($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Region_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarRegiones($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ConsultarComunas($Region, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('region_codigo' => $Region);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Comunas_Region_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ConsultarComunas($Region, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarEstadoCivil($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Estado_Civil_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEstadoCivil($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarGenero($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Genero_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarGenero($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Ciclo Minero N ============================== */

      public function ListarAreaCicloMinero($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CMArea_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarAreaCicloMinero($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarProcesoCicloMinero($CMArea, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('CMArea' => $CMArea);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CMProceso_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarProcesoCicloMinero($CMArea, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarSubProcesoCicloMinero($CMProceso, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('CMProceso' => $CMProceso);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CMSubproceso_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarSubProcesoCicloMinero($CMProceso, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== Tipo Curso SSO N ============================== */

      public function ListarTipoCursoSSO($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTipo_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarTipoCursoSSO($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function UpdateCursoTipoSSO($CursoTipo, $Descripcion, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoTipo' => $CursoTipo, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTipo_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCursoTipoSSO($CursoTipo, $Descripcion, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoTipoSSO($Descripcion, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTipo_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoTipoSSO($Descripcion, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarTipoCursoSSOVigente($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTipo_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarTipoCursoSSOVigente($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      /* ============================== Catalogo N ============================== */

      public function ObtenerRubros($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/ObtenerRubros");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ObtenerRubros($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ObtenerProfesiones($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/ObtenerProfesiones");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ObtenerProfesiones($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ObtenerEmpresas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/ObtenerEmpresas");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ObtenerEmpresas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ObtenerCargos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/ObtenerCargos");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ObtenerCargos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ObtenerCasaEstudios($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/ObtenerCasaEstudios");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ObtenerCasaEstudios($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ObtenerComunas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/ObtenerComunas");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ObtenerComunas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function BusquedaES($data,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            // $TokenApiCapitalHumano =  $this->tokenApiCapitalHumano();
            // $authorization = "Authorization: Bearer ".$TokenApiCapitalHumano->token ;
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apicapitalhumano/Buscador/Busqueda");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
   
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->BusquedaES($data,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== GESTION USUARIOS ============================== */

      public function obtenerDatosPersona($rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Correo_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->obtenerDatosPersona($rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function obtenerDatosPersonaST($rut, $contador, $tok){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$tok->token;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Correo_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               return  $server_output;
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarPass($Usuario, $Pass, $contador, $tok){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Usuario,'usuariosistema' => '0', 'clave' => $Pass);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$tok->token;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ControlAcceso/PerfilClave_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               return  $server_output;
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarPassLog($Usuario, $Pass, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Usuario, 'usuariosistema' => '0', 'clave' => $Pass);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ControlAcceso/PerfilClave_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarPassLog($Usuario, $Pass, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function SolicitarCodigo($Usuario, $aplicacion, $contador, $tok){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Usuario, 'idAdmAplicacion' => $aplicacion);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$tok->token;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ControlAcceso/CodigoSeguridad_Nuevo");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               return  $server_output;
            }else{
               return  $server_output;
            }
         }
      }      

      /* ============================== AREAS ============================== */

      public function ListarGerencia($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Gerencia_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);

            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarGerencia($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarSuptcias($IdGerencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idGerencia' => $IdGerencia);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/SuptciaGerencia_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarSuptcias($IdGerencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarAreas($IdSuptcia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idSuptciaGerencia' => $IdSuptcia);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/AreaSuptcia_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarAreas($IdSuptcia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarEstadoArea($idArea, $idGerencia, $vig, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $idArea, 'vigencia' => $vig);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Area_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarEstadoArea($idArea, $idGerencia, $vig, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarArea($Area, $Gerencia, $Descripcion, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area, 'idGerencia' => $Gerencia, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Area_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarArea($Area, $Gerencia, $Descripcion, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function insertarArea($Gerencia, $Descripcion, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idGerencia' => $Gerencia, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Area_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->insertarArea($Gerencia, $Descripcion, $Vigencia, $Orden, $contador);
               }else{
                  return $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      /* ============================== INSTITUCIÓN ============================== */

      public function listarInstitucionTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarInstitucionTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function listarInstitucionVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{

            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();


            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarInstitucionVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }
                  
      public function InsertInstitucion($Descripcion, $Vigencia, $Nivel_1, $Nivel_2, $Nivel_3, $Nivel_4, $Nivel_5, $Nivel_6, $Nivel_7, $Orden, $Aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'nivel_1' => $Nivel_1, 'nivel_2' => $Nivel_2, 'nivel_3' => $Nivel_3, 'nivel_4' => $Nivel_4, 'nivel_5' => $Nivel_5, 'nivel_6' => $Nivel_6, 'nivel_7' => $Nivel_7, 'orden' => $Orden, 'aprobado' => $Aprobado);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAInstitucion_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertInstitucion($Descripcion, $Vigencia, $Nivel_1, $Nivel_2, $Nivel_3, $Nivel_4, $Nivel_5, $Nivel_6, $Nivel_7, $Orden, $Aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== CARRERA ============================== */

      public function listarCarreraTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FACarrera_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCarreraTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function listarCarreraVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FACarrera_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCarreraVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function UpdateCarrera($id, $Descripcion, $Vigencia, $Orden, $Aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('id' => $id, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden, 'aprobado' =>$Aprobado );
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FACarrera_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateCarrera($id, $Descripcion, $Vigencia, $Orden, $Aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCarrera($Descripcion, $Vigencia, $Orden, $Aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array( 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden, 'aprobado' => $Aprobado );
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FACarrera_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCarrera($Descripcion, $Vigencia, $Orden, $Aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== ESPECIALIDAD ============================== */

      public function listarEspecialidadTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarEspecialidadTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      
      
      public function listarEspecialidadVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEspecialidad_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarEspecialidadVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      

      /* ============================== NIVEL ============================== */

      public function listarNivel($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FANivel_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarNivel($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }



      /* ============================== ESTADO ============================== */

      public function listarEstado($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/FAEstado_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->listarEstado($contador);
               }else{
                     return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }



      /* ============================== CURSOS ============================== */

      public function listarTipoCursoVigente($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CursoTipo_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarTipoCursoVigente($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return $server_output;
            }
         }
      }

      public function listarCursos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCursos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarCurso($Curso, $Descripcion, $Inducción_horas, $Validez_año, $IdCursoTipo, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCurso' => $Curso, 'descripcion' => $Descripcion, 'induccionhoras' => $Inducción_horas, 'validezanio' => $Validez_año, 'idCursoTipo' => $IdCursoTipo, 'vigencia' => $Vigencia, 'orden' => $Orden);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarCurso($Curso, $Descripcion, $Inducción_horas, $Validez_año, $IdCursoTipo, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarEstadoCurso($idCurso, $vig, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCurso' => $idCurso, 'vigencia' => $vig);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarEstadoCurso($idCurso, $vig, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function insertarCurso($Descripcion, $Inducción_horas, $Validez_año, $IdCursoTipo, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'induccionhoras' => $Inducción_horas, 'validezanio' => $Validez_año, 'idCursoTipo' => $IdCursoTipo, 'vigencia' => $Vigencia, 'orden' => $Orden);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Curso_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->insertarCurso($Descripcion, $Inducción_horas, $Validez_año, $IdCursoTipo, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== CARGOS ============================== */

      public function listarCargos($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCargos($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarCargo($Cargo, $Descripcion, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCargo' => $Cargo, 'descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden);
            
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarCargo($Cargo, $Descripcion, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function actualizarEstadoCargo($idCargo, $vig, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCargo' => $idCargo, 'vigencia' => $vig);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarEstadoCargo($idCargo, $vig, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function insertarCargo($Descripcion, $Vigencia, $Orden, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $Descripcion, 'vigencia' => $Vigencia, 'orden' => $Orden);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->insertarCargo($Descripcion, $Vigencia, $Orden, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCargo($descripcion, $vigencia, $orden, $aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('descripcion' => $descripcion, 'vigencia' => $vigencia, 'orden' => $orden, 'aprobado' => $aprobado);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCargo($descripcion, $vigencia, $orden, $aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== EMPRESAS ============================== */

      public function InsertEmpresa($nombre, $aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('nombre' => $nombre, 'origen' => "CH", 'aprobado' => $aprobado);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertEmpresa($nombre, $aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function UpdateEmpresa($idEmpresa, $nombre, $aprobado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idEmpresa' => $idEmpresa, 'nombre' => $nombre, 'origen' => "CH", 'aprobado' => $aprobado);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->UpdateEmpresa($idEmpresa, $nombre, $aprobado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarEmpresaVigente($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarEmpresaVigente($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarEmpresaTodas($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Empresa_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarEmpresaTodas($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ==============================  ============================== */

      public function listarCargoAreaVigente($Area, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CargoArea_Area_Listar_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCargoAreaVigente($Area, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarCargoNoAsociadoAreaVigente($Area, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idArea' => $Area);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_No_Asociado_Area_Listar_Vigente");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCargoNoAsociadoAreaVigente($Area, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function AsociarCargoArea($CargoArea, $Cargo, $Area, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCargoArea' => $CargoArea, 'idCargo' => $Cargo, 'idArea' => $Area, 'vigencia' => $Vigencia);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CargoArea_Asociar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->AsociarCargoArea($CargoArea, $Cargo, $Area, $Vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function QuitarCargoArea($CargoArea, $Vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCargoArea' => $CargoArea, 'vigencia' => $Vigencia);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CargoArea_Asociar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->QuitarCargoArea($CargoArea, $Vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== VERIFICACION TRABAJADOR ============================== */

      public function listarDatosCabecera($Rut, $Fecha, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'fechaconsulta' => $Fecha);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            // curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Cabecera");
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/CabeceraEscaner");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarDatosCabecera($Rut, $Fecha, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarCursosPersonal($Rut, $Area, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut, 'idArea' => $Area);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/Revision_AreaCargo_Consulta");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCursosPersonal($Rut, $Area, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarCursosPersonalB($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/Revision_Basicos_Consulta");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCursosPersonalB($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarExperienciaPersonal($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Ultima");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarExperienciaPersonal($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarAñosTotalExperiencia($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/PersonaAcumulado");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarAñosTotalExperiencia($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarFormacionPersonal($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarFormacionPersonal($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== PERSONA CURSO ============================== */

      public function listarTrabajador($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/General_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarTrabajador($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      public function listarTrabajadorxEmpresa($Rut,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/EmpresaAdmin_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarTrabajadorxEmpresa($Rut,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function consultarCursoCursado($Rut,$contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->consultarCursoCursado($Rut,$contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function insertarPersonaCurso($rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => $idCurso, 'idEmpresa' => $idEmpresa, 'idGerencia' => $idGerencia, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->insertarPersonaCurso($rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function InsertCursoCursadoMasiva($rutfull, $pasaporte, $curso, $empresa, $gerenciasigla, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => '', 'curso' => $curso, 'empresa' => $empresa, 'gerenciasigla' => $gerenciasigla, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Masiva_Insertar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->InsertCursoCursadoMasiva($rutfull, $pasaporte, $curso, $empresa, $gerenciasigla, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      public function actualizarPersonaCurso($idCursoCursado, $rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => $idCursoCursado, 'rutfull' => $rutfull, 'pasaporte' => $pasaporte, 'idCurso' => $idCurso, 'idEmpresa' => $idEmpresa, 'idGerencia' => $idGerencia, 'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'asistencia' => $asistencia, 'evaluacion' => $evaluacion, 'resultado' => $resultado);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->actualizarPersonaCurso($idCursoCursado, $rutfull, $pasaporte, $idCurso, $idEmpresa, $idGerencia, $fechainicio, $fechatermino, $asistencia, $evaluacion, $resultado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarCursoCursado($contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCursoCursado($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarCursoCursadoResumen($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Resumen_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCursoCursadoResumen($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCursoCursadoXId($idCursoCursado, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idCursoCursado' => intval($idCursoCursado));
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Cursos/CursoCursado_Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCursoCursadoXId($idCursoCursado, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== CATALOGO LABORAL ============================== */

      public function ListarCatalogo($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CatalogoLaboral/General_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCatalogo($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      public function ListarCVTrabajadorCabecera($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Curriculum/Cabecera");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCVTrabajadorCabecera($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function listarCVExperienciaPersonal($Rut, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->listarCVExperienciaPersonal($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== FormacionAcademica ============================== */

      public function ListarFormacionCVPersonal($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Lista_Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarFormacionCVPersonal($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ActualizarFormacionAcademica($idFAPersona, $Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAPersona' => $idFAPersona, 'rutfull' => $Rut, 'nivel_descripcion' => $nivel, 'estado_descripcion' => $estado, 'carrera_descripcion' => $carrera, 'especialidad_descripcion' => $especialidad, 'institucion_descripcion' => $institucion, 'pais_descripcion' => $pais_codigo, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ActualizarFormacionAcademica($idFAPersona, $Rut, $nivel, $estado, $carrera, $especialidad, $institucion, $pais_codigo, $fecha_inicio, $fecha_termino, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ActualizarEstadoFormacionAcademica($idFAPersona, $vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFAPersona' => $idFAPersona, 'vigencia' => $vigencia, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Estado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ActualizarEstadoFormacionAcademica($idFAPersona, $vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarFormacionAcademicaTotal($contador){
         if($contador>5){
               header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/Total_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarFormacionAcademicaTotal($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarFormacionAcademicaEECC($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/FormacionAcademica/EECC_Listar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarFormacionAcademicaEECC($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
       
      /* ============================== EXPERIENCIA LABORAL ============================== */

      public function ListarExperienciaCVPersonal($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Lista_Personal");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarExperienciaCVPersonal($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarExperienciaXId($idFLExperienciaGeneral, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFLExperienciaGeneral' => $idFLExperienciaGeneral);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Consulta_ID");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarExperienciaXId($idFLExperienciaGeneral, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ActualizarExperienciaLaboral($idFLExperienciaGeneral, $Rut, $cargo, $especialidad, $pais, $fecha_inicio, $fecha_termino, $empresa, $actividad_empresa, $division, $cmarea, $cmproceso, $cmsubproceso, $descripcion, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFLExperienciaGeneral' => $idFLExperienciaGeneral, 'rutfull' => $Rut, 'cargo' => $cargo, 'especialidad' => $especialidad, 'pais' => $pais, 'fecha_inicio' => $fecha_inicio, 'fecha_termino' => $fecha_termino, 'empresa' => $empresa, 'actividad_empresa' => $actividad_empresa, 'division' => $division, 'cmarea' => $cmarea, 'cmproceso' => $cmproceso, 'cmsubproceso' => $cmsubproceso, 'descripcion' => $descripcion, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ActualizarExperienciaLaboral($idFLExperienciaGeneral, $Rut, $cargo, $especialidad, $pais, $fecha_inicio, $fecha_termino, $empresa, $actividad_empresa, $division, $cmarea, $cmproceso, $cmsubproceso, $descripcion, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function EliminarExperienciaLaboral($idFLExperienciaGeneral, $vigencia, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('idFLExperienciaGeneral' => $idFLExperienciaGeneral, 'vigencia' => $vigencia, 'sesion_usuario' => $_SESSION["CapitalHumano"]["rut_CapitalHumano"]);

            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Estado_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->EliminarExperienciaLaboral($idFLExperienciaGeneral, $vigencia, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarExperienciaLaboralTotal($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/Total_Listar");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarExperienciaLaboralTotal($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarExperienciaLaboralEECC($Rut, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $Rut);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/ExperienciaLaboral/EECC_Listar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarExperienciaLaboralEECC($Rut, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      /* ============================== DATOS TRABAJADOR ============================== */

      public function ActualizarDatosPersonales($rutfull, $nacionalidad, $genero, $estado_civil, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull' => $rutfull, 'nacionalidad' => $nacionalidad, 'genero' => $genero, 'estado_civil' => $estado_civil);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Informacion_Actualizar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ActualizarDatosPersonales($rutfull, $nacionalidad, $genero, $estado_civil, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ActualizarDatosContacto($rutfull, $telefono, $pais_codigo, $cutcomuna, $calle, $email, $contador){
         if($contador>5){
               header('../portal.php');
         }else{
               $fields = array('rutfull' => $rutfull, 'telefono' => $telefono, 'pais_codigo' => $pais_codigo, 'cutcomuna' => $cutcomuna, 'calle' => $calle, 'email' => $email);
               $fields_string = json_encode($fields);
               $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
               curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Persona/Contacto_Actualizar");
               curl_setopt($ch, CURLOPT_POST, 1);
               curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

               $server_output = json_decode(curl_exec($ch));

               curl_close ($ch);
               if(isset($server_output->detalle)){
                  $detalle = $server_output->detalle;
                  if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->ActualizarDatosContacto($rutfull, $telefono, $pais_codigo, $cutcomuna, $calle, $email, $contador);
                  }else{
                     return  $server_output;
                  }
               }else{
                  return  $server_output;
               }
         }
      }
  
      /* ============================== DATOS COMUNES ============================== */

      public function ListarCargosVigentes($contador){
         if($contador>5){
               header('../portal.php');
         }else{
               $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
               $ch = curl_init();

               curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
               curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Cargo_Listar_Vigente");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

               $server_output = json_decode(curl_exec($ch));
               curl_close ($ch);
               if(isset($server_output->detalle)){
                  $detalle = $server_output->detalle;
                  if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->ListarCargosVigentes($contador);
                  }else{
                     return  $server_output;
                  }
               }else{
                  return  $server_output;
               }
         }
      }

      public function ListarActividadEmpresaVigentes($contador){
         if($contador>5){
               header('../portal.php');
         }else{
               $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
               $ch = curl_init();

               curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
               curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/ActividadEmpresa_Listar_Vigente");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

               $server_output = json_decode(curl_exec($ch));
               curl_close ($ch);
               if(isset($server_output->detalle)){
                  $detalle = $server_output->detalle;
                  if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->ListarActividadEmpresaVigentes($contador);
                  }else{
                     return  $server_output;
                  }
               }else{
                  return  $server_output;
               }
         }
      }

      public function ListarDivisionesVigentes($contador){
         if($contador>5){
               header('../portal.php');
         }else{
               $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
               $ch = curl_init();

               curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
               curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/Division_Listar_Vigente");
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

               $server_output = json_decode(curl_exec($ch));
               curl_close ($ch);
               if(isset($server_output->detalle)){
                  $detalle = $server_output->detalle;
                  if($detalle=="token expirado o inválido."){
                     $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                     $contador+=1;
                     return $this->ListarDivisionesVigentes($contador);
                  }else{
                     return  $server_output;
                  }
               }else{
                  return  $server_output;
               }
         }
      }

      public function ValidaConsultar($Usuario, $Consulta, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('rutfull_admin' => $Usuario, 'rutfull_trabajador' => $Consulta );
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/CatalogoLaboral/EmpresaAdmin_Valida_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ValidaConsultar($Usuario, $Consulta, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
      
      /* ============================== CICLO MINERO ============================== */

      public function ListarAreaPMVigentes($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CMArea_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarAreaPMVigentes($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ConsultarCMProceso($CMArea, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('CMArea' => $CMArea);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CMProceso_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ConsultarCMProceso($CMArea, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ConsultarCMSubProceso($CMProceso, $contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('CMProceso' => $CMProceso);
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CMSubproceso_Consultar");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));

            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ConsultarCMSubProceso($CMProceso, $contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarCMVigente($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/Mantenedor/CicloMinero_DET_Listar_Vigente");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarCMVigente($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }

      public function ListarArbol($contador){
         if($contador>5){
            header('../portal.php');
         }else{
            $fields = array('padre' => '1', 'primera' => '0');
            $fields_string = json_encode($fields);
            $authorization = "Authorization: Bearer ".$_SESSION["CapitalHumano"]["token_CapitalHumano"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Accept: application/json', 'Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL,"https://appdetprod.codelco.cl:91/apiuni/General/Arbol_Consulta");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $server_output = json_decode(curl_exec($ch));
            curl_close ($ch);
            if(isset($server_output->detalle)){
               $detalle = $server_output->detalle;
               if($detalle=="token expirado o inválido."){
                  $_SESSION["CapitalHumano"]["token_CapitalHumano"] = $this->token()->token;
                  $contador+=1;
                  return $this->ListarArbol($contador);
               }else{
                  return  $server_output;
               }
            }else{
               return  $server_output;
            }
         }
      }
        
   }
