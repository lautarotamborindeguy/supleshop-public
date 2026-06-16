const CART_KEY = 'supleStoreCart';

function getCart() {
    const savedCart = localStorage.getItem(CART_KEY);

    if (!savedCart) {
        return [];
    }

    try {
        const parsedCart = JSON.parse(savedCart);
        return Array.isArray(parsedCart) ? parsedCart : [];
    } catch (error) {
        return [];
    }
}

function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function clearCart() {
    localStorage.removeItem(CART_KEY);
}

function formatPrice(priceInCents) {
    return (priceInCents / 100).toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

function escapeHTML(value) {
    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function updateCartCount() {
    const cart = getCart();
    const cartCount = document.getElementById('cart-count');
    let totalItems = 0;

    for (const item of cart) {
        totalItems += Number(item.quantity) || 0;
    }

    if (cartCount) {
        cartCount.textContent = totalItems;
        cartCount.classList.toggle('is-empty', totalItems === 0);
    }
}

function showCartMessage(message) {
    let messageBox = document.getElementById('cart-message');

    if (!messageBox) {
        messageBox = document.createElement('div');
        messageBox.id = 'cart-message';
        messageBox.className = 'cart-message';
        document.body.appendChild(messageBox);
    }

    messageBox.textContent = message;
    messageBox.classList.add('is-visible');

    setTimeout(() => {
        messageBox.classList.remove('is-visible');
    }, 2200);
}

function addToCart(product) {
    const cart = getCart();
    const existingProduct = cart.find((item) => item.id === product.id);

    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }

    saveCart(cart);
    updateCartCount();
    renderCartPage();
    showCartMessage('Produto adicionado ao carrinho.');
}

function captureAddCartButtons() {
    const buttons = document.querySelectorAll('.btn-add-cart');

    for (const button of buttons) {
        button.addEventListener('click', () => {
            const product = {
                id: button.dataset.id,
                name: button.dataset.name,
                price: Number(button.dataset.price),
                image: button.dataset.image
            };

            if (!product.id || !product.name || !Number.isFinite(product.price) || product.price <= 0) {
                showCartMessage('Nao foi possivel adicionar este produto.');
                return;
            }

            addToCart(product);
        });
    }
}

function changeQuantity(productId, operation) {
    const cart = getCart();

    for (const item of cart) {
        if (item.id === productId) {
            if (operation === 'increase') {
                item.quantity += 1;
            }

            if (operation === 'decrease') {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                } else {
                    showCartMessage('Quantidade minima e 1. Use remover para excluir.');
                }
            }
        }
    }

    saveCart(cart);
    updateCartCount();
    renderCartPage();
}

function removeFromCart(productId) {
    const cart = getCart();
    const updatedCart = cart.filter((item) => item.id !== productId);

    saveCart(updatedCart);
    updateCartCount();
    renderCartPage();
    showCartMessage('Produto removido do carrinho.');
}

function createCartItem(item) {
    const subtotal = Number(item.price) * Number(item.quantity);
    const article = document.createElement('article');
    const productId = escapeHTML(item.id);
    const productName = escapeHTML(item.name);
    const productImage = escapeHTML(item.image);

    article.className = 'cart-item';
    article.innerHTML = `
        <div class="cart-item-image">
            ${item.image ? `<img src="assets/img/${productImage}" alt="${productName}">` : '<span>Sem imagem</span>'}
        </div>

        <div class="cart-item-info">
            <h2>${productName}</h2>
            <p>Preco unitario: ${formatPrice(item.price)}</p>
        </div>

        <div class="quantity-controls" aria-label="Quantidade">
            <button type="button" class="quantity-btn" data-action="decrease" data-id="${productId}">-</button>
            <span>${item.quantity}</span>
            <button type="button" class="quantity-btn" data-action="increase" data-id="${productId}">+</button>
        </div>

        <strong class="cart-subtotal">${formatPrice(subtotal)}</strong>

        <button type="button" class="remove-cart-item" data-id="${productId}">Remover</button>
    `;

    return article;
}

function renderCartPage() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartEmpty = document.getElementById('cart-empty');
    const cartSummary = document.getElementById('cart-summary');
    const cartTotal = document.getElementById('cart-total');

    if (!cartItemsContainer || !cartEmpty || !cartSummary || !cartTotal) {
        return;
    }

    const cart = getCart();
    let total = 0;

    cartItemsContainer.innerHTML = '';

    if (cart.length === 0) {
        cartEmpty.style.display = 'block';
        cartSummary.style.display = 'none';
        return;
    }

    cartEmpty.style.display = 'none';
    cartSummary.style.display = 'block';

    for (const item of cart) {
        total += Number(item.price) * Number(item.quantity);
        cartItemsContainer.appendChild(createCartItem(item));
    }

    cartTotal.textContent = formatPrice(total);
}

function captureCartPageActions() {
    const cartItemsContainer = document.getElementById('cart-items');
    const checkoutButton = document.getElementById('checkout-button');
    const checkoutMessage = document.getElementById('checkout-message');

    if (cartItemsContainer) {
        cartItemsContainer.addEventListener('click', (event) => {
            const target = event.target;

            if (target.classList.contains('quantity-btn')) {
                changeQuantity(target.dataset.id, target.dataset.action);
            }

            if (target.classList.contains('remove-cart-item')) {
                removeFromCart(target.dataset.id);
            }
        });
    }

    if (checkoutButton) {
        checkoutButton.addEventListener('click', (event) => {
            const cart = getCart();

            if (cart.length === 0) {
                event.preventDefault();

                if (checkoutMessage) {
                    checkoutMessage.textContent = 'Adicione produtos antes de finalizar o pedido.';
                }

                showCartMessage('Seu carrinho esta vazio.');
            }
        });
    }
}

function getCartTotal(cart) {
    let total = 0;

    for (const item of cart) {
        total += Number(item.price) * Number(item.quantity);
    }

    return total;
}

function renderCheckoutSummary() {
    const checkoutItems = document.getElementById('checkout-items');
    const checkoutEmpty = document.getElementById('checkout-empty');
    const checkoutTotal = document.getElementById('checkout-total');

    if (!checkoutItems || !checkoutEmpty || !checkoutTotal) {
        return;
    }

    const cart = getCart();
    checkoutItems.innerHTML = '';

    if (cart.length === 0) {
        checkoutEmpty.style.display = 'block';
        checkoutItems.style.display = 'none';
        checkoutTotal.textContent = formatPrice(0);
        return;
    }

    checkoutEmpty.style.display = 'none';
    checkoutItems.style.display = 'flex';

    for (const item of cart) {
        const subtotal = Number(item.price) * Number(item.quantity);
        const productName = escapeHTML(item.name);
        const summaryItem = document.createElement('article');

        summaryItem.className = 'checkout-item';
        summaryItem.innerHTML = `
            <div>
                <h3>${productName}</h3>
                <p>${item.quantity} x ${formatPrice(item.price)}</p>
            </div>
            <strong>${formatPrice(subtotal)}</strong>
        `;

        checkoutItems.appendChild(summaryItem);
    }

    checkoutTotal.textContent = formatPrice(getCartTotal(cart));
}

function getCheckoutCustomerData() {
    return {
        name: document.getElementById('customer-name')?.value.trim() || '',
        email: document.getElementById('customer-email')?.value.trim() || '',
        phone: document.getElementById('customer-phone')?.value.trim() || '',
        city: document.getElementById('customer-city')?.value.trim() || '',
        address: document.getElementById('customer-address')?.value.trim() || '',
        comments: document.getElementById('customer-comments')?.value.trim() || ''
    };
}

function validateCheckout(customer, cart) {
    const errors = [];
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^[0-9+\-()\s]{6,20}$/;

    if (cart.length === 0) {
        errors.push('O carrinho esta vazio.');
    }

    if (customer.name === '') {
        errors.push('Informe o nome completo.');
    }

    if (customer.email === '') {
        errors.push('Informe o email.');
    } else if (!emailRegex.test(customer.email)) {
        errors.push('Informe um email valido.');
    }

    if (customer.phone === '') {
        errors.push('Informe o telefone ou WhatsApp.');
    } else if (!phoneRegex.test(customer.phone)) {
        errors.push('Informe um telefone valido.');
    }

    if (customer.city === '') {
        errors.push('Informe a cidade.');
    }

    if (customer.address === '') {
        errors.push('Informe o endereco ou zona de entrega.');
    }

    return errors;
}

function showCheckoutErrors(errors) {
    const errorsBox = document.getElementById('checkout-errors');
    const successBox = document.getElementById('checkout-success');

    if (successBox) {
        successBox.textContent = '';
    }

    if (!errorsBox) {
        return;
    }

    errorsBox.innerHTML = '';

    if (errors.length === 0) {
        return;
    }

    const list = document.createElement('ul');

    for (const error of errors) {
        const item = document.createElement('li');
        item.textContent = error;
        list.appendChild(item);
    }

    errorsBox.appendChild(list);
}

function generateOrderText(customer, cart) {
    const lines = [
        'Novo pedido desde SupleStore',
        '',
        'Dados do cliente:',
        `Nome: ${customer.name}`,
        `Email: ${customer.email}`,
        `Telefone / WhatsApp: ${customer.phone}`,
        `Cidade: ${customer.city}`,
        `Endereco ou zona de entrega: ${customer.address}`,
        '',
        'Produtos:'
    ];

    for (const item of cart) {
        const subtotal = Number(item.price) * Number(item.quantity);

        lines.push(
            `- ${item.name}`,
            `  Quantidade: ${item.quantity}`,
            `  Preco unitario: ${formatPrice(item.price)}`,
            `  Subtotal: ${formatPrice(subtotal)}`
        );
    }

    lines.push('', `Total geral: ${formatPrice(getCartTotal(cart))}`);

    if (customer.comments !== '') {
        lines.push('', 'Comentarios adicionais:', customer.comments);
    }

    return lines.join('\n');
}

function captureCheckoutForm() {
    const checkoutForm = document.getElementById('checkout-form');
    const successBox = document.getElementById('checkout-success');

    if (!checkoutForm) {
        return;
    }

    checkoutForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const cart = getCart();
        const customer = getCheckoutCustomerData();
        const errors = validateCheckout(customer, cart);

        showCheckoutErrors(errors);

        if (errors.length > 0) {
            return;
        }

        const subject = 'Nuevo pedido desde SupleStore';
        const body = generateOrderText(customer, cart);
        const mailtoUrl = `mailto:tienda@example.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

        // O pedido e enviado por email e a entrega/pagamento sao coordenados posteriormente com o cliente.
        window.location.href = mailtoUrl;

        clearCart();
        updateCartCount();
        renderCheckoutSummary();

        if (successBox) {
            successBox.textContent = 'Pedido preparado com sucesso. Seu cliente de email sera aberto para envio.';
        }

        showCartMessage('Pedido enviado para o cliente de email.');

        setTimeout(() => {
            window.location.href = 'produtos.php';
        }, 4500);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    captureAddCartButtons();
    captureCartPageActions();
    captureCheckoutForm();
    updateCartCount();
    renderCartPage();
    renderCheckoutSummary();
});
