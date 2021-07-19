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
		'description',
		'date_start',
		'date_end',
		'created_at',
		'updated_at'
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
        $group = $groupModel->getOneGroup($slug);

        $eventModel = new EventModel();
        $events = $eventModel->where('group_id', $group['id'])->findAll();

        return $events;
    }

    public function getOneEvent($eventId){
        $eventModel = new EventModel();
        $event = $eventModel->where('id', $eventId)->first();
        // TODO ajouter l'admin de l'event

        return $event;
    }
	
}
