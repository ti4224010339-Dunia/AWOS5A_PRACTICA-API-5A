<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos - Panel Pastel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* --- Paleta de Colores Pasteles --- */
        :root {
            --fondo-suave: #FDFBFF;       /* Un blanco roto muy suave */
            --lila-pastel: #E6E6FA;       /* Lavender */
            --lila-fuerte: #C3C3E6;       /* Un lila un poco más oscuro para texto/bordes */
            --rosado-pastel: #FFD1DC;     /* Pink pastel */
            --rosado-fuerte: #FFB7C5;     /* Un rosado un poco más oscuro para hover */
            --texto-oscuro: #5A5A7A;      /* Un gris azulado suave para el texto */
        }

        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--fondo-suave); 
            color: var(--texto-oscuro);
        }

        .container { 
            margin-top: 50px; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(230, 230, 250, 0.5); /* Sombra con toque lila */
            border: 1px solid var(--lila-pastel);
        }

        /* Título Principal */
        h2.text-primary {
            color: var(--lila-fuerte) !important;
            font-weight: 600;
        }

        /* --- Botones Personalizados --- */
        .btn-custom { 
            border-radius: 25px; 
            padding: 10px 25px; 
            transition: all 0.3s ease; 
            font-weight: 400;
            border: none;
        }

        /* Botón Agregar (Rosado) */
        .btn-agregar {
            background-color: var(--rosado-pastel);
            color: #A06070; /* Texto rosado oscuro para contraste */
        }
        .btn-agregar:hover {
            background-color: var(--rosado-fuerte);
            transform: translateY(-2px);
        }

        /* Botón Editar (Lila Suave) */
        .btn-editar {
            background-color: var(--lila-pastel);
            color: #6A6A8A; /* Texto lila oscuro */
        }
        .btn-editar:hover {
            background-color: var(--lila-fuerte);
            transform: translateY(-1px);
        }

        /* Botón Eliminar (Rojo Pastel suave, para mantener la semántica pero en tono pastel) */
        .btn-eliminar {
            background-color: #FFE0E0; /* Un rojo muy deslavado */
            color: #C08080;
        }
        .btn-eliminar:hover {
            background-color: #FFCDCD;
            transform: translateY(-1px);
        }

        /* --- Tabla Personalizada --- */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px; /* Espaciado entre filas */
        }
        .table thead th { 
            background-color: var(--lila-pastel); 
            color: #6A6A8A;
            border: none;
            padding: 15px;
            font-weight: 600;
        }
        .table tbody tr {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            border-radius: 10px;
        }
        .table tbody td {
            vertical-align: middle;
            padding: 15px;
            border-top: 1px solid #F0F0F0;
            border-bottom: 1px solid #F0F0F0;
        }
        .table tbody tr:hover {
            background-color: #FBF9FF; /* Un toque lila muy leve al pasar el mouse */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="text-primary">Panel de Alumnos</h2>
        <button class="btn btn-custom btn-agregar" onclick="mostrarFormulario()">+ Nuevo Registro</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Correo</th>
                    <th>Escuela</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaAlumnos">
                </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="script.js"></script>
</body>
</html>