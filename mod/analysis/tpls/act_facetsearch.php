<?php
global $conf;
?>

<script type="text/javascript" src="res/jquery/jquery-ui-map/jquery.ui.map.js"></script>
<script type="text/javascript" src="res/markerclusterer/markerclusterer_packed.js"></script>
<script type="text/javascript" src="res/js/jquery.facetsearch.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart','charteditor']});
</script>
<div class="panel">
    <ul class="nav nav-tabs facet-tabs" id="myTab">
        <?php
        $i = 0;

        foreach ($entities as $entity) {
            ?>
            <li <?php if ($i == 0) echo 'class="active"' ?>><a href="#<?php echo $entity ?>"><?php echo $domaindata->$entity->label ?></a></li>
            <?php
            $i++;
        }
        ?>
    </ul>

    <div class="tab-content">
        <?php
        $i = 0;
        $facetlabels = array();

        function getFieldsRecursive($entity, $entities_map, $domaindata) {
            $fields = array();
            if ($domaindata->$entity->ac_type) {
                $entity_trans = $domaindata->$entity->ac_type;
                $fields[$entity] = $domaindata->$entity_trans->fields;
            } else {
                $fields[$entity] = $domaindata->$entity->fields;
                $entity_trans = $entity;
            }

            foreach ($entities_map[$entity] as $ent) {
                $fields = array_merge($fields, getFieldsRecursive($ent, $entities_map, $domaindata));
            }
            return $fields;
        }

        foreach ($entities as $entity) {
            $fields = getFieldsRecursive($entity, $entities_map, $domaindata);
            ?>
            <div class="tab-pane <?php if ($i == 0) echo "active"; ?>" id="<?php echo $entity ?>">
                <select name="facets" multiple="multiple" class="facetsselect" id="<?php echo $entity ?>facets"> 
                    <?php
                    $i = 1;
                    $allowedTypes = array("mt_tree", "mt_select", "checkbox", "radio");
                    foreach ($fields as $ent => $fields2) {
                        foreach ($fields2 as $key => $field) {

                            if (in_array($field->field_type, $allowedTypes)) {
                                $facetlabels[$ent][$field->value] = $field->label;
                                ?>
                                <option value="<?php echo $i ?>" data-entity="<?php echo $ent ?>" data-field="<?php echo $field->value ?>"><?php echo $domaindata->$ent->label ?> - <?php echo $field->label ?></option>
                                <?php
                                $i++;
                            }
                            
                        }
                        
                    }
                    ?>
                </select>

                <button type="button" class="btn btn-primary loadfacets" name="load"  data-entity="<?php echo $entity ?>" ><i class="icon-zoom-in icon-white"></i> <?php echo _t('Load') ?></button>

            </div>
            <?php
            $i++;
        }
        ?>
    </div>
    <br/> <br/>
    <div class="facetsearchcontainer"></div>

</div>

<script type="text/javascript">
    var facetlabels = <?php echo json_encode($facetlabels) ?>;
    
    jQuery(document).ready(function($) {
        $('.loadfacets').click(function (e) {
            $('.facetsearchcontainer').html("")
            var entity = $(this).data("entity");
            
            var selectedfacets = $("#"+entity+"facets").val()
            var facets = new Array();
            for (i in selectedfacets){
                var opt = $("#"+entity+"facets option[value=\"" + selectedfacets[i] + "\"]");
                var facet = new Object();
                facet.field = opt.data("field");
                facet.display = facetlabels[opt.data("entity")][opt.data("field")];
                facet.entity = opt.data("entity");
                facets.push(facet)
            }
                    
        
            $('.facetsearchcontainer').facetsearch({
                search_url: 'index.php?mod=analysis&act=facetsearchresults&',
                facets: facets,
                entities: [
                    entity, 
                ],
                paging: {
                    from: 0,
                    size: 30
                }
            });
        })
    
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
        $(".facetsselect").select2({
            width: 'resolve',
            allowClear: true,
            closeOnSelect:false,
            placeholder: "Select facets"
        });
       
 
    });
</script>