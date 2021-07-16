<h2>Notifications du groupe <?= $group['name'] ?></h2>
<p>Vous avez <?= count($requests) ?> notifications en attente.</p>
<?php dd($requests); ?>
<?php foreach ($requests as $request) : ?>
    <div class="card">
        <div class="card-header">
            <?= $request['member']['pseudo'] ?>
        </div>
        <div class="card-body">
            <?= $request['message'] ?>
        </div>
        <div class="card-footer">
            <?= $request['created_at'] ?>
        </div>
    </div>
<?php endforeach ?>
</div>