<?php
require_once 'DbConnect.php';
$response = array();
if (isset($_POST['create'])) {
   

    $sql = "CREATE TABLE `perfomancemeasurement`.`earthquakes` ( `time` VARCHAR(25) NOT NULL , `latitude` DOUBLE NOT NULL , `longitude` DOUBLE NOT NULL , `depth` FLOAT(10) NOT NULL , `mag` FLOAT(10) NOT NULL , `magType` VARCHAR(5) NOT NULL , `nst` INT(5) NULL , `gap` INT(5) NULL , `dmin` DOUBLE NULL , `rms` FLOAT(10) NOT NULL , `net` VARCHAR(5) NOT NULL , `id` VARCHAR(15) NOT NULL , `updated` VARCHAR(25) NOT NULL , `place` VARCHAR(50) NOT NULL , `type` VARCHAR(10) NOT NULL , `horizontalError` FLOAT(10) NULL , `depthError` FLOAT(10) NULL , `magError` FLOAT(10) NULL , `magNst` INT(5) NULL , `status` VARCHAR(10) NOT NULL , `locationSource` VARCHAR(5) NOT NULL , `magSource` VARCHAR(5) NOT NULL )";

    $msc = microtime(true);
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if($result >0){
        $msc = microtime(true)-$msc;//$msc is in seconds

        $stmt->close();
        $response['error'] = false; 
        $response['message'] = 'Table \'earthquakes\' was created successfuly!'; 
        $response['time'] =$msc." secs";
        $response['page'] ="createTable";

    }else{
        $response['error'] = true; 
        $response['message'] = 'Error during creation of table, Table exist!!'; 
        $response['page'] ="createTable";
    }

   // header("Location: http://localhost/performace_measure/index.html#createTable?res=".json_encode($response));
}  
echo json_encode($response);