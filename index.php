<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .form-switch {
            display: flex;
            justify-content: space-around;
            margin-bottom: 2rem;
        }

        .form-switch button {
            flex: 1;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            border: none;
            outline: none;
            font-weight: bold;
            cursor: pointer;
        }

        #loginButton.active,
        #signupButton.active {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
        }

        #loginButton,
        #signupButton {
            background: #e0e0e0;
            color: #333;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #d6d6d6;
        }

        .form-wrapper {
            position: relative;
            width: 100%;
            height: auto;
        }

        .form-wrapper form {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transform: translateX(-100%);
            transition: all 0.5s ease-in-out;
        }

        form.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        form:not(.active) {
            transform: translateX(100%);
        }

        .btn {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border: none;
        }

        .btn:hover {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 0.8rem;
        }

        .form-heading {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
            color: #333;
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 1.5rem;
                max-width: 350px;
            }

            .form-switch button {
                padding: 0.3rem 0.8rem;
                font-size: 0.9rem;
            }

            .form-heading {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-switch">
            <button id="loginButton" class="active">Login</button>
            <button id="signupButton">Sign Up</button>
        </div>

        <div class="form-wrapper">
            <!-- Login Form -->
            <form id="loginForm" class="active" action="login.php" method="post">
                <div class="form-heading">Welcome Back!</div>
                <div class="mb-3">
                    <label for="loginEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="loginEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                </div>
                <button type="submit" class="btn w-100">Login</button>
            </form>

            <!-- Signup Form -->
            <form id="signupForm" action="signup.php" method="post">
                <div class="form-heading">Create an Account</div>
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
                <button type="submit" class="btn w-100">Sign Up</button>
            </form>
        </div>
    </div>

    <script>
        const loginButton = document.getElementById('loginButton');
        const signupButton = document.getElementById('signupButton');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');

        loginButton.addEventListener('click', () => {
            loginForm.classList.add('active');
            signupForm.classList.remove('active');
            loginButton.classList.add('active');
            signupButton.classList.remove('active');
        });

        signupButton.addEventListener('click', () => {
            signupForm.classList.add('active');
            loginForm.classList.remove('active');
            signupButton.classList.add('active');
            loginButton.classList.remove('active');
        });
    </script>
</body>

</html>
