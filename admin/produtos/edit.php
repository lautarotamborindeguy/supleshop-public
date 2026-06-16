<?php
$baseUrl = '../../';
$pageTitle = 'Editar produto';

require_once '../../includes/auth.php';
require_once '../../includes/db.php';

requireLogin('../../login.php');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$errors = [];
$product = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id LIMIT 1');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch();
}

$categoriesStmt = $pdo->query('SELECT id, name FROM categories ORDER BY name');
$categories = $categoriesStmt->fetchAll();

if (!$product) {
    require_once '../../includes/header.php';
    ?>

    <main class="main-content page-shell">
        <section class="admin-section">
            <h1>Produto nao encontrado</h1>
            <p class="empty-message">O produto informado nao existe ou foi removido.</p>
            <a class="btn btn-primary" href="index.php">Voltar para listagem</a>
        </section>
    </main>

    <?php
    require_once '../../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product['name'] = trim($_POST['name'] ?? '');
    $product['description'] = trim($_POST['description'] ?? '');
    $product['price'] = trim($_POST['price'] ?? '');
    $product['stock'] = trim($_POST['stock'] ?? '');
    $product['category_id'] = trim($_POST['category_id'] ?? '');
    $product['image'] = trim($_POST['image'] ?? '');
    $product['active'] = isset($_POST['active']) ? 1 : 0;

    if ($product['name'] === '') {
        $errors[] = 'Informe o nome do produto.';
    }

    if ($product['description'] === '') {
        $errors[] = 'Informe a descricao do produto.';
    }

    if ($product['price'] === '' || !is_numeric($product['price']) || (float) $product['price'] <= 0) {
        $errors[] = 'Informe um preco numerico maior que zero.';
    }

    if ($product['stock'] === '' || !is_numeric($product['stock']) || (int) $product['stock'] < 0) {
        $errors[] = 'Informe um stock numerico maior ou igual a zero.';
    }

    if ($product['category_id'] === '') {
        $errors[] = 'Selecione uma categoria.';
    }

    if ($product['image'] === '') {
        $errors[] = 'Informe o nome da imagem.';
    }

    if (count($errors) === 0) {
        try {
            $stmt = $pdo->prepare("
                UPDATE products
                SET
                    category_id = :category_id,
                    name = :name,
                    description = :description,
                    price = :price,
                    stock = :stock,
                    image = :image,
                    active = :active
                WHERE id = :id
            ");

            $stmt->bindValue(':category_id', (int) $product['category_id'], PDO::PARAM_INT);
            $stmt->bindValue(':name', $product['name']);
            $stmt->bindValue(':description', $product['description']);
            $stmt->bindValue(':price', (float) $product['price']);
            $stmt->bindValue(':stock', (int) $product['stock'], PDO::PARAM_INT);
            $stmt->bindValue(':image', $product['image']);
            $stmt->bindValue(':active', (int) $product['active'], PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Nao foi possivel atualizar o produto. Verifique os dados informados.';
        }
    }
}

require_once '../../includes/header.php';
?>

<main class="main-content page-shell">
    <section class="admin-section admin-form-section" aria-labelledby="edit-title">
        <div class="admin-page-header">
            <div>
                <span class="section-kicker">Produtos</span>
                <h1 id="edit-title">Editar produto</h1>
            </div>

            <a class="btn btn-outline" href="index.php">Voltar</a>
        </div>

        <?php if (count($errors) > 0): ?>
            <div class="alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form class="form-card product-form" action="edit.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Descricao</label>
                <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="price">Preco</label>
                    <input type="number" id="price" name="price" step="0.01" min="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="category_id">Categoria</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categories as $category): ?>
                            <option
                                value="<?php echo $category['id']; ?>"
                                <?php echo (int) $product['category_id'] === (int) $category['id'] ? 'selected' : ''; ?>
                            >
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Imagem</label>
                    <input type="text" id="image" name="image" placeholder="produto.jpg" value="<?php echo htmlspecialchars($product['image']); ?>" required>
                </div>
            </div>

            <label class="checkbox-field">
                <input type="checkbox" name="active" value="1" <?php echo (int) $product['active'] === 1 ? 'checked' : ''; ?>>
                Produto ativo
            </label>

            <button class="btn btn-primary" type="submit">Atualizar produto</button>
        </form>
    </section>
</main>

<?php require_once '../../includes/footer.php'; ?>
