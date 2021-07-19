<div class="m-2">
<h1>Modifier l'événement</h1>
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
		<input id="name" class="form-control" type="text" name="name" value="<?= isset($event['name']) ? $event['name'] : "" ?>">
	</div>

	<!-- Description !-->
	<div class="mb-3 form-group">
		<label for="description" class="control-label">Description de l'événement</label>
		<textarea id="description" class="form-control" type="text" name="description"><?= isset($event['description']) ? $event['description'] : "" ?></textarea>
	</div>
	
    <!-- TODO ajouter des lieux : pour les events, pour les dates... localisation par coordonnées ? -->

	<!-- date de début de l'événement -->
	<div class="mb-3 form-group">
		<label for="date_start" class="control-label">Date de début</label>
		<input id="date_start" class="form-control" type="date" name="date_start" value="<?= isset($event['date_start']) ? $event['date_start'] : "" ?>">
	</div>

    <!-- date de fin de l'événement -->
	<div class="mb-3 form-group">
		<label for="date_end" class="control-label">Date de fin</label>
		<input id="date_end" class="form-control" type="date" name="date_end" value="<?= isset($event['date_end']) ? $event['date_end'] : "" ?>">
	</div>

	<!-- Envoyer !-->
	<input id="updateEvent" class="btn btn-outline-dark" type="submit" value="Modifier l'événement" >
	
</form>
</div>

<a href="<?= site_url('group/'.$group['slug'].'/event') ?>">Retour</a>