<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CuraConnect</title>
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style-common.css" rel="stylesheet" />
</head>

<body>

  <!--header-->

  <?php include('includes/header.php'); ?>

  <?php include('includes/connection.php');

  session_start();

  // Clear existing session variables
  $_SESSION["user"] = "";
  $_SESSION["usertype"] = "";

  // Set the timezone
  date_default_timezone_set('Asia/Kolkata');
  $_SESSION["date"] = date('Y-m-d');

  // Import database connection
  include("connection.php");

  if ($_POST) {
    // Retrieve personal information from session
    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $nic = $_SESSION['personal']['nic'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];

    // Check if passwords match
    if ($newpassword === $cpassword) {
      // Check if email already exists
      $result = $database->query("SELECT * FROM user WHERE email='$email'");
      if ($result->num_rows === 1) {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
      } else {
        // Insert new patient record
        $database->query("INSERT INTO patient (pemail, pname, ppassword, paddress, pdob, ptel) VALUES ('$email', '$name', '$newpassword', '$address', '$dob', '$tele')");
        // Insert new web user record
        $database->query("INSERT INTO user (email, usertype) VALUES ('$email', 'p')");

        // Set session variables for user login
        $_SESSION["user"] = $email;
        $_SESSION["usertype"] = "p";
        $_SESSION["username"] = $fname;

        header('Location: patient/index.php');
        exit(); // Ensure no further code is executed after redirect
      }
    } else {
      $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password does not match :) Please try again...</label>';
    }
  } else {
    $error = '<label for="promter" class="form-label"></label>';
  }
  ?>



  <!--header end-->

  <!--create account section-->

  <section class="login-section">
    <center>
      <div class="login-block">
        <h2>Let's Get Started</h2>
        <p class="sub-text">It's Okay, Now Create User Account.</p>
        <div class="login-form">
          <table border="0" style="width: 69%">
            <form action="" method="POST">
              <tr>
                <td class="label-td" colspan="2">
                  <label for="newemail" class="form-label">Email: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="email"
                    name="newemail"
                    class="input-text"
                    placeholder="Email Address"
                    required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="tele" class="form-label">Mobile Number: </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="tel"
                    name="tele"
                    class="input-text"
                    placeholder="Ex: 9123456789"
                    pattern="[6-9][0-9]{9}" />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="newpassword" class="form-label">Create New Password:
                  </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="password"
                    name="newpassword"
                    class="input-text"
                    placeholder="New Password"
                    required />
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <label for="cpassword" class="form-label">Conform Password:
                  </label>
                </td>
              </tr>
              <tr>
                <td class="label-td" colspan="2">
                  <input
                    type="password"
                    name="cpassword"
                    class="input-text"
                    placeholder="Conform Password"
                    required />
                </td>
              </tr>

              <tr>
                <td colspan="2"><?php echo $error ?></td>
              </tr>

              <tr>
                <td class="td-btn">
                  <input
                    type="reset"
                    value="Reset"
                    class="login-btn common-light-btn" />
                </td>
                <td class="td-btn">
                  <input
                    type="submit"
                    value="Next"
                    class="login-btn common-btn" />
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <br />
                  <label for="" class="sub-text" style="font-weight: 280">Already have an account&#63;
                  </label>
                  <a href="login.php" class="hover-link1 non-style-link">Login</a>
                  <br /><br /><br />
                </td>
              </tr>
            </form>
          </table>
        </div>
      </div>
    </center>
  </section>

  <!--create account section end-->
</body>

</html>