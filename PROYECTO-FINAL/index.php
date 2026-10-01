<?php
require_once __DIR__ . '/includes/init.php';

// Si el usuario ya inició sesión, redirigirlo a su dashboard
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . '/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido | Fit Bull Center</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0f172a;
            color: #fff;
            overflow-x: hidden;
        }

        /* Navbar & Tiny Login */
        .navbar {
            background: rgba(15, 23, 42, 0.9) !important;
            backdrop-filter: blur(10px);
        }
        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff;
            text-decoration: none;
        }
        .brand-logo span { color: #e94560; }
        .tiny-login {
            font-size: 0.75rem;
            color: #94a3b8;
            text-decoration: none;
            opacity: 0.7;
            transition: all 0.3s;
        }
        .tiny-login:hover {
            opacity: 1;
            color: #cbd5e1;
        }

        /* Hero Section */
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop') center/cover no-repeat;
            position: relative;
        }
        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            text-transform: uppercase;
            background: linear-gradient(45deg, #e94560, #ff758f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Info Section */
        .info-section, .location-section {
            padding: 100px 0;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 50px;
            text-align: center;
            color: #e94560;
        }
        .feature-card {
            background: #1e293b;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            transition: transform 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            background: #27374d;
        }
        .feature-icon {
            font-size: 3rem;
            color: #e94560;
            margin-bottom: 20px;
        }

        /* Location */
        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            height: 400px;
        }
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Footer */
        footer {
            background: #0b1120;
            padding: 30px 0;
            text-align: center;
            font-size: 0.9rem;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="brand-logo" href="#">Fit Bull<span> Center</span></a>
            
            <!-- Opción de Login pequeñita y discreta a un lado -->
            <a href="<?= BASE_URL ?>/login.php" class="tiny-login">
                <i class="fa-solid fa-lock"></i> Staff Acceso
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center" id="inicio">
        <div class="container">
            <div data-aos="fade-up" data-aos-duration="1000">
                <h1 class="hero-title mb-3">Supera Tus Límites</h1>
                <p class="lead text-light mb-5 fs-4">El gimnasio con el mejor equipamiento y ambiente para alcanzar tus metas.</p>
                <a href="#informacion" class="btn btn-outline-light btn-lg rounded-pill px-5 py-3 fw-bold" style="border-width: 2px;">Descubre Más</a>
            </div>
        </div>
        <!-- Scroll indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 delay-2" style="animation: bounce 2s infinite;">
            <i class="fa-solid fa-chevron-down fs-3 text-white-50"></i>
        </div>
    </section>

    <!-- Info / Services Section -->
    <section class="info-section bg-slate-900" id="informacion">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">¿Por qué elegirnos?</h2>
            
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <i class="fa-solid fa-dumbbell feature-icon"></i>
                        <h4 class="fw-bold mb-3">Equipamiento Premium</h4>
                        <p class="text-muted">Contamos con máquinas de última generación importadas, pesas libres y zonas especializadas para hipertrofia y cardio.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <i class="fa-solid fa-heart-pulse feature-icon"></i>
                        <h4 class="fw-bold mb-3">Clases Grupales</h4>
                        <p class="text-muted">Spinning, Yoga, Crossfit, Zumba y más. Todo guiado por instructores profesionales certificados.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <i class="fa-solid fa-spa feature-icon"></i>
                        <h4 class="fw-bold mb-3">Instalaciones de Lujo</h4>
                        <p class="text-muted">Vestidores higiénicos, duchas, área de cafetería, suplementos y ambiente climatizado para tu confort.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Section -->
    <section class="location-section" style="background-color: #0b1120;" id="ubicacion">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 mb-5 mb-md-0" data-aos="fade-right">
                    <h2 class="section-title text-start mb-4">Nuestra Ubicación</h2>
                    <h4 class="fw-bold mb-3"><i class="fa-solid fa-map-location-dot text-danger me-2"></i> Encuéntranos en</h4>
                    <p class="text-muted fs-5 mb-4">Av. Principal #1234, Centro de la Ciudad.<br>Estamos justo frente al parque central.</p>
                    
                    <h5 class="fw-bold"><i class="fa-regular fa-clock text-danger me-2"></i> Horario de Atención</h5>
                    <ul class="list-unstyled text-muted mt-2">
                        <li><strong>Lunes a Viernes:</strong> 06:00 am - 10:00 pm</li>
                        <li><strong>Sábados:</strong> 07:00 am - 06:00 pm</li>
                        <li><strong>Domingos:</strong> 08:00 am - 02:00 pm</li>
                    </ul>
                </div>
                <div class="col-md-7" data-aos="fade-left">
                    <!-- Mapa Embebido de Google (Puedes cambiar la dirección en src) -->
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1144.5!2d-75.0!3d40.0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDAwJzAwLjAiTiA3NcKwMDAnMDAuMCJX!5e0!3m2!1sen!2sus!4v1600000000000!5m2!1sen!2sus" 
                            allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <h5 class="text-white fw-bold mb-3">Fit Bull Center</h5>
            <p class="mb-0">&copy; <?= date('Y') ?> Fit Bull Center. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.css"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inicializar animaciones de AOS
        AOS.init({
            once: true, // La animación solo se ejecuta una vez al hacer scroll
            offset: 100 // Distancia en px para activar la animación
        });

        // Keyframes CSS inyectados para el indicador de scroll
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-20px); }
                60% { transform: translateY(-10px); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>