<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: GET, POST');
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];

// --- GET: lihat detail pesanan ---
if ($method === 'GET') {
    $id = (int)($_GET['id'] ?? 0);
    if (!$id) { echo json_encode(['success'=>false,'error'=>'ID pesanan tidak valid']); exit; }
    $db = getDB();
    $order = $db->prepare("SELECT * FROM orders WHERE id=?");
    $order->execute([$id]);
    $o = $order->fetch();
    if (!$o) { echo json_encode(['success'=>false,'error'=>'Pesanan tidak ditemukan']); exit; }
    $items = $db->prepare("SELECT * FROM order_items WHERE order_id=?");
    $items->execute([$id]);
    $o['items'] = $items->fetchAll();
    echo json_encode(['success'=>true,'order'=>$o]);
    exit;
}

// --- POST: buat pesanan baru ---
$body  = json_decode(file_get_contents('php://input'), true) ?? [];
$cart  = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo json_encode(['success'=>false,'error'=>'Keranjang kosong']); exit;
}

$name  = htmlspecialchars(trim($body['customer_name'] ?? ''), ENT_QUOTES, 'UTF-8');
$notes = htmlspecialchars(trim($body['notes'] ?? ''), ENT_QUOTES, 'UTF-8');
$total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));

$db = getDB();
try {
    $db->beginTransaction();
    $db->prepare("INSERT INTO orders (session_id, customer_name, notes, total_price, status) VALUES (?,?,?,?,'pending')")
       ->execute([session_id(), $name ?: null, $notes ?: null, $total]);
    $orderId = (int)$db->lastInsertId();

    $ins = $db->prepare("INSERT INTO order_items (order_id, menu_id, menu_name, price, qty, subtotal) VALUES (?,?,?,?,?,?)");
    foreach ($cart as $item) {
        $ins->execute([$orderId, $item['menu_id'], $item['name'], $item['price'], $item['qty'], $item['price'] * $item['qty']]);
    }

    $db->commit();
    $_SESSION['cart'] = [];
    echo json_encode(['success'=>true,'order_id'=>$orderId,'total'=>$total]);
} catch (PDOException $e) {
    $db->rollBack();
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
