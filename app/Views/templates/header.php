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
	<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" 
		integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous">
	</script>
	

    <!-- Style maison -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('/css/style.min.css'); ?>"> !-->
	<link rel="stylesheet" href="<?php echo base_url('/css/style.css'); ?>">
	

    <title>Jamaïzer</title>
	
</head>

	<!-- JAVASCRIPT -->
	<script type="text/javascript">

		$(function() {
			// add padding top to show content behind navbar
			navbar_height = document.querySelector('.navbar').offsetHeight;
			document.body.style.paddingTop = navbar_height + 'px';
		});
		

	</script>


<body id="bootstrap-overrides">

<?php if(isset($_SESSION['logged']) && $_SESSION['logged']) : ?>
<!-- // ##################################################################### // -->
<!-- // ######################## NAV TOP PHONE LOGGED ####################### // -->
<!-- // ##################################################################### // -->
    <div id="nav-logged-phone" class="container-fluid fixed-top d-lg-none d-flex justify-content-around align-items-center flex-row">
        <a  class="d-flex align-items-center my-2" href="<?= site_url('member/profil') ?>">
            <div>
                <img src="<?php if(!empty($_SESSION['member']['picture'])){echo base_url('images/member/').'/'.$_SESSION['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-profil-nav-phone m-1">
            </div>   
        </a>
        <a href="#" alt="Mes Groupes"><i class="bi bi-people-fill"></i></a>
        <a href="#" alt="Mes événements"><i class="bi bi-calendar3-fill"></i></a>
        <a href="#" alt="Mes messages"><i class="bi bi-chat-dots-fill"></i></a>
        <a href="#" alt="Déconnexion"><i class="bi bi-door-open-fill"></i></a>
    </div>
<?php endif ?>


<!-- // ##################################################################### // -->
<!-- // ############################### HEADER ############################## // -->
<!-- // ##################################################################### // -->
    <header>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark  mt-auto">
            <div class="container-fluid">
                <a class="navbar-brand d-lg-none" href="<?= site_url('') ?>">
                    <h2>Jamaïzer</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url(); ?>">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('about'); ?>">A propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Les groupes</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Un Groupe</a></li>
                                <li><a class="dropdown-item" href="#">Un autre groupe</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Trouver un groupe</a></li>
                            </ul>
                        </li>
                    </ul> -->
                    <a class="navbar-brand d-none d-lg-inline" href="<?= site_url(); ?>">Jamaïzer</a>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('group'); ?>">Les groupes</a>
                        </li>
                        <?php if(!isset($_SESSION['logged']) || !$_SESSION['logged']) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('member/inscription'); ?>">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('member/connexion'); ?>">Connexion</a>
                            </li>
                        <?php endif ?>
                        <?php if(isset($_SESSION['logged']) && $_SESSION['logged']) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('member/profil'); ?>">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('member/deconnexion'); ?>">Déconnexion</a>
                            </li>
                        <?php endif ?>
                        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['member']['is_super_admin']) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('admin'); ?>">ADMIN</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

<!-- //  Ouverture de la div qui contient MAIN et ASIDE  // -->
    <div id="j-big-container">


<?php if(isset($_SESSION['logged']) && $_SESSION['logged']) : ?>
<!-- // ##################################################################### // -->
<!-- // ####################### NAV ASIDE ORDI LOGGED ####################### // -->
<!-- // ##################################################################### // -->
        <aside class="d-none d-lg-block p-2">
            <div>
                <a  class="row d-flex align-items-center my-2" href="<?php echo site_url('member/view'); ?>">
                    <div class="col-3">
                        <img src="<?php if(!empty($_SESSION['member']['picture'])){echo base_url('images/member/').'/'.$_SESSION['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-profil m-1">
                    </div>
                    <div class="col-9">
                        <p class="m-1"><?= $_SESSION['member']['pseudo'] ?></p>
                    </div>
                </a>
            </div>
            <div class="accordion j-accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item j-accordion-item">
                    <h5 class="accordion-header j-accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button j-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            <i class="bi bi-people-fill mx-2"></i> Mes Groupes
                        </button>
                    </h5>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($_SESSION['myGroups'] as $group) : ?>
                                <li class="list-group-item">
                                    <a class="d-flex align-items-center" href="<?= site_url('group/view/').esc($group['slug'], 'url') ?>">
                                        <img src="<?php if(!empty($group['picture'])){echo base_url('images/group/').'/'.$group['picture'];}else{echo base_url('images/group/default-group-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-group m-1"><?= $group['name'] ?>
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
                <div class="accordion-item j-accordion-item">
                    <h5 class="accordion-header j-accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button j-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        <i class="bi bi-calendar3-fill mx-2"></i> Mes prochaines dates
                        </button>
                    </h5>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <a href="#" class="j-a-event">
                                        <img src="<?php echo base_url('images/group/chatons-groupe.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">
                                        <p>La Jam des Chatons</p>
                                    </a>
                                    15.08.21
                                </li>
                                <li class="list-group-item">
                                    <a href="#" class="j-a-event">
                                        <img src="<?php echo base_url('images/group/pelicans-groupe.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">
                                        <p>Pélicans en folie - Concert d'ouverture</p>
                                    </a>
                                    15.08.21
                                </li>
                                <li class="list-group-item">
                                    <a href="#" class="j-a-event">
                                        <img src="<?php echo base_url('images/group/autruches-groupe.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">
                                        <p>Le bal des Autruches</p>
                                    </a>
                                    15.08.21
                                </li>
                                <li class="list-group-item">
                                    <a href="#">Toutes mes dates</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item j-accordion-item">
                    <h5 class="accordion-header j-accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button j-accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        <i class="bi bi-chat-dots-fill mx-2"></i>Mes messages
                        </button>
                    </h5>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                        <ul class="list-group list-group-flush">
                                <li class="list-group-item flex-column">
                                    <a href="#">
                                        <img src="<?php echo base_url('images/member/chaton-solo.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">
                                        Chaton
                                    </a>
                                    "Salut, ça va ?"
                                </li>
                                <li class="list-group-item flex-column">
                                    <a href="#">
                                        <img src="<?php echo base_url('images/member/pelican-solo.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">
                                        Pélican
                                    </a>
                                    "Hello !"
                                </li>
                                <li class="list-group-item flex-column">
                                    <a href="#">
                                        <img src="<?php echo base_url('images/member/autruche-solo.jpg'); ?>" alt="image de profil" class="rounded-circle j-img-group m-1">
                                        Autruche
                                    </a>
                                    "Est-ce que tu sais combien de touches a un piano ?"
                                </li>
                                <li class="list-group-item">
                                    <a href="#"> Tous mes messages</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
<?php endif ?>

<!-- // ##################################################################### // -->
<!-- // ######################### Ouverture du MAIN ######################### // -->
<!-- // ##################################################################### // -->
        <main class="mx-auto my-0">