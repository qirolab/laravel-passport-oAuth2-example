<?php
use App\Http\Controllers\ClientRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts', 'PostsController@index');

Route::get('/developers', 'DevelopersController@index');




//This function will get Data from the clientsOath view and create the client_user and client_id 

Route::get('oathClients', function (\Laravel\Passport\ClientRepository $clientRepository,Request $request) {
  return  $clientRepository->create(null, $request->name, $request->redirect_uri);

});


//This function will get Data from the personalTokenView view and create the client_id 
Route::get('tokenPersonal', function (\Laravel\Passport\ClientRepository $clientRepository, Request $request) {
    return  $clientRepository->createPersonalAccessClient(null, $request->name, $request->redirect_uri);
  });






  //forUser

//Show blade for making Oath Clients View

Route::get('/clientsOath', function(){
    return view('clientsOath2.clientsOath');
})->name("showView"); 





//Show blade for making Personal Access Token

Route::get('/personal_access_token', function(){
    return view('clientsOath2.tokenPersonal');
})->name("tokenPersonalInsert"); 





  
//Route for Creating the authentication Id
 //Set Up the Credentials here,You can Customise this in .env 
  
Route::get('/redirect', function (Request $request) {
   

    $request->session()->put('state', $state = Str::random(40));
    
    $query = http_build_query([
        'client_id' => '',
        'redirect_uri' => '', // Should be the same with one you used when you were making the client_id and client_secret
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
    ]);
    
    //No need to define the oauth/authorise route at the end of this url, it is defined by laravel 
    return redirect('whatever_folder/server/public/oauth/authorize?'.$query);
    
    });   
    
    
    
    
    //Recieve The Authorisation code here , compare the states and proceed 
    
    Route::get('/callback', function (Request $request) {
        $state = $request->session()->pull('state');
    
        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );
     //No need to define the oauth/token route at the end of this url, it is defined by laravel 
        $response = Http::asForm()->post('whatever_folder/server/public/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => '',
            'client_secret' => '***********************',
            'redirect_uri' => '', // Should be the same with one you used when you were making the client_id and client_secret
            'code' => $request->code,
        ]);
    
        return $response->json();
    });
    
    
    //Here we now get the token response  
    Route::get('/tokenresponse', function (Request $request) {
    return $request;
    });

