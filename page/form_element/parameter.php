<?php
    
if (isset($i))  
{
    $id = $i;
    $value['name'] = 'value="' . $v['name'] . '" ';
    $value['type'] = 'value="' . $v['type'] . '" ';
    $value['description'] = 'value="' . $v['description'] . '" ';
} 
 else 
{
    $id =1;
    $value['name'] = '';
    $value['type'] = '';
    $value['description'] = '';
}

?>

<div class="form-group">
    <label for="project_id" class="col-lg-2 control-label ">Parameter <span class="param_number"><?=$id?></span></label>
    <div class="col-lg-5">
        <input name="parameter_name_<?=$id?>" type="text" <?=$value['name']?>class="form-control" placeholder="Naam" /><br />
        <input name="parameter_type_<?=$id?>" type="text" <?=$value['type']?>class="form-control" placeholder="Type (array, string, object etc.)" />
    </div>
    <div class="col-lg-5">
        <textarea name="parameter_description_<?=$id?>" <?=$value['description']?>class="form-control" placeholder="Omschrijving van de parameter" rows="3" ></textarea>
    </div>
</div>