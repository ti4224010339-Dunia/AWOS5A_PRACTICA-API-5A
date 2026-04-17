const URL_API = 'http://localhost/Zavala/UTCAM%205A/api.php';

// Cargar alumnos al iniciar
document.addEventListener('DOMContentLoaded', obtenerAlumnos);

async function obtenerAlumnos() {
    try {
        const res = await fetch(URL_API);
        const alumnos = await res.json();
        const tabla = document.getElementById('tablaAlumnos');
        tabla.innerHTML = '';

        alumnos.forEach(alumno => {
            tabla.innerHTML += `
                <tr>
                    <td>${alumno.id}</td>
                    <td class="fw-bold">${alumno.nombre}</td>
                    <td>${alumno.edad}</td>
                    <td>${alumno.correo}</td>
                    <td>${alumno.escuela}</td>
                    <td class="text-center">
                        <button class="btn btn-custom btn-editar btn-sm me-2" onclick="prepararEdicion(${JSON.stringify(alumno).replace(/"/g, '&quot;')})">Editar</button>
                        <button class="btn btn-custom btn-eliminar btn-sm" onclick="eliminarAlumno(${alumno.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error("Error al obtener datos:", error);
        Swal.fire('Error', 'No se pudo conectar con la API', 'error');
    }
}

// ... EL RESTO DEL ARCHIVO SCRIPT.JS QUEDA IGUAL ...
// (mostrarFormulario, enviarDatos, eliminarAlumno, prepararEdicion)
// Las funciones de SweetAlert2 no necesitan cambiar de color porque ya usan un diseño limpio y profesional por defecto.

// Función para Agregar (POST) usando SweetAlert2 como formulario
async function mostrarFormulario() {
    const { value: formValues } = await Swal.fire({
        title: 'Nuevo Alumno',
        html:
            '<input id="swal-nombre" class="swal2-input" placeholder="Nombre">' +
            '<input id="swal-edad" type="number" class="swal2-input" placeholder="Edad">' +
            '<input id="swal-correo" type="email" class="swal2-input" placeholder="Correo">' +
            '<input id="swal-escuela" class="swal2-input" placeholder="Escuela">',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        preConfirm: () => {
            return {
                nombre: document.getElementById('swal-nombre').value,
                edad: document.getElementById('swal-edad').value,
                correo: document.getElementById('swal-correo').value,
                escuela: document.getElementById('swal-escuela').value
            }
        }
    });

    if (formValues) {
        enviarDatos(formValues, 'POST');
    }
}

// Enviar datos a la API
async function enviarDatos(datos, metodo, id = '') {
    const url = id ? `${URL_API}?id=${id}` : URL_API;
    
    const res = await fetch(url, {
        method: metodo,
        body: JSON.stringify(datos),
        headers: { 'Content-Type': 'application/json' }
    });

    const resultado = await res.json();
    if (resultado.mensaje) {
        Swal.fire('¡Éxito!', resultado.mensaje, 'success');
        obtenerAlumnos();
    } else {
        Swal.fire('Error', 'No se pudo realizar la operación', 'error');
    }
}

// Eliminar Alumno (DELETE)
function eliminarAlumno(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const res = await fetch(`${URL_API}?id=${id}`, { method: 'DELETE' });
            const data = await res.json();
            Swal.fire('Eliminado', data.mensaje, 'success');
            obtenerAlumnos();
        }
    });
}

// Preparar edición (PUT)
async function prepararEdicion(alumno) {
    const { value: formValues } = await Swal.fire({
        title: 'Editar Alumno',
        html:
            `<input id="swal-nombre" class="swal2-input" value="${alumno.nombre}">` +
            `<input id="swal-edad" type="number" class="swal2-input" value="${alumno.edad}">` +
            `<input id="swal-correo" type="email" class="swal2-input" value="${alumno.correo}">` +
            `<input id="swal-escuela" class="swal2-input" value="${alumno.escuela}">`,
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        preConfirm: () => {
            return {
                nombre: document.getElementById('swal-nombre').value,
                edad: document.getElementById('swal-edad').value,
                correo: document.getElementById('swal-correo').value,
                escuela: document.getElementById('swal-escuela').value
            }
        }
    });

    if (formValues) {
        enviarDatos(formValues, 'PUT', alumno.id);
    }
}