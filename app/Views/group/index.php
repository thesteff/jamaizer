<h1>Trouver un groupe</h1>
<form class="m-1" action="">
    <div class="row">
        <div class="col-10">
            <input class="form-control" type="text" placeholder="Chercher un groupe sur Jamaïzer">
        </div>
        <div class="col-2">
            <button id="searche-group" class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </div>
</form>
<div class="row mx-1">
    <div class="col-3">
        <h5>Filtrer</h5>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus, alias ex sint rem magni odit blanditiis
            porro non soluta modi aliquam quo atque perferendis vel quos in earum amet ipsum?</p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Default checkbox
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
            <label class="form-check-label" for="flexCheckChecked">
                Checked checkbox
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Default radio
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                Default checked radio
            </label>
        </div>
    </div>
    <div class="col-9">
        <?php for ($i=0; $i < 5; $i++): ?>
            <a href="<?= site_url('group/view'); ?>">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo base_url('images/chatons-groupe.jpg'); ?>" class="img-fluid rounded-start" alt="..." style="height: 100%">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Groupe des chatons</h5>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                    additional content. This content is a little bit longer.</p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endfor ?>
    </div>
</div>