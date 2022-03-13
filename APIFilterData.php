<?php
require_once 'DbConnect.php';
$response = array();

if (isset($_POST['search'])) {
   
    try {
        $sql = "SELECT * FROM `earthquakes` WHERE `locationSource` LIKE ?";
        $search =$_POST['search']."%";
    
        $msc = microtime(true);
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$search);
        $stmt->execute();

        $res = $stmt->get_result();
        if($res->num_rows >0){
        $msc = microtime(true)-$msc;//$msc is in seconds

        while($assocData = $res->fetch_assoc()) {
            $fetchedData[]=$assocData;
        }
            $stmt->close();
            $response['error'] = false; 
            $response['message'] = 'Earthquakes Data Successfully fetched!'; 
            $response['time'] =$msc." secs";
            $response['data'] =$fetchedData ;
            $response['page'] ="filterData";
    

    }else{
        $response['error'] = true; 
        $response['message'] = 'No Data Fetched, Error!!'; 
        $response['page'] ="filterData";
    } 
        //code...
    } catch (\Throwable $th) {
        //throw $th;
        $response['error'] = true; 
        $response['message'] = 'Table doesn\'t exist!!';
        $response['page'] ="filterData";
    }
     


//header("Location: http://localhost/performace_measure/index.html#filterData?res=".json_encode($response));
}
echo json_encode($response);
