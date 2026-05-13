<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once __DIR__ . '/../config/db.php';

$category = $_GET['category'] ?? 'all';
$db = getDB();

try {
    if ($category === 'all') {
        $stmt = $db->query("
            SELECT m.*, c.slug as category_slug, c.name as category_name, c.emoji
            FROM menus m
            JOIN categories c ON m.category_id = c.id
            WHERE m.is_available = 1
            ORDER BY c.sort_order, m.id
        ");
    } else {
        $stmt = $db->prepare("
            SELECT m.*, c.slug as category_slug, c.name as category_name, c.emoji
            FROM menus m
            JOIN categories c ON m.category_id = c.id
            WHERE m.is_available = 1 AND c.slug = ?
            ORDER BY m.id
        ");
        $stmt->execute([$category]);
    }
    $menus = $stmt->fetchAll();

    $catStmt = $db->query("SELECT * FROM categories ORDER BY sort_order");
    $categories = $catStmt->fetchAll();

    echo json_encode(['success' => true, 'categories' => $categories, 'menus' => $menus]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
