<?php
require_once("../Model/db.php");

$seat_id_list=json_decode($_POST['seat_id_list'],true);
$options='';
$options .= "<tr>
             <th>Ticket</th>
             <th>Type</th>
             <th>Price</th>
             <th>Remove</th>
             </tr>";
             $total=0;
             foreach($seat_id_list as $seat_id){
                $query=mysqli_query($connection,"select seat,seat_row,type,price from seat where id=$seat_id");
                while($res=mysqli_fetch_assoc($query)){
                    $options .= "<tr>
             <td>".$res['seat_row']."\t".$res['seat']."</td>
             <td>".$res['type']."</td>
             <td>".$res['price']."</td>
             <td><div onclick='removeSeat(this)'><i class='bx bx-x'></i><p style='display:none'>".$seat_id."</p></div></td>

             </tr>";
                    $total+=$res['price'];
                }
             
             }
                                
$options .= "<tr>
             <td>Total </td>
             <td colspan='2' style='text-align:right'>".$total."</td>
             <td></td>
             </tr>";
    echo $options;
?>