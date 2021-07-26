            </main>

        </div>	<!-- On ferme l'item flex !-->
		</div>	<!-- On ferme le j-container !-->
		
        <!--   <footer class="mt-auto footer">
            
          <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a class="nav-link" href="<?php echo site_url('contact'); ?>">Contact</a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="<?php echo site_url('about'); ?>">A propos</a>
                </li>
                <li class="list-group-item">
                    <a class="nav-link" href="<?php echo site_url('mentions_legales'); ?>">Mentions Légales</a>
                </li>
            </ul> 

            <div class="container pt-2 pb-2">
				<a href="<?php echo site_url('contact'); ?>">Contact</a> |
				<a href="<?php echo site_url('about'); ?>">A propos</a> |
				<a href="<?php echo site_url('mentions_legales'); ?>" data-bs-toggle="modal" data-bs-target="#show_mentions">Mentions Légales</a> |
				<small><span class="soften">&copy; 2014 - <?php echo date("Y"); ?></span></small>
            </div>
            
        </footer>-->

        <!-- SCRIPTS JQUERY -->


<!-- // ##################################################################### // -->
<!-- // ############################### MODAL ############################### // -->
<!-- // ##################################################################### // -->

	<!-- Box de connexion !-->
	<div id="modal_login" class="modal fade">
		<div class="modal-dialog default modal-sm modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Connexion</h5>
				</div>
				<div class="modal-body">
					
					<!-- Formulaire !-->
					<form method="post" action="javascript:login()" name="login_form">
					
						<!-- Nom ou Email!-->
						<div class="mb-3">
							<input id="input" type="input" class="form-control" required="true" name="input" placeholder="Pseudo ou Email">
						</div>
						
						<!-- Pass !-->
						<div class="mb-3">
							<input id="password" type="password" class="form-control" required="true" name="password" placeholder="Mot de passe">
						</div>
						
						<!-- Connexion !-->
						<div>
							<button type="submit" class="btn btn-primary form-control">Se connecter</button>
						</div>
						
					</form>
					
				</div>
				
				<!-- Mot de passe oublié !-->
				<div class="modal-footer p-2">
					<div class="text-center">
						<a href="javascript:forgotten_box()">Mot de passe oublié</a>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Box de mot de passe oublié !-->
	<div id="modal_forgotten" class="modal fade">
		<div class="modal-dialog default modal-sm modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Mot de passe oublié</h5>
				</div>
				<div class="modal-body">
					
					<!-- Formulaire !-->
					<form method="post" action="javascript:forgotten()" name="login_form">
					
						<!-- email !-->
						<div class="mb-3">
							<input id="email" type="email" class="form-control form-group" required="true" name="email" placeholder="Email">
						</div>

						<!-- Connexion !-->
						<div>
							<button type="submit" class="btn btn-primary form-control">Réinitialiser le mot de passe</button>
						</div>
						
					</form>
					
				</div>
			</div>
		</div>
	</div>


	<!-- Modal mentions legales -->
	<div id="show_mentions" class="modal fade">
		<div class="modal-dialog modal-dialog-centered default modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Mentions légales</h5>
				</div>
				<div class="modal-body">
					<p>Les informations recueillies sont nécessaires pour votre adhésion.<br>
						Elles font l’objet d’un traitement informatique et sont destinées au secrétariat de l’association. En application des articles 39 et suivants de la loi du 6 janvier 1978 modifiée, vous bénéficiez d’un droit d’accès et de rectification aux informations qui vous concernent. Si vous souhaitez exercer ce droit et obtenir communication des informations vous concernant, veuillez nous adresser un message à l'adresse suivante : <a href="mailto:contact@le-gro.com"><b>contact@le-gro.com</b></a>.</p>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Modal de message !-->
	<div id="modal_msg" class="modal fade" data-bs-backdrop="true" data-bs-focus="true" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered default">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"></h5>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer text-end"><button class="btn btn-primary" data-bs-dismiss="modal">Fermer</button></div>
			</div>
		</div>
	</div>
	
	
	<!-- Modal d'attente bloquante !-->
	<div id="modal_wait" class="modal fade" data-bs-keyboard="false" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered default">
			<div class="modal-content">
				<div class="modal-body">
					<p class="modal-title">Patientez...</p>
				</div>
			</div>
		</div>
	</div>



    </body>
</html>