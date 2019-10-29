<?php
  $fileName =  dirname(__FILE__).'/Dat/user.txt';
  $fileArr = unserialize(file_get_contents($fileName));

  $userName = $password = "";
  $errors = ["userName" => '', "password" => ''];

  if (isset($_POST['login'])) {
    if (empty($_POST['userName'])) {
      $errors["userName"] = "Please enter your userName";
    } else {
      $userName = $_POST['userName'];
      if (!preg_match("/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/", $userName)) {
          $errors["userName"] = "Your username is not validated";
      }
    }

    if (empty($_POST['password'])) {
      $errors['password'] = "Please enter your password";
    } else {
      $password = strip_tags($_POST['password']);
    }

    if (!array_filter($errors)) {

      foreach ($fileArr as $user) {
        if ($userName === $user[0] && $password === $user[2]) {
          setcookie('login', 'success', time() + (86400 * 30), "/");
          setcookie('userName', $user[0]);
        }
      }
      header('Location: login.php');
    }
  }
 ?>

<?php include './templates/header.php' ?>
<link rel="stylesheet" href="public/style/login.css">
<link rel="stylesheet" href="public/style/login_mediaquery.css">
<?php include './templates/nav.php' ?>

<div class="wrapper">
  <?php if (isset($_COOKIE["login"])) { ?>
    <section class="login-success">
      <h1 class="hero-header">Login Successfully</h1>
      <p class="hero-text">Redirecting back to homepage...</p>
      <?php header("refresh:3;url=index.php"); ?>
    </section>
    <?php  } else { ?>
      <div class="container">
      <section class="side-image">
        <div class="side-image-box">
          <h1>Welcome to VACAYELP</h1>
        </div>
      </section>
      <section class="login-section">
        <form class="login" action="login.php" method="post" >
          <div class="login-header">
            <h2>Log In to VACAYELP</h2>
          </div>
          <div class="login-container">
            <label for="userName" class="login-label">
              <input type="text" name="userName" id="userName" class="login-input" onblur="inputHandle(this)">
              <span class="login-title">Username:</span>
              <span style="font-size: 0.8rem; color: red; padding-top: 0.5em"><?php echo $errors["userName"] ?></span>
            </label>
            <label for="password" class="login-label">
              <input type="password" name="password" id="password" class="login-input" onblur="inputHandle(this)">
              <span class="login-title">Password:</span>
              <span style="font-size: 0.8rem; color: red; padding-top: 0.5em"><?php echo $errors["password"] ?></span>
            </label>
            <a href="#" class="pwd-link">Forget your password?</a>
            <button type="submit" name="login" class="btn btn-primary">Log In</button>
          </div>
          <div class="login-new-user">
            <hr>
            <h4>Don't have an account yet?</h4>
            <a href="signup.php" class="btn btn-secondary">Create your account</a>
          </div>
        </form>
      </section>
    <?php  } ?>
  </div>
</div>
<script type="text/javascript">
function inputHandle(event) {
  if (event.value !== "") {
    event.nextElementSibling.classList = 'moveUp';
  } else {
    event.nextElementSibling.classList = 'login-title';
  }
}
window.onload = function() {
  console.log('loaded');
}
</script>

<?php include './templates/footer.php' ?>
