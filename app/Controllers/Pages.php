<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        if ( ! is_file(APPPATH.'/Views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        if ($page == "home") 
        {
            $data['title'] = "Accueil";
            $data['page_title'] = "Jamaizer rencontres musicales";
            // On lance la vue
            echo view('templates/header', $data);
            echo view('pages/'.$page, $data);
            echo view('templates/footer', $data);
        }

        elseif ($page == "about") 
        {
            $data['title'] = "A propos";
            $data['page_title'] = "Jamaizer rencontres musicales";
            // On lance la vue
            echo view('templates/header', $data);
            echo view('pages/'.$page, $data);
            echo view('templates/footer', $data);
        }

        elseif ($page == "contact") 
        {
            $data['title'] = "Contact";
            $data['page_title'] = "Contacter Jamaizer";
            // On lance la vue
            echo view('templates/header', $data);
            echo view('pages/'.$page, $data);
            echo view('templates/footer', $data);
        }

        elseif ($page == "member") 
        {
            $data['title'] = "Profil";
            $data['page_title'] = "Votre Profil";
            // On lance la vue
            echo view('templates/header', $data);
            echo view('pages/'.$page, $data);
            echo view('templates/footer', $data);
        }
        
    }
}