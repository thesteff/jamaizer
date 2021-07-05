<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MemberModel;
// use App\Config\Validation;

class Member extends BaseController
{
	public function index()
	{
		//
	}

	public function create() {
		$validation =  \Config\Services::validation();
		$validation->getRules('inscription');
		$errors = $validation->getErrors();
		
		// $errors = [['a'=>'a']];

		// on vérifie que les champs requis sont remplis : pseudo, email, password, pass_confirm
		if(isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['pass_confirm'])) {
			// dd($_POST);

			// on enlève les espaces qui débordent et on range pseudo et email dans des variables simples
			$pseudo = trim($_POST['pseudo']);
			$email = trim($_POST['email']);
			$password = $_POST['password'];
			$pass_confirm = $_POST['pass_confirm'];
			
			// on vérifie si le pseudo et l'email sont uniques et de bonne longueur, et si password correspond à pass_confirm
			if ( $this->validate([
				$pseudo       => 'is_unique[member.pseudo]|max_length[50]',
				$email        => 'is_unique[member.email]|valid_email|max_length[100]',
				$password     => 'max_length[100]',
				$pass_confirm => 'matches[password]',
			])){
				// on hash le password après vérif
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	
				// met toutes les infos dans $data
				$data = array(
					'pseudo' => $pseudo,
					'email' => $email,
					'password' => $password,
				);

				// crée un objet membre
				$member = new MemberModel;
				
				// met les données $data dans le nouvel objet $member
				$member->insert($data);

			}
			// else {

				// return view('member/create', [
				// 	'errors' => $this->validator->getErrors()
				// ]);

				// $errors = $this->validator->getErrors();
				// echo view('templates/header');
				// echo view('member/create', $errors);
				// echo view('templates/footer');
			// }
			



			// validation du formulaire
			// $validation->setRules([
			// 	'pseudo'     => 'required|is_unique[member.pseudo]|max_length[50]',
			// 	'email'        => 'required|valid_email|max_length[100]',
			// 	'password'     => 'required|max_length[100]',
			// 	'pass_confirm' => 'required|matches[password]',
			// 	'name' => 'max_length[50]',
			// 	'first_name' => 'max_length[50]',
			// 	'gender' => 'in_list[0,1,2,3]',
			// 	'phone' => 'max_length[20]',
			// ]);

			// $validation->setRules([
			// 	'pseudo'     => [
			// 		'rules' => 'required|is_unique[member.pseudo]|max_length[50]',
			// 		'errors' => [
			// 			'required' => 'Pseudo requis',
			// 			'is_unique[member.pseudo]' => 'Pseudo déjà pris',
			// 			'max_length[50]' => 'pseudo trop long',
			// 		],
			// 	],
			// 	'email'        => 'required|valid_email|max_length[100]',
			// 	'password'     => 'required|max_length[100]',
			// 	'pass_confirm' => 'required|matches[password]',
			// 	'name' => 'max_length[50]',
			// 	'first_name' => 'max_length[50]',
			// 	'gender' => 'in_list[0,1,2,3]',
			// 	'phone' => 'max_length[20]',
			// ]);
			



			// $name = trim($_POST['name']);
			// $first_name = trim($_POST['first_name']);
			// $gender = trim($_POST['gender']);
			// $birth = trim($_POST['birth']);
			// $phone = trim($_POST['phone']);


			// $data = array(
			// 	'pseudo' => $pseudo,
			// 	'email' => $email,
			// 	'password' => $password,
			// 	'name' => $name,
			// 	'first_name' => $first_name,
			// 	'gender' => $gender,
			// 	'birth' => $birth,
			// 	'phone' => $phone,
			// );

			// // crée un objet membre
			// $member = new MemberModel;
			
			// // met les données $data dans le nouvel objet $member
			// $member->insert($data);
			
		} 
		// else {
		// 	return view('member/create', [
		// 		'errors' => [
		// 			'incomplet'
		// 		]
		// 	]);
		// }
		// $errors = $validation->getErrors('pseudo');

		echo view('templates/header');
		echo view('member/create', $errors);
		echo view('templates/footer');
	}

	public function view() {
		
		echo view('templates/header');
		echo view('member/view');
		echo view('templates/footer');
	}
}
