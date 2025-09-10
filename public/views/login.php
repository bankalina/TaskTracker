<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="public/styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-card">

            <div class="login-header">
                <div class="logo">
                    <div class="checkmark-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="brand-name">TaskTracker</span>
                </div>
                <p class="welcome-text">Welcome back! Please login to your account.</p>
            </div>

            <form class="login-form" action="login" method="POST">
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
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <span class="checkmark"></span>
                        Remember me
                    </label>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="signin-btn">Sign In</button>
            </form>

            <div class="signup-link">
                <p>Don't have an account? <a href="createAccount">Sign up</a></p>
            </div>
        </div>
    </div>
    <script src="public/js/script.js"></script>
</body>

</html>