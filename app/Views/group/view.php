<div id="j-group-header">
    <div class="card rounded-0">
        <img src="<?php echo base_url('images/chatons-groupe.jpg'); ?>" class="card-img rounded-0"
            alt="photo du groupe">
        <div class="card-img-overlay d-flex justify-content-end align-items-center flex-column">
            <h1 class="card-title" <?php if(!$group['is_valid']){echo 'style="color: black"';} ?>><?= $group['name'] ?></h1>
            <?php if(!$group['is_valid']){echo '<p class="p-1" style="background-color: white">Le group est en attente de validation</p>';} ?>
        </div>
    </div>

    <nav class="d-flex"  <?php if(!$group['is_valid']){echo 'style="background-color: lightgrey"';} ?>>
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
        <?php if($group['is_admin']) : ?>
            <div class="mx-auto my-1">
                <a class="p-1" href="#"><i class="bi bi-gear"></i></a>
            </div>
        <?php endif ?>
    </nav>
    <!-- TODO compléter pour dynamique : https://getbootstrap.com/docs/5.0/components/navs-tabs/#methods, et aussi gro/view/jam/view.php 'TABS AJAX' -->
    <?php dd($group); ?>
</div>
<div id="j-group-main" class="p-2">
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt animi amet temporibus sed repellendus necessitatibus facere et, aperiam ex iusto enim possimus voluptate ipsam non dignissimos voluptatem quos quo labore!</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt animi amet temporibus sed repellendus necessitatibus facere et, aperiam ex iusto enim possimus voluptate ipsam non dignissimos voluptatem quos quo labore!</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt animi amet temporibus sed repellendus necessitatibus facere et, aperiam ex iusto enim possimus voluptate ipsam non dignissimos voluptatem quos quo labore!</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt animi amet temporibus sed repellendus necessitatibus facere et, aperiam ex iusto enim possimus voluptate ipsam non dignissimos voluptatem quos quo labore!</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt animi amet temporibus sed repellendus necessitatibus facere et, aperiam ex iusto enim possimus voluptate ipsam non dignissimos voluptatem quos quo labore!</p>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt animi amet temporibus sed repellendus necessitatibus facere et, aperiam ex iusto enim possimus voluptate ipsam non dignissimos voluptatem quos quo labore!</p>
</div>
