<div id="signupform" class="modal">
    <div style="background-color:white;padding:0.2% 5% 0.5% 5%; margin:5% 24.9% 0% 24.93%; border-radius:5px 5px 0 0;" class="animate">
        <div class="imgcontainer">
            <span onclick="document.getElementById('signupform').style.display='none'" class="close" title="Close Modal">&times;</span>
        </div>
        <h3>SignUp</h3>
    </div> 
    <form class="modal-content animate" action="" method="post" style="margin-top:0;background-color: gray;border-radius:0 0 5px 5px;font-size:14px">
        <div class="container">
            <center>
            <input type="email" style="border-radius:8px" placeholder="Enter email" name="Email" required><br>
            <span id="emailexistsWarning" style="color:red; font-size:12px"></span>
            <input type="text" style="border-radius:7px" placeholder="Enter Full name" name="fullname" required><br>
            <input type="text" style="border-radius:7px" placeholder="Enter Mobile Number" name="mobile" required><br>
            <input type="text" style="border-radius:7px" placeholder="Enter Username" name="uname" required><br>
            <span id="userNameExists" style="color:red; font-size:12px"></span>
            <input type="password" style="border-radius:7px" placeholder="Enter Password" name="psw" required><br>
            <button class="bt" type="submit" style="border-radius: 7px;width:50%;color:white;" name="signUpBtn">SIGNUP</button>
          </center>
        </div>
    </form>
    <?php
$signUpBtn = $_POST['signUpBtn'];
if (isset($signUpBtn)) {
    $em = $_POST['Email'];
    $uname = $_POST['uname'];
    $mobile = $_POST['mobile'];
    $pswd = $_POST['psw'];
    $fullname = $_POST['fullname'];

    $con = mysqli_connect("pxukqohrckdfo4ty.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "r42xjjzx0hy6jn0q", "bjv1aq1p3q3was3o", "uy2phg3cofsy8520");
    if (mysqli_connect_errno()) {
        die("Could not connect" . mysqli_connect_error());
    } else {
        $query = mysqli_query($con, "SELECT * FROM user WHERE email = '" . $em . "';");
        if (mysqli_num_rows($query) > 0) {
            echo "<script>
            document.getElementById('emailexistsWarning').innerHTML='Email already exists<br><br>';
            document.getElementById('signupform').style.display='block';
            </script>";
        } else {
            echo "<script>document.getElementById('emailexistsWarning').innerHTML=''</script>";

            // Check if the username already exists
            $query = mysqli_query($con, "SELECT * FROM user WHERE username = '" . $uname . "';");
            if (mysqli_num_rows($query) > 0) {
                echo "<script>
                document.getElementById('userNameExists').innerHTML='Username already exists<br><br>';
                document.getElementById('signupform').style.display='block';
                </script>";
            } else {
                echo "<script>document.getElementById('userNameExists').innerHTML=''</script>";

                // Assume you have already validated and sanitized the user inputs
                $em = $_POST['Email'];
                $uname = $_POST['uname'];
                $mobile = $_POST['mobile'];
                $pswd = $_POST['psw'];
                $fullname = $_POST['fullname'];

                // Hash the password using password_hash
                $hashed_password = password_hash($pswd, PASSWORD_DEFAULT);

                $con = mysqli_connect("pxukqohrckdfo4ty.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "r42xjjzx0hy6jn0q", "bjv1aq1p3q3was3o", "uy2phg3cofsy8520");
                if (mysqli_connect_errno()) {
                    die("Could not connect" . mysqli_connect_error());
                }

                // Use a prepared statement
                $stmt = $con->prepare("INSERT INTO user (email, username, mobile, password, fullname) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssdss", $em, $uname, $mobile, $hashed_password, $fullname);

                if ($stmt->execute()) {
                    echo "<script>window.alert('Registered Successfully');</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
                $con->close();

                            }
        }
    }
}
?>

</div>