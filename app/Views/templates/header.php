<?php

	use CodeIgniter\I18n\Time;

	// On récupère les variables de sessions
	$session = \Config\Services::session();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Icones bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	
	
	<!-- JQuery 3.6.0 -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	

    <!-- Style maison -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('/css/style.min.css'); ?>"> !-->
	<link rel="stylesheet" href="<?php echo base_url('/css/style.css'); ?>">
	

    <title>Jamaïzer</title>
	
</head>


<!-- JAVASCRIPT -->
<script type="text/javascript">

	$(function() {
		
		// Global layout
		refresh();
		
		// Refresh le layout quant on resize
		$(window).resize(function() {
			refresh();
		});
		
		// Affichage dynamique de la scrollbar de la sidebar (on affiche que si nécessaire)
		// TODO attention ça ne fonctionne pas sur chrome, la scrollbar est affichée en permanence même s'il n'y a rien à faire défiler
		$("#j-sidebar-container").mouseenter(function() {
			realSize = parseInt($("#j-sidebar").css("height"),10);
			if(realSize > parseInt($("#j-sidebar-container").css("height"),10)) {
				$(this).css("scrollbar-width","thin");
			}
		});
		$("#j-sidebar-container").mouseleave(function() {
			$(this).css("scrollbar-width","none");
		});
		
		
		//~~~~~~~~~~~~ Gestion des MODALS de Connexion ~~~~~~~~~~~~
		// On ferme les autres fenêtre au cas où elle seraient ouvertes
		$('#modal_login').on('show.bs.modal', function () {
			$("#modal_forgotten").modal('hide'); 
			$("#modal_msg").modal('hide'); 
		});
		// Gestion de l'autofocus sur les modal box
		$('#modal_login').on('shown.bs.modal', function () {
			$('#modal_login #input').focus();
		});
		// Init lorsqu'on ferme la modal de login
		$('#modal_login').on('hidden.bs.modal', function () {
			$("#modal_login #password").val("");
			$("#modal_login #input").val("");
		});
		$('#modal_msg').on('shown.bs.modal', function () {
			$('#modal_msg #modal_close').focus();
		});
		$('#modal_msg').on('hidden.bs.modal', function () {
			$('#password').focus();
		});
		$('#modal_forgotten').on('shown.bs.modal', function () {
			$('#email').focus();
		});
		
	});
		
		
	// Permet un refresh du layout global
	function refresh() {
		//console.log(":: refresh()");
		
		// On ajouter un padding top pour permettre l'affiche du haut du main et de la sidebar
		navbarHeight = document.querySelector('.navbar').offsetHeight;
		$("main").css("padding-top", navbarHeight+"px");
		$("#j-sidebar-container").css("top", navbarHeight+"px");
		
		// On ajuste la taille de la sidebar 
		sidebarHeight = window.innerHeight - navbarHeight;
		$("#j-sidebar-container").css("height",sidebarHeight+"px");

		
	}
	
	
	/********* Login ***********/
	// Bootstrap s'occupe de la validation (email valide, pas de champs vide)
	function login() {
		
		// On change le curseur
		document.body.style.cursor = 'wait';
		
		// Requète ajax au serveur
		$.post("<?php echo site_url('ajax_member/login'); ?>",
		
			// On récupère les données nécessaires
			{
				'input':$('#input').val(),
				'password':$('#password').val()
			},
			
			// On traite la réponse du serveur			
			function (return_data) {
				
				//console.log(return_data);
				$obj = JSON.parse(return_data);
				
				// On change le curseur
				document.body.style.cursor = 'default';

				// Utilisateur loggé => on recharge la page actuelle
				if ($obj['state'] == 1) {
					location.reload();
				}
				
				//Utilisateur non loggé => Erreur
				else {
					// On ferme la modal de login et on vide ses input
					$("#modal_login").modal('hide');
					
					// On affiche la modal d'erreur
					$("#modal_msg .modal-header .modal-title").html("Erreur !");
					$("#modal_msg .modal-body").html($obj['data']);
					$("#modal_msg .modal-footer").html('<a id="modal_close" href="#" data-bs-dismiss="modal">Fermer</a>');

					
					$("#modal_msg").modal('show');
				}
			}
		);
	}
	
	
	
	/***** Modal box de Mot de passe oublié *******/
	function forgotten_box() {

		$("#modal_login").modal('hide');
		
		// On teste si le input est un email. Si oui on la recopie pour le forgotten
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		if($("#input").val().match(re)) {
			$("#email").val($("#input").val());
		}
		
		$("#modal_forgotten").modal('show');
	}
	
	
	/***** Mot de passe oublié *******/
	function forgotten() {
	
		// On change le curseur
		document.body.style.cursor = 'wait';
		
		// Requète ajax au serveur
		$.post("<?php echo site_url('ajax_member/forgotten'); ?>",
		
			// On récupère les données nécessaires
			{'email':$('#email').val()
			},
			
			// On traite la réponse du serveur			
			function (return_data) {
				
				//console.log(return_data);
				$obj = JSON.parse(return_data);
				
				// On change le curseur
				document.body.style.cursor = 'default';

				// Mot de passe envoyé par email
				if ($obj['state'] == 1) {
					// Success
					// On affiche la modal d'erreur
					$("#modal_msg .modal-header .modal-title").html("Email envoyé");
					$("#modal_msg .modal-body").html($obj['data']);
					$("#modal_msg .modal-footer").html('<a id="modal_close" href="#" data-bs-dismiss="modal">Fermer</a>');
					
					
					/*$("#modal_msg .modal-dialog").removeClass("error");
					$("#modal_msg .modal-dialog").addClass("success");
					$("#modal_msg .modal-dialog").addClass("backdrop","static");
					$("#modal_msg .modal-header").html("Email envoyé");
					$("#modal_msg .modal-body").html($obj['data']);
					$("#modal_msg .modal-footer").html('<a id="modal_close" href="#" data-dismiss="modal">Fermer</a>');*/
				}
				
				// Erreur lors de l'envoie de mail
				else {
					// On affiche la modal d'erreur
					$("#modal_msg .modal-header .modal-title").html("Erreur !");
					$("#modal_msg .modal-body").html($obj['data']);
					$("#modal_msg .modal-footer").html('<a id="modal_close" href="#" data-bs-dismiss="modal">Fermer</a>');
				}
				
				// On cache la modal de forgotten et on vide ses input
				$("#modal_forgotten").modal('hide');
				$("#email").val("");
				$("#modal_msg").modal('show');
			}
		);
	}
	
	
</script>


<body id="bootstrap-overrides">
	<?php if (isset($session->logged) && $session->logged) : ?>
		<!-- // ##################################################################### // -->
		<!-- // ######################## NAV TOP PHONE LOGGED ####################### // -->
		<!-- // ##################################################################### // -->
	<!-- cette nav est cachée derrière le header -->
    <div id="nav-logged-phone" class="container-fluid fixed-top d-lg-none d-flex justify-content-around align-items-center flex-row">
        <a  class="d-flex align-items-center my-2" href="<?php echo site_url('member/profil') ?>">
            <div>
                <img src="<?php if(!empty($_SESSION['member']['picture'])){echo base_url('images/member/').'/'.$_SESSION['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-profil-nav-phone m-1">
            </div>   
        </a>
        <a href="<?= site_url('group'); ?>" alt="Mes Groupes"><i class="bi bi-people-fill"></i></a>
        <a href="#" alt="Mes événements"><i class="bi bi-calendar3-fill"></i></a>
        <a href="#" alt="Mes messages"><i class="bi bi-chat-dots-fill"></i></a>
        <a href="<?= site_url('ajax_member/deconnexion'); ?>" alt="Déconnexion"><i class="bi bi-door-open-fill"></i></a>
    </div>
<?php endif ?>

<!-- // ##################################################################### // -->
<!-- // ######################### HEADER NAVBAR ############################## // -->
<!-- // ##################################################################### // -->
    <header>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark mt-auto">
            <div class="container-fluid">
                <a class="navbar-brand d-lg-none" href="<?php echo site_url('') ?>">
                    <h2>Jamaïzer</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <a class="navbar-brand d-none d-lg-inline j-label" href="<?php echo site_url(); ?>">Jamaïzer</a>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					
						<!-- Les groupes !-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('group'); ?>">Groupes</a>
                        </li>
						
						<!-- Non connecté !-->
                        <?php if ( !isset($session->logged) || !$session->logged ) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('member/inscription'); ?>">Inscription</a>
                            </li>
							
							<!-- modal_login est dans le footer !-->
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="modal" data-bs-target="#modal_login" href=""><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
							</li>

							
						<!-- Connecté !-->
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('member/profil'); ?>">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('ajax_member/logout'); ?>">Déconnexion</a>
                            </li>
                        <?php endif; ?>
						
						<!-- Super Admin !-->
                        <?php if( isset($session->logged) && ($session->logged && $session->member['is_super_admin']) ) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo site_url('admin'); ?>">ADMIN</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


<!-- //  Ouverture de la div qui contient MAIN et SIDEBAR  // -->
<div id="j-container" class="container-fluid">
	<div class="flex-nowrap">
		<?php if (isset($session->logged) && $session->logged) : ?>
			<!-- // ####################################################################### // -->
			<!-- // ####################### NAV SIDEBAR ORDI LOGGED ####################### // -->
			<!-- // ####################################################################### // -->
			<div id="j-sidebar-container" class="fixed-top col-auto col-md-3 col-xl-2">
			
				<div id="j-sidebar">
						
					<!-- Pseudo !-->
					<div>
						<a class="row d-flex align-items-center my-2" href="<?php echo site_url('member/profil'); ?>">
						<div class="col-3">
							<img id="avatar" class="rounded-circle m-1" alt="image de profil" 
							src="<?php 
										if (!empty($session->member['picture'])) echo base_url('images/member/').'/'.$session->member['picture'];
										else echo base_url('images/member/default-member-image.jpg');
										?>">
							</div>
							<div class="col-9">
								<p class="m-1"><?= $session->member['pseudo'] ?></p>
							</div>
						</a>
					</div>
						
					<!-- LIST GROUP !-->
					<?php if (isset($session->myGroups)) : ?>
					<div class="accordion">
						<div class="accordion-item">
							<h5 class="accordion-header" id="panelsStayOpen-headingOne">
								<button class="accordion-button j-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
									<i class="bi bi-people-fill mx-2"></i> Mes Groupes
								</button>
							</h5>
							<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
								<div class="accordion-body">
									<ul class="list-group list-group-flush">
										<?php foreach ($session->myGroups as $group) : ?>
										<li class="list-group-item">
											<a class="d-flex align-items-center" href="<?= site_url('group/view/').esc($group['slug'], 'url') ?>">
												<img alt="image de profil" class="rounded-circle img-group m-1"
													src="<?php 
														if (!empty($group['picture'])) echo base_url('images/group/').'/'.$group['picture'];
														else echo base_url('images/group/default-group-image.jpg'); ?>">
												
												<?php echo $group['name'] ?>
												<div class="ms-auto">
													<?php if($group['is_admin'] && $group['is_valid']) : ?>  
														<i class="bi bi-gear ms-auto"></i>
													<?php elseif($group['is_admin'] && !$group['is_valid']) : ?>
														<i class="bi bi-patch-question ms-auto"></i>
													<?php endif ?>
												</div>
											</a>
										</li>
										<?php endforeach ?>
										<!-- <li class="list-group-item">
											<a href="#">
												<img src="<?php echo base_url('images/pelicans-groupe.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">Les Pélicans
											</a>
										</li>
										<li class="list-group-item">
											<a href="#">
												<img src="<?php echo base_url('images/autruches-groupe.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">Les Autruches
											</a>
										</li> -->
										<li class="list-group-item">
											<a href="<?= site_url('group'); ?>">Tous mes groupes</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						
							
							<!-- LIST DATE !-->
							<div class="accordion-item">
								<h5 class="accordion-header" id="panelsStayOpen-headingTwo">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
									<i class="bi bi-calendar3-fill mx-2"></i> Mes prochains "events"
									</button>
								</h5>
								<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
									<div class="accordion-body">
										<ul class="list-group list-group-flush">
											<?php foreach($session->myEvents as $event) : ?>
											<li class="list-group-item">
												<a href="<?= site_url('group').'/'.esc($event['group']['slug'], 'url').'/event/'.esc($event['slug'], 'url') ?>" class="a-event">
													<img src="<?php 
															if (!empty($event['group']['picture'])) echo base_url('images/group/').'/'.$group['picture'];
															else echo base_url('images/group/default-group-image.jpg'); ?>" alt="image de profil" class="rounded-circle img-group m-1">
													<p><?php echo $event['name'] ?></p>
													<div class="ms-auto">
														<?php if($event['is_admin']) : ?>  
															<i class="bi bi-gear ms-auto"></i>
														<?php endif ?>
													</div>
												</a>
											</li>
											<?php endforeach ?>
											<li class="list-group-item">
												<a href="#">Toutes mes dates</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							
							
				</div> <!-- On ferme l'accordéon !-->
				<?php endif; ?>
				
				<!-- FOOTER !-->
				<div id="footer" class="container text-center pt-3">
					<small>
						<a href="<?php echo site_url('contact'); ?>">Contact</a> |
						<a href="<?php echo site_url('about'); ?>">A propos</a> |
						<a href="<?php echo site_url('mentions_legales'); ?>" data-bs-toggle="modal" data-bs-target="#show_mentions">Mentions Légales</a>
						<br>
						<span class="soften text-nowrap">&copy; 2020 - <?php echo date("Y"); ?></span>
					</small>
				</div>
				
				
			</div> <!-- On ferme la sidebar !-->
				
        </div>	<!-- On ferme la sidebar-container !-->
		
		<!-- le reste est fermé dans le footer !-->
	
		
<?php endif; ?>

<!-- // ##################################################################### // -->
<!-- // ######################### Ouverture du MAIN ######################### // -->
<!-- // ##################################################################### // -->
        <main class="container col-auto col-md-6 col-xl-6 <?php if(isset($session->logged) && $session->logged) : ?> offset-md-4 offset-xl-4 <?php endif; ?> pb-3">
		