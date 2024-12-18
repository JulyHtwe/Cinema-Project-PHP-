<?php
include("../Model/db.php");

if (isset($_POST['submit'])) {
    $search_input = mysqli_real_escape_string($connection, $_POST['search_input']);
    // Make sure the search query is only run if there's input

    if (!empty($search_input)) {
        $sql = mysqli_query($connection, "SELECT id,title FROM movie WHERE title LIKE '%$search_input%'");
        $flag = true;
    } else {
        $flag = false;
    }
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/header.css">
    <style>
        body {
            background: linear-gradient(120deg, #f8f9fa, #e9ecef, #dee2e6);
            overflow-x: hidden;

        }

        html {
            overflow-x: hidden;
        }

        .row {
            display: flex;

        }

        .row .content:first-child {
            width: 20%;
        }

        .row .content:last-child {
            width: 80%;
        }

        .content .logo {
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .content .logo img {
            width: 130px;
            height: 130px;
            margin: auto;
        }

        .content:last-child {
            overflow-x: hidden;
            overflow-y: auto;
            width: 100%;
            height: 100vh;
        }

        #search_input {
            width: 500px;
            color: black;

        }

        #search_input,
        #search_id,
        .cancel {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
            height: 45px;
            border-radius: 15px;
            margin-top: 20px;
            margin-bottom: 20px;

        }

        #search_id,
        .cancel {
            width: 100px;
            margin-left: 10px;
        }

        .cancel {
            margin-left: 20px;
            background-color: black;
            color: white;
        }

        #search_id {
            width: 100px;
        }

        #search_id:hover {
            background-color: #e2e2e2;

        }

        .search_container {

            background-color: #e2e2e2;
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .search-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
            margin-bottom: 10px;
        }

        /* Styling the list items */
        .search-list-item {
            text-decoration: none;
            width: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px 20px;
            margin-top: 20px;
            margin-left: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            font-size: 18px;
            color: #333;
            transition: background-color 0.3s ease;
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Hover effect */
        .search-list-item:hover {
            background-color: #e2e2e2;
        }


        .home-content .weekly_movie,
        .home-content .hot_movie {
            margin-top: 20px;
        }

        .carousel,
        .carousel-inner,
        .carousel-item active {
            width: 100%;
            height: 100%;
            border-radius: 15px;

        }

        .carousel {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
        }

        .carousel-inner img {
            border-radius: 15px;
            width: 100%;
            height: 300px;

        }

        .tit {
            /* padding-left: 5%; */
            font-size: 25px;
            font-weight: bold;
            color: black;
            margin-bottom: 10px;
        }

        .flex_use {
            margin-top: 20px;
            display: flex;
            flex-direction: row;
            gap: 50px;

        }

        .sub_weekly_movie,
        .sub_hot_movie {
            width: 220px;
            height: 300px;
            border-radius: 12px;
            margin-bottom: 20px;
            /* Optional: Adds some space between each div */
            background: linear-gradient(to bottom right, #0d1b2a, #1b263b);
        }

        .sub_weekly_movie img,
        .sub_hot_movie img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
        }

        .ticket {
            width: 100%;
            overflow-x: scroll;
            overflow-y: hidden;
            margin-left: 50px;
        }

        .ticket_content {
            display: flex;
            flex-direction: row;
            justify-content: left;
            align-items: flex-start;
            gap: 3rem;

            width: 100vw;
        }

        .ticket_content .ticket_item {
            background: white;
            border: 1px solid rgba(222, 226, 230, 0.5);
            border-radius: 12px;
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            width: 50vh;
            margin-bottom: 20px;
            padding: 50px 15px;
            /* Width of each ticket item */
        }

        .ticket_content .ticket_item .ticket_header1 h4 span {
            display: inline-block;
            width: 60px;
        }

        .ticket_content .ticket_item .ticket_header2 {
            text-align: right;

        }

        .ticket_content .ticket_item .ticket_header2 h5 span {
            display: inline-block;
            width: 100px;
            text-align: left;

        }

        .ticket_content .ticket_item .ticket_footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ticket_content .ticket_item table tr td:nth-child(2),
        .ticket_content .ticket_item table tr td:nth-child(3),
        .ticket_content .ticket_item table tr th:nth-child(2),
        .ticket_content .ticket_item table tr th:nth-child(3)
        {
            text-align: right;
        }


        .about {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px;
            gap: 50px;
            max-width: 100%;

        }

        .about-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 20px;
            background: white;
            border: 1px solid rgba(222, 226, 230, 0.5);
            border-radius: 12px;
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            width: 100%;
            padding: 20px;

        }

        /* For larger screens, display side by side */
        @media(min-width: 768px) {
            .about-section {
                flex-direction: row;
                text-align: left;
            }
        }

        .about-image {
            border-radius: 50%;
            width: 200px;
            height: 200px;
            object-fit: cover;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.1);
        }

        .about-content {
            max-width: 500px;
        }

        .about-content .about-title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: black;
        }

        .about-content .about-paragraph {
            font-size: 1rem;
            line-height: 1.6;
            color: black;
        }

        .menu li i {
            font-size: 20px;
            font-weight: bold;
        }

        header ul a {
            color: black;
            font-size: 20px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="row">
        <div class="content">
            <header>
                <div class="logo">
                    <p>MINGALA</p>
                    <img src="../Photo/logo.png" alt="">
                </div>
                <ul class="menu" id="nav">
                    <a href="#home">
                        <li class="active"><i class='bx bxs-home'></i>Home</li>
                    </a>
                    <a href="#ticket">
                        <li><i class='bx bx-credit-card-alt'></i>Ticket</li>
                    </a>
                    <a href="#about">
                        <li><i class='bx bx-group'></i>About</li>
                    </a>

                </ul>
            </header>
        </div>
        <div class="content">

            <section class="home" id="home">
                <div class="search_box" style="padding-left: 50px;">
                    <form class="d-flex" role="search" method="POST">
                        <input id="search_input" class="form-control me-2" type="search" placeholder="Search"
                            aria-label="Search" name="search_input" id="search_input">
                        <button id="search_id" type="submit" name="submit">Search</button>
                        <button class="btn-danger cancel"
                            style="display: <?php echo isset($_POST['submit']) && !empty($search_input) ? 'block' : 'none'; ?>">Cancel</button>
                    </form>

                    <div class="search_container"
                        style="display: <?php echo isset($_POST['submit']) && !empty($search_input) ? 'block' : 'none'; ?>"
                        ;>
                        <?php
                        if ($flag) {

                            if (mysqli_num_rows($sql) > 0) {
                                // Fetch results as an associative array
                                $search_res = mysqli_fetch_all($sql, MYSQLI_ASSOC);

                                echo "<ul class='search-list'>";
                                foreach ($search_res as $row) {
                                    echo "<li>" . "<a href='detail.php?id=" . $row['id'] . "' class='search-list-item'>" . $row["title"] . "</a></li>";
                                }
                                echo "</ul>";
                            } else {
                                echo "No results found.";
                            }
                        }


                        ?>

                    </div>

                </div>
                <div class="home-content" style="padding-left: 50px;">
                    <div class="first_div" style="width:100%;">

                        <div class="carousel">
                            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $sql = mysqli_query($connection, "SELECT * FROM movie");
                                    $isFirst = true;

                                    // Loop through the result set
                                    while ($row = mysqli_fetch_assoc($sql)) {

                                        $base64_image = $row['image'];  // Make sure your table has an 'image' column
                                        $image_data = 'data:image/jpeg;base64,' . $base64_image;
                                        $activeClass = $isFirst ? 'active' : '';
                                        $isFirst = false;
                                    ?>
                                        <div class="carousel-item active">
                                            <img src="<?php echo $image_data ?>" class="d-block w-100" alt="...">
                                        </div>
                                    <?php } ?>

                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="second_div" style="width:100%;">
                        <div class="weekly_movie">
                            <h2 class="tit">တစ်ပတ်အတွင်းပြသမည့် ဇာတ်ကားများ</h2>
                            <div class="flex_use" style="overflow-x:auto;">
                                <?php
                                //Weekly Movie (date and time)
                                $today = date('Y-m-d');
                                // $end_dates = [];
                                // $modify_dates = [];
                                $week_dates = [];

                                $date = mysqli_query($connection, "select end_date from show2");
                                while ($row = mysqli_fetch_assoc($date)) {
                                    $end_date = new DateTime($row['end_date']);
                                    $modify_date = clone new DateTime($today); //no value ,use clone
                                    $modify_date->modify('+7 days');

                                    if (new DateTime($today) < $end_date && $end_date < $modify_date) {
                                        $week_dates[] = $end_date->format('Y-m-d');
                                    }
                                    // $end_dates[]=$end_date->format('Y-m-d');
                                    // $modify_dates[]=$modify_date->format('Y-m-d');
                                }

                                if (!empty($week_dates)) {
                                    $week_dates_str = "'" . implode("','", $week_dates) . "'"; //cpnvert to
                                    $sql = mysqli_query($connection, "
                        SELECT * 
                        FROM movie JOIN show2 
                        ON movie.id = show2.id 
                        WHERE show2.end_date IN ($week_dates_str) ;
                    ");

                                    // Fetch and print the results
                                    while ($res = mysqli_fetch_assoc($sql)) {
                                        $id = $res['id'];
                                        $base64_image = $res['image'];  // Make sure your table has an 'image' column
                                        $image_data = 'data:image/jpeg;base64,' . $base64_image;
                                        echo "
                                    <div class='sub_weekly_movie'>
                                    <a href='detail.php?id={$id}'><img src='$image_data' alt=''></a> 
                                    </div>
                        ";
                                    }
                                } else {
                                    echo "No movie dates found for the current week.";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="hot_movie">
                            <h2 class="tit">လူကြိုက်များသည့် ဇာတ်ကားများ</h2>
                            <div class="flex_use">
                                <?php
                                $sql = mysqli_query($connection, "
                    SELECT 
                    movie.id,movie.image,
                    sum(buyseat.price) as total_price
                        FROM movie 
                        JOIN show2 on movie.id=show2.movie_id
                        JOIN buyseat on show2.id=buyseat.show_id
                        group by movie.id
                        order by total_price desc; 
                    ");

                                while ($res = mysqli_fetch_assoc($sql)) {
                                    $id = $res['id'];
                                    $base64_image = $res['image'];  // Make sure your table has an 'image' column
                                    $image_data = 'data:image/jpeg;base64,' . $base64_image;
                                    echo "
                            <div class='sub_hot_movie'>
                            <a href='detail.php?id={$id}'><img src='$image_data' alt=''></a> 
                            </div>
                ";
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
            

            <section id="ticket" class="ticket">
                <h2 class="tit">Tickets</h2>
                <div class="ticket_content" id="ticket_content">

                    <div class="image_holder_content" style="display:none;">
                        <div role="status" class="space-y-8 animate-pulse md:space-y-0 md:space-x-8 rtl:space-x-reverse md:flex md:items-center">
                            <div class="flex items-center justify-center w-full h-48 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
                                <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                    <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    

            </section>
            <script>
                fetch_ticket();

                function getDeviceId() {
                    let deviceId = localStorage.getItem('device_id');
                    if (!deviceId) {
                        deviceId = 'device-' + Math.random().toString(36).substr(2, 16);
                        localStorage.setItem('device_id', deviceId);

                    }
                    return deviceId;
                }

                function fetch_ticket() {
                    var uID = getDeviceId();
                    // Make sure the values are valid before making the request
                    if (uID) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "get_ticket.php", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                        // When the request completes, update the second select box
                        xhr.onload = function() {
                            if (this.status == 200) {
                                document.getElementById("ticket_content").innerHTML = this.responseText;
                            }
                        };

                        // Send the request with the selected values
                        xhr.send("uID=" + uID);
                    }
                }
            </script>
            <section class="about" id="about" style="padding-left: 50px;">

                <div class="about-section">
                    <img src="../Photo/daung.jfif" alt="Team member 1" class="about-image">
                    <div class="about-content">
                        <h2 class="about-title">Back-end Developer</h2>
                        <p class="about-paragraph">
                            Our company strives to innovate and inspire. We believe in the power of technology and
                            creativity
                            coming together to solve today’s challenges and shape tomorrow’s possibilities. We envision
                            a world
                            where innovation drives sustainable progress.
                        </p>
                    </div>
                </div>

                <!-- Section 2 -->
                <div class="about-section">
                    <img src="../Photo/july.jpg" alt="Team member 2" class="about-image">
                    <div class="about-content">
                        <h2 class="about-title">Front-end Deveolper</h2>
                        <p class="about-paragraph">
                            We are dedicated to delivering high-quality products and services that empower people and
                            businesses.
                            Our mission is to transform ideas into reality through cutting-edge solutions, driven by a
                            team of passionate
                            professionals who are committed to excellence.
                        </p>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz'
        crossorigin='anonymous'></script>

    <script>
        // Select all <li> elements
        const menuItems = document.querySelectorAll('#nav li');

        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(li => li.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>

</body>

</html>
