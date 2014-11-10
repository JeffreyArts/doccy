
<div class="row">
	<div class="col-lg-12">
		<h1>Welkom op de documentatie pagina</h2><br />
	</div>
</div>
<div class="well">
	<form action="/" method="post" class="form-horizontal">
	  <fieldset>

	    <legend>Selecteer project</legend>

	    <div class="form-group">
	      <label for="project_id" class="col-lg-2 control-label">Projectnaam</label>
	      <div class="col-lg-10">
			<select name="project_id" class="form-control">
				<option value="0">- Selecteer project -</option>
				<?php foreach ($projects as $key=>$val) {?>
					<option value="<?=$val['id'];?>"><?=$val['name'];?></option>
				<?php } ?>
			</select>
	      </div>
	    </div>

	    <div class="form-group">
	    	<div class="col-lg-9">
				<input type="hidden" name="form_type" value="load_project" />
	    		<input class="btn btn-primary" type="submit" name="load_project" value="Laad project">
	    	</div>
	    </div>

	  </fieldset>
	</form>
</div>