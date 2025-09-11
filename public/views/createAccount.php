<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="public/styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="create-account-page">
    <div class="login-container">
        <div class="login-content">
            <div class="login-header">
                <div class="logo">
                    <div class="checkmark-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="brand-name">TaskTracker</span>
                </div>
                <h1 class="page-title">Create your account</h1>
                <p class="welcome-text">Start managing your tasks efficiently</p>
            </div>

            <form class="login-form" action="createAccount" method="POST">
                <div class="messages">
                    <?php if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo '<div class="message error">' . $message . '</div>';
                        }
                    }?>
                    <?php if(isset($success_messages)) {
                        foreach ($success_messages as $message) {
                            echo '<div class="message success">' . $message . '</div>';
                        }
                    }?>
                </div>

                <div class="form-group">
                    <label for="fullname">Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Create a password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="confirmPassword" name="confirmPassword"
                            placeholder="Confirm your password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-wrapper terms-checkbox">
                        By clicking the Create Account button, you agree to our
                        <a href="#" class="terms-link">Terms of Service</a>
                        and
                        <a href="#" class="terms-link">Privacy Policy.</a>
                    </label>
                </div>

                <button type="submit" class="signin-btn">
                    <i class="fas fa-user-plus"></i>
                    Create Account
                </button>
            </form>

            <div class="signup-link">
                <p>Already have an account? <a href="login">Log in</a></p>
            </div>
        </div>
    </div>

    <script src="public/js/script.js"></script>
</body>

</html>