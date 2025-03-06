<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('/Huntm/assets/css/registrationform.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
         body {
            font-family: 'Poppins', sans-serif; 
            font-size: 16px; 
            font-weight: 400; 
            color: #333; 
            line-height: 1.6;
            background-color: #2C3E50;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color:#2C3E50; 
            padding: 10px 20px;
            z-index: 1000;
        }
        
        .huntmlogo{
            width:60px;
            height:60px;
            padding: 10px 0;  
        }
        
        a{
            text-decoration: none;
        }
        
        .login-page{
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap:20px;
            margin-top: 70px;
        }

        .reg_content {
            padding-top: 20px;
            padding-left: 5%;
        }

        .reg_content h1 {
            font-size: 50px;
            font-weight: bold;
            color: white;
        }

        .reg_content p {
            text-align: left;
            display: flex;
            align-items: center;
            font-size: 20px;
            color: white;
            padding:5px 0;
        }

        .reg_content i {
            font-size: 20px;
            padding-right: 10px;
            color:#0000FF;
        }

        .reg_container {
            max-width: 700px;
            margin: 40px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px; 
        }

        .reg_container h2 {
            font-weight: bold;
            color: #3a3a3a;
            text-align:center;
        }

        .reg_container p{
            text-align:center;
        }

        input {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #510AC9;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .forgot-password {
            display: block;
            margin-top: 10px;
            color: #777;
            text-decoration: none;
            font-size: 14px;
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
        }

        .register-link a {
            color: #510AC9;
            text-decoration: none;
            font-weight: bold;
        }

        .icon-box {
            display: inline-block;
            width: 100px;
            height: 30px;
            margin: 5px;
            text-align: center;
            vertical-align: middle;
            line-height: 35px;
            border: 1px solid;
            border-radius: 5px;
            position:relative;
            left:30px; 
        }

        .icon-box i {
            color: black;
            font-size: 20px;
        }

    </style>
</head>
<body>
    <header>
        <a href="#"><h1 style="font-size:25px; color:white;"><img src="/Huntm/Image/Huntm-logo.svg" alt="Huntm Logo" class="huntmlogo">Huntm</h1></a>
    </header>

    <div class="login-page">
        <div class="reg_content">
            <h1>Keep your customers engaged with your business</h1>
            <p><i class="fas fa-chevron-right"></i>Send campaigns to your customers</p>
            <p><i class="fas fa-chevron-right"></i>Track the results</p>
            <p><i class="fas fa-chevron-right"></i>Manage your customers</p>
            <p><i class="fas fa-chevron-right"></i>Get insights</p>
        </div>
        <div class="reg_container">
            <h2>LOG IN</h2>
            <!-- <div><?php echo validation_errors() ?></div> -->
            <form method="post" action="<?=base_url('user/login_user')?>">
                <input type="text" name="email" placeholder="Mobile Number or Email Id" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <a href="<?=base_url('user/send_password')?>">Forgot Password?</a>
                <p class="register-link">New to Huntm.in? <a href="submit">Register</a></p>
            </form>
            <div class="icon-box">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
                <div class="icon-box">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
                <div class="icon-box">
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
        </div>
    </div>
</body>
</html>
