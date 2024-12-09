<?php
include('includes/connect.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    global $con;

    // Sanitize and validate input
    $name = mysqli_real_escape_string($con, trim($_POST['user_username']));
    $email = mysqli_real_escape_string($con, trim($_POST['user_email']));
    $password = mysqli_real_escape_string($con, trim($_POST['user_password']));
    $confirmPassword = mysqli_real_escape_string($con, trim($_POST['conf_user_password']));
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
    $query_insert = "INSERT INTO users (username, email, password, role) VALUES ('$name', '$email', '$passwordHashed', 1)";
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

    mysqli_close($conn);
} else {
    http_response_code(405); // Invalid method
    echo json_encode(["message" => "Invalid request method."]);
}
?>
