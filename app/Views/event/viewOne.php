<div class="m-2">
    <?php if(isset($group)) : ?>
        <h2><small>Le groupe </small> <?= $group['name'] ?></h2>
    <?php else : ?>
        <h2>Quelqu'un.e<h2>
    <?php endif ?>
        <h4>organise l'événement</h4>
    <h1><?= $event['name'] ?></h1>
    <h3><small>Description : </small><?= $event['description'] ?></h3>
    <?php if((isset($group['is_admin']) && $group['is_admin']) || (isset($event['is_admin']) && $event['is_admin'])) : ?>
        <a href="<?= site_url('event').'/'.esc($event['slug'], 'url').'/update' ?>" class="btn btn-outline-light mt-3 ms-2">
            Modifier l'événement
        </a>
        <a href="<?= site_url('event').'/'.esc($event['slug'], 'url').'/date/create' ?>" class="btn btn-outline-light mt-3 ms-2">
            Ajouter une date
        </a>
        <a href="<?= site_url('event').'/'.esc($event['slug'], 'url').'/members' ?>" class="btn btn-outline-light mt-3 ms-2">
            Voir les membres
        </a>
    <?php endif ?>
    <?php if(isset($event['is_member'])) : ?>
        <?php if($event['is_member'] && $event['is_admin']) : ?>
            <p>Vous participez à l'event, vous en êtes même l'admin !</p>
        <?php elseif($event['is_member'] && !$event['is_admin']) : ?>
            <p>Vous participez à l'event. Quelle chance !</p>
        <?php elseif(!$event['is_member'] && $event['is_admin']) : ?>
            <p>Vous ne participez pas à l'event mais vous l'administrez. ça va ?</p>
        <?php elseif(!$event['is_member'] && !$event['is_admin']) : ?>
            <p>Vous ne participez pas encore à l'event.</p>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-light mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                S'inscrire
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
        <?php endif ?>
    <?php else : ?>
        <button type="button" class="btn btn-outline-dark mt-3 ms-2" disabled>
            S'inscrire
        </button>
        <p>Pour vous inscrire à l'event, il faut d'abord a <a href="<?= site_url('login') ?>">vous connecter</a>. Si vous n'avez pas encore de compte,  <a href="<?= site_url('inscription') ?>">inscrivez-vous</a> !</p>
    <?php endif ?>

    <?php foreach($dates as $date) : ?>
        <div class="card mb-2" style="border: 3px red solid; color: blue; background-color: magenta;">
            <div class="card-body">
                <h5 class="card-title"><?= $date['name'] ?></h5>
                <p class="card-text"><?= $date['description'] ?></p>
                <p><?= $date['date_start'] ?></p>
                <p><?= $date['date_end'] ?></p>
                <a href="<?= site_url('event').'/'.esc($event['slug'], 'url').'/date/'.esc($date['slug'], 'url').'/update' ?>" class="card-link">Détails</a>
                <a href="<?= site_url('event').'/'.esc($event['slug'], 'url').'/date/'.esc($date['slug'], 'url').'/viewOne' ?>" class="card-link">Modifier</a>
            </div>
        </div>
    <?php endforeach ?>


</div>