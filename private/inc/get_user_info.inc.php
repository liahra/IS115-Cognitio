<?php
function get_user_info($pdo, $user_id) {
    // Forbered en SQL-spørring
    $stmt = $pdo->prepare('SELECT password, email FROM accounts WHERE id = :id');
    
    // Bind verdien for user_id
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

    // Utfør spørringen
    $stmt->execute();

    // Hent resultatet som en assosiativ array
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

    // Returner brukerinformasjon hvis funnet, ellers returner null
    return $user_info ? $user_info : null;
}
?>