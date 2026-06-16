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
    const price = (priceInCents / 100).toLocaleString('es-UY', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    return `$U ${price}`;
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
    const currentQuantity = existingProduct ? Number(existingProduct.quantity) || 0 : 0;

    if (Number.isFinite(product.stock) && currentQuantity >= product.stock) {
        showCartMessage('No hay más stock disponible para este producto.');
        return;
    }

    if (existingProduct) {
        existingProduct.quantity += 1;
        existingProduct.stock = product.stock;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            stock: product.stock,
            quantity: 1
        });
    }

    saveCart(cart);
    updateCartCount();
    renderCartPage();
    showCartMessage('Producto agregado al carrito.');
}

function captureAddCartButtons() {
    const buttons = document.querySelectorAll('.btn-add-cart');

    for (const button of buttons) {
        button.addEventListener('click', () => {
            const product = {
                id: button.dataset.id,
                name: button.dataset.name,
                price: Number(button.dataset.price),
                stock: Number(button.dataset.stock),
                image: button.dataset.image
            };

            if (
                !product.id ||
                !product.name ||
                !Number.isFinite(product.price) ||
                product.price <= 0 ||
                !Number.isFinite(product.stock)
            ) {
                showCartMessage('No fue posible agregar este producto.');
                return;
            }

            if (product.stock <= 0) {
                showCartMessage('Este producto no tiene stock disponible.');
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
                if (Number.isFinite(item.stock) && item.quantity >= item.stock) {
                    showCartMessage('No hay más stock disponible para este producto.');
                    continue;
                }

                item.quantity += 1;
            }

            if (operation === 'decrease') {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                } else {
                    showCartMessage('La cantidad mínima es 1. Usa eliminar para quitarlo.');
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
    showCartMessage('Producto eliminado del carrito.');
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
            ${item.image ? `<img src="assets/img/${productImage}" alt="${productName}">` : '<span>Sin imagen</span>'}
        </div>

        <div class="cart-item-info">
            <h2>${productName}</h2>
            <p>Precio unitario: ${formatPrice(item.price)}</p>
        </div>

        <div class="quantity-controls" aria-label="Cantidad">
            <button type="button" class="quantity-btn" data-action="decrease" data-id="${productId}">-</button>
            <span>${item.quantity}</span>
            <button type="button" class="quantity-btn" data-action="increase" data-id="${productId}">+</button>
        </div>

        <strong class="cart-subtotal">${formatPrice(subtotal)}</strong>

        <button type="button" class="remove-cart-item" data-id="${productId}">Eliminar</button>
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
                    checkoutMessage.textContent = 'Agrega productos antes de finalizar el pedido.';
                }

                showCartMessage('Tu carrito está vacío.');
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
        errors.push('El carrito está vacío.');
    }

    if (customer.name === '') {
        errors.push('Indica el nombre completo.');
    }

    if (customer.email === '') {
        errors.push('Indica el correo electrónico.');
    } else if (!emailRegex.test(customer.email)) {
        errors.push('Indica un correo electrónico válido.');
    }

    if (customer.phone === '') {
        errors.push('Indica el teléfono o WhatsApp.');
    } else if (!phoneRegex.test(customer.phone)) {
        errors.push('Indica un teléfono válido.');
    }

    if (customer.city === '') {
        errors.push('Indica la ciudad.');
    }

    if (customer.address === '') {
        errors.push('Indica la dirección o zona de entrega.');
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

async function processOrderStock(cart) {
    const response = await fetch('checkout_process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            items: cart.map((item) => ({
                id: item.id,
                quantity: item.quantity
            }))
        })
    });

    let result = null;

    try {
        result = await response.json();
    } catch (error) {
        throw new Error('No se pudo leer la respuesta del servidor.');
    }

    if (!response.ok || !result.success) {
        const message = result.message || 'No fue posible procesar el pedido.';
        const errors = Array.isArray(result.errors) ? result.errors : [];
        const error = new Error(message);
        error.details = errors;
        throw error;
    }

    return result;
}

function generateOrderText(customer, cart) {
    const lines = [
        'Nuevo pedido desde SupleStore',
        '',
        'Datos del cliente:',
        `Nombre: ${customer.name}`,
        `Correo electrónico: ${customer.email}`,
        `Teléfono / WhatsApp: ${customer.phone}`,
        `Ciudad: ${customer.city}`,
        `Dirección o zona de entrega: ${customer.address}`,
        '',
        'Productos:'
    ];

    for (const item of cart) {
        const subtotal = Number(item.price) * Number(item.quantity);

        lines.push(
            `- ${item.name}`,
            `  Cantidad: ${item.quantity}`,
            `  Precio unitario: ${formatPrice(item.price)}`,
            `  Subtotal: ${formatPrice(subtotal)}`
        );
    }

    lines.push('', `Total general: ${formatPrice(getCartTotal(cart))}`);

    if (customer.comments !== '') {
        lines.push('', 'Comentarios adicionales:', customer.comments);
    }

    return lines.join('\n');
}

function captureCheckoutForm() {
    const checkoutForm = document.getElementById('checkout-form');
    const successBox = document.getElementById('checkout-success');
    const submitButton = checkoutForm?.querySelector('button[type="submit"]');

    if (!checkoutForm) {
        return;
    }

    checkoutForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const cart = getCart();
        const customer = getCheckoutCustomerData();
        const errors = validateCheckout(customer, cart);

        showCheckoutErrors(errors);

        if (errors.length > 0) {
            return;
        }

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Procesando pedido...';
        }

        try {
            await processOrderStock(cart);
        } catch (error) {
            const stockErrors = [error.message];

            if (Array.isArray(error.details)) {
                stockErrors.push(...error.details);
            }

            showCheckoutErrors(stockErrors);
            showCartMessage('No fue posible completar el pedido.');

            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Enviar pedido';
            }

            return;
        }

        const subject = 'Nuevo pedido desde SupleStore';
        const body = generateOrderText(customer, cart);
        const mailtoUrl = `mailto:tienda@example.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

        // El pedido se envía por correo electrónico y la entrega/pago se coordinan después con el cliente.
        window.location.href = mailtoUrl;

        clearCart();
        updateCartCount();
        renderCheckoutSummary();

        if (successBox) {
            successBox.textContent = 'Pedido confirmado con éxito. Tu cliente de correo se abrirá para enviarlo.';
        }

        showCartMessage('Pedido confirmado y stock actualizado.');

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
