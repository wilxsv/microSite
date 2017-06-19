<?php global $wpdb; ?>
<table class='table table-bordered table-hover'>
					<tr>
						<td>
							Institución o persona que elaboró la herramienta
						</td>
						<td>
							<select name=idinstitucionelaboro id=idinstitucionelaboro onchange="func()" >
								<option value="0" selected>Todas</option>
								<?php
								     $query = "SELECT * FROM dgpc_institucion;";
								     $lista=$wpdb->get_results($query);
								     foreach ($lista as $i) {
										 echo '<option value="'.$i->idinstitucion.'">'.$i->nombre.'</option>';
								     }
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Área y componente a la que pertenece la herramienta
						</td>
						<td>
							<select name=componente id=componente onchange="func()" >
								<option value="0" selected>Todas</option>
								<?php
								     $query = "SELECT c.idcomponente, c.nombre AS n, a.nombre AS m FROM dgpc_area AS a, dgpc_componente AS c WHERE a.idarea = c.idarea ORDER BY a.nombre, c.nombre;";
								     $lista=$wpdb->get_results($query);
								     $area = '';
								     foreach ($lista as $i) {
										 if ($area != $i->m)
											echo '<option value="0" disabled><b>'.$i->m.'</b></option>';
										 echo '<option value="'.$i->idcomponente.'">'.$i->n.'</option>';
										 $area = $i->m;
								     }
								?>
							</select>
						</td>
					</tr>
				</table>
