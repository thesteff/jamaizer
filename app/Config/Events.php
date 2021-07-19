<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;

use App\Models\MemberModel;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', function () {
	if (ENVIRONMENT !== 'testing')
	{
		if (ini_get('zlib.output_compression'))
		{
			throw FrameworkException::forEnabledZlibOutputCompression();
		}

		while (ob_get_level() > 0)
		{
			ob_end_flush();
		}

		ob_start(function ($buffer) {
			return $buffer;
		});
	}

	/*
	 * --------------------------------------------------------------------
	 * Debug Toolbar Listeners.
	 * --------------------------------------------------------------------
	 * If you delete, they will no longer be collected.
	 */
	if (CI_DEBUG && ! is_cli())
	{
		Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
		Services::toolbar()->respond();
	}
});



Events::on('post_controller_constructor', function() {
	
	$session = \Config\Services::session();
	$members_model = new MemberModel();
	
	if (!$session->logged) {
	
		//log_message('debug', "  ******* NO SESSION USERDATA ******");
		
		// On récupère le cookie et on checke si un membre correspond
		$cookie_str = get_cookie('remember_me');
		//log_message('debug', "  ******* COOKIE exist : ".json_encode($cookie_str)." ******");
		
		// Si le cookie existe
		if ($cookie_str != "") {
		
			// On récupère le membre en fonction du cookie trouvé sur le browser
			$member = $members_model->where('cookie_str', $cookie_str)->first();
			//log_message('debug', "MEMBER : ".json_encode($member));
			
			
			// On rétablit la session
			if ($member != false) {
				
				// On récupère les évènements accessibles
				//$arrayEvent = $members_model->get_jams($member->id);
				
				// On récupère les notifications
				//$arrayNotif = [];
				//$arrayNotif = $members_model->get_notifications($member['id']);
				
				// On fixe les variables de sessions
				$data = array(
								'logged' => true,
								'member' => $member
							);
				$session->set($data);
				
				// On actualise la date_access
				$members_model->update($member['id'], [ 'date_access' => date('c') ] );

				// Pour le domaine on enlève http:// ou https://
				$domain = substr(base_url(),strpos(base_url(),"//")+2);
				// Pour le domaine on enlève le / en fin de string
				if (substr($domain,-1) == '/') $domain = substr($domain,0,-1);
				
				// On s'occupe de créer le cookie pour le login automatique et on actualise le membre
				$rdmStr = random_string('alnum',64);
				$cookie = array(
					'name'   => 'remember_me',
					'value'  => $rdmStr,
					'expire' => '15778800',            // 6 mois
					'domain' => $domain,
					'path'   => '/'
				);
				set_cookie($cookie);
				$members_model->update($member['id'], [ 'cookie_str' => $rdmStr ]);
			
				//log_message('debug', "REDIRECT TO HOME");
				redirect()->to('home');
			}
		}
	}
	/*else {
		log_message('debug', "  ******* SESSION USERDATA EXIST ******");
	}*/
});