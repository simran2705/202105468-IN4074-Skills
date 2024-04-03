
<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$event_name = $decoration_items= $charges = "";
$event_err = $decoration_items_err = $charges_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        // Prepare an insert statement
        $sql = "INSERT INTO events (event_name, decoration_items , charges) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_event_name, $param_decoration_items, $param_charges);

            // Set parameters
            $param_event_name = $event_name;
            $param_decoration_items = $decoration_items;
            $param_charges = $charges;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add new event information to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Event name here:</label>
                            <input type="text" name="event_name" class="form-control <?php echo (!empty($event_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $event_name; ?>">
                            <span class="invalid-feedback"><?php echo $event_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Decoration items provided:</label>
                            <input type="text" name="decoration_items" class="form-control <?php echo (!empty($decoration_items_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $decoration_items; ?>">
                            <span class="invalid-feedback"><?php echo $decoration_items_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Charges on the event</label>
                            <input type="text" name="charges" class="form-control <?php echo (!empty($charges_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $charges; ?>">
                            <span class="invalid-feedback"><?php echo $charges_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="events.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
