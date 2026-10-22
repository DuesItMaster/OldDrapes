<


    <style type="text/css">
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* --- Estilos ESPECÍFICOS para la sección de ANUNCIOS --- */

        #uhu_tj_9502 ul.pd { 
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 0;
            margin-top: 20px;
        }

        #uhu_tj_9502 .ajax_block_product {
            box-sizing: border-box;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            background-color: #fcfcfc;
            position: relative;
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 350px;
            min-height: 330px; /* Altura mínima para uniformidad */
        }

        #uhu_tj_9502 .ajax_block_product:hover {
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            border-color: #007bff;
        }

       @media (max-width: 767px) {
            #uhu_tj_9502 .ajax_block_product {
                width: 90% !important;
                min-height: auto; /* Desactiva la altura mínima en móviles */
            }
        }
        
        @media (min-width: 768px) and (max-width: 991px) {
            #uhu_tj_9502 .ajax_block_product {
                width: calc(50% - 15px) !important;
            }
        }
        
        @media (min-width: 992px) {
            #uhu_tj_9502 .ajax_block_product {
                width: calc(25% - 23px) !important; /* Ajuste para 4 columnas */
            }
        }

        #uhu_tj_9502 .product-image-container {
            width: 100%;
            height: 150px;
            margin-bottom: 15px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        #uhu_tj_9502 .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 6px;
        }
        
        /* Contenedor de información ajustado para flexbox */
        #uhu_tj_9502 .info {
            width: 100%;
            padding: 0 10px;
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Permite que el contenedor crezca */
        }
        
        /* Ocultar elementos no deseados */
        #uhu_tj_9502 .price_container,
        #uhu_tj_9502 .announcement-comment,
        #uhu_tj_9502 .call-to-action-text,
        #uhu_tj_9502 .new-tag {
            display: none !important;
        }

        .announcement-title {
            font-size: 1.4em; /* Ligeramente más pequeño para títulos largos */
            font-weight: 700;
            color: #2c3e50;
            margin-top: 15px;
            margin-bottom: 15px;
            padding: 0;
            text-align: center;
            width: 100%;
            background: none;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            margin-top: auto; /* Empuja el botón hacia abajo */
            width: 100%;
            padding-bottom: 10px; /* Espacio inferior */
        }

        .action-buttons a.btn-view-pdf {
            display: inline-flex;
            align-items: center;
            background-color: #007bff;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            font-size: 1em;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
            cursor: pointer;
        }

        .action-buttons a.btn-view-pdf:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
        }

        .action-buttons a.btn-view-pdf i {
            margin-right: 10px;
        }

        /* --- Estilos para la Modal de PDF --- */
        .pdf-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .pdf-modal.is-visible {
            opacity: 1;
            display: flex;
        }

        .pdf-modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 900px;
            height: 90%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transform: scale(0.9);
            transition: transform 0.3s ease-out;
        }
        .pdf-modal.is-visible .pdf-modal-content {
            transform: scale(1);
        }

        .pdf-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }

        .pdf-modal-title {
            font-size: 1.5em;
            color: #333;
            font-weight: bold;
        }

        .close-button {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-button:hover,
        .close-button:focus {
            color: #000;
            text-decoration: none;
        }

        .pdf-iframe-container {
            flex-grow: 1;
            width: 100%;
        }

        .pdf-iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>

<div id="index" class="index hide-left-column hide-right-column lang_es">
    <div id="page" style="padding-top: 50px;">
        <div class="columns-container">
            <div id="columns" class="container">
                <div id="columns_home" class="row">
                    <div id="center_column" class="center_column col-xs-12 col-sm-12">
                        <div class="clearfix">
                            <div id="uhu_tj_9502" class="col-xs-12 col-sm-12 col-md-12 products_block">
                                <h1 style="text-align: center;">Comunicados Importantes</h1>
                                <div id="more_info_sheets" class="tab-content block_content align_justify">
                                    <div id="idTab_0" class="row tab-pane active">
                                        <ul class="pd col-xs-12 active">
                                            
                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Comunicado Brenna">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Comunicado - Brenna</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/Comunicado - BRENNA.pdf" data-title="Comunicado - Brenna">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Tejidos Descontinuados Marzo">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Tejidos Descontinuados Marzo</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/TEJIDOS DESCONTINUADOS MARZO 2025- DRAPES.pdf" data-title="Tejidos Descontinuados Marzo">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Tejidos Descontinuados Abril">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Tejidos Descontinuados Abril</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/TEJIDOS DESCONTINUADOS ABRIL 2024- Drapes. (1) 1.pdf" data-title="Tejidos Descontinuados Abril">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Comunicado Darren Velvet">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Comunicado - velvet</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/Comunicado - DARREN VELVET.pdf" data-title="Comunicado Darren Velvet">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Tiempos de entrega">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Tiempos de entrega</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/Comunicado tiempos entrega 2025 2.pdf" data-title="Tiempos de entrega">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Tejidos Descontinuados Diciembre">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Tejidos Descontinudos</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/TEJIDOS DESCONTINUADOS DICIEMBRE 2022- Drapes..pdf" data-title="Tejidos Descontinuados Diciembre">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Aumento de Costos">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Aumento de Costos</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/Comunicado Aumento precios Marzo 2025 1.pdf" data-title="Aumento de Costos">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            <li class="ajax_block_product">
                                                <div class="product-container">
                                                    <div class="product-image-container">
                                                        <img class="img-responsive" src="fotocomunidado.jpg" alt="Semana Santa 2025">
                                                    </div>
                                                    <div class="info">
                                                        <h3 class="announcement-title">Semana Santa 2025</h3>
                                                        <div class="action-buttons">
                                                            <a href="#" class="btn-view-pdf" data-pdf-url="/drapes/assets/anuncios/Comunicado SS 25 1.pdf" data-title="Semana Santa 2025">
                                                                <i class="fas fa-eye"></i> Ver Comunicado
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pdfModal" class="pdf-modal">
    <div class="pdf-modal-content">
        <div class="pdf-modal-header">
            <h2 class="pdf-modal-title"></h2> <span class="close-button">&times;</span>
        </div>
        <div class="pdf-iframe-container">
            <iframe id="pdfViewer" class="pdf-iframe" src="" frameborder="0"></iframe>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const pdfModal = document.getElementById('pdfModal');
        const pdfViewer = document.getElementById('pdfViewer');
        const modalTitle = document.querySelector('.pdf-modal-title');
        const closeButton = document.querySelector('.close-button');
        const viewPdfButtons = document.querySelectorAll('.btn-view-pdf');

        function openPdfModal(pdfUrl, title) {
            // Se construye la URL completa para el iframe
            const finalUrl = window.location.origin + pdfUrl;
            pdfViewer.src = finalUrl;
            modalTitle.textContent = title || 'Vista Previa de Comunicado';
            pdfModal.classList.add('is-visible');
            document.body.style.overflow = 'hidden';
        }

        function closePdfModal() {
            pdfModal.classList.remove('is-visible');
            setTimeout(() => {
                pdfViewer.src = 'about:blank'; // Limpiar el iframe para detener la carga
                modalTitle.textContent = '';
                document.body.style.overflow = '';
            }, 300);
        }

        viewPdfButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const pdfUrl = this.getAttribute('data-pdf-url');
                const pdfTitle = this.getAttribute('data-title');
                openPdfModal(pdfUrl, pdfTitle);
            });
        });

        closeButton.addEventListener('click', closePdfModal);

        pdfModal.addEventListener('click', function(event) {
            if (event.target === pdfModal) {
                closePdfModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && pdfModal.classList.contains('is-visible')) {
                closePdfModal();
            }
        });
    });
</script>
 <script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
    <script src="../../assets/js/libs/spin.js/spin.min.js"></script>
    <script src="../../assets/js/libs/autosize/jquery.autosize.min.js"></script>
    <script src="../../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
    <script src="../../assets/js/core/source/App.js"></script>
    <script src="../../assets/js/core/source/AppNavigation.js"></script>
    <script src="../../assets/js/core/source/AppOffcanvas.js"></script>
    <script src="../../assets/js/core/source/AppCard.js"></script>
    <script src="../../assets/js/core/source/AppForm.js"></script>
    <script src="../../assets/js/core/source/AppNavSearch.js"></script>
    <script src="../../assets/js/core/source/AppVendor.js"></script>
    <script src="../../assets/js/core/demo/Demo.js"></script>
</body>
</html>