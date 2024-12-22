<?php
include_once('includes/connect.php'); // ndryshim sepse nuk eshte eficente te besh vetem include


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    global $con;

    // Sanitize and validate input
    $name = mysqli_real_escape_string($con, trim($_POST['username']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $password = mysqli_real_escape_string($con, trim($_POST['password']));
    $confirmPassword = mysqli_real_escape_string($con, trim($_POST['conf_password']));
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);

    // Regular expressions for validation
    $nameRegex = "/^[a-zA-Z ]{3,20}$/"; // Name must be between 3-20 characters, letters and spaces only
    $passwordRegex = "/^[a-zA-Z0-9-_ ]{4,}$/"; // Password must be at least 4 characters, alphanumeric, with optional special chars

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
    $query_insert = "INSERT INTO users (username, email, password, role_id,role_name) VALUES ('$name', '$email', '$passwordHashed', 1,'user')";
    $result_insert = mysqli_query($con, $query_insert);

    if (!$result_insert) {
        http_response_code(500);
        echo json_encode([
            "message" => "Internal Server Error: Unable to register user.",
            "error" => mysqli_error($con)
        ]);
        exit;
    } else {
        http_response_code(200);
        echo json_encode([
            "message" => "Useri u ruajt me sukses",
            "location" => "/" // Redirect to the homepage or another page
        ]);
        exit;
    }

    mysqli_close($con);
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

    session_start();

    $_SESSION['id'] = $row['user_id'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['date_time'] = time();
    $_SESSION['name'] = $row['username'];
    $_SESSION['role_name'] = $row['role_name'];

    mysqli_close($con);

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
                        email = '$email'" . 
                        ($fotoPath ? ", foto = '$fotoPath'" : "") . 
                        " WHERE user_id = $id";

        if (mysqli_query($con, $updateQuery)) {
            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
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
    }


else {
    http_response_code(405); // Invalid method
    echo json_encode(["message" => "Invalid request method."]);
}
?>
