<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DateModel;
use App\Models\DateRegistrationModel;
use App\Models\EventModel;
use App\Models\EventRegistrationModel;
use App\Models\GroupMemberModel;
use App\Models\GroupModel;
use App\Models\RequestModel;
use CodeIgniter\I18n\Time;

class Date extends BaseController
{
	public function create($groupSlug, $eventSlug){
        if(count($_POST) > 0) {
            // il y a des données dans $_POST. Si le slug n'est pas généré, on le crée et on le place dans une variable
            if((!isset($_POST['slug']) || empty($_POST['slug'])) && !empty($_POST['name'])){
                $dateSlug  = url_title($this->request->getPost('name'), '-', TRUE);
            } elseif(isset($_POST['slug']) && !empty($_POST['slug'])) {
                $dateSlug = trim($_POST['slug']);
            } else {
                $dateSlug = null;
            }
            $_POST['slug'] = $dateSlug;
            // maintenant il y a forcément un slug dans $slug
            
            // les données du formulaire sont-elles valides ?
            if(!$this->validate([
                'name' => 'required',
                'slug' => 'is_unique[date.slug]',
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
                    $data['event']['slug'] = $eventSlug;
                
                // on affiche à nouveau le formulaire
                echo view('templates/header');
                echo view('date/create', $data);
                echo view('templates/footer');
                return;
            } else {
                
                // on ajoute le nom et le slug qui sont forcément renseigné
                $data['slug'] = $dateSlug;
                $name =  trim($_POST['name']);
                $data['name'] = $name;

                // on ajoute l'event auquel est rattachée la date
                $eventModel = new EventModel();
                $event = $eventModel->getOneEventBySlug($eventSlug, $_SESSION['member']['id']);
                $data['event_id'] = $event['id'];


                // si des dates et la description sont renseignées, on les ajoutes
                $description = trim($_POST['description']);
                if(!empty($_POST['description'])){$data['description'] = trim($_POST['description']);}
                // TODO vérifier que la date de fin est après la date de début
                if(!empty($_POST['date_start'])){$data['date_start'] = trim($_POST['date_start']);}
                if(!empty($_POST['date_end'])){$data['date_end'] = trim($_POST['date_end']);}
                // à la création le groupe n'est pas encore validé

                $dateModel = new DateModel();
                $dateModel->insert($data);

                // on inscrit ensuite le membre connecté à la date, en le mettant en admin
                // pour ça il faut d'abord récupérer la date
                $date = $dateModel->where('slug', $dateSlug)->orderBy('id', 'DESC')->first();
                // dd($date);
                // l'inscription à une date n'est possible que si on est inscrit.e à l'event correspondant
                // on va donc chercher l'inscription du membre à l'event
                $eventRegistrationModel = new EventRegistrationModel();
                $eventRegistration = $eventRegistrationModel->where(['event_id' => $event['id'], 'member_id' => $this->session->member['id']])->first();
                
                $data = array(
                    'date_id' => $date['id'],
                    'event_registration_id' => $eventRegistration['id'],
                    'is_admin' => true,
                );
                $dateRegistrationModel = new DateRegistrationModel();
                $dateRegistrationModel->insert($data);
            }
        }

        $groupController = new Group;
        $data = $groupController->header($groupSlug);
        echo view('templates/header');
        echo view('group/view/header', $data);
        echo view('date/create', $data);
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
            $data['updated_at'] = Time::now();
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

    public function delete($groupSlug, $eventSlug){
        $eventModel = new EventModel();
        $event = $eventModel->getOneEventBySlug($eventSlug);
        $data['deleted_at'] = Time::now();
        $eventModel->update($event['id'], $data);
        return redirect()->to('group/'.$groupSlug.'/event');
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
// dd($data);
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
        // dd($event);
        if(isset($_SESSION['logged']) && $_SESSION['logged'] && !$event['is_member'] && !$event['is_admin'] && count($_POST) > 0) {
            dd('ok');
            if(isset($_POST['message'])){
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
