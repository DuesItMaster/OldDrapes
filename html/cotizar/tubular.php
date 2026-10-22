<?php 
    $IdNombre =31;
	if (isset($_GET['opcion'])){  $opcion = $_GET['opcion']; } 
 	include '../../conexion/wsConsumeDrapes.php';
	$Nombre = "Tubular";
?>
<style>
    /* Estilo para hacer que las imágenes sean responsivas */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table td {
        text-align: center;
        vertical-align: top;
        padding: 10px;
    }
    img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
</style>
<script>
	function col(color){
		if(color=="CAFE OSCURO") {
				$("#CAFEOSCURO").prop("checked", true);
				$("#ARGCAFEOSCURO").prop("checked", true);
				$("#chkbaston").attr('disabled', false);
		}
		else if(color=="NATURAL") {
				$("#NATURAL").prop("checked", true);
				$("#ARGNATURAL").prop("checked", true);
				$("#chkbaston").attr('disabled', false);
			}
		else if(color=="NEGRO") {
				$("#NEGRO").prop("checked", true);
				$("#ARGNEGRO").prop("checked", true);
				$("#chkbaston").attr('disabled', false); //esta opcion estaba en true 200722, 200922 se actualiza a false
		}
		else if(color=="DORADO") {
				$("#DORADO").prop("checked", true);
				$("#ARGDORADO").prop("checked", true);
				$("#chkbaston").attr('disabled', true); //esta opcion estaba en true 200722
				$("#chkbaston").prop("checked", false);
		}

		}
</script>	
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/tubular.css" />

<div class="cortinero" onload="obtenerValores();">
	<form class="form" method="POST" action="index.php?opcion=terminar" id="tubularsoe" name="tubularsoe">
		<!-- PRIMERA COLUMA -->
		<div class="container-left">
			<div class="card card-outlined style-default-light">
				<div class="card-head">
					<h3><?php echo  $Nombre; ?></h3>
				</div>
				<div class="card-body no-padding height-7">
					<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/TUBULAR.jpg')"></div>
				</div>		
			</div>	

		</div>
		<div class="container-right">
			<div class="container-right-top">
				<div class="container-right-top-tab">
					<div class="col-sm-5">
						<label for="cantidad">Cantidad de cortineros <span class="comentario_label">*Unidad</span></label>
						<div class="cantidades">
							<button type="button" id="btn_cantidad_1" onclick="seleccionarNumero('1')" class="btn_cantidad">1</button>
							<button type="button" id="btn_cantidad_2" onclick="seleccionarNumero('2')" class="btn_cantidad">2</button>
							<button type="button" id="btn_cantidad_3" onclick="seleccionarNumero('3')" class="btn_cantidad">3</button>
							<button type="button" id="btn_cantidad_4" onclick="seleccionarNumero('4')" class="btn_cantidad">4</button>
							<button type="button" id="btn_cantidad_5" onclick="seleccionarNumero('5')" class="btn_cantidad">5+</button>
							<input type="number" class="form-control" id="cantidadcortinero" name="cantidadcortinero" min="1" onkeypress="ValidaSoloNumeros()"  onchange="obtenerValores()" onkeyup="CargarValor()" value="1" required></div>
						<label for="autocomplete1">Espacio</label>
						<input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
					</div>
					<div class="col-sm-3">
						<label for="cantidad">Ancho (mts)</label>
						<input type="number" id="anchocortinero" name="ancho" min="1" max="5" step="0.01" onkeypress="return NumCheck(event, this)" onchange="obtenerValores()" onkeyup="obtenerValores()" value="1" required>
					</div>
					<div class="col-sm-4">
						<label for="cantidad"></label>
						<div class="status"></div>
					</div>
				</div>
				<div class="tab-options">
					<button class="tablinks active" onclick="openTab(event,'1')" type="button">Datos Generales</button>
				</div>

				<div id="tab_1" class="tabcontent tab-bg" style="display:block;">
					<div>
						<div class="form-group">
						<h3>Selecciona un color</h3>								
						<select class="form-control" id="SelectColor" name="SelectColor" onchange="obtenerValores();">												
							<?php										   
								$rescolor=colores($IdNombre);	
								foreach ($rescolor as $valor) {														
									echo "<option value='". $valor."'>".trim($valor)."</option>";														
								}													
							?>
						</select>
						</div>
						<h3>Cantidad de hojas</h3>
						<div class="">
							<div class="">
								<table class="table table-condensed acoplamiento">
									<tr>
										<td>
											<label class="radio-inline radio-styled">
												<input type="radio" name="hoja" value="1IZQUIERDA" id="1IZQUIERDA" onchange="obtenerValores();" checked><span>1 Izquierda  </span>
												<img src="../../assets/img/opciones/izquierda.png"/>
											</label>
										</td>
										<td>
											<label class="radio-inline radio-styled">
												<input type="radio" name="hoja" value="1DERECHA" id="1DERECHA" onchange="obtenerValores();"><span> 1 Derecha </span>
												<img src="../../assets/img/opciones/derecha.png"/>
											</label>
										</td>
										<td>
											<label class="radio-inline radio-styled">
												<input type="radio" name="hoja" value="2HOJAS" id="2HOJAS" onchange="obtenerValores();"><span>2 Hojas </span>
												<img src="../../assets/img/opciones/Ambas.png"/>
											</label>
										</td>													
									</tr>	
								</table>
							</div>
						</div>			
						<br>		
						<div id="resultado4"></div>
								
						<div class="modal fade" id="msj" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title" id="simpleModalLabel">Información</h4>
									</div>
									<div class="modal-body">
										<p class="msjModal">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>													
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->			
					</div>
					<h3>VARIABLES</h3>
					<h3>Control</h3>
					<div class="">
						<div class="">
							<table class="table table-condensed acoplamiento">
								<tr>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" name="control" value="Izquierda" id="Izquierda" onchange="obtenerValores();"><span>&nbsp;Izquierdo &nbsp;</span>
											<img src="../../assets/img/opciones/izquierda.png"/>
										</label>
									</td>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" name="control" value="Derecha" id="Derecha" onchange="obtenerValores();" checked><span>&nbsp;Derecho&nbsp;</span>
											<img src="../../assets/img/opciones/derecha.png"/>
										</label>
									</td>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" name="control" value="Ambos" id="Ambos" onchange="obtenerValores();"><span>&nbsp;Ambos&nbsp;</span>
											<img src="../../assets/img/opciones/derecha.png"/>
										</label>
									</td>										
								</tr>													
							</table>                                                  
						</div>
					</div>
					<h3>Instalación</h3>
					<div class="">
						<div class="">
							<table class="table table-condensed acoplamiento">
								<tr>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" class="MURO" name="instalacion" value="MURO" onchange="validarSoportes();" checked><span>Muro </span>
											<img src="../../assets/img/opciones/muro.png"/>
										</label>
									</td>	
									<td>
											<input type="radio" class="TECHO" name="instalacion" value="MURO" onchange="validarSoportes();"><span>Techo </span>
											<img src="../../assets/img/opciones/techo.png"/>
										</label>
									</td>																																					
								</tr>													
							</table>
						</div>
					</div>
					<h3>Tipo de remate</h3>
					<!--<div class="form-group">
						<div class="input-group">-->	
							<table>
								<tr>
									<td>
										<input type="radio" name="remate" value="TAPON" id="TAPON" onchange="obtenerValores();" checked ><span>Tapón</span>
										<img src="../../assets/img/acce/TUBULAR-REMATES-TAPON.jpg" width="80px" height="70px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
									<!--<td>
										<input type="radio" name="remate" value="ESFERA" id="ESFERA" onchange="obtenerValores();" ><span>Esfera</span>
										<img src="../../assets/img/acce/TUBULAR-REMATES-ESFERA.jpg" width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</td>-->	
									<td>
										<input type="radio" name="remate" value="CILINDRO" id="CILINDRO" onchange="obtenerValores();" ><span>Cilindro</span>
										<img src="../../assets/img/acce/TUBULAR-REMATES-CILINDRO.jpg"  width="80px" height="70px"/>
									</td>
								<!--	<td>
										<input type="radio" name="remate" value="DISCO" id="DISCO" onchange="obtenerValores();" ><span>Disco</span>
										<img src="../../assets/img/acce/disco.jpg"  width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
									<td>
										<input type="radio" name="remate" value="TAMBOR" id="TAMBOR" onchange="obtenerValores();" ><span>Tambor</span>
										<img src="../../assets/img/acce/tambor.jpg"  width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
									<td>
										<input type="radio" name="remate" value="BARREL" id="BARREL" onchange="obtenerValores();" ><span>Barrel</span>
										<img src="../../assets/img/acce/barrel.jpg"  width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</td>		-->									
								</tr>
							</table>                        
						<!--</div>
					</div>-->
					<h3>Soporte</h3>
					<table>	
						<th><h3>Sencillo</h3></th>								
						<tr>
							<td>
								<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOESTANDAR" checked><span>Estandar</span>
								<img src="../../assets/img/acce/sencillotub.jpg"  width="50px" height="60px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<td>
								<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOSAUL"><span>Saul</span>
								<img src="../../assets/img/acce/sencilloSaul.jpg"  width="50px" height="60px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<!--<td>
								<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOEDGAR"><span>Edgar</span>
								<img src="../../assets/img/acce/sencilloEdgar.jpg"  width="50px" height="60px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>																															
							<td>
								<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOESTANDARTECHO" disabled = "true"><span>Estandar Techo</span>
								<img src="../../assets/img/acce/sencilloTechoTubular.jpg"  width="50px" height="60px"/>
							</td>-->
						</tr>
						<th><h3>Doble</h3></th>
						<tr>
							<td>
								<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();" class= "DOBLEESTANDAR"><span>Estandar</span>
								<img src="../../assets/img/acce/dobletub.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							
							<td>
								<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();" class= "DOBLESAUL" ><span>Saul</span>
								<img src="../../assets/img/acce/dobleSaul.jpg"  width="50px" height="70px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>	
						<!--	<td>
								<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();" class= "DOBLEEDGAR" ><span>Edgar</span>
								<img src="../../assets/img/acce/dobleEdgar.jpg"  width="50px" height="70px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>	-->
						</tr>										
					</table>   
					<h3>ACCESORIOS</h3>
					<h3>Argolla 2"</h3>
					<div class="checkbox checkbox-styled tile-text">
						<label>
							<input type="checkbox" id="chkargolla" onchange="obtenerValores();">
							<span>Argolla</span>
						</label>
					</div>		
					<table>
    <tr>
        <td>
            <input type="radio" id="ARGNATURAL" name="argolla" value="NATURAL" onchange="obtenerValores();" checked>
            <span>Natural</span>
            <img src="../../assets/img/acce/argollanat.jpg" alt="Natural">
        </td>
        <td>
            <input type="radio" id="ARGCAFEOSCURO" name="argolla" onchange="obtenerValores();" value="CAFE OSCURO">
            <span>Café</span>
            <img src="../../assets/img/acce/145 X 170 PX ARGOLLA CAFE.jpg" alt="Café">
        </td>	
        <td>
            <input type="radio" id="ARGDORADO" name="argolla" onchange="obtenerValores();" value="BRONZE">
            <span>Bronze</span>
            <img src="../../assets/img/acce/145 X 170 PX ARGOLLA BRONZE.jpg" alt="Bronze">
        </td>
        <td>
            <input type="radio" id="ARGNEGRO" name="argolla" onchange="obtenerValores();" value="NEGRO">
            <span>Negro</span>
            <img src="../../assets/img/acce/145 X 170 PX ARGOLLA NEGRO.jpg" alt="Negro">
        </td>																									
    </tr>
