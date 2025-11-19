<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GoogleCalendarService; // <-- ¡NECESARIO para crear el evento!
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon; // <-- NECESARIO para manejar las fechas del evento


use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirige al usuario a la página de autenticación de Google.
     * Esta es la acción del botón "Reservar con Google".
     */
    public function redirectToGoogle()    {

    return Socialite::driver('google')
    //setScopes solicita permisos especificos a Google
        ->setScopes([
            //le dices a Google que permisos quiero
            //calendar->necesario para reuniones
            //profile->info del usuario
            //emial->saber el email
            'https://www.googleapis.com/auth/calendar',
            'profile',
            'email'
        ])
             ->with([
            'access_type' => 'offline',
            'prompt' => 'consent' // fuerza a Google a mostrar la pantalla de permisos otra vez
        ])

        //redirige ,abre la ventana de Google para elegir cuenta y aceptar permisos.
        ->redirect();
}


//Google redirige aquí despues de aceptar terminos
public function handleGoogleCallBack()
//método handleGoogleCallBack() recibe la información del usuario después de que Google autoriza la aplicación.
//Uso Socialite para obtener el nombre, email y los tokens.
//Después, con updateOrCreate, registro o actualizo el usuario en la base de datos, guardo el token y, si Google me lo envía, el refresh token.
//El refresh token es clave porque permite crear eventos incluso si el access token ha caducado.
//Luego inicio sesión al usuario y lo redirijo al dashboard.
{
  try {
            // 1. Obtiene la información del usuario autenticado
            $googleUser = Socialite::driver('google')->stateless()->user();
           // Esto llama a Google y trae:

            //nombre

            //email

            //id de Google

            //token de acceso

//          refresh token (si Google lo envía)
            
            // 2. BUSCAR/CREAR EL USUARIO Y GUARDAR TOKENS
            $user = User::updateOrCreate([
                'email' => $googleUser->getEmail()
            ], [
                'name' => $googleUser->getName(),
                'google_token' => $googleUser->token,
                // El refresh token solo se da la primera vez o si se fuerza. 
                // Lo guardamos si existe, si no, lo dejamos como NULL.
                'google_refresh_token' => $googleUser->refreshToken ?? null,
                // IMPORTANTE: Laravel requiere la columna 'password' por defecto. 
                // Creamos una password dummy si no existe.
                'password' => \Hash::make($googleUser->getName() . $googleUser->getId()) 
            ]);

            // 3. Verifica el refresh token y lo guarda explícitamente si se recibió
            if (!is_null($googleUser->refreshToken)) {
                $user->google_refresh_token = $googleUser->refreshToken;
                $user->save(); 
            }
            
            // 4. Iniciar sesión del usuario
            Auth::login($user);

            // 5. Redirigir al dashboard (o donde quieras, '/')
            return redirect('/')->with('success', 'Conexión con Google y sesión iniciada.');

        } catch (\Exception $e) {
            // Si el error es de base de datos (p. ej., columna 'password' NULL), ¡lo veremos aquí!
            dd('ERROR AL PROCESAR EL CALLBACK: ' . $e->getMessage()); 
        }
    }


    //Crea un evento de prueba en el calendario del usuario autenticado
     public function bookMeeting()
    {
        // 1.Aquí recuperas al usuario que ya inició sesión con Google.
        $user = Auth::user();

        if (!$user) {
             // Si el usuario no está logueado, lo enviamos al login de Google
            return redirect()->route('google.redirect');
        }

        if (!$user->google_token) {
            // Esto solo pasaría si el usuario NO ha pasado por el flujo de OAuth (el botón "Hola")
            return redirect('/')->with('error', 'Token de Google no encontrado. Por favor, reconecta.');
        }

        try {
            // 2. Inicializar el servicio de calendario
            // Este servicio se encarga de renovar el token si ha expirado.
            $calendarService = new GoogleCalendarService($user);
            
            // 3. Definir las fechas (usamos Carbon para manejar el tiempo)
            $start = Carbon::now('Europe/Madrid')->addMinute(); // Empieza en 1 minuto
            $end = Carbon::now('Europe/Madrid')->addMinute()->addMinutes(30); // Dura 30 minutos

            // 4. Crear el evento
            $event = $calendarService->createEvent(
                'Reunión de Prueba LaravelMeetings',
                'Esta es una reunión de prueba creada automáticamente a través de la API de Google Calendar. ¡La integración funciona!',
                $start->toRfc3339String(),
                $end->toRfc3339String()
            );

            // 5. Redirigir con éxito
            return redirect()->route("meeting")->with("meetLink",$event->hangoutLink);

        } catch (\Exception $e) {
            // Si hay errores de token expirado o permisos, caeremos aquí
            dd('ERROR AL CREAR EVENTO: ' . $e->getMessage()); 
        }
    }

}




    


