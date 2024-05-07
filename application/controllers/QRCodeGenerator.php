<?php
defined('BASEPATH') OR exit('No direct script access allowed');



if (isset($_SERVER['HTTP_ORIGIN'])) {
          // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one you want to allow, and if so:
          header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
          header('Access-Control-Allow-Credentials: true');
          header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }
      
      // Access-Control headers are received during OPTIONS requests
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
              header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
      
          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
              header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
      
          exit(0);
      }



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
