<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Customer - Register</title>
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
            transition: width 0.5s ease;
            display: flex;
        }

        .toggle-container,
        .form-container {
            flex: 1;
            height: 100%;
        }

        .toggle-container {
            position: relative;
            flex: 1.1111;
        }

        .toggle {
            background-color: #4B70DD;
            color: #fff;
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            text-align: center;
            transition: all 0.6s ease-in-out;
            border-radius: 0 150px 100px 0;
        }

        .container.active .toggle {
            left: -100%;
        }

        .toggle-panel {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            text-align: center;
            top: 0;
            transition: all 0.6s ease-in-out;
        }

        .toggle-right {
            right: 0;
        }

        .container.active .toggle-panel {
            left: 100%;
        }

        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            margin-left: 10px;
            flex: 1;
        }

        .form-container form {
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items horizontally */
        }

        .error-message {
            color: red;
            align-self: flex-start; /* Align error messages to the start */
        }

        .container p {
            font-size: 20px;
            line-height: 30px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        .container span {
            font-size: 18px;
            text-align: center;
            margin-bottom: 10px;
        }

        .container a {
            color: #333;
            font-size: 20px;
            text-decoration: none;
            margin: 20px 0 10px;
        }

        .container button {
            background-color: #4B70DD;
            color: #fff;
            font-size: 22px;
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
            font-size: 22px;
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

    @media (max-width: 380px) {
        .form-container {
            margin-top: 0px;
        }
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
</head>

<body>

    <div class="container" id="container">
        <!-- Toggle Section -->
        <div class="toggle-container">
            <div class="toggle toggle-right">
                <div class="toggle-panel">
                    <h1>Welcome!</h1>
                    <p>Welcome aboard! 🚀 We're excited to have you join our community. Get ready to embark on an incredible journey with us</p>
                    <a class="btn hidden" href="{{ route('login') }}">Log In</a>
                </div>
            </div>
        </div>
        <!-- Registration Form -->
        <div class="form-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h1>Create Account</h1>
                <!-- Name -->
                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name">
                <x-input-error :messages="$errors->get('name')" class="error-message" />
                <!-- Email Address -->
                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email">
                <x-input-error :messages="$errors->get('email')" class="error-message" />
                <!-- Password -->
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="error-message" />
                <!-- Confirm Password -->
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                <x-input-error :messages="$errors->get('password_confirmation')" class="error-message" />
                <button type="submit">Sign Up</button>
            </form>
        </div>
    </div>
</body>

</html>
