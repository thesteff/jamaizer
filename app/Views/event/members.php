<div class="m-2">
    <?php if(isset($group['is_admin']) && $group['is_admin']) : ?>    
        <h2>Vous avez <?= count($eventRequests) ?> demande<?php if(count($eventRequests) > 1){echo('s');} ?> d'inscription</h2>
        <?php foreach($eventRequests as $request) : ?>
        <div class="card">
            <div class="card-header">
                <img src="<?php if(!empty($request['member']['picture'])){echo base_url('images/member/').'/'.$request['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-profil-nav-phone m-1">
                <p><?= $request['member']['pseudo'] ?></p>
            </div>
            <div class="card-body">
                <p><?= $request['message'] ?></p>
                <p><?= $request['created_at'] ?></p>
            </div>
            <div class="card-footer">
            <a href="<?= site_url('group/').esc($group['slug'], 'url').'/event/'.esc($event['slug'], 'url').'/members/accept/'.$request['member_id'] ?>"  class="btn btn-outline-dark">Accepter dans le groupe</a>
            </div>
        </div>
        <?php endforeach ?>
    <?php endif ?>
    <?php foreach($eventRegistrations as $registration) : ?>
        <div class="card">
            <div class="card-body">
            <img src="<?php if(!empty($registration['member']['picture'])){echo base_url('images/member/').'/'.$registration['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-profil-nav-phone m-1">
            <?= $registration['member']['pseudo'] ?>
            </div>
        </div>
    <?php endforeach ?>
</div>