<?php
$baseUrl = '../../';
$pageTitle = 'Listado de productos';

require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireLogin('../../login.php');

$search = trim($_GET['search'] ?? '');
$params = [];

$sql = "
    SELECT
        products.id,
        products.name,
        products.price,
        products.stock,
        products.image,
        products.active,
        categories.name AS category_name
    FROM products
    INNER JOIN categories ON products.category_id = categories.id
";

if ($search !== '') {
    $sql .= " WHERE products.name LIKE :search OR categories.name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

$sql .= " ORDER BY products.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

require_once '../../includes/header.php';
?>

<main class="main-content page-shell">
    <section class="admin-section" aria-labelledby="products-title">
        <div class="admin-page-header">
            <div>
                <span class="section-kicker">Productos</span>
                <h1 id="products-title">Listado de productos</h1>
            </div>

            <a class="btn btn-primary" href="create.php">Nuevo producto</a>
        </div>

        <form class="search-form" action="index.php" method="get">
            <label for="search">Buscar por producto o categoría</label>
            <div class="search-row">
                <input type="search" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Ej.: Whey, Creatinas">
                <button class="btn" type="submit">Buscar</button>
            </div>
        </form>

        <?php if (count($products) === 0): ?>
            <p class="empty-message">No se encontró ningún producto.</p>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img class="product-thumb"
                                            src="../../assets/img/<?php echo htmlspecialchars($product['image']); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <?php else: ?>
                                        <span class="image-placeholder">Sin imagen</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td>$U <?php echo number_format((float) $product['price'], 2, ',', '.'); ?></td>
                                <td><?php echo (int) $product['stock']; ?></td>
                                <td>
                                    <?php if ((int) $product['active'] === 1): ?>
                                        <span class="status-badge status-active">Activo</span>
                                    <?php else: ?>
                                        <span class="status-badge status-inactive">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="edit.php?id=<?php echo $product['id']; ?>">Editar</a>
                                        <a class="danger-link" href="delete.php?id=<?php echo $product['id']; ?>"
                                            onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                                            Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>