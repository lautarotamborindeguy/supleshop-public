<?php
header('Content-Type: application/json; charset=utf-8');

require_once 'includes/db.php';

function jsonResponse(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(405, [
        'success' => false,
        'message' => 'Método no permitido.',
    ]);
}

$rawInput = file_get_contents('php://input');

try {
    $payload = json_decode($rawInput, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $exception) {
    jsonResponse(400, [
        'success' => false,
        'message' => 'No se pudo leer el pedido.',
    ]);
}

$items = $payload['items'] ?? [];

if (!is_array($items) || count($items) === 0) {
    jsonResponse(400, [
        'success' => false,
        'message' => 'El carrito está vacío.',
    ]);
}

$requestedItems = [];

foreach ($items as $item) {
    if (!is_array($item)) {
        jsonResponse(400, [
            'success' => false,
            'message' => 'El carrito contiene productos inválidos.',
        ]);
    }

    $productId = filter_var($item['id'] ?? null, FILTER_VALIDATE_INT);
    $quantity = filter_var($item['quantity'] ?? null, FILTER_VALIDATE_INT);

    if (!$productId || !$quantity || $productId <= 0 || $quantity <= 0) {
        jsonResponse(400, [
            'success' => false,
            'message' => 'El carrito contiene productos inválidos.',
        ]);
    }

    $requestedItems[$productId] = ($requestedItems[$productId] ?? 0) + $quantity;
}

try {
    $pdo->beginTransaction();

    $ids = array_keys($requestedItems);
    $placeholders = [];
    $params = [];

    foreach ($ids as $index => $id) {
        $placeholder = ':id' . $index;
        $placeholders[] = $placeholder;
        $params[$placeholder] = $id;
    }

    $productsStmt = $pdo->prepare("
        SELECT id, name, stock
        FROM products
        WHERE active = 1
            AND id IN (" . implode(', ', $placeholders) . ")
        FOR UPDATE
    ");

    foreach ($params as $placeholder => $id) {
        $productsStmt->bindValue($placeholder, $id, PDO::PARAM_INT);
    }

    $productsStmt->execute();
    $products = [];

    foreach ($productsStmt->fetchAll() as $product) {
        $products[(int) $product['id']] = $product;
    }

    if (count($products) !== count($requestedItems)) {
        $pdo->rollBack();
        jsonResponse(409, [
            'success' => false,
            'message' => 'Uno o más productos ya no están disponibles.',
        ]);
    }

    $stockErrors = [];

    foreach ($requestedItems as $productId => $quantity) {
        $product = $products[$productId];
        $availableStock = (int) $product['stock'];

        if ($quantity > $availableStock) {
            $stockErrors[] = sprintf(
                '%s: disponible %d, solicitado %d',
                $product['name'],
                $availableStock,
                $quantity
            );
        }
    }

    if (count($stockErrors) > 0) {
        $pdo->rollBack();
        jsonResponse(409, [
            'success' => false,
            'message' => 'No hay stock suficiente para completar el pedido.',
            'errors' => $stockErrors,
        ]);
    }

    $updateStmt = $pdo->prepare('
        UPDATE products
        SET stock = stock - :quantity
        WHERE id = :id
            AND stock >= :quantity
    ');

    $updatedProducts = [];

    foreach ($requestedItems as $productId => $quantity) {
        $updateStmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $updateStmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $updateStmt->execute();

        if ($updateStmt->rowCount() !== 1) {
            $pdo->rollBack();
            jsonResponse(409, [
                'success' => false,
                'message' => 'El stock cambió mientras se procesaba el pedido. Intenta nuevamente.',
            ]);
        }

        $updatedProducts[] = [
            'id' => $productId,
            'name' => $products[$productId]['name'],
            'stock' => (int) $products[$productId]['stock'] - $quantity,
        ];
    }

    $pdo->commit();

    jsonResponse(200, [
        'success' => true,
        'message' => 'Stock actualizado correctamente.',
        'products' => $updatedProducts,
    ]);
} catch (PDOException $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    jsonResponse(500, [
        'success' => false,
        'message' => 'No fue posible procesar el pedido.',
    ]);
}
