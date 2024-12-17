<?php
class Seat
{
    public $seat_id;
    public $date;

    public function __construct($seat_id, $date)
    {
        $this->seat_id = $seat_id;
        $this->date = $date;
    }
}
?>


<?php
require_once("../Model/db.php");
if (isset($_POST['city']) && isset($_POST['branch']) && isset($_POST['movie_id'])) {
    $city_id = $_POST['city'];
    $branch_id = $_POST['branch'];
    $movieId = $_POST['movie_id'];
    // Use the received values in the query
    $query = "SELECT seat.id as id,seat.seat as seat,seat.seat_row as seat_row,seat.seat_column as seat_column,seat.type as seat_type,seat.price as price
              FROM show2
              JOIN cinema
              ON show2.cinema_id=cinema.id
              JOIN seat
              ON show2.room_id=seat.room_id AND show2.cinema_id=seat.cinema_id
              WHERE cinema.city = '$city_id'
              AND cinema.branch = '$branch_id'
              AND show2.movie_id = '$movieId'";  // Example for the third value
    $buyseat_query = "SELECT buyseat.id as id,buyseat.seat_id as seat_id,buyseat.date as 'date',cinema.id as cinema_id,show2.id as show_id
              FROM show2
              JOIN cinema
              ON show2.cinema_id=cinema.id
              JOIN buyseat
              ON show2.id=buyseat.show_id AND show2.cinema_id=buyseat.cinema_id
              WHERE cinema.city = '$city_id'
              AND cinema.branch = '$branch_id'
              AND show2.movie_id = '$movieId'";

    $result = mysqli_query($connection, $query);
    $buyseat_result = mysqli_query($connection, $buyseat_query);
    while ($row = mysqli_fetch_assoc($buyseat_result)) {
        $seat = new Seat($row['seat_id'], $row['date']);
        $seats[] = $seat;
        $cinema_id=$row['cinema_id'];
        $show_id=$row['show_id'];
    }

    $seat_id_list = json_decode($_POST['seat_id_list'], true);

    $options = '';

    $row_name = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];
    for ($j = 0; $j < 9; $j++) {
        $options .= " <div class='row ms-3'>";

        for ($i = 1; $i <= 17; $i++) {
            if ($i == 17) {
                $options .= "<div class='col m-0 p-0'><p>" . $row_name[$j] . "</p></div>";
            } else {
                $flag = true;

                // Reset result pointer to the start of the result set
                mysqli_data_seek($result, 0);

                // Loop through fetched rows and check seat positions
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['seat_row'] == $row_name[$j] && $row['seat_column'] == $i) {
                        $bought = false;
                        if (isset($seats)) {
                            foreach ($seats as $seat) {
                                if ($seat->seat_id == $row['id']) {
                                    $bought = true;
                                    break;
                                }
                            }
                        }
                        if ($bought) {
                            $options .= "<div class='col m-0 p-0'><p><i class='bx bxs-lock-alt' style='color:green;font-size:1.8rem'></i></p></div>";
                        } else {

                            if (isset($seat_id_list)) {
                                $exist = false;
                                foreach ($seat_id_list as $seat_id) {
                                    if ($seat_id == $row['id']) {
                                        $exist = true;
                                        break;
                                    }
                                }
                                if ($exist) {
                                    $options .= "<div class='col m-0 p-0'><p style='background:green;color:white' onclick='changeBgColorAndGetData(this)'>" . "<span style='display:none'>" . htmlspecialchars($row['id']) . "</span>" . htmlspecialchars($row['seat']) . "</p></div>";
                                } else {
                                    $options .= "<div class='col m-0 p-0'><p style='background:#dedede;color:black' onclick='changeBgColorAndGetData(this)'>" . "<span style='display:none'>" . htmlspecialchars($row['id']) . "</span>" . htmlspecialchars($row['seat']) . "</p></div>";
                                }
                            } else {
                                $options .= "<div class='col m-0 p-0'><p onclick='changeBgColorAndGetData(this)'>" . "<span style='display:none'>" . htmlspecialchars($row['id']) . "</span>" . htmlspecialchars($row['seat']) . "</p></div>";
                            }
                        }

                        $flag = false;
                        break;
                    }
                }

                // If no matching seat found, display an empty column
                if ($flag) {
                    $options .= "<div class='col m-0 p-0'><p style='background:transparent;border:none;'></p></div>";
                }
            }
        }

        $options .= " </div>";
        
    }


    echo $options.="<p id='cinema_id' style='display:none'>".$cinema_id."</p> <p id='show_id' style='display:none'>".$show_id."</p>";
}

