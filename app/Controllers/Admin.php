<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupModel;

class Admin extends BaseController
{
	// page dashboard pour SuperAdmin uniquement. Accès aux groupes, et aux publications jamaïzer
	public function index() {
        if(isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['member']['is_super_admin']){
            $group = new GroupModel();
            // on récupère les groupes non-validés + le membre qui les a créés dans le même objet ('created_by')
            $groups = $group->adminGetGroups();
            $data['groups'] = $groups;

            echo view('templates/header');
            echo view('admin/dashboard', $data);
            echo view('templates/footer');
        } 
        // TODO ajouter la redirection en cas de non-connexion ou non-super-admin
	}

    // methode pour valider un groupe depuis l'interface admin
    public function acceptGroup($id = 0){
        if(isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['member']['is_super_admin']){
            $group = new GroupModel();
            $data['is_valid'] = 1;
            $group->update($id, $data);
            return redirect('admin');
        } else {
            return redirect('home');
        }
    }

}
