<?php
include("../Model/db.php");
$id = "";
$row = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($connection, "SELECT * FROM movie WHERE id = $id");
    $row = mysqli_fetch_assoc($sql);
    echo '<input type="hidden" name="movieid" id="movieid" value="' . ($row['id'] ?? 'N/A') . '">';
    $rating_sql = mysqli_query($connection, "select rate from rating where m_id=$id");
    //$rating_row=mysqli_fetch_assoc($rating_sql);
    $count = 0;
    $rate_index = 0;
    $flag = false;
    while ($res = mysqli_fetch_assoc($rating_sql)) {
        $count++;
        $rate_index += $res['rate'];
        $flag = true;
    }

    $total_res = $flag ? ($rate_index / ($count * 5)) * 10 : 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-3.4.0.min.js"
        integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </style>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: Poppins;
        margin: 0;
        background: linear-gradient(120deg, #f8f9fa, #e9ecef, #dee2e6);
        overflow: hidden;
        /* Snow to Gray mix height: 100vh; */
    }

    .main {
        padding: 20px;
        display: flex;
        flex-direction: row;
        gap: 10px;
        margin: 0;
        height: 95vh;
    }

    .img_div {
        margin: 30px 20px;
        width: 30%;
        height: 85vh;
    }

    img {

        width: 100%;
        height: 100%;
        background: white;
        border: 1px solid rgba(222, 226, 230, 0.5);
        border-radius: 12px;
    }

    .detail_div {
        margin: 30px 20px;
        width: 75%;
        height: 93vh;
        /* color: black; */
    }

    .movie_detail {
        margin-top: 10px;
    }

    #for_detail {
        background: linear-gradient(90deg, #c9cdd2, #cfd2d5, #c9cdd2);
        border: 1px solid rgba(222, 226, 230, 0.5);
        border-radius: 12px;
        padding: 10px;
        overflow-y: scroll;
        width: 100%;
        height: 100%;
        margin: 0;
    }

    #for_rating {
        background: linear-gradient(90deg, #c9cdd2, #cfd2d5, #c9cdd2);
        border: 1px solid rgba(222, 226, 230, 0.5);
        border-radius: 12px;
        padding: 10px;
        width: 100%;
        height: 100%;
    }

    #for_seat {
        background: linear-gradient(90deg, #c9cdd2, #cfd2d5, #c9cdd2);
        border: 1px solid rgba(222, 226, 230, 0.5);
        border-radius: 12px;
        padding: 10px;
        width: 100%;
        height: 100%;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    #spoil {
        font-size: 14px;
        text-align: justify;
        text-indent: 40px;
    }

    .title-content {
        width: 100%;
        display: flex;
        background: linear-gradient(90deg, #c9cdd2, #cfd2d5, #c9cdd2);
        border: 1px solid rgba(222, 226, 230, 0.5);
        border-radius: 12px;
        padding: 10px;
        justify-content: space-between;
        align-items: center;
        text-align: center;
    }

   .title-content div h2 {
        margin: 0;
        font-size: 30px;
        text-align: left;
    }

    .time_detail {
        margin: 0;
        padding: 0;
        display: flex;
        width: 350px;
    }

    .time_detail p {
        padding: 0;
        margin: 0;
        color: black;
    }

    .title-content button {
        background-color: red;
        color: white;
        width: 150px;
        height: 40px;
        border-radius: 20px;
        margin-right: 0;
    }

    td#head_td {
        width: 100px;
    }

    .icon {
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .icon i {
        text-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
        font-size: 3rem;
        margin-left: 30px;
    }

    #command {
        height: 100px;
    }

    .feeling {
        display: flex;
        gap: 100px;
        margin-top: 5px;
        justify-content: center;
        text-align: center;
        margin-bottom: 20px;
    }

    .sub_feeling {
        display: flex;
        flex-direction: column;
        /* gap: 50px; */
    }

    #small_gp i {
        font-size: 2.5rem;
        color: golden;
        text-align: center;
        padding: 20px;
        text-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
    }

    #i_feeling {
        color: gold;
        font-size: 50px;
    }

    .title_btn {
        display: flex;
    }

    .title_btn button {
        border: none;
        font-size: 20px;
    }

    #detail_btn,
    #rating_btn,
    #seat_btn {
        color: black;
        /* border: none; */
        margin: 10px 0px;

    }

    #rating_btn,
    #detail_btn {
        margin-left: 20px;
    }

    .seat-body .row .col p {
        width: 30px;
        height: 30px;
        border-radius: 5px;
        background: #dedede;
        border: 1px solid rgba(222, 226, 230, 0.5);
        color: black;
        text-align: center;
        line-height: 30px;
        cursor: pointer;

    }

    .seat-body .row .col:last-child p {
        background-color: transparent;
        color: black;
    }

    .send {
        position: absolute;
        width: 100px;
        bottom: 16%;
        left: 50%;
        text-align: center;
        transform: translateX(100%);

    }

    .submit {
        background-color: red;
        color: white;
        width: 150px;
        height: 40px;
        border-radius: 20px;
        margin-top: 10px;
        margin: 0 auto;
        display: block;

    }

    @media screen and (max-width: 678px) {
        img {
            width: 80px;
            height: 350px;
        }

        .detail_div {
            width: 500px;
            height: 350px;
        }

        i,
        #spoil,
        #title,
        #review,
        #small_gp i,
        #i_feeling,
        .title_btn button {
            font-size: 10px;
        }

    }

    .active-btn {
        border: none;
        border-bottom: 5px solid blue;
    }

    .score {
        background-color: black;
        color: white;
        padding: 3px;
        width: 145px;
        text-align: center;
        border-radius: 5px;
        margin: 0;
        margin-top: 8px;
    }

    .score span {
        color: yellow;
    }

    #buy_list tr th:last-child,
    #buy_list tr th:nth-child(2),
    #buy_list tr td:nth-child(2),
    #buy_list tr th:nth-child(3),
    #buy_list tr td:nth-child(3),
    #buy_list tr td:last-child {
        text-align: right;
    }

    #buy_list tr td:last-child i {
        font-size: 2rem;
    }

    .find {
        position: absolute;
        margin: 0;
        bottom: 7rem;
    }

    .toggle-btn {
        font-size: 1.5rem;
        height: 40px;
        width: 40px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        position: absolute;
        top: 0;
        left: 0;
        cursor: pointer;
    }

    .find-content {
        display: flex;
        gap: 10px;
        margin-left: 40px;
        position: absolute;
    }

    .find-btn {
        width: 60px;
    }

    .form-select {
        width: 150px;
    }

    .buy_payment .payment_method {
        display: flex;

    }



    .buy_payment .btn_list {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .buy_payment .btn_list button {
        margin-top: 10px;
        width: 100%;
        height: 40px;
    }

    .kpay,
    .wave {
        position: relative;
        display: inline-block;
        margin: 10px;
    }

    .buy_payment .payment_method img {
        width: 60px;
        height: 60px;
        display: block;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .kpay i,
    .wave i {
        position: absolute;
        font-size: 3rem;
        color: green;
        text-align: center;
        opacity: 1;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .payment_content {
        background-color: lightgray;
        padding-top: 10px;
    }

    .custom-scrollbar-css::-webkit-scrollbar {
        width: 5px;

    }

    .custom-scrollbar-css::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar-css::-webkit-scrollbar-thumb {
        border-radius: 1rem;
        background-color: RGBA(0, 0, 255, 0.4);
    }

    .min {
        min-height: 265px;
    }

    #buy_cart {
        overflow: hidden;
    }

    @media (min-height: 500px) {
        #buy_cart {
            overflow: auto;
            overflow-x: hidden;
        }
    }
</style>

<body>
    <label for=""></label>
    <div class="main">
        <div class="img_div">
            <?php
            if ($row) {
                $base64_image = $row['image'];
                echo '<img src="data:image/jpeg;base64,' . $base64_image . '" alt="Image" id="poster_image"/>';
            ?>

                <div id="buy_cart" style="display:none;height:80%;border-radius:15px;"
                    class="custom-scrollbar-css max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-100 v-85 ">
                    <?php
                    echo '<img src="data:image/jpeg;base64,' . $base64_image . '" alt="Image" style="height:150px;border-radius:0"/>';
                    ?>
                    <div class="p-1">
                        <div class="min">
                            <table class="table" id="buy_list">

                            </table>
                        </div>

                        <div class="buy_payment container">
                            <div class="shadow-bg container rounded payment_content">
                                <h6>Payment Choose</h6>
                                <div class="payment_method">
                                    <div class="kpay">
                                        <i class='bx'></i>
                                        <img src="../Photo/kpay.jpg" alt="" class="kpay_img">
                                    </div>

                                    <div class="wave ms-3">
                                        <i class='bx'></i>
                                        <img src="../Photo/wave.png" alt="" class="wave_img">
                                    </div>


                                </div>
                            </div>

                            <div class="btn_list">
                                <button class='btn btn-danger' onclick="cancel()">Cancel</button>
                                <button class='btn btn-primary ms-3' onclick='buyTicket()'>Buy</button>

                            </div>
                        </div>
                    </div>

                </div>
        </div>
    <?php
            } else {
                echo "No image available.";
            }
    ?>
    <script>
        function cancel() {
            seat_id_list.splice(0, seat_id_list.length);
            fetchSeat();

            document.querySelector("#poster_image").style.display = seat_id_list.length > 0 ? 'none' : 'block';
            document.querySelector("#buy_cart").style.display = seat_id_list.length > 0 ? 'block' : 'none';
            // const table = document.getElementById('buy_list');
            // while (table.rows.length > 0) {
            //     table.deleteRow(0);
            // }

            //const id = document.getElementById('movieid').value;
            // window.location.href = "http://localhost/Cinema1/Cinema/View/detail1.php?id=" + id;
        }
    </script>
    <script>
        const kpay = document.querySelector(".kpay");
        const wave = document.querySelector(".wave");
        kpay.addEventListener("click", () => {
            const icon = kpay.querySelector(".bx");
            icon.classList.toggle("bxs-check-circle");
            // icon.classList.toggle("bx-x");
            document.querySelector(".kpay_img").style.opacity =
                icon.classList.contains("bxs-check-circle") ? 0.3 : 1;

            const wave_icon = wave.querySelector(".bx");
            wave_icon.classList.remove("bxs-check-circle");
            wave.querySelector("img").style.opacity = 1;
        });


        wave.addEventListener("click", () => {
            const icon = wave.querySelector(".bx");
            icon.classList.toggle("bxs-check-circle");
            document.querySelector(".wave_img").style.opacity =
                icon.classList.contains("bxs-check-circle") ? 0.3 : 1;

            const kpay_icon = kpay.querySelector(".bx");
            kpay_icon.classList.remove("bxs-check-circle");
            kpay.querySelector("img").style.opacity = 1;
        });

        function buyTicket() {

            var uID = getDeviceId();
            var show_id = document.getElementById('show_id').innerText;
            var cinema_id = document.querySelector('#cinema_id').innerText;
            // alert(uID+','+show_id+','+cinema_id+','+seat_id_list);
            // window.location.href = "index.php?uID=" + encodeURIComponent(uID);
            

            $.ajax({
                url: "../Model/buydb.php",
                method: "POST",
                dataType: 'json',
                data: {
                    uID: uID,
                    show_id: show_id,
                    cinema_id: cinema_id,
                    seat_id_list: JSON.stringify(seat_id_list)
                },
                success: function(result) {
                    alert(result.message);
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
            cancel();
        }
    </script>

    <div class="detail_div">
        <div class="title-content" style="height:20%;">
            <div>
                <h2 id="title"><?= isset($row['title']) ? $row['title'] : 'N/A'; ?> | </h2>
                <div class="time_detail">
                    <p> <?= isset($row['release_date']) ? $row['release_date'] : 'N/A'; ?> | </p>
                    <p> <?= isset($row['duration']) ? $row['duration'] : 'N/A'; ?> | </p>
                    <p> <?= isset($row['genre']) ? $row['genre'] : 'N/A'; ?> </p>
                </div>
                <p class="score">Score : <span><?php echo $total_res ?> out of 10</span></p>
            </div>

            <a href="<?php echo $row['trailer_url'] ?>"><button type="button" id="a">TRAILER</button></a>
            <!-- <script>
                var youtubeUrl = "<?php echo $row['trailer_url'] ?>";
            </script> -->
        </div>
        <div class="title_btn" style="height:10%;">
            <p id="seat_btn" class="active-btn"><button type="button">Seat</button></p>
            <p id="detail_btn"><button type="button">Detail</button></p>
            <p id="rating_btn"><button type="button">Rating</button></p>

        </div>
        <div style="height:60%;" class="movie_detail">
            <div class="custom-scrollbar-css" id="for_detail" style="display:none;">
                <table>
                    <tr>
                        <td id="head_td">Director</td>
                        <td><?= isset($row['director']) ? $row['director'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Actors</td>
                        <td><?= isset($row['cast']) ? $row['cast'] : 'N/A'; ?></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td>Subtitles</td>
                        <td><?= isset($row['language']) ? $row['language'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Video</td>
                        <td><?= isset($row['display']) ? $row['display'] : 'N/A'; ?></td>
                    </tr>
                </table>
                <p id="spoil"><?= isset($row['detail']) ? $row['detail'] : 'N/A'; ?></p>
            </div>
            <div class="review" id="for_rating" style="display:none;">
                <form action="#" class="star">
                    <div class="icon">


                        <div text_align="center">
                            <i class="fa fa-star fa-2x" data-index="0"></i>
                            <i class="fa fa-star fa-2x" data-index="1"></i>
                            <i class="fa fa-star fa-2x" data-index="2"></i>
                            <i class="fa fa-star fa-2x" data-index="3"></i>
                            <i class="fa fa-star fa-2x" data-index="4"></i>
                            <br><br>


                        </div>

                    </div>

                    <div class="feeling">

                        <div class="sub_feeling">
                            <div id="small_gp">
                                <i class="fa-solid fa-heart" id="i_feeling"></i>
                                <div>
                                    <input type="radio" id="option1" name="group1" value="အရမ်းကောင်း">
                                    <label for="option1">အရမ်းကောင်း</label><br>
                                </div>
                            </div>

                            <div id="small_gp">
                                <i class="fa-regular fa-thumbs-up" id="i_feeling"></i>
                                <div>
                                    <input type="radio" id="option2" name="group1" value="ကောင်းသည်">
                                    <label for="option2">ကောင်းသည်</label><br>
                                </div>
                            </div>
                        </div>
                        <div class="sub_feeling">
                            <div id="small_gp">
                                <i class="fa-solid fa-face-smile" id="i_feeling"></i>
                                <div>
                                    <input type="radio" id="option3" name="group1" value="အသင့်အတင့်">
                                    <label for="option3">အသင့်အတင့်</label>
                                </div>
                            </div>

                            <div id="small_gp">
                                <i class="fa-solid fa-face-laugh-squint" id="i_feeling"></i>
                                <div>
                                    <input type="radio" id="option1" name="group1" value="ရယ်ရသည်">
                                    <label for="option1">ရယ်ရသည်</label><br>
                                </div>
                            </div>
                        </div>
                        <div class="sub_feeling">
                            <div id="small_gp">
                                <i class="fa-solid fa-face-tired" id="i_feeling"></i>
                                <div>
                                    <input type="radio" id="option2" name="group1" value="ကြောက်ဖို့ကောင်း">
                                    <label for="option2">ကြောက်ဖို့ကောင်း</label><br>
                                </div>
                            </div>

                            <div id="small_gp">
                                <i class="fa-solid fa-thumbs-down" id="i_feeling"></i>
                                <div>
                                    <input type="radio" id="option3" name="group1" value="မကောင်း ">
                                    <label for="option3">မကောင်း</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="submit">submit</button>
                </form>
            </div>
            <div class="seat custom-scrollbar-css" id="for_seat" style="display:block;">
                <div class="container find">
                    <div class="find-content">
                        <div class="mb-3">
                            <select class="form-select" id="citys" aria-label="Default select example"
                                onchange="fetchShowtimes()">
                                <option value="" disabled selected>Select City</option>
                                <?php
                                $city_sql = mysqli_query($connection, "select cinema.id,cinema.city from cinema join show2 on cinema.id=show2.cinema_id where show2.movie_id=$id ");
                                while ($city_res = mysqli_fetch_assoc($city_sql)) {
                                    echo "<option value=" . $city_res['city'] . ">" . $city_res['city'] . " </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select class="form-select" id="branches" aria-label="Default select example">
                                <option value="" disabled selected>Select Branch</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary find-btn" onclick="fetchSeat()">OK</button>
                        </div>
                    </div>

                    <div class="toggle-btn">
                        <i class="bx bx-x"></i>
                    </div>
                </div>
                <script>
                    const toggleBtn = document.querySelector(".toggle-btn");
                    const findContent = document.querySelector(".find-content");
                    const findBtn = document.querySelector(".find-btn");
                    findBtn.addEventListener("click", () => {
                        const icon = toggleBtn.querySelector(".bx");
                        icon.classList.toggle("bx-plus");
                        icon.classList.toggle("bx-x");
                        document.querySelector(".find-content").style.visibility =
                            icon.classList.contains("bx-x") ? "visible" : "hidden";
                    });

                    toggleBtn.addEventListener("click", () => {
                        const icon = toggleBtn.querySelector(".bx");
                        icon.classList.toggle("bx-plus");
                        icon.classList.toggle("bx-x");
                        document.querySelector(".find-content").style.visibility =
                            icon.classList.contains("bx-x") ? "visible" : "hidden";
                    });

                    function onDrag({
                        movementX
                    }) {
                        // Get the current styles of the nav element
                        const navStyle = window.getComputedStyle(toggleBtn),
                            navLeft = parseInt(navStyle.left), // Get nav left value (in pixels)
                            navHeight = parseInt(navStyle.height), // Get nav height value (in pixels)
                            navWidth = parseInt(navStyle.width), // Get nav width value (in pixels)
                            windWidth = window.innerWidth; // Get window width

                        toggleBtn.style.left =
                            navLeft + movementX > 0 ? `${navLeft + movementX}px` : "0px";
                        if (navLeft + movementX > windWidth - navWidth) {
                            toggleBtn.style.left = `${windWidth - navWidth}px`;
                        }

                        let newLeft = navLeft + movementX;
                        newLeft = Math.max(0, Math.min(newLeft, windWidth - navWidth));

                        findContent.style.left = `${newLeft + 10}px`;
                    }

                    let isDragging = false;

                    toggleBtn.addEventListener("mousedown", () => {
                        isDragging = true;
                    });

                    document.addEventListener("mousemove", (e) => {
                        if (isDragging) {
                            onDrag(e);
                        }
                    });

                    document.addEventListener("mouseup", () => {
                        isDragging = false;
                    });
                </script>
                <script>
                    function fetchShowtimes() {
                        var city = document.getElementById("citys").value;
                        // Make sure the cityId is valid before making the request
                        if (city) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "get_showtimes.php", true);
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                            // When the request completes, update the second select box
                            xhr.onload = function() {
                                if (this.status == 200) {
                                    document.getElementById("branches").innerHTML = this.responseText;
                                }
                            };

                            // Send the request with the selected city ID
                            xhr.send("city=" + city);
                        }
                    }
                </script>
                <script>
                    function fetchSeat(seat_id_list) {
                        var city = document.getElementById("citys").value;
                        var branch = document.getElementById("branches").value;
                        var movieId = document.getElementById("movieid").value;

                        // Make sure the values are valid before making the request
                        if (city && branch && movieId) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "get_showseat.php", true);
                            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                            // When the request completes, update the second select box
                            xhr.onload = function() {
                                if (this.status == 200) {
                                    document.getElementById("seat").innerHTML = this.responseText;
                                }
                            };

                            // Send the request with the selected values
                            xhr.send("city=" + city + "&branch=" + branch + "&movie_id=" + movieId + "&seat_id_list=" + JSON.stringify(seat_id_list));
                        }
                    }
                </script>

                <div class="seat-body" id="seat">

                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var movieid = document.getElementById("movieid").value;
        var ratedIndex = -1;
        uID = localStorage.setItem('uID', getDeviceId());
        emoji = getSelectedValue();


        function getDeviceId() {
            // Check if an ID already exists
            let deviceId = localStorage.getItem('device_id');

            // If not, create one and store it
            if (!deviceId) {
                deviceId = 'device-' + Math.random().toString(36).substr(2, 16);
                localStorage.setItem('device_id', deviceId);

            }
            return deviceId;
        }



        $(document).ready(function() {
            var ratedIndex = -1; // Initialize ratedIndex
            var uID = getDeviceId(); // Ensure device ID is fetched correctly
            var movieid = document.getElementById("movieid").value; // Get movieid
            var emoji = getSelectedValue(); // Fetch emoji value

            resetStarColors();

            $.ajax({
                url: "../Model/ratedb.php",
                method: "POST",
                dataType: 'json',
                data: {
                    uID: uID,
                    movieid: movieid
                },
                success: function(rate) {
                    setStars(rate);
                    localStorage.setItem('ratedIndex', rate);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error:', error);
                }
            });
            //for emoji
            $.ajax({
                url: "../Model/feelingdb.php",
                method: "POST",
                dataType: 'json',
                data: {
                    uID: uID,
                    movieid: movieid
                },
                success: function(emoji) {
                    checkEmojiOption(emoji);

                },
                error: function(xhr, status, error) {
                    console.log('AJAX error:', error);
                }
            });

            //emoji function
            function checkEmojiOption(emoji) {
                // Get the checkbox for the corresponding emoji
                var emojiCheckbox = document.querySelector(`input[type="radio"][value="${emoji}"]`);
                if (emojiCheckbox) {
                    emojiCheckbox.checked = true;
                }
            }

            // Handle star click
            $('.fa-star').on('click', function() {
                ratedIndex = parseInt($(this).data('index'));
                localStorage.setItem('ratedIndex', ratedIndex);
            });

            // Handle mouseover event
            $('.fa-star').mouseover(function() {
                resetStarColors();
                let currentIndex = parseInt($(this).data('index'));
                setStars(currentIndex);
            });

            // Handle mouseleave event
            $('.fa-star').mouseleave(function() {
                resetStarColors();
                if (ratedIndex !== -1) {
                    setStars(ratedIndex);
                }
            });

            // Handle submit click
            $('.submit').on('click', function(e) {
                event.preventDefault();
                localStorage.setItem('ratedIndex', ratedIndex);
                saveToTheDB();
            });
        });

        function getDeviceId() {
            let deviceId = localStorage.getItem('device_id');
            if (!deviceId) {
                deviceId = 'device-' + Math.random().toString(36).substr(2, 16);
                localStorage.setItem('device_id', deviceId);
            }
            return deviceId;
        }

        function getSelectedValue() {
            const selected = document.querySelector('input[name="group1"]:checked');
            return selected ? selected.value : "no option selected";
        }

        function saveToTheDB() {
            var movieid = document.getElementById("movieid").value;
            var emoji = getSelectedValue();
            var uID = localStorage.getItem('uID');
            var ratedIndex = localStorage.getItem('ratedIndex');

            $.ajax({
                url: "../Model/savedb.php",
                method: "POST",
                dataType: 'json',
                data: {
                    save: 1,
                    uID: uID,
                    movieid: movieid,
                    rate: ratedIndex,
                    emoji: emoji
                },
                success: function(r) {
                    if (r.success) {
                        alert('Rating saved successfully.');
                        // localStorage.setItem('uID', r.id); // You can uncomment if needed
                    } else {
                        console.log('Error:', r.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error:', error);
                }
            });

        }

        function setStars(max) {
            for (var i = 0; i <= max; i++) {
                $('.fa-star:eq(' + i + ')').css('color', 'gold');
            }
        }

        function resetStarColors() {
            $('.fa-star').css('color', 'white');
        }

        var detailDiv = document.getElementById("for_detail");
        var ratingDiv = document.getElementById("for_rating");
        var seatDiv = document.getElementById("for_seat");
        var detailBtn = document.getElementById("detail_btn"); // Fixed spelling
        var ratingBtn = document.getElementById("rating_btn");
        var seatBtn = document.getElementById("seat_btn");

        // Click event for Details button
        detailBtn.addEventListener("click", function() {
            detailBtn.classList.add('active-btn');
            ratingBtn.classList.remove('active-btn');
            seatBtn.classList.remove('active-btn');
            detailDiv.style.display = "block";
            ratingDiv.style.display = "none";
            seatDiv.style.display = "none";
        });

        // Click event for Rating button
        ratingBtn.addEventListener("click", function() {
            ratingBtn.classList.add('active-btn');
            detailBtn.classList.remove('active-btn');
            seatBtn.classList.remove('active-btn');
            detailDiv.style.display = "none";
            ratingDiv.style.display = "block";
            seatDiv.style.display = "none";

        });

        //for seat btn
        seatBtn.addEventListener("click", function() {
            ratingBtn.classList.remove('active-btn');
            detailBtn.classList.remove('active-btn');
            seatBtn.classList.add('active-btn');
            detailDiv.style.display = "none";
            ratingDiv.style.display = "none";
            seatDiv.style.display = "block";
        });

        const seat_id_list = [];

        function changeBgColorAndGetData(element) {
            let flag = false;
            const seat_id = element.querySelector('span').textContent;
            seat_id_list.forEach(id => {
                if (id == seat_id) {
                    flag = true;

                }
            });
            if (flag) {
                element.style.backgroundColor = "#dedede";
                element.style.color = 'black';
                // Find the index of the seat with a specific condition (e.g., 'vacant' status)
                let index = seat_id_list.indexOf(seat_id);
                if (index !== -1) {
                    seat_id_list.splice(index, 1);
                }


            } else {
                element.style.backgroundColor = 'green';
                element.style.color = 'white';
                seat_id_list.push(seat_id);
            }
            fetchedSeat(seat_id_list);

            document.querySelector("#poster_image").style.display = seat_id_list.length > 0 ? 'none' : 'block';
            document.querySelector("#buy_cart").style.display = seat_id_list.length > 0 ? 'block' : 'none';

            // console.log(seat_id_list);
        }

        function removeSeat(element) {
            const seat_id = element.querySelector('p').textContent;
            let index = seat_id_list.indexOf(seat_id);
            if (index !== -1) {
                seat_id_list.splice(index, 1);
            }

            fetchedSeat(seat_id_list);

            document.querySelector("#poster_image").style.display = seat_id_list.length > 0 ? 'none' : 'block';
            document.querySelector("#buy_cart").style.display = seat_id_list.length > 0 ? 'block' : 'none';

            fetchSeat(seat_id_list);
        }

        function fetchedSeat(seat_id_list) {
            if (seat_id_list) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "get_buylist.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                // When the request completes, update the second select box
                xhr.onload = function() {
                    if (this.status == 200) {
                        document.getElementById("buy_list").innerHTML = this.responseText;
                    }
                };

                // Send the request with the selected city ID
                xhr.send("seat_id_list=" + JSON.stringify(seat_id_list));
            }
        }
    </script>

</body>

</html>