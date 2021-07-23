

<!-- Bootstrap datepicker !-->
<script type="text/javascript" src="<?php echo base_url("/plugin/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("/plugin/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.fr.min.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("/plugin/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.min.css"); ?>"/>


<!-- Bootstrap-select !-->
<link rel="stylesheet" href="<?php echo base_url("plugin/bootstrap-select-1.13.18/bootstrap-select.min.css" ); ?>"/>
<script type="text/javascript" src="<?php echo base_url("plugin/bootstrap-select-1.13.18/bootstrap-select.min.js"); ?>"></script>

<script type="text/javascript" src="<?php echo base_url("plugin/popper/popper.min.js"); ?>"></script>

<!--
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
!-->

<!-- Cropper js !-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.7/cropper.min.css"/>





<script type="text/javascript">

	$(function() {
		
		var initValue = "";		
		
		
		// On initialise le datepicker
		$('#birth').datepicker({
			format: "dd/mm/yyyy",
			todayBtn: "linked",
			language: "fr",
			todayHighlight: true,
			startView: 2
		});
		
		// On initialise le selectpicker du genre
		$('#profil #gender').selectpicker('val', '<?php echo $member["gender"] ?>');
		
		
		
		// EDIT // On fixe le comportement des bouttons d'edit
		$("#profil form button.editBtn").each(function() {
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
				$parentDiv.find(".editBtn").addClass("d-none");
				$parentDiv.find(".abortBtn").removeClass("d-none");
				$parentDiv.find(".saveBtn").removeClass("d-none");
			});			
		});
		
		// ABORT // On fixe le comportement des bouttons annuler
		$("#profil form button.abortBtn").each(function() {
			$(this).on("click", function() {
				reset();
			});
		});		
		
		// SAVE // On fixe le comportement des bouttons d'enregistrement
		$("#profil form button.saveBtn").each(function() {
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
			$abortBtnDisplayed = $("#profil form").find(".abortBtn:not(.d-none)");
			
			// On actualise l'UI
			if ($abortBtnDisplayed) {
				
				// On récupère la div parent
				$parentDiv = $abortBtnDisplayed.parents("div[id$='Div']");
				
				// On reset le input à sa valeur initiale
				$parentDiv.find("input").val(initValue);
				
				// On enlève le focus
				$parentDiv.find("input").blur();
				
				// On remet le champ disabled
				$parentDiv.find("input").prop("disabled",true);
				
				// On actualise les bouttons
				$parentDiv.find(".editBtn").removeClass("d-none");
				$parentDiv.find(".abortBtn").addClass("d-none");
				$parentDiv.find(".saveBtn").addClass("d-none");
				
			}
		}
		
		
		//////// UPDATE // On valide l'édition si possible via Ajax
		function update() {
			
			// On cherche un update qui est affiché
			$updateBtnDisplayed = $("#profil form").find(".saveBtn:not(.d-none)");
			
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
						'birth':$('#profil #birthDiv input').val(),
						'gender':$('#profil #genderDiv input').val(),
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
							// $('#modal_wait').on('hidden.bs.modal', function () {
								// $("#modal_msg .modal-title").html("Modification réussie !");
								// $("#modal_msg .modal-body").html($obj['data']);
								// $("#modal_msg").modal('show');
							// });
						}
						
						// Erreur
						else {
							// On reset
							reset();
							// On paramètre la modal_msg
							$('#modal_wait').on('hidden.bs.modal', function () {
								$("#modal_msg .modal-title").html("Modification annulée !&nbsp;&nbsp;&nbsp;:-(");
								$("#modal_msg .modal-body").html($obj['data']);
								$("#modal_msg").modal('show');
							});
						}
						
						// On hide la modal_wait
						$("#modal_wait").addClass("fade").modal('hide');

						// On actualise l'UI de la page
						$parentDiv.find("input").prop("disabled",true);
						$parentDiv.find(".editBtn").removeClass("d-none");
						$parentDiv.find(".abortBtn").addClass("d-none");
						$parentDiv.find(".saveBtn").addClass("d-none");
					}
				);
			}
		}
		
		
		// ***************** AVATAR ****************
		// *****************************************
		
		var image = document.getElementById('imageAvatar');
		
		// On charge l'image de l'avatar si la variable picture est set_error_handler
		<?php if (isset($member['id'])) : ?>
			$.ajax({
				url:'<?php echo base_url("images/member/")."/".$member["id"].".png"; ?>',
				type:'HEAD',
				success: function() {
					$("#avatar img").prop("src",'<?php echo base_url("images/member/")."/".$member["id"].".png"; ?>');
				}
			});
		<?php endif ?>
		
		
		$("#profil #avatar").hover(function() {
			$(this).find("button").fadeIn("fast");
		},function() {
			$(this).find("button").fadeOut("fast");
		});
		
		// ***** Cropper options ******
		$("#updateAvatarModal #btnOptions button").on('click', function(event) {
			
			$target = $(event.currentTarget);
			
			switch($target.prop("id")) {
				case "btnRotate1":
					cropper.rotate(45);
					break;
				case "btnRotate2":
					cropper.rotate(-45);
					break;
				case "btnInvert1":
					cropper.scaleX(cropper.getImageData().scaleX * -1);
					break;
				case "btnInvert2":
					cropper.scaleY(cropper.getImageData().scaleY * -1);
					break;
				case "btnReset":
					cropper.reset();
					break;
				default:
				// code block
			} 
		});
		
		
		// **** SEND new avatar ***
		$("#updateAvatarModal #btnSend").on('click', function(event) {

			// On récupère la nouvelle image
			$croppedImg = cropper.getCroppedCanvas({
				width: 128,
				height: 128,
				minWidth: 128,
				minHeight: 128,
				fillColor: '#fff',
				imageSmoothingEnabled: true,
				imageSmoothingQuality: 'high',
			});
			
			
			// On change le curseur
			document.body.style.cursor = 'progress';
			
			// Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`.
			// The default value for the second parameter of `toBlob` is 'image/png', change it if necessary.
			canvas = cropper.getCroppedCanvas({
				width: 256,
				height: 256,
			});
			
			
			canvas.toBlob(function (blob) {
				var formData = new FormData();

				formData.append('file', blob);
				
				$.ajax('<?php echo site_url(); ?>/ajax_member/update_avatar', {
					method: 'POST',
					data: formData,
					processData: false,
					contentType: false,

					// xhr: function () {
						// var xhr = new XMLHttpRequest();

						// xhr.upload.onprogress = function (e) {
							// var percent = '0';
							// var percentage = '0%';

							// if (e.lengthComputable) {
								// percent = Math.round((e.loaded / e.total) * 100);
								// percentage = percent + '%';
								// $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
							// }
						// };

						// return xhr;
					// },

					success: function (return_data) {
						console.log('Upload success : '+return_data);
						
						// On change le curseur
						document.body.style.cursor = 'default';
						
						// On ferme la modal (ce qui détruit le cropper)
						$("#updateAvatarModal").modal("hide");
						
						// On actualise l'image courante avec la nouvelle
						$("#avatar img").prop("src",canvas.toDataURL());
					},

					error: function () {
						console.log('Upload error');
					},
				});
			});
			
		});
		
			
		// **************** CROPPER MODAL
		// On attend que la modal soit complètement ouverte
		$("#updateAvatarModal").on('shown.bs.modal', function() {
			// On instancie le cropper
			cropper = new Cropper(image, {
				aspectRatio: 1
			});
		});
		
		// On détruit le cropper à la fermeture
		$("#updateAvatarModal").on('hidden.bs.modal', function () {
			cropper.destroy();
			cropper = null;
		});
		
		
		// **************** File Selected
		$("#fileSelectInput").on("change", function(e) {
			// On ouvre la modal d'update
			$("#updateAvatarModal").modal('show');
			// On récupère l'image select
			image.src = URL.createObjectURL(event.target.files[0]);
		});
		
	});


	// ************ AVATAR ************
	// Pour ouvrir une fenêtre d'exploration afin de selec un fichier
	function browse(target) {
		//$("#modal_msg").modal('hide');
		$(target).trigger('click');
	}

	
</script>

<div id="profil" class="container mainContent">


	<!-- Avatar + Pseudo + Cropper Btn !-->
	<div id="profil-title" class="d-flex my-3">
	
		<!-- Avatar !-->
		<div id="avatar" class="col-sm-2">
			<img class='rounded-circle' src='<?php echo base_url("images/icons/avatarWhite.png"); ?>' width="128" height="128">
			<!-- Upload -->
			<button class="fileUpload btn btn-xs btn-primary" onclick="javascript:browse('#profil-title #fileSelectInput')" title="Envoyer une image"><i class="bi bi-camera-fill"></i></button>
		</div>
		
		<!-- Input invisible qui se charge de récupérer le fichier !-->
		<input id="fileSelectInput" type="file" name="file" accept="image/*" style="display:none" />
		
		<!-- Pseudo !-->
		<div class="col-sm-8 align-self-end">
			<h2><?php echo $member['pseudo']; ?></h2>
		</div>
		
	</div>
	
	
	<!-- Formulaire !-->
	<form>
	
		<fieldset>
		
			<!-- Email !-->
			<div id="emailDiv" class="row mb-3">
				<label class="col-2 col-form-label">Email</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['email'] ?>" disabled>
						<button class="editBtn input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button class="abortBtn input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button class="saveBtn input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Nom !-->
			<div id="nameDiv" class="row mb-3">
				<label class="col-2 col-form-label">Nom</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['name'] ?>" disabled>
						<button class="editBtn input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button class="abortBtn input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button class="saveBtn input-group-text btn btn-primary d-none saveBtn" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Prénom !-->
			<div id="first_nameDiv" class="row mb-3">
				<label class="col-2 col-form-label">Prénom</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['first_name'] ?>" disabled>
						<button class="editBtn input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button class="abortBtn input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button class="saveBtn input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Naissance !-->
			<div id="birthDiv" class="row mb-3">
				<label class="col-2 col-form-label">Date de naissance</label>
				<div class="col-10">
					<div class="input-group">
						<input id="birth" type="text" class="form-control" value="<?php echo $member['birth'] ?>" data-provide="datepicker">
						<button class="editBtn input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button class="abortBtn input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button class="saveBtn input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
					</div>
				</div>
			</div>
			
			
			<!-- Genre !-->
			<div id="genderDiv" class="row mb-3">
				<label class="col-2 col-form-label">Genre</label>
				<div class="col-10">
					<div class="input-group">
						<select id="gender" class="form-control" name="gender" data-style="btn-primary">
							<option value="0">Non spécifié</option>
							<option value="1">Homme</option>
							<option value="2">Femme</option>
						</select>
					</div>
				</div>
			</div>
			
			
			<!-- Mobile !-->
			<div id="phoneDiv" class="row mb-3">
				<label class="col-2 col-form-label">Mobile</label>
				<div class="col-10">
					<div class="input-group">
						<input type="text" class="form-control" value="<?php echo $member['phone'] ?>" disabled>
						<button class="editBtn input-group-text btn btn-warning" type="button"><i class="bi bi-pencil-fill"></i></button>
						<button class="abortBtn input-group-text btn btn-primary d-none" type="button">Annuler</button>
						<button class="saveBtn input-group-text btn btn-primary d-none" type="button">Enregistrer</button>
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



<!-- ******** MODAL UPDATE AVATAR ******* !-->
<div id="updateAvatarModal" class="modal fade" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog default">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Modifier l'image du profil</h5>
		</div>
		<div class="modal-body">
		
			<!-- CROPPER !-->
			<div class="row text-center">
				<img id="imageAvatar">
			</div>
			
			<!-- OPTION !-->
			<div id="btnOptions" class="btn-toolbar d-flex justify-content-center p-3 gap-3" role="toolbar">
			
				<!-- Rotate !-->
				<div class="btn-group" role="group">
					<button id="btnRotate1" type="button" class="btn btn-xs btn-primary">
						<span title="Tourner l'image">
							<image src='<?php echo base_url("images/icons/rotate1.png"); ?>' width='20px' height='20px' css="filter: invert(1)">
						</span>
					</button>
					<button id="btnRotate2" type="button" class="btn btn-xs btn-primary">
						<span title="Tourner l'image">
							<image src='<?php echo base_url("images/icons/rotate2.png"); ?>' width='20px' height='20px'>
						</span>
					</button>
				</div>
				
				<!-- Miror !-->
				<div class="btn-group" role="group">
					<button id="btnInvert1" type="button" class="btn btn-xs btn-primary">
						<span title="Inverser l'image">
							<image src='<?php echo base_url("images/icons/miror1.png"); ?>' width='20px' height='20px'>
						</span>
					</button>
					<button id="btnInvert2" type="button" class="btn btn-xs btn-primary">
						<span title="Inverser l'image">
							<image src='<?php echo base_url("images/icons/miror2.png"); ?>' width='20px' height='20px'>
						</span>
					</button>
				</div>
				
				<!-- Reset !-->
				<div class="btn-group" role="group">
					<button id="btnReset" type="button" class="btn btn-xs btn-primary">
						Init
					</button>
				</div>
				
			</div>
				
				
			<!-- Envoyer !-->
			<div class="d-flex justify-content-center">
				<button id="btnSend" type="button" class="btn btn-primary">
					Envoyer
				</button>
			</div>
			
		</div>
	</div>
	</div>
</div>