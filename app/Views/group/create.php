<div class="m-2">
<h1>Créer un groupe</h1>
<p>Une fois votre groupe créé, attendez que celui-ci soit validé pour pouvoir créer des événements.</p>
<?php
// var_dump($errors); 
if(isset($errors)){
    foreach($errors as $error){
        echo '<p>'.$error.'</p>';
	}
} 
?>

<!-- Formulaire !-->		
<form id="create_group_form" method="post">

	<!-- Nom !-->
	<div class="mb-3 form-group">
		<label for="name" class="control-label">Nom du groupe</label>
		<input id="name" class="form-control" type="text" name="name" value="<?= isset($name) ? $name : "" ?>">
	</div>
	
    <!-- Nom !-->
	<div class="mb-3 form-group">
		<label for="description" class="control-label">Description du groupe</label>
		<input id="description" class="form-control" type="text" name="description" value="<?= isset($description) ? $description : "" ?>">
	</div>
	
    <!-- Nom !-->
	<div class="mb-3 form-group">
		<label for="city" class="control-label">Ville principale du groupe</label>
		<input id="city" class="form-control" type="text" name="city" value="<?= isset($city) ? $city : "" ?>">
	</div>
	
	
	<!-- Envoyer !-->
	<input id="create" class="btn btn-outline-dark" type="submit" value="Créer le groupe" >
	
</form>
</div>