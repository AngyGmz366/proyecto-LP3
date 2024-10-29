// Simulación de una base de datos de artículos
let articulos = [
    {
        nombre: "Juguetes anntiguos",
        codigo: "JGT12",
        descripcion: "Juguetes antiguos de colección",
        precio: 150,
        cantidad: 10,
        categoria: "Juguetes"
    },

    {
        nombre: "Comics Vintages",
        codigo: "CMV13",
        descripcion: "Comics antiguos de colección",
        precio: 450,
        cantidad: 5,
        categoria: "Comics"
    },
    
    {
        nombre: "Figuras de colección",
        codigo: "FGC89",
        descripcion: "Figuras de colección",
        precio: 1200,
        cantidad: 5,
        categoria: "Figuras"
    }
];

// Simulación de la obtención de categorías desde Categoria.php
let categorias = [
    { id: 1, nombre: "Juguetes" },
    { id: 2, nombre: "Figuras" },
    { id: 3, nombre: "Comics" },
    { id: 3, nombre: "Posters" }
];

// Función para cargar categorías en el select
function cargarCategorias() {
    const selectCategoria = document.getElementById("categoriaArticulo");
    categorias.forEach(categoria => {
        const option = document.createElement("option");
        option.value = categoria.nombre;
        option.textContent = categoria.nombre;
        selectCategoria.appendChild(option);
    });
}

// Función para mostrar artículos en la tabla
function mostrarArticulos() {
    const listaArticulos = document.getElementById("listaArticulos");
    listaArticulos.innerHTML = "";

    articulos.forEach((articulo, index) => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${articulo.nombre}</td>
            <td>${articulo.codigo}</td>
            <td>${articulo.descripcion}</td>
            <td>L ${articulo.precio}</td>
            <td>${articulo.cantidad}</td>
            <td>${articulo.categoria}</td>
            <td>
                <button onclick="eliminarArticulo(${index})" class="eliminar">Eliminar</button>
                <button onclick="aumentarCantidad(${index})">+ Añadir Stock</button>
            </td>
        `;

        listaArticulos.appendChild(row);
    });
}

// Función para agregar un artículo
function agregarArticulo(event) {
    event.preventDefault();
    const nombre = document.getElementById("nombreArticulo").value;
    const codigo = document.getElementById("codigoArticulo").value;
    const descripcion = document.getElementById("descripcionArticulo").value;
    const precio = parseFloat(document.getElementById("precioArticulo").value);
    const cantidad = parseInt(document.getElementById("cantidadArticulo").value);
    const categoria = document.getElementById("categoriaArticulo").value;

    const nuevoArticulo = { nombre, codigo, descripcion, precio, cantidad, categoria };
    articulos.push(nuevoArticulo);

    mostrarArticulos();
    event.target.reset();  // Limpia el formulario después de agregar
}

// Función para eliminar un artículo
function eliminarArticulo(index) {
    articulos.splice(index, 1);
    mostrarArticulos();
}

// Función para aumentar la cantidad en existencia
function aumentarCantidad(index) {
    const cantidad = parseInt(prompt("Ingrese la cantidad adicional:"));
    if (cantidad > 0) {
        articulos[index].cantidad += cantidad;
        mostrarArticulos();
    } else {
        alert("Ingrese una cantidad válida.");
    }
}

// Llama a la función para mostrar artículos al cargar la página y cargar categorías en el formulario
document.addEventListener("DOMContentLoaded", () => {
    mostrarArticulos();
    cargarCategorias();
});
