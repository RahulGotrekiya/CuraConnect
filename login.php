<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/style-common.css" />
</head>

<body>

  <?php

  // include database
  include('connection.php');

  // include header file
  include('includes/header.php');

  // Initialize error variable
  $error = '';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    // Prepare and execute the statement
    $stmt = $conn->prepare("SELECT ppassword FROM users WHERE email = ? AND usertype = 'p'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      // Compare the plain-text password
      if ($password === $user['ppassword']) {
        echo "Login successful!";
        // Redirect or start a session here
      } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
      }
    } else {
      $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">No account found for this email.</label>';
    }

    $stmt->close();
    $conn->close();
  }

  ?>

  <!--login section-->

  <section class="login-section">
    <center>
      <div class="login-block">
        <h2>Welcome Back!</h2>
        <p class="sub-text">Login with your details to continue</p>
        <div class="login-form">
          <form action="" method="POST">
            <table border="0" style="margin: 0; padding: 0; width: 60%">
              <tr>
                <td class="label-td">
                  <label for="useremail" class="form-label">Email: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input
                    type="email"
                    name="useremail"
                    class="input-text"
                    placeholder="Email Address"
                    required />
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <label for="userpassword" class="form-label">Password:
                  </label>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input
                    type="Password"
                    name="userpassword"
                    class="input-text"
                    placeholder="Password"
                    required />
                </td>
              </tr>
              <tr>
                <td>
                <td colspan="2"><?php echo $error ?></td>
                </td>
              </tr>
              <tr>
                <td class="label-td">
                  <input
                    type="submit"
                    value="Login"
                    class="common-btn login-btn" />
                </td>
              </tr>
              <tr>
                <td>
                  <br />
                  <label for="" class="sub-text" style="font-weight: 280">Don't have an account&#63;
                  </label>
                  <a href="signup.php" class="hover-link1">Sign Up</a>
                  <br /><br /><br />
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </center>
  </section>

  <!--login section end-->

  <!--footer-->
  <?php include('includes/footer.php'); ?>
  <!--footer end-->
</body>

</html>