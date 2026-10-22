<link type="text/css" rel="stylesheet" href="../../assets/css/tutoriales.css">

<div class="videos_container">	
	<div class="row">
	<?php
		if (isset($_GET['video'])) {
			switch ($_GET['video']) {	
				case 'cs':
	?>
		<h1>CORTINERO CS</h1>
		<div class="col-md-12" style="margin: 2%;"> 
			<video src="../../assets/video/cortineros/CORTINERO CS.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroCS.png" controls></video> 
		</div>
	<?php
					break;
				case 'ondulado':
	?>
		<h1>CORTINERO ONDULADO</h1>
		<div class="col-md-12" style="margin: 2%;">
			<video src="../../assets/video/cortineros/CORTINERO ONDULADO.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroForest.png" controls></video>
		</div>
	<?php
					break;
				case 'madera':
	?>
		<h1>DECORATIVO DE MADERA</h1>
		<div class="col-md-12" style="margin: 2%;">
			<video src="../../assets/video/cortineros/DECORATIVO DE MADERA.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroGlydea.png" controls></video>
		</div>
	<?php
					break;
				case 'hriel':
	?>
		<h1>DECORATIVO H-RIEL</h1>
		<div class="col-md-12" style="margin: 2%;">
			<video src="../../assets/video/cortineros/DECORATIVO H-RIEL.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroHRiel.png" controls></video>
		</div>
	<?php
					break;
				case 'tubular':
	?>
		<h1>DECORATIVO TUBULAR</h1>
		<div class="col-md-12" style="margin: 2%;">
			<video src="../../assets/video/cortineros/DECORATIVO TUBULAR.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroMadera.png" controls></video>
		</div>
	<?php
					break;
				case 'forest':
	?>
		<h1>MOTORIZADO FOREST</h1>
		<div class="col-md-12" style="margin: 2%;">
			<video src="../../assets/video/cortineros/MOTORIZADO FOREST.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroOndulado.png" controls></video>
		</div>
	<?php
					break;
				case 'glydea':
	?>
		<h1>MOTORIZADO GLYDEA</h1>
		<div class="col-md-12" style="margin: 2%;">
			<video src="../../assets/video/cortineros/MOTORIZADO GLYDEA.mp4" width="100%" height="100%" poster="../../assets/img/portada/CortineroTubular.png" controls></video>
		</div>
	<?php
					break;
			}
		}
	?>
		
</div>


