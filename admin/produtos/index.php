<?php
$baseUrl = '../../';
$pageTitle = 'Listagem de produtos';

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
                <span class="section-kicker">Produtos</span>
                <h1 id="products-title">Listagem de produtos</h1>
            </div>

            <a class="btn btn-primary" href="create.php">Novo produto</a>
        </div>

        <form class="search-form" action="index.php" method="get">
            <label for="search">Buscar por produto ou categoria</label>
            <div class="search-row">
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Ex.: Whey, Creatinas"
                >
                <button class="btn btn-outline" type="submit">Buscar</button>
            </div>
        </form>

        <?php if (count($products) === 0): ?>
            <p class="empty-message">Nenhum produto encontrado.</p>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preco</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img
                                            class="product-thumb"
                                            src="../../assets/img/<?php echo htmlspecialchars($product['image']); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        >
                                    <?php else: ?>
                                        <span class="image-placeholder">Sem imagem</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td>R$ <?php echo number_format((float) $product['price'], 2, ',', '.'); ?></td>
                                <td><?php echo (int) $product['stock']; ?></td>
                                <td>
                                    <?php if ((int) $product['active'] === 1): ?>
                                        <span class="status-badge status-active">Ativo</span>
                                    <?php else: ?>
                                        <span class="status-badge status-inactive">Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="edit.php?id=<?php echo $product['id']; ?>">Editar</a>
                                        <a
                                            class="danger-link"
                                            href="delete.php?id=<?php echo $product['id']; ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir este produto?');"
                                        >
                                            Excluir
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
