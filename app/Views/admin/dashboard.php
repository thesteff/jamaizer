<h1>Dashboard Super Admin</h1>
<div class="d-flex justify-content-around flex-wrap">
    <?php foreach ($groups as $group) : ?>
        <div class="card p-2 m-1" style="flex: 1 1 300px">
            <img src="<?php if(!empty($group['picture'])){echo base_url('images/group/').'/'.$group['picture'];}else{echo base_url('images/group/default-group-image.jpg');} ?>" class="card-img-top" alt="photo du groupe">
            <div class="card-body">
                <h5 class="card-title"><?= $group['name'] ?></h5>
                <p class="card-text"><?= $group['description'] ?></p>
                <p class="card-text"></p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Ville principale : <?= $group['city'] ?></li>
                <li class="list-group-item">Style musical : truc</li>
                <li class="list-group-item">Nombre de personnes : truc</li>
                <li class="list-group-item">Date de création : <?= $group['created_at'] ?></li>
                <li class="list-group-item">Créé par : <?= $group['created_by'] ?></li>
                
            </ul>
            <div class="card-body">
                <a href="<?= site_url('admin/group/').esc($group['id'], 'url') ?>"  class="btn btn-outline-dark">Autoriser</a>
                <!-- <a href="#"  class="btn btn-outline-dark">Interdire</a> -->
            </div>
        </div>
    <?php endforeach ?>
</div>