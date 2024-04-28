<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .reset-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .reset-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .reset-form input[type="email"],
        .reset-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .reset-form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
        .reset-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <form class="reset-form" action="reset" method="post">
            <input type="text" name="shibir_id" placeholder="shibir Id" required>
            <input type="text" name="password" placeholder="password" required>
            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
