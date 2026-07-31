<?php
/**
 * ============================================================
 *  ADMIN — Update flight status
 *  Location: includes/admin/update_status.php
 *  Called from the inline status dropdown on admin/all_flights.php
 * ============================================================
 */
session_start();
if (isset($_POST['update_status']) && isset($_SESSION['adminId'])) {
    require '../../helpers/init_conn_db.php';

    $flight_id = $_POST['flight_id'];
    $status = $_POST['status'];

    // Only allow the exact set of statuses the dropdown offers —
    // anything else falls back to '' (scheduled) rather than being
    // written straight from user input.
    $allowed = array('', 'dep', 'arr', 'issue');
    if (!in_array($status, $allowed, true)) {
        $status = '';
    }

    $sql = 'UPDATE Flight SET status=? WHERE flight_id=?';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: ../../admin/all_flights.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'si', $status, $flight_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: ../../admin/all_flights.php');
        exit();
    }
} else {
    header('Location: ../../admin/all_flights.php');
    exit();
}