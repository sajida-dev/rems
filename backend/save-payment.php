<?php

require_once 'vendor/autoload.php';
require_once 'components/db_connection.php';
require_once "components/notification.php";
\Stripe\Stripe::setApiKey('sk_test_51R0gnMCmRIcgkVt93JTky9fZMgslreOAdSw0GL2VeANrXGYZJaA6KjRvtIAStPMgvkg0KoVkK2s5M1DfjgtSio4R00SZwauCqW');
if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if (!isset($_SESSION['id'])) {
        redirect('register.php?id=' . $_GET['id'], 'Please log in before making a payment.', 'error');
        exit;
    }
}

$propertyId = (isset($_GET['id'])) ? intval($_GET['id']) : 0;

$sql = "SELECT p.id, pc.name AS category_name, u.name, p.category_id, p.title, p.location, p.rent_price, p.old_price, p.area, p.image_url, p.agent_id, p.status 
        FROM `properties` AS p
        LEFT JOIN `property_categories` AS pc ON pc.id=p.category_id
        LEFT JOIN `users` AS u ON u.id = p.agent_id
        WHERE p.id=:propertyId";

$statement = $conn->prepare($sql);
$statement->bindParam(':propertyId', $propertyId, PDO::PARAM_INT);
$statement->execute();
$property = $statement->fetch(PDO::FETCH_ASSOC);
$amount = (int)($property['rent_price'] * 99);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = intval($_SESSION['id']);
    $full_name = trim($_POST['full_name'] ?? '');
    $card_number = trim($_POST['card_number'] ?? '');
    $card_expiration = trim($_POST['card_expiration'] ?? '');
    $card_cvv = trim($_POST['card_cvv'] ?? '');

    // 5. Basic validation
    $errors = [];
    if (empty($full_name)) {
        $errors[] = "Full name is required.";
    }
    if (empty($card_number) || empty($card_expiration) || empty($card_cvv)) {
        $errors[] = "Card details are incomplete.";
    }

    if (!preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $card_expiration, $matches)) {
        $errors[] = "Card expiration must be in the format mm/yy.";
    } else {
        $expMonth = intval($matches[1]);
        $expYear = intval($matches[2]);

        $expYear += 2000;

        $expDate = DateTime::createFromFormat('Y-m-d', sprintf("%04d-%02d-%02d", $expYear, $expMonth, cal_days_in_month(CAL_GREGORIAN, $expMonth, $expYear)));
        $now = new DateTime();

        if ($expDate < $now) {
            $errors[] = "The card is expired.";
        }
    }

    if (!preg_match('/^\d{3,4}$/', $card_cvv)) {
        $errors[] = "CVV must be 3 or 4 digits.";
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        redirect('request-property-buy.php?id=' . $propertyId, 'Payment form error.', 'error');
        exit;
    }

    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'confirm' => false,
        ]);

        $transactionType = 'buy';
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, property_id, transaction_type, status) VALUES (:user_id, :property_id, :transaction_type, 'pending')");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':property_id', $propertyId, PDO::PARAM_INT);
        $stmt->bindParam(':transaction_type', $transactionType, PDO::PARAM_STR);
        $stmt->execute();
        $transaction_id = $conn->lastInsertId();

        $paymentMethod = 'credit_card';
        $amount = (float)$property['rent_price'];
        $stmt2 = $conn->prepare("INSERT INTO payments (transaction_id, amount, payment_method, stripe_payment_id, status) 
                                 VALUES (:transaction_id, :amount, :payment_method, :stripe_payment_id, 'pending')");
        $stmt2->bindParam(':transaction_id', $transaction_id, PDO::PARAM_INT);
        $stmt2->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt2->bindParam(':payment_method', $paymentMethod, PDO::PARAM_STR);
        $stmt2->bindParam(':stripe_payment_id', $paymentIntent->id, PDO::PARAM_STR);
        $stmt2->execute();
        $payment_id = $conn->lastInsertId();

        // 9. Optionally confirm the PaymentIntent with the PaymentMethod
        // In production, you would use the payment method id received from the front-end

        // $paymentIntent->confirm([
        //     'payment_method' => $paymentMethod->id,
        // ]);


        $stmt3 = $conn->prepare("UPDATE payments SET status = 'completed' WHERE id = :id");
        $stmt3->bindValue(':id', $payment_id, PDO::PARAM_INT);
        $stmt3->execute();

        $stmt = $conn->prepare("UPDATE transactions SET status = 'completed' WHERE id=:transaction_id");
        $stmt->bindParam(':transaction_id', $transaction_id, PDO::PARAM_INT);
        $stmt->execute();

        redirect('properties.php', 'Payment successful! Your total: $' . number_format($amount, 2));
    } catch (\Stripe\Exception\ApiErrorException $e) {
        $_SESSION['error'] = "Stripe error: " . $e->getMessage();
        redirect('request-property-buy.php', 'Payment failed.', 'error');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        redirect('request-property-buy.php', 'Payment failed.', 'error');
    }
}
