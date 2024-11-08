let articulos = [];

let categorias = [
    { id: 1, nombre: "Juguetes" },
    { id: 2, nombre: "Figuras" },
    { id: 3, nombre: "Comics" },
    { id: 4, nombre: "Posters" }
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

function agregarArticulo() {
    const nombreArticulo = document.getElementById('nombreArticulo').value;
    const codigoArticulo = document.getElementById('codigoArticulo').value;
    const descripcion = document.getElementById('descripcion').value;
    const precio = document.getElementById('precio').value;
    const cantidadExistencia = parseInt(document.getElementById('cantidadExistencia').value);
    const categoria = document.getElementById('categoria').value;
    const imagenArchivo = document.getElementById('fotografiaArticulo').files[0];

    if (imagenArchivo) {
        const imagenURL = URL.createObjectURL(imagenArchivo);

        articulos.push({
            nombreArticulo,
            codigoArticulo,
            descripcion,
            precio,
            cantidadExistencia,
            categoria,
            imagenURL
        });

        actualizarTablaArticulos();

        // SweetAlert de confirmación para agregar el artículo
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Artículo agregado con éxito',
            showConfirmButton: false,
            timer: 1500
        });

        document.getElementById('formArticulo').reset();
        document.getElementById('preview').style.display = 'none';
    }
}

function actualizarTablaArticulos() {
    const tabla = document.getElementById("tablaArticulos").getElementsByTagName('tbody')[0];
    tabla.innerHTML = '';

    articulos.forEach((articulo, index) => {
        const newRow = tabla.insertRow();

        newRow.insertCell().textContent = articulo.nombreArticulo;
        newRow.insertCell().textContent = articulo.codigoArticulo;
        newRow.insertCell().textContent = articulo.descripcion;
        newRow.insertCell().textContent = articulo.precio;
        newRow.insertCell().textContent = articulo.cantidadExistencia;
        newRow.insertCell().textContent = articulo.categoria;

        const cellFoto = newRow.insertCell();
        const imgElement = document.createElement('img');
        imgElement.src = articulo.imagenURL;
        imgElement.style.width = '50px';
        cellFoto.appendChild(imgElement);

        const accionesCell = newRow.insertCell();

        const eliminarBtn = document.createElement("button");
        eliminarBtn.textContent = "Eliminar";
        eliminarBtn.classList.add("action-btn", "delete-btn");
        eliminarBtn.onclick = () => eliminarArticulo(index);

        const añadirStockBtn = document.createElement("button");
        añadirStockBtn.textContent = "Añadir Stock";
        añadirStockBtn.classList.add("action-btn", "stock-btn");
        añadirStockBtn.onclick = () => añadirStock(index);

        accionesCell.appendChild(eliminarBtn);
        accionesCell.appendChild(añadirStockBtn);
    });

    //SweetAlert de confirmación para la actualizacion de articulos
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Artículo agregado con éxito',
        showConfirmButton: false,
        timer: 1500
    });
}

function eliminarArticulo(index) {
    articulos.splice(index, 1);
    actualizarTablaArticulos();

    //SweetAlert de confirmación para la eliminacion de articulos
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Artículo eliminado con éxito',
        showConfirmButton: false,
        timer: 1500
    });
}

function añadirStock(index) {
    const cantidadAdicional = parseInt(prompt("Ingrese la cantidad adicional de stock:"));
    if (cantidadAdicional > 0) {
        articulos[index].cantidadExistencia += cantidadAdicional;
        actualizarTablaArticulos();
    } else {
        alert("Cantidad inválida.");
    }
}
