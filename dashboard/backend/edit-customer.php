<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"] ?? 0);
    $name = trim($_POST["customerName"] ?? '');
    $email = trim($_POST["customerEmail"] ?? '');
    $contact = trim($_POST["customerContact"] ?? '');

    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!empty($errors)) {
        $_SESSION["error_msg"] = implode("<br>", $errors);
        header("Location: ../update-customer.php?id=" . $id);
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, contact = :contact WHERE id = :id AND role = 'end-user'");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION["success_msg"] = "Customer updated successfully.";
        echo "<script>window.location.href = 'all-customers.php';</script>";
        // header("Location: ../all-customers.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION["error_msg"] = "Database error: " . $e->getMessage();
        echo "<script>window.location.href = 'update-customers.php?id='" . $id . ";</script>";
        // header("Location: ../update-customer.php?id=" . $id);
        exit;
    }
}
