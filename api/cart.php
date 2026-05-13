<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$method = $_SERVER['REQUEST_METHOD'];

// --- GET: return current cart ---
if ($method === 'GET') {
    $cart  = $_SESSION['cart'];
    $total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
    $count = array_sum(array_column($cart, 'qty'));
    echo json_encode(['success' => true, 'cart' => array_values($cart), 'total' => $total, 'count' => $count]);
    exit;
}

// --- POST: add / update / remove ---
$body   = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $body['action'] ?? $_POST['action'] ?? '';

if ($action === 'add') {
    $id  = (int)($body['menu_id'] ?? 0);
    $qty = (int)($body['qty']     ?? 1);
    if ($id <= 0) { echo json_encode(['success'=>false,'error'=>'menu_id invalid']); exit; }

    $db   = getDB();
    $stmt = $db->prepare("SELECT m.*, c.slug as category_slug, c.emoji FROM menus m JOIN categories c ON m.category_id=c.id WHERE m.id=? AND m.is_available=1");
    $stmt->execute([$id]);
    $menu = $stmt->fetch();
    if (!$menu) { echo json_encode(['success'=>false,'error'=>'Menu tidak ditemukan']); exit; }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$id] = [
            'menu_id'       => $menu['id'],
            'name'          => $menu['name'],
            'price'         => (int)$menu['price'],
            'category_slug' => $menu['category_slug'],
            'emoji'         => $menu['emoji'],
            'image'         => $menu['image'],
            'qty'           => $qty,
        ];
    }

} elseif ($action === 'update') {
    $id  = (int)($body['menu_id'] ?? 0);
    $qty = (int)($body['qty']     ?? 0);
    if ($qty <= 0) {
        unset($_SESSION['cart'][$id]);
    } elseif (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] = $qty;
    }

} elseif ($action === 'remove') {
    $id = (int)($body['menu_id'] ?? 0);
    unset($_SESSION['cart'][$id]);

} elseif ($action === 'clear') {
    $_SESSION['cart'] = [];

} else {
    echo json_encode(['success'=>false,'error'=>'Aksi tidak dikenal']); exit;
}

$cart  = $_SESSION['cart'];
$total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
$count = array_sum(array_column($cart, 'qty'));
echo json_encode(['success'=>true, 'cart'=>array_values($cart), 'total'=>$total, 'count'=>$count]);
