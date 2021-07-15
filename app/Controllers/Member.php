<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\MemberModel;
// use App\Config\Validation;

class Member extends BaseController
{
	public function index()
	{
		//
	}

// ##################################################################### //
// ###################### SECTION PAGE INSCRIPTION ##################### //
// ##################################################################### //
	public function create() {

		// Si l'array $_POST n'est pas vide (> 0), on entre dans le if
		if(count($_POST) > 0) {
			// on vérifie si les données sont valides d'après nos critères. 
			// si c'est validé, on entre dans le if
			if($this->validate([
				'pseudo'     => 'required|is_unique[member.pseudo]|max_length[50]',
				'email'        => 'required|is_unique[member.email]|valid_email|max_length[100]',
				'password'     => 'required|max_length[100]',
				'pass_confirm' => 'required|matches[password]',
				'name' => 'max_length[50]',
				'first_name' => 'max_length[50]',
				// 'picture' => 'max_size[picture,1024]',
				'gender' => 'in_list[0,1,2,3]',
				'birth' => 'valid_date',
				'phone' => 'max_length[20]',
			]))
			{
				// les données sont valides, on passe à l'enregistrement
				
				// On récupère les infos dans $_POST, on enlève les espaces qui débordent et on range pseudo et email dans des variables simples
				$pseudo = trim($_POST['pseudo']);
				$email = trim($_POST['email']);
				$name = trim($_POST['name']);
				$first_name = trim($_POST['first_name']);
				$phone = trim($_POST['phone']);
				
				
				// image
				// dd($_FILES);
				if(!empty($_FILES['picture']['name'])){
					// dd('not empty');
					$file = $this->request->getFile('picture');
					$newPictureName = $file->getRandomName();
					if(!$file->guessExtension()){
						$errors[] = 'Le format du fichier téléchargé est invalide.';
						return;
					} else {
						$picture = $newPictureName;
						$file = $file->move(FCPATH.'images/member', $picture);
					}
				} else {
					$picture = "";
					// dd('empty');

				}
				
				// on hash le password
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				
				// on met toutes les infos dans $data
				$data = array(
					'pseudo' => $pseudo,
					'email' => $email,
					'password' => $password,
					'password' => $password,
					'name' => $name,
					'first_name' => $first_name,
					'gender' => $_POST['gender'],
					'birth' => $_POST['birth'],
					'picture' => $picture,
					'phone' => $phone,
				);
				// TODO enregistrement de l'image + enregistrement de "is_super_admin" = 0
				// dd($data);
				// on crée un objet membre
				$member = new MemberModel;
				
				// on met les données $data dans le nouvel objet $member -> on l'insère dans la BDD
				$member->insert($data);
		
				// on crée un message de succès pour confirmer l'inscription
				$inscriptionSuccess = "Votre inscription a bien été effectuée ! Vous pouvez à présent vous connecter à Jamaïzer !";
				$data = [];
				$data['inscriptionSuccess'] = [$inscriptionSuccess];
				$data['pseudo'] = $pseudo;
				// TODO on redirige vers la page de connexion, avec le message de succès et le pseudo pour préremplir le formulaire de connexion
				return redirect('member/connexion', $data);
			} 
			else 
			{
				// si au moins une donnée n'est pas validée, on réaffiche le formulaire sans entrer le membre dans la BDD, et on préremplis les données qui ont déjà été renseignées
				// TODO on affiche aussi les messages d'erreur pour expliquer pourquoi les données n'ont pas été validées
				$data = array(
					'pseudo' => $_POST['pseudo'],
					'is_super_admin' => 0,
					'email' => $_POST['email'],
					'name' => $_POST['name'],
					'first_name' => $_POST['first_name'],
					'gender' => $_POST['gender'],
					'birth' => $_POST['birth'],
					'phone' => $_POST['phone'],
				);
				$errors = $this->validator->getErrors();
				$data['errors'] = $errors;
				// dd($data);
				echo view('templates/header');
				echo view('member/create', $data);
				echo view('templates/footer');
			}
		
		// si $_POST est vide (<0), on affiche simplement la page d'inscription sans données supplémentaires
		} else {
			echo view('templates/header');
			echo view('member/create');
			echo view('templates/footer');
		}
	}

// ##################################################################### //
// ######################## SECTION PAGE UPDATE ######################## //
// ##################################################################### //
	public function update() {
		$errors = array();

		// petite sécurité : s'il n'y a pas de membre en session ou que 'logged' dans la session est false, on redirige vers la page d'accueil
		if(!isset($_SESSION['member']['id']) || !$_SESSION['logged']){
			return redirect('');
		}

		if(count($_POST) > 0) {
			// On vérifie que le pseudo n'a pas été modifié
			if(isset($_POST['pseudo'])){
				if($_POST['pseudo'] !== $_SESSION['member']['pseudo']){
					$errors[] = "Vous ne pouvez pas modifier votre pseudo !";
				}
			}
			// On vérifie que l'email n'a pas été modifié
			if(isset($_POST['email'])){
				if($_POST['email'] !== $_SESSION['member']['email']){
					$errors[] = "Vous ne pouvez pas modifier votre email !";
				}
			}
			// On vérifie si member a rentré qqch dans un champ de mot de passe pour le modifier
			if(!empty($_POST['password']) || !empty($_POST['new_password']) || !empty($_POST['new_pass_confirm'])) {
				// au moins un des trois champs de mot de passe est remplis, on vérifie que les trois sont bien remplis
				if(!empty($_POST['password']) && !empty($_POST['new_password']) && !empty($_POST['new_pass_confirm'])) {
					// les trois champs de mot de passe sont bien remplis
					if(!password_verify($_POST['password'], $_SESSION['member']['password'])){
						// le mot de passe donné ne correspond pas à l'ancien => erreur !
						$errors[] = 'L\'ancien mot de passe que vous avez mis ne correspond pas.';
					} else {
						// l'ancien mot de passe est bien renseigné, on peut à présent vérifier le nouveau
						if($this->validate(['new_pass_confirm' => 'matches[new_password]'])){
							// on hash le nouveau password
							$newpassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
							$data['password'] = $newpassword; 
						} else {
							// le nouveau mdp ne correspond pas à la confirmation
							$errors[] = 'Le nouveau mot de passe ne correspond pas à la confirmation.';
						}		
					}
				} else {
					// un ou deux champs de mot de passe ne sont pas remplis => erreur !
					$errors[] = 'Pour modifier votre mot de passe veuillez remplir les 3 champs concernés.';
				}
			}

			

			// on vérifie maintenant s'il y a d'autres infos et si celles-ci ont été modifiées
			// TODO y a-t-il ici des champs dont il faut vérifier les erreurs ?

			// pour le nom
			if(!empty(trim($_POST['name']))){
				// le champ nom a été remplis
				if(empty($_SESSION['member']['name'])) {
					// il n'y avait pas encore de nom dans la BDD
					$newname = trim($_POST['name']);
					$data['name'] = $newname;
				} elseif(trim($_POST['name']) !== $_SESSION['member']['name']) {
					// il y avait déjà un nom dans la BDD mais celui-ci est différent
					$newname = trim($_POST['name']);
					$data['name'] = $newname;
				}
				// s'il y avait déjà un nom dans la BDD et que celui-ci est identique, on ne fait rien
			}

			// pour le prénom (mêmes vérifs que pour le nom)
			if(!empty(trim($_POST['first_name']))){
				if(empty($_SESSION['member']['first_name'])) {
					$newfirstname = trim($_POST['first_name']);
					$data['first_name'] = $newfirstname;
				} elseif(trim($_POST['first_name']) !== $_SESSION['member']['first_name']) {
					$newfirstname = trim($_POST['first_name']);
					$data['first_name'] = $newfirstname;
				}
			}

			// pour la date de naissance
			if(!empty($_POST['birth'])){
				if((empty($_SESSION['member']['birth']) || $_POST['birth'] !== $_SESSION['member']['birth']) && $this->validate(['birth' => 'valid_date'])) {
					$newbirth = $_POST['birth'];
					$data['birth'] = $newbirth;
				}
			}

			// pour le genre (mêmes vérifs que pour le nom)
			if(!empty(trim($_POST['gender']))){
				if(empty($_SESSION['member']['gender'])) {
					$newgender = trim($_POST['gender']);
					$data['gender'] = $newgender;
				} elseif(trim($_POST['gender']) !== $_SESSION['member']['gender']) {
					$newgender = trim($_POST['gender']);
					$data['gender'] = $newgender;
				}
			}

			// pour le téléphone (mêmes vérifs que pour le nom)
			if(!empty(trim($_POST['phone']))){
				if(empty($_SESSION['member']['phone']) || trim($_POST['phone']) !== $_SESSION['member']['phone']) {
					$newphone = trim($_POST['phone']);
					$data['phone'] = $newphone;
				}
			}

			// pour l'image
			if(!empty($_FILES['picture']['name'])){
				$file = $this->request->getFile('picture');
				$newPictureName = $file->getRandomName();
				if(!$file->guessExtension()){
					$errors[] = 'Le format du fichier téléchargé est invalide.';
				} else {
					$picture = $newPictureName;
					$data['picture'] = $picture;
					$file = $file->move(FCPATH.'images/member', $picture);
				}	
			}
			

			if(count($errors) > 0) {
				// il y a eu des erreurs, on n'enregitre pas et on réaffiche le formulaire préremplis
				$data['errors'] = $errors;
				echo view('templates/header');
				echo view('member/update', $data);
				echo view('templates/footer');
				return;

			} elseif(isset($data)) {
				$memberModel = new MemberModel();
				// on met à jour les données du membre connecté dans la BDD
				$memberModel->update($_SESSION['member']['id'], $data);
				// on met à jour la session avec les nouvelles données
				$memberUpdate = $memberModel->find($_SESSION['member']['id']);
				$session = session();
				// $session->destroy();
				$data['member'] = $memberUpdate;
				$session->set($data);
	
			}
		}
		echo view('templates/header');
		echo view('member/update');
		echo view('templates/footer');
	}

// ##################################################################### //
// ####################### SECTION PAGE CONNEXION ###################### //
// ##################################################################### //
	public function login() {
		
		// on vérifie si des données sont déjà envoyées dans $_POST
		if (count($_POST) > 0) {
		
			// il y a des données dans $_POST, on vérifie si les deux champs sont remplis.
			if($this->validate([
				'input'     => 'required',
				'password'  => 'required',
			]))
			{
				// les champs ont été remplis, on vérifie maintenant si l'input "input" correspond à un mail ou à un pseudo dans la BDD
				$input = trim($_POST['input']);


				if($this->validate(['input'=>'is_unique[member.pseudo]']) && $this->validate(['input'=>'is_unique[member.pseudo]']))
				{
					// l'input ne correspond à rien ni parmi les pseudo, ni parmi les emails ! il y a donc une erreur. 
					// retour au formulaire avec un message d'erreur
					$error = "Le pseudo, l'email ou le mot de passe est invalide, veuillez à nouveau écrire vos identifiants.";
					$data['error'] = $error;
					echo view('templates/header');
					echo view('member/login', $data);
					echo view('templates/footer');
					return;
				} 
				$this->validator->reset();
				
				if($this->validate(['input' => 'is_not_unique[member.pseudo]'])){
					$pseudo = $input;
					// l'input existe bien dans les pseudo !
					$member = new MemberModel();
					$member = $member->where('pseudo', $pseudo)->findAll();
				}
				$this->validator->reset();

				// TODO l'email ne marche pas pour se connecter. POURQUOI???
				if($this->validate(['input' => 'is_not_unique[member.email]'])){
					$email = $input;
					// l'input existe bien dans les email !
					$member = new MemberModel();
					$member = $member->where('email', $email)->findAll();

				}
				// normalement on ne récupère qu'un membre. Si ce n'est pas le cas, on renvoie un message d'erreur.

				// on a bien récupéré notre membre, soit par son pseudo soit par son email

				// on vérifie quand même qu'on a bien récupéré un membre, ni plus ni moins.
				if(count($member) != 1){
					$error = "Il y a eu une erreur. Veuillez réessayer. Si le problème persiste, prenez contact avec l'équipe technique. Merci de votre compréhension.";
					$data['error'] = $error;
					echo view('templates/header');
					echo view('member/login', $data);
					echo view('templates/footer');
					return;
				}

				$member = $member[0];
				// à ce stade-là notre membre est trouvé, on vérifie que son mot de passe est le bon.
				$password = $_POST['password'];
				// dd($member);
				$hash = $member['password'];
				if(!password_verify($password, $hash)){
					// le mot de passe n'est pas valide, il ne correspond ni au pseudo ni au mail
					// on affiche un message d'erreur. Pour raison de sécurité, on ne précise pas d'où vient l'erreur.
					$error = "Le pseudo, l'email ou le mot de passe est invalide, veuillez à nouveau écrire vos identifiants.";
					$data['error'] = $error;
					echo view('templates/header');
					echo view('member/login', $data);
					echo view('templates/footer');
					return;
				} elseif(password_verify($password, $hash)){
					// c'est gagné ! le mot de passe est le bon, connexion réussie ! il ne reste plus qu'à créer la session
					
					// ~~~~ ANCHOR CREATION DE LA SESSION ~~~~ //
					// On fixe les variables de sessions
					$data['logged'] = true;
					$data['member'] = $member;

					// on récupère les groupes du membre
					$groups = new GroupModel();
					$myGroups = $groups->getMyGroups($member['id']);
					$data['myGroups'] = $myGroups;

					// initialisation de la session (est-ce que c'est nécessaire?)
					$session = session();

					$session->set($data);
					// dd($_SESSION);
					return redirect('member/profil');

				}

			} else {
				$error = "Veuillez remplir les deux champs avant de valider le formulaire.";
				$data['error'] = $error;
				echo view('templates/header');
				echo view('member/login', $data);
				echo view('templates/footer');
				return;
			}
		} 
		echo view('templates/header');
		echo view('member/login');
		echo view('templates/footer');
		return;
	}

// ##################################################################### //
// ###################### SECTION PAGE DECONNEXION ##################### //
// ##################################################################### //
	public function logout(){
		$session = session();

		$session->destroy();

		$data['logged'] = false;
		$session->set($data);

		return redirect('member/connexion');
	}

// ##################################################################### //
// ######################## SECTION PAGE PROFIL ######################## //
// ##################################################################### //
	public function view() {
		
		echo view('templates/header');
		echo view('member/view');
		echo view('templates/footer');
	}
}
