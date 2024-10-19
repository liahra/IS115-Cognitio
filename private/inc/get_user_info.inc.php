<?php
function get_user_info($con, $user_id) {
    // Hent passord og e-post fra db.
    $stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
    
    // Hent brukerinfor basert på ID.
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($password, $email);
    $stmt->fetch();
    $stmt->close();
    
    return ['password' => $password, 'email' => $email];
}
?>