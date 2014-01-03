<?php
/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);

        if ($realSize != $this->getSize()){
            return false;
        }

        $target = fopen($path, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Obtención de la longitud del contenido no está soportado.');
        }
    }
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
        //Asigno valores a los atributos de la clase
        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }
    //funcion para verificar las configuraciones del servidor
    private function checkServerSettings(){
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'incrementar post_max_size y upload_max_filesize a $size'}");
        }
    }

    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = TRUE){
        //Puedo escribir en el directorio
        if (!is_writable($uploadDirectory)){
            return array('error' => "Error de servidor. Permiso denegado en directorio de carga.");
        }
        //Hay archivos
        if (!$this->file){
            return array('error' => 'No hay archivos subidos.');
        }
        //Asigno el tamaño
        $size = $this->file->getSize();
        //El tamaño está vacío
        if ($size == 0) {
            return array('error' => 'Tamaño está vacío');
        }
        //Es muy grande el archivo
        if ($size > $this->sizeLimit) {
            return array('error' => 'Archivo es muy grande');
        }
        //Direccion del archivo en el cliente
        $pathinfo = pathinfo($this->file->getName());
        //Nombre del archivo
        $filename = $pathinfo['filename'];
        
        if(stripos($filename, "m")!==FALSE && stripos($filename, "v")!==FALSE){
            $filename="movistar";
        }
        elseif(stripos($filename, "p")!==FALSE && stripos($filename, "u")!==FALSE
                && stripos($filename, "e")===FALSE && stripos($filename, "x")===FALSE){
            $filename="captura";
        }
        elseif(stripos($filename, "e")!==FALSE && stripos($filename, "x")!==FALSE){
            $filename="etelixPeru";
        }
        elseif(stripos($filename, "l")!==FALSE){
            $filename="claro";
        }
        else{
            
            $filename="*";
            
        }

        //$filename = md5(uniqid());
        
        if($filename!=="*"){
            $ext = $pathinfo['extension'];
            //Si la extension del archivo es diferente a las permitidas
            if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
                $these = implode(', ', $this->allowedExtensions);
                return array('error' => 'El archivo tiene una extension invalida, deberá ser '. $these . '.');
            }

            if(!$replaceOldFile){
                /// don't overwrite previous files that were uploaded
                while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                    $filename .= rand(10, 99);
                }
            }

            if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
                return array('success'=>true,'filename'=>$filename.'.'.$ext);
            } else {
                return array('error'=> 'No se pudo salvar el archivo.' .
                    'La carga fue cancelada, o el servidor encontró un error.');
            }
        }
        elseif($filename==="*"){
            
            return array('error'=> 'No se pudo salvar el archivo.' .
                    'La carga fue cancelada, ESTE ARCHIVO NO ESTA PERMITIDO.');
            
        }
    }
}
