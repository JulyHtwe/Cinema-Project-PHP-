<?php
require_once('db.php'); 

if (isset($_POST['uID'], $_POST['movieid'])) {
    global $connection;
    $stmt = $connection->prepare("SELECT emoji FROM rating WHERE u_id = ? AND m_id = ?");
    
    if ($stmt) {
        $stmt->bind_param("ss", $_POST['uID'], $_POST['movieid']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data = $row['emoji'];
            }
            echo json_encode($data);
        } else {
            echo json_encode(['success' => false, 'error' => 'No rating found']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
    $connection->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>