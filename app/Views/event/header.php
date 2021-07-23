
<div id="j-event-header" style="border: 6px solid blue;">
    <div class="card rounded-0">
        <img src="<?php if(!empty($event['picture'])){echo base_url('images/event/').'/'.$event['picture'];}else{echo base_url('images/event/default-event-image.jpg');} ?>"
            class="card-img rounded-0" alt="photo du evente">
        <div class="card-img-overlay d-flex justify-content-end align-items-center flex-column">
            <a href="<?= site_url('event/').esc($event['slug'], 'url') ?>"><h1 class="card-title"><?= $event['name'] ?>
            </h1></a>

        </div>
    </div>

    <nav class="d-flex">
        <div class="mx-auto my-1">
            <a class="p-1" href="<?= site_url('event').'/'.esc($event['slug']) ?>">A propos</a>
        </div>
        <div class="mx-auto my-1">
            <a class="p-1" href="<?= site_url('event/'.$event['slug']) ?>">Dates</a>
        </div>
        <div class="mx-auto my-1">
            <a class="p-1" href="#">Playlists</a>
        </div>
        <div class="mx-auto my-1">
            <a class="p-1" href="<?= site_url('event/').esc($event['slug'], 'url').'/members' ?>">Membres</a>
        </div>
        <?php if(isset($event['is_admin']) && $event['is_admin']) : ?>
            <div class="mx-auto my-1">
                <!-- notifications pour l'admin du evente -->    
                <a class="p-1 position-relative fs-5" href="<?= site_url('event/').esc($event['slug'], 'url').'/notification' ?>"><i class="bi bi-bell"></i></a>
                <!-- accès aux paramètres pour l'admin du evente -->
                <a class="p-1 fs-5" href="<?= site_url('event/').esc($event['slug'], 'url').'/update' ?>"><i
                        class="bi bi-gear"></i></a>
            </div>
        <?php endif ?>
    </nav>
    <?php if(isset($_SESSION['logged']) && $_SESSION['logged']) : ?>
        <?php if(!$event['is_member'] && !isset($event['is_admin'])) : ?>
            <?php if(isset($success['eventRequest'])) : ?>
                <p class="m-2"><?= $success['eventRequest']?></p>
            <?php endif ?>
            <?php if(!$event['request'] || !isset($success['eventRequest'])) : ?>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-dark mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Rejoindre le evente
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
                                <form id="send_event_request" method="post">
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
            <?php elseif($event['request'] || isset($success['eventRequest'])) : ?>
                <button type="button" class="btn btn-outline-dark mt-3 ms-2" disabled>
                    Demande envoyée
                </button>
            <?php endif ?>
        <?php endif ?>
    <?php endif ?>

    <!-- TODO compléter pour dynamique : https://getbootstrap.com/docs/5.0/components/navs-tabs/#methods, et aussi gro/view/jam/view.php 'TABS AJAX' -->

</div>
<div id="j-event-main" class="p-2">
    