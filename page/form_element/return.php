<?php
    
if (isset($i))  
{
    $id = $i;
    $value['name'] = 'value="' . $v['name'] . '" ';
    $value['type'] = 'value="' . $v['type'] . '" ';
    $value['description'] = 'value="' . $v['description'] . '" ';
} else {
    $id =1;
    $value['name'] = '';
    $value['type'] = '';
    $value['description'] = '';
}
?>

<div class="form-group">
    <label for="project_id" class="col-lg-2 control-label ">Return <span class="param_number">1</span></label>
    <div class="col-lg-5">
        <input name="return_name_1" type="text" <?=$value['name']?>class="form-control" placeholder="Naam" /><br />
        <input name="return_type_1" type="text" <?=$value['type']?>class="form-control" placeholder="Type (boolean, string, array etc.)" />
    </div>
    <div class="col-lg-5">
        <textarea name="return_description_1" <?=$value['description']?>class="form-control" placeholder="Wat gebeurt er bij deze return" rows="3"></textarea>
    </div>
</div>