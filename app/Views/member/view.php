
<script type="text/javascript">

	$(function() {
		
		var initValue = "";
		var inputEdited = false;
		
		// EDIT // On fixe le comportement des bouttons d'edit
		$("#profil form button#editBtn").each(function() {
			$(this).on("click", function() {
				
				// On fait un reset au cas où
				reset();
				
				// On récupère la div parent
				$parentDiv = $(this).parents("div[id$='Div']");
				
				// On sauve la valeur initiale
				initValue = $parentDiv.find("input").val();
				
				// On édit le input
				$parentDiv.find("input").prop("disabled",false).focus();
				
				// On actualise l'UI
				$parentDiv.find("#editBtn").addClass("d-none");
				$parentDiv.find("#abortBtn").removeClass("d-none");
				$parentDiv.find("#saveBtn").removeClass("d-none");
			});			
		});
		
		// ABORT // On fixe le comportement des bouttons annuler
		$("#profil form button#abortBtn").each(function() {
			$(this).on("click", function() {
				reset();
			});			
		});
		
		
		// SAVE // On fixe le comportement des bouttons d'enregistrement
		$("#profil form button#saveBtn").each(function() {
			$(this).on("click", function() {
				update();
			});			
		});
		
		// On gère l'UI via le clavier
		$(document).on('keydown', function(evt) {
			// ESCAPE :: On fait un abort si c'est possible
			if (evt.key === "Escape") {
				reset();
			}
			// ENTER :: On enregistre si c'est possible (input focused)
			else if (evt.key === "Enter" && $("#profil form input[type='text']:focus").length > 0) {
				// On enlève le focus de l'input
				$("#profil form input[type='text']:focus").blur();
				// On update
				update();
			}
		});
		
	
	
	////////////////////////////////////////////////////////
	
	
	//////// RESET // On annule l'édition si possible + rétablissement de la valeur initiale là où il faut
	function reset() {
		
		// On cherche un abort qui est affiché
		$abortBtnDisplayed = $("#profil form").find("#abortBtn:not(.d-none)");
		
		// On actualise l'UI
		if ($abortBtnDisplayed) {
			
			// On récupère la div parent
			$parentDiv = $abortBtnDisplayed.parents("div[id$='Div']");
			
			// On reset le input à sa valeur initiale
			$parentDiv.find("input").val(initValue);
			
			// On remet le champ disabled
			$parentDiv.find("input").prop("disabled",true);
			
			// On actualise les bouttons
			$parentDiv.find("#editBtn").removeClass("d-none");
			$parentDiv.find("#abortBtn").addClass("d-none");
			$parentDiv.find("#saveBtn").addClass("d-none");
			// On enlève le focus
			$parentDiv.find("input").blur();
		}
	}
	
	
	//////// UPDATE // On valide l'édition si possible via Ajax
	function update() {
		
		// On cherche un update qui est affiché
		$updateBtnDisplayed = $("#profil form").find("#saveBtn:not(.d-none)");
		
		if ($updateBtnDisplayed) {
		
			// On récupère la div parent
			$parentDiv = $updateBtnDisplayed.parents("div[id$='Div']");
			
			// On change le curseur
			$("body").addClass("wait");
			$("#modal_wait").removeClass("fade").modal('show');
		
			// Requète ajax au serveur
			$.post("<?php echo site_url('ajax_member/update'); ?>",
			
				{	
					'id':'<?php echo $_SESSION["member"]["id"] ?>',
					'email':$('#profil #emailDiv input').val(),
					'name':$('#profil #nameDiv input').val(),
					'first_name':$('#profil #first_nameDiv input').val(),
					// 'genre':$('#profil #genreDiv input').val(),
					// 'birth':$('#profil #birthDiv input').val(),
					// 'phone':$('#profil #phoneDiv input').val().replace(/\s/g, ''),
					// 'allowMail':$('#profil #allowMailDiv input').is(':checked') ? "1" : "0",
					// 'freqRecapMail':$('#profil #freqRecapMailDiv input').val()
				},
			
				function (return_data) {
					
					$obj = JSON.parse(return_data);
					
					// On change le curseur
					$("body").removeClass("wait");
					
					// Succès
					if ($obj['state'] == 1) {
						// On paramètre la modal_msg
						$('#modal_wait').on('hidden.bs.modal', function () {
							$("#modal_msg .modal-title").html("Modification réussie !");
							$("#modal_msg .modal-body").html($obj['data']);
							$("#modal_msg").modal('show');
						});
					}
					
					// Erreur
					else {
						// On reset
						reset();
						// On paramètre la modal_msg
						$('#modal_wait').on('hidden.bs.modal', function () {
							$("#modal_msg .modal-title").html("Modification annulée !  :-(");
							$("#modal_msg .modal-body").html($obj['data']);
							$("#modal_msg").modal('show');
						});
					}
					
					// On hide la modal_wait
					$("#modal_wait").addClass("fade").modal('hide');

					// On actualise l'UI de la page
					$parentDiv.find("input").prop("disabled",true);
					$parentDiv.find("#editBtn").removeClass("d-none");
					$parentDiv.find("#abortBtn").addClass("d-none");
					$parentDiv.find("#saveBtn").addClass("d-none");
				}
			);
		}
	}
	
	});
	
</script>

<div id="profil" class="container mainContent">

	<div class="d-flex align-items-center">
		<img id="avatar" class="rounded-circle p-3" src="<?php if(!empty($member['picture'])){echo base_url('images/member/').'/'.$member['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>"
			alt="image de profil">
		<h1 class="p-3"><?php echo $member['pseudo'] ?></h1>
	</div>
	
	<form>
	
		<fieldset>
		
			<!-- Email !-->
			<div id="emailDiv" class="row mb-3">
				<label class="col-2 col-form-label">Email</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['email'] ?>" disabled>
						<button id="editBtn" class="input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button id="abortBtn" class="input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button id="saveBtn" class="input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Nom !-->
			<div id="nameDiv" class="row mb-3">
				<label class="col-2 col-form-label">Nom</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['name'] ?>" disabled>
						<button id="editBtn" class="input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button id="abortBtn" class="input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button id="saveBtn" class="input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Prénom !-->
			<div id="first_nameDiv" class="row mb-3">
				<label class="col-2 col-form-label">Prénom</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['first_name'] ?>" disabled>
						<button id="editBtn" class="input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button id="abortBtn" class="input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button id="saveBtn" class="input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Naissance !-->
			<div id="birthDiv" class="row mb-3">
				<label class="col-2 col-form-label">Date de naissance</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['birth'] ?>" disabled>
						<span class="input-group-text btn btn-warning"><i class="bi bi-pencil-fill"></i></span>
					</div>
				</div>
			</div>
			
			
			<!-- Genre !-->
			<div id="genderDiv" class="row mb-3">
				<label class="col-2 col-form-label">Genre</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['gender'] ?>" disabled>
						<span class="input-group-text btn btn-warning"><i class="bi bi-pencil-fill"></i></span>
					</div>
				</div>
			</div>
			
			
			<!-- Mobile !-->
			<div id="phoneDiv" class="row mb-3">
				<label class="col-2 col-form-label">Mobile</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['phone'] ?>" disabled>
						<span class="input-group-text btn btn-warning"><i class="bi bi-pencil-fill"></i></span>
					</div>
				</div>
			</div>
			
		</fieldset>
		
	</form>
	
	
	<!--
		<li class="list-group-item text-center">
			<a class="btn btn-outline-dark" href="<?php echo site_url('member/update'); ?>">Modifier</a>
		</li>
	</ul> !-->
	
	<div class="text-end pt-2">
		<button class="btn btn-primary" onclick="location.href='<?php echo site_url('group/create'); ?>'" href="">Créer un groupe</button>
	</div>
	
</div>