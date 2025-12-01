<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{setting('site.title')}} - {{setting('site.description')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4a90e2;
            --secondary: #7ed321;
            --accent: #ff6b6b;
            --dark: #333333;
            --light: #f8f9fa;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .hero {
            background: linear-gradient(rgba(74, 144, 226, 0.8), rgba(126, 211, 33, 0.7)), url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #3a7bc8;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background-color: var(--secondary);
            border: none;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            background-color: #6bbd1d;
            transform: translateY(-2px);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--primary);
            margin: 15px auto;
        }
        
        .service-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            margin-bottom: 30px;
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
        }
        
        .service-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
        }
        
        .testimonial-author {
            font-weight: 500;
            color: var(--primary);
        }
        
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 30px;
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }
        
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }
        
        .whatsapp-float i {
            color: white;
            font-size: 1.8rem;
        }
        
        .contact-info {
            margin-bottom: 20px;
        }
        
        .contact-info i {
            color: var(--primary);
            margin-right: 10px;
            width: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-paw me-2"></i>
                <span class="d-none d-lg-inline">{{setting('site.title')}}</span>
                <span class="d-inline d-lg-none">{{\Illuminate\Support\Str::limit(setting('site.title'), 18, '')}}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#nosotros">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonios">Testimonios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="hero">
        <div class="container">
            <h1>Cuidamos a tu mascota como si fuera nuestra</h1>
            <p class="lead">En Consultorio Veterinario Cortez ofrecemos servicios médicos de calidad para perros, gatos y animales exóticos. Tu mascota está en las mejores manos.</p>
            <a href="#cita" class="btn btn-success btn-lg me-3">Solicitar Cita</a>
            <a href="#servicios" class="btn btn-outline-light btn-lg">Nuestros Servicios</a>
        </div>
    </section>

    <!-- Servicios Section -->
    <section id="servicios" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Nuestros Servicios</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <h4>Consulta General</h4>
                            <p>Exámenes de salud completos, diagnóstico y tratamiento para mantener a tu mascota saludable.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="fas fa-syringe"></i>
                            </div>
                            <h4>Vacunación</h4>
                            <p>Programas de vacunación personalizados para proteger a tu mascota de enfermedades comunes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="fas fa-cut"></i>
                            </div>
                            <h4>Cirugías</h4>
                            <p>Procedimientos quirúrgicos con equipos de última generación y anestesia segura.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="fas fa-teeth"></i>
                            </div>
                            <h4>Odontología</h4>
                            <p>Cuidado dental profesional, limpiezas y tratamientos para la salud bucal de tu mascota.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="fas fa-x-ray"></i>
                            </div>
                            <h4>Radiografías</h4>
                            <p>Servicio de diagnóstico por imágenes para detectar problemas óseos y de órganos internos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <h4>Hospitalización</h4>
                            <p>Área de recuperación y hospitalización con monitoreo constante para casos que lo requieran.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulario de Citas -->
    <section id="cita" class="py-5">
        <div class="container">
            <h2 class="section-title">Solicita una Cita</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-container">
                        <form id="appointment-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre completo *</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono *</label>
                                    <input type="tel" class="form-control" id="phone" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pet-name" class="form-label">Nombre de la mascota *</label>
                                    <input type="text" class="form-control" id="pet-name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pet-type" class="form-label">Tipo de mascota *</label>
                                    <select class="form-select" id="pet-type" required>
                                        <option value="">Seleccione...</option>
                                        <option value="perro">Perro</option>
                                        <option value="gato">Gato</option>
                                        <option value="ave">Ave</option>
                                        <option value="roedor">Roedor</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="service" class="form-label">Servicio solicitado *</label>
                                <select class="form-select" id="service" required>
                                    <option value="">Seleccione...</option>
                                    <option value="consulta">Consulta General</option>
                                    <option value="vacunacion">Vacunación</option>
                                    <option value="cirugia">Cirugía</option>
                                    <option value="odontologia">Odontología</option>
                                    <option value="radiografia">Radiografía</option>
                                    <option value="emergencia">Emergencia</option>
                                    <option value="otros">Otros</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Motivo de la consulta *</label>
                                <textarea class="form-control" id="message" rows="4" required></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">Acepto los términos y condiciones</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Solicitar Cita</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section id="testimonios" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Lo que dicen nuestros clientes</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Llevo a mi perro Max desde que era cachorro. El personal es muy amable y profesional. Siempre recibe la mejor atención."
                        </div>
                        <div class="testimonial-author">- María González</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Mi gata Luna tuvo una emergencia y la atendieron inmediatamente. Estoy muy agradecida con el Dr. Cortez y su equipo."
                        </div>
                        <div class="testimonial-author">- Carlos Rodríguez</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Excelente servicio y precios justos. Mis dos perros siempre están saludables gracias a sus cuidados preventivos."
                        </div>
                        <div class="testimonial-author">- Ana Martínez</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-5">
        <div class="container">
            <h2 class="section-title">Contáctanos</h2>
            <div class="row">
                <div class="col-md-6">
                    <h4>Información de contacto</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> {{setting('site.address')}}</p>
                        <p><i class="fas fa-phone"></i> +591 {{setting('redes-sociales.whatsapp')}}</p>
                        <p><i class="fas fa-envelope"></i> {{setting('site.email')??'SN'}}</p>
                        <p><i class="fas fa-clock"></i> Lunes a Viernes: 8:00 am - 6:00 pm</p>
                        <p><i class="fas fa-clock"></i> Sábados: 9:00 am - 2:00 pm</p>
                    </div>
                    <h4>Síguenos en redes sociales</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.952912260219!2d3.375295414770757!3d6.527631324807576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8b2ae68280c1%3A0xdc9e87a367c3d9cb!2sLagos%2C%20Nigeria!5e0!3m2!1sen!2sus!4v1647836132345!5m2!1sen!2sus" width="100%" height="300" style="border:0; border-radius: 10px;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4>{{setting('site.title')}}</h4>
                    <p>{{setting('site.description')}}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4>Enlaces rápidos</h4>
                    <ul class="list-unstyled">
                        <li><a href="#inicio" class="text-light">Inicio</a></li>
                        <li><a href="#servicios" class="text-light">Servicios</a></li>
                        <li><a href="#cita" class="text-light">Solicitar Cita</a></li>
                        <li><a href="#contacto" class="text-light">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h4>Suscríbete a nuestro boletín</h4>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Tu correo electrónico">
                        <button class="btn btn-primary" type="button">Suscribirse</button>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                {{-- <p>&copy; 2023 Consultorio Veterinario Cortez. Todos los derechos reservados.</p> --}}
                <a style="color: rgb(255, 255, 255); font-size: 15px" href="https://www.soluciondigital.dev/" target="_blank">Copyright <small style="font-size: 15px">SolucionDigital {{date('Y')}}</small>
                    {{-- <br>Todos los derechos reservados. --}}
                </a>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/1234567890?text=Hola,%20me%20interesa%20solicitar%20una%20cita%20para%20mi%20mascota" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form submission handling
        document.getElementById('appointment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple validation
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const petName = document.getElementById('pet-name').value;
            
            if(name && phone && petName) {
                alert('¡Gracias! Tu solicitud de cita ha sido enviada. Nos pondremos en contacto contigo pronto.');
                document.getElementById('appointment-form').reset();
            } else {
                alert('Por favor completa todos los campos obligatorios.');
            }
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>