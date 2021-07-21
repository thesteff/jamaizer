<?php

namespace App\Models;

use CodeIgniter\Model;

class EventRegistrationModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'event_registration';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'event_id',
		'member_id',
		'is_admin',
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
	
	public function getEventRegistrations($eventId){
		$eventRegistrationModel = new EventRegistrationModel();
		$registrations = $eventRegistrationModel->where('event_id', $eventId)->findALl();
		$registrationsOk = [];
		// on récupère maintenant le membre qui correspond à chaque inscription
		$memberModel = new MemberModel();
		foreach ($registrations as $registration) {
			$member = $memberModel->getOneMember($registration['member_id']);
			// $registration['member_pseudo'] = $member['pseudo'];
			// $registration['member_picture'] = $member['picture'];
			$registration['member'] = $member;
			$registrationsOk[] = $registration;
		}

		return $registrationsOk;
	}
}
