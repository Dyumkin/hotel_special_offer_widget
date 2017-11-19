<p></p>
<div class="media-widget-control" id="<?php echo $this->id?>">
	<div class="media-widget-preview media_image">
		<div onclick="hotelOfferMedia.select('<?php echo $this->id?>')"
			class="attachment-media-view <?php echo ($this->hasImage($instance)) ? 'selected' : 'not-selected'; ?>">

			<div class="placeholder"><?php esc_html_e('No image selected'); ?></div>
		</div>

		<?php if ($this->hasImage($instance)): ?>
			<img src="<?php echo esc_attr( $instance['image_url'] ); ?>"
			     alt="<?php echo esc_attr( $instance['image_alt'] ); ?>">
		<?php endif; ?>
	</div>

	<p class="media-widget-buttons">
		<button type="button"
		        class="button delete-offer-media <?php echo ($this->hasImage($instance)) ? 'not-selected' : 'selected'; ?>"
		        onclick="hotelOfferMedia.remove('<?php echo $this->id?>')"
		>
			Delete Image
		</button>
		<button type="button"
		        class="button select-offer-media <?php echo ($this->hasImage($instance)) ? 'selected' : 'not-selected'; ?>"
		        onclick="hotelOfferMedia.select('<?php echo $this->id?>')"
		>
			Add Image
		</button>
	</p>

	<input type="hidden"
	       class="media-url"
	       id="<?php echo $this->get_field_id( 'image_url' ); ?>"
	       name="<?php echo $this->get_field_name( 'image_url' ); ?>"
	       value="<?php echo esc_attr( $instance['image_url'] ); ?>"
	/>

	<input type="hidden"
	       class="media-alt"
	       id="<?php echo $this->get_field_id( 'image_alt' ); ?>"
	       name="<?php echo $this->get_field_name( 'image_alt' ); ?>"
	       value="<?php echo esc_attr( $instance['image_alt'] ); ?>"
	/>
</div>

<p>
	<label for="<?php echo $this->get_field_id( 'hotel_name' ); ?>"><?php esc_html_e( 'Hotel Name:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'hotel_name' ); ?>"
	       name="<?php echo $this->get_field_name( 'hotel_name' ); ?>"
	       type="text"
	       value="<?php echo esc_attr( $instance['hotel_name'] ); ?>"
	/>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'room_name' ); ?>"><?php esc_html_e( 'Room Name:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'room_name' ); ?>"
	       name="<?php echo $this->get_field_name( 'room_name' ); ?>"
	       type="text"
	       value="<?php echo esc_attr( $instance['room_name'] ); ?>"
	/>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'rate_name' ); ?>"><?php esc_html_e( 'Rate Name:' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'rate_name' ); ?>"
	       name="<?php echo $this->get_field_name( 'rate_name' ); ?>"
	       type="text"
	       value="<?php echo esc_attr( $instance['rate_name'] ); ?>"
	/>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'cost' ); ?>"><?php esc_html_e( 'Cost:' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'cost' ); ?>"
	       name="<?php echo $this->get_field_name( 'cost' ); ?>"
	       type="number"
	       value="<?php echo esc_attr( $instance['cost'] ); ?>"
	       min="0"
	       step="0.1"
	/>
	<span>&#036;</span>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'arrival_date' ); ?>"><?php esc_html_e( 'Arrival Date:' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'arrival_date' ); ?>"
	       name="<?php echo $this->get_field_name( 'arrival_date' ); ?>"
	       type="date"
	       value="<?php echo esc_attr( $instance['arrival_date'] ); ?>"
	/>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'departure_date' ); ?>"><?php esc_html_e( 'Departure Date:' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'departure_date' ); ?>"
	       name="<?php echo $this->get_field_name( 'departure_date' ); ?>"
	       type="date"
	       value="<?php echo esc_attr( $instance['departure_date'] ); ?>"
	/>
</p>
