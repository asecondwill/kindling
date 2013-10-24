<?
	add_filter('get_twig', 'add_to_twig');
	add_filter('timber_context', 'add_to_context');

	function add_to_context($data){
		/* this is where you can add your own data to Timber's context object */
		$data['qux'] = 'I am a value set in your functions.php file';
		$data['menu'] = new TimberMenu();
		//$data['widgetareacart'] = Timber::get_widgets('widgetarea-cart');		

		return $data;
	}

	function add_to_twig($twig){
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension(new Twig_Extension_StringLoader());
		$twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
		$twig->addFilter('avatar', new Twig_Filter_Function('avatar'));
		$function = new Twig_SimpleFunction('avatar', function ($comment, $size = 32, $default = '') {
      return get_avatar($comment, $size, $default);
    });
    $twig->addFunction($function);
		return $twig;
	}


	function myfoo($text){
    	$text .= ' bar!';
    	return $text;
	}

class KindlingComment extends TimberComment {
 function avatar($size='32', $default='<path_to_url>'){
      // Fetches the Gravatar
      // use it like this
      // {{comment.avatar(36,template_uri~"/img/dude.jpg")}}
      return get_avatar($this,$size,$default );
      
    }
}

/*
\------------------------------------
\ Switch on for production.
\====================================
*/
// Timber::$cache = true;