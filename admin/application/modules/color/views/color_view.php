<div class="palettefirst_color">
    <div class="color_panel">
    	<?php
		 echo form_input(array(
			'id'       => 'show_color'.$fnid,
			'readonly' => 'readonly',
			'class'    => 'form-control',
			'value'    => $color_name
		  ));
		?>
        <span id="show_color10<?php echo $fnid; ?>" data-toggle="modal" data-target=".color_palette<?php echo $fnid ?>" class="color_panel_touch"><i class="<?php echo $title_color; ?>"></i></span>
   	</div>
    <?php
	if (!empty($color)) {
		
		foreach ($color as $color_result) {
			
			$id	= $color_result->id;
			$color_name	= $color_result->color_name;
			$color_class	= $color_result->color_class;
			$color_code	= $color_result->color_code;
			
			$hiddenid = array(
					'type'	=> 'hidden',
					'id'	=> 'palette_class_'.$fnid.'a'.$id,
					'value'	=> $color_class
		  		);
				
			$hiddenname = array(
					'type'	=> 'hidden',
					'id'	=> 'color_name_'.$fnid.'a'.$id,
					'value'	=> $color_name
		  		);
            
			$list[] = '<a onclick="choosecolor('.$id.',
					'."'color_palette$fnid'".',
					'."'show_color$fnid'".',
					'."'$labelid'".',
					'."'palette_class_$fnid'".',
					'."'color_name_$fnid'".',
					'."'show_color10$fnid'".')" href="javascript:void(0);" data-toggle = "tooltip" id="search_color_result'.$fnid.'" title="'.$color_name.'"><p>'.$color_name.'</p><span class="'.$color_class.'"></span></a>'.form_input($hiddenid).form_input($hiddenname);
		}
	}
			
	$attributes = array(
			'id'	=> 'color_palette'.$fnid,
			'class'	=> 'color_palette'
		);
	
	$buttonx = array(
			'class'	=> 'close',
			'data-dismiss'	=> 'modal',
			'aria-label'	=> 'Close',
			'content'	=> '<span aria-hidden="true">×</span>'
		);
	
	$buttonclose = array(
			'class'	=> 'btn btn-default',
			'data-dismiss'	=> 'modal',
			'content'	=> 'Close'
		);
		
	?>
    <div class="modal fade color_palette<?php echo $fnid ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm popup_width">
            <div class="modal-content">			
                <div class="modal-header">
                    <?php echo form_button($buttonx).heading('Choose Color',4,array('class' => 'modal-title','id' => 'myModalLabel2')); ?>
                </div>
                <div class="modal-body">
                	<?php if (!empty($color)) { ?>
                		<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        	<?php
							echo form_input(array(
								'type' => 'text' ,
								'id' => 'search_color'.$fnid ,
								'onkeyup' => 'search_colors('.$fnid.')' ,
								'class' => 'form-control' ,
								'placeholder' => 'Search color...'
							));
							?>
                    	</div>
                    	<?php 
						echo ul($list,$attributes);
					} else {
						echo '<p>No Color</p>';
					}
					?>
             	</div>
                <div class="modal-footer">
                    <?php echo form_button($buttonclose); ?>
                </div>
            </div>
        </div>
    </div>
</div>