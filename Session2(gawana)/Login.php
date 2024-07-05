<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session 2</title>

    <style>
        * {
            user-select: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            height: 100vh;
            margin: 0;
        }


        .container {
            height: 350px;
            width: 550px;
            background-color: #72A0C1;
            border: 1px solid black;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
        }

        .inside-container {
            height: 200px;
            width: 350px;
            background-color: #B9D9EB;
            border: 3px solid whitesmoke;
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
        }


        .Textcontainer {
            display: flex;
            justify-content: center;
        }


        .gridcontain {
            display: grid;
            grid-template-columns: 30% 50%;
            position: relative;
            top: 10px;
            left: 40px;
            padding: 10px;

        }

        button {
            display: inline-block;
            padding: 7px 17px;
            text-align: center;
            text-decoration: none;
            border: 1px solid black;
            cursor: pointer;
            border-radius: 10px;
            background-color: #E1EBEE;
            border: 2px solid whitesmoke;
        }

        button:hover {
            background-color: black;
            color: white;
        }

        label {
            font-size: 18px;
        }

        input {
            padding: 8px;
            border-radius: 10px;
            transition: box-shadow 0.3s, background-color 0.3s;
            background-color: #E1EBEE;
        }

        input:focus {
            border-bottom: 2px solid green;
            box-shadow: 0px 4px 6px rgba(76, 175, 80, 0.5);
            /* Shadow effect below */
        }

        .button-contain {
            position: relative;
            top: 50px;
            left: 193px;
            display: grid;
            grid-template-columns: 23% 30%;
        }


        .login button:hover {
            background-color: green;
            color: white;
        }

        .cancel button:hover {
            background-color: red;
            color: white;
        }
    </style>

</head>

<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "Session2";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT *, IsAdmin FROM employees WHERE Username='$username' AND Password='$password'";
    $result = $connection->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $isAdmin = $row['IsAdmin'];

        if ($isAdmin == 1) {
            echo "<script>alert('Admin login successful');</script>";
            header("Location: ListRequest.php");
            exit;
        } else {
            echo "<script>alert('User login successful');</script>";
            header("Location: AssetsList.php");
            exit;
        }
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>


<body>
    <div class="container">
        <div class="inside-container">
            <div class="Textcontainer">
                <h4>Sign in to EM Management</h4>
            </div>
            <form method="post" action="">
                <div class="gridcontain">
                    <label>Username:</label>
                    <input type="text" name="username" id="username" placeholder="Username">
                </div>
                <div class="gridcontain">
                    <label>Password:</label>
                    <input type="password" name="password" id="password" placeholder="******">
                </div>
                <div class="button-contain">
                    <div class="login">
                        <button type="submit">Login</button>
                    </div>
                    <div class="cancel">
                        <button type="reset">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</script>
</body>

</html>