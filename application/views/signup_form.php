<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>application/views/register.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> <!-- FIXED ICON ISSUE -->
</head>
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

.reg_container {
    max-width: 450px;
    /* margin: 50px auto; */
    margin-top: 40px;
    background: rgba(255, 255, 255, 0.9);
    padding: 20px 10px;
    border-radius: 10px;  
    position: relative;
    right: -20%;
    top: 5%;
}

a{
    text-decoration: none;
}

.form-control {
    margin-bottom: 10px;
}

.reg_form {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap:20px;
    margin-top: 50px;
}

.reg_content{
    padding-top: 20px;
    padding-left: 5%;
}

.reg_content h1 {
    font-size: 50px;
    font-weight: bold;
    padding-top: 50px;
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

.huntmlogo{
    width:60px;
    height:60px;
    padding: 10px 0; 
   
}

button {
    width: 100%;
    padding: 10px;
    background: #510AC9;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
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

.footer_container p{
    color:gray;
}

    </style>
</head>
<body>
        <header>
        <a href="#"><h1 style="font-size:25px; color:white;"><img src="/huntm/Image/Huntm-logo.svg" alt="Huntm Logo" class="huntmlogo">Huntm</h1></a>
        </header>

        <div class="reg_form">
            <div class="reg_content">
                <h1>Keep your customers <br> engaged with your <br> business</h1>
                <p><i class="fas fa-chevron-right"></i>Send campaigns to your customers</p>
                <p><i class="fas fa-chevron-right"></i>Track the results</p>
                <p><i class="fas fa-chevron-right"></i>Manage your customers</p>
                <p><i class="fas fa-chevron-right"></i>Get insights</p>
            </div>
            <div class="reg_container">
                <h1 class="text-center">CREATE ACCOUNT</h1>
                <div><?php echo validation_errors() ?></div>
                <form method="post" action="<?=base_url('user/submit')?>">

                    <input type="email" name="email" class="form-control" placeholder="Email" required>

                    <div class="row">
                        <div class="col">
                            <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col">
                            <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>

                    <input type="text" name="phone" class="form-control" placeholder="Mobile Number" required>
                    <input type="text" name="username" class="form-control" placeholder="User Name" required>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>

                    <select name="role" class="form-control" required>
                        <option value="">User Role</option>
                        <option value="distributor">Distributor</option>
                        <option value="manager">Manager</option>
                        <option value="staff">Staff</option>
                        <option value="fieldofficer">Field Officer</option>
                    </select>

                    <textarea name="address" class="form-control" placeholder="Address" rows="3" required></textarea>

                    <div class="row">
                        <div class="col">
                            <input type="text" name="pincode" class="form-control" placeholder="Pincode" required>
                        </div>
                        <div class="col">
                            <input type="text" name="city" class="form-control" placeholder="City" required>
                        </div>
                    </div>

                    <input type="text" name="officenumber" class="form-control" placeholder="Office Mobile Number" required>

                    <div class="input-group">
                        <input type="text" name="officemaplink" class="form-control" placeholder="Map">
                        <span class="input-group-text">📍</span>
                    </div>

                    <button type="submit">SIGN UP</button>

                    <p style="text-align:center; padding-top: 10px;">Already have an account? <a href="login_user">Login</a></p>

                <?php echo form_close(); ?>

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
        <footer class="footer_container">
            <p>© 2022 Huntm, Inc. All rights reserved.</p>

        </footer>
</body>
</html>
