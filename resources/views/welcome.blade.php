<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{setting('site.title')}} - {{setting('site.description')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user me-1"></i> Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="hero">
        <div class="container">
            <h1>Cuidamos a tu mascota como si fuera nuestra</h1>
            <p class="lead">En {{setting('site.title')}} ofrecemos servicios médicos de calidad para perros, gatos y animales exóticos. Tu mascota está en las mejores manos.</p>
            <a href="#cita" class="btn btn-success btn-lg me-3">Solicitar Cita</a>
            <a href="#servicios" class="btn btn-outline-light btn-lg">Nuestros Servicios</a>
        </div>
    </section>

    <!-- Servicios Section -->
    <section id="servicios" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Nuestros Servicios</h2>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
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
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
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
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
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
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
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
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
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
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
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
            <h2 class="section-title" data-aos="fade-up">Solicita una Cita</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="form-container">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form id="appointment-form" action="{{ route('appointment.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre completo *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pet-name" class="form-label">Nombre de la mascota *</label>
                                    <input type="text" class="form-control" id="pet-name" name="pet_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pet-type" class="form-label">Especie *</label>
                                    <select class="form-select" id="pet-type" name="pet_type" required>
                                        <option value="" selected disabled>Seleccione...</option>
                                        @foreach ($animals as $animal)
                                            <option value="{{$animal->id}}">{{$animal->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="service" class="form-label">Servicio solicitado *</label>
                                <select class="form-select" id="service" name="service" required>
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
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
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
            <h2 class="section-title" data-aos="fade-up">Lo que dicen nuestros clientes</h2>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Llevo a mi perro Max desde que era cachorro. El personal es muy amable y profesional. Siempre recibe la mejor atención."
                        </div>
                        <div class="testimonial-author">- María González</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            "Mi gata Luna tuvo una emergencia y la atendieron inmediatamente. Estoy muy agradecida con el Dr. Cortez y su equipo."
                        </div>
                        <div class="testimonial-author">- Carlos Rodríguez</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
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
            <h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
            <div class="row">
                <div class="col-md-6" data-aos="fade-right">
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
                <div class="col-md-6" data-aos="fade-left">
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
                {{-- <p>&copy; 2023 {{setting('site.title')}}. Todos los derechos reservados.</p> --}}
                <a style="color: rgb(255, 255, 255); font-size: 15px" href="https://www.soluciondigital.dev/" target="_blank">Copyright <small style="font-size: 15px">SolucionDigital {{date('Y')}}</small>
                    {{-- <br>Todos los derechos reservados. --}}
                </a>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/591{{setting('redes-sociales.whatsapp')}}?text=Hola,%20me%20interesa%20solicitar%20una%20cita%20para%20mi%20mascota" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp whatsapp-icon"></i>
        <span class="whatsapp-text">¡Chatea con nosotros!</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
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

        // Inicializar AOS (Animate On Scroll)
        AOS.init({
            duration: 800, // Duración de la animación en milisegundos
        });
    </script>
</body>
</html>
