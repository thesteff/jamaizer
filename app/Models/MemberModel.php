<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'member';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		'pseudo',
		'name',
		'first_name',
		'email',
		'birth',
		'gender',
		'phone',
		'hasAvatar',
		'password',
		'is_super_admin',
		'cookie_str',
		'date_access',
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'pseudo'		=> 'required|is_unique[member.pseudo,id,{id}]|max_length[50]',
		'name'			=> 'max_length[50]',
		'first_name'	=> 'max_length[50]',
		'email'			=> 'required|is_unique[member.email,id,{id}]|valid_email|max_length[100]',
		'gender'		=> 'in_list[0,1,2]',
		'phone'			=> 'max_length[10]',
		'password'		=> 'required|max_length[100]',
		'pass_confirm'	=> 'required|matches[password]',
	];
	
	protected $validationMessages = [];
	
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

	/*public function getOneMember($memberId){
		$memberModel = new MemberModel();
		$member = $memberModel->find($memberId);
		return $member;
	}*/
}
