<div id="j-group-header">
    <div class="card rounded-0">
        <img src="<?php if(!empty($group['picture'])){echo base_url('images/group/').'/'.$group['picture'];}else{echo base_url('images/group/default-group-image.jpg');} ?>"
            class="card-img rounded-0" alt="photo du groupe">
        <div class="card-img-overlay d-flex justify-content-end align-items-center flex-column">
            <h1 class="card-title" <?php if(!$group['is_valid']){echo 'style="color: black"';} ?>><?= $group['name'] ?>
            </h1>
            <?php if(!$group['is_valid']){echo '<p class="p-1" style="background-color: white">Le groupe est en attente de validation</p>';} ?>
        </div>
    </div>

    <nav class="d-flex" <?php if(!$group['is_valid']){echo 'style="background-color: lightgrey"';} ?>>
        <div class="mx-auto my-1">
            <a class="p-1" href="#">A propos</a>
        </div>
        <div class="mx-auto my-1">
            <a class="p-1" href="#">Evénements</a>
        </div>
        <div class="mx-auto my-1">
            <a class="p-1" href="#">Playlists</a>
        </div>
        <div class="mx-auto my-1">
            <a class="p-1" href="#">Membres</a>
        </div>
        <?php if(isset($group['is_admin']) && $group['is_admin']) : ?>
            <div class="mx-auto my-1">
                <!-- notifications pour l'admin du groupe -->    
                <a class="p-1 position-relative fs-5" href="<?= site_url('group/notification/').esc($group['slug'], 'url') ?>"><i class="bi bi-bell"></i></a>
                <!-- accès aux paramètres pour l'admin du groupe -->
                <a class="p-1 fs-5" href="<?= site_url('group/update/').esc($group['slug'], 'url') ?>"><i
                        class="bi bi-gear"></i></a>
            </div>
        <?php endif ?>
    </nav>
    <?php if(isset($_SESSION['logged']) && $_SESSION['logged']) : ?>
    <?php if(!$group['is_member'] && !isset($group['is_admin'])) : ?>
    <?php if(isset($success['groupRequest'])) : ?>
    <p class="m-2"><?= $success['groupRequest']?></p>
    <?php endif ?>
    <?php if(!$group['request'] || !isset($success['groupRequest'])) : ?>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-dark mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Rejoindre le groupe
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Envoyer une demande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="send_group_request" method="post">
                        <div class="mb-3">
                            <textarea name="message" class="form-control" id="exampleFormControlTextarea1"
                                rows="3"></textarea>
                        </div>
                        <button class="btn btn-outline-dark mt-3 ms-2" data-bs-dismiss="modal"
                            type="submit">Envoyer</button>
                        <button type="button" class="btn btn-outline-dark mt-3 ms-2"
                            data-bs-dismiss="modal">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php elseif($group['request'] || isset($success['groupRequest'])) : ?>
    <button type="button" class="btn btn-outline-dark mt-3 ms-2" disabled>
        Demande envoyée
    </button>
    <?php endif ?>
    <?php endif ?>
    <?php endif ?>

    <!-- TODO compléter pour dynamique : https://getbootstrap.com/docs/5.0/components/navs-tabs/#methods, et aussi gro/view/jam/view.php 'TABS AJAX' -->

</div>
<div id="j-group-main" class="p-2">
    