<?php foreach ($pump_charges[$pump_id] as $pump_charge): ?>
	 <?php foreach ($charges as $charge): ?>
	 	<?php if ($charge->charge_id === $pump_charge["charge_id"]): ?>
		 	<li class="list-group-item list-group-sm row">
				<span class="col-md-5 col-xs-12"><?= $charge->charge_desc; ?></span>
				<span class="col-md-5 col-xs-12">
					<?php 
						$val;
						switch ($charge->unit) 
						{
							case 'peso':
								# peso format
								$val = peso($pump_charge['value']);
								break;
							case 'cubic':
								# cubic format
								$val = cubic($pump_charge['value']);
								break;
							case 'pcs':
								#pcs format
								$val = pcs($pump_charge['value']);
								break;
							default:
								# default format
								if ($pump_charge['value'] == 0) 
								{
									$val = null;
								}
								else
								{
									$val = round($pump_charge['value']).' ';
								}
								
								break;
						}
						
						echo trim($val = 0 ? '':$val.$pump_charge['desc']);
					 ?>
				</span>
			</li>
		<?php endif ?>
	 <?php endforeach ?>
<?php endforeach; ?>
