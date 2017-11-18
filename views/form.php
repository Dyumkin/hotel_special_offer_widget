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
