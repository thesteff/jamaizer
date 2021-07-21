<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\GroupMemberModel;
use App\Models\GroupModel;
use App\Models\RequestModel;

class Event extends BaseController
{
	public function create($groupSlug){
        if(count($_POST) > 0) {

            // il y a des données dans $_POST. Si le slug n'est pas généré, on le crée et on le place dans une variable
            if((!isset($_POST['slug']) || empty($_POST['slug'])) && !empty($_POST['name'])){
                $slug  = url_title($this->request->getPost('name'), '-', TRUE);
            } elseif(isset($_POST['slug']) && !empty($_POST['slug'])) {
                $slug = trim($_POST['slug']);
            } else {
                $slug = null;
            }
            $_POST['slug'] = $slug;
            // maintenant il y a forcément un slug dans $slug
            
            // les données du formulaire sont-elles valides ?
            if(!$this->validate([
                'name' => 'required',
                'slug' => 'is_unique[events.slug]',
                'description' => 'required',
                ])){
                    // il y a des erreurs dans les données. Avant de réafficher le formulaire, on prépare l'hydratation en envoyant les données déjà rentrées
                    
                    if(!empty($_POST['name'])){$data['name'] = trim($_POST['name']);}
                    if(!empty($_POST['slug'])){$data['slug'] = trim($_POST['slug']);}
                    if(!empty($_POST['description'])){$data['description'] = trim($_POST['description']);}
                    if(!empty($_POST['date_start'])){$data['date_start'] = trim($_POST['date_start']);}
                    if(!empty($_POST['date_end'])){$data['date_end'] = trim($_POST['date_end']);}
                    // on récupère les messages d'erreur automatiques afin de les afficher
                    $errors = $this->validator->getErrors();
                    $data['errors'] = $errors;
                    $this->validator->reset();
                    $data['group']['slug'] = $groupSlug;
                
                // on affiche à nouveau le formulaire
                echo view('templates/header');
                echo view('event/create', $data);
                echo view('templates/footer');
                return;
            } else {
                
                $name =  trim($_POST['name']);
                $data['slug'] = $slug;
                $description =  trim($_POST['description']);
                // on ajoute le nom et la description, qui sont forcément renseignés
                $data['name'] = $name;
                $data['description'] = $description;

                // on ajoute le groupe auquel est rattaché l'event
                $groupModel = new GroupModel();
                $group = $groupModel->getOneGroupBySlug($groupSlug, $_SESSION['member']['id']);
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
                // TODO il faut peut-être améliorer la méthode. Car là il y a une possibilité d'être enregistré sur le mauvais event si un membre crée au même moment (ou plutôt une petite fraction de seconde plus tard) un event avec le même nom et la même description exactement.
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
        // $groupModel = new GroupModel();
        // $group = $groupModel->getOneGroupBySlug($slug, $_SESSION['member']['id']);
        // $data['group'] = $group;

        $groupController = new Group;
        $data = $groupController->header($groupSlug);
        echo view('templates/header');
        echo view('group/view/header', $data);
        echo view('event/create', $data);
        echo view('templates/footer');
    }

    public function update($groupSlug, $eventSlug){
        if(isset($_SESSION['logged']) && $_SESSION['logged']){
			$memberId = $_SESSION['member']['id'];
		} else {
			return redirect('group');
		}
        
        $eventModel = new EventModel();
        $event = $eventModel->getOneEventBySlug($eventSlug);
        
		if(count($_POST) > 0) {
            // les données du formulaire sont-elles valides ?
			// TODO mettre des vérifications ici
            
            // les vérifications sont faites, on enregistre le groupe
            $data['name'] = trim($_POST['name']);
            $data['description'] = trim($_POST['description']);
            $data['date_start'] = $_POST['date_start'];
            $data['date_end'] = $_POST['date_end'];
            
            $eventUpdate = $eventModel->update($event['id'], $data);
            $event = $eventModel->getOneEventBySlug($eventSlug);
            // return redirect('group/view');
		} 

        // $groupModel = new GroupModel();
        // $group = $groupModel->getOneGroupBySlug($slug, $_SESSION['member']['id']);
        // $data['group'] = $group;

        $groupController = new Group;
        $data = $groupController->header($groupSlug);
        
        $data['event'] = $event;
        
        echo view('templates/header');
        echo view('group/view/header', $data);
        echo view('event/update', $data);
        echo view('templates/footer');
    }

    public function viewGroupsEvents($groupSlug){
        if(isset($_SESSION['logged']) && $_SESSION['logged']){
            $memberId = $_SESSION['member']['id'];
        } else {
            $memberId = 0;
        }

        // $groupModel = new GroupModel();
        // $group = $groupModel->getOneGroupBySlug($slug, $memberId);
        
        $groupController = new Group;
        $data = $groupController->header($groupSlug);

        $eventModel = new EventModel();
        $events = $eventModel->getGroupsEvents($groupSlug);

        $data['events'] = $events;
        
        echo view('templates/header');
        echo view('group/view/header', $data);
        echo view('event/view', $data);
        echo view('templates/footer');
    }

    public function viewOneEvent($groupSlug, $eventSlug){
        if(isset($_SESSION['logged']) && $_SESSION['logged']){
            $memberId = $_SESSION['member']['id'];
        } else {
            $memberId = 0;
        }
        // $groupModel = new GroupModel();
        // $group = $groupModel->getOneGroupBySlug($slug, $memberId);
        $groupController = new Group;
        $data = $groupController->header($groupSlug);

        $eventModel = new EventModel();
        $event = $eventModel->getOneEventBySlug($eventSlug, $memberId);
        
        // ====================================================== //
		// = //  envoie de requête pour rejoindre un groupe  // = //
		// ====================================================== //
		/**
         * On vérifie : 
         * - que le membre est connecté
         * - que le membre ne fait pas partie de l'événement
         * - que le membre n'est pas admin de l'événement
         * - que des données sont envoyées via $_POST
		 */
        if(isset($_SESSION['logged']) && $_SESSION['logged'] && !$event['is_member'] && !$event['is_admin'] && count($_POST) > 0) {
            if($this->validate(['message' => 'required'])){
				$eventId = $event['id'];
				$message = trim($_POST['message']);
				$memberId = $_SESSION['member']['id'];
			} else {
				$errors[] = 'Pour envoyer une demande, veuillez écrire un message';
				$data['errors'] = $errors;
				echo view('templates/header');
				echo view('event/viewOne', $data);
				echo view('templates/footer');
				return;
			}
			
            $requestModel = new RequestModel();
			$requestModel->setEventRequest($eventId, $message, $memberId);
			$success['eventRequest'] = 'Votre demande pour rejoindre l\'événement a bien été envoyée !';
			$data['success'] = $success;
		} 

        // $data['group'] = $group;
        $data['event'] = $event;
        
        echo view('templates/header');
        echo view('group/view/header', $data);
        echo view('event/viewOne', $data);
        echo view('templates/footer');
    }

    public function members($groupSlug, $eventSlug){
        $groupController = new Group;
        $data = $groupController->header($groupSlug);
        // dd($data);

        $eventModel = new EventModel();
        $event = $eventModel->getOneEventBySlug($eventSlug);
        $data['event'] = $event;
        
        $eventRequestModel = new RequestModel();
        $eventRequests = $eventRequestModel->getEventRequests($eventSlug);
        $data['eventRequests'] = $eventRequests;

        $eventRegistrationModel = new EventRegistrationModel();
        $eventRegistrations = $eventRegistrationModel->getEventRegistrations($eventSlug);
        $data['eventRegistrations'] = $eventRegistrations;

        echo view('templates/header');
        echo view('group/view/header', $data);
        echo view('event/members', $data);
        echo view('templates/footer');
    }

    //  ! pas une page ! pour accepter un membre dans un groupe  //
    public function acceptMemberInEvent($groupSlug, $eventSlug, $memberId){

		// TODO ajouter ici une vérification pour être sûre que la personne connectée est admin de l'event
		if(isset($_SESSION['logged']) && $_SESSION['logged']){
			$eventModel = new EventModel();
            $event = $eventModel->getOneEventBySlug($eventSlug);
            
            $data = array(
				'event_id' => $event['id'],
				'member_id' => $memberId,
				'is_admin' => false,
			);
			
			// on crée la relation membre groupe => le membre fait maintenant partie du groupe
			$eventRegistrationModel = new EventRegistrationModel();
            $eventRegistrationModel->insert($data);

			// on supprime la requête qui n'est plus utile
			$requestModel = new RequestModel();
			$request = $requestModel->where(['event_id' => $event['id'], 'member_id' => $memberId])->first();
			$requestModel->delete($request);
            
			return  redirect('group');
        } else {
            return redirect('group');
        }
    }

}
