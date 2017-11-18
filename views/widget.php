<?php echo $args[ 'before_widget' ]; ?>
<div data-number="<?php echo $this->number ?>">
	<table>
		<caption><?php echo __('SPECIAL OFFER', $this->slug)?></caption>
		<tbody>
			<tr class="block">
				<td class="image" width="40%">
					<img src="https://files.adme.ru/files/news/part_79/793310/10095010-797ab841d30ecf2e893c6ff55e0e067a_970x-1000-224ec000e1-1484579184.jpg"">
				</td>
				<td class="info" width="60%">
					<table>
						<tbody>
							<tr>
								<td colspan="3"><h4 class="hotel">{Hotel Name}</h4></td>
							</tr>
							<tr>
								<td colspan="3"><h5 class="room">{Room Name}</h5></td>
							</tr>
							<tr>
								<td colspan="3" class="cost-rate"><?php echo '${Cost} ' . __('USD/NIGHT') . '| {Rate} ' . __('RATE'); ?></td>
							</tr>
							<tr>
								<td class="arrival">
									<fieldset>
										<legend align="center"><?php echo __('ARRIVAL'); ?></legend>
										<p class="month">NOVEMBER</p>
										<p class="day">14</p>
									</fieldset>
								</td>
								<td class="departure">
									<fieldset>
										<legend align="center"><?php echo __('DEPARTURE'); ?></legend>
										<p class="month">NOVEMBER</p>
										<p class="day">17</p>
									</fieldset>

								</td>
								<td class="book">
									<a href="#"><?php echo __('BOOK NOW'); ?></a>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="loader"></div>
</div>
<?php echo $args['after_widget']; ?>
