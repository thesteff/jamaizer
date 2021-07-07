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
		'is_super_admin',
		'email',
		'password',
		'name',
		'first_name',
		'birth',
		'gender',
		'phone',
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [
		// 'pseudo'     => 'required|is_unique[member.pseudo]|max_length[50]',
        // 'email'        => 'required|valid_email|max_length[100]',
        // 'password'     => 'required|max_length[100]',
        // 'pass_confirm' => 'required|matches[password]',
		// 'name' => 'max_length[50]',
		// 'first_name' => 'max_length[50]',
		// 'gender' => 'in_list[0,1,2,3]',
		// 'phone' => 'max_length[20]',
	];
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
}
