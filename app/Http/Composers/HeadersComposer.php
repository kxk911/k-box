<?php namespace KlinkDMS\Http\Composers;

use Illuminate\Contracts\View\View;

class HeadersComposer {

    /**
     * ...
     *
     * @var 
     */
    protected $adapter;
    
    
    private static $search_target_for_routes = array(
        'documents.show' => 'documents.index',
        'documents.edit' => 'documents.index',
        'frontpage' => 'search'
    );

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(\Klink\DmsAdapter\KlinkAdapter $adapter)
    {
        
        $this->adapter = $adapter;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $body_classes = [];

        // institution name
        $view->with('dms_institution_name', 
            $this->adapter->getInstitutionName(\Config::get('dms.institutionID'))); // 'Test Institution'

        // $view->with('dms_institution_name', 'Test');

        $is_logged = \Auth::check();

        $view->with('is_user_logged', $is_logged);

        if($is_logged){

            $logged_in_user = \Auth::user();
            $view->with('current_user', $logged_in_user->id);
            $view->with('current_user_home_route', $logged_in_user->homeRoute());
            $view->with('current_user_name', $logged_in_user->name);
            $view->with('current_user_avatar', $logged_in_user->avatar);

            $view->with('list_style_current', $logged_in_user->optionListStyle());

        }
        else {
            $view->with('list_style_current', 'tiles');
        }

        $route_name = \Route::currentRouteName();

        
        $show_search = !is_null( $route_name ) && !starts_with($route_name, 'admin') &&  
                       !str_contains($route_name, 'trash') &&  !str_contains($route_name, 'recent') && 
                       !str_contains($route_name, 'share') &&  !str_contains($route_name, 'people.index') &&
                       !str_contains($route_name, 'profile.index') &&
                       !str_contains($route_name, 'people.show') &&
                       ($is_logged || \Config::get('dms.are_guest_public_search_enabled'));
        $view->with('show_search', $show_search );

        $view->with('search_target', $show_search && array_key_exists($route_name, self::$search_target_for_routes) ? self::$search_target_for_routes[$route_name] : $route_name);
        
        $view->with('search_target_parameters', $show_search && !array_key_exists($route_name, self::$search_target_for_routes) ? \Route::current()->parameters() : false);        
        
        $is_frontpage = $route_name === 'dashboard' || $route_name === 'frontpage';

        $view->with('is_frontpage', $is_frontpage );

//        if( !is_null( $route_name ) ){
//            $body_classes[] = $route_name;
//        }
//
//        if( !is_null( $route_name ) && starts_with($route_name, 'documents')){
//            $body_classes[] = 'dropzone-container';
//        }
//
//        if( is_null( $route_name ) && !is_null(\Route::getCurrentRoute()) ){
//            $path = \Route::getCurrentRoute()->getPath();
//
//            $exploded = array_slice( explode('/', $path), 0, 2);
//
//            $body_classes[] =  implode(' ', $exploded);
//        }
//
//        $is_frontpage = $route_name === 'dashboard' || $route_name === 'frontpage';
//
//        $view->with('is_frontpage', $is_frontpage );
//
//        if($is_frontpage){
//
//            $view->with('dms_how_many_public_documents', $this->adapter->getDocumentsCount());
//
//            $view->with('dms_how_many_institutions', $this->adapter->getInstitutionsCount());
//
//        }
//
//        $already_added_classes = isset($view['body_classes']) ? $view['body_classes'] : null;
//
//        
//
//        if(!is_null($already_added_classes)){
//            $body_classes[] = $already_added_classes;
//            
//            $body_classes = array_unique($body_classes);
//        }
//
////        dd(compact('already_added_classes', 'body_classes'));
//        
//        $view->with('body_classes', implode(' ', $body_classes));
        
    }

}