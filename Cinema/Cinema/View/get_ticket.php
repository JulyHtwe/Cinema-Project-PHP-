<?php
include('../Model/db.php');

$uID = isset($_POST['uID']) ? $_POST['uID'] : '';
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$start_date_obj = DateTime::createFromFormat('Y-m-d', $start_date);
$end_date_obj = DateTime::createFromFormat('Y-m-d', $end_date);
$start_date_formatted = $start_date_obj->format('Y-m-d');
$end_date_formatted = $end_date_obj->format('Y-m-d');
if ($uID) {
    $uID = mysqli_real_escape_string($connection, $uID);
    $options = '';

    $ticket_sql = mysqli_query($connection, "SELECT id,seat_id_list,watched FROM ticket WHERE user_id = '$uID' AND date BETWEEN '$start_date_formatted' AND '$end_date_formatted'");
    if ($ticket_sql->num_rows > 0) {
        while ($ticket_row = $ticket_sql->fetch_assoc()) {
            $token = $ticket_row['id'];
            $watched = $ticket_row['watched'];
            $seat_id_list = json_decode($ticket_row['seat_id_list']);
            $count = 0;
            $total = 0;
            $options .= "<div class='ticket_item' style='width:400px'>
                            <div class='ticket_receipt'>
                            <div class='ticket_header1'>
                            <h1 style='font-size:1.5rem;'><b>Mingalar Cinema</b></h1>
                            <p style='border-bottom:1px solid gray;line-height:2rem;margin-bottom:0.5rem;border-top:1px solid gray;margin-top:0.5rem;'><span>Token</span>:" . $ticket_row['id'] . "</p>
                                ";
            $seat_ids = implode(',', array_map('intval', $seat_id_list));
            $query = "
                SELECT seat.seat AS seat, seat.seat_row AS seat_row, seat.type AS type, seat.price AS price,
                       cinema.branch AS branch, cinema.city AS city, show2.time AS time, 
                       movie.title AS title, movie.display AS display, buyseat.date AS date
                FROM seat
                JOIN buyseat ON buyseat.seat_id = seat.id
                JOIN cinema ON buyseat.cinema_id = cinema.id
                JOIN show2 ON buyseat.show_id = show2.id
                JOIN movie ON movie.id = show2.movie_id
                WHERE buyseat.id IN ($seat_ids)
            ";

            $ticket_sql_res = mysqli_query($connection, $query);
            if (mysqli_num_rows($ticket_sql_res) > 0) {
                while ($row = mysqli_fetch_assoc($ticket_sql_res)) {
                    if ($count == 0) {
                        $options .= "<p><span>Branch </span>:" . htmlspecialchars($row['branch']) . ', ' . htmlspecialchars($row['city']) . "</p>
                                     <p><span>Room </span>:" . htmlspecialchars($row['display']) . "</p>
                                     <h5>" . htmlspecialchars($row['title']) . "</h5>
                                    </div>
                                    <div class='ticket_header2'>
                                        <p>Date : <span>" . htmlspecialchars($row['date']) . "</span></p>
                                        <p>Show Time : <span>" . htmlspecialchars($row['time']) . "</span></p>
                                    </div>
                                    <div class='ticket_body'>
                                        <table class='table'>
                                            <thead>
                                                <tr>
                                                    <th scope='col'>Seat</th>
                                                    <th scope='col'>Type</th>
                                                    <th scope='col'>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                    }
                    $options .= "<tr>
                                    <td>" . htmlspecialchars($row['seat_row']) . " " . htmlspecialchars($row['seat']) . "</td>
                                    <td>" . htmlspecialchars($row['type']) . "</td>
                                    <td>" . htmlspecialchars($row['price']) . "</td>
                                </tr>";
                    $total += $row['price'];
                    $time = $row['time'];

                    $count++;
                }
                $options .= "<tr>
                                 <td><b>Total</b></td>
                                 <td colspan='2'><b>" . htmlspecialchars($total) . "</b></td>
                            </tr>
                            </tbody>
                            </table>
                            </div>
                            <div class='ticket_footer'>
                                <p>Time : " . htmlspecialchars($time) . "</p>

                            </div>
                            </div>";
            }
            if ($watched === 'false') {
                $barcodeData = $token;
                $barcodeType = '128'; // Supported types: C128, EAN13, UPC-A, etc.

                // Generate barcode using an API
                $barcodeUrl = "https://barcodeapi.org/api/{$barcodeType}/{$barcodeData}";
                $options .= "
                <div class='ticket_receipt mt-1 text-center'>
                                        <img style='width:100%;height:5rem' src=" . $barcodeUrl . " alt='Barcode'>
                                </div>
                ";
            }
            $options .= "</div>";
        }
    }
    echo $options;
}
