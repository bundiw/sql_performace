<?php
require_once 'DbConnect.php';
$response = array();
if (isset($_POST['delete'])) {
    # code...

    $sql = "DROP TABLE `earthquakes`";

    $msc = microtime(true);
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if($result >0){
    $msc = microtime(true)-$msc;//$msc is in seconds

        $stmt->close();
        $response['error'] = false; 
        $response['message'] = 'Table \'earthquakes\' was Deleted successfuly!'; 
        $response['time'] =$msc." secs";
        $response['page'] ="createTable";

    }else{
        $response['error'] = true; 
        $response['message'] = 'Error during deletion of table, Table doen\'t exist!!'; 
        $response['page'] ="createTable";
    }

    //header("Location: http://localhost/performace_measure/index.html#createTable?res=".json_encode($response));
   } 
   echo json_encode($response);