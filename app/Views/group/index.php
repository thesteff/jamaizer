<div id="groupList" class="container mainContent pt-2">
	<h1>Trouver un groupe</h1>

	<!-- Recherche !-->
	<form class="" action="">
		<div class="row">
			<div class="col-10">
				<input class="form-control" type="text" placeholder="Chercher un groupe sur Jamaïzer">
			</div>
			<div class="col-2">
				<button id="searche-group" class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i></button>
			</div>
		</div>
	</form>


	<!-- Filtres !-->
	<div class="row">
		<div class="col-12">
			<h5>Filtrer</h5>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus, alias ex sint rem magni odit blanditiis
			porro non soluta modi aliquam quo atque perferendis vel quos in earum amet ipsum?</p>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
				<label class="form-check-label" for="flexCheckDefault">
					Default checkbox
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
				<label class="form-check-label" for="flexCheckChecked">
					Checked checkbox
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
				<label class="form-check-label" for="flexRadioDefault1">
					Default radio
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
				<label class="form-check-label" for="flexRadioDefault2">
					Default checked radio
				</label>
			</div>
		</div>
	</div>
		
		
	<!-- LISTES !-->
	<div class="row">

		<div class="col-12">
			<?php if(isset($_SESSION['logged']) && $_SESSION['logged'] && isset($_SESSION['myGroups'])) : ?>
				<h5>Tous mes groupes</h5>
				
				<!-- On liste les groupes auxquels participe l'utilisateur !-->
				<?php foreach ($_SESSION['myGroups'] as $group): ?>
					<!-- <a class="link_groupIndex" href="<?php // site_url('group/view/').esc($group['slug'], 'url')// ?>"> -->
					<a class="link_groupIndex" href="<?= site_url('group/').esc($group['slug'], 'url').'/view/' ?>">
						<div class="myGroupIndex card mb-3">
							<div class="row g-0">
								<div class="col-md-4">
									<img src="<?php if(!empty($group['picture'])){echo base_url('images/group/').'/'.$group['picture'];}else{echo base_url('images/group/default-group-image.jpg');} ?>" class="img-fluid rounded-start" alt="..." style="height: 100%">
								</div>
								<div class="col-md-8">
									<div class="card-body">
										<h5 class="card-title"><?= $group['name']?></h5>
										<p class="card-text"><?= $group['description']?></p>
										<p class="card-text"><small class="text-muted"><?= $group['city']?></small></p>
									</div>
								</div>
							</div>
						</div>
					</a>
				<?php endforeach ?>
					
				<h5>Découvrez aussi...</h5>
			<?php endif ?>
			
			<!-- On suggère des groupes !-->
			<div class="d-grid gap-3 p-3">
			<?php foreach ($groups as $group): ?>
				<!--<a class="link_groupIndex" href="<?php echo site_url('group/view/').esc($group['slug'], 'url') ?>">!-->
					<div class="card">
						<div class="row g-0">
							<div class="col-md-4">
								<img src="<?php if(!empty($group['picture'])){echo base_url('images/group/').'/'.$group['picture'];}else{echo base_url('images/group/default-group-image.jpg');} ?>" class="img-fluid rounded-start" alt="..." style="height: 100%">
							</div>
							<div class="col-md-8">
								<div class="card-body">
									<h5 class="card-title" onclick="location.href='<?= site_url('group/').esc($group['slug'], 'url').'/view/' ?>'"><?php echo $group['name']?></h5>
									<p class="card-text"><?php echo $group['description']?></p>
									<p class="card-text"><small class="text-muted"><?php echo $group['city']?></small></p>
								</div>
							</div>
						</div>
					</div>
				
			<?php endforeach ?>
			</div>
			
		</div>  <!-- End Colonne Principale !-->
		
	</div>
	
</div>