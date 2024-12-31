<?php
require_once 'Model/db.php';

if (isset($_COOKIE['token'])) {
  $token = $_COOKIE['token'];
  $stmt = $connection->prepare("SELECT * FROM user WHERE token = ?");
  $stmt->execute([$token]);
  $user = $stmt->fetch();
  if ($user) {
    header("Location:View/index.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: rgb(197, 193, 193);
    }

    .container {
      margin-top: 0.5rem;
      width: 37%;
      justify-content: center;
      align-items: center;

    }

    .tab-content {
      padding: 3rem 1.5rem;
      background: #fffffe;
      box-shadow: 0 3px 3px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Pills navs -->
    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="tab-login" data-mdb-pill-init href="#pills-login" role="tab"
          aria-controls="pills-login" aria-selected="true">Login</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab-register" data-mdb-pill-init href="#pills-register" role="tab"
          aria-controls="pills-register" aria-selected="false">Register</a>
      </li>
    </ul>
    <!-- Pills navs -->

    <!-- Pills content -->
    <div class="tab-content">
      <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">

        <!-- First form -->

        <form action="authentication.php" method="post">
          <div class="text-center mb-3">
            <p>Sign in with:</p>
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
              <i class="fab fa-google"></i>
            </button>

            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
              <i class="fab fa-github"></i>
            </button>
          </div>

          <p class="text-center">or:</p>

          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" name="email" class="form-control" />
            <label class="form-label">Email</label>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" maxlength="12" name="password" class="form-control" />
            <label class="form-label">Password</label>
          </div>

          <!-- 2 column grid layout -->
          <div class="row mb-4">
            <div class="col-md-6 d-flex justify-content-center">
              <!-- Checkbox -->
              <div class="form-check mb-3 mb-md-0">
                <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked name="remember_me" />
                <label class="form-check-label"> Remember me </label>
              </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center">
              <!-- Simple link -->
              <a href="#!">Forgot password?</a>
            </div>
          </div>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary btn-block mb-4" name="log_submit">Sign in</button>

          <div class="text-center">
            <p>Not a member? <a href="#pills-register">Register</a></p>
          </div>
        </form>

      </div>

      <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">

        <!-- Second Form -->
        <form action="register.php" id="register_form" method="POST">
          <div class="text-center mb-3">
            <p>Sign up with:</p>
            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-google"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-link btn-floating mx-1">
              <i class="fab fa-github"></i>
            </button>
          </div>

          <p class="text-center">or:</p>


          <!-- Username input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="text" name="username" class="form-control" required />
            <label class="form-label">Username</label>
          </div>

          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" name="email" class="form-control" required />
            <label class="form-label">Email</label>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" maxlength="12" id="password" name="password" class="form-control" required oninput="checkPasswordStrength()" />
            <label class="form-label" id="strengthFeedback">Password</label>
          </div>
          <script>
            function checkPasswordStrength() {
              const password = document.getElementById('password').value;
              let strength = 0;
              const feedbackElement = document.getElementById('strengthFeedback');

              // Length check: Password should be at least 8 characters long
              if (password.length >= 8) strength++;

              // Check for lowercase letters
              if (/[a-z]/.test(password)) strength++;

              // Check for uppercase letters
              if (/[A-Z]/.test(password)) strength++;

              // Check for numbers
              if (/[0-9]/.test(password)) strength++;

              // Check for special characters (non-alphanumeric)
              if (/[\W_]/.test(password)) strength++;

              // Password strength feedback based on score
              if( strength === 0 ){
                feedbackElement.textContent = "Password";
                feedbackElement.className = 'form-label';
              }else if (strength < 3) {
                feedbackElement.textContent = "Weak";
                feedbackElement.className = 'form-label text-danger'; // Red for weak
              } else if (strength === 3) {
                feedbackElement.textContent = "Medium";
                feedbackElement.className = 'form-label text-warning'; // Yellow for medium
              } else {
                feedbackElement.textContent = "Strong";
                feedbackElement.className = 'form-label text-success'; // Green for strong
              }
            }
          </script>

          <!-- Repeat Password input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" maxlength="12" name="repassword" class="form-control" required />
            <label class="form-label">Repeat password</label>
          </div>
          <div class="form-check d-flex justify-content-center mb-4">
            <input class="form-check-input me-2" type="checkbox" value="" id="registerCheck" checked
              aria-describedby="registerCheckHelpText" />
            <label class="form-check-label">
              I have read and agree to the terms
            </label>
          </div>
          <button type="submit" class="btn btn-primary btn-block mb-3" name="reg_submit">Sign in</button>
        </form>
      </div>

    </div>
  </div>

</body>

<script>
  document.getElementById('register_form').addEventListener('reg_submit', function(event) {
    if (!document.getElementById('registerCheck').checked) {
      alert("You must agree to the terms and conditions to register.");
      event.preventDefault();
    }
  });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.1.0/mdb.umd.min.js"></script>


</html>