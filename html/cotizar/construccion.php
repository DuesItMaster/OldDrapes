<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dues Textil: Calidad e innovación. Estamos construyendo nuestra nueva plataforma digital para un servicio superior.">
    <title>Dues Textil | Plataforma en Desarrollo</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Paleta de colores corporativa: limpia, seria y de alto contraste */
            --color-fondo: #F8F9FA;          /* Blanco roto, más suave a la vista */
            --color-texto-principal: #212529; /* Negro muy oscuro, casi total */
            --color-texto-secundario: #6C757D;/* Gris corporativo */
            --color-acento: #0D2F4F;          /* Azul naval profundo y serio */
        }

        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--color-fondo);
        }

        /* --- Contenedor principal con layout dividido --- */
        .split-layout {
            display: grid;
            grid-template-columns: 3fr 7fr; /* Dos columnas iguales */
            height: 100%;
            width: 100%;
        }

        

        /* --- Panel de Contenido (Derecha) --- */
        .content-panel {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Alinea el contenido hacia arriba */
            flex-direction: column;
            padding: clamp(2rem, 10vw, 6rem); /* Padding adaptable */
            overflow-y: auto; /* Permite scroll si el contenido es mucho */
        }
        
        .content-wrapper {
            max-width: 450px;
            width: 100%;
            animation: fadeIn 1.2s ease-out;
        }

        .logo {
            max-width: 160px;
            margin-bottom: 3.5rem; /* Más espacio para que respire */
        }

        h1 {
            font-size: clamp(2rem, 5vw, 2.8rem);
            font-weight: 700;
            color: var(--color-texto-principal);
            margin: 0 0 1rem 0;
            line-height: 1.3;
            letter-spacing: -1px; /* Detalle tipográfico profesional */
        }

        .subtitle {
            font-size: clamp(1rem, 2.5vw, 1.1rem);
            font-weight: 300;
            color: var(--color-texto-secundario);
            margin: 0 0 2.5rem 0;
            line-height: 1.8;
        }

        /* --- Llamada a la acción (CTA) minimalista --- */
        .cta-heading {
            font-weight: 600;
            color: var(--color-texto-principal);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .cta-link {
            display: inline-block;
            font-size: 1rem;
            text-decoration: none;
            color: var(--color-acento);
            font-weight: 600;
            padding: 10px 0;
            position: relative;
            transition: color 0.3s ease;
        }

        .cta-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--color-acento);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease-out;
        }
        
        .cta-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .footer-text {
            margin-top: 4rem;
            font-size: 0.8rem;
            color: #ADB5BD; /* Un gris aún más claro */
        }
        
        /* --- Animación de entrada --- */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- RESPONSIVIDAD: En pantallas pequeñas, el layout se apila --- */
        @media (max-width: 900px) {
            .split-layout {
                grid-template-columns: 1fr; /* Una sola columna */
            }
            .image-panel {
                min-height: 300px; /* Altura mínima para la imagen en móvil */
                height: 40vh;
            }
            .content-panel {
                align-items: center; /* Centra el contenido en móvil */
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <main class="split-layout">
        
        <div class="image-panel"></div>

        <div class="content-panel">
            <div class="content-wrapper">
                <img src="due.png" alt="Logo de Dues Textil" class="logo">
                
                <h1>Calidad e Innovación Textil. Próximamente en línea.</h1>
                
                <p class="subtitle">Estamos desarrollando una nueva plataforma digital para ofrecer un servicio más ágil y un catálogo de productos optimizado a nuestros clientes.</p>
                
                <h3 class="cta-heading">¿Necesitas atención inmediata?</h3>
                <a href="mailto:ventas@duestextil.com?subject=Solicitud de información" class="cta-link">
                    Contacta a un distribuidor
                </a>

                <p class="footer-text">
                    &copy; 2025 Dues Textil.
                </p>
            </div>
        </div>

    </main>

</body>
</html>