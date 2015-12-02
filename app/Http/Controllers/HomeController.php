<?php namespace KlinkDMS\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * [$adapter description]
	 * @var \Klink\DmsAdapter\KlinkAdapter
	 */
	private $adapter = NULL;

	/**
	 * [$documents description]
	 * @var \Klink\DmsDocuments\DocumentsService
	 */
	private $documents = NULL;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(\Klink\DmsAdapter\KlinkAdapter $adapterService, \Klink\DmsDocuments\DocumentsService $documentsService)
	{
		$this->middleware('auth');

		$this->adapter = $adapterService;

		$this->documents = $documentsService;
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Guard $auth)
	{
		
		if($auth->check()){

			$auth_user = $auth->user();
			
			return redirect($auth_user->homeRoute());
			
		}
		else {
			return view('welcome');
		}
	}

}
