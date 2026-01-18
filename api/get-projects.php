<?php
require_once '../config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        SELECT * FROM projects 
        WHERE is_active = 1 
        ORDER BY display_order ASC, created_at DESC
        LIMIT 6
    ");
    $stmt->execute();
    $projects = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'projects' => $projects
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>