<?php
require_once('db.php');
if (isset($_POST['uID'], $_POST['cinema_id'], $_POST['show_id'], $_POST['seat_id_list'])) {
    global $connection;
    $today = date("Y-m-d");
    $currentTime = date("h:i:s A");
    $buy_seat_id_list = array(); 
    $seat_id_list = json_decode($_POST['seat_id_list']);
    foreach ($seat_id_list as $seat_id) {
        $randomNumber = rand(0, 999);
        $sql = "SELECT * FROM seat WHERE id = $seat_id";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $cinema_id = $row['cinema_id'];
                $show_id = $_POST['show_id'];
                $seat_id = $row['id'];
                $price = $row['price'];
                $id = $cinema_id . $show_id . $seat_id . $randomNumber;
                $buy_seat_id_list[] = (int)$id;
                buyseat($id, $cinema_id, $show_id, $seat_id, $today, $price, $currentTime);
            }
        }
    }

    if (count($buy_seat_id_list) > 0) {
        $json_string = json_encode($buy_seat_id_list);
        $token = generateShortToken(4).'-'.generateShortToken(4).'-'.generateShortToken(4);

        $userID = mysqli_real_escape_string($connection, $_POST['uID']);
        $cinemaID = mysqli_real_escape_string($connection, $_POST['cinema_id']);
        $showID = mysqli_real_escape_string($connection, $_POST['show_id']);
        $ticket_insert_sql = "INSERT INTO ticket (id,user_id, cinema_id, show_id, seat_id_list, `date`) 
                              VALUES ('$token','$userID', '$cinemaID', '$showID', '$json_string', '$today')";

        if (mysqli_query($connection, $ticket_insert_sql)) {
            $response = array(
                'status' => 'success',
                'message' => 'Tickets are purchased!'
            );
            echo json_encode($response);
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }
    mysqli_close($connection);
}
function generateShortToken($length) {
    return substr(bin2hex(random_bytes($length / 2)), 0, $length);
}

// Example usage
function buyseat($id, $cinema_id, $show_id, $seat_id, $today, $price, $currentTime)
{
    global $connection;
    $id = (int)$id;
    $cinema_id = mysqli_real_escape_string($connection, $cinema_id);
    $show_id = mysqli_real_escape_string($connection, $show_id);
    $seat_id = (int)$seat_id;
    $price = (float)$price;
    $today = mysqli_real_escape_string($connection, $today);
    $currentTime = mysqli_real_escape_string($connection, $currentTime);
    $buyseat_insert_sql = "INSERT INTO buyseat (id, cinema_id, show_id, seat_id, `date`, price, `time`) 
                           VALUES ($id, '$cinema_id', '$show_id', $seat_id, '$today', $price, '$currentTime')";

    if (mysqli_query($connection, $buyseat_insert_sql)) {
    } else {
       echo "Error executing buyseat query: " . mysqli_error($connection);
    }
}
?>
