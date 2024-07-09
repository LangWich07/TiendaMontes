
document.addEventListener('DOMContentLoaded', function() {
    const addProductBtn = document.getElementById('addProductBtn');
    const addProductModal = document.getElementById('addProductModal');
    const closeBtn = document.querySelector('.close');
    const productForm = document.getElementById('productForm');
    const productList = document.getElementById('productList');

    // Mostrar modal al hacer clic en "Agregar Producto"
    addProductBtn.addEventListener('click', function() {
        addProductModal.style.display = 'block';
    });

    // Cerrar modal al hacer clic en la X
    closeBtn.addEventListener('click', function() {
        addProductModal.style.display = 'none';
    });

    // Cerrar modal si el usuario hace clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target === addProductModal) {
            addProductModal.style.display = 'none';
        }
    });

    // Manejar el envío del formulario para agregar productos
    productForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar envío por defecto del formulario

        const productName = document.getElementById('productName').value;
        const productDescription = document.getElementById('productDescription').value;
        const productPrice = document.getElementById('productPrice').value;

        // Enviar datos del formulario usando fetch a AggProducto.php
        fetch('AggProducto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `productName=${encodeURIComponent(productName)}&productDescription=${encodeURIComponent(productDescription)}&productPrice=${encodeURIComponent(productPrice)}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(`Perfecto: ${data.message}`);
                // Actualizar la lista de productos inmediatamente después de agregar
                fetchAndDisplayProducts();
            } else {
                alert(`Hubo un error al agregar el producto: ${data.message}`);
            }
            productForm.reset();
            addProductModal.style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al intentar agregar el producto.');
        });
    });

    // Agregar evento para eliminar producto
    productList.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-btn')) {
            const productId = event.target.dataset.productId;

            // Confirmar si realmente quiere eliminar el producto
            if (confirm(`¿Está seguro de eliminar este producto?`)) {
                // Enviar solicitud para eliminar producto usando fetch a EliminarProducto.php
                fetch('EliminarProducto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `productId=${encodeURIComponent(productId)}`,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(`Perfecto: ${data.message}`);
                        // Actualizar la lista de productos inmediatamente después de eliminar
                        fetchAndDisplayProducts();
                    } else {
                        alert(`Hubo un error al eliminar el producto: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al intentar eliminar el producto.');
                });
            }
        }
    });

    // Función para cargar y mostrar productos
    function fetchAndDisplayProducts() {
        fetch('productos.php')
            .then(response => response.json())
            .then(productos => {
                productList.innerHTML = ''; // Limpiar lista de productos
                productos.forEach(producto => {
                    const productItem = document.createElement('div');
                    productItem.classList.add('product-item');
                    productItem.innerHTML = `
                        <h3>${producto.nombre}</h3>
                        <p>${producto.descripcion}</p>
                        <p>Precio: $${producto.precio}</p>
                        <button class="delete-btn" data-product-id="${producto.id}">Eliminar</button>
                    `;
                    productList.appendChild(productItem);
                });
            })
            .catch(error => console.error('Error al cargar productos:', error));
    }

    // Cargar y mostrar productos al cargar la página
    fetchAndDisplayProducts();
});
