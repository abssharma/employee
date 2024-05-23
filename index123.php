<!DOCTYPE html>
<html>
<head>
    <title>Employee Training Session Mapping</title>
    <style>
        /* Your CSS styles go here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        /* Other CSS styles for forms, buttons, etc. */
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .form-container, .result, .links {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], input[type="date"], select, button {
            width: calc(100% - 22px);
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: auto;
            background-color: #5CDB95;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }
        button:hover {
            background-color: #379683;
        }
        .links a {
            text-decoration: none;
            color: #333;
            background-color: #ddd;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
            margin-right: 10px;
        }
        .links a:hover {
            background-color: #ccc;
        }
        .clear { clear: both; }
    </style>
</head>
<body>
    <h1>Employee Training Session Mapping</h1>
    <?php
    $connection = pg_connect("host=localhost dbname=postgres user=postgres password=postgredb");

    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }
    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        // Convert undefined array key warning into an exception
        if (strpos($errstr, 'Undefined array key') !== false) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        } else {
            // Handle other errors or warnings
            echo "Error: $errstr\n";
        }
    }
    
    // Set the custom error handler
    set_error_handler("customErrorHandler");
    ?>
    <!-- Employee Management -->
    <div class="form-container">
    <h2>Employee Management</h2>
    <form id="employeeForm" method="POST">
        <!--<select name="operation" required>
            <option value="">Select Operation</option>
            <option value="add">Add New</option>
            <option value="update">Update</option>
        </select> -->
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="preferred_name" placeholder="Preferred Name">
        <input type="text" name="role_name" placeholder="Role Name" required>
        <input type="number" name="experience" placeholder="Experience" required>
        <input type="text" name="country_name" placeholder="Country Name" required>
        <input type="text" name="employeeId" placeholder="Employee ID (-1 To add new Employee)">
        <button type="submit">Submit</button> 
    </form>
</div>
    <?php
    try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Access form data using $_POST
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $preferred_name = $_POST["preferred_name"];   
        $role_name = $_POST["role_name"];  
        $experience = $_POST["experience"];  
        $country_name = $_POST["country_name"];  
        $employeeId = $_POST["employeeId"];
        $result = pg_query_params($connection, 'CALL public.add_employee($1, $2, $3, $4, $5, $6, $7)', array($first_name, $last_name,$preferred_name, $role_name,$experience, $country_name, $employeeId)) or die('Unable to CALL stored procedure: ' . pg_last_error());;
        }}
    catch (ErrorException $e) {
            // Catch the exception (converted from the warning)
        
        }

    
?>
    <div id="employeeResult" class="result"></div>


    <!-- Training Session Management -->
    <div class="form-container">
    <h2>Training Session Assignment</h2>
    <form id="trainingSessionForm" method="POST">
        <!--<select name="operation" required>
            <option value="">Select Operation</option>
            <option value="add">Add New</option>
            <option value="update">Update</option>
        </select>-->
        <input type="number" name="employee_Id" placeholder="Employee Id" >
        <input type="text" name="sessionName" placeholder="Session Name"  required>
        <input type="text" name="Comments" placeholder="Comments" >
        <button type="submit">Submit</button>
    </form>
    </div>
    <?php
    try{
    if (($_SERVER["REQUEST_METHOD"] == "POST")) {
        // Access form data using $_POST
        $employee_Id = $_POST["employee_Id"];
        $sessionName = $_POST["sessionName"];
        $Comments = $_POST["Comments"];   
        $result = pg_query_params($connection, 'CALL public.upsert_employee_training($1, $2, $3)', array($employee_Id, $sessionName,$Comments)) or die('Unable to CALL stored procedure: ' . pg_last_error());;
        }}
    catch (ErrorException $e) {
        // Catch the exception (converted from the warning)
        //echo "Hello" . "\n";
    }
?>
    <div id="trainingSessionResult" class="result">

    </div>

    <!-- Role Management -->
    <div class="form-container">
    <h2>Role Management</h2>
    <form id="roleForm" method="POST">
        <!--<select name="operation" required>
            <option value="">Select Operation</option>
            <option value="add">Add New</option>
            <option value="update">Update</option>
        </select>-->
        <input type="text" name="roleId" placeholder="Role ID (-1 to Add New Role)">
        <input type="text" name="roleName" placeholder="Role Name" required>
        <input type="text" name="DepartmentName" placeholder="Department Name" required>
        <input type="text" name="roleDescription" placeholder="Role Description">
        <button type="submit">Submit</button>
    </form>
