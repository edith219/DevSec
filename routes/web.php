 <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/



/*
//ExampleTest
Route::get('/', function () {
    return 'home';
});

Route::get('/about', function () {
    return 'about';
});

Route::get('/contact', function () {
    return 'contact';
});
*/


//User Test
Route::view('/login','users.login')->name('login');

Route::view('/register','users.register')->name('register');

Route::get('/logout',[UserContoller::class, 'logout'])->name('logout');

Route::post('/do-login',[UserContoller::class, 'login'])->name('do-login');

Route::post('/do-register',[UserContoller::class, 'register'])->name('do-register');

Route::middleware('auth')->get('/',function(){return
     response("Portada");})->name('home');

