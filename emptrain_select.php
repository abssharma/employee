<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Your CSS styles go here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #5CDB95;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }
        a:hover {
            background-color: #379683;
        }
    </style>
</head>
<body>
    <h2>Employee Training Session Mapping</h2>
    <?php
    $connection = pg_connect("host=localhost dbname=postgres user=postgres password=postgredb");

    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }?>

<table>
        <tr>
            <th>Mapping ID</th>
            <th>Employee First Name</th>
            <th>Employee Last Name</th>
            <th>Training Session Name</th>
            <th>Training Session Comments</th>
            </tr>

        <?php
        $result_emp=pg_query($connection, "SELECT et.et_id,ee.e_firstname,ee.e_lastname,ts.ts_name,et.et_comments FROM public.employeetraining AS et JOIN public.employee AS ee ON et.et_employeeid=ee.e_employeeid JOIN public.trainingsession AS ts ON ts.ts_sessionid=et.et_sessionid");
        while($row = pg_fetch_assoc($result_emp)) {
        echo"
        <tr>
        <td>$row[et_id] </td>
        <td>$row[e_firstname]</td>
        <td>$row[e_lastname]</td>
        <td>$row[ts_name]</td>
        <td>$row[et_comments]</td>
        </tr>
        ";
        }
        ?>
    </table>
 <a href="http://localhost/index123.php/"> Go Back </a>
    </body>
</html>