<?php 
	include_once('event_title.php');
    
?>
<div class="panel">
<?php if($del_confirm){ ?>
    <div class="alert alert-error" >
        <h3><?php echo _t('DO_YOU_WANT_TO_DELETE_THE_SELECTED_INFORMATION_S__')?></h3>
    <form class="form-horizontal"  action="<?php get_url('events','delete_information')?>" method="post">
        <br />
        <center>
              <button type='submit' class='btn btn-grey' name='yes' ><i class="icon-trash"></i> <?php echo _t('DELETE') ?></button>
        <button type='submit' class='btn' name='no' ><i class="icon-remove-circle"></i> <?php echo _t('CANCEL') ?></button>
     </center>
        <?php			
			foreach($_POST['informations'] as $val){ ?>
        		<input type='hidden' name='informations[]' value='<?php echo $val ?>' />
        <?php			 
			}
		?>
    </form>
    </div>

<table class='table table-bordered table-striped table-hover'>
    <thead>
        <tr>			
            <th class="title"><?php echo _t('DATE_OF_SOURCE_MATERIAL')?></th>
            <th class="title"><?php echo _t('SOURCE_NAME')?></th>
            <th class="title"><?php echo _t('INFORMATION')?></th>
        </tr>
    </thead>
    <tbody>		
<?php 			
       		foreach($sources as $record){ ?>
        <tr class='<?php if($i++%2==1)echo "odd ";if($_GET['row']==$i)echo 'active'; ?>' >			
            <td><?php echo $record['date_of_source_material']; ?></td>
            <td><?php echo $record['person_name']; ?></td>
            <td><?php echo $record['connection']; ?></td>            
        </tr>
		
<?php 	
			}		
?>
	</tbody>
</table>
<?php 
	}		
?>
<br />
<center>
	<a class="btn" href="<?php echo get_url('events','src_list',null,array('eid'=>$event_id)) ?>"><i class="icon-chevron-left"></i> <?php echo _t('BACK')?></a>
</center>
<br />
</div>
