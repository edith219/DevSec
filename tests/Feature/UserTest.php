<?php
// creamos el test con php artisan make:test UserTest
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class UserTest extends TestCase
{
 
    public function test_register(){

        Artisan::call('migrate');

        // Formulario carga correctamente
        $carga = $this->get(route('register'));
        $carga->assertStatus(200);
        $carga->assertSee('Registrarse');

        //Registro incorrecto
        $registroMal = $this->post(route('do-register' 
            ),["email"=>"aaa","password"=>"123"]);
        $registroMal->assertStatus(302)->
            assertRedirect(route('register'))->
            assertSessionHasErrors([
            'email' => _('validation.email',['
                 attribute'=>'email']),
            'name' => _('validation.required',['
                 attribute'=>'name']),
            'password' => _('
                  validation.min.string',['
                  attribute'=>'password','min'=>6])
    ]);

    //Registro correcto
    $registroBien = $this->post(route('
         do-register'),['email'=>"test@testing.es"
         ,"password"=>"Password1","name"=>"Testing
         "]);
    $registroBien->assertStatus(302)->
         assertRedirect(route('home'));
    $this->assertDatabaseHas('user',['email'=>"
        test@testing.es"]);  

    }
    
}
