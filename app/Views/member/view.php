

<div id="profil" class="container mainContent">

	<div class="d-flex align-items-center">
		<img id="avatar" class="rounded-circle p-3" src="<?php if(!empty($_SESSION['member']['picture'])){echo base_url('images/member/').'/'.$_SESSION['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>"
			alt="image de profil">
		<h1 class="p-3"><?= $_SESSION['member']['pseudo'] ?></h1>
	</div>
	
	<form class="mb-3">
	
		<fieldset>
		
			<!-- Email !-->
			<div class="row mb-3">
				<label class="col-2 col-form-label">Email</label>
				<div class="col-10">
					<input type="email" class="form-control" placeholder="<?php echo $_SESSION['member']['email'] ?>" disabled>
				</div>
			</div>
			
			
			<!-- Nom !-->
			<div class="row mb-3">
				<label class="col-2 col-form-label">Nom</label>
				<div class="col-10">
					<input type="email" class="form-control" placeholder="<?php echo $_SESSION['member']['name'] ?>" disabled>
				</div>
			</div>
			
			
			<!-- Prénom !-->
			<div class="row mb-3">
				<label class="col-2 col-form-label">Prénom</label>
				<div class="col-10">
					<input type="email" class="form-control" placeholder="<?php echo $_SESSION['member']['first_name'] ?>" disabled>
				</div>
			</div>
			
			
			<!-- Naissance !-->
			<div class="row mb-3">
				<label class="col-2 col-form-label">Date de naissance</label>
				<div class="col-10">
					<input type="email" class="form-control" placeholder="<?php echo $_SESSION['member']['birth'] ?>" disabled>
				</div>
			</div>
			
			
			<!-- Genre !-->
			<div class="row mb-3">
				<label class="col-2 col-form-label">Genre</label>
				<div class="col-10">
					<input type="email" class="form-control" placeholder="<?php echo $_SESSION['member']['gender'] ?>" disabled>
				</div>
			</div>
			
			
			<!-- Mobile !-->
			<div class="row mb-3">
				<label class="col-2 col-form-label">Mobile</label>
				<div class="col-10">
					<input type="email" class="form-control" placeholder="<?php echo $_SESSION['member']['phone'] ?>" disabled>
				</div>
			</div>
			
		</fieldset>
		
	</form>
	
	
	<!--
		<li class="list-group-item text-center">
			<a class="btn btn-outline-dark" href="<?php echo site_url('member/update'); ?>">Modifier</a>
		</li>
	</ul> !-->
	
	<div class="">
		<a class="btn btn-primary" href="<?php echo site_url('group/create'); ?>">Créer un groupe</a>
	</div>
	
</div>