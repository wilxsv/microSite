<?php
include('cabecera.php');
echo "<b>Ficha de recolección de información de herramienas desarrolladas para la gestión integral de riesgos.</b>";	    
global $wpdb;
/*$instituciones=$wpdb->get_results( 
		"select dgpc_institucion.idinstitucion,dgpc_institucion.nombre from dgpc_institucion order by dgpc_institucion.nombre"    
		);*/
$areas=$wpdb->get_results( 
		"select distinct dgpc_area.idarea,dgpc_area.nombre from dgpc_area inner join dgpc_componente on dgpc_area.idarea=dgpc_componente.idarea  order by dgpc_area.nombre"    
		);
$tipos=$wpdb->get_results( 
		"select  dgpc_tipoherramienta.idtipo,dgpc_tipoherramienta.nombre from dgpc_tipoherramienta  order by dgpc_tipoherramienta.nombre"    
		);
$clases=$wpdb->get_results( 
		"select  dgpc_claseherramienta.idclase,dgpc_claseherramienta.nombre from dgpc_claseherramienta  order by dgpc_claseherramienta.nombre"    
		);
$ambitos=$wpdb->get_results( 
		"select  dgpc_ambitoaplicacion.idambito,dgpc_ambitoaplicacion.nombre from dgpc_ambitoaplicacion  order by dgpc_ambitoaplicacion.nombre"    
		);
$mecanismos=$wpdb->get_results( 
		"select  dgpc_criteriovalidacion.idcriterio,dgpc_criteriovalidacion.nombre from dgpc_criteriovalidacion  order by dgpc_criteriovalidacion.idcriterio"    
		);
$grupos=$wpdb->get_results( 
		"select  dgpc_grupovulnerable.idgrupo,dgpc_grupovulnerable.nombre from dgpc_grupovulnerable  order by dgpc_grupovulnerable.nombre"    
		);
$incluye=$wpdb->get_results( 
		"select  dgpc_itemincluye.iditem,dgpc_itemincluye.nombre from dgpc_itemincluye  order by dgpc_itemincluye.nombre"    
		);
$preguntas=$wpdb->get_results( 
		"select  dgpc_preguntas.idpregunta,dgpc_preguntas.pregunta from dgpc_preguntas  order by dgpc_preguntas.idpregunta"    
		);
/*$contactos=$wpdb->get_results( 
		"select  * from dgpc_contacto  order by dgpc_contacto.nombre"    
		);
*/

?>
<?php
if(isset($_POST["newherramienta"])){
	$id="";
	$nombre=$_POST["nombre"];
	$objetivo=$_POST["objetivo"];	
	$idinstitucionelaboro=$_POST["idinstitucionelaboro"];
	$lugarelaboracion=$_POST["lugarelaboracion"];
	$fechaelaboracion=$_POST["fechaelaboracion"];
	$lugaractualizacion=$_POST["lugaractualizacion"];
	$fechaactualizacion=$_POST["fechaactualizacion"];
	$idinstitucionpresenta=$_POST["institucionpresenta"];
	$pais=$_POST["pais"];
	$contacto=$_POST["newnombrecontacto"];
	$cargo=$_POST["newcargocontacto"];
	$telefono=$_POST["newtelefonocontacto"];
	$email=$_POST["newemailcontacto"];
	$website=$_POST["newwebsitecontacto"];
	//Asumiendo que son excluyentes
	$idcomponente=$_POST["componente"][0];
	$idtipoherramienta=$_POST["tipo"][0];
	$idclaseherramienta=$_POST["clase"][0];
  $longitud=$_POST["longitud"];
  $latitud=$_POST["latitud"];
  $fechapresentacion=$_POST["fechapresentacion"];

  $fe = explode('/',$fechaelaboracion);
  $fechaelaboracion = $fe[2].'-'.$fe[1].'-'.$fe[0];

  $fa = explode('/',$fechaactualizacion);
  $fechaactualizacion = $fa[2].'-'.$fa[1].'-'.$fa[0];

  $fp = explode('/',$fechapresentacion);
  $fechapresentacion = $fp[2].'-'.$fp[1].'-'.$fp[0];
  //punto GEO longitud y latitud
  $puntogeo="geomfromtext('POINT(".$longitud." ".$latitud.")')";
   // REcuperando usuario activo
  global $current_user;
  get_currentuserinfo();

  $r=$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO  dgpc_herramienta ( nombre ,  objetivo , 
					 idinstitucionelaboro ,  lugarelaboracion ,  fechaelaboracion , 
					 lugaractualizacion ,  fechaactualizacion ,  idinstitucionpresenta , 
					 idcomponente ,  idtipoherramienta ,  idclaseherramienta , pais,contacto,
					 cargo,telefono,email,website,fechapresentacion,coordenada,iduser ) 
				VALUES (%s,%s,%d,%s,%s,%s,%s,%d,%d,%d,%d,%s,%s,%s,%s,%s,%s,%s,$puntogeo,%d)"
				,$nombre,$objetivo,$idinstitucionelaboro,$lugarelaboracion,$fechaelaboracion,
				$lugaractualizacion,$fechaactualizacion,$idinstitucionpresenta,$idcomponente,
				$idtipoherramienta,$idclaseherramienta,$pais,$contacto,$cargo,$telefono,$email,$website,$fechapresentacion,$current_user->ID 
				)
		);
	$idh=$wpdb->insert_id;
