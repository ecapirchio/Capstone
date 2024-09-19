<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Workout Helper</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            height: 100%;
        }
        .left {
            background-color: #242424;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .right {
            position: relative;
            flex: 1;
            background: url('NickBackground.jpeg') no-repeat center center;
            background-size: cover;
        }
        .right::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent dark overlay */
        }
        .title {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }
        .form-group button.cancel {
            background-color: #f44336;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
    <script>
        // Redirect to login.html when Cancel button is clicked
        function cancelRegistration() {
            window.location.href = 'login.html';
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="title">Register</div>
            
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <form method="POST" action="register.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="Register">Register</button>
                    <!-- Cancel button that triggers JavaScript function to redirect -->
                    <button type="button" class="cancel" onclick="cancelRegistration()">Cancel</button>
                </div>
            </form>
        </div>
        <div class="right"></div>
    </div>
</body>
</html>
