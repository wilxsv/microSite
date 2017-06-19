		<table class='table table-bordered table-hover'>
				<tr >
					<td> TIPO DE HERRAMIENTA </td>
					<td>
						<select name=tipo id=tipo onchange="func()" >
								<option value="0" selected>Todos los registros</option>
						<?php
					 $tipos=$wpdb->get_results("select  dgpc_tipoherramienta.idtipo,dgpc_tipoherramienta.nombre from dgpc_tipoherramienta  order by dgpc_tipoherramienta.nombre");
					foreach ($tipos as $i) {
						echo '<option value="'.$i->idtipo.'">'.$i->nombre.'</option>';
					}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td> CLASE DE HERRAMIENTA </td>
					<td><select name=clase id=clase onchange="func()" >
								<option value="0" selected>Todos los registros</option>
						<?php
					 $clases=$wpdb->get_results("select  dgpc_claseherramienta.idclase,dgpc_claseherramienta.nombre from dgpc_claseherramienta  order by dgpc_claseherramienta.nombre");
					foreach ($clases as $i) {
						echo '<option value="'.$i->idclase.'">'.$i->nombre.'</option>';
					}
					?>
					</select>
					</td>
				</tr>
				<tr >
					<td>
						ÁMBITO DE APLICACIÓN
					</td>
					<td><select name=ambito id=ambito onchange="func()" >
								<option value="0" selected>Todos los registros</option>
						<?php
					 $ambitos=$wpdb->get_results("select  dgpc_ambitoaplicacion.idambito,dgpc_ambitoaplicacion.nombre from dgpc_ambitoaplicacion  order by dgpc_ambitoaplicacion.nombre");
					 foreach ($ambitos as $i) {
						echo '<option value="'.$i->idambito.'">'.$i->nombre.'</option>';
					}
					?>
					</select>
					</td>
	  			</tr>
			</table>
