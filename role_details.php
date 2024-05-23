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
    <h2>Role Details</h2>
    <?php
    $connection = pg_connect("host=localhost dbname=postgres user=postgres password=postgredb");

    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }?>

<table>
        <tr>
            <th>Role ID</th>
            <th>Role Name</th>
            <th>Department Name</th>
            <th>Role Comments</th>
            </tr>

        <?php
        $result_emp=pg_query($connection, "SELECT * FROM public.roles");
        while($row = pg_fetch_assoc($result_emp)) {
        echo"
        <tr>
        <td>$row[ro_roleid] </td>
        <td>$row[ro_name]</td>
        <td>$row[ro_department]</td>
        <td>$row[ro_comment]</td>

        </tr>
        ";
        }
        ?>
    </table>
 <a href="http://localhost/index123.php/"> Go Back </a>
    </body>
</html>