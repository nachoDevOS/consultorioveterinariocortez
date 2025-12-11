<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma - {{Voyager::setting('admin.title') }}</title>
    <style>
        :root {
            --primary: #1a3e72;
            --accent: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--dark);
            line-height: 1.6;
            background-color: #f1f5f9;
        }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary) 0%, #2a4a7e 100%);
            color: white;
            padding: 10px 50px;
            position: relative;
            overflow: hidden;
        }
        
        .header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent);
        }
        
        .logo-header {
            display: flex;
            align-items: center;
            margin-bottom: 0px;
        }
        
        .logo {
            height: 70px;
            margin-right: 20px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 5px 0;
            letter-spacing: 0.5px;
        }
        
        .company-tagline {
            font-size: 12px;
            opacity: 0.9;
            margin: 0;
            font-weight: 400;
        }
        
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
            font-size: 13px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
        }
        
        .contact-item i {
            margin-right: 6px;
            font-size: 14px;
        }
        
        .document-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 50px;
            background: var(--light);
            border-bottom: 1px solid #e9ecef;
        }
        
        .document-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
        }
        
        .document-meta {
            text-align: right;
        }
        
        .document-number {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 5px;
        }
        
        .document-date {
            font-size: 13px;
            color: var(--gray);
        }
        
        .client-section {
            padding: 0px 50px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .section-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }
        
        .section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e9ecef;
            margin-left: 15px;
        }
        
        .client-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .client-detail {
            margin-bottom: 0px;
        }
        
        .detail-label {
            font-size: 13px;
            color: var(--gray);
            margin-bottom: 3px;
            display: block;
        }
        
        .detail-value {
            font-weight: 300;
        }
        
        .products-section {
            padding: 0 40px;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0 30px;
        }
        
        .products-table thead {
            background: var(--primary);
            color: white;
        }
        
        .products-table th {
            padding: 0px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
        }
        
        .products-table td {
            padding: 5px 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }
        
        .products-table tr:last-child td {
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals-container {
            margin-left: auto;
            width: 300px;
            border-top: 2px solid var(--primary);
            margin-bottom: 0px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        
        .total-label {
            font-weight: 500;
        }
        
        .grand-total {
            font-weight: 700;
            font-size: 15px;
            color: var(--primary);
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            padding: 30px 40px;
            border-top: 1px solid #e9ecef;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid var(--gray);
            margin: 25px auto 10px;
            width: 80%;
        }
        
        .footer {
            background: var(--primary);
            color: white;
            padding: 0px 40px;
            text-align: center;
            font-size: 13px;
        }
        
        .footer p {
            margin: 0px 0;
            opacity: 0.9;
        }
        
        .thank-you {
            font-weight: 500;
            margin-bottom: 10px !important;
            font-size: 14px;
        }
        
        .decorative-border {
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--accent) 50%, var(--primary) 100%);
        }
        
        /* Estilos para los botones */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px 0;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }
        
        .print-button, .cancel-button {
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .print-button {
            background-color: var(--primary);
            color: white;
        }
        
        .print-button:hover {
            background-color: #142f5c;
            transform: translateY(-2px);
        }
        
        .cancel-button {
            background-color: var(--accent);
            color: white;
        }
        
        .cancel-button:hover {
            background-color: #c1121f;
            transform: translateY(-2px);
        }
        
        @media print {
            .button-container {
                display: none;
            }
            
            body {
                background: none;
            }
            
            .container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-header">
                <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
                @if($admin_favicon == '')
                    <img src="{{ asset('images/icon.png')}}" alt="{{Voyager::setting('admin.title') }}" width="70px" class="logo">
                @else
                    <img src="{{ Voyager::image($admin_favicon) }}" alt="{{Voyager::setting('admin.title') }}" width="70px" class="logo">
                @endif


                {{-- <img src="https://via.placeholder.com/70x70/1a3e72/ffffff?text=ME" alt="Logo" class="logo"> --}}
                <div class="company-info">
                    <h1 class="company-name">{{strtoupper(Voyager::setting('admin.title')) }}</h1>
                    <p class="company-tagline">Repuestos de alta calidad para tu moto</p>
                </div>
            </div>
            {{-- <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    Av. Los Motores 123,
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    (591) 67285914
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    ventas@motorepuesto.com
                </div>
                <div class="contact-item">
                    <i class="fas fa-id-card"></i>
                    RUC: 20123456789
                </div>
            </div> --}}
        </div>
        
        <div class="decorative-border"></div>
        
        <div class="document-head">
            <h2 class="document-title">PROFORMA DE VENTA</h2>
            <div class="document-meta">
                <div class="document-number">N°: {{$sale->code}}</div>
                <div class="document-date">Fecha: <span id="current-date">{{date('d/m/Y h:i a', strtotime($sale->dateSale))}}</span></div>
            </div>
        </div>
        
        <div class="client-section">
            <div class="section-title">
                <i class="fas fa-user-circle" style="margin-right: 8px;"></i>
                Datos del cliente
            </div>
            <div class="client-grid">
                <div class="client-detail">
                    <span class="detail-label">Nombre/Razón Social</span>
                    <span style="font-size: 14px" class="detail-value">{{$sale->person?$sale->person->first_name.' '.$sale->person->paternal_surname.' '.$sale->person->maternal_surname:'Cliente ocasional'}}</span>
                </div>
                <div class="client-detail">
                    <span class="detail-label">CI/NIT</span>
                    <span style="font-size: 14px" class="detail-value">{{$sale->person?$sale->person->ci:'Sin documento'}}</span>
                </div>
            </div>
        </div>
        
        <div class="products-section">
            <div class="section-title">
                <i class="fas fa-list-alt" style="margin-right: 8px;"></i>
                Detalle de productos
            </div>
            <table class="products-table">
                <thead>
                    <tr>
                        <th width="5%">N&deg;</th>
                        <th width="60%">Descripción</th>
                        <th width="10%" class="text-center">Cant.</th>
                        <th width="15%" class="text-right">P. Unit.</th>
                        <th width="10%" class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i =1;
                        $total=0;
                    @endphp
                    @foreach ($sale->saleDetails as $item)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$item->name}}</td>
                            <td class="text-center">{{ number_format($item->quantity, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->price, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->amount, 2, ',', '.') }}</td>
                        </tr>
                        @php
                            $i++;
                            $total+=$item->amount;
                        @endphp
                    @endforeach                    
                </tbody>
            </table>
            
            <div class="totals-container">
                {{-- <div class="total-row">
                    <span class="total-label">Subtotal:</span>
                    <span>S/ 1,084.00</span>
                </div>
                <div class="total-row">
                    <span class="total-label">IGV (18%):</span>
                    <span>S/ 195.12</span>
                </div> --}}
                <div class="total-row grand-total">
                    <span>TOTAL:</span>
                    <span>Bs. {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        
        <div class="footer">
            <p class="thank-you">¡Gracias por su preferencia!</p>
            {{-- <p>Horario de atención: Lunes a Viernes 8:30 am - 6:30 pm | Sábados 9:00 am - 1:00 pm</p> --}}
        </div>
        
        <div class="button-container">
            <button class="print-button" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button class="cancel-button" onclick="cancelProforma()">
                <i class="fas fa-times-circle"></i> Cancelar
            </button>
        </div>
    </div>
    
    <script>
        // Script para fecha automática
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();
            
            document.getElementById('current-date').textContent = dd + '/' + mm + '/' + yyyy;
        });
        
        // Función para el botón Cancelar
        function cancelProforma() {
            window.close();
        }
        
        // Configuración para impresión
        window.addEventListener('beforeprint', function() {
            // Puedes agregar ajustes específicos antes de imprimir
            console.log('Preparando para imprimir...');
        });
    </script>
</body>
</html>