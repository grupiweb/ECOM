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

        var name = $("#user_username").val();
        var email = $("#user_email").val();
        var password = $("#user_password").val();
        var confirmPassword = $("#conf_user_password").val();

        var nameRegex = /^[a-zA-Z ]{3,20}$/;
        var passwordRegex = /^[a-zA-Z0-9-_ ]{4,}$/;

        var error = 0;
        
        // Validate name
        if (!nameRegex.test(name)) {
            $("#user_username").addClass('error');
            $("#nameError").text("Emri vetem karaktere, minimumi 3");
            error++;
        } else {
            $("#user_username").removeClass('error');
            $("#nameError").text("");
        }

        // Validate email
        if (isEmpty(email)) {
            $("#user_email").addClass('error');
            $("#emailError").text("Email nuk mund te jete bosh");
            error++;
        } else {
            $("#user_email").removeClass('error');
            $("#emailError").text("");
        }

        // Validate password
        if (!passwordRegex.test(password)) {
            $("#user_password").addClass('error');
            $("#passwordError").text("Password ka minimumi 4 karaktere");
            error++;
        } else if (password != confirmPassword) {
            $("#user_password").addClass('error');
            $("#confirm-password").addClass('error');
            $("#passwordError").text("Passwordet nuk jane te barabarta");
            $("#confirmPasswordError").text("Passwordet nuk jane te barabarta");
            error++;
        } else {
            $("#user_password").removeClass('error');
            $("#confirm-password").removeClass('error');
            $("#passwordError").text("");
            $("#confirmPasswordError").text("");
        }

        // If no errors, proceed with AJAX
        if (error == 0) {
            var data = new FormData();
            data.append("action", "register");
            data.append("user_username", name);
            data.append("user_email", email);
            data.append("user_password", password);
            data.append("conf_user_password", confirmPassword);

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
        <input type="text" id="user_username" placeholder="Enter your username" name="user_username">
        <span id="usernameError" class="error-message"></span>
      </div>
      <div class="input-box">
        <input type="text" id="user_email" name="user_email" placeholder="Enter your email">
        <span id="emailError" class="error-message"></span>
      </div>
      <div class="input-box">
        <input type="password" id="user_password" name="user_password" placeholder="Create password">
        <span id="passwordError" class="error-message"></span>
      </div>
      <div class="input-box">
        <input type="password" id="conf_user_password" name="conf_user_password" placeholder="Confirm password">
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
    </form>
  </div>
</body>
</html>
