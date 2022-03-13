<?php
require_once 'DbConnect.php';
//store response array
$response = array();
//catch submit click
if(isset($_POST["rowCount"]))
{//check if file has been uploaded
  if($_FILES['file']['name'])
  {
      //break file into name and extension
    $file_array = explode(".", $_FILES['file']['name']);

    $file_name = $file_array[0];

    $extension = end($file_array);

    if($extension == 'csv')
    {
       //size to store
      $store_size = $_POST["rowCount"];
      //store the  data cols
      $column_name = array();

      $final_data = array();
     
      $file_data = file_get_contents($_FILES['file']['tmp_name']);

      $data_array = array_map("str_getcsv", explode("\n", $file_data));
      //remove the first array element as it is the labels
      $labels = array_shift($data_array);

      foreach($labels as $label)
      {
          //store the cols names that were removed
        $column_name[] = $label;
      }
      //compute the number of elements in data array
      $count = count($data_array) - 1;
  

      for($j = 0; $j < $count; $j++)
      {
        //merge the 
        if($j<= $store_size){
            $data = array_combine($column_name, $data_array[$j]);
            $d[] =$data;
            $final_data[$j] = $data;
        }
       
      }

     
     // $d =json_encode($data);
      //store the json array in/the database
     
      $msc = microtime(true);
      foreach(  $d as $row){
          $sql = "INSERT INTO `earthquakes`(`time`, `latitude`, `longitude`, `depth`, `mag`, `magType`, `nst`, `gap`, `dmin`, `rms`, `net`, `id`, `updated`, `place`, `type`, `horizontalError`, `depthError`, `magError`, `magNst`, `status`, `locationSource`, `magSource`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          $stmt = $conn->prepare($sql);
          //i,d,s,b
          $time= $row['time'];
         $latitude= doubleval($row['latitude']);
         $longitude= doubleval($row['longitude']);
          $depth= floatval($row['depth']);
          $mag= floatval($row['mag']);
         $magType= $row['magType'];
          $nst= $row['nst'] != ""?intval($row['nst']):0;
          $gap= $row['gap']!=""?intval($row['gap']):0;
          $dmin= $row['dmin']!=""?doubleval($row['dmin']):0;
          $rms= floatval($row['rms']);
          $net= $row['net'];
          $id= $row['id'];
          $updated= $row['updated'];
          $place= $row['place'];
          $type= $row['type'];
          $horizontalError= $row['horizontalError']!=""?floatval($row['horizontalError']):0;
          $depthError= $row['depthError']!=0?floatval($row['depthError']):0;
          $magError= $row['magError']!=""?floatval($row['magError']):0;
          $magNst= $row['magNst']!=""?intval($row['magNst']):0;
          $status= $row['status'];
          $locationSource= $row['locationSource'];
          $magSource= $row['magSource'];
         
            try {
                //code...
                $stmt->bind_param("sddddsiiddsssssdddisss",$time,$latitude, $longitude,$depth,$mag,$magType,$nst,$gap,$dmin,$rms,$net,$id,$updated,$place, $type, $horizontalError,$depthError,$magError,$magNst,$status,$locationSource,$magSource);
         
                $stmt->execute(); 
                $msc = microtime(true)-$msc;
                $stmt->store_result();
	
	              if($stmt->num_rows > 0){
                  $response['error'] = false; 
                  $response['message'] = 'Data saved successfully!' ;
                  $response['time'] = $msc." secs";//$msc is in seconds
                  $response['page'] ="home";
                }else {
                   $response['error'] = true; 
                  $response['message'] = 'Table doen\'t exist' ;
                  $response['page'] ="home";
                }
               
            } catch (\Throwable $th) {
                //throw $th;
                $response['error'] = true; 
                $response['message'] = 'Table doen\'t exist' ;
                $response['page'] ="home";

            }
        

      }
       
    }
    else
    {
     
     
      $response['error'] = true; 
      $response['message'] = 'Only .csv file that is allowed!' ;
      $response['page'] ="home";
    }
  }
  else
  {
    
    $response['error'] = true; 
    $response['message'] = 'Please Select CSV File!'; 
    $response['page'] ="home";
  }
}

//header("Location: http://localhost/performace_measure/index.html#index?res=".json_encode($response));



echo json_encode($response);
?>




