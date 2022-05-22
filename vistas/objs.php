
<div class="container bg-white shadow-sm rounded-3 p-4 my-4">
	<div class="row">
		<div class="col-4">
			<div class="d-flex align-items-center">
				<img src="../../imagenes/icono.png" width="70px"/>
				<h1 class="fw-bold text-secondary ms-3" style="font-size: 23px;"> | Busca Donantes</h1>
			</div>

			<div class="row mt-3">
				<?php if($_GET['santos'] == "true"){ ?>
					<div class="col p-1">
						<button class="btn btn-sm btn-success w-100" onclick="nuevoDonante()">Crear donante</button>
					</div>
				<?php } ?>
				<div class="col p-1">
					<button class="btn btn-sm btn-primary w-100" onclick="tipificacion()">Si donará</button>
				</div>
				<div class="col p-1">
					<button class="btn btn-sm btn-info w-100" onclick="buscarindividual()">Importar</button>
				</div>
			</div>

			<div class="border rounded-3 p-3 mt-4">
				<label for="idsede">Sede:</label>
				<select id="idsede" class="form-select" name="Sede">
					<option value="1">BOGOTA</option>
					<option value="2">IBAGUE</option>
					<option value="3">BARRANQUILLA</option>
				</select>

				<label for="idtipo" class="mt-2">Tipo donantes</label>
				<select id="idtipo" class="form-select">
					<option value="0">POTENCIALES</option>
				</select>

				<label for="idtipod" class="mt-2">Tipo donación</label>
				<select id="idtipod" class="form-select">
					<option value="0">TODAS</option>
					<option value="1">SANGRE TOTAL</option>
					<option value="10">PLAQUETOAFERESIS</option>
				</select>

				<div class="my-2 d-flex align-items-center justify-content-between">
					<div>
						<img src="../../imagenes/excel.jpg" class="cmdimgo" width="40px" style="cursor: pointer;" onclick="crearexcel()"/>
					</div>
					<div><?php echo $this->jsarecorte["cmd_buscar"]; ?></div>
				</div>
				
				<hr>
				<label for="fechaRep">Fecha reporte</label>
				<input type="date" class="form-control" id="fechaRep" name="fecha">

				<div class="d-flex align-items-center justify-content-end my-3">
					<img src="../../imagenes/buscar.png" class="imgRep" onclick="buscarReporte()" />
				</div>

				<?php echo $this->jsarecorte["mensaje"];?>
			</div>
		</div>


		<!-- MODAL RESERVA -->
		<div class="col-8">
			<div>
				<?php echo $this->jsarecorte["respuestabuscar"]; ?>
				
				<div id="respuesta" class="barra_todo">
					<center><img src="../../imagenes/actualizar.png" /></center>
				</div>

				<div class="modal fade" id="modalReservaDonante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title text-success fw-bold" style="font-size:25px" id="exampleModalLabel"><i class="i-headset-solid"></i> Total de llamadas: <span id="tllamadas">/</span></h5>
				      </div>

				      <div class="modal-body">
				      	<div id="celular"></div>

				      	<div class="row">
					      	<div class="col-6">
					      		<label for="idestado">Resultado</label>
					      		<select id="idestado" class="form-select">
					      			<option value="1">SI</option>
					      			<option value="2">DESPUES</option>
					      			<option value="3">NO</option>
					      		</select>
					      	</div>
				      		<div class="col-6">
					      		<label for="ndocumento">Documento</label>
				      			<input id="ndocumento" class="form-control" type="text" />
										<input type="button" class="form-control" hidden value="Sihevi" onclick="consultadonante()" />
				      		</div>

				      		<!-- /// -->
				      		<div class="col-6 mt-2">
				      			<label for="fecha">Fecha</label>
				      			<input id="fecha" min="<?php echo date("Y-m-d"); ?>" class="form-control form-control-sm" type="date" name="Fecha"/>
				      		</div>
				      		<div class="col-6 mt-2">
				      			<label for="">&nbsp;</label>
				      			<button type="button" class="btn btn-sm btn-primary w-100" id="btnAgendar"><i class="i-calendar-day-solid"></i> Agendamiento</button>
				      		</div>

				      		<div class="col-12 mt-2">
				      			<label for="correo">Correo</label>
				      			<input id="correo" class="form-control" type="mail" name="Correo"/>
				      		</div>

				      		<!-- /// -->
				      		<div class="col-6 my-2">
				      			<label for="ciudad">Ciudad</label>
				      			<input id="ciudad" class="form-control" type="text" name="Ciudad" maxlength="100"/>
				      		</div>
				      		<div class="col-6 my-2">
				      			<label for="barrio">Barrio</label>
				      			<input id="barrio" class="form-control" type="text" name="Barrio" maxlength="100"/>
				      		</div>

				      		<!-- /// -->
				      		<label for="">Dirección</label>
				      		<div class="d-flex align-items-center">
										<select id="d" class="form-select" name="">
											<option value=""></option>
											<option value="CALLE">CALLE</option>
											<option value="CRA">CARRERA</option>
											<option value="DIAG">DIAGONAL</option>
											<option value="TRANS">TRASVERSAL</option>
											<option value="AV">AVENIDA</option>
										</select>
				      			
										<input id="d1" class="form-control" type="number" name=""/>
										<input id="d2" class="form-control" type="text" name="" maxlength="30"/>
										No.
										<input id="d3" class="form-control" type="number" name=""/>
										<input id="d4" class="form-control" type="text" name="" maxlength="30"/>
										<font id="guion">-</font>
										<input id="d5" class="form-control" type="number" name=""/>
										<input id="d6" class="form-control" type="text" name="" maxlength="30"/>
				      		</div>

				      		<!-- /// -->
				      		<div class="col-12 my-2">
				      			<label for="obs">Observación</label>
				      			<input id="obs" class="form-control" type="text" maxlength="500" />
				      		</div>
				      	</div>
				      	<hr>
				      	<div class="d-flex align-items-center justify-content-end">
				      		<button type="button" class="btn btn-blood" onclick="cancelar()"><i class="i-times-solid"></i> Cancelar</button>
				      		<button type="button" class="btn btn-success ms-2" onclick="aceptar()"><i class="i-check-solid"></i> Aceptar</button>
				      	</div>
				      </div>

				    </div>
				  </div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalCrearDonante" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crear donante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      	<div class="row">
      		<div class="col-6">
      			<label for="newName">Nombres</label>
      			<input type="text" class="form-control" name="Nombre" id="newName">
      		</div>
      		<div class="col-6">
		      	<label for="newApe">Apellidos</label>
		      	<input type="text" class="form-control" name="Apellidos" id="newApe">
      		</div>

      		<div class="col-6 mt-2">
	      		<label for="newSexo">Sexo</label>
		      	<select id="newSexo" class="form-select">
							<option selected="" disabled="" value="">Seleccione</option>
							<option value="M">Masculino</option>
							<option value="F">Femenino</option>
					  </select>
      		</div>
      		<div class="col-6 mt-2">
      			<label for="newTel">Celular</label>
      			<input type="text" class="form-control" name="Celular" id="newTel">
      		</div>

      		<div class="col-6 mt-2">
      			<label for="newDoc">Documento</label>
      			<input type="text" class="form-control" name="Doc" id="newDoc">
      		</div>
      		<div class="col-6 mt-2">
      			<label for="newMail">Correo</label>
      			<input type="text" class="form-control" name="Correo" id="newMail">
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="newAdd" class="btn btn-success"><i class="i-plus-solid"></i> Crear donante</button>
      </div>
    </div>
  </div>
</div>
