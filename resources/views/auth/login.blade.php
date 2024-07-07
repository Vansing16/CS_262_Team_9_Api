<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Customer - Login</title>
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
    }

    body {
        background-color: white;
        background: linear-gradient(to right, white, white);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: 100vh;
        padding: 20px;
    }

    .container {
        background-color: #fff;
        border-radius: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        position: relative;
        overflow: hidden;
        width: 1000px;
        max-width: 100%;
        min-height: 700px;
        transition: width 0.5s ease, transform 0.5s ease;
    }

    .container p {
        font-size: 18px;
        line-height: 28px;
        letter-spacing: 0.3px;
        margin: 20px 0;
    }

    .container span {
        font-size: 16px;
    }

    .container a {
        color: #333;
        font-size: 17px;
        text-decoration: none;
        margin: 20px 0 10px;
    }

    .container button {
        background-color: #4B70DD;
        color: #fff;
        font-size: 20px;
        padding: 20px 60px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 20px;
        cursor: pointer;
    }

    .container .btn {
        background-color: #4B70DD;
        color: #fff;
        font-size: 20px;
        padding: 20px 60px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-top: 20px;
        cursor: pointer;
    }

    .container .btn.hidden {
        background-color: transparent;
        border-color: #fff;
    }

    .container .btn:hover {
        background-color: white;
        color: black;
    }

    .container button.hidden {
        background-color: transparent;
        border-color: #fff;
    }

    .container form {
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 80px;
        height: 100%;
    }

    .container input {
        background-color: #eee;
        border: none;
        margin: 10px 0;
        padding: 20px 25px;
        font-size: 18px;
        border-radius: 8px;
        width: 100%;
        outline: none;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .container.active .sign-in {
        transform: translateX(100%);
    }

    .social-icons {
        margin: 20px 0;
    }

    .social-icons a {
        border: 1px solid #ccc;
        border-radius: 20%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        width: 50px;
        height: 50px;
    }

    .toggle-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: all 0.6s ease-in-out;
        border-radius: 150px 0 0 100px;
        z-index: 1000;
    }

    .container.active .toggle-container {
        transform: translateX(-100%);
        border-radius: 0 150px 100px 0;
    }

    .toggle {
        background-color: #4B70DD;
        height: 100%;
        background: linear-gradient(to right, #5c6bc0, #4B70DD);
        color: #fff;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: all 0.6s ease-in-out;
    }

    .container.active .toggle {
        transform: translateX(50%);
    }

    .toggle-panel {
        position: absolute;
        width: 50%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        text-align: center;
        top: 0;
        transform: translateX(0);
        transition: all 0.6s ease-in-out;
    }

    .toggle-left {
        transform: translateX(-200%);
    }

    .container.active .toggle-left {
        transform: translateX(0);
    }

    .toggle-right {
        right: 0;
        transform: translateX(0);
    }

    .container.active .toggle-right {
        transform: translateX(200%);
    }

    .error-message {
        color: red;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .container {
            width: 100%;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .toggle-container {
            position: relative;
            width: 100%;
            height: auto;
            left: 0;
            top: 0;
            border-radius: 0;
            overflow: visible;
            transform: none;
            margin-bottom: 300px;
        }

        .toggle {
            width: 100%;
            height: auto;
            left: 0;
            transform: none;
            background: linear-gradient(to right, #5c6bc0, #4B70DD);
            border-radius: 20px 20px 0 0;
        }

        .toggle-panel {
            background-color: #4B70DD;
            width: 100%;
            height: auto;
            transform: none;
            padding: 20px;
        }

        .form-container {
            width: 100%;
            position: static;
            height: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 0 0 20px 20px;
        }

        .sign-in {
            position: static;
            width: 100%;
            left: 0;
            transform: none;
        }

        .container.active .sign-in {
            transform: none;
        }

        .container form {
            padding: 0 20px;
        }

        .container input {
            padding: 15px 20px;
            font-size: 16px;
        }

        .container button,
        .container .btn {
            padding: 15px 50px;
            font-size: 18px;
        }

        .container p {
            font-size: 16px;
        }

        .container a {
            font-size: 15px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
        }

        /* Add scaling for better visibility */
        .container {
            transform: scale(0.9);
        }
    }

    @media (max-width: 480px) {
        .container {
            width: 100%;
            min-height: 650px;
            display: flex;
            flex-direction: column;
            align-items: center;
            
        }

        .toggle-container {
            position: relative;
            width: 100%;
            height: auto;
            left: 0;
            top: 0;
            border-radius: 0;
            overflow: visible;
            transform: none;
            margin-bottom: 20px;
        }

        .toggle {
            width: 100%;
            height: auto;
            left: 0;
            transform: none;
            background: linear-gradient(to right, #5c6bc0, #4B70DD);
            border-radius: 20px 20px 0 0;
        }

        .toggle-panel {
            background-color: #4B70DD;
            width: 100%;
            height: auto;
            transform: none;
            padding: 20px;
        }

        .form-container {
            width: 100%;
            position: static;
            height: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 0 0 20px 20px;
            margin-top: 300px;
        }

        .sign-in {
            position: static;
            width: 100%;
            left: 0;
            transform: none;
            padding: 20px;
        }

        .container.active .sign-in {
            transform: none;
        }

        .container form {
            padding: 0 20px;
        }

        .container input {
            padding: 15px 20px;
            font-size: 16px;
        }

        .container button,
        .container .btn {
            padding: 15px 50px;
            font-size: 18px;
        }

        .container p {
            font-size: 16px;
        }

        .container a {
            font-size: 15px;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
        }

        /* Add scaling for better visibility */
        .container {
            transform: scale(0.9);
        }
    }

    @media (max-width: 360px) {
    .container {
        transform: scale(0.85); /* Slightly smaller scale for very small screens */
    }

    .container button,
    .container .btn {
        padding: 10px 40px; /* Smaller padding for buttons */
        font-size: 16px;
    }

    .container input {
        padding: 10px 15px; /* Smaller padding for inputs */
        font-size: 14px;
    }

    .container p {
        font-size: 14px;
    }

    .container a {
        font-size: 13px;
    }

    /* Toggle Section */
    .toggle-container {
        margin-bottom: 10px; /* Reduce margin for smaller screens */
    }

    .toggle {
        border-radius: 10px 10px 0 0; /* Adjust border radius */
    }

    .toggle-panel {
        padding: 10px; /* Reduce padding for smaller screens */
    }
    
}

</style>

<body>

    <div class="container" id="container">
        <!-- Toggle Section -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back!</h1>
                    <p>Welcome back! 🌟 We're thrilled to see you again. Log in to access your personalized dashboard and continue your journey with us.</p>
                    <a class="btn hidden" href="{{ route('register') }}">Sign Up</a>
                </div>
            </div>
        </div>
        <!-- Login Form -->
        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign in</h1>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email">
                <x-input-error :messages="$errors->get('email')" class="error-message" />
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="error-message" />
                <x-input-error :messages="$errors->get('error')" class="error-message" />
                <a href="{{ route('password.request') }}">Forgot your password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>
    </div>
</body>

</html>

