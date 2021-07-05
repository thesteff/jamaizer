<h1>Connexion</h1>
<?= isset($inscriptionSuccess) ? '<p>'.$inscriptionSuccess.'</p>' : "" ?>
<?= isset($error) ? '<p>'.$error.'</p>' : "" ?>

<!-- Formulaire !-->		
<form id="login_form" method="post">

	<!-- Email !-->
	<div class="mb-3 form-group required">
		<label for="input" class="control-label">Pseudo ou Email</label>
		<input id="input" class="form-control" required="true" type="input" name="input" value="<?= isset($input) ? $input : "" ?>">
	</div>
	
	<!-- Password !-->
	<div class="mb-3 form-group required">
		<label for="password" class="control-label">Mot de passe</label>
		<input id="password" class="form-control" type="password" name="password" required="true" />
	</div>
		
	<!-- Envoyer !-->
	<input id="login" class="btn btn-outline-dark" type="submit" value="Connexion" >
	
</form>