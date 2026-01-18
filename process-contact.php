<?php
require_once 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Validate
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error'] = 'Please fill in all required fields';
        redirect(BASE_URL . '/index.php#contact');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email address';
        redirect(BASE_URL . '/index.php#contact');
    }
    
    // Insert into database
    try {
        $stmt = $db->prepare("
            INSERT INTO contact_messages (name, email, phone, subject, message, ip_address) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $email, $phone, $subject, $message, $ip_address]);
        
        $_SESSION['success'] = 'Thank you for your message! We will contact you soon.';
        
        // Optional: Send email notification to admin
        // mail(ADMIN_EMAIL, "New Contact Message: $subject", $message, "From: $email");
        
    } catch (Exception $e) {
        $_SESSION['error'] = 'Failed to send message. Please try again.';
    }
    
    redirect(BASE_URL . '/index.php#contact');
} else {
    redirect(BASE_URL . '/index.php');
}