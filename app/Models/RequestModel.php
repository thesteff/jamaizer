<?php

namespace App\Models;

use CodeIgniter\Model;

class RequestModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'request';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'message',
		'member_id',
		'sent_by_member',
		'group_id',
		'event_id',
		'date_id',
        'admin_id'
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
	
	public function getOneGroupRequest($groupId, $memberId){
        $requestModel = new RequestModel();
        $request = $requestModel->where(['group_id' => $groupId, 'member_id' => $memberId])->first();
        return $request;
    }

    public function getGroupRequests($groupId){
        $requestModel = new RequestModel();
        // on récupère toutes les requêtes du groupe
        // TODO pour l'instant on n'a qu'un critère puisqu'on n'a qu'une sorte de requête : d'un membre à un groupe. donc il faudra rajouter plein de paramètres !
        $requests = $requestModel->where(['group_id' => $groupId])->findAll();
        // on récupère maintenant le membre qui correspond à chaque requête
        $memberModel = new MemberModel();
        foreach ($requests as $request) {
			$member = $memberModel->getOneMember($request['member_id']);
			// $request['member_pseudo'] = $member['pseudo'];
			// $request['member_picture'] = $member['picture'];
			$request['member'] = $member;
			$requestsOk[] = $request;
        }

        return $requestsOk;
    }
    
    public function setGroupRequest($groupId, $message, $memberId){
        $newRequest = new RequestModel();
        
        $requestExists = $newRequest->getOneGroupRequest($groupId, $memberId);
        if(empty($requestExists)){
            $data = array(
                'message' => $message,
                'member_id' => $memberId,
                'sent_by_member' => true,
                'group_id' => $groupId,
                'event_id' => null,
                'date_id' => null,
                'admin_id' => null
            );
            $newRequest->insert($data);
        }
    }
}