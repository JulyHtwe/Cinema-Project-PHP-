<?php 
require_once('db.php'); 

if (isset($_POST['save'])) {
    if (isset($_POST['uID'], $_POST['movieid'], $_POST['rate'], $_POST['emoji'])) {
        global $connection; 
        $stmt = $connection->prepare("INSERT INTO rating (m_id, u_id, rate, emoji) VALUES (?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("ssss", $_POST['movieid'], $_POST['uID'], $_POST['rate'], $_POST['emoji']);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
        }
        
        $connection->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
    }
}
?>
