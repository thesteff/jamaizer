<h1>Inscription</h1>
<?php
// var_dump($errors); 
if(isset($errors)){
	foreach($errors as $error){
		echo '<p>'.$error.'</p>';
	}
} 
?>

<!-- Formulaire !-->		
<form id="inscription_form" method="post">

	<!-- Pseudo !-->
	<div class="mb-3 form-group required">
		<label for="pseudo" class="control-label">Pseudo</label>
		<input id="pseudo" class="form-control" required="true" type="text" name="pseudo" value="<?= isset($pseudo) ? $pseudo : "" ?>">
	</div>

	<!-- Email !-->
	<div class="mb-3 form-group required">
		<label for="email" class="control-label">Email</label>
		<input id="email" class="form-control" required="true" type="email" name="email" value="<?= isset($email) ? $email : "" ?>">
	</div>
	
	<!-- Password !-->
	<div class="mb-3 form-group required">
		<label for="password" class="control-label">Mot de passe</label>
		<input id="password" class="form-control" type="password" name="password" required="true" />
	</div>
	
	<!-- Confirm Pass !-->
	<div class="mb-3 form-group required">
		<label for="pass_confirm" class="control-label">Confirmer le mot de passe</label>
		<input id="pass_confirm" class="form-control" type="password" name="pass_confirm" required="true"  />
	</div>

	<!-- Nom !-->
	<div class="mb-3 form-group">
		<label for="name" class="control-label">Nom</label>
		<input id="name" class="form-control" type="text" name="name" value="<?= isset($name) ? $name : "" ?>">
	</div>
	
	<!-- Prénom !-->
	<div class="mb-3 form-group">
		<label for="first_name" class="control-label">Prénom</label>
		<input id="first_name" class="form-control" type="text" name="first_name" value="<?= isset($first_name) ? $first_name : "" ?>">
	</div>

	<!-- Photo de profil -->
	<div class="mb-3">
		<label for="picture" class="form-label">Photo de profil</label>
		<input id="picture" class="form-control" type="file" name="picture">
	</div>
	
	<!-- Date de naissance !-->
	<div class="mb-3 form-group">
		<label for="birth" class="control-label">Date de naissance</label>
		<input id="birth" class="form-control" type="date" name="birth" value="<?= isset($birth) ? $birth : "" ?>">
	</div>
	
	<!-- Genre !-->
	<div class="mb-3 form-group">
		<label for="gender" class="control-label">Genre</label>
		<select id="gender" class="form-control selectpicker" name="gender" data-style="btn-default">
			<option value="0" <?php if(isset($gender) && $gender == 0){echo 'selected';} ?>>Non spécifié</option>
			<option value="1" <?php if(isset($gender) && $gender == 1){echo 'selected';} ?>>Homme</option>
			<option value="2" <?php if(isset($gender) && $gender == 2){echo 'selected';} ?>>Femme</option>
			<option value="3" <?php if(isset($gender) && $gender == 3){echo 'selected';} ?>>Non-binaire</option>
		</select>
	</div>

	<!-- Mobile !-->
	<div class="mb-3 form-group">
		<label for="phone" class="control-label">N° de téléphone</label>
		<input id="phone" class="form-control" type="text" name="phone" value="<?= isset($phone) ? $phone : "" ?>">
	</div>
	
	<!-- Envoyer !-->
	<input id="create" class="btn btn-outline-dark" type="submit" value="S'inscrire" >
	
</form>