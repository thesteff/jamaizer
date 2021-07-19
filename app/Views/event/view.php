<?php if(isset($group['is_admin']) && $group['is_admin']) : ?>
    <a href="<?= site_url('group/'.$group['slug'].'/event/create') ?>" type="button" class="btn btn-outline-dark mt-3 ms-2">
        Créer un événement
    </a>
<?php endif ?>

<?php if(isset($event) && !empty($events)) : ?>
    Tous les événements
<?php endif ?>

<?php foreach ($events as $event): ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="card-body">
                <h5 class="card-title"><?= $event['name']?></h5>
                <p class="card-text"><?= $event['description']?></p>
                <p class="card-text"><small class="text-muted"><?= $event['date_start']?> - <?= $event['date_end']?></small></p>
            </div>
            <div class="card-footer">
                <?php if(isset($group['is_admin']) && $group['is_admin']) : ?>
                    <a href="<?= site_url('group/'.$group['slug'].'/event/'.$event['id'].'/update') ?>" type="button" class="btn btn-outline-dark mt-3 ms-2">
                        Modifier l'événement
                    </a>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php endforeach ?>
