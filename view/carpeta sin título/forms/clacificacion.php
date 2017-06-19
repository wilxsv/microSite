		<table class='table table-bordered table-hover'>
				<tr >
					<td >QUÉ GRUPOS VULNERABLES AFECTA</td>
					<td >
						<select name=grupo id=grupo onchange="func()" >
								<option value="0" selected>Todos los registros</option>
								<?php
								     $query = "select  dgpc_grupovulnerable.idgrupo,dgpc_grupovulnerable.nombre from dgpc_grupovulnerable  order by dgpc_grupovulnerable.nombre;";
								     $lista=$wpdb->get_results($query);
								     foreach ($lista as $i) {
										 echo '<option value="'.$i->idgrupo.'">'.$i->nombre.'</option>';
								     }
								?>
								</select>
					</td>	
				</tr>
			</table>
