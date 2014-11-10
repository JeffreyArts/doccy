<form action="/ajax/edit_element.php" method="post" class="form-horizontal">
    <fieldset>

        <legend>Element wijzigen</legend>
          
        <input name="element_id" value="<?=$element->id;?>" type="hidden">

        <div class="form-group">
            <label for="project_id" class="col-lg-3 control-label">Naam</label>
            <div class="col-lg-9">
                <input name="name" class="form-control" value="<?=$element->name;?>" placeholder="Titel">
            </div>
        </div>


        <div class="form-group">
            <label for="project_id" class="col-lg-3 control-label">Omschrijving</label>
            <div class="col-lg-9">
                <textarea name="description" class="form-control" placeholder="Omschrijving element"><?=$element->description;?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="project_id" class="col-lg-3 control-label">Type</label>
            <div class="col-lg-5">
                <select name="type_id" class="form-control">
                    <option value="0">- Selecteer type -</option>
                    <?php foreach ($types as $key=>$val) {
                        if (isset($selection)) {
                            unset($selection);
                        }   
                        if ($val['id'] == $element->type_id) {
                            $selection = ' selected="selected"';
                        } 
                        ?>
                        <option value="<?=$val['id'];?>"<?=$selection;?>><?=$val['name'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>




        <div class="col-lg-12 pull-right">
            <!-- START FUNCTIE PROPERTIES-->
            <?php
                if ($element->type_name=='functie') {
                    $parameter_hidden = '';
                } else {
                    $parameter_hidden = 'hidden';
                }
            ?>

            <div class="panel panel-success <?=$parameter_hidden?>" id="functie_eigenschappen">
                <div class="panel-heading">Functie eigenschappen</div>

                <div class="panel-body">
                    <div class="parameters">
                        <div class="input-fields">
                            <?php 
                            if (isset($element->parameter) && is_array($element->parameter)) {
                                $i=1;
                                foreach ($element->parameter as $k=>$v)  {
                                //-- Possible Values
                                    // $v->name
                                    // $v->description
                                    // $v->type
                                    include($_SERVER['DOCUMENT_ROOT'].'/page/form_element/parameter.php');
                                   $i++;
                                }
                                unset($v, $k, $i);
                            } else {
                                include($_SERVER['DOCUMENT_ROOT'].'/page/form_element/parameter.php');
                            }
                            ?>
                        </div>
                        <div class="add-input col-lg-10 pull-right">
                            <span class="btn btn-primary" data-form="/page/form_element/parameter.php" value="add">Extra parameter toevoegen</span>
                        </div>
                    </div>
                    <div class="col-lg-12"><hr /></div>


                    <div class="return">
                        <div class="input-fields">
                            <?php 
                            if (isset($element->return) && is_array($element->return)) {
                                $i=1;
                                foreach ($element->return as $k=>$v)  {
                                //-- Possible Values
                                    // $v->name
                                    // $v->description
                                    // $v->type
                                    include($_SERVER['DOCUMENT_ROOT'].'/page/form_element/return.php');
                                   $i++;
                                }
                                unset($v, $k, $i);
                            } else {
                                include($_SERVER['DOCUMENT_ROOT'].'/page/form_element/return.php');
                            }
                            ?>
                        </div>
                        <div class="add-input col-lg-10 pull-right">
                            <span class="btn btn-primary" data-form="/page/form_element/return.php" value="add">Extra return toevoegen</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- START VARIABLE PROPERTIES-->
            <div class="panel panel-info hidden" id="var_eigenschappen">
                <div class="panel-heading">Variabel eigenschappen</div>

                <div class="panel-body">
                    <div class="var">
                        <div class="input-fields">
                            <?php include($_SERVER['DOCUMENT_ROOT'].'/page/form_element/var.php');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="project_id" class="col-lg-3 control-label ">Parent Class</label>
            <div class="col-lg-5">
                <select name="parent_id" class="form-control">
                	<option value="0">- Selecteer Parent -</option>
                	<?php foreach ($elements->getAllClasses() as $key=>$val) {
                        if (isset($selection)) {
                            unset($selection);
                        }   
                        if ($val->id == $element->parent_id) {
                            $selection = ' selected="selected"';
                        } 
                        ?>
                		<option value="<?=$val->id;?>"<?=$selection;?>><?=$val->name;?></option>
                	<?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
        	<div class="col-lg-9">
                <input type="hidden" name="form_type" value="edit_element" />
        		<input class="btn btn-primary" type="submit" name="edit_element" value="Wijzig">
        	</div>
        </div>

    </fieldset>
</form>