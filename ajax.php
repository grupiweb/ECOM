<?php
// Start the session if it has not been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('includes/connect.php'); // ndryshim sepse nuk eshte eficente te besh vetem include

require './libraries/phpmailer/Exception.php';
require './libraries/phpmailer/PHPMailer.php';
require './libraries/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$GMAIL_ADDRESS = 'grupiweb@gmail.com';
$GMAIL_ADDRESS_PASSWORD = 'amly jexm cjfv amez';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $con;

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'register') {
            // Sanitize and validate input
            $name = mysqli_real_escape_string($con, trim($_POST['name']));
            $surname = mysqli_real_escape_string($con, trim($_POST['surname']));
            $name = mysqli_real_escape_string($con, trim($_POST['username']));
            $email = mysqli_real_escape_string($con, trim($_POST['email']));
            $password = mysqli_real_escape_string($con, trim($_POST['password']));
            $confirmPassword = mysqli_real_escape_string($con, trim($_POST['conf_password']));
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

            // Regular expressions for validation
            $nameRegex = "/^[a-zA-Z ]{3,20}$/"; // Name must be between 3-20 characters, letters and spaces only
            $passwordRegex = "/^[a-zA-Z0-9-_ ]{4,}$/"; // Password must be at least 4 characters, alphanumeric, with optional special chars

            // Validate first name
            if (!preg_match($nameRegex, $name)) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Emri vetem karaktere, minimumi 3",
                    "tagError" => "nameError",
                    "tagElement" => "name"
                ]);
                exit;
            }

            // Validate surname
            if (!preg_match($nameRegex, $surname)) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Mbiemri vetem karaktere, minimumi 3",
                    "tagError" => "surnameError",
                    "tagElement" => "surname"
                ]);
                exit;
            }

            // Validate name
            if (!preg_match($nameRegex, $name)) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Emri vetem karaktere, minimumi 3",
                    "tagError" => "nameError",
                    "tagElement" => "name"
                ]);
                exit;
            }

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Email nuk eshte i sakte",
                    "tagError" => "emailError",
                    "tagElement" => "email"
                ]);
                exit;
            }

            // Validate password
            if (empty($password) || strlen($password) < 4) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Passwordi minimumi 4 karaktere.",
                    "tagError" => "passwordError",
                    "tagElement" => "password"
                ]);
                exit;
            }

            // Check if password and confirm password match
            if ($password !== $confirmPassword) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Passwordi dhe confirm password te barabarta.",
                    "tagError" => "passwordError",
                    "tagElement" => "password"
                ]);
                exit;
            }

            // Check if the email already exists in the database
            $query_check = "SELECT user_id FROM users WHERE email = '$email'";
            $result_check = mysqli_query($con, $query_check);

            if (!$result_check) {
                http_response_code(500);
                echo json_encode([
                    "message" => "Internal Server Error: Unable to check for existing user.",
                    "error" => mysqli_error($con)
                ]);
                exit;
            }

            if (mysqli_num_rows($result_check) > 0) {
                http_response_code(203);
                echo json_encode([
                    "message" => "Ekziston nje user me kete email",
                    "tagError" => "emailError",
                    "tagElement" => "email"
                ]);
                exit;
            }

            // Insert the new user into the database
            $query_insert = "INSERT INTO users (name, surname, username, email, password, role_id, role_name, verified) VALUES ('$name', '$surname', '$name', '$email', '$passwordHashed', 1, 'user', 0)";
            $result_insert = mysqli_query($con, $query_insert);

            if (!$result_insert) {
                http_response_code(500);
                echo json_encode([
                    "message" => "Internal Server Error: Unable to register user.",
                    "error" => mysqli_error($con)
                ]);
                exit;
            }

            // Fetch the newly created user
            $user_id = mysqli_insert_id($con);
            $query_user = "SELECT * FROM users WHERE user_id = '$user_id'";
            $result_user = mysqli_query($con, $query_user);

            if (!$result_user) {
                http_response_code(500);
                echo json_encode([
                    "message" => "Internal Server Error: Unable to fetch user.",
                    "error" => mysqli_error($con)
                ]);
                exit;
            }

            $row = mysqli_fetch_assoc($result_user);

            // Generate a 6-digit verification code
            $verificationCode = rand(100000, 999999);
            
            // Get the current time and set expiration date (1 hour from now)
            $expirationDate = date("Y-m-d H:i:s", strtotime("+24 hour"));

            // Store the verification code and expiration date in the database
            $query_insert_code = "UPDATE users SET verification_code = '$verificationCode', code_expiration = '$expirationDate' WHERE email = '$email'";
            $result_insert_code = mysqli_query($con, $query_insert_code);

            if (!$result_insert_code) {
                http_response_code(500);
                echo json_encode([
                    "message" => "Internal Server Error: Unable to store verification code.",
                    "error" => mysqli_error($con)
                ]);
                exit;
            }

            // Email setup using PHPMailer
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $GMAIL_ADDRESS ; // Your email address
                $mail->Password = $GMAIL_ADDRESS_PASSWORD; // Your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('your-email@gmail.com', 'Mailer');
                $mail->addAddress($email, $name);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body    = "Your 6-digit verification code is: <b>$verificationCode</b>";

                $mail->send();
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    "message" => "Could not send verification email. Please try again later.",
                    "error" => $mail->ErrorInfo
                ]);
                exit;
            }

            // Log in the user to the session
            $_SESSION['id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['date_time'] = time();
            $_SESSION['name'] = $row['username'];
            $_SESSION['role_name'] = $row['role_name'];
            $_SESSION['verified'] = $row['verified'];

            // Success response
            http_response_code(200);
            echo json_encode([
                "message" => "Useri u ruajt me sukses. Verifikimi i email-it eshte derguar.",
                "location" => "./verify.php"  // Redirect to verification page
            ]);
            exit;

            mysqli_close($con);
        } elseif ($_POST['action'] == "verifyCode") {
            if (!isset($_SESSION['email'])) {
                http_response_code(400);
                echo json_encode([
                    "message" => "Email not found in session."
                ]);
                exit;
            }

            $email = mysqli_real_escape_string($con, trim($_SESSION['email']));
            $verificationCode = mysqli_real_escape_string($con, trim($_POST['verificationCode']));

            // Check if the verification code is correct and not expired
            $query_check_code = "SELECT user_id FROM users WHERE email = '$email' AND verification_code = '$verificationCode' AND code_expiration > NOW()";
            $result_check_code = mysqli_query($con, $query_check_code);

            if (mysqli_num_rows($result_check_code) > 0) {
                // Update the user as verified
                $query_update_verified = "UPDATE users SET verified = 1 WHERE email = '$email'";
                mysqli_query($con, $query_update_verified);

                http_response_code(200);
                echo json_encode([
                    "message" => "Email verified successfully."
                ]);
            } else {
                http_response_code(400);
                echo json_encode([
                    "message" => "Invalid or expired verification code."
                ]);
            }
            exit;
        } elseif($_POST['action'] == "login"){
            $email = mysqli_real_escape_string($con,trim($_POST['email']));
            $password = mysqli_real_escape_string($con,trim($_POST['password']));

            if (empty($password) || strlen($password) < 4) {
                http_response_code(203);
                echo json_encode(
                    array(
                        "message" => "Passwordi minimumi 4 karaktere.",
                        "tagError" => "passwordError",
                        "tagElement" => "password"
                    ));
                exit;
            }
            
            // Kontrollojme nese useri ekziston ne db me email dhe pass

            $query_check = "SELECT 
                                users.user_id, 
                                users.username, 
                                users.email, 
                                users.password, 
                                users.role_id, 
                                users.verified,
                                roles.name AS role_name
                            FROM 
                                users 
                            LEFT JOIN 
                                roles ON users.role_id = roles.id
                            WHERE 
                                users.email = '".$email."';";


            $result_check = mysqli_query($con, $query_check);

            if (!$result_check){
                http_response_code(500);
                echo json_encode(
                    array(
                        "message" => "Internal Server Error",
                        "error" => mysqli_error($con)
                    ));
                exit;
            }

            // nese nuk ekziston nje user me kete email
            if (mysqli_num_rows($result_check) == 0 ){
                http_response_code(203);
                echo json_encode(
                    array(
                        "message" => "Nuk ka user me kete email/nr"
                    ));
                exit;
            }

            $row = mysqli_fetch_assoc($result_check);

            // Handle missing role
            if (empty($row['role_name'])) {
            $row['role_name'] = 'user'; // Default role name if role is missing
            }
            
            
            $passwordHashed = $row['password'];

            // verifikimi i password
            if (!password_verify($password, $passwordHashed)) {
                http_response_code(203);
                echo json_encode(
                    array(
                        "message" => "Passwordi/Email te pasakte."
                    ));
                exit;
            }

            // Suppress the notice for session_start() if a session is already active
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['date_time'] = time();
            $_SESSION['name'] = $row['username'];
            $_SESSION['role_name'] = $row['role_name'];
            $_SESSION['verified'] = $row['verified'];

            mysqli_close($con);

            // Redirect to verification page if the user is not verified
            if ($row['verified'] == 0) {
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "message" => "User logged in but email not verified.",
                    "location" => "./verify.php"
                ]);
                exit;
            }

            // Nese eshte admin location eshte lista e userave
            // nese eshte user location eshte profili 
            $location = "index.php";
            if ($row['role_id'] != 1){
                $location = "./admin_manage/index.php";   
            }

            http_response_code(200);
            echo json_encode(
                array(
                    "success" => true,
                    "message" => "Useri logged in",
                    "location" => $location
                ));
            exit;



        }elseif($_POST['action'] == "updateUser"){
                // Handling user update logic
                $id = intval($_POST['id']);
                $name = mysqli_real_escape_string($con, $_POST['name']);
                $surname = mysqli_real_escape_string($con, $_POST['surname']);
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $email = mysqli_real_escape_string($con, $_POST['email']);

                // Validation rules for user fields
                if (!preg_match("/^[A-Z][a-zA-Z ]{2,19}$/", $name)) {
                    echo json_encode(['status' => 'error', 'message' => 'Name must start with a capital letter and be 3-20 characters long.']);
                    exit;
                }

                if (!preg_match("/^[A-Z][a-zA-Z ]{2,19}$/", $surname)) {
                    echo json_encode(['status' => 'error', 'message' => 'Surname must start with a capital letter and be 3-20 characters long.']);
                    exit;
                }

                if (empty($username)) {
                    echo json_encode(['status' => 'error', 'message' => 'Username cannot be empty.']);
                    exit;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo json_encode(['status' => 'error', 'message' => 'Enter a valid email address.']);
                    exit;
                }

                // Check email uniqueness
                $checkQuery = "SELECT user_id FROM users WHERE email = '$email' AND user_id != $id";
                $checkResult = mysqli_query($con, $checkQuery);
                if (mysqli_num_rows($checkResult) > 0) {
                    echo json_encode(['status' => 'error', 'field' => 'email', 'message' => 'Try another email.']);
                    exit;
                }

                // Handle file upload (if any)
                $fotoPath = null;
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                    $uploadDir = "uploads/";
                    $fotoPath = $uploadDir . basename($_FILES['foto']['name']);
                    move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath);
                }

                // Update query for user data
                $updateQuery = "UPDATE users SET 
                                name = '$name', 
                                surname = '$surname', 
                                username = '$username', 
                                email = '$email', 
                                verified = 0" . 
                                ($fotoPath ? ", foto = '$fotoPath'" : "") . 
                                " WHERE user_id = $id";

                if (mysqli_query($con, $updateQuery)) {
                    // Generate a new verification code
                    $verificationCode = rand(100000, 999999);
                    $expirationDate = date("Y-m-d H:i:s", strtotime("+24 hour"));
                    $query_update_code = "UPDATE users SET verification_code = '$verificationCode', code_expiration = '$expirationDate' WHERE user_id = $id";
                    mysqli_query($con, $query_update_code);

                    // Send verification email
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = $GMAIL_ADDRESS;
                        $mail->Password = $GMAIL_ADDRESS_PASSWORD;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        $mail->setFrom('your-email@gmail.com', 'Mailer');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Your Verification Code';
                        $mail->Body    = "Your 6-digit verification code is: <b>$verificationCode</b>";
                        $mail->send();
                    } catch (Exception $e) {
                        echo json_encode(['status' => 'error', 'message' => 'Could not send verification email.']);
                        exit;
                    }

                    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully. Verification email sent.', 'redirect' => './verify.php']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Database update failed: ' . mysqli_error($con)]);
                }
            }elseif (isset($_POST['action']) && $_POST['action'] == 'updatePassword') {
                // Handle password update logic
                $userId = intval($_POST['id']);
                $currentPassword = mysqli_real_escape_string($con, $_POST['currentPassword']);
                $newPassword = mysqli_real_escape_string($con, $_POST['newPassword']);

                // Fetch the user's current password hash
                $query = "SELECT password FROM users WHERE user_id = '$userId'";
                $result = mysqli_query($con, $query);

                if (!$result) {
                    echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . mysqli_error($con)]);
                    exit;
                }

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $hashedPassword = $row['password'];

                    // Validate the current password
                    if (password_verify($currentPassword, $hashedPassword)) {
                        // Check if the new password meets the length requirement
                        if (strlen($newPassword) < 8) {
                            echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long.']);
                            exit;
                        }

                        // Hash the new password
                        $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                        // Update the password in the database
                        $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE user_id = '$userId'";
                        if (mysqli_query($con, $updateQuery)) {
                            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
                        } else {
                            echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
                        }
                    } else {
                        // Invalid current password
                        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
                    }
                } else {
                    // User not found
                    echo json_encode(['status' => 'error', 'message' => 'User not found.']);
                }
            } elseif ($_POST['action'] === 'resendVerification') {
                if (!isset($_SESSION['email'])) {
                    http_response_code(400);
                    echo json_encode([
                        "message" => "Email not found in session."
                    ]);
                    exit;
                }

                $email = mysqli_real_escape_string($con, trim($_SESSION['email']));

                // Generate a new 6-digit verification code
                $verificationCode = rand(100000, 999999);
                
                // Get the current time and set expiration date (1 hour from now)
                $expirationDate = date("Y-m-d H:i:s", strtotime("+24 hour"));

                // Store the new verification code and expiration date in the database
                $query_update_code = "UPDATE users SET verification_code = '$verificationCode', code_expiration = '$expirationDate' WHERE email = '$email'";
                $result_update_code = mysqli_query($con, $query_update_code);

                if (!$result_update_code) {
                    http_response_code(500);
                    echo json_encode([
                        "message" => "Internal Server Error: Unable to store verification code.",
                        "error" => mysqli_error($con)
                    ]);
                    exit;
                }

                // Email setup using PHPMailer
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $GMAIL_ADDRESS; // Your email address
                    $mail->Password = $GMAIL_ADDRESS_PASSWORD; // Your email password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    //Recipients
                    $mail->setFrom('your-email@gmail.com', 'Mailer');
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Verification Code';
                    $mail->Body    = "Your new 6-digit verification code is: <b>$verificationCode</b>";

                    $mail->send();
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode([
                        "message" => "Could not send verification email. Please try again later.",
                        "error" => $mail->ErrorInfo
                    ]);
                    exit;
                }

                // Success response
                http_response_code(200);
                echo json_encode([
                    "message" => "Verification email sent successfully."
                ]);
                exit;
            }
        } else {
            http_response_code(405); // Invalid method
            echo json_encode(["message" => "Invalid request method."]);
        }
}
?>
