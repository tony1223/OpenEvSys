<?php include_once('tabs.php') ?>
<?php include_once('event_title.php')?>
<?php
    include_once('card_list.php');
    draw_card_list('int',$event_id);
?>
<div class="panel">
	<?php include_once('intv_list_table.php'); ?>
	<br />
	<br />
    <h3><?php echo _t('EDIT_THIS_INTERVENTION') ?></h3>
    <br />
    <div class="form-container"> 
        <form id="intervention" name="intervention" action='<?php echo get_url('events','edit_intv',null,array('intervention_id'=>$_GET['intervention_id']))?>' method='post' enctype='multipart/form-data'>
        <?php
			$intervention_form['update'] = array('type'=>'submit','label'=>_t('UPDATE')); 
			$fields = shn_form_get_html_fields($intervention_form);
			place_form_elements($intervention_form,$fields);
		?>
        <br />
        <center>
        <?php echo $fields['update'];?>    
        <a class="but" href="<?php echo get_url('events','intv_list',null,array('eid'=>$event_id,'intervention_id'=>$_GET['intervention_id'],'type'=>'intv')) ?>"><?php echo _t('CANCEL')?></a><span>&nbsp;&nbsp;</span>
        </center>
        </form>
    </div>
</div>