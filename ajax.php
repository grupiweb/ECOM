<?php
include_once('includes/connect.php'); // ndryshim sepse nuk eshte eficente te besh vetem include


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

    mysqli_close($con);
}elseif($_POST['action'] == "login"){
    $email = mysqli_real_escape_string($con,trim($_POST['email_number']));
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

        $query_check = "SELECT user_id, username, email, password, role_id, roles.name as role_name
        FROM users 
        left join roles on users.role_id = roles.id
        WHERE email = '".$email."'; ";

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

    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['date_time'] = time();
    $_SESSION['name'] = $row['name'];

    mysqli_close($con);

    // Nese eshte admin location eshte lista e userave
    // nese eshte user location eshte profili 
    $location = "profile.php"; //nese kemi te bejme me nje user, per momentin ne kodin tone nuk kemi nje porfile.php po do ta bej ose un eose heidi
    if ($row['role_id'] != 1){
        $location = "users.php";   // nese kemi te bejme me nje admin, per momentin nuk kemi nje users.php 
    }

    http_response_code(200);
    echo json_encode(
        array(
            "message" => "Useri logged in",
            "location" => $location
        ));
    exit;



}else {
    http_response_code(405); // Invalid method
    echo json_encode(["message" => "Invalid request method."]);
}
?>
