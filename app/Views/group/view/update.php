<div class="m-2">
<h1>Modifier les infos du groupe</h1>
<?php
// var_dump($errors); 
if(isset($errors)){
	foreach($errors as $error){
		echo '<p>'.$error.'</p>';
	}
} 
?>

<!-- Formulaire !-->		
<form id="update_group_form" method="post" enctype="multipart/form-data">

    <!-- Nom !-->
    <div class="mb-3 form-group">
		<label for="name" class="control-label">Nom du groupe</label>
		<input id="name" class="form-control" type="text" name="name" value="<?= isset($name) ? $name : "" ?>" disabled>
	</div>

	<!-- Description !-->
	<div class="mb-3 form-group">
		<label for="description" class="control-label">Description du groupe</label>
		<textarea id="description" class="form-control" type="text" name="description"><?= isset($description) ? $description : "" ?></textarea>
	</div>
	
    <!-- Ville principale !-->
	<div class="mb-3 form-group">
		<label for="city" class="control-label">Ville principale du groupe</label>
		<input id="city" class="form-control" type="text" name="city" value="<?= isset($city) ? $city : "" ?>">
	</div>

	<!-- Photo du groupe -->
	<div class="mb-3">
		<label for="picture" class="form-label">Photo du groupe</label>
		<input id="picture" class="form-control" type="file" name="picture">
	</div>
	
	
	<!-- Envoyer !-->
	<button id="update_group" class="btn btn-outline-dark" type="submit">Enregistrer les modifications</button>
	<a class="btn btn-outline-dark" href="<?= site_url('group/view/').esc($slug, 'url') ?>">Retour</a>
	
</form>
</div>