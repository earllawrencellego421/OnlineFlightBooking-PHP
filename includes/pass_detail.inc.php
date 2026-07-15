<?php
session_start();
if(isset($_POST['pass_but']) && isset($_SESSION['userId'])) {
    require '../helpers/init_conn_db.php';  
    $mobile_flag = false;
    $flight_id = $_POST['flight_id'];
    $passengers = $_POST['passengers'];
    $mob_len = count($_POST['mobile']);
    for($i=0;$i<$mob_len;$i++) {
        if(strlen($_POST['mobile'][$i]) !== 11) {
            $mobile_flag = true;
            break;            
        }
    }
    if($mobile_flag) {
        header('Location: ../pass_form.php?error=moblen');
        exit();         
    }
    $date_len = count($_POST['date']);
    for($i=0;$i<$date_len;$i++) {        
        $date_mnth = (int)substr($_POST['date'][$i],5,2);
        $flag = false;
        if($date_mnth > (int)date('m')){
          $flag = true;
        } else if($date_mnth == (int)date('m')){
          if((int)substr($_POST['date'][$i],8,2) >= (int)date('d')) {
            $flag = true;            
          } 
        }  
        if($flag) {
            header('Location: ../pass_form.php?error=invdate');
            exit();    
            break;
        }      
    }        
    $stmt = mysqli_stmt_init($conn);
    $flag = false;
    $pass_ids = array();
    for($i=0;$i<$date_len;$i++) {
        $sql = 'INSERT INTO Passenger_profile (user_id,mobile,dob,f_name,
        m_name,l_name,flight_id) VALUES (?,?,?,?,?,?,?)';            
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            header('Location: ../pass_form.php?error=sqlerror');
            exit();            
        } else {
            mysqli_stmt_bind_param($stmt,'iissssi',$_SESSION['userId'],
                $_POST['mobile'][$i],$_POST['date'][$i],$_POST['firstname'][$i],
                $_POST['midname'][$i],$_POST['lastname'][$i],$flight_id);                           
            mysqli_stmt_execute($stmt);  
            // Ask MySQL what ID it actually assigned instead of guessing —
            // guessing is what caused new bookings to attach to whichever
            // pre-existing passenger row happened to sit at the guessed ID.
            $pass_ids[] = mysqli_insert_id($conn);
            $flag = true;        
        }
    }   
    if($flag) {
        $_SESSION['flight_id'] = $flight_id;
        $_SESSION['class'] = $_POST['class'];
        $_SESSION['passengers'] = $passengers;
        $_SESSION['price'] = $_POST['price'];
        $_SESSION['type'] = $_POST['type'];
        $_SESSION['ret_date'] = $_POST['ret_date'];
        $_SESSION['pass_ids'] = $pass_ids;
        $_SESSION['pass_id'] = $pass_ids[0];
        header('Location: ../payment.php');
        exit();          
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);    

} else {
    header('Location: ../pass_form.php');
    exit();  
}