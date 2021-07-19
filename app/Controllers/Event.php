<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\GroupModel;

class Event extends BaseController
{
	public function create($slug){
        if(count($_POST) > 0) {

            // les données du formulaire sont-elles valides ?
            if(!$this->validate([
                'name' => 'required',
                'description' => 'required',
            ])){
                // il y a des erreurs dans les données. Avant de réafficher le formulaire, on prépare l'hydratation en envoyant les données déjà rentrées
                
                if(!empty($_POST['name'])){$data['name'] = trim($_POST['name']);}
                if(!empty($_POST['description'])){$data['description'] = trim($_POST['description']);}
                if(!empty($_POST['date_start'])){$data['date_start'] = trim($_POST['date_start']);}
                if(!empty($_POST['date_end'])){$data['date_end'] = trim($_POST['date_end']);}
                // on récupère les messages d'erreur automatiques afin de les afficher
                $errors = $this->validator->getErrors();
                $data['errors'] = $errors;
                // on affiche à nouveau le formulaire
                echo view('templates/header');
                echo view('event/create', $data);
                echo view('templates/footer');
                return;
            } else {
                $name =  trim($_POST['name']);
                $description =  trim($_POST['description']);
                // on ajoute le nom et la description, qui sont forcément renseignés
                $data['name'] = $name;
                $data['description'] = $description;

                // on ajoute le groupe auquel est rattaché l'event
                $groupModel = new GroupModel();
                $group = $groupModel->getOneGroup($slug, $_SESSION['member']['id']);
                $data['group_id'] = $group['id'];


                // si des dates sont renseignées, on les ajoutes
                // TODO vérifier que la date de fin est après la date de début
                if(!empty($_POST['date_start'])){$data['date_start'] = trim($_POST['date_start']);}
                if(!empty($_POST['date_end'])){$data['date_end'] = trim($_POST['date_end']);}
                // à la création le groupe n'est pas encore validé

                $eventModel = new EventModel;
                $eventModel->insert($data);

                // on inscrit ensuite le membre connecté à l'event', en le mettant en admin
                // pour ça il faut d'abord récupérer l'event
                $event = $eventModel->where(['name' => $name, 'description' => $description])->orderBy('id', 'DESC')->first();
                $data = array(
                    'event_id' => $event['id'],
                    'member_id' => $_SESSION['member']['id'],
                    'is_admin' => true,
                );
                $eventRegistrationModel = new EventRegistrationModel();
                $eventRegistrationModel->insert($data);
            }
        }
        $groupModel = new GroupModel();
        $group = $groupModel->getOneGroup($slug, $_SESSION['member']['id']);
        $data['group'] = $group;

        echo view('templates/header');
        echo view('event/create', $data);
        echo view('templates/footer');
    }

    public function update($slug, $eventId){
        // if(isset($_SESSION['logged']) && $_SESSION['logged']){
        if(isset($_SESSION['logged']) && $_SESSION['logged']){
			$memberId = $_SESSION['member']['id'];
		} else {
			return redirect('group');
		}
        
        $eventModel = new EventModel();
        $event = $eventModel->getOneEvent($eventId);
		// $data = $event;
        
		if(count($_POST) > 0) {
            // dd($_POST);
            // les données du formulaire sont-elles valides ?
			// TODO mettre des vérifications ici
            
            // les vérifications sont faites, on enregistre le groupe
            $data['name'] = trim($_POST['name']);
            $data['description'] = trim($_POST['description']);
            $data['date_start'] = $_POST['date_start'];
            $data['date_end'] = $_POST['date_end'];
            
            $eventUpdate = $eventModel->update($event['id'], $data);
            $event = $eventModel->getOneEvent($eventId);
            // return redirect('group/view');
		} 

        $groupModel = new GroupModel();
        $group = $groupModel->getOneGroup($slug, $_SESSION['member']['id']);
        $data['group'] = $group;
        
        $data['event'] = $event;
        
        echo view('templates/header');
        echo view('event/update', $data);
        echo view('templates/footer');
    }

    public function viewGroupsEvents($slug){
        if(isset($_SESSION['logged']) && $_SESSION['logged']){
            $memberId = $_SESSION['member']['id'];
        } else {
            $memberId = 0;
        }

        $groupModel = new GroupModel();
        $group = $groupModel->getOneGroup($slug, $memberId);
        
        $eventModel = new EventModel();
        $events = $eventModel->getGroupsEvents($slug);

        $data['group'] = $group;
        $data['events'] = $events;
        
        echo view('templates/header');
        echo view('event/view', $data);
        echo view('templates/footer');
    }

}
