<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = " ";
    $dbname = "management";

    // Create connection
    $conn = mysqli_connect('localhost', 'root', '', 'management');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

        // Get form data
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $number = $_POST["number"];
        $gender = $_POST["gender"];

        // SQL query to insert form data into table
        $sql = "INSERT INTO info (fullname, email, number, gender) VALUES ('$fullname', '$email', '$number', '$gender')";

        if (mysqli_query($conn, $sql)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close connection
        mysqli_close($conn);
}
?>



