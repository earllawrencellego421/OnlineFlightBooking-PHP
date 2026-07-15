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

    if($dep_city===$arr_city || $arr_city==='To' || $arr_city==='From') {
      header('Location: ../../admin/flight.php?error=same');
      exit();
    }

    $time_source = $source_time.':00';
    $time_dest = $dest_time.':00';
    $arrival = $dest_date.' '.$time_dest;
    $departure = $source_date.' '.$time_source;

    // Compares full departure/arrival timestamps (year included) instead of
    // the previous month/day/time-only digit comparison, which could
    // misjudge flights that cross a year boundary (e.g. Dec -> Jan).
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
      mysqli_stmt_close($stmt);
      if($row = mysqli_fetch_assoc($result)) {
        $seats = $row['seats'];
        $airline_name = $row['name'];
        $sql = "INSERT INTO Flight(admin_id,arrivale,departure,Destination,source,
          airline,Seats,duration,Price,status,issue) VALUES (?,?,?,
          ?,?,?,?,?,?,'','')";
          
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
          header('Location: ../../admin/flight.php?error=sqlerr1');
          exit();          
        } else {      
          $admin_id = $_SESSION['adminId'];  
          mysqli_stmt_bind_param($stmt,'isssssisi',$admin_id,$arrival,$departure,$arr_city
            ,$dep_city,$airline_name,$seats,$dura,$price);            
          mysqli_stmt_execute($stmt); 
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: ../../admin/flight.php?flight=success');
        exit();
      } else {
        header('Location: ../../admin/flight.php?error=sqlerr');
        exit();
      }
    }
} else {
    header('Location: ../../index.php');
    exit();
}