<div class="m-2">
<h1>Créer un événement</h1>
<p>Une fois votre événement créé, vous pourrez y ajouter des dates !</p>
<?php
if(isset($errors)){
    foreach($errors as $error){
        echo '<p>'.$error.'</p>';
	}
} 
?>

<!-- Formulaire !-->		
<form id="create_event_form" method="post" enctype="multipart/form-data">

	<!-- Nom !-->
	<div class="mb-3 form-group">
		<label for="name" class="control-label">Nom de l'événement</label>
		<input id="name" class="form-control" type="text" name="name" value="<?= isset($name) ? $name : "" ?>">
	</div>

	<?php if(isset($slug) && isset($errors['slug'])) : ?>
		<!-- Slug !-->
		<!-- S'il y a un souci avec le slug, on l'affiche pour demander au membre de le modifier -->
		<div class="mb-3 form-group">
			<label for="slug" class="control-label">Slug</label>
			<input id="slug" class="form-control" type="text" name="slug" value="<?= isset($slug) ? $slug : "" ?>">
			<p>Veuillez modifier le slug car celui-ci est déjà pris, nous ne pouvons pas le générer automatiquement. Le slug est comme un pseudo mais pour votre event, il est unique (même dans le cas de 2 événements ayant le même nom).<br><strong> Il ne peut avoir ni caractères spéciaux, ni accents, ni ponctuation, ni espaces. Il est uniquement composé de lettres et de chiffres.</strong></p>
		</div>
	<?php endif ?>

	<!-- Description !-->
	<div class="mb-3 form-group">
		<label for="description" class="control-label">Description de l'événement</label>
		<textarea id="description" class="form-control" type="text" name="description"><?= isset($description) ? $description : "" ?></textarea>
	</div>
	
    <!-- TODO ajouter des lieux : pour les events, pour les dates... localisation par coordonnées ? -->

	<!-- date de début de l'événement -->
	<div class="mb-3 form-group">
		<label for="date_start" class="control-label">Date de début</label>
		<input id="date_start" class="form-control" type="date" name="date_start" value="<?= isset($date_start) ? $date_start : "" ?>">
	</div>

    <!-- date de fin de l'événement -->
	<div class="mb-3 form-group">
		<label for="date_end" class="control-label">Date de fin</label>
		<input id="date_end" class="form-control" type="date" name="date_end" value="<?= isset($date_end) ? $date_end : "" ?>">
	</div>

	<!-- Envoyer !-->
	<input id="create" class="btn btn-outline-dark" type="submit" value="Créer l'événement" >
	
</form>
</div>

<a href="<?= site_url('group/'.$group['slug'].'/event') ?>">Retour</a>