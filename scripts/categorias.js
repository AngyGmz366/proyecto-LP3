let categorias = [];

// Función para agregar una categoría
function agregarCategoria() {
    const id = document.getElementById('idCategoria').value;
    const nombre = document.getElementById('nombreCategoria').value;
    const descripcion = document.getElementById('descripcionCategoria').value;

    if (id && nombre && descripcion) {
        categorias.push({ id, nombre, descripcion });
        actualizarTabla();
        limpiarFormulario('agregarCategoria');

        //SweetAlert de confirmación para la agregación
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Categoría agregada con éxito',
            showConfirmButton: false,
            timer: 1600
        });
    }
}

// Función para eliminar una categoría
function eliminarCategoria() {
    const id = document.getElementById('idCategoria').value;
    categorias = categorias.filter(categoria => categoria.id !== id);

    //SweetAlert para confirmación de eliminación de la categoría
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Categoría eliminada con éxito',
        showConfirmButton: false,
        timer: 1600
    });

    actualizarTabla();
    limpiarFormulario('eliminarCategoria');
}

// Función para actualizar una categoría
function actualizarCategoria() {
    const id = document.getElementById('idCategoria').value;
    const nuevoNombre = document.getElementById('nombreCategoria').value;
    const nuevaDescripcion = document.getElementById('descripcionCategoria').value;

    for (let i = 0; i < categorias.length; i++) {
        if (categorias[i].id === id) {
            categorias[i].nombre = nuevoNombre;
            categorias[i].descripcion = nuevaDescripcion;

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Categoría actualizada con éxito',
                showConfirmButton: false,
                timer: 1600
            });
    break;

            
        }
    }
    actualizarTabla();
    limpiarFormulario('actualizarCategoria');
}

// Función para actualizar la tabla de categorías
function actualizarTabla() {
    const tbody = document.querySelector('#tablaCategorias tbody');
    tbody.innerHTML = ''; // Limpiar tabla

    categorias.forEach(categoria => {
        const fila = document.createElement('tr');

        const celdaId = document.createElement('td');
        celdaId.textContent = categoria.id;
        fila.appendChild(celdaId);

        const celdaNombre = document.createElement('td');
        celdaNombre.textContent = categoria.nombre;
        fila.appendChild(celdaNombre);

        const celdaDescripcion = document.createElement('td');
        celdaDescripcion.textContent = categoria.descripcion;
        fila.appendChild(celdaDescripcion);

        tbody.appendChild(fila);
    });
}

// Función para limpiar formularios
function limpiarFormulario(formId) {
    document.getElementById(formId).reset();
}
