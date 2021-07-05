<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $inscription = [
        'pseudo'     => [
			'rules' => 'required|is_unique[member.pseudo]|max_length[50]',
			'errors' => [
				'required' => 'Pseudo requis',
				'is_unique[member.pseudo]' => 'Pseudo déjà pris',
				'max_length[50]' => 'pseudo trop long',
			],
		],
		'email'        => 'required|valid_email|max_length[100]',
		'password'     => 'required|max_length[100]',
		'pass_confirm' => 'required|matches[password]',
		// 'name' => 'max_length[50]',
		// 'first_name' => 'max_length[50]',
		// 'gender' => 'in_list[0,1,2,3]',
		// 'phone' => 'max_length[20]',
    ];
}
