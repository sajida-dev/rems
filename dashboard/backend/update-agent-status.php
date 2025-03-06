<?php
require_once "../components/db_connection.php";
if (isset($_GET['id']) && isset($_GET['status'])) {
    $agent_id = $_GET['id'];
    $status = ($_GET['status'] == '0' ? '1' : '0');

    try {
        $stmt = $conn->prepare("UPDATE agent SET status = :status WHERE agent_id = :agent_id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':agent_id', $agent_id, PDO::PARAM_INT);

        $stmt->execute();

        redirect("../all-agents.php", "Agent status updated successfully!");
    } catch (PDOException $e) {
        redirect("../all-agents", "Error: " . $e->getMessage(), "error");
    }
}
