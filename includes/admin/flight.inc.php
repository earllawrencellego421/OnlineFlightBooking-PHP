<?php
session_start();
if(isset($_POST['flight_but']) and isset($_SESSION['adminId'])) {
    require '../../helpers/init_conn_db.php';
    $source_date = $_POST['source_date'];
    $source_time = $_POST['source_time'];
    $dest_date = $_POST['dest_date'];
    $dest_time = $_POST['dest_time'];
    $dep_city = $_POST['dep_city'];
    $arr_city = $_POST['arr_city'];
    $price = $_POST['price'];
    $air_id = $_POST['airline_name'];
    $dura = $_POST['dura'];
    
    // Grab the recurrence value, default to 1 if missing
    $recur_days = isset($_POST['recur_days']) ? (int)$_POST['recur_days'] : 1;

    if($dep_city===$arr_city || $arr_city==='To' || $arr_city==='From') {
      header('Location: ../../admin/flight.php?error=same');
      exit();
    }

    $time_source = $source_time.':00';
    $time_dest = $dest_time.':00';
    $arrival = $dest_date.' '.$time_dest;
    $departure = $source_date.' '.$time_source;

    if (strtotime($arrival) <= strtotime($departure)) {
      header('Location: ../../admin/flight.php?error=destless');
      exit();
    } else {
      $sql = "SELECT * FROM Airline WHERE airline_id =?";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt,$sql);
      mysqli_stmt_bind_param($stmt,'i',$air_id);            
      mysqli_stmt_execute($stmt);      
      $result = mysqli_stmt_get_result($stmt);    
      
      if($row = mysqli_fetch_assoc($result)) {
        $seats = $row['seats'];
        $airline_name = $row['name'];
        mysqli_stmt_close($stmt); // Close previous statement before opening new one
        
        $sql = "INSERT INTO Flight(admin_id,arrivale,departure,Destination,source,
          airline,Seats,duration,Price,status,issue) VALUES (?,?,?,
          ?,?,?,?,?,?,'','')";
          
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
          header('Location: ../../admin/flight.php?error=sqlerr1');
          exit();          
        } else {      
          $admin_id = $_SESSION['adminId'];  
          
          // LOOP: Insert a flight for each day requested
          for ($i = 0; $i < $recur_days; $i++) {
              // Add $i days to the original departure and arrival timestamps
              $current_dep = date('Y-m-d H:i:s', strtotime($departure . " +$i days"));
              $current_arr = date('Y-m-d H:i:s', strtotime($arrival . " +$i days"));
              
              mysqli_stmt_bind_param($stmt,'isssssisi',$admin_id,$current_arr,$current_dep,$arr_city,$dep_city,$airline_name,$seats,$dura,$price);            
              mysqli_stmt_execute($stmt); 
          }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: ../../admin/flight.php?flight=success');
        exit();
      } else {
        mysqli_stmt_close($stmt);
        header('Location: ../../admin/flight.php?error=sqlerr');
        exit();
      }
    }
} else {
    header('Location: ../../index.php');
    exit();
}