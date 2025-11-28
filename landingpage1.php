<?php
// --- PROCESAMIENTO DEL FORMULARIO ---
$mensajeEnviado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = $_POST["nombre"] ?? "";
    $correo   = $_POST["correo"] ?? "";
    $telefono = $_POST["telefono"] ?? "";

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
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #BD1622;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        header img {
            height: 70px;
        }

        header .titles {
            text-align: left;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
        }

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
            font-weight: bold;
        }

        .tab-button:hover {
            background-color: #A62631;
            color: white;
        }

        /* FORMULARIO */
        .form-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 40px;
        }

        .form-fields-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
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
            padding: 14px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 18px;
            cursor: pointer;
        }

        /* VIDEO Y CARRUSEL */
        .flex-row {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .video-wrapper {
            width: 48%;
            height: 600px; /* Alta */
            background: #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .video-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .carousel-container {
            width: 46%;
            height: 600px; /* Alta */
            background: black;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .carousel-images img {
            width: 80%;
            height: 80%;
            object-fit: cover;
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
            padding: 12px;
            cursor: pointer;
            font-size: 26px;
        }

        .prev { left: 10px; }
        .next { right: 10px; }

        /* BOTONES WHATSAPP */
        .wbtn {
            margin-top: 5px;
            margin-left: 500px; /* mueve a la derecha */
            margin-right: 600px;
			margin-bottom: 15px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #28a745;
            color: white;
            padding: 14px 18px;
            border-radius: 8px;
            font-size: 18px;
            text-decoration: none;
            font-weight: bold;
        }

        .wbtn svg {
            width: 48px;
            height: 48px;
            fill: white;
        }
.footer-unilova {

    background: #BD1622; 
    color: white;
    padding: 30px 40px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 40px;
    margin-top: 40px;
}

.footer-left img {
    width: 640px;
    border-radius: 10px;
}

.footer-right ul {
    list-style: none;
    padding: 0;
	margin-top:30px;

}

.footer-right ul li {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
    font-size: 18px;
}

.footer-right ul li img {
    width: 48px;
    height: 48px;
    margin-right: 10px;
}

.footer-right a {
    color: #1DB954; /* verde estilo WhatsApp */
    font-weight: bold;
    text-decoration: none;
}

.footer-right a:hover {
    text-decoration: underline;
}

/* RESPONSIVO */
@media (max-width: 768px) {
    .footer-unilova {
        flex-direction: column;
        text-align: center;
    }

    .footer-left img {
        width: 80%;
        margin: 0 auto;
    }

    .footer-right ul li {
        justify-content: center;
    }
}
		
		
    </style>
</head>

<body>

<header>
    <img src="unilova_logo.png">
    <div class="titles">
        <h1 style="margin:0;">Universidad LOVA</h1>
        <h2 style="margin:0;">Carreras Técnicas</h2>
    </div>
</header>

<div class="container">

<?php if ($mensajeEnviado): ?>
    <div style="padding:15px; background:#d4edda; color:#155724; border-radius:5px;">
        ✔️ Gracias, tu registro fue enviado correctamente.
    </div>
<?php endif; ?>

<div class="tab-buttons">
    <a href="#mecatronica" class="tab-button">Tec. Mecatrónica</a>
    <a href="#mantenimiento" class="tab-button">Tec. Mantenimiento Industrial</a>
</div>

<!-- FORMULARIO -->
<aside class="form-section">
    <h3>FORMULARIO DE INSCRIPCIÓN</h3>

    <form method="POST">
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

<!-- MECATRÓNICA -->
<section id="mecatronica">
    <h2>⚙️ Técnico en Mecatrónica</h2>

    <a class="wbtn" href="https://wa.me/5214492254967/?text=Hola,%20quiero%20saber%20m%C3%A1s%20sobre%20%20la%20carrera%20de%20mecatrónica" target="_blank">
        <!-- Ícono WhatsApp -->
        <svg viewBox="0 0 32 32"><path d="M16 .3A15.7 15.7 0 0 0 .2 16a15.5 15.5 0 0 0 2.3 8.2L0 32l8-2.1A16 16 0 1 0 16 .3Zm0 29.2a13.3 13.3 0 0 1-6.8-1.9l-.5-.3-4.7 1.2 1.3-4.6-.3-.5A13.8 13.8 0 1 1 16 29.5Zm7.5-10c-.4-.2-2.3-1.1-2.6-1.2s-.6-.2-.8.2l-1.1 1.4c-.2.2-.4.3-.8.1s-1.6-.6-3-1.9c-1.1-1-1.9-2.3-2.1-2.7s0-.6.2-.7l1-1.2c.2-.3.2-.6 0-.8l-1.2-3c-.3-.8-.6-.7-.8-.8h-.7a1.4 1.4 0 0 0-1 1.1 5.5 5.5 0 0 0 1 4c.1.2 2 3.5 5 5.1s4 1.5 4.7 1.4a4 4 0 0 0 2.6-1.8c.3-.5.3-1 .2-1.1s-.4-.2-.7-.4Z"></path></svg>
        WhatsApp Mecatrónica
    </a>

    <div class="flex-row">
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/Y_2kGtS0L-8" allowfullscreen></iframe>
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

<!-- MANTENIMIENTO INDUSTRIAL -->
<section id="mantenimiento">
    <h2>🔧 Técnico en Mantenimiento Industrial</h2>

    <a class="wbtn" href="https://wa.me/5214492254967/?text=Hola,%20quiero%20saber%20m%C3%A1s%20sobre%20%20la%20carrera%20de%20mantenimiento%20industrial" target="_blank">
        <!-- Ícono WhatsApp -->
        <svg viewBox="0 0 32 32"><path d="M16 .3A15.7 15.7 0 0 0 .2 16a15.5 15.5 0 0 0 2.3 8.2L0 32l8-2.1A16 16 0 1 0 16 .3Zm0 29.2a13.3 13.3 0 0 1-6.8-1.9l-.5-.3-4.7 1.2 1.3-4.6-.3-.5A13.8 13.8 0 1 1 16 29.5Zm7.5-10c-.4-.2-2.3-1.1-2.6-1.2s-.6-.2-.8.2l-1.1 1.4c-.2.2-.4.3-.8.1s-1.6-.6-3-1.9c-1.1-1-1.9-2.3-2.1-2.7s0-.6.2-.7l1-1.2c.2-.3.2-.6 0-.8l-1.2-3c-.3-.8-.6-.7-.8-.8h-.7a1.4 1.4 0 0 0-1 1.1 5.5 5.5 0 0 0 1 4c.1.2 2 3.5 5 5.1s4 1.5 4.7 1.4a4 4 0 0 0 2.6-1.8c.3-.5.3-1 .2-1.1s-.4-.2-.7-.4Z"></path></svg>
        WhatsApp Mantenimiento
    </a>

    <div class="flex-row">
        <div class="video-wrapper">
            <iframe src="https://www.youtube.com/embed/jBuizjlJUok" allowfullscreen></iframe>
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

<!-- ====== FOOTER PERSONALIZADO ====== -->
<footer class="footer-unilova">

    <!-- Imagen izquierda -->
    <div class="footer-left">
        <img src="Fachada.png" alt="Fachada Unilova">
    </div>

    <!-- Datos derecha -->
    <div class="footer-right">
        <ul>
            <li>
                <img src="wa.png" alt="WhatsApp">
                Whatsapp: <a href="https://wa.me/5214492254967" target="_blank">449 225 4967</a>
            </li>

            <li>
                <img src="tel.png" alt="Teléfono">
                Teléfono: <a href="tel:4497357910">449 735 7910</a>
            </li>

            <li>
                <img src="mail.png" alt="Correo">
                Correo: <a href="mailto:ventas1@unilova.mx">ventas1@unilova.mx</a>
            </li>

            <li>
                <img src="map.png" alt="Dirección">
                Dirección: Av. Siglo XXI, No. 7301, fracc. Solidaridad III, C.P. 20263.
            </li>
        </ul>
    </div>

</footer>


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