</table>
					<h3>Bastón en acero inoxidable</h3>
					<div class="checkbox checkbox-styled tile-text">
						<label>
						<input type="checkbox" id="chkbaston" onchange="obtenerValores();">
						<span>Bastón</span><p>Nota: El bastón no es funcional si no lleva argolla</p>
						</label>
					</div>	
					<table>
						<tr>
							<td>
								<input type="radio" name="colorbaston" id="NATURAL" value="NATURAL" onchange="obtenerValores();" checked><span>Natural</span>
								<img src="../../assets/img/acce/bastonb.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<td>
								<input type="radio" name="colorbaston" id="CAFEOSCURO" value="CAFE OSCURO" onchange="obtenerValores();"><span>Café oscuro</span>
								<img src="../../assets/img/acce/bastoncaf.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>	
							<td>
								<input type="radio" name="colorbaston" id="NEGRO" value="NEGRO" onchange="obtenerValores();"><span>Negro</span>
								<img src="../../assets/img/acce/bastonnegro.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<!--<td>
								<input type="radio" name="colorbaston" id="DORADO" value="DORADO" onchange="obtenerValores();"><span>Dorado</span>
								<img src="../../assets/img/acce/bastondorado.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>-->
						</tr>
					</table>								 
					<h3>Medida del bastón</h3>
					<table>
						<tr>
							<td>
								<input type="radio" name="medida" id="bastonUnoP1" onchange="obtenerValores();" value="1" checked><span>1m</span>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>
							<td>
								<input type="radio" name="medida" id="bastonUnoP2" onchange="obtenerValores();" value="1.2" ><span>1.2m</span>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>	
							<td>
								<input type="radio" name="medida" id="bastonUnoP3" onchange="obtenerValores();" value="1.5" ><span>1.5m</span>&nbsp;&nbsp;&nbsp;&nbsp;
							</td>																				
						</tr>	
					</table>				
				</div>	
				<div class="panel_inferior">
					<div id="precios">
						<div id="precio_total" class="precio_total">
							<div id="resultado">
								<label class="label_total">Precio Total</label>
								<label class="label_cantidad">$0.00</label>
								<input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right;' type="hidden" readonly>
							</div>
						</div>
					</div>
					<div id="cargando" style="display:none; color: green;">Cargando...</div>
					<div class="msjModal" id="cargando2" style="display:none; color: red;">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>
					<div id="BtnD"><button type="button" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
				</div>
		</div>	
	</form>
</div>
<script>	
	function disabledRadios(radioHojasCheckedValue) {
		if (radioHojasCheckedValue == '2HOJAS') {
			$('#Derecha').attr('disabled', true);
			$('#Izquierda').attr('disabled', true);
			$('#Ambos').attr('disabled', false);
			$("#Ambos").attr('checked', true);
		} 
		else if(radioHojasCheckedValue == '1DERECHA'){
			$('#Derecha').attr('disabled', true);
			$('#Ambos').attr('disabled', true);
			$('#Izquierda').attr('disabled', false);
			$("#Izquierda").attr('checked', true);
		}
		else if(radioHojasCheckedValue == '1IZQUIERDA'){
			$('#Ambos').attr('disabled', true);
			$('#Izquierda').attr('disabled', true);
			$('#Derecha').attr('disabled', false);
			$("#Derecha").attr('checked', true);
		}

	}	

	var costoFinal=0;
	precioRecalculado1 = 0;
	precioRecalculado2 = 0;					  

	var costoCortinero=0;
	var anchoinicial=0;
	var Nombre;
	var color;
	var resultadoSistema;
	var decorativo;
	var peso;
	var	argollaBool;							    
	var resultadoRemate;
	var resultadoSoporte;
	//var radioMedida="1.2";
	var radioMaterial="ACERO INOXIDABLE";
	var baston;
	var valorBaston;
	var rutaImg="../../assets/img/cortineros/TUBULARES.jpg";
	var tipolinea="N";
	var TipoArticuloDetalle;
	var area;
	var cantBaston=0;
	var cantidadBastonFija = 0;
	var resHojas;

	bloqueado = false;
	
	function validarSoportes()
	{				
		/*resultadoFijacion =  $("input[name='instalacion']:checked").parent().text();
		resultadoFijacion = resultadoFijacion.trim();*/

			//obtener fijacion
		var radioFijacion=document.getElementsByName("instalacion");
		for(var i=0;i<radioFijacion.length;i++) {
			if(radioFijacion[i].checked)
				resultadoFijacion=radioFijacion[i].className;
		}

		/*Alejandro*/
		if (resultadoFijacion == 'MURO') {
			$("input[class='SENCILLOESTANDAR']").attr("disabled",false);
			$("input[class='SENCILLOSAUL']").attr("disabled",false);
			$("input[class='SENCILLOEDGAR']").attr("disabled",false);
			$("input[class='DOBLEESTANDAR']").attr("disabled",false);
			$("input[class='DOBLESAUL']").attr("disabled",false);
			$("input[class='DOBLEEDGAR']").attr("disabled",false);
			$("input[class='SENCILLOESTANDARTECHO']").attr("disabled",true);
			$("input[class='SENCILLOESTANDAR']").prop('checked', 'cheked');
			/*$(this).find('input[type="radio"]').prop('checked','checked');*/
		}
		if (resultadoFijacion == 'TECHO'){
			$("input[class='SENCILLOESTANDAR']").attr("disabled",true);
			$("input[class='SENCILLOSAUL']").attr("disabled",true);
			$("input[class='SENCILLOEDGAR']").attr("disabled",true);
			$("input[class='DOBLEESTANDAR']").attr("disabled",true);
			$("input[class='DOBLESAUL']").attr("disabled",true);
			$("input[class='DOBLEEDGAR']").attr("disabled",true);
			$("input[class='SENCILLOESTANDARTECHO']").attr("disabled", false);		
			$("input[class='SENCILLOESTANDARTECHO']").prop('checked', 'cheked');	
		}
		obtenerValores();
	}
	function obtenerValores(hacerRecalculo = false)
	{						
		permitirCotizar();

		if ($("#anchocortinero").val().length == 0)
		{
			bloquearCotizar("Favor de capturar el ancho deseado para el cortinero.", false);

			return;
		}

		if ($("#anchocortinero").val() >= 2.31)
		{
			if ($("input[name='hoja']:checked").val() != "2HOJAS"){
					
					bloquearCotizar("En medidas superiores a 2.3 mt no es posible tener una sola hoja...", false);

					return;
				}
			
		}

		radioHojasCheckedValue = $("input[name='hoja']:checked").val();
		disabledRadios(radioHojasCheckedValue);						
		color= $("#SelectColor option:selected").html();
		col(color);						   									
		anchoinicial=document.getElementById('anchocortinero').value;
		anchomod=Math.ceil( anchoinicial * 10 )/10;
		Nombre = "<?php echo $IdNombre;?>";
		TipoArticuloDetalle	= "<?php echo $opcion;?>";									    								   
		//color=document.getElementById("SelectColor").value;
		resultadoSistema="ESTANDAR";
		decorativo="SI";
		peso=0;		

		//obtener argolla checada
		var argollaChecada=document.getElementById("chkargolla").checked;	
		if (argollaChecada==true){
			argollaBool="SI";										    
		} else{
			argollaBool="NO";	    
		}
			//obtener fijacion
		var radioFijacion=document.getElementsByName("instalacion");
		for(var i=0;i<radioFijacion.length;i++) {
			if(radioFijacion[i].checked)
				resultadoFijacion=radioFijacion[i].value;
		}

			//obtener remate
		var radioRemate=document.getElementsByName("remate");
		for(var i=0;i<radioRemate.length;i++) {
			if(radioRemate[i].checked)
				resultadoRemate=radioRemate[i].value;
		}
				//OBTENER SOPORTE
		var radioSoporte=document.getElementsByName("soporte");
		for(var i=0;i<radioSoporte.length;i++) {
			if(radioSoporte[i].checked)
				resultadoSoporte=radioSoporte[i].value;
			//alert(resultadoSoporte);
		}
				//OBTENER ARGOLLA
		var radioArgolla=document.getElementsByName("argolla");
		for(var i=0;i<radioArgolla.length;i++) {
			if(radioArgolla[i].checked)
				resultadoArgolla=radioArgolla[i].value;
		}


		Color= $("input[name='colorbaston']:checked").val();
		radioMedida= $("input[name='medida']:checked").val();
		baston=document.getElementById("chkbaston").checked;


		if(baston==false){
			valorBaston = "NO";
		}
		else {
			valorBaston = "SI";
		}

		resHojas=$("input[name='control']:checked").val();
		console.log(resHojas);
		$("#cargando").css("display", "inline");
		$("#BtnD").css("display", "none");
				
		/*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
		$.post("../fnc/cortinero.php", 
		{ 
			ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
			argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,baston:baston,
			valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
		}, function(data)
		{
			$("#resultado").html(data);

			validacionesResultado();

			if (!bloqueado)
			{
				if (hacerRecalculo)
				{
					precioRecalculado1 = $("#resultadoSuma").val();

					$.post("../fnc/cortinero.php", 
					{ 
						ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema,
						soporte:resultadoSoporte, argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,
						radioMaterial:radioMaterial,baston:baston, valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
					}, function(data)
					{
						$("#resultado").html(data);

						validacionesResultado();

						if (!bloqueado)
						{
							precioRecalculado2 = $("#resultadoSuma").val();

							if (precioRecalculado1 != precioRecalculado2 || costoFinal != precioRecalculado1)
							{	
								bloquearCotizar("Se detectaron problemas de conexión que podrían afectar el cálculo del costo de su cotización, favor de recargar la página.", true);
							}
							else
							{	
								$("#tubularsoe").submit();
							}
						}
					});
				}
				else
				{
					costoFinal = $("#resultadoSuma").val();

					permitirCotizar();
				}
			}
		});									    												 
	}

	function validacionesResultado()
	{
		if ($("#CodigoCortinero").val() == "multiCortinero")
		{
			bloquearCotizar("La configuración actual del artículo esta relacionada con dos códigos de artículo, favor de notificar a su agente de ventas.", true);
		}
		else if ($("#codigoBaston").val() == "multiBaston")
		{
			bloquearCotizar("La configuración actual del artículo esta relacionada con dos códigos de bastón, favor de notificar a su agente de ventas.", true);
		}
		else if ($("#resultadoVacio").val() == 0)
		{
			bloquearCotizar("Este articulo no se encuentra dado de alta, favor de notificar a su agente de ventas.");
		}
	}

	function bloquearCotizar(mensaje, mostrarModal = false)
	{
		$(".msjModal").html(mensaje);
		$("#cargando").css("display", "none");
		$("#BtnD").css("display", "none");

		if (mostrarModal)
		{
			$("#msj").modal();
		}

		$("#cargando2").css("display", "inline");

		bloqueado = true;
	}

	function triggerModal(mensaje)
	{
		$(".msjModal").html(mensaje);

		$("#msj").modal();
	}

	function permitirCotizar()
	{
		bloqueado = false;

		$("#cargando2").css("display", "none");
		$("#cargando").css("display", "none");
		$("#BtnD").css("display", "inline");
	}

	$(document).ready(function()
	{
		obtenerValores();
		$("#BotonEnviar").click(function()
		{
			if ($("#autocomplete1").val().length == 0){
				triggerModal("Favor de especificar el espacio.");
				return;
			}
			obtenerValores(true);
		});

		$("#msj").on('hidden.bs.modal', function()
		{
			$("#autocomplete1").focus();
		});

		$("#tubularsoe").submit(function() 
		{
			Cantidad = $("#cantidadcortinero").val();
			precioBaston = $("#valorBaston").val();
			precioFinal = costoFinal;//este es el precio final
			codigoBaston = $("#codigoBaston").val();
			cantidadHojas=$("input[name='hoja']:checked").val();
			control= $("input[name='control']:checked").val();
			fijacion= $("input[name='instalacion']:checked").parent().text();
			nombreCorti="CORTINERO TUBULAR";
			tipoarticulo="cortinero";
			codigo = $("#CodigoCortinero").val();
			area=$("#autocomplete1").val();
			textoSoporte =  $("input[name='soporte']:checked").parent().text();
			textoSoporte = textoSoporte.trim();
			fijacion = fijacion.trim();
			fijacion =  fijacion.toUpperCase();
			codigoBastonID ="";			
			
			if(codigoBaston != null){
				codigoBastonID = codigoBaston.replace("\"","");
			}
			id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoBastonID;				  	

			if(baston==true){
				if(cantidadHojas == "2HOJAS"){
					cantBaston=2;
					if(resultadoSoporte=="DOBLE"){
						cantBaston=4;
					}
				}
				else{
					cantBaston=1;
					if(resultadoSoporte=="DOBLE"){
						cantBaston=2;
					}
				}
			}

			cantidadBastonFija = cantBaston;
			cantBaston=cantBaston * Cantidad;
			precioBaston=precioBaston * Cantidad;
			resultadoSoporte = resultadoSoporte + " " + textoSoporte.toUpperCase();					
			$.post("LlenarCarrito.php",
			{
				id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo, tipoarticulo:tipoarticulo, ruta:rutaImg,
				ancho:anchoinicial, color:color, fijacion:fijacion, cantidadHojas:cantidadHojas, control:control, decorativo:decorativo,
				peso:peso, remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,argolla:argollaBool,
				codigoBaston:codigoBaston, baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,
				tipolinea:tipolinea, TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston,
				cantidadBastonFija:cantidadBastonFija
			}, function(){ });	 			  
		});
	});
	function seleccionarNumero(num) {
		$(".btn_cantidad").removeClass("active");
		$("#btn_cantidad_"+num).addClass("active");
		if(num<5){
			$(".cantidades #cantidadcortinero").css("display", "none");
			$(".cantidades #cantidadcortinero").val(num);
		}
		else{
			$(".cantidades #cantidadcortinero").css("display", "inline-block");
			$(".cantidades #cantidadcortinero").val("");
		}
	}
	function openTab(evt, tab_num) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById("tab_"+tab_num).style.display = "block";
		evt.currentTarget.className += " active";
	}
</script>	
<!-- BEGIN JAVASCRIPT -->
<script src="../../assets/js/core/source/App.js"></script>
<script src="../../assets/js/libs/select2/select2.min.js"></script>
<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
<script src="../../assets/js/core/demo/Demo.js"></script>
<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
<!-- END JAVASCRIPT -->		