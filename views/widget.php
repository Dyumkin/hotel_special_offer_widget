<?php echo $args['before_widget']; ?>
<div data-number="<?php echo $this->number ?>">
	<div class="container">
		<div class="row header">
			<div class="col-12">
				<?php echo __( 'SPECIAL OFFER', $this->slug ) ?>
			</div>
		</div>

		<div class="row block">
			<div class="image col-5">
				<img width="350" src="">
			</div>
			<div class="info col-7">

				<div class="row">
					<div class="col-12">
						<h4 class="hotel"></h4>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<h5 class="room margin-0"></h5>
					</div>
				</div>

				<div class="row">
					<div class="cost-rate col-12"></div>
				</div>

				<div class="row table">
					<div class="arrival">
						<fieldset>
							<legend align="center"><?php echo __( 'ARRIVAL' ); ?></legend>
							<p class="month"></p>
							<p class="day"></p>
						</fieldset>
					</div>
					<div class="departure">
						<fieldset>
							<legend align="center"><?php echo __( 'DEPARTURE' ); ?></legend>
							<p class="month"></p>
							<p class="day"></p>
						</fieldset>
					</div>
					<div class="book">
						<a href="#"><?php echo __( 'BOOK NOW' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="loader"></div>
</div>
<?php echo $args['after_widget']; ?>
