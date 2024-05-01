<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QRCodeGenerator extends CI_Controller {

    public function index()
    {
        include APPPATH . 'libraries/phpqrcode/qrlib.php';

        $id = $this->read_id();
        $path = 'D:\shibir_app\system\database\qr\ ';
        foreach($id as $value)
        {
            $file = $path . $value . ".png";

            $ecc = 'L';
            $pixel_Size = 10;
            $frame_Size = 10;

            QRcode::png($value, $file, $ecc, $pixel_Size, $frame_Size);
            $this->qr_model->store_qr($value);
            echo "<center><img src='D:\shibir_app\system\database\qr'></center>";
        }

    }

    public function give_qr()
{
    $path = 'system/database/qr/'; // Assuming this is relative to your application
    
    // Display the existing images
    $files = glob($path . "*.png");
    foreach ($files as $file) {
        echo "<center><img src='" . $file . "'></center>";
    }
}




    public function read_id() {
        $filePath = 'C:\Users\limba\OneDrive\Desktop\read.csv';
        
        $file = fopen($filePath, 'r');
        
        $data = array();
        $headerRow = null; 
        
        while (($row = fgetcsv($file)) !== false) {
            if ($headerRow === null) {
                $headerRow = $row;
                continue;
            }
    
            $rowData = array();
    
            foreach ($row as $key => $value) {
                $columnName = isset($headerRow[$key]) ? $headerRow[$key] : "Column$key";
                if($columnName == 'ID Code' ) {  
                    $rowData[] = $value;
                }
            }
            foreach($rowData as $value){
                $data[] = $value;
            }
        }

        fclose($file);
        
        return $data;
    }
      
    
}
