<?php
  $username = $password = $email = "";

  $errors = ["username" => "", "email" => "", "password" => "" ];



  if (isset($_POST['submit'])) {
    //username validation
    if (empty($_POST['username'])) {
      $errors['username'] = "A username is required";
    } else {
      $username = $_POST['username'];
      if (!preg_match("/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $username)) {
        $errors['username'] = "Only contains alphanumeric characters, underscore and dot. Number of characters must be between 3 to 20.";
      }
    }

    //email validation
    if (empty($_POST['email'])) {
      $errors['email'] = "An email is required";
    } else {
      $email = $_POST['email'];
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "$email is not a valid email address";
      }
    }

    //password validation
    if (empty($_POST['password'])) {
      $errors['password'] = "Please eneter password";
    } else {
      $password = $_POST['password'];
      if (strlen($password) < 8) {
        $errors['password'] = "Your Password Must Contain At Least 8 Cahracters!";
      } elseif (!preg_match("#[0-9]+#", $password)) {
        $errors['password'] = "Your Password Must Contain At Least 1 Number!";
      } elseif (!preg_match("#[a-z]+#", $password)) {
        $errors['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
      }
    }

    //write all data to a file
    if (array_filter($errors)) {
      // print_r($errors);
    } else {
      // $usrFile = dirname(__FILE__).'/Dat/username.txt';
      // $usrCont = "$username\n";
      // file_put_contents($usrFile, $usrCont);
      //
      // $emailFile = dirname(__FILE__).'/Dat/email.txt';
      // $emailCont = "$email\n";
      // file_put_contents($emailFile, $emailCont);
      //
      // $pwdFile = dirname(__FILE__).'/Dat/pwd.txt';
      // $pwdCont = "$password\n";
      // file_put_contents($pwdFile, $pwdCont);

      //saving all data into an array

      $usrInfo = [$username, $email, $password];
      $usrFile = dirname(__FILE__).'/Dat/user.txt';
      $usrArr = unserialize(file_get_contents($usrFile));
      array_push($usrArr, $usrInfo);
      $string_data = serialize($usrArr);
      $usr_dat = $string_data;

      file_put_contents($usrFile, $usr_dat);
      header('Location: index.php');
    }
  }

  function getLineWithString($fileName, $str) {
  $lines = file($fileName);
    foreach ($lines as $lineNumber => $line) {
        if (strpos($line, $str) !== false) {
            return $line;
        }
    }
    return -1;
  }

  $usrFile = dirname(__FILE__).'/Dat/user.txt';
  // $string_data = serialize($array);
  // file_put_contents($usrFile, $string_data);


  // $user_data = file_get_contents($usrFile);
  // $array = unserialize($user_data);
  // foreach ($array as $data) {
  //   // print_r($data[0]);
  //   array_search("Tina", $data);
  // }
 ?>

<?php include "./templates/header.php" ?>
  <link rel="stylesheet" href="public/style/sign_up.css">
  <link rel="stylesheet" href="public/style/signupmediaquery.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.slim.js"
  integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI="
  crossorigin="anonymous"></script>
<?php include "./templates/nav.php" ?>
  <div class="container">
    <div class="hero-section">
      <div class="hero-container">
        <h1 class="hero-title">Sign Up for VACAYELP</h1>
        <p class="hero-text">Create an account to review your favorite place and share it with others</p>
      </div>
    </div>
    <div class="sidebar">
      <form class="sign-up-form" action="signup.php" method="post">
        <h2 class="sign-up-header">Create an account</h2>
        <div class="sign-up-container">
          <label for="username" class="sign-up-label">
            <input type="text" name="username" id="username" class="sign-up-input" onblur="inputHandle(this)">
            <span class="sign-up-title">Username:</span>
            <div class="error_output">
              <?php echo $errors['username']; ?>
            </div>
          </label>
          <label for="email" class="sign-up-label">
            <input type="email" name="email" id="email" class="sign-up-input" onblur="inputHandle(this)">
            <span class="sign-up-title">Email:</span>
            <div class="error_output">
              <?php echo $errors['username']; ?>
            </div>
          </label>
          <label for="password" class="sign-up-label">
            <input type="password" name="password" id="password" class="sign-up-input" onblur="inputHandle(this)">
            <span class="sign-up-title">Password:</span>
            <div class="error_output">
              <?php echo $errors['username']; ?>
            </div>
          </label>
        </div>
        <button type="submit" name="submit" class="btn">Sign Up</button>
      </form>
    </div>
  </div>
  <script type="text/javascript">
  function inputHandle(event) {
    if (event.value !== "") {
      event.nextElementSibling.classList = 'moveUp';
    } else {
      event.nextElementSibling.classList = 'sign-up-title';
    }
  }
  window.onload = function() {
    console.log('loaded');
  }
  </script>
<?php include "./templates/footer.php" ?>
