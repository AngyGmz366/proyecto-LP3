// Ejemplo de datos de artículos (Obtenidos del backend)
const articulos = [
    { id: 1, nombre: "Figura de Acción", precio: 320.85, categoria: "figuras", imagen: "figura1.jpg", cantidad: 5 },
    { id: 2, nombre: "Póster de Anime", precio: 120.54, categoria: "posters", imagen: "poster1.jpg", cantidad: 2 },
    { id: 3, nombre: "Cómic Edición Limitada", precio: 250.10, categoria: "comics", imagen: "comic1.jpg", cantidad: 0 },
    { id: 4, nombre: "Videojuego Clásico", precio: 657.33, categoria: "videojuegos", imagen: "videojuego1.jpg", cantidad: 8 },
    { id: 5, nombre: "Figura de Colección", precio: 758.50, categoria: "figuras", imagen: "figura2.jpg", cantidad: 3 },
];

// Filtrar y renderizar artículos
function renderizarArticulos(categoria = "todos") {
    const contenedor = document.getElementById("listaArticulos");
    contenedor.innerHTML = ""; // Limpiar artículos previos

    const articulosFiltrados = categoria === "todos" 
        ? articulos 
        : articulos.filter(articulo => articulo.categoria === categoria);

    articulosFiltrados.forEach(articulo => {
        const articuloDiv = document.createElement("div");
        articuloDiv.className = "articulo";

        articuloDiv.innerHTML = `
            <img src="${articulo.imagen}" alt="${articulo.nombre}">
            <h3>${articulo.nombre}</h3>
            <p>Precio: L${articulo.precio.toFixed(2)}</p>
            <div class="botones-cantidad">
                <button onclick="cambiarCantidad(${articulo.id}, -1)">-</button>
                <span id="cantidad-${articulo.id}">0</span>
                <button onclick="cambiarCantidad(${articulo.id}, 1)">+</button>
            </div>
            <button class="carrito" onclick="agregarAlCarrito(${articulo.id})">Agregar al Carrito</button>
        `;

        contenedor.appendChild(articuloDiv);
    });
}

// Cambiar cantidad seleccionada
function cambiarCantidad(idArticulo, cambio) {
    const articulo = articulos.find(art => art.id === idArticulo);
    const cantidadElemento = document.getElementById(`cantidad-${idArticulo}`);
    let cantidadSeleccionada = parseInt(cantidadElemento.textContent);

    // Validar cantidad
    if (cambio > 0 && cantidadSeleccionada < articulo.cantidad) {
        cantidadSeleccionada += cambio;
    } else if (cambio < 0 && cantidadSeleccionada > 0) {
        cantidadSeleccionada += cambio;
    } else if (cambio > 0) {
        alert("No hay más stock disponible para este artículo.");
    }

    cantidadElemento.textContent = cantidadSeleccionada;
}

// Función para agregar al carrito
function agregarAlCarrito(idArticulo) {
    const cantidadSeleccionada = parseInt(document.getElementById(`cantidad-${idArticulo}`).textContent);

    if (cantidadSeleccionada > 0) {
        alert(`Se han agregado ${cantidadSeleccionada} unidades del artículo con ID ${idArticulo} al carrito.`);
        window.location.href = "carrito.html";
    } else {
        alert("Selecciona al menos una unidad antes de agregar al carrito.");
    }
}

// Filtrar por categoría
function filtrarPorCategoria() {
    const categoriaSeleccionada = document.getElementById("filtroCategoria").value;
    renderizarArticulos(categoriaSeleccionada);
}

// Renderizar todos los artículos al cargar
window.onload = () => {
    renderizarArticulos();
};