//	insertando los registros en las tablas intermedias.
	//AmbitosXHerramienta
	$ambitosid=$_POST["ambito"];
	foreach ($ambitosid as $idambito) {
			$wpdb->query($wpdb->prepare(
					"INSERT INTO dgpc_ambitoherramienta(idambito,idherramienta)values(%d,%d)",$idambito,$idh 		
			));
	}

	//Mecanismos de validacion
	
	$mecanismorespuesta=$_POST["mecanismorespuesta"];
	foreach ($mecanismorespuesta as $id=>$respuesta) {
		
		$wpdb->query($wpdb->prepare(
					"INSERT INTO dgpc_validacion(idcriterio,idherramienta,descripcion)values(%d,%d,%s)",$id,$idh,$respuesta 		
			));
	}
//Grupos vulnerables
	
	$grupoid=$_POST["grupo"];
	foreach ($grupoid as $id) {
			$wpdb->query($wpdb->prepare(
					"INSERT INTO dgpc_grupoherramienta(idgrupo,idherramienta,como)values(%d,%d,%s)",$id,$idh,'nada' 		
			));
	}
//La herramienta incluye
	
	$incluyeid=$_POST["incluye"];
	foreach ($incluyeid as $id) {
			$wpdb->query($wpdb->prepare(
					"INSERT INTO dgpc_herramientaincluye(iditem,idherramienta,pregunta)values(%d,%d,%s)",$id,$idh,'nada' 		
			));
	}
//Las preguntas
	
	$preguntaid=$_POST["pregunta"];
	foreach ($preguntaid as $id=>$respuesta) {
			$wpdb->query($wpdb->prepare(
					"INSERT INTO dgpc_preguntaherramienta(idpregunta,idherramienta,respuesta)values(%d,%d,%s)",$id,$idh,$respuesta 		
			));
	}
	if($r==1){
    //notificancion por email
    $to = $email;
    $subject = 'Registro de Herramienta Direccion General de Protección Civil';
    $body = 'Por este medio se informa del registro correcto de la herramienta: <b>$nombre</b>.
    <br>Presentada en fecha:$fechapresentacion.';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $remail=wp_mail( $to, $subject, $body, $headers );

		echo "
		<div>
  			<div class='alert alert-success'>
    			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    			<strong>Registro almacenado correctamente!</strong> 
    			
  			</div>
		</div>
	";
	}else{
		echo "
		<div>
  			<div class='alert alert-warning'>
    			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
    			<strong>Se ha producido un error al intentar almacenar, compruebe los datos</strong> 
    			
  			</div>
		</div>
	";
	}
	
}
?>
<form method="post" name=registroh id=registroh onsubmit="return validar();">
<div>
  	<!-- Nav tabs -->
	  <ul class='nav nav-tabs' role='tablist' id='myTabs'>
	    <li role='presentation' class='active'>
	    	<a href='#generales' aria-controls='generales' role='tab' data-toggle='tab'>
	    	<span class='glyphicon glyphicon-option-vertical' aria-hidden='true'></span>Generales</a>
	    </li>
	    <li role='presentation'>
	    	<a href='#clasificacion' aria-controls='clasificacion' role='tab' data-toggle='tab'>
	    	<span class='glyphicon glyphicon-option-vertical' aria-hidden='true'></span>Clasificación y ámbito de aplicación</a>
	    </li>
	    <li role='presentation'>
	    	<a href='#mecanismos' aria-controls='mecanismos' role='tab' data-toggle='tab'>
	    	<span class='glyphicon glyphicon-option-vertical' aria-hidden='true'></span>Validación / Prueba de la Herramienta</a>
	    </li>
	    <li role='presentation'>
	    	<a href='#settings' aria-controls='settings' role='tab' data-toggle='tab'>
	    	<span class='glyphicon glyphicon-option-vertical' aria-hidden='true'></span>¿Cómo?</a>
	    </li>
	     
	  </ul>
	<div class='tab-content'>
	    <div role='tabpanel' class='tab-pane active' id='generales'>
			<div class='table-responsive'>
				<table class='table table-hover table-bordered'>
					<tr>
						<th>Nombre de la herramienta</th>
						<td>
							<textarea name=nombre id=nombre cols=85 rows=4></textarea>
						</td>
					</tr>
					<tr>
						<th>Objetivo de la herramienta
						</th>
						<td>
							<textarea name='objetivo' cols=85 rows=5 id='objetivo'></textarea> 
						</td>
					</tr>
					<tr>
						<th>País
						</th>
						<td>
							<select  name=pais>
													  <option>Afganistán</option> 
                      <option>Albania</option> 
                      <option>Alemania</option> 
                      <option>Andorra</option> 
                      <option>Angola</option> 
                      <option>Anguilla</option> 
                      <option>Antártida</option> 
                      <option>Antigua y Barbuda</option> 
                      <option>Antillas Holandesas</option> 
                      <option>Arabia Saudí</option> 
                      <option>Argelia</option> 
                      <option>Argentina</option> 
                      <option>Armenia</option> 
                      <option>Aruba</option> 
                      <option>Australia</option> 
                      <option>Austria</option>  
                      <option>Azerbaiyán</option>  
                      <option>Bahamas</option>  
                      <option>Bahrein</option>  
                      <option>Bangladesh</option>  
                      <option>Barbados</option>  
                      <option>Bélgica</option>  
                      <option>Belice</option>  
                      <option>Benin</option>  
                      <option>Bermudas</option>  
                      <option>Bielorrusia</option>  
                      <option>Birmania</option>  
                      <option>Bolivia</option>  
                      <option>Bosnia y Herzegovina</option>  
                      <option>Botswana</option>  
                      <option>Brasil</option>  
                      <option>Brunei</option>  
                      <option>Bulgaria</option>  
                      <option>Burkina Faso</option>  
                      <option>Burundi</option>  
                      <option>Bután</option>  
                      <option>Cabo Verde</option>  
                      <option>Camboya</option>  
                      <option>Camerún</option>  
                      <option>Canadá</option>  
                      <option>Chad</option>  
                      <option>Chile</option>  
                      <option>China</option>  
                      <option>Chipre</option>  
                      <option>Ciudad del Vaticano (Santa Sede)</option>  
                      <option>Colombia</option>  
                      <option>Comores</option>  
                      <option>Congo</option>  
                      <option>Congo, República Democrática del</option>  
                      <option>Corea</option>  
                      <option>Corea del Norte</option>  
                      <option>Costa de Marfíl</option>  
                      <option>Costa Rica</option>  
                      <option>Croacia (Hrvatska)</option>  
                      <option>Cuba</option>  
                      <option>Dinamarca</option>  
                      <option>Djibouti</option>  
                      <option>Dominica</option>  
                      <option>Ecuador</option>  
                      <option>Egipto</option>  
                      <option selected>El Salvador</option>  
                      <option>Emiratos Árabes Unidos</option>  
                      <option>Eritrea</option>  
                      <option>Eslovenia</option>  
                      <option>España</option>  
                      <option>Estados Unidos</option>  
                      <option>Estonia</option>  
                      <option>Etiopía</option>  
                      <option>Fiji</option>  
                      <option>Filipinas</option>  
                      <option>Finlandia</option>  
                      <option>Francia</option>  
                      <option>Gabón</option>  
                      <option>Gambia</option>  
                      <option>Georgia</option>  
                      <option>Ghana</option>  
                      <option>Gibraltar</option>  
                      <option>Granada</option>  
                      <option>Grecia</option>  
                      <option>Groenlandia</option>  
                      <option>Guadalupe</option>  
                      <option>Guam</option>  
                      <option>Guatemala</option>  
                      <option>Guayana</option>  
                      <option>Guayana Francesa</option>  
                      <option>Guinea</option>  
                      <option>Guinea Ecuatorial</option>  
                      <option>Guinea-Bissau</option>  
                      <option>Haití</option>  
                      <option>Honduras</option>  
                      <option>Hungría</option>  
                      <option>India</option>  
                      <option>Indonesia</option>  
                      <option>Irak</option>  
                      <option>Irán</option>  
                      <option>Irlanda</option>  
                      <option>Isla Bouvet</option>  
                      <option>Isla de Christmas</option>  
                      <option>Islandia</option>  
                      <option>Islas Caimán</option>  
                      <option>Islas Cook</option>  
                      <option>Islas de Cocos o Keeling</option>  
                      <option>Islas Faroe</option>  
                      <option>Islas Heard y McDonald</option>  
                      <option>Islas Malvinas</option>  
                      <option>Islas Marianas del Norte</option>  
                      <option>Islas Marshall</option>  
                      <option>Islas menores de Estados Unidos</option>  
                      <option>Islas Palau</option>  
                      <option>Islas Salomón</option>  
                      <option>Islas Svalbard y Jan Mayen</option>  
                      <option>Islas Tokelau</option>  
                      <option>Islas Turks y Caicos</option>  
                      <option>Islas Vírgenes (EE.UU.)</option>  
                      <option>Islas Vírgenes (Reino Unido)</option>  
                      <option>Islas Wallis y Futuna</option>  
                      <option>Israel</option>  
                      <option>Italia</option>  
                      <option>Jamaica</option>  
                      <option>Japón</option>  
                      <option>Jordania</option>  
                      <option>Kazajistán</option>  
                      <option>Kenia</option>  
                      <option>Kirguizistán</option>  
                      <option>Kiribati</option>  
                      <option>Kuwait</option>  
                      <option>Laos</option>  
                      <option>Lesotho</option>  
                      <option>Letonia</option>  
                      <option>Líbano</option>  
                      <option>Liberia</option>  
                      <option>Libia</option>  
                      <option>Liechtenstein</option>  
                      <option>Lituania</option>  
                      <option>Luxemburgo</option>  
                      <option>Macedonia, Ex-República Yugoslava de</option>  
                      <option>Madagascar</option>  
                      <option>Malasia</option>  
                      <option>Malawi</option>  
                      <option>Maldivas</option>  
                      <option>Malí</option>  
                      <option>Malta</option>  
                      <option>Marruecos</option>  
                      <option>Martinica</option>  
                      <option>Mauricio</option>  
                      <option>Mauritania</option>  
                      <option>Mayotte</option>  
                      <option>México</option>  
                      <option>Micronesia</option>  
                      <option>Moldavia</option>  
                      <option>Mónaco</option>  
                      <option>Mongolia</option>  
                      <option>Montserrat</option>  
                      <option>Mozambique</option>  
                      <option>Namibia</option>  
                      <option>Nauru</option>  
                      <option>Nepal</option>  
                      <option>Nicaragua</option>  
                      <option>Níger</option>  
                      <option>Nigeria</option>  
                      <option>Niue</option>  
                      <option>Norfolk</option>  
                      <option>Noruega</option>  
                      <option>Nueva Caledonia</option>  
                      <option>Nueva Zelanda</option>  
                      <option>Omán</option>  
                      <option>Países Bajos</option>  
                      <option>Panamá</option>  
                      <option>Papúa Nueva Guinea</option>  
                      <option>Paquistán</option>  
                      <option>Paraguay</option>  
                      <option>Perú</option>  
                      <option>Pitcairn</option>  
                      <option>Polinesia Francesa</option>  
                      <option>Polonia</option>  
                      <option>Portugal</option>  
                      <option>Puerto Rico</option>  
                      <option>Qatar</option>  
                      <option>Reino Unido</option>  
                      <option>República Centroafricana</option>  
                      <option>República Checa</option>  
                      <option>República de Sudáfrica</option>  
                      <option>República Dominicana</option>  
                      <option>República Eslovaca</option>  
                      <option>Reunión</option>  
                      <option>Ruanda</option>  
                      <option>Rumania</option>  
                      <option>Rusia</option>  
                      <option>Sahara Occidental</option>  
                      <option>Saint Kitts y Nevis</option>  
                      <option>Samoa</option>  
                      <option>Samoa Americana</option>  
                      <option>San Marino</option>  
                      <option>San Vicente y Granadinas</option>  
                      <option>Santa Helena</option>  
                      <option>Santa Lucía</option>  
                      <option>Santo Tomé y Príncipe</option>  
                      <option>Senegal</option>  
                      <option>Seychelles</option>  
                      <option>Sierra Leona</option>  
                      <option>Singapur</option>  
                      <option>Siria</option>  
                      <option>Somalia</option>  
                      <option>Sri Lanka</option>  
                      <option>St. Pierre y Miquelon</option>  
                      <option>Suazilandia</option>  
                      <option>Sudán</option>  
                      <option>Suecia</option>  
                      <option>Suiza</option>  
                      <option>Surinam</option>  
                      <option>Tailandia</option>  
                      <option>Taiwán</option>  
                      <option>Tanzania</option>  
                      <option>Tayikistán</option>  
                      <option>Territorios franceses del Sur</option>  
                      <option>Timor Oriental</option>  
                      <option>Togo</option>  
                      <option>Tonga</option>  
                      <option>Trinidad y Tobago</option>  
                      <option>Túnez</option>  
                      <option>Turkmenistán</option>  
                      <option>Turquía</option>  
                      <option>Tuvalu</option>  
                      <option>Ucrania</option>  
                      <option>Uganda</option>  
                      <option>Uruguay</option>  
                      <option>Uzbekistán</option>  
                      <option>Vanuatu</option>  
                      <option>Venezuela</option>  
                      <option>Vietnam</option>  
                      <option>Yemen</option>  
                      <option>Yugoslavia</option>  
                      <option>Zambia</option>  
                      <option>Zimbabue</option> 	
							</select>
						</td>
					</tr>
					<tr>
						<th>
							Institución o persona que elaboró la herramienta
						</th>
						<td>
							<div id=selectinstituciones>
							<select name=idinstitucionelaboro id=idinstitucionelaboro>
								<?php
									/* foreach ($instituciones as $reg) {
										echo "<option value=".$reg->idinstitucion.">".$reg->nombre."</option>";
									} */
								?>
							</select>
							
							<button type=button class='btn btn-success' id=addinstitucion name=addinstitucion>
								<span class='glyphicon glyphicon-plus'></span>
							</button>
							</div>

						</td>
					</tr>
					<tr>
						<th>
							Lugar y Fecha de elaboración
						</th>
						<td>
							<input type=text name=lugarelaboracion id=lugarelaboracion  size=35>
							<label for="fechaelaboracion" class="btn"><span class="glyphicon glyphicon-calendar"></span>
							 </label>
							<input id="fechaelaboracion" readonly="true" name=fechaelaboracion type="text" class="date-picker" size=9  />	       
						</td>
					</tr>
          <tr>
            <th>
              Longitud del Lugar
            </th>
            <td>
               
              <input id="longitud" name='longitud' type="text" size='15' maxlength="15">
              <button type='button' class='btn btn-success' id='addPoint' name='addPoint' alt='Abrir mapa'>
                <span class='glyphicon glyphicon-globe'></span>
              </button>
             </td> 
          </tr>      
          <tr>
            <th>
              Latitud del Lugar
            </th>
            <td>
              <input id="latitud" name=latitud type="text"  size=15 maxlength="15">
             
             </td> 
          </tr>
              
					<tr>
						<th>
							Lugar y Fecha de actualización
						</th>
						<td>
							<input type=text name=lugaractualizacion id=lugaractualizacion   size=35>
							<label for="fechaactualizacion" class="btn"><span class="glyphicon glyphicon-calendar"></span>
							 </label>
							<input id="fechaactualizacion" readonly="true" name=fechaactualizacion type="text" class="date-picker" size=9   />
						</td>
					</tr>
					<tr>
						<th>
							Institución o persona que presenta la herramienta
						</th>
						<td>
							<div id=selectinstituciones>
								<select name=institucionpresenta id=institucionpresenta>
								<?php /*
										foreach ($instituciones as $reg) {
											echo "<option value=".$reg->idinstitucion.">".$reg->nombre."</option>";
										} */
									?>
								</select>
                <button type=button class='btn btn-success' id=addinstitucion2 name=addinstitucion2>
                <span class='glyphicon glyphicon-plus'></span>
              </button>
							</div>
              
						</td>
					</tr>
          <tr>
            <th>Fecha de presentación en la DGPC</th>

            <td>
              <label for="fechapresentacion" class="btn"><span class="glyphicon glyphicon-calendar"></span>
               </label>  
            <input id="fechapresentacion" readonly="true" name=fechapresentacion type="text" class="date-picker" size=9   /></td>
          </tr>
					<tr>
						<th colspan=2 align=center>
							Marque en la casilla el área y componente a la que pertenece la herramienta
						</th>
					</tr>
				    <tr>
				    	<td colspan=2 align=center>
				    		<table class='table'>
				    			<tr class='success'>
				    				<?php 
				    				$z=1;
				    				
				    				$opcionesComp=array();
				    					foreach ($areas as $reg) {
				    					$grupo="grupo".$z;
				    				?>
				    				<th class='text-center'><?php echo $reg->nombre;?>
				    								<?php
				    								
				    								$componentes=$wpdb->get_results($wpdb->prepare( 
				    									"select dgpc_componente.idcomponente,dgpc_componente.nombre from dgpc_componente 
				    									 where dgpc_componente.idarea=%d order by dgpc_componente.nombre" , $reg->idarea)    
														);

				    								foreach ($componentes as $c) {
				    										if(isset($opcionesComp[$grupo])){
				    											$opcionesComp[$grupo].="<input type=checkbox name=componente[] value='". $c->idcomponente. "'>".$c->nombre."<br>";
				    										}else{
				    											$opcionesComp[$grupo]="<input type=checkbox name=componente[] value='". $c->idcomponente. "'>".$c->nombre."<br>";
				    										}
				    									}	
				    								?>	

				    					</th>
				    				<?php
				    					$z++;
				    				 }?>
				    			</tr>
				    			<tr>
				    				<?php
				    				
				    					foreach ($opcionesComp as $op) {
				    						echo "<td>$op</td>";
				    					}

				    				?>
				    			</tr>	 
				    		</table>
				    	</td>
				    </tr>
				</table>
	    	</div>
		</div>
	    	
	    <div role='tabpanel' class='tab-pane' id='clasificacion'>
	    	<table class='table table-bordered table-hover'>
				<tr class=success>
					<th class='text-center' colspan=6> TIPO DE HERRAMIENTA </th>
				</tr>
				<tr>
					<td colspan=6>
						<?php
							$col=ceil(count($tipos)/3);
							$cuenta=0;
						?>
							<table class='table table-bordered table-hover'>
							<tr>	
							<?php
							
							foreach ($tipos as $t) {
								if($cuenta%3==0){
									if($cuenta==0){
							 			echo "<td colspan=$col>
							 			<input type=checkbox name=tipo[] value=".$t->idtipo.">".$t->nombre."</td>";
							 		}else{
							 			echo"<tr><td colspan=$col>
							 			<input type=checkbox name=tipo[] value=".$t->idtipo.">".$t->nombre."</td>";
							 		}
							 	}else{
							 		echo "<td colspan=$col><input type=checkbox name=tipo[] value=".$t->idtipo.">".$t->nombre."</td>";
							 	}	
							 	$cuenta++;	
							}
					?>
					</tr>
					</table>
				</td>
				</tr>
				<tr class=success>
					<th class='text-center' colspan=6> CLASE DE HERRAMIENTA </th>
				</tr>
				<tr>
				 <td colspan="6">
					<?php
							$col=ceil(count($clases)/3);
							$cuenta=0;
						?>
						<table class='table table-bordered table-hover'>
						<tr>	
							<?php
								foreach ($clases as $c) {
									if($cuenta%3==0){
											if($cuenta==0){
												echo"<td colspan=$col>
												<input type=checkbox name=clase[] value=".$c->idclase.">".$c->nombre."</td>";
											}else{
												echo"<tr><td colspan=$col>
												<input type=checkbox name=clase[] value=".$c->idclase.">".$c->nombre."</td>";
											}
									}else{
										echo "<td colspan=$col><input type=checkbox name=clase[] value=".$c->idclase.">".$c->nombre."</td>";
									}	
									$cuenta++;		
								}
							?>
						</tr>
						</table>	
				 </td>	
				</tr>
				<tr class=success>
					<th class='text-center' colspan=6>
						ÁMBITO DE APLICACIÓN
					</th>
				</tr>
				<tr>
					<td colspan="6">
						<?php
							$col=ceil(count($ambitos)/3);
							$cuenta=0;
						?>
						<table class='table table-bordered table-hover'>
							<tr>	
						<?php
							foreach ($ambitos as $a) {
								if($cuenta%3==0){
									if($cuenta==0){
										echo"
										<td colspan=$col>
										<input type=checkbox name=ambito[] value=".$a->idambito.">".$a->nombre."</td>";
									}else{
										echo"<tr><td colspan=$col>
										<input type=checkbox name=ambito[] value=".$a->idambito.">".$a->nombre."</td>";
									}
									

								}else{
								echo "<td colspan=$col><input type=checkbox name=ambito[] value=".$a->idambito.">".$a->nombre."</td>";

							}
							$cuenta++;
						}	
						?>
						</tr>
						</table>				
					</td>
	  			</tr>
			</table>

	    </div>
	    <div role='tabpanel' class='tab-pane' id='mecanismos'>
	    	<div class=table-responsive>
			<table class='table table-bordered table-hover'>
				<tr class=success>
					<th class='text-center' colspan=6> MECANISMOS DE VALIDACIÓN O PRUEBA DE LA HERRAMIENTA</th>
				</tr>
				<?php
						foreach ($mecanismos as $m) {
							echo "<tr><td colspan=2>".$m->nombre."</td>";
							echo "<td colspan=4>
							<input type=hidden name=mecanismoid[] value=".$m->idcriterio.">
							<textarea name=mecanismorespuesta[".$m->idcriterio."]   cols=65 rows=3></textarea></td></tr>";
						}
					?>
				
				
				<tr class=success>
					<th class='text-center' colspan=6>QUÉ GRUPOS VULNERABLES AFECTA</th>
				</tr>
				<tr>
				 <td colspan=6>
				 	<?php
							$col=ceil(count($grupos)/3);
							$cuenta=0;
						?>
						<table class='table table-bordered table-hover'>
							<tr>	
								<?php
									foreach ($grupos as $g) {
										if($cuenta%3==0){
											if($cuenta==0){
											echo"
												<td colspan=$col>
												<input type=checkbox name=grupo[] value=".$g->idgrupo.">".$g->nombre."</td>";
											}else{
												echo"
													<tr><td colspan=$col>
													<input type=checkbox name=grupo[] value=".$g->idgrupo.">".$g->nombre."</td>";
											}
										}else{
											echo "<td colspan=$col><input type=checkbox name=grupo[] value=".$g->idgrupo.">".$g->nombre."</td>";
										}
										$cuenta++;		
									}
								?>
							</tr>
						</table>		
				 </td>	
				</tr>
				<tr class=success>
					<th class='text-center' colspan=6>
						LA HERRAMIENTA INCLUYE
					</th>
				</tr>
				<tr>
					<td colspan=6>
						<?php
							$col=ceil(count($grupos)/3);
							$cuenta=0;
						?>
							<table class='table table-bordered table-hover'>
								<tr>		 
									<?php
										foreach ($incluye as $i) {
											if($cuenta%3==0){
												if($cuenta==0){
													echo"
														<td colspan=$col>
														<input type=checkbox name=incluye[] value=".$i->iditem.">".$i->nombre."</td>";
												}else{
													echo"
													<tr><td colspan=$col>
													<input type=checkbox name=incluye[] value=".$i->iditem.">".$i->nombre."</td>";
												}
											}else{
												echo "<td colspan=$col><input type=checkbox name=incluye[] value=".$i->iditem.">".$i->nombre."</td>";
											}
											$cuenta++;			
										}
									?>		
								</tr>
						</table>				
					</td>
	  			</tr>
	  			
			</table>
			</div>
		</div>

	    <div role='tabpanel' class='tab-pane' id='settings'>
	    <table class='table table-bordered table-hover'>
	  				<?php 
	  					foreach ($preguntas as $p) {
	  						echo "<tr><td colspan=6>".$p->pregunta."</td></tr>
	  						<tr><td colspan=6><textarea name=pregunta[".$p->idpregunta."] cols=128 rows=4></textarea></td></tr>";
	  					}
	  				?>	
	  				<tr><td><div class='form-group col-md-5'>Datos del Contacto</div>
	  				<div class=clear></div>
							 <div class='form-group col-md-5'>
					    	 	<label for=newnombrecontacto>Nombre</label>
					    	 	<input type=hidden name=tab id=tab value='contacto'>		
					    		<input type=text name=newnombrecontacto id=newnombrecontacto class='form-control'  > 
					        </div>
					        <div class='form-group col-md-4'>
					        	<label for=newcargocontacto>Cargo</label>
					        	<input type=text name=newcargocontacto id=newcargocontacto class='form-control'  > 
					        </div>
					        <div class='form-group col-md-2'>
					        	<label for=newtelefonocontacto>Teléfono</label>
					        	<input type=text name=newtelefonocontacto id=newtelefonocontacto class='form-control'  > 
					        </div>
					        <div class='form-group col-md-6'>
					        	<label for=newemailcontacto>Correo electrónico</label>
					        	<input type=email name=newemailcontacto id=newemailcontacto class='form-control'  > 
					        </div>
					        <div class='form-group col-md-6'>
					        	<label for=newwebsitecontacto>Dirección de sitio web</label>
					        	<input type=url name=newwebsitecontacto id=newwebsitecontacto class='form-control'  > 
					        </div>
					        <div class='form-group col-md-1'>
								<button type='submit' class='btn btn-success' name=newherramienta id=newherramienta value='ok'>
									<span class='glyphicon glyphicon-plus'></span>Guardar datos de Herramienta
								</button>
							</div>
						</td>		  			
	  				</tr>
	     </table>
		</div>
</div>
</div>
</form>
 <!-- Modal EDIT -->
  <div class="modal fade" id="ModalAdd" role="dialog"  tabindex="-1">
    <form role='form' name=f4 method=post>
      <div class="modal-dialog modal-sm" style="position: inherit;" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registrar institución</h4>
          </div>
          <div class="modal-body">
            <div class='form-group'>
                  <label for=nombre>Nombre de Institución</label>
                 <input type=text required name=nombreinstitucion id=nombreinstitucion class='form-control' value=''>               
              </div> 
        
          </div>
          <div class="modal-footer">
            <button type="button"  class='btn btn-success' name=saveinstitucion id=saveinstitucion value=ok>
          <span class='glyphicon glyphicon-ok'>Guardar</span>
        </button> 
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-ban-circle'>Cancelar</span>  
              </button>
          </div>
        </div>
      </div>
    </form>
  </div>

<?php
include("geolocalizacion.php");
?>
 
<script type="text/javascript">
var selectActivo='';
jQuery(document).ready(function() {
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 changeMonth: true,
 changeYear: true, 
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: '',
 minDate: "-50Y", 
 maxDate: 0,
 yearRange: '-50:+0'
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
    $(".date-picker").datepicker();

//funcion ajax
    $('#addPoint').on('click', function(){
        $('#ModalMapa').modal();
        center_map_on_location();       

      });
$('#ModalMapa').on('shown.bs.modal', function() {
    $(this).find('.modal-dialog').css({
        'margin-left': function () {
            return -($(this).outerWidth() / 2);
        }
    });
});

 $('#savepoint').on('click', function(){
        
         $('#ModalMapa').modal('hide');

    });  
    $('#addinstitucion').on('click', function(){
        $('#ModalAdd').modal();
        selectActivo=1;

      });
    $('#addinstitucion2').on('click', function(){
    $('#ModalAdd').modal();
      selectActivo=2;
      });
        
    $('#saveinstitucion').on('click', function(){
        registrarInstitucion();
         $('#ModalAdd').modal('hide');

    });   

  function getInstituciones(nombreIns,selectName){

  $.post( 'admin-ajax.php', {action: 'get_instituciones'}, function(data)
        {
          var q = data.length;
          
            if ( q > 0 ) {
               
                $(selectName).html('');
              for ( var i = 0; i < q; i++ )
                {
                 
                  if(selectName!=null){
                      if(nombreIns==data[i].nombre){
                           $(selectName).append("<option selected value="+data[i].value+">"+data[i].nombre+"</option>");
                      }else{
                           $(selectName).append("<option value="+data[i].value+">"+data[i].nombre+"</option>");
                      }
                  }
                }
            } 
        }, 'json');
  }

  function registrarInstitucion(){
      $.post( 'admin-ajax.php', {action: 'insert_institucion',nombre: $('#nombreinstitucion').val()}, function(data)
        {
          var q = data.length;
            if ( q > 0 ) {
              if(selectActivo==1){
               getInstituciones($('#nombreinstitucion').val(),'#idinstitucionelaboro');
               getInstituciones(null,'#institucionpresenta');
              }else{
               getInstituciones($('#nombreinstitucion').val(),'#institucionpresenta');
              }
              
            } 
        }, 'json');
  }    
  
  getInstituciones(null,'#idinstitucionelaboro');
  getInstituciones(null,'#institucionpresenta');
});


$('#ModalAdd').keypress(function(e) {
    if (e.keyCode == $.ui.keyCode.ENTER) {
          $('#saveinstitucion').click();
          return false;
          }
});

function validar(){
campos=null;  
campos='<ul>';
procesar=true;

 if ($("#nombre").val().length==0){
    campos+="<li>- Nombre de herramienta</li>";
    procesar=false;
   
 }
  
  if($("#objetivo").val()==""){
    campos+="<li>- Objetivo de herramienta </li>";
    procesar=false;
  }

  if($("#lugarelaboracion").val()==""){
    campos+="<li>- Institución que elaboró  </li>";
    procesar=false;
  }

  if($("#lugarelaboracion").val()==""){
    campos+="<li>- Lugar de elaboración </li>";
    procesar=false;
  }
  
  if($("#fechaelaboracion").val()==""){
    campos+="<li>- Fecha de elaboración</li>";
    procesar=false;
  }

   if($("#lugaractualizacion").val()==""){
    campos+="<li>- Lugar actualización</li>";
    procesar=false;
  }

  if($("#fechaactualizacion").val()==""){
    campos+="<li>- Fecha de actualización</li>";
    procesar=false;
  }
  if($("#longitud").val()==""){
    campos+="<li>- Longitud</li>";
    procesar=false;
  }
  if($("#latitud").val()==""){
    campos+="<li>- Latitud </li>";
    procesar=false;
  }
  if($("#fechapresentacion").val()==""){
    campos+="<li>- Fecha presentación</li>";
    procesar=false;
  }
  
   if($("#newnombrecontacto").val()==""){
    campos+="<li>- Nombre del contacto</li>";
    procesar=false;
  }
  
  if($("#newtelefonocontacto").val()==""){
    campos+="<li>- Teléfono del contacto</li>";
    procesar=false;
  }
  if($("#newcargocontacto").val()==""){
    campos+="<li>- Cargo del contacto</li>";
    procesar=false;
  }
  if($("#newmailcontacto").val()==""){
    campos+="<li>- Email del contacto</li>";
    procesar=false;
  }
  
  if($("#newwebsitecontacto").val()==""){
    campos+="<li>- Website </li>";
    procesar=false;
  }
  //Verificando la activacion de los grupos de checkbox
  totalcheck = $('[name="componente[]"]:checked').length;
  if(totalcheck==0){
    campos+="<li>- Seleccione el area y/o componente </li>";
    procesar=false;
  }  
  totalcheck = $('[name="clase[]"]:checked').length;
  if(totalcheck==0){
    campos+="<li>- Seleccione la clase de herramienta</li>";
    procesar=false;
  }  
  totalcheck = $('[name="tipo[]"]:checked').length;
  if(totalcheck==0){
     campos+="<li>- Seleccione el tipo de herramienta</li>";
     procesar=false;
  } 
  totalcheck = $('[name="ambito[]"]:checked').length;
  if(totalcheck==0) {
    campos+="<li>- Seleccione el ámbito de aplicación </li>";
    procesar=false;
  } 
  totalcheck = $('[name="grupo[]"]:checked').length;
  if(totalcheck==0){
     campos+="<li>- Seleccione los grupos vulnerables </li>";
     procesar=false;
  } 
  totalcheck = $('[name="incluye[]"]:checked').length;
  if(totalcheck==0) {
    campos+="<li>- Seleccione lo que incluye la herramienta</li>";
    procesar=false;
  } 
  
  campos+="</ol>"; 
  if(procesar==false){
     $("#ModalErrores").remove();   
    $("#wpbody-content").append('<div class="modal" id="ModalErrores" role="dialog" tabindex="-1" ><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button>              <h4 class="modal-title">Debe de completar los campos requeridos: </h4></div><div class="modal-body">'+campos+'</div><div class="modal-footer"><button type="button" class="btn btn-warning" data-dismiss="modal"><span class="glyphicon glyphicon-ban-circle">Cerrar</span></button></div></div></div></div>');  
    $("#ModalErrores").modal(); 
     $("#ModalErrores").find('.modal-dialog').css({
        'margin-left': function () {
            return -($(this).outerWidth() / 2);
        }
    });   
  }  
  return procesar;
}

</script>

