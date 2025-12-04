<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{setting('site.title')}} - {{setting('site.description')}}</title>
    
            <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('site.logo', ''); ?>
    @if($admin_favicon == '')
        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif

    {{-- SEO --}}
    <meta property="og:title"         content="{{ Voyager::setting('site.title') }}" />
    <meta property="og:description"   content="{{ Voyager::setting('site.description') }}" />
    <meta property="og:image"         content="{{ $admin_favicon == '' ? asset('images/icon.png') : Voyager::image($admin_favicon) }}" />



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                 @if($admin_favicon != '')
                    <img src="{{ Voyager::image($admin_favicon) }}" alt="{{setting('site.title')}}" style="height: 80px; position: absolute; top: 0; margin-right: 100px;">
                 @else
                     <i class="fas fa-paw me-2"></i>
                 @endif
                <span class="d-none d-lg-inline" style="margin-left: 170px;">{{ setting('site.title') }}</span><br>
                {{-- <span class="d-inline d-lg-none" style="margin-left: 180px;">{{\Illuminate\Support\Str::limit(setting('site.title'), 18, '')}}</span> --}}
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
                        <form id="appointment-form" action="{{ route('appointment.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+591</span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Ej: 71234567" pattern="[0-9]{8}" title="Ingrese un número de 8 dígitos." required maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pet-name" class="form-label">Nombre de la mascota <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('pet_name') is-invalid @enderror" id="pet-name" name="pet_name" value="{{ old('pet_name') }}" required>
                                    @error('pet_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pet-type" class="form-label">Especie <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pet_type') is-invalid @enderror" id="pet-type" name="pet_type" required>
                                        <option value="" selected disabled>Seleccione...</option>
                                        @foreach ($animals as $animal)
                                            <option value="{{$animal->id}}" {{ old('pet_type') == $animal->id ? 'selected' : '' }}>{{$animal->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('pet_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pet_race" class="form-label">Raza <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pet_race') is-invalid @enderror" id="pet_race" name="pet_race" required disabled>
                                        <option value="" selected disabled>Primero seleccione una especie</option>
                                    </select>
                                    @error('pet_race')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pet-gender" class="form-label">Sexo de la mascota <span class="text-danger">*</span></label>
                                    <select class="form-select @error('pet_gender') is-invalid @enderror" id="pet-gender" name="pet_gender" required>
                                        <option value="" selected disabled>Seleccione...</option>
                                        <option value="Macho" {{ old('pet_gender') == 'Macho' ? 'selected' : '' }}>Macho</option>
                                        <option value="Hembra" {{ old('pet_gender') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                                        {{-- <option value="Desconocido">Desconocido</option> --}}
                                    </select>
                                    @error('pet_gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pet_age" class="form-label">Edad de la mascota <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('pet_age') is-invalid @enderror" id="pet_age" name="pet_age" value="{{ old('pet_age') }}" required>
                                    @error('pet_age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="appointment-date" class="form-label">Fecha de Atención <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment-date" name="appointment_date" value="{{ old('appointment_date') }}" required>
                                    @error('appointment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="appointment-time" class="form-label">Hora de Atención <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" id="appointment-time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                                    @error('appointment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="service" class="form-label">Servicio solicitado <span class="text-danger">*</span></label>
                                <select class="form-select @error('service') is-invalid @enderror" id="service" name="service" required>
                                    <option value="" selected disabled>Seleccione...</option>
                                    @foreach ($services as $service)
                                        <option value="{{$service->id}}" {{ old('service') == $service->id ? 'selected' : '' }}>{{$service->name}}</option>
                                    @endforeach
                                </select>
                                @error('service')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Motivo de la consulta <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="pet-photo" class="form-label">Subir Foto de la Mascota (opcional)</label>
                                    <input type="file" class="form-control @error('pet_photo') is-invalid @enderror" id="pet-photo" name="pet_photo" accept="image/*">
                                    @error('pet_photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="appointment-location" class="form-label">Ubicación para la Cita (Selecciona en el mapa) <span class="text-danger">*</span></label>
                                <div id="map" style="height: 400px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"></div>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="appointment-location" name="appointment_location" value="{{ old('appointment_location') }}" placeholder="La dirección aparecerá aquí..." readonly required>
                                <input type="hidden" id="latitude" name="latitude">
                                <input type="hidden" id="longitude" name="longitude">
                                @error('latitude')
                                    <div class="invalid-feedback">Por favor, selecciona una ubicación en el mapa.</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">Acepto los términos y condiciones <span class="text-danger">*</span></label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
                        {{-- <p><i class="fas fa-envelope"></i> {{setting('site.email')??'SN'}}</p> --}}
                        <p><i class="fas fa-clock"></i> Lunes a Viernes: 8:00 am - 6:00 pm</p>
                        <p><i class="fas fa-clock"></i> Sábados: 9:00 am - 2:00 pm</p>
                    </div>
                    <h4>Síguenos en redes sociales</h4>
                    <div class="social-links">
                        @if (setting('redes-sociales.facebook'))
                            <a href="{{setting('redes-sociales.facebook')}}"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if (setting('redes-sociales.instagram'))
                            <a href="{{setting('redes-sociales.instagram')}}"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if (setting('redes-sociales.tiktok'))
                            <a href="{{setting('redes-sociales.tiktok')}}"><i class="fa-brands fa-tiktok"></i></a>                            
                        @endif
                        @if (setting('redes-sociales.twitter'))
                            <a href="{{setting('redes-sociales.twitter')}}"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if (setting('redes-sociales.youtube'))
                           <a href="{{setting('redes-sociales.youtube')}}"><i class="fab fa-youtube"></i></a> 
                        @endif
                        
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
                <div class="col-md-6 mb-6">
                    <h4>{{setting('site.title')}}</h4>
                    <p>{{setting('site.description')}}</p>
                </div>
                <div class="col-md-6 mb-6 ">
                    <h4>Enlaces rápidos</h4>
                    <ul class="list-unstyled">
                        <li><a href="#inicio" class="text-light">Inicio</a></li>
                        <li><a href="#servicios" class="text-light">Servicios</a></li>
                        <li><a href="#cita" class="text-light">Solicitar Cita</a></li>
                        <li><a href="#contacto" class="text-light">Contacto</a></li>
                    </ul>
                </div>
                {{-- <div class="col-md-4 mb-4">
                    <h4>Suscríbete a nuestro boletín</h4>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Tu correo electrónico">
                        <button class="btn btn-primary" type="button">Suscribirse</button>
                    </div>
                </div> --}}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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

        // SweetAlert2 Toaster Notifications
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        @endif

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: 'Por favor, revisa los campos marcados en rojo.'
            })
        @endif

        // --- Leaflet Map for Location Picker ---
        // 1. Inicializar el mapa con una ubicación por defecto (Santa Cruz, Bolivia)
        const defaultLat = -14.8203618;
        const defaultLng = -64.897594; // Coordenadas de ejemplo
        // Mapbox permite un zoom mucho mayor, lo que da más nitidez.
        const map = L.map('map', { maxZoom: 20 }).setView([defaultLat, defaultLng], 17); 

        // 2. Definir las capas de mapa usando Mapbox
        const mapboxAccessToken = '{{ config('maps.mapbox.access_token') }}';

        const mapboxSatellite = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v12/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxAccessToken
        });

        const mapboxStreets = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: '© <a href="https://www.mapbox.com/about/maps/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> <strong><a href="https://www.mapbox.com/map-feedback/" target="_blank">Improve this map</a></strong>',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: mapboxAccessToken
        }).addTo(map); // Añadimos la capa de calles por defecto

        // Crear el objeto con las capas base para el control de capas
        const baseMaps = {
            "Satélite": mapboxSatellite,
            "Calles": mapboxStreets
        };
        // Añadir el control de capas al mapa
        L.control.layers(baseMaps).addTo(map);

        // 3. Crear un marcador arrastrable
        let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

        // 4. Obtener referencias a los campos del formulario
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');
        const locationInput = document.getElementById('appointment-location');
        locationInput.value = 'Arrastra el marcador o haz clic en el mapa para seleccionar.';

        // 5. Función para actualizar los campos y la dirección
        function updateMarkerPosition(lat, lng) {
            latInput.value = lat;
            lngInput.value = lng;

            // Geocodificación inversa para obtener la dirección (usando Nominatim)
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        locationInput.value = data.display_name;
                    } else {
                        locationInput.value = 'No se pudo obtener la dirección.';
                    }
                })
                .catch(error => {
                    console.error('Error en geocodificación inversa:', error);
                    locationInput.value = 'Error al obtener la dirección.';
                });
        }

        // 6. Eventos del mapa y marcador
        // Actualizar campos cuando el marcador se arrastra y se suelta
        marker.on('dragend', function(e) {
            const newPos = e.target.getLatLng();
            updateMarkerPosition(newPos.lat, newPos.lng);
        });

        // Mover el marcador al hacer clic o doble clic en el mapa
        map.on('click dblclick', function(e) {
            const newPos = e.latlng;
            marker.setLatLng(newPos);
            updateMarkerPosition(newPos.lat, newPos.lng);
        });

        // 7. Establecer la posición inicial del marcador (sin geocodificación inicial)
        latInput.value = defaultLat;
        lngInput.value = defaultLng;

        // --- Lógica para cargar Razas dinámicamente ---
        document.getElementById('pet-type').addEventListener('change', function() {
            const animalId = this.value;
            const raceSelect = document.getElementById('pet_race');

            // Limpiar y deshabilitar el select de razas mientras se carga
            raceSelect.innerHTML = '<option value="" selected disabled>Cargando razas...</option>';
            raceSelect.disabled = true;

            if (animalId) {
                // Hacer la petición AJAX para obtener las razas
                fetch(`{{ url('/api/races') }}/${animalId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('La respuesta de la red no fue exitosa');
                        }
                        return response.json();
                    })
                    .then(races => {
                        raceSelect.innerHTML = '<option value="" selected disabled>Seleccione una raza</option>';
                        if (races.length > 0) {
                            races.forEach(race => {
                                const option = document.createElement('option');
                                option.value = race.id;
                                option.textContent = race.name;
                                raceSelect.appendChild(option);
                            });

                            // Añadir la opción "Otras" al final
                            const otherOption = document.createElement('option');
                            otherOption.value = ""; // Valor vacío para no enviar ID
                            otherOption.textContent = "Otras";
                            raceSelect.appendChild(otherOption);

                            raceSelect.disabled = false; // Habilitar el select
                        } else {
                            // Si no hay razas, mostrar "Seleccione..." y "Otras"
                            raceSelect.innerHTML = '<option value="" selected disabled>Seleccione una opción</option>';
                            const otherOption = document.createElement('option');
                            otherOption.value = ""; // Valor vacío
                            otherOption.textContent = "Otras";
                            raceSelect.appendChild(otherOption);
                            raceSelect.disabled = false; // Habilitar para que se pueda enviar
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar las razas:', error);
                        raceSelect.innerHTML = '<option value="" selected disabled>Error al cargar razas</option>';
                    });
            }
        });

    </script>
</body>
</html>
