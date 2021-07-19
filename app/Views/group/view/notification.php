<h2>Notifications du groupe <?= $group['name'] ?></h2>
<p>Vous avez <?= count($requests) ?> notifications en attente.</p>

<?php foreach ($requests as $request) : ?>
    <div class="card">
        <div class="card-header">
            <img src="<?php if(!empty($request['member']['picture'])){echo base_url('images/member/').'/'.$request['member']['picture'];}else{echo base_url('images/member/default-member-image.jpg');} ?>" alt="image de profil" class="rounded-circle j-img-profil-nav-phone m-1">
            <?= $request['member']['pseudo'] ?>
        </div>
        <div class="card-body">
            <?= $request['message'] ?>
            <?= $request['created_at'] ?>
        </div>
        <div class="card-footer">
        <a href="<?= site_url('group/notification/accept').'?0='.$request['group_id'].'&1='.$request['member_id'] ?>"  class="btn btn-outline-dark">Accepter dans le groupe</a>
        </div>
    </div>
<?php endforeach ?>
</div>