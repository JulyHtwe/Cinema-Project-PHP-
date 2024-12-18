<?php
include('../Model/db.php');
// Ensure that the uID is properly retrieved from the query string
$uID = isset($_POST['uID']) ? $_POST['uID'] : '';
if ($uID) {

    // Make sure $uID is safe to use in the query (prevent SQL injection)
    $uID = mysqli_real_escape_string($connection, $uID);

    // Query to get the seat_id_list for the given user

    $options = "<div class='ticket_item'>
                        <div class='ticket_header1'>
                            <h1><b>Mingalar Cinema</b></h1>";

    $ticket_sql = mysqli_query($connection, "SELECT seat_id_list FROM ticket WHERE user_id = '$uID'");
    if ($ticket_sql->num_rows > 0) {
        while ($ticket_row = $ticket_sql->fetch_assoc()) {
            $seat_id_list = json_decode(json: $ticket_row['seat_id_list']);
            $count = 0;
            $total = 0;

            // print_r($seatlist);
            foreach ($seat_id_list as $seat_id) {


                $ticket_sql = mysqli_query($connection, "
                    SELECT seat.seat as seat, seat.seat_row as seat_row, seat.type as type, seat.price as price, cinema.branch as branch, cinema.city as city, 
                    show2.time as time, movie.title as title, movie.display as display, buyseat.date as date
                    FROM seat JOIN buyseat ON buyseat.seat_id=seat.id
                    JOIN cinema ON buyseat.cinema_id = cinema.id
                    JOIN show2 ON buyseat.show_id = show2.id
                    JOIN movie ON movie.id = show2.movie_id 
                    WHERE buyseat.id=$seat_id
                    ");

                while ($ticket_sql_res = mysqli_fetch_assoc($ticket_sql)) {
                    if ($count == 0) {
                        $options .= "<h4><span>Branch </span>:" . $ticket_sql_res['branch'] . ',' . $ticket_sql_res['city'] . "</h4>
                                    <h4><span>Room </span>:" . $ticket_sql_res['display'] . "</h4>
                                    <h1>" . $ticket_sql_res['title'] . "</h1>
                                    </div>

                                    <div class='ticket_header2'>
                                    <h5>Date : <span>" . $ticket_sql_res['date'] . "</span></h5>
                                        <h5>Show Time : <span>" . $ticket_sql_res['time'] . "</span></h5>
                                    </div>";
                        $options .= "<div class='ticket_body'>
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
                                    <td>" . $ticket_sql_res['seat_row'] . " " . $ticket_sql_res['seat'] . "</td>
                                    <td>" . $ticket_sql_res['type'] . "</td>
                                    <td>" . $ticket_sql_res['price'] . "</td>
                                </tr>";

                    $total += $ticket_sql_res['price'];

                    if ($count == count($seat_id_list) - 1) {
                        $options .= "<tr>
                                         <td><b>Total</b></td>
                                         <td colspan='2'><b>" . $total . "</b></td>
                                    </tr> 
                                    </tbody>
                                    </table>
                                    </div>
                                    <div class='ticket_footer'>
                                        <h5>Time : " . $ticket_sql_res['time'] . "</h5>
                                        <button class='btn btn-primary'>Print</button>
                                    </div>";
                    }

                    $count++;
                }
            }
        }
    }
    echo $options .= " </div>
                </div>";
}
                //     <div class="ticket_item">
                //         <div class="ticket_header1">
                //             <h1><b>Mingalar Cinema</b></h1>
                //             <h4><span>Branch </span>: 2, Taungoo</h4>
                //             <h4><span>Room </span>: 2D</h4>
                //             <h1>Tha Bin Thal Mya Hnin Si 2</h1>
                //         </div>

                //         <div class="ticket_header2">
                //             <h5>Date : <span>2024-09-11</span></h5>
                //             <h5>Show Time : <span>10:00 am</span></h5>
                //         </div>
                //         <div class="ticket_body">
                //             <table class="table table-hover">
                //                 <thead>
                //                     <tr>
                //                         <th scope="col">Seat</th>
                //                         <th scope="col">Type</th>
                //                         <th scope="col">Price</th>
                //                     </tr>
                //                 </thead>
                //                 <tbody>
                //                     <tr>
                //                         <td>Mark</td>
                //                         <td>Otto</td>
                //                         <td>@mdo</td>
                //                     </tr>
                //                     <tr>
                //                         <td>Jacob</td>
                //                         <td>Thornton</td>
                //                         <td>@fat</td>
                //                     </tr>
                //                     <tr>
                //                         <td>Total</td>
                //                         <td colspan="2">12000</td>
                //                     </tr>
                //                 </tbody>
                //             </table>
                //         </div>
                //         <div class="ticket_footer">
                //             <h5>Time : 02:37:47 PM</h5>
                //             <button>Print</button>
                //         </div>
                //     </div>
                // </div>
