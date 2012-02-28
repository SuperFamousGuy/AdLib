<?php if ($s5_resize_columns  != "disabled") { ?>

	<script type="text/javascript">

		var s5_columns_equalizer = new Class({
			initialize: function(elements,stop,prevent) {
				this.elements = $$(elements);
			},
			equalize: function(hw) {
				if(!hw) { hw = 'height'; }
				var max = 0, 
					prop = (typeof document.body.style.maxHeight != 'undefined' ? 'min-' : '') + hw; //ie6 ftl
					offset = 'offset' + hw.capitalize();
				this.elements.each(function(element,i) {
					var calc = element[offset];
					if(calc > max) { max = calc; }
				},this);
				this.elements.each(function(element,i) {
					element.setStyle(prop,max - (element[offset] - element.getStyle(hw).replace('px','')));
				});
				return max;
			}
		});
		
		function s5_load_resize_columns() {
		
		if (document.getElementById("s5_columns_wrap")) {
			var s5_resize_center_columns = document.getElementById("s5_columns_wrap").getElementsByTagName("DIV");
			for (var s5_resize_center_columns_y=0; s5_resize_center_columns_y<s5_resize_center_columns.length; s5_resize_center_columns_y++) {
				if (s5_resize_center_columns[s5_resize_center_columns_y].id == "s5_center_column_wrap_inner" || s5_resize_center_columns[s5_resize_center_columns_y].id == "s5_left_column_wrap" || s5_resize_center_columns[s5_resize_center_columns_y].id == "s5_right_column_wrap") {
					if (s5_resize_center_columns[s5_resize_center_columns_y].className == "") {
						s5_resize_center_columns[s5_resize_center_columns_y].className = "s5_resize_center_columns";
					}
					else {
						s5_resize_center_columns[s5_resize_center_columns_y].className = "s5_resize_center_columns " + s5_resize_center_columns[s5_resize_center_columns_y].className;
					}
				}
			}
		}
		
		<?php if ($s5_resize_columns  == "all") { ?>
		
		if (document.getElementById("s5_top_row1")) {
			var s5_resize_top_row1 = document.getElementById("s5_top_row1").getElementsByTagName("DIV");
			for (var s5_resize_top_row1_y=0; s5_resize_top_row1_y<s5_resize_top_row1.length; s5_resize_top_row1_y++) {
				if (s5_resize_top_row1[s5_resize_top_row1_y].className == "s5_module_box_2") {
					if (s5_resize_top_row1[s5_resize_top_row1_y].className == "") {
						s5_resize_top_row1[s5_resize_top_row1_y].className = "s5_resize_top_row1";
					}
					else {
						s5_resize_top_row1[s5_resize_top_row1_y].className = "s5_resize_top_row1 " + s5_resize_top_row1[s5_resize_top_row1_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_top_row2")) {
			var s5_resize_top_row2 = document.getElementById("s5_top_row2").getElementsByTagName("DIV");
			for (var s5_resize_top_row2_y=0; s5_resize_top_row2_y<s5_resize_top_row2.length; s5_resize_top_row2_y++) {
				if (s5_resize_top_row2[s5_resize_top_row2_y].className == "s5_module_box_2") {
					if (s5_resize_top_row2[s5_resize_top_row2_y].className == "") {
						s5_resize_top_row2[s5_resize_top_row2_y].className = "s5_resize_top_row2";
					}
					else {
						s5_resize_top_row2[s5_resize_top_row2_y].className = "s5_resize_top_row2 " + s5_resize_top_row2[s5_resize_top_row2_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_top_row3")) {
			var s5_resize_top_row3 = document.getElementById("s5_top_row3").getElementsByTagName("DIV");
			for (var s5_resize_top_row3_y=0; s5_resize_top_row3_y<s5_resize_top_row3.length; s5_resize_top_row3_y++) {
				if (s5_resize_top_row3[s5_resize_top_row3_y].className == "s5_module_box_2") {
					if (s5_resize_top_row3[s5_resize_top_row3_y].className == "") {
						s5_resize_top_row3[s5_resize_top_row3_y].className = "s5_resize_top_row3";
					}
					else {
						s5_resize_top_row3[s5_resize_top_row3_y].className = "s5_resize_top_row3 " + s5_resize_top_row3[s5_resize_top_row3_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_above_columns_inner")) {
			var s5_resize_above_columns_inner = document.getElementById("s5_above_columns_inner").getElementsByTagName("DIV");
			for (var s5_resize_above_columns_inner_y=0; s5_resize_above_columns_inner_y<s5_resize_above_columns_inner.length; s5_resize_above_columns_inner_y++) {
				if (s5_resize_above_columns_inner[s5_resize_above_columns_inner_y].className == "s5_module_box_2") {
					if (s5_resize_above_columns_inner[s5_resize_above_columns_inner_y].className == "") {
						s5_resize_above_columns_inner[s5_resize_above_columns_inner_y].className = "s5_resize_above_columns_inner";
					}
					else {
						s5_resize_above_columns_inner[s5_resize_above_columns_inner_y].className = "s5_resize_above_columns_inner " + s5_resize_above_columns_inner[s5_resize_above_columns_inner_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_middle_top")) {
			var s5_resize_middle_top = document.getElementById("s5_middle_top").getElementsByTagName("DIV");
			for (var s5_resize_middle_top_y=0; s5_resize_middle_top_y<s5_resize_middle_top.length; s5_resize_middle_top_y++) {
				if (s5_resize_middle_top[s5_resize_middle_top_y].className == "s5_module_box_2") {
					if (s5_resize_middle_top[s5_resize_middle_top_y].className == "") {
						s5_resize_middle_top[s5_resize_middle_top_y].className = "s5_resize_middle_top";
					}
					else {
						s5_resize_middle_top[s5_resize_middle_top_y].className = "s5_resize_middle_top " + s5_resize_middle_top[s5_resize_middle_top_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_above_body")) {
			var s5_resize_above_body = document.getElementById("s5_above_body").getElementsByTagName("DIV");
			for (var s5_resize_above_body_y=0; s5_resize_above_body_y<s5_resize_above_body.length; s5_resize_above_body_y++) {
				if (s5_resize_above_body[s5_resize_above_body_y].className == "s5_fourdivs_4") {
					if (s5_resize_above_body[s5_resize_above_body_y].className == "") {
						s5_resize_above_body[s5_resize_above_body_y].className = "s5_resize_above_body";
					}
					else {
						s5_resize_above_body[s5_resize_above_body_y].className = "s5_resize_above_body " + s5_resize_above_body[s5_resize_above_body_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_below_body")) {
			var s5_resize_below_body = document.getElementById("s5_below_body").getElementsByTagName("DIV");
			for (var s5_resize_below_body_y=0; s5_resize_below_body_y<s5_resize_below_body.length; s5_resize_below_body_y++) {
				if (s5_resize_below_body[s5_resize_below_body_y].className == "s5_fourdivs_4") {
					if (s5_resize_below_body[s5_resize_below_body_y].className == "") {
						s5_resize_below_body[s5_resize_below_body_y].className = "s5_resize_below_body";
					}
					else {
						s5_resize_below_body[s5_resize_below_body_y].className = "s5_resize_below_body " + s5_resize_below_body[s5_resize_below_body_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_middle_bottom")) {
			var s5_resize_middle_bottom = document.getElementById("s5_middle_bottom").getElementsByTagName("DIV");
			for (var s5_resize_middle_bottom_y=0; s5_resize_middle_bottom_y<s5_resize_middle_bottom.length; s5_resize_middle_bottom_y++) {
				if (s5_resize_middle_bottom[s5_resize_middle_bottom_y].className == "s5_module_box_2") {
					if (s5_resize_middle_bottom[s5_resize_middle_bottom_y].className == "") {
						s5_resize_middle_bottom[s5_resize_middle_bottom_y].className = "s5_resize_middle_bottom";
					}
					else {
						s5_resize_middle_bottom[s5_resize_middle_bottom_y].className = "s5_resize_middle_bottom " + s5_resize_middle_bottom[s5_resize_middle_bottom_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_below_columns_inner")) {
			var s5_resize_below_columns_inner = document.getElementById("s5_below_columns_inner").getElementsByTagName("DIV");
			for (var s5_resize_below_columns_inner_y=0; s5_resize_below_columns_inner_y<s5_resize_below_columns_inner.length; s5_resize_below_columns_inner_y++) {
				if (s5_resize_below_columns_inner[s5_resize_below_columns_inner_y].className == "s5_module_box_2") {
					if (s5_resize_below_columns_inner[s5_resize_below_columns_inner_y].className == "") {
						s5_resize_below_columns_inner[s5_resize_below_columns_inner_y].className = "s5_resize_below_columns_inner";
					}
					else {
						s5_resize_below_columns_inner[s5_resize_below_columns_inner_y].className = "s5_resize_below_columns_inner " + s5_resize_below_columns_inner[s5_resize_below_columns_inner_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_bottom_row1")) {
			var s5_resize_bottom_row1 = document.getElementById("s5_bottom_row1").getElementsByTagName("DIV");
			for (var s5_resize_bottom_row1_y=0; s5_resize_bottom_row1_y<s5_resize_bottom_row1.length; s5_resize_bottom_row1_y++) {
				if (s5_resize_bottom_row1[s5_resize_bottom_row1_y].className == "s5_module_box_2") {
					if (s5_resize_bottom_row1[s5_resize_bottom_row1_y].className == "") {
						s5_resize_bottom_row1[s5_resize_bottom_row1_y].className = "s5_resize_bottom_row1";
					}
					else {
						s5_resize_bottom_row1[s5_resize_bottom_row1_y].className = "s5_resize_bottom_row1 " + s5_resize_bottom_row1[s5_resize_bottom_row1_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_bottom_row2")) {
			var s5_resize_bottom_row2 = document.getElementById("s5_bottom_row2").getElementsByTagName("DIV");
			for (var s5_resize_bottom_row2_y=0; s5_resize_bottom_row2_y<s5_resize_bottom_row2.length; s5_resize_bottom_row2_y++) {
				if (s5_resize_bottom_row2[s5_resize_bottom_row2_y].className == "s5_module_box_2") {
					if (s5_resize_bottom_row2[s5_resize_bottom_row2_y].className == "") {
						s5_resize_bottom_row2[s5_resize_bottom_row2_y].className = "s5_resize_bottom_row2";
					}
					else {
						s5_resize_bottom_row2[s5_resize_bottom_row2_y].className = "s5_resize_bottom_row2 " + s5_resize_bottom_row2[s5_resize_bottom_row2_y].className;
					}
				}
			}
		}
		
		if (document.getElementById("s5_bottom_row3")) {
			var s5_resize_bottom_row3 = document.getElementById("s5_bottom_row3").getElementsByTagName("DIV");
			for (var s5_resize_bottom_row3_y=0; s5_resize_bottom_row3_y<s5_resize_bottom_row3.length; s5_resize_bottom_row3_y++) {
				if (s5_resize_bottom_row3[s5_resize_bottom_row3_y].className == "s5_module_box_2") {
					if (s5_resize_bottom_row3[s5_resize_bottom_row3_y].className == "") {
						s5_resize_bottom_row3[s5_resize_bottom_row3_y].className = "s5_resize_bottom_row3";
					}
					else {
						s5_resize_bottom_row3[s5_resize_bottom_row3_y].className = "s5_resize_bottom_row3 " + s5_resize_bottom_row3[s5_resize_bottom_row3_y].className;
					}
				}
			}
		}
		
		<?php } ?>

		new s5_columns_equalizer('.s5_resize_center_columns').equalize('height');
		
		<?php if ($s5_resize_columns  == "all") { ?>
			new s5_columns_equalizer('.s5_resize_top_row1').equalize('height');
			new s5_columns_equalizer('.s5_resize_top_row2').equalize('height');
			new s5_columns_equalizer('.s5_resize_top_row3').equalize('height');
			new s5_columns_equalizer('.s5_resize_above_columns_inner').equalize('height');
			new s5_columns_equalizer('.s5_resize_middle_top').equalize('height');
			new s5_columns_equalizer('.s5_resize_above_body').equalize('height');
			new s5_columns_equalizer('.s5_resize_below_body').equalize('height');
			new s5_columns_equalizer('.s5_resize_middle_bottom').equalize('height');
			new s5_columns_equalizer('.s5_resize_below_columns_inner').equalize('height');
			new s5_columns_equalizer('.s5_resize_bottom_row1').equalize('height');
			new s5_columns_equalizer('.s5_resize_bottom_row2').equalize('height');
			new s5_columns_equalizer('.s5_resize_bottom_row3').equalize('height');
		<?php } ?>
		
		}
		
		window.addEvent('domready', function() {
		
		window.setTimeout(s5_load_resize_columns,<?php echo $s5_resize_columns_delay ?>);
		
		});

	</script>
	
<?php } ?>