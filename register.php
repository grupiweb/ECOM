<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="style_reg.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  
  <script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    function register_user(event) {
        event.preventDefault(); // Prevent form submission

        var name = $("#username").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var confirmPassword = $("#conf_password").val();
        var termsAccepted = $("#terms").is(":checked");

        var nameRegex = /^[a-zA-Z ]{3,20}$/;
        var passwordRegex = /^[a-zA-Z0-9-_ ]{4,}$/;

        var error = 0;
        
        // Validate name
if (!nameRegex.test(name)) {
    $("#username").addClass("error"); // Add error styling to the input
    $("#usernameError").text("Emri vetem karaktere, minimumi 3"); // Show error message
    error++;
} else {
    $("#username").removeClass("error"); // Remove error styling
    $("#usernameError").text(""); // Clear the error message (but keep space)
}

// Validate email
if (isEmpty(email)) {
    $("email").addClass("error");
    $("#emailError").text("Email nuk mund te jete bosh");
    error++;
} else {
    $("#user_email").removeClass("error");
    $("#emailError").text(""); // Clear the error message
}

// Validate terms acceptance
if (!$("#terms").is(":checked")) {
    $("#termsError").text("Duhet te pranoni termat dhe kushtet"); // Show error
    error++;
} else {
    $("#termsError").text(""); // Clear the error
}

// Validate password
if (!passwordRegex.test(password)) {
    $("password").addClass("error");
    $("#passwordError").text("Password duhet minimumi 4 karaktere");
    error++;
} else if (password !== confirmPassword) {
    $("#password").addClass("error");
    $("#conf_password").addClass("error");
    $("#passwordError").text("Passwordet nuk jane te barabarta");
    $("#confirmPasswordError").text("Passwordet nuk jane te barabarta");
    error++;
} else {
    $("#password").removeClass("error");
    $("#conf_password").removeClass("error");
    $("#passwordError").text(""); // Clear error
    $("#confirmPasswordError").text(""); // Clear error
}

        // If no errors, proceed with AJAX
        if (error == 0) {
            var data = new FormData();
            data.append("action", "register");
            data.append("username", name);
            data.append("email", email);
            data.append("password", password);
            data.append("conf_password", confirmPassword);

            // AJAX call to the backend
            $.ajax({
                type: "POST",
                url: "ajax.php",
                async: false,
                cache: false,
                processData: false,
                data: data,
                contentType: false,
                success: function (response, status, call) {
                    response = JSON.parse(response);
                    console.log(response);

                    if (call.status == 200) {
                        toastr.success(response.message); // Use toastr for success message
                        setTimeout(function () {
                            window.location.href = response.location;
                        }, 2500);
                    } else {
                        $("#" + response.tagError).text(response.message); // Display validation errors
                        $("#" + response.tagElement).addClass('error'); // Highlight error field
                    }
                },
                error: function () {
                    showMessage("An error occurred. Please try again.", "error");
                }
            });
        }
    }

    function isEmpty(value) {
    // Ensure value is a string before calling trim
    return (value === undefined || value === null || value.trim() === "");
}


    // Show message function to display custom messages (like error messages)
    function showMessage(message, type) {
        const messageElement = $("<div>").addClass("message " + type).text(message);
        $("body").append(messageElement);
        setTimeout(() => messageElement.fadeOut(() => messageElement.remove()), 3000);
    }
</script>

</head>
<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <form id="registrationForm" onsubmit="register_user(event);" novalidate>
      <div class="input-box">
        <input type="text" id="username" placeholder="Enter your username" name="username">
        <span id="usernameError" class="error-message"></span>
      </div>
      <div class="input-box">
        <input type="text" id="email" name="email" placeholder="Enter your email">
        <span id="emailError" class="error-message"></span>
      </div>
      <div class="input-box">
        <input type="password" id="password" name="password" placeholder="Create password">
        <span id="passwordError" class="error-message"></span>
      </div>
      <div class="input-box">
        <input type="password" id="conf_password" name="conf_password" placeholder="Confirm password">
        <span id="confirmPasswordError" class="error-message"></span>
      </div>
      <div class="policy">
  <input type="checkbox" id="terms">
  <h3>I accept all terms & conditions</h3>
</div>
<div id="termsError" class="error-message"></div>
<div class="input-box button">
  <input type="submit" value="Register Now">
</div>
<div class="text">
  <h3>Already have an account? <a href="login.php">Login here</a></h3>
</div>

    </form>
  </div>
</body>
</html>
