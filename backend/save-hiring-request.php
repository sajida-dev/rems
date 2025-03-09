<?php

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    redirect("login.php?page=request-services&agent_id=" . $_GET['agent_id'], "Please log in to request services.", 'error');
}

$user_id = intval($_SESSION['id']);
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    $transaction_type  = trim($_POST['transaction_type'] ?? '');
    $property_category = intval($_POST['property_category'] ?? 0);
    $location          = trim($_POST['location'] ?? '');
    $min_budget        = floatval($_POST['min_budget'] ?? 0);
    $max_budget        = floatval($_POST['max_budget'] ?? 0);
    $bedrooms          = intval($_POST['bedrooms'] ?? 0);
    $requirements      = trim($_POST['requirements'] ?? '');
    $agent_id = intval($_GET['agent_id']);

    $errors = [];
    if (empty($transaction_type)) {
        $errors[] = "Please select a transaction type.";
    }
    if ($property_category <= 0) {
        $errors[] = "Please select a property category.";
    }
    if (empty($location)) {
        $errors[] = "Location is required.";
    }
    if ($min_budget <= 0 && $max_budget <= 0) {
        $errors[] = "Please enter a valid budget range.";
    }
    if (empty($requirements)) {
        $errors[] = "Please describe your requirements.";
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        redirect("request-services.php?agent_id=" . $_GET['agent_id']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO hiring_requests (user_id, agent_id, transaction_type, property_category, location, min_budget, max_budget, bedrooms, requirements, created_at) VALUES (:user_id, :agent_id, :transaction_type, :property_category, :location, :min_budget, :max_budget, :bedrooms, :requirements, NOW())");
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":agent_id", $agent_id, PDO::PARAM_INT);
        $stmt->bindParam(":transaction_type", $transaction_type);
        $stmt->bindParam(":property_category", $property_category, PDO::PARAM_INT);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":min_budget", $min_budget);
        $stmt->bindParam(":max_budget", $max_budget);
        $stmt->bindParam(":bedrooms", $bedrooms, PDO::PARAM_INT);
        $stmt->bindParam(":requirements", $requirements);
        $stmt->execute();

        require_once 'vendor/autoload.php';

        require_once "dashboard/components/config-php-mailer.php";

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // Sender and recipient
        $mail->setFrom('saadzaib1123@gmail.com', 'Real Estate Website');
        $mail->addAddress('sajidajavaid640@gmail.com', 'Agent Name'); // Get agent email from your database if necessary

        // Subject and body
        $mail->Subject = "New Hiring Request from User #$user_id";

        $mail->Body    = "
            <p>A new hiring request has been submitted:</p>
            <p><strong>Transaction Type:</strong> $transaction_type</p>
            <p><strong>Property Category:</strong> $property_category</p>
            <p><strong>Location:</strong> $location</p>
            <p><strong>Budget Range:</strong> $min_budget - $max_budget</p>
            <p><strong>Bedrooms:</strong> $bedrooms</p>
            <p><strong>Requirements:</strong><br>$requirements</p>
            <p>Please follow up with the user as soon as possible.</p>
        ";

        if (!$mail->send()) {
            throw new Exception("Mailer Error: " . $mail->ErrorInfo);
            redirect("request-services.php?agent_id=" . $_GET['agent_id'], $mail->ErrorInfo, "error");
        }


        $_SESSION['msg'] = "Your request has been submitted successfully. An agent will contact you soon.";

        redirect('properties.php', $_SESSION['msg']);
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        // echo $_SESSION['error'];
        // exit;
        redirect("request-services.php?agent_id=" . $_GET['agent_id'], $_SESSION['error'], "error");
    }
endif;
