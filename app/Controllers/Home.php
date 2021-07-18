<?php

namespace App\Controllers;

class Home extends BaseController {

	public function index() {
		
		// On récupère les infos du membres s'il est connecté
		$data['session'] = $this->session;
		
		echo view('templates/header', $data);
		echo view('pages/home', $data);
		echo view('templates/footer.php', $data);
	}
}
