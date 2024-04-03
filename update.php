
<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$event_name = $decoration_items= $charges = "";
$event_err = $decoration_items_err = $charges_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate name
 // Validate event name
 $input_event_name = trim($_POST["event_name"]);
 if (empty($input_event_name)) {
     $event_name_err = "Please enter an event name.";
 }  else {
     $event_name= $input_event_name;
 }

 // Validate decoration items
 $input_decoration_items = trim($_POST["decoration_items"]);
 if (empty($input_decoration_items)) {
     $decoration_items_err = "Please enter an address.";
 } else {
     $decoration_items= $input_decoration_items;
 }

 // Validate charges
 $input_charges = trim($_POST["charges"]);
 if (empty($input_charges)) {
     $charges_err = "Please enter the charges amount.";
 } elseif (!ctype_digit($input_charges)) {
     $charges_err = "Please enter a positive integer value.";
 } else {
     $charges= $input_charges;
 }

    // Check input errors before inserting in database
    if (empty($event_name_err) && empty($decoration_items_err) && empty($charges_err)) {
        // Prepare an update statement
        $sql = "UPDATE events SET event_name=?, decoration_items=?, charges=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_event_name, $param_decoration_items, $param_charges, $param_id);

            // Set parameters
            $param_event_name = $event_name;
            $param_decoration_items = $decoration_items;
            $param_charges= $charges;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                header("location: events.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM events WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $event_name = $row["event_name"];
                    $decoration_items = $row["decoration_items"];
                    $charges = $row["charges"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the event details.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="event_name" class="form-control <?php echo (!empty($event_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_name; ?>">
                            <span class="invalid-feedback"><?php echo $event_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>decoration_items</label>
                            <input type="text" name="decoration_items" class="form-control <?php echo (!empty($decoration_items_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $decoration_items; ?>">
                            <span class="invalid-feedback"><?php echo $decoration_items_err; ?></span>
                            
                        </div>
                        <div class="form-group">
                            <label>Charges</label>
                            <input type="text" name="charges" class="form-control <?php echo (!empty($charges_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $charges; ?>">
                            <span class="invalid-feedback"><?php echo $charges_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="events.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
