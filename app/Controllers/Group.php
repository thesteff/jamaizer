<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Controllers\BaseController;
use App\Models\GroupMemberModel;

class Group extends BaseController
{
// ##################################################################### //
//  page pour voir tous les groupes existants, les chercher (selon visibilité, accès possible ou pas)  //
// ##################################################################### //
	public function index() {

		$groupModel = new GroupModel();
		if(isset($_SESSION['member']['id'])) {
			$memberId = $_SESSION['member']['id'];
		} else {
			$memberId = 0;
		}
		$groups = $groupModel->indexGroups($memberId);
		$data['groups'] = $groups;

		echo view('templates/header');
		echo view('group/index', $data);
		echo view('templates/footer');
	}

// ##################################################################### //
// ###################### page pour voir UN groupe ##################### //
// ##################################################################### //
	public function view($slug) {

		if(isset($_SESSION['logged']) && $_SESSION['logged']){
			$memberId = $_SESSION['member']['id'];
		} else {
			$memberId = 0;
		}

		$groupModel = new GroupModel();
		$group = $groupModel->getOneGroup($slug, $memberId);

		$data['group'] = $group;
		echo view('templates/header');
		echo view('group/view', $data);
		echo view('templates/footer');
	}

// ##################################################################### //
// ##################### page pour créer un groupe ##################### //
// ##################################################################### //
	public function create() {
		if(count($_POST) > 0) {

			// il y a des données dans $_POST. Si le slug n'est pas généré, on le crée et on le place dans une variable
			if((!isset($_POST['slug']) || empty($_POST['slug'])) && !empty($_POST['name'])){
				$slug  = url_title($this->request->getPost('name'), '-', TRUE);
				// $_POST['slug'] = $slug;
				// dd($_POST);
			} elseif(isset($_POST['slug']) && !empty($_POST['slug'])) {
				$slug = trim($_POST['slug']);
			} else {
				$slug = null;
			}
			$_POST['slug'] = $slug;
			// dd($_POST);
			// maintenant il y a forcément un slug dans $slug

			// les données du formulaire sont-elles valides ?
			if(!$this->validate([
				'name' => 'required|is_unique[groups.name]',
				'slug' => 'is_unique[groups.slug]',
				'description' => 'required',
			])){
				// il y a des erreurs dans les données. Avant de réafficher le formulaire, on prépare l'hydratation en envoyant les données déjà rentrées
				if(!empty($_POST['name'])){$data['name'] = trim($_POST['name']);}
				if(!empty($_POST['description'])){$data['description'] = trim($_POST['description']);}
				if(!empty($_POST['city'])){$data['city'] = trim($_POST['city']);}
				// on récupère les messages d'erreur automatiques afin de les afficher
				$errors = $this->validator->getErrors();
				$data['errors'] = $errors;
				// on affiche à nouveau le formulaire
				echo view('templates/header');
				echo view('group/create', $data);
				echo view('templates/footer');
				return;
			} else {
				// les vérifications sont faites, on enregistre le groupe
				$data['name'] = trim($_POST['name']);
				$data['slug'] = $slug;
				$data['description'] = trim($_POST['description']);
				// si une ville est renseignée, on l'ajoute
				if(!empty($_POST['city'])){$data['city'] = trim($_POST['city']);}
				// à la création le groupe n'est pas encore validé
				$data['is_valid'] = false;
				$group = new GroupModel;
				$group->insert($data);

				// on relie le groupe au membre qui l'a créé en le mettant admin du groupe
				$group = $group->where('name', trim($_POST['name']))->findAll();
				// dd($group[0]);
				if(count($group) > 1) {
					$data['errors'] = 'Il y a eu un souci. Veuillez réessayer et si le problème persiste contactez le service technique.';
					echo view('templates/header');
					echo view('group/create', $data);
					echo view('templates/footer');
					return;
				} else {
					$groupId = $group[0]['id'];
				}
				$groupMember = new GroupMemberModel();
				$data = array(
					'group_id' => $groupId,
					'member_id' => $_SESSION['member']['id'],
					'is_group_ok' => true,
					'is_member_ok' => true,
					'is_admin' => true
				);
				$groupMember->insert($data);

			}
		}
		echo view('templates/header');
		echo view('group/create');
		echo view('templates/footer');
	}

// ##################################################################### //
// #################### page pour modifier un groupe ################### //
// ##################################################################### //
	public function update($slug) {

		if(isset($_SESSION['logged']) && $_SESSION['logged']){
			$memberId = $_SESSION['member']['id'];
		} else {
			return redirect('group');
		}

		$groupModel = new GroupModel();
		$group = $groupModel->getOneGroup($slug, $memberId);
		$data = $group;

		if(count($_POST) > 0) {

			// les données du formulaire sont-elles valides ?
			if(isset($_POST['name']) && $_POST['name'] !== $group['name']){
				$errors[] = 'Vous ne pouvez pas modifier le nom du groupe.';
				$data['errors'] = $errors;
				if(!empty($_POST['description'])){$data['description'] = trim($_POST['description']);}
				if(!empty($_POST['city'])){$data['city'] = trim($_POST['city']);}
				// on affiche à nouveau le formulaire
				echo view('templates/header');
				echo view('group/update', $data);
				echo view('templates/footer');
				return;
			} else {
				// les vérifications sont faites, on enregistre le groupe
				$data['description'] = trim($_POST['description']);
				// si une ville est renseignée, on l'ajoute
				if(!empty($_POST['city'])){$data['city'] = trim($_POST['city']);}
				$groupUpdate = $groupModel->update($group['id'], $data);
				// return redirect('group/view');
			}
		}

		echo view('templates/header');
		echo view('group/update', $data);
		echo view('templates/footer');
	}
}
