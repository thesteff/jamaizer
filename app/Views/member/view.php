<div id="page-profil">
    <div class="d-flex align-items-center">
        <img id="j-img-page-profil" class="rounded-circle p-3" src="<?php if(!empty($_SESSION['member']['picture'])){echo base_url('images/member/').$_SESSION['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>"
            alt="image de profil">
        <h1 class="mx-auto p-3"><?= $_SESSION['member']['pseudo'] ?></h1>
    </div>
    <a class="btn btn-outline-dark" href="<?= site_url('group/create'); ?>">Créer un groupe</a>
    <p>Necessitatibus et repudiandae cum voluptas placeat.Distinctio fugit distinctio. Quo voluptates perferendis. Nisi
        amet natus natus optio voluptatum. Ut fugiat commodi et. Est qui quae et est libero repudiandae quasi et. Vel
        quo nulla inventore dolore tenetur in. Omnis similique occaecati ullam voluptatem blanditiis accusantium
        molestiae. Maxime incidunt omnis doloremque ad. Quia officiis id doloribus vitae repellendus quasi minima eos.
        Eum minima voluptatibus quam numquam animi et similique ratione quo. Molestias architecto ut hic nisi earum qui
        dolor itaque ducimus. Mollitia maiores odit amet sequi doloremque ullam dicta.</p>

    <h2 class="h5">Mes infos</h2>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>Pseudo :</small>
                </div>
                <div class="col-8 text-center">
                    <?= $_SESSION['member']['pseudo'] ?>
                </div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>Email :</small></div>
                <div class="col-8 text-center">
                    <?= $_SESSION['member']['email'] ?></div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>Nom :</small>
                </div>
                <div class="col-8 text-center">
                    <?= $_SESSION['member']['name'] ?>
                </div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>Prénom :</small>
                </div>
                <div class="col-8 text-center">
                    <?= $_SESSION['member']['first_name'] ?>
                </div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>Date de naissance :</small>
                </div>
                <div class="col-8 text-center">
                    <?= $_SESSION['member']['birth'] ?>
                </div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>Genre :</small>
                </div>
                <div class="col-8 text-center">
                    <?php if($_SESSION['member']['gender'] == 0){echo "";} elseif ($_SESSION['member']['gender'] == 1) {echo "Homme";} elseif ($_SESSION['member']['gender'] == 2){echo "Femme";} elseif ($_SESSION['member']['gender'] == 3){echo "Non-Binaire";} ?>
                </div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row">
                <div class="col-2">
                    <small>N° de téléphone :</small>
                </div>
                <div class="col-8 text-center">
                    <?= $_SESSION['member']['phone'] ?>
                </div>
                <div class="col-2">
                    visibilité
                </div>
            </div>
        </li>
        <li class="list-group-item text-center">
            <a class="btn btn-outline-dark" href="<?= site_url('member/update'); ?>">Modifier</a>
        </li>
    </ul>
</div>