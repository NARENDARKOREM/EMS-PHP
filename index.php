<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }

        .header {
            background-color: #6c757d;
            padding: 1rem;
            color: #ffffff;
            text-align: center;
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .signup,
        .login {
            background-color: #6c757d;
        }

        .container {
            margin-top: 2rem;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-switch {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .form-switch button {
            margin: 0 0.5rem;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Employee Management System</h1>
    </div>
    <div class="container">
        <div class="form-container">
            <div class="form-switch">
                <button id="loginButton" class="btn btn-secondary">Login</button>
                <button id="signupButton" class="btn btn-secondary">Sign Up</button>
            </div>
            <form id="loginForm" action="login.php" method="post">
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="loginEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                </div>
                <button type="submit" class="btn login w-100">Login</button>
            </form>
            <form id="signupForm" style="display: none;" action="signup.php" method="post">
                <div class="mb-3">
                    <label for="signupName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="signupName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="signupUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="signupUsername" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="signupEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="signupEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="signupPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="signupPassword" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="mb-3">
                    <label for="signupRole" class="form-label">Role</label>
                    <select class="form-control" id="signupRole" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                    </select>
                </div>
                <button type="submit" class="btn signup w-100">Sign Up</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginButton').addEventListener('click', function() {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('signupForm').style.display = 'none';
        });

        document.getElementById('signupButton').addEventListener('click', function() {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'block';
        });

        // Show login form if redirected after signup
        if (window.location.search.includes('signup=success')) {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('signupForm').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>