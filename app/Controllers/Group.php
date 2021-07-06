<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Controllers\BaseController;
use App\Models\GroupMemberModel;

class Group extends BaseController
{
	// page pour voir tous les groupes existants, les chercher (selon visibilité, accès possible ou pas)
	public function index() {
		echo view('templates/header');
		echo view('group/index');
		echo view('templates/footer');
	}

	// page pour voir UN groupe
	public function view() {
		echo view('templates/header');
		echo view('group/view');
		echo view('templates/footer');
	}

	// page pour créer un groupe
	public function create() {
		if(count($_POST) > 0) {
			if(!$this->validate([
				'name' => 'required|is_unique[groups.name]',
				'description' => 'required',
			])){
				if(!empty($_POST['name'])){$data['name'] = trim($_POST['name']);}
				if(!empty($_POST['description'])){$data['description'] = trim($_POST['description']);}
				if(!empty($_POST['city'])){$data['city'] = trim($_POST['city']);}
				$errors = $this->validator->getErrors();
				$data['errors'] = $errors;
				echo view('templates/header');
				echo view('group/create', $data);
				echo view('templates/footer');
				return;
			} else {
				// les vérifications sont faites, on enregistre le groupe
				$data['name'] = trim($_POST['name']);
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

	// page pour modifier un groupe
	public function update() {

	}
}
