<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .success-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success-message h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .payment-animation {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid #28a745;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .receipt {
            margin-top: 30px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            text-align: left;
            background-color: #e9ecef;
        }
        .receipt h3 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        .receipt p {
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        .receipt p strong {
            color: #495057;
        }
        #qr-code {
            margin-top: 20px;
            display: inline-block; /* Important for QR code generation */
        }
        .back-to-home {
            margin-top: 30px;
        }
        .back-to-home a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .back-to-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-message">
            <h1>¡Pago Procesado Exitosamente!</h1>
            <p>Gracias por tu compra. Tu reserva ha sido confirmada.</p>
        </div>
        <div class="payment-animation"></div>

        <div class="receipt">
            <h3>Detalles de la Reserva</h3>
            <p><strong>ID de Orden:</strong> <span id="receipt-order-id"></span></p>
            <p><strong>Nombre:</strong> <span id="receipt-name"></span></p>
            <p><strong>Película:</strong> <span id="receipt-movie-title"></span></p>
            <p><strong>Sala:</strong> <span id="receipt-theatre"></span></p>
            <p><strong>Tipo:</strong> <span id="receipt-type"></span></p>
            <p><strong>Fecha:</strong> <span id="receipt-date"></span></p>
            <p><strong>Hora:</strong> <span id="receipt-time"></span></p>
            <p><strong>Asientos:</strong> <span id="receipt-seats"></span></p>
            <p><strong>Monto Pagado:</strong> <span id="receipt-amount"></span></p>
            <p><strong>Email:</strong> <span id="receipt-email"></span></p>
            <p><strong>Teléfono:</strong> <span id="receipt-mobile"></span></p>

            <div id="qr-code">
                <img id="qr-code-image" src="Verify.png" alt="Código QR" style="max-width: 200px;">
            </div>
            <p class="text-muted">Escanea el QR para más información o para acceder a tu entrada.</p>
        </div>

        <div class="back-to-home">
            <a href="index.php">Volver a la página principal</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);

            const orderId = urlParams.get('order_id');
            const movieTitle = decodeURIComponent(urlParams.get('movie_title'));
            const seats = urlParams.get('seats');
            const amount = urlParams.get('amount');
            const name = decodeURIComponent(urlParams.get('name'));
            const email = urlParams.get('email');
            const mobile = urlParams.get('mobile');
            const theatre = urlParams.get('theatre');
            const type = urlParams.get('type');
            const date = urlParams.get('date');
            const time = urlParams.get('time');
            // const qrCodePath = urlParams.get('qr_code_path'); // No longer needed as src is hardcoded

            document.getElementById('receipt-order-id').textContent = orderId || 'N/A';
            document.getElementById('receipt-name').textContent = name || 'N/A';
            document.getElementById('receipt-movie-title').textContent = movieTitle || 'N/A';
            document.getElementById('receipt-theatre').textContent = theatre || 'N/A';
            document.getElementById('receipt-type').textContent = type || 'N/A';
            document.getElementById('receipt-date').textContent = date || 'N/A';
            document.getElementById('receipt-time').textContent = time || 'N/A';
            document.getElementById('receipt-seats').textContent = seats || 'N/A';
            document.getElementById('receipt-amount').textContent = `$${amount}` || 'N/A';
            document.getElementById('receipt-email').textContent = email || 'N/A';
            document.getElementById('receipt-mobile').textContent = mobile || 'N/A';

            // Display QR Code image (src is now set directly in HTML)
            // const qrCodeImageElement = document.getElementById('qr-code-image');
            // if (qrCodeImageElement) {
            //     qrCodeImageElement.src = 'Verify.png'; // Always use Verify.png
            // }
        });
    </script>
</body>
</html>
