<!--Simranjeet Singh 202105468 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <title>events</title>


</head>
<body>
    <header>
        <ol>
            <li> <a href="index.html">Home</a> </li>
            <li> <a href="events.php">events</a> </li>
        <li> <a href="registration.html">Registration</a> </li>
        <li> <a href="about.html">about</a> </li>


        </ol>
            </header>
    <main>
    <h1> Our events</h1>
    <hr>
    <p class="concert">Our events are meticulously crafted experiences that bring together individuals 
        from diverse backgrounds to celebrate, learn, and connect. From intimate gatherings to
         large-scale conferences, each event is thoughtfully curated to inspire and engage attendees.
          We strive to create immersive environments where ideas flourish, relationships are forged,
           and memories are made. Whether it's a corporate summit, a cultural festival, or a community
            fundraiser, our events reflect a commitment to excellence in planning, execution, and
             participant satisfaction. Through innovative programming, top-notch logistics, and a 
             focus on attendee experience, we aim to exceed expectations and leave a lasting impression
              on all who participate. Join us as we embark on a journey of exploration, discovery, and
               celebration at our next unforgettable event.</p>
             <hr>
        
            <section>
<img src="https://media.istockphoto.com/id/1319479588/photo/the-musicians-were-playing-rock-music-on-stage-there-was-an-audience-full-of-people-watching.jpg?s=612x612&w=0&k=20&c=OrGoVzFYygF904aMkM38N_v53yyBI5D_aWkpZZhTvEY=">
<img src="https://media.istockphoto.com/id/1330424071/photo/large-group-of-people-at-a-concert-party.jpg?s=612x612&w=0&k=20&c=LwdiOCBqbfICjQ3j5AzwyugxmfkbyfL3StKEQhtx4hE=">

</section> 

<h4> Here is information of the events that we organised and we have a fix charges over them. Besides this,
     we provide decoraton items as listed below according to the events.</h4>
    <p><b> Register your details on our registration page
    to get information for the events listed below </b></p>
    <h5 class="pull-left">event details</h5>

    </main> <br><br>
    <div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <?php
                // Include config file
                require_once "config.php";

                // Attempt select query execution
                $sql = "SELECT * FROM events";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>event_name</th>";
                        echo "<th>decoration_items</th>";
                        echo "<th>charges</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['event_name'] . "</td>";
                            echo "<td>" . $row['decoration_items'] . "</td>";
                            echo "<td>" . $row['charges'] . "</td>";
                            echo "<td>";
                            echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close connection
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</div>
<a href="create.php" class="btn btn-info"><i class="fa fa-plus"></i> Add New event</a>

            <!--Pawandeep kaur ID 202106637-->

</body>
</html>