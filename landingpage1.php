<?php
// --- PROCESAMIENTO DEL FORMULARIO ---
$mensajeEnviado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = $_POST["nombre"] ?? "";
    $correo   = $_POST["correo"] ?? "";
    $telefono = $_POST["telefono"] ?? "";

    // Aquí puedes agregar:
    // - guardado en base de datos
    // - envío por correo
    // - envío a WhatsApp
    // - API externa (CRM)

    // Ejemplo: enviar por correo simple
    $to = "TU_CORREO@DOMINIO.COM";
    $subject = "Nuevo registro desde la Landing Page";
    $message = "Nombre: $nombre\nCorreo: $correo\nTeléfono: $telefono";

    @mail($to, $subject, $message);

    $mensajeEnviado = true;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page: Carreras Técnicas</title>

    <style>
        /* TODO TU CSS AQUÍ (sin cambios) */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 40px 0;
            background-color: #A62631;
            color: white;
        }

        /* Botones de Pestañas */
        .tab-buttons {
            text-align: center;
            margin-bottom: 20px;
        }

        .tab-button {
            padding: 10px 20px;
            margin: 5px;
            border: 2px solid #A62631;
            background-color: white;
            color: #A62631;
            text-decoration: none;
            border-radius: 20px;
            display: inline-block;
            transition: all 0.3s;
        }

        .tab-button:hover {
            background-color: #A62631;
            color: white;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
        }

        /* Formulario */
        .form-section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .form-fields-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 10px;
        }

        .form-group {
            flex: 1 1 200px;
            display: flex;
            flex-direction: column;
        }

        .form-group input {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-section button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1.1em;
        }

        /* Videos */
        .video-wrapper {
            position: relative;
            width: 100%;
            max-width: 300px;
            height: 400px;
            background-color: #ddd;
            margin: auto;
        }

        .video-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Carrusel */
        .carousel-container {
            position: relative;
            background: black;
            border-radius: 8px;
            overflow: hidden;
            height: 300px;
        }

        .carousel-images img {
            width: 100%;
            display: none;
        }

        .carousel-images img.active {
            display: block;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 20px;
        }

        .prev { left: 10px; }
        .next { right: 10px; }

    </style>

</head>

<body>

<header>
    <h1>Landing Page: Técnico en Mecatrónica y Mantenimiento Industrial</h1>
    <h2>¡NO TE QUEDES FUERA! Inscríbete Ahora.</h2>
</header>

<div class="container">

    <?php if ($mensajeEnviado): ?>
        <div style="padding:15px; background:#d4edda; color:#155724; border-radius:5px;">
            ✔️ Gracias, tu registro fue enviado correctamente.
        </div>
    <?php endif; ?>

    <div class="tab-buttons">
        <a href="#mecatronica" class="tab-button"><strong>Tec. Mecatrónica</strong></a>
        <a href="#mantenimiento" class="tab-button"><strong>Tec. Mantenimiento Industrial</strong></a>
    </div>

    <!-- FORMULARIO -->
    <aside class="form-section">
        <h3>FORMULARIO DE INSCRIPCIÓN</h3>

        <form action="" method="POST">
            <div class="form-fields-grid">
                <div class="form-group">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required>
                </div>

                <div class="form-group">
                    <label>Correo:</label>
                    <input type="email" name="correo" required>
                </div>

                <div class="form-group">
                    <label>Teléfono:</label>
                    <input type="tel" name="telefono" required>
                </div>
            </div>

            <button type="submit">¡QUIERO INSCRIBIRME AHORA!</button>
        </form>
    </aside>

    <!-- SECCIÓN DE CONTENIDO (VIDEOS Y CARRUSELES) -->
    <section id="mecatronica" class="course-section">
        <h2>⚙️ Técnico en Mecatrónica</h2>

        <div style="display:flex; gap:20px; flex-wrap:wrap;">

            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/Y_2kGtS0L-8"
                        allowfullscreen></iframe>
            </div>

            <div class="carousel-container" id="carouselMecatronica">
                <button class="carousel-btn prev" onclick="moveCarousel('Mecatronica', -1)">‹</button>

                <div class="carousel-images">
                    <img src="MECATRONICA1.jpg" class="active">
                    <img src="MECATRONICA2.jpg">
                    <img src="MECATRONICA3.jpg">
                </div>

                <button class="carousel-btn next" onclick="moveCarousel('Mecatronica', 1)">›</button>
            </div>
        </div>
    </section>

    <hr>

    <section id="mantenimiento" class="course-section">
        <h2>🔧 Técnico en Mantenimiento Industrial</h2>

        <div style="display:flex; gap:20px; flex-wrap:wrap;">

            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/jBuizjlJUok"
                        allowfullscreen></iframe>
            </div>

            <div class="carousel-container" id="carouselMantenimiento">
                <button class="carousel-btn prev" onclick="moveCarousel('Mantenimiento', -1)">‹</button>

                <div class="carousel-images">
                    <img src="MANTENIMIENTO1.jpg" class="active">
                    <img src="MANTENIMIENTO2.jpg">
                    <img src="MANTENIMIENTO3.jpg">
                </div>

                <button class="carousel-btn next" onclick="moveCarousel('Mantenimiento', 1)">›</button>
            </div>
        </div>
    </section>

</div>

<script>
function moveCarousel(id, dir) {
    const c = document.getElementById("carousel" + id);
    const images = c.querySelectorAll("img");

    let index = [...images].findIndex(img => img.classList.contains("active"));
    images[index].classList.remove("active");

    index = (index + dir + images.length) % images.length;

    images[index].classList.add("active");
}
</script>

</body>
</html>
