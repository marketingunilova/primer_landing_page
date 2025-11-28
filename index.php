<?php
// --- CONEXIÓN A LA BASE DE DATOS ---
$servername = "140.84.191.227";
$username = "landing_page";
$password = "Mektia#2025";
$dbname = "landing_page";
$port = 3306;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    $db_error = true;
} else {
    $db_error = false;
}

// --- PROCESAMIENTO DEL FORMULARIO ---
$mensajeEnviado = false;
$db_success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST["nombre"] ?? "");
    $correo   = trim($_POST["correo"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");
    
    if (!empty($nombre) && !empty($correo) && !empty($telefono)) {
        if (!$db_error) {
            $stmt = $conn->prepare("INSERT INTO landing_page (nombre, correo, telefono, fecha_registro) VALUES (?, ?, ?, NOW())");
            
            if ($stmt) {
                $stmt->bind_param("sss", $nombre, $correo, $telefono);
                
                if ($stmt->execute()) {
                    $db_success = true;
                    $mensajeEnviado = true;
                }
                $stmt->close();
            }
        }
        
        $to = "ventas1@unilova.mx";
        $subject = "Nuevo registro desde la Landing Page - Universidad LOVA";
        $message = "Se ha recibido un nuevo registro:\n\nNombre: $nombre\nCorreo: $correo\nTeléfono: $telefono\n\nFecha: " . date('Y-m-d H:i:s');
        $headers = "From: landingpage@unilova.mx\r\n";
        @mail($to, $subject, $message, $headers);
        
        if (!$mensajeEnviado) {
            $mensajeEnviado = true;
        }
    }
}

if (isset($conn) && !$db_error) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras Técnicas - Universidad LOVA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #BD1622;
            --primary-dark: #99131D;
            --primary-light: #D42A36;
            --secondary: #2C3E50;
            --accent: #F39C12;
            --light: #ECF0F1;
            --dark: #2C3E50;
            --success: #27AE60;
            --gradient-primary: linear-gradient(135deg, #BD1622 0%, #D42A36 100%);
            --gradient-secondary: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --shadow-hover: 0 15px 40px rgba(0,0,0,0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            line-height: 1.7;
            color: #333;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            overflow-x: hidden;
        }

        /* HEADER CORREGIDO - LOGO VISIBLE */
        .main-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(189, 22, 34, 0.3);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            flex-wrap: wrap;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .logo-container img {
            height: 70px;
        }

        .logo-text h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .logo-text h2 {
            font-size: 1.3rem;
            font-weight: 300;
            opacity: 0.9;
        }

        /* HERO SECTION MÁS COMPACTO */
        .hero {
            background: var(--gradient-secondary);
            color: white;
            padding: 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.05"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.1rem;
            margin-bottom: 0;
            opacity: 0.9;
        }

        .highlight {
            color: var(--accent);
            font-weight: 700;
        }

        /* TABS MÁS CERCANOS AL HERO */
        .tabs-section {
            background: white;
            padding: 1.5rem;
            margin: -1rem auto 0;
            max-width: 1200px;
            border-radius: 15px;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 10;
        }

        .tabs-container {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 1rem 2rem;
            background: white;
            border: 2px solid var(--primary);
            color: var(--primary);
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.1rem;
        }

        .tab-btn:hover, .tab-btn.active {
            background: var(--gradient-primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        /* FORMULARIO MEJORADO */
        .form-section {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .form-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: var(--shadow);
            border-left: 5px solid var(--primary);
        }

        .form-card h3 {
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group input {
            padding: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(189, 22, 34, 0.1);
            outline: none;
        }

        .submit-btn {
            width: 100%;
            padding: 1.2rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        /* CARRERAS SECTION CON MEDIA ESCALABLE */
        .career-section {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .career-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 3rem;
            transition: transform 0.3s ease;
        }

        .career-card:hover {
            transform: translateY(-5px);
        }

        .career-header {
            background: var(--gradient-primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .career-header h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: var(--success);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 1rem 0;
        }

        .whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* MEDIA CONTAINER MEJORADO - MISMAS MEDIDAS */
        .media-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 2rem;
            align-items: stretch;
        }

        .video-container, .carousel-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 350px;
            position: relative;
        }

        .video-container {
            background: #000;
        }

        .video-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            object-fit: cover;
        }

        .carousel-container {
            background: var(--dark);
        }

        .carousel-images {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .carousel-images img.active {
            opacity: 1;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(189, 22, 34, 0.8);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .carousel-btn:hover {
            background: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        .prev { left: 1rem; }
        .next { right: 1rem; }

        /* FEATURES GRID - MOVIDO DESPUÉS DE CARRERAS Y MÁS COMPACTO */
        .features-section {
            max-width: 1200px;
            margin: 4rem auto 3rem;
            padding: 0 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .feature-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: var(--secondary);
            margin-bottom: 0.8rem;
            font-size: 1.3rem;
        }

        .feature-card p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* ALERTS */
        .alert {
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1rem 0;
            font-weight: 600;
            text-align: center;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        /* FOOTER CON IMAGEN DE FONDO */
        .main-footer {
            background: var(--gradient-secondary);
            color: white;
            padding: 4rem 2rem 2rem;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        .main-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('Fachada.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.2;
            z-index: 1;
        }

        .footer-content, .footer-bottom {
            position: relative;
            z-index: 2;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .footer-info h3 {
            color: var(--accent);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .contact-list {
            list-style: none;
        }

        .contact-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .contact-list i {
            width: 20px;
            color: var(--accent);
        }

        .contact-list a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-list a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* RESPONSIVE DESIGN MEJORADO - FEATURES MÁS COMPACTOS EN MÓVIL */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .hero {
                padding: 1.5rem 1rem;
                min-height: 150px;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .form-card {
                padding: 2rem 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .career-header h2 {
                font-size: 1.6rem;
            }

            .media-container {
                grid-template-columns: 1fr;
                padding: 1rem;
                gap: 1rem;
            }

            .video-container, .carousel-container {
                height: 250px;
            }

            .tabs-section {
                margin: -0.5rem auto 0;
                padding: 1rem;
            }

            .tab-btn {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }

            /* FEATURES MÁS COMPACTOS EN MÓVIL */
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .feature-card {
                padding: 1.2rem;
                margin-bottom: 0.5rem;
            }

            .feature-icon {
                font-size: 2rem;
                margin-bottom: 0.8rem;
            }

            .feature-card h3 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }

            .feature-card p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 1rem;
                min-height: 120px;
            }

            .hero h1 {
                font-size: 1.5rem;
            }

            .tabs-section {
                padding: 1rem;
            }

            .tab-btn {
                width: 100%;
                justify-content: center;
            }

            /* FEATURES AÚN MÁS COMPACTOS EN TELÉFONO PEQUEÑO */
            .feature-card {
                padding: 1rem;
            }

            .feature-icon {
                font-size: 1.8rem;
            }

            .feature-card h3 {
                font-size: 1.1rem;
            }

            .feature-card p {
                font-size: 0.85rem;
            }
        }

        /* ANIMATIONS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body>
    <!-- HEADER CON LOGO VISIBLE -->
    <header class="main-header">
        <div class="header-content">
            <div class="logo-container">
                <img src="unilova_logo.png" alt="Universidad LOVA">
                <div class="logo-text">
                    <h1>Universidad LOVA</h1>
                    <h2>Excelencia en Educación Técnica</h2>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION COMPACTO -->
    <section class="hero">
        <div class="hero-content fade-in-up">
            <h1>Transforma tu Futuro con <span class="highlight">Carreras Técnicas</span></h1>
            <p>Formación especializada con alta demanda laboral</p>
        </div>
    </section>

    <!-- TABS SECTION CERCANO -->
    <section class="tabs-section">
        <div class="tabs-container">
            <button class="tab-btn active" onclick="scrollToSection('mecatronica')">
                <i class="fas fa-robot"></i>
                Tec. Mecatrónica
            </button>
            <button class="tab-btn" onclick="scrollToSection('mantenimiento')">
                <i class="fas fa-tools"></i>
                Tec. Mantenimiento Industrial
            </button>
        </div>
    </section>

    <!-- FORM SECTION -->
    <section class="form-section">
        <?php if ($mensajeEnviado): ?>
            <div class="alert alert-success">
                <?php if ($db_success): ?>
                    <i class="fas fa-check-circle"></i> ¡Felicidades! Tu registro ha sido exitoso. Nos contactaremos contigo pronto.
                <?php else: ?>
                    <i class="fas fa-check-circle"></i> ¡Gracias! Hemos recibido tu información correctamente.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($db_error) && $db_error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> Error temporal. Por favor, intenta nuevamente.
            </div>
        <?php endif; ?>

        <div class="form-card fade-in-up">
            <h3><i class="fas fa-edit"></i> Formulario de Inscripción</h3>
            <form method="POST" id="inscripcionForm">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre"><i class="fas fa-user"></i> Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                    </div>
                    <div class="form-group">
                        <label for="correo"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                        <input type="email" id="correo" name="correo" required placeholder="ejemplo@correo.com">
                    </div>
                    <div class="form-group">
                        <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" required placeholder="449 123 4567">
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> ¡QUIERO INSCRIBIRME AHORA!
                </button>
            </form>
        </div>
    </section>

    <!-- CARRERAS -->
    <section class="career-section">
        <!-- MECATRÓNICA -->
        <div class="career-card" id="mecatronica">
            <div class="career-header">
                <h2><i class="fas fa-robot"></i> Técnico en Mecatrónica</h2>
                <p>Formación en automatización, robótica y sistemas inteligentes</p>
                <a href="https://wa.me/5214492254967/?text=Hola,%20quiero%20saber%20m%C3%A1s%20sobre%20la%20carrera%20de%20Técnico%20en%20Mecatrónica%20en%20Universidad%20LOVA" 
                   class="whatsapp-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i> Información por WhatsApp
                </a>
            </div>
            <div class="media-container">
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/Y_2kGtS0L-8" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                </div>
                <div class="carousel-container">
                    <div class="carousel-images" id="carouselMecatronica">
                        <img src="MECATRONICA1.jpg" class="active" alt="Mecatrónica 1">
                        <img src="MECATRONICA2.jpg" alt="Mecatrónica 2">
                        <img src="MECATRONICA3.jpg" alt="Mecatrónica 3">
                    </div>
                    <button class="carousel-btn prev" onclick="moveCarousel('Mecatronica', -1)">‹</button>
                    <button class="carousel-btn next" onclick="moveCarousel('Mecatronica', 1)">›</button>
                </div>
            </div>
        </div>

        <!-- MANTENIMIENTO INDUSTRIAL -->
        <div class="career-card" id="mantenimiento">
            <div class="career-header">
                <h2><i class="fas fa-tools"></i> Técnico en Mantenimiento Industrial</h2>
                <p>Especialista en mantenimiento predictivo y correctivo de maquinaria industrial</p>
                <a href="https://wa.me/5214492254967/?text=Hola,%20quiero%20saber%20m%C3%A1s%20sobre%20la%20carrera%20de%20Técnico%20en%20Mantenimiento%20Industrial%20en%20Universidad%20LOVA" 
                   class="whatsapp-btn" target="_blank">
                    <i class="fab fa-whatsapp"></i> Información por WhatsApp
                </a>
            </div>
            <div class="media-container">
                <div class="video-container">
                    <iframe src="https://www.youtube.com/embed/jBuizjlJUok" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                </div>
                <div class="carousel-container">
                    <div class="carousel-images" id="carouselMantenimiento">
                        <img src="MANTENIMIENTO1.jpg" class="active" alt="Mantenimiento 1">
                        <img src="MANTENIMIENTO2.jpg" alt="Mantenimiento 2">
                        <img src="MANTENIMIENTO3.jpg" alt="Mantenimiento 3">
                    </div>
                    <button class="carousel-btn prev" onclick="moveCarousel('Mantenimiento', -1)">‹</button>
                    <button class="carousel-btn next" onclick="moveCarousel('Mantenimiento', 1)">›</button>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION - MOVIDA DESPUÉS DE LAS CARRERAS -->
    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Título Oficial</h3>
                <p>Programas educativos con reconocimiento oficial SEP</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Bolsa de Trabajo</h3>
                <p>Convenios con las mejores empresas de la región</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Docentes Calificados</h3>
                <p>Profesores con amplia experiencia industrial</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-laptop-house"></i>
                </div>
                <h3>Modalidades Flexibles</h3>
                <p>Estudia en horarios que se adapten a tus necesidades</p>
            </div>
        </div>
    </section>

    <!-- FOOTER CON IMAGEN DE FONDO -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-info">
                <h3>Contacto</h3>
                <ul class="contact-list">
                    <li>
                        <i class="fab fa-whatsapp"></i>
                        <div>
                            <strong>WhatsApp:</strong><br>
                            <a href="https://wa.me/5214492254967" target="_blank">449 225 4967</a>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Teléfono:</strong><br>
                            <a href="tel:4497357910">449 735 7910</a>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Correo:</strong><br>
                            <a href="mailto:ventas1@unilova.mx">ventas1@unilova.mx</a>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Dirección:</strong><br>
                            Av. Siglo XXI, No. 7301<br>
                            Fracc. Solidaridad III<br>
                            C.P. 20263, Aguascalientes
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Universidad LOVA. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function moveCarousel(id, direction) {
            const carousel = document.getElementById(`carousel${id}`);
            const images = carousel.querySelectorAll('img');
            let activeIndex = 0;
            
            images.forEach((img, index) => {
                if (img.classList.contains('active')) {
                    activeIndex = index;
                }
            });
            
            images[activeIndex].classList.remove('active');
            
            let newIndex = (activeIndex + direction + images.length) % images.length;
            images[newIndex].classList.add('active');
        }

        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
            
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }

        // Auto carousel
        setInterval(() => {
            moveCarousel('Mecatronica', 1);
        }, 5000);

        setInterval(() => {
            moveCarousel('Mantenimiento', 1);
        }, 5000);

        // Form validation
        document.getElementById('inscripcionForm').addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const correo = document.getElementById('correo').value.trim();
            const telefono = document.getElementById('telefono').value.trim();
            
            if (!nombre || !correo || !telefono) {
                e.preventDefault();
                alert('Por favor, completa todos los campos del formulario.');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(correo)) {
                e.preventDefault();
                alert('Por favor, ingresa un correo electrónico válido.');
                return false;
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.career-card, .feature-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html> 