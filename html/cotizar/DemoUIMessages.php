<?php      
   include_once '../clases/Carrito.class.php';
   require_once '../../conexion/cnx.php'; 

   if (isset($_POST['tpl']) && $_POST['tpl']<>"" ){
   		
   		$tpl=$_POST['tpl'];   		
   		$id_unico=$_POST['id_unico'];

   		$carrito = new Carrito();
   		$carro = $carrito->get_content();
   		

   
   	   	$sql = "SELECT CORTINERO/*,nombre,if(estatus=1,'SI','NO') AS ESTATUS*/ 
   	        FROM dues_drapes.confeccion_cortinero c 
   	        inner join confeccion co on (c.id_confeccion = co.id_confeccion) 
   	        WHERE ESTATUS=1 and clave='".$tpl."';";

   	       // echo "consulta: " . $sql;
   	    $message = "";
		$result = mysqli_query($GLOBALS["db"], $sql);
		
		if(mysqli_num_rows($result)>0){
			$NumRows = mysqli_num_rows($result);
			$inicio = "<tr>";
			$fin = "";
			$i = 0 ;
			
			while ($row=mysqli_fetch_assoc($result)){

				$fila = ($i+1);
	 			//$residuo = $fila%3;
				if (($fila%3==0) AND ($i!=0)){
					//$inicio="<tr>";
					$fin = "</tr>";
				}
				else if($i==0){				
					$inicio="<tr>";
					$fin = "";
				}
				else{
					$inicio="";
					$fin = "";
				}

				$message = $message . $inicio;
				 //$inicio;

				if($carro){			
					foreach($carro as $producto){
						if($producto["unique_id"]==$id_unico){						

							if ($row['CORTINERO'] == "TUBULAR"){
								$Link = "index.php?opcion=ctubular"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"];
								
							}/*else if ($row['CORTINERO'] == "MADERA"){
								$Link = "index.php?opcion=cmadera"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}*/
							else if ($row['CORTINERO'] == "ONDULADO"){
								$Link = "index.php?opcion=condulado"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							else if ($row['CORTINERO'] == "CS"){
								$Link = "index.php?opcion=ccs"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"];
							}
							else if ($row['CORTINERO'] == "CURVO"){
								$Link = "index.php?opcion=ccurvoks"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							else if ($row['CORTINERO'] == "HRIEL"){
								$Link = "index.php?opcion=chriel"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							else if ($row['CORTINERO'] == "GABIN"){
								$Link = "index.php?opcion=cgabin"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"];
							}
							else if ($row['CORTINERO'] == "GLYSTRO"){
								$Link = "index.php?opcion=cglystro"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							else if ($row['CORTINERO'] == "FOREST"){
								$Link = "index.php?opcion=cforest"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							/*else if ($row['CORTINERO'] == "MOVELITE"){
								$Link = "index.php?opcion=cmovelite"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}*/
							else if ($row['CORTINERO'] == "DSXL"){
								$Link = "index.php?opcion=cdsxl"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							else if ($row['CORTINERO'] == "MTS"){
								$Link = "index.php?opcion=cmts"."&ancho=".$producto["ancho"]."&area=".$producto["area"]."&acoplamiento=".$producto["acoplamiento"]."&fijacion=".$producto["fijacion"]."&cantidad=".$producto["cantidad"]."&sistema=".$tpl;
							}
							else{
								$Link = "";
							}
							if ($Link == ""){

							}else{
							$message = $message .'<td>Cortinero: '.$row['CORTINERO'].'<a href="'.$Link.'" id="okBtn" 
										class="btn-flat btn-success toastr-action">'.'<br><img height="80%" width="80%" class="img-responsive" src="../../assets/img/cortineros/'.$row['CORTINERO'].'.jpg"><br></a></td>';
							}

						}
					}
				}

				if (($fila%3==0)) {
					//$inicio = "<tr>";
					$fin = "</tr>";
				}
				else{
					$inicio="";
					$fin = "";
				}
				$message = $message . $fin;

				$i=$i+1;

			}
		}

		echo "<input type='hidden' id='valor' name='valor' value='".$message."'>";
		echo "<script>var algo='a'; mensaje(algo);</script>".$message;

	}

?>


<script>
	function mensaje(algo){ 
	        //ass=algo;
	        ass = $('#valor').val();
			toastr.clear();
			toastr.options.closeButton = true;
			toastr.options.progressBar = false;
			toastr.options.debug = false;
			toastr.options.positionClass = 'toast-bottom-left';
			toastr.options.showDuration = 333;
			toastr.options.hideDuration = 333;
			toastr.options.timeOut = 0;
			toastr.options.extendedTimeOut = 1000;
			toastr.options.showEasing = 'swing';
			toastr.options.hideEasing = 'swing';
			toastr.options.showMethod = 'slideDown';
			toastr.options.hideMethod = 'slideUp';
			var message=ass;
			toastr.info(message, 'Sugerencias para esta confección');
			}

(function (namespace, $) {
	"use strict";

	var DemoUIMessages = function () {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function () {
			o.initialize();
		});

	};
	var p = DemoUIMessages.prototype;

	// =========================================================================
	// MEMBER
	// =========================================================================

	p.messageTimer = null;

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function () {
		this._initToastr();
	};

	// =========================================================================
	// INIT TOASTR
	// =========================================================================
	p._initToastr = function () {

		this._initActionToastr();
	};

	// =========================================================================
	// ACTION TOASTS
	// =========================================================================

	p._initActionToastr = function () {
		//var o = this;
		//$('#toast-action').on('click', function () {
		/*function mensaje(){  
			alert("si inicia");
			toastr.clear();
			toastr.options.closeButton = true;
			toastr.options.progressBar = false;
			toastr.options.debug = false;
			toastr.options.positionClass = 'toast-bottom-left';
			toastr.options.showDuration = 333;
			toastr.options.hideDuration = 333;
			toastr.options.timeOut = 0;
			toastr.options.extendedTimeOut = 1000;
			toastr.options.showEasing = 'swing';
			toastr.options.hideEasing = 'swing';
			toastr.options.showMethod = 'slideDown';
			toastr.options.hideMethod = 'slideUp';
			var message = "<?php echo $message;?>";
			//'Se recomienda un cortinero tubular. <a href="index.php?opcion=ctubular" id="okBtn" class="btn btn-flat btn-success toastr-action">TBUBULAR</a>';
			toastr.info(message, 'Sugerencias');
			}
		//});	*/
	};

	// =========================================================================
	// TOAST CONFIG
	// =========================================================================

	/*p._toastrStateConfig = function () {
		toastr.options.closeButton = false;
		toastr.options.progressBar = false;
		toastr.options.debug = false;
		toastr.options.positionClass = 'toast-bottom-left';
		toastr.options.showDuration = 333;
		toastr.options.hideDuration = 333;
		toastr.options.timeOut = 4000;
		toastr.options.extendedTimeOut = 4000;
		toastr.options.showEasing = 'swing';
		toastr.options.hideEasing = 'swing';
		toastr.options.showMethod = 'slideDown';
		toastr.options.hideMethod = 'slideUp';
	};*/

	// =========================================================================
	namespace.DemoUIMessages = new DemoUIMessages;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
