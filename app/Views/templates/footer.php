            </main>
        </div>
        <footer class="mt-auto footer">
            
            <!-- <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="<?php echo site_url('about'); ?>">A propos</a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="<?php echo site_url('mentions_legales'); ?>">Mentions Légales</a>
                </li>
            </ul> -->

            <div class="container pt-2 pb-2">
				<a href="<?php echo site_url('contact'); ?>">Contact</a> |
				<a href="<?php echo site_url('about'); ?>">A propos</a> |
				<a href="<?php echo site_url('mentions_legales'); ?>" data-bs-toggle="modal" data-bs-target="#show_mentions">Mentions Légales</a> |
				<small><span class="soften">&copy; 2014 - <?php echo date("Y"); ?></span></small>
            </div>
            
            <!-- TODO mettre une licence -->
        </footer>

        <!-- SCRIPTS JQUERY -->

	<!-- Modal mentions legales -->
	<div id="show_mentions" class="modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered default">
			<div class="modal-content">
				<div class="modal-header lead">Mentions légales</div>
				<div class="modal-body">
					<p>Les informations recueillies sont nécessaires pour votre adhésion.<br>
						Elles font l’objet d’un traitement informatique et sont destinées au secrétariat de l’association. En application des articles 39 et suivants de la loi du 6 janvier 1978 modifiée, vous bénéficiez d’un droit d’accès et de rectification aux informations qui vous concernent. Si vous souhaitez exercer ce droit et obtenir communication des informations vous concernant, veuillez nous adresser un message à l'adresse suivante : <a href="mailto:contact@le-gro.com"><b>contact@le-gro.com</b></a>.</p>
				</div>
			</div>
		</div>
	</div>



    </body>
</html>