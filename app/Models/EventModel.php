<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'events';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'group_id',
		'name',
		'slug',
		'description',
		'date_start',
		'date_end',
		'created_at',
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
	
	public function getGroupsEvents($slug){
        $groupModel = new GroupModel();
        $group = $groupModel->getOneGroupBySlug($slug);

        $eventModel = new EventModel();
        $events = $eventModel->where('group_id', $group['id'])->findAll();
		
		$eventsOk = [];
		foreach($events as $event){
			if($event['deleted_at'] === null){
				$eventsOk[] = $event;
			}
		}

        return $eventsOk;
    }

    /**
     * Fonction pour trouver un événement. Il faut au moins l'ID de l'event pour le trouver.
     * Si on ajoute en argument l'id du membre (membre connecté), la méthode ajoute des infos à l'event : est-ce que le membre est inscrit à cet event ? Est-ce que le membre est admin ?
     */
    public function getOneEventBySlug($eventSlug, $memberId = 0){
        $eventModel = new EventModel();
        $event = $eventModel->where('slug', $eventSlug)->first();

		if($event['deleted_at'] != null){
			return $eventOk = null;
		}

        // TODO ajouter l'admin de l'event

        if($memberId != 0){
            $eventRegistrationModel = new EventRegistrationModel();
            $eventRegistration = $eventRegistrationModel->where(['event_id' => $event['id'], 'member_id' => $memberId])->first();
            if(!empty($eventRegistration)){
                $event['is_member'] = true;
                if($eventRegistration['is_admin']){
                    $event['is_admin'] = true;
                } else {
                    $event['is_admin'] = false;
                }
            } else {
                $event['is_member'] = false;
                $event['is_admin'] = false;
            }
        }
        
        $eventOk = $event;

        return $eventOk;
    }
	
	public function getMyEvents($memberId){
		// méthode pour récupérer toutes les inscriptions à des événements d'un membre qui se connecte, de façon à les mettre dans la session lors de sa création
		$eventRegistrationModel = new EventRegistrationModel();
		// on va chercher toutes les relations entre le membre en session et des events
		$myEventsRegistration = $eventRegistrationModel->where('member_id', $memberId)->findAll();
		
		$myEventsList = array();
		
		// pour chaque relation group/event, on va chercher l'event et si le membre est son admin, on ajoute l'info à l'objet event
		foreach ($myEventsRegistration as $registration) {
			$eventModel = new EventModel();
			// on récupère l'objet event correspondant à la relation
			$event = $eventModel->find($registration['event_id']);
			if($event['deleted_at'] === null){
				// on vérifie si le member est admin
				if($registration['is_admin']){
					// le membre est admin de l'event, on le précise dans l'objet event
					$event['is_admin'] = true;
				} else {
					// le membre n'est pas admin du groupe, on le précise dans l'objet groupe
					$event['is_admin'] = false;
				}
				
				// on récupère le groupe correspondant
				$groupModel = new GroupModel();
				$group = $groupModel->getOneGroup($event['group_id']);
				$event['group'] = $group;

				// enfin on ajoute l'objet groupe dans la liste des groupes du membre
				$myEventsList[] = $event;
			}
		}
		return $myEventsList;
	}

}
