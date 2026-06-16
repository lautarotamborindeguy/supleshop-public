<?php
$pageTitle = 'Produtos';

require_once 'includes/db.php';

$search = trim($_GET['search'] ?? '');
$selectedCategory = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
$selectedCategory = $selectedCategory && $selectedCategory > 0 ? $selectedCategory : '';

$categoriesStmt = $pdo->prepare('SELECT id, name FROM categories ORDER BY name');
$categoriesStmt->execute();
$categories = $categoriesStmt->fetchAll();

$sql = "
    SELECT
        products.id,
        products.name,
        products.description,
        products.price,
        products.stock,
        products.image,
        products.created_at,
        categories.name AS category_name
    FROM products
    INNER JOIN categories ON products.category_id = categories.id
    WHERE products.active = 1
";

$params = [];

if ($search !== '') {
    $sql .= " AND (products.name LIKE :search OR products.description LIKE :search OR categories.name LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if ($selectedCategory !== '') {
    $sql .= " AND products.category_id = :category_id";
    $params[':category_id'] = $selectedCategory;
}

$sql .= " ORDER BY products.name ASC";

$productsStmt = $pdo->prepare($sql);

foreach ($params as $key => $value) {
    if ($key === ':category_id') {
        $productsStmt->bindValue($key, $value, PDO::PARAM_INT);
    } else {
        $productsStmt->bindValue($key, $value);
    }
}

$productsStmt->execute();
$products = $productsStmt->fetchAll();

function shortDescription(?string $text, int $limit = 110): string
{
    $text = trim($text ?? '');

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($text, 'UTF-8') <= $limit) {
            return $text;
        }

        return mb_substr($text, 0, $limit, 'UTF-8') . '...';
    }

    if (strlen($text) <= $limit) {
        return $text;
    }

    return substr($text, 0, $limit) . '...';
}

require_once 'includes/header.php';
?>

<main class="main-content page-shell">
    <section class="catalog-section" aria-labelledby="catalog-title">
        <div class="catalog-header">
            <div>
                <span class="section-kicker">Catalogo</span>
                <h1 id="catalog-title">Produtos SupleStore</h1>
                <p>Escolha seus suplementos favoritos e adicione ao carrinho.</p>
            </div>
        </div>

        <form class="catalog-filter-form" action="produtos.php" method="get">
            <div class="form-group">
                <label for="search">Buscar produto</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Nome, descricao ou categoria"
                >
            </div>

            <div class="form-group">
                <label for="category">Categoria</label>
                <select id="category" name="category">
                    <option value="">Todas as categorias</option>
                    <?php foreach ($categories as $category): ?>
                        <option
                            value="<?php echo $category['id']; ?>"
                            <?php echo (int) $selectedCategory === (int) $category['id'] ? 'selected' : ''; ?>
                        >
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Filtrar</button>
        </form>

        <?php if (count($products) === 0): ?>
            <aside class="catalog-empty" aria-label="Sem resultados">
                <h2>Nenhum produto encontrado</h2>
                <p>Tente buscar por outro nome ou selecionar uma categoria diferente.</p>
            </aside>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <?php
                    $price = (float) $product['price'];
                    $priceInCents = (int) round($price * 100);
                    ?>

                    <article class="product-card">
                        <div class="product-image-box">
                            <?php if (!empty($product['image'])): ?>
                                <img
                                    src="assets/img/<?php echo htmlspecialchars($product['image']); ?>"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                                >
                            <?php else: ?>
                                <span>Sem imagem</span>
                            <?php endif; ?>
                        </div>

                        <div class="product-card-body">
                            <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                            <p><?php echo htmlspecialchars(shortDescription($product['description'])); ?></p>
                        </div>

                        <div class="product-card-footer">
                            <div>
                                <strong>R$ <?php echo number_format($price, 2, ',', '.'); ?></strong>
                                <span>Stock: <?php echo (int) $product['stock']; ?></span>
                            </div>

                            <button
                                class="btn btn-primary btn-add-cart"
                                type="button"
                                data-id="<?php echo $product['id']; ?>"
                                data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                data-price="<?php echo $priceInCents; ?>"
                                data-image="<?php echo htmlspecialchars($product['image']); ?>"
                            >
                                Agregar al carrito
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
