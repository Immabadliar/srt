<?php
// Define form data variables
$fullName = $email = $whyJoin = $position = $experience = "";
$errors = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the full name
    if (empty($_POST["fullName"])) {
        $errors[] = "Full name is required.";
    } else {
        $fullName = sanitize_input($_POST["fullName"]);
    }

    // Validate the email address
    if (empty($_POST["email"])) {
        $errors[] = "Email address is required.";
    } else {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
    }

    // Validate the "Why Do You Want to Join?" answer
    if (empty($_POST["whyJoin"])) {
        $errors[] = "Please provide a reason for wanting to join.";
    } else {
        $whyJoin = sanitize_input($_POST["whyJoin"]);
    }

    // Validate position applying for
    if (empty($_POST["position"])) {
        $errors[] = "Please select the position you are applying for.";
    } else {
        $position = sanitize_input($_POST["position"]);
    }

    // Validate experience
    if (empty($_POST["experience"])) {
        $errors[] = "Please provide your experience.";
    } else {
        $experience = sanitize_input($_POST["experience"]);
    }

    // If no errors, proceed with the application
    if (empty($errors)) {
        // Send an email with the application details (you may customize this)
        $to = "lucacocchia1234@gmail.com"; // Replace with your desired email address
        $subject = "New Application: $fullName";
        $message = "
        New application received:

        Full Name: $fullName
        Email Address: $email
        Position Applying For: $position
        Why Do You Want to Join?: $whyJoin
        Experience: $experience
        ";
        $headers = "From: no-reply@hdasrt.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "<p>Thank you for applying! Your application has been submitted successfully.</p>";
        } else {
            echo "<p>Sorry, there was an error submitting your application. Please try again later.</p>";
        }
    } else {
        // Display errors
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