</div>
    <?php
    try{
        if (($_SERVER["REQUEST_METHOD"] == "POST")) {
            // Access form data using $_POST
            $roleId = $_POST["roleId"];
            $roleName = $_POST["roleName"];
            $DepartmentName = $_POST["DepartmentName"];
            $roleDescription = $_POST["roleDescription"];   
            $result = pg_query_params($connection, 'CALL public.upsert_roles($1, $2, $3, $4)', array($roleName, $DepartmentName,$roleDescription, $roleId)) or die('Unable to CALL stored procedure: ' . pg_last_error());;
        }
    }
    catch (ErrorException $e) {
        // Catch the exception (converted from the warning)
        //echo "Hello" . "\n";
    }
    ?>
    <div id="roleResult" class="result"></div>

    <!-- Country/Region Management -->
    <div class="form-container">
    <h2>Country/Region Management</h2>
    <form id="countryForm" method="POST">
        <!--<select name="operation" required>
            <option value="">Select Operation</option>
            <option value="add">Add New</option>
            <option value="update">Update</option>
        </select>-->
        <input type="text" name="countryId" placeholder="Country Id (-1 to Insert)">
        <input type="text" name="countryName" placeholder="Country Name" required>
        <input type="text" name="region" placeholder="Region">
        <input type="text" name="countryComments" placeholder="Country Comments">
        <button type="submit">Submit</button>
    </form>
</div>
    <?php
    try{
        if (($_SERVER["REQUEST_METHOD"] == "POST")) {
            // Access form data using $_POST
            $countryId = $_POST["countryId"];
            $countryName = $_POST["countryName"];
            $region = $_POST["region"];
            $countryComments = $_POST["countryComments"];   
            $result = pg_query_params($connection, 'CALL public.upsert_country($1, $2, $3, $4)', array($countryName, $region,$countryComments, $countryId)) or die('Unable to CALL stored procedure: ' . pg_last_error());;
            }}
        catch (ErrorException $e) {
            // Catch the exception (converted from the warning)
            //echo "Hello" . "\n";
        }
    ?>
    <div id="countryResult" class="result"></div>
    <div class="form-container">
    <h2>Training Sessions Management</h2>
    <form id="countryForm" method="POST">
        <!--<select name="operation" required>
            <option value="">Select Operation</option>
            <option value="add">Add New</option>
            <option value="update">Update</option>
        </select>-->
        <input type="text" name="sessionName" placeholder="Session Name">
        <input type="number" name="trainerId" placeholder="Trainer Id" required>
        <input type="number" name="min_experience" placeholder="Minimum Experience" required>
        <label>Session Start Date:</label>
        <input type="date" name="sessionStart" placeholder="Session Start Date">
        <label>Session End Date:</label>
        <input type="date" name="sessionEnd" placeholder="Session End Date">
        <input type="number" name="sessionCapacity" placeholder="Session Capacity" required>
        <input type="text" name="countryName" placeholder="Country Name">
        <input type="number" name="sessionId" placeholder="Session Id" required>
        <button type="submit">Submit</button>
    </form>
    </div>
    <?php
        try{
            if (($_SERVER["REQUEST_METHOD"] == "POST")) {
                // Access form data using $_POST
                $sessionName = $_POST["sessionName"];
                $trainerId = $_POST["trainerId"];
                $min_experience = $_POST["min_experience"];
                $sessionStart = $_POST["sessionStart"];   
                $sessionEnd = $_POST["sessionEnd"]; 
                $sessionCapacity = $_POST["sessionCapacity"];  
                $countryName = $_POST["countryName"];  
                $sessionId = $_POST["sessionId"];  
                $result = pg_query_params($connection, 'CALL public.upsert_training_session($1, $2, $3, $4 , $5, $6, $7, $8)', array($sessionName, $trainerId,$min_experience, $sessionStart, $sessionEnd, $sessionCapacity, $countryName, $sessionId)) or die('Unable to CALL stored procedure: ' . pg_last_error());;
                }}
            catch (ErrorException $e) {
                // Catch the exception (converted from the warning)
                //echo "Hello" . "\n";
            }
    ?>
    <div id="countryResult" class="result"></div>
    
    <div class="links">
    <a href="http://localhost/emp_select.php/">Employee Details</a>
    <a href="http://localhost/train_select.php/">Training Session Details</a>
    <a href="http://localhost/Country_select.php/">Country Details</a>
    <a href="http://localhost/Region_select.php/">Region Details</a>
    <a href="http://localhost/emptrain_select.php/">Employee Training Sessios Mapping</a>
    <a href="http://localhost/role_details.php/">Role Details</a>
    </div>
    <script src="script.js"></script>
</body>
</html>
