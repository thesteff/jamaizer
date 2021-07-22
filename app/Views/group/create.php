
<div id="groupCreate" class="container mainContent pt-2">

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
	<form id="create_group_form" method="post" enctype="multipart/form-data">

		<!-- Nom !-->
		<div class="mb-3 form-group">
			<label for="name" class="control-label">Nom du groupe</label>
			<input id="name" class="form-control" type="text" name="name" value="<?= isset($name) ? $name : "" ?>">
		</div>
		
		<?php if(isset($slug)) : ?>
			<!-- Slug !-->
			<!-- S'il y a un souci avec le slug, on l'affiche pour demander au membre de le modifier -->
			<div class="mb-3 form-group">
				<label for="slug" class="control-label">Slug</label>
				<input id="slug" class="form-control" type="text" name="slug" value="<?= isset($slug) ? $slug : "" ?>">
				<p>Veuillez modifier le slug car celui-ci est déjà pris, nous ne pouvons pas le générer automatiquement. Le slug est comme un pseudo mais pour votre groupe, il est unique.<br><strong> Il ne peut avoir ni caractères spéciaux, ni accents, ni ponctuation, ni espaces. Il est uniquement composé de lettres et de chiffres.</strong></p>
			</div>
		<?php endif ?>

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
			<label for="picture" class="control-label">Photo du groupe</label>
			<input id="picture" class="form-control" type="file" name="picture">
		</div>
		
		
		<!-- Envoyer !-->
		<div class="text-end pt-2">
			<button class="btn btn-primary" type="submit" href="">Créer le groupe</button>
		</div>
		
	</form>
	
</div>