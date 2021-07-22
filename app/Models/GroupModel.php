<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'groups';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'name',
		'slug',
		'description',
		'picture',
		'city',
		'is_valid',
		'updated_at',
		'deleted_at',
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
	
	
	public function adminGetGroups() {
		// on récupère tous les groupes qui ne sont pas validés
		$groups = $this->where('is_valid', 0)->findAll();
		// Pour chaque groupe on va récupérer la personne qui l'a créé
		$groupMember = new GroupMemberModel();
		$member = new MemberModel();

		foreach ($groups as $group) {
			if($group['deleted_at'] == null){
				$adminGroupMember = $groupMember->where('group_id', $group['id'])->findAll();
				// normalement on ne récupère qu'une ligne, parce qu'il n'y a pas eu la possibilités d'ajouter d'autres admin au groupe
				$adminGroupMember = $adminGroupMember[0];
				// log_message('debug', json_encode($adminGroupMember));
				$adminMember = $member->find($adminGroupMember['member_id']);
				$group['created_by'] = $adminMember['pseudo'];
				$invalidGroups[] = $group;
			}
		}
		return $invalidGroups;
	}

	// méthode pour récupérer tous les groupes d'un membre qui se connecte, de façon à les mettre dans la session lors de sa création
	public function getMyGroups($id) {
		$groupMemberModel = new GroupMemberModel();
		// on va chercher toutes les relations entre le membre en session et des groupes
		$myGroupsMember = $groupMemberModel->where('member_id', $id)->findAll();
		
		$myGroupsList = array();
		
		// pour chaque relation groupe/membre, on va chercher le groupe et si le membre est son admin, on ajoute l'info à l'objet group
		foreach ($myGroupsMember as $myGroupMember) {
			$group = new GroupModel();
			// on récupère l'objet groupe correspondant à la relation
			$myGroup = $group->find($myGroupMember['group_id']);

			// on vérifie que le groupe n'a pas été supprimé
			if($group['deleted_at'] == null){

				// on vérifie si le member est admin
				if($myGroupMember['is_admin']){
					// le membre est admin du groupe, on le précise dans l'objet groupe
					$myGroup['is_admin'] = true;
				} else {
					// le membre n'est pas admin du groupe, on le précise dans l'objet groupe
					$myGroup['is_admin'] = false;
				}

				// enfin on ajoute l'objet groupe dans la liste des groupes du membre
				$myGroupsList[] = $myGroup;
			}
		}
		return $myGroupsList;
	}

	// fonction pour afficher les groupes dans l'index des groupes
	// TODO faire un affichage avec des différences selon les paramètres de visibilité du groupe, et les liens que le membre peut avoir avec chaque groupe
	public function indexGroups($memberId = 0) {
		$groupModel = new GroupModel();
		// on récupère tous les groupes validés
		$groups = $groupModel->where('is_valid', 1)->findAll();
		
		$listGroups = [];
		
		// on garde seulement les groupes dont on ne fait pas partie
		$groupMemberModel = new GroupMemberModel();
		foreach($groups as $group) {
			// on vérifie que le groupe n'a pas été supprimé
			if($group['deleted_at'] == null){
				// on prend toutes les relations qui concernent ce groupe
				$groupMember = $groupMemberModel->where('group_id', $group['id'])->findAll();
				// on vérifie qu'aucune de ces relations ne concerne notre membre
				$isNotMyGroup = true;
				foreach($groupMember as $xGroup){
					if($xGroup['member_id'] == $memberId) {
						$isNotMyGroup = false;
					}
				}

				if ($isNotMyGroup == true){
					$listGroups[] = $group;
				}
			}
		}
		return $listGroups;
	}

	// méthode pour sélectionner un groupe grâce à son slug. Ajoute le lien ou l'absence de lien avec le membre connecté
	// TODO quand il y aura les autres infos (events, posts, playlists...) on pourra les récupérer ici ?
	public function getOneGroupBySlug($slug, $memberId = 0){
		$groupModel = new GroupModel();
		$group = $groupModel->where('slug', $slug)->first();
		if($group['deleted_at'] !== null){
			return $group = null;
		}
		// on vérifie si qqn est connecté
		if(isset($_SESSION['logged']) && $_SESSION['logged'] && $memberId > 0) {
			// un membre est connecté, on vérifie s'il est lié au groupe
			$groupMemberModel = new GroupMemberModel();
			// on cherche si une relation existe entre le groupe et le membre
			$relation = $groupMemberModel->where(['member_id' => $memberId, 'group_id' => $group['id']])->first();
			
			if (!empty($relation)){
				$group['is_member'] = true;
				if($relation['is_admin']){
					$group['is_admin'] = true;
				}	else {
					$group['is_admin'] = false;
				}
			} else {
				$group['is_member'] = false;
			}
		}
		return $group;
	}

	public function getOneGroup($groupId, $memberId = 0){
		$groupModel = new GroupModel();
		$group = $groupModel->first('group_id', $groupId);
		
		// on vérifie que le groupe n'a pas été supprimé
		if($group['deleted_at'] == null){
			return $group = null;
		}
		
		// on vérifie si qqn est connecté
		if(isset($_SESSION['logged']) && $_SESSION['logged'] && $memberId > 0) {
			// un membre est connecté, on vérifie s'il est lié au groupe
			$groupMemberModel = new GroupMemberModel();
			// on cherche si une relation existe entre le groupe et le membre
			$relation = $groupMemberModel->where(['member_id' => $memberId, 'group_id' => $group['id']])->first();
			
			if (!empty($relation)){
				$group['is_member'] = true;
				if($relation['is_admin']){
					$group['is_admin'] = true;
				}	else {
					$group['is_admin'] = false;
				}
			} else {
				$group['is_member'] = false;
			}
		}
		return $group;
	}
}
