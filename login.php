   <!DOCTYPE html>
    <!-- Coding by CodingNepal | www.codingnepalweb.com-->
    <html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <title> Login and Registration Form in HTML & CSS | CodingLab </title>
        <link rel="stylesheet" href="style.css">
        <!-- Fontawesome CDN Link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>       
           /* Google Font Link */
           @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
           *{
              margin: 0;
              padding: 0;
              box-sizing: border-box;
              font-family: "Poppins" , sans-serif;
          }
          body{
              min-height: 100vh;
              display: flex;
              align-items: center;
              justify-content: center;
              background: url('image/2.jpg');
              padding: 30px;
              background-size: cover;
          }
          .container{
              position: relative;
              max-width: 850px;
              width: 100%;
              background: #fff;
              padding: 40px 30px;
              box-shadow: 0 5px 10px rgba(0,0,0,0.2);
              perspective: 2700px;
          }
          .container .cover{
              position: absolute;
              top: 0;
              left: 50%;
              height: 100%;
              width: 50%;
              z-index: 98;
              transition: all 1s ease;
              transform-origin: left;
              transform-style: preserve-3d;
          }
          .container #flip:checked ~ .cover{
              transform: rotateY(-180deg);
          }
          .container .cover .front,
          .container .cover .back{
              position: absolute;
              top: 0;
              left: 0;
              height: 100%;
              width: 100%;
          }
          
          .container .cover::before,
          .container .cover::after{
              content: '';
              position: absolute;
              height: 100%;
              width: 100%;
              background: #7d2ae8;
              opacity: 0.5;
              z-index: 12;
              backface-visibility: hidden;
          }
          .container .cover::after{
              opacity: 0.3;
              transform: rotateY(180deg);
              backface-visibility: hidden;
          }
          .container .cover img{
              position: absolute;
              height: 100%;
              width: 100%;
              object-fit: cover;
              z-index: 10;
              backface-visibility: hidden;
          }
          .container .cover .text{
              position: absolute;
              z-index: 130;
              height: 100%;
              width: 100%;
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
              backface-visibility: hidden;
          }
          .cover .text .text-1,
          .cover .text .text-2{
              font-size: 26px;
              font-weight: 600;
              color: #fff;
              text-align: center;
              backface-visibility: hidden;
              transition: transform 0.8s ease;
          }
          .cover .back .text .text-1,
          .cover .back .text .text-2{
            transform: rotate(180deg);
          }
          .cover .text .text-2{
              font-size: 15px;
              font-weight: 500;
          }
          .container #flip:checked ~ .cover .text .text-1 {
            transform: rotateY(180deg);
            z-index: 2;
          }
          .container #flip:checked ~ .cover .text .text-2 {
            transform: rotateY(180deg);
            z-index: 2;
          }
          .container .forms{
              height: 100%;
              width: 100%;
              background: #fff;
          }
          .container .form-content{
              display: flex;
              align-items: center;
              justify-content: space-between;
          }
          .form-content .login-form,
          .form-content .signup-form{
              width: calc(100% / 2 - 25px);
          }
          .forms .form-content .title{
              position: relative;
              font-size: 24px;
              font-weight: 500;
              color: #333;
          }
          .forms .form-content .title:before{
              content: '';
              position: absolute;
              left: 0;
              bottom: 0;
              height: 3px;
              width: 25px;
              background: #7d2ae8;
          }
          .forms .signup-form  .title:before{
              width: 20px;
          }
          .forms .form-content .input-boxes{
              margin-top: 30px;
          }
          .forms .form-content .input-box{
              display: flex;
              align-items: center;
              height: 50px;
              width: 100%;
              margin: 10px 0;
              position: relative;
          }
          .form-content .input-box input{
              height: 100%;
              width: 100%;
              outline: none;
              border: none;
              padding: 0 30px;
              font-size: 16px;
              font-weight: 500;
              border-bottom: 2px solid rgba(0,0,0,0.2);
              transition: all 0.3s ease;
          }
          .form-content .input-box input:focus,
          .form-content .input-box input:valid{
              border-color: #7d2ae8;
          }
          .form-content .input-box i{
              position: absolute;
              color: #7d2ae8;
              font-size: 17px;
          }
          .forms .form-content .text{
              font-size: 14px;
              font-weight: 500;
              color: #333;
          }
          .forms .form-content .text a{
              text-decoration: none;
          }
          .forms .form-content .text a:hover{
              text-decoration: underline;
          }
          .forms .form-content .button{
              color: #fff;
              margin-top: 40px;
          }
          .forms .form-content .button input{
              color: #fff;
              background: #7d2ae8;
              border-radius: 6px;
              padding: 0;
              cursor: pointer;
              transition: all 0.4s ease;
          }
          .forms .form-content .button input:hover{
              background: #5b13b9;
          }
          .forms .form-content label{
              color: #5b13b9;
              cursor: pointer;
          }
          .forms .form-content label:hover{
              text-decoration: underline;
          }
          .forms .form-content .login-text,
          .forms .form-content .sign-up-text{
              text-align: center;
              margin-top: 25px;
          }
          .container #flip{
              display: none;
          }
         .forms .date_time{
              color: #fff;
              background: #7d2ae8;
              border-radius: 10px;
              width : calc(100% / 2 - 25px);
              height: 100%;
              padding: 0;
              text-align: center;
              border-bottom: 2px solid rgba(0,0,0,0.2);
              font-size: 20px;
              font-weight: 500;
          }
          @media (max-width: 730px) {
              .container .cover{
                display: none;
            }
            .form-content .login-form,
            .form-content .signup-form{
                width: 100%;
            }
            .form-content .signup-form{
                display: none;
            }
            .container #flip:checked ~ .forms .signup-form{
                display: block;
            }
            .container #flip:checked ~ .forms .login-form{
                display: none;
            }
        }   
    </style>
    </head>
    <body>
      <div class="container">
        <input type="checkbox" id="flip">
        <div class="cover">
          <div class="front">
            <img src="image/font.png" alt="image">
            <div class="text">
              <span class="text-1">"Sustainable Cultivation Nourishing the Future <br> Hydroponic Farming"</span>
              <span class="text-2">Let's get connected</span>
          </div>
      </div>

    </div>
    <div class="forms">
        <div class="date_time" id="datetime">Loading...</div>
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
            <form action="loginform.php" method="post">
                <div class="input-boxes">
                  <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="text" name= "email" placeholder="Enter your email" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" name ="Password" placeholder="Enter your password" required>
                </div>
                <div class="text"><a href='forgot_password.php'>Forgot password?</a></div>
                <div class="button input-box">
                    <input type="submit" value="Submit">
                </div>
                <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup now</label></div>
            </div>
        </form>
    </div>
    <div class="signup-form">
      <div class="title">Signup</div>
      <form action="registration.php" method="post">
        <div class="input-boxes">
          <div class="input-box">
            <i class="fas fa-user"></i>
            <input type="text" name= "username" placeholder="Enter your name" required>
        </div>
        <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="email" name ="email"  placeholder="Enter your email" required>
        </div>
        <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" name= "Password" placeholder="Enter your password" required>
        </div>
        <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" name = "confirm_password" placeholder="config your password" required>
        </div>
        <div class="button input-box">
            <input type="submit" value="Submit">
        </div>
        <div class="text sign-up-text">Already have an account? <label for="flip">Login now</label></div>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    </body>
    </html>
<script>
    // Function to update the date and time
    function updateDateTime() {
      const now = new Date();
      const dateTimeString = now.toLocaleString(); // Convert date and time to a human-readable string
      document.getElementById("datetime").textContent = dateTimeString;
  }

    // Call the function once when the page loads
  updateDateTime();

    // Update the date and time every second (1000ms)
  setInterval(updateDateTime, 1000);
</script>