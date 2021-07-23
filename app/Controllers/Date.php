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
	public function create($eventSlug){
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

        echo view('templates/header');
        // echo view('group/view/header', $data);
        echo view('date/create', $data);
        echo view('templates/footer');
    }
}
