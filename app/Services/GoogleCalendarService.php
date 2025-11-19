<?php

namespace App\Services;

use App\Models\User;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Illuminate\Support\Facades\Log;

/**
 * Clase de servicio para interactuar con la API de Google Calendar.
 * Maneja la autenticación, la renovación de tokens y la creación de eventos.
 */
class GoogleCalendarService
{
    protected Client $client;
    protected User $user;
    protected Calendar $calendarService;

    /**
     * Inicializa el cliente de Google y configura el token del usuario.
     * * @param User $user El modelo de usuario que contiene los tokens de Google.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->client = new Client();

        // 1. Configurar credenciales de la aplicación (CLIENT_ID, CLIENT_SECRET)
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope(Calendar::CALENDAR);
        
        // 2. Establecer el token de acceso del usuario
        $accessToken = [
            'access_token' => $user->google_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => 3600, // Google tokens expiran en 1 hora (3600s)
        ];
        
        $this->client->setAccessToken($accessToken);

        // 3. Manejar la expiración del token (¡La parte más importante!)
        if ($this->client->isAccessTokenExpired()) {
            if ($user->google_refresh_token) {
                try {
                    // Refrescar el token usando el refresh_token
                    $this->client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
                    
                    // Obtener el nuevo token y guardarlo
                    $newAccessToken = $this->client->getAccessToken();

                    // ¡Guardar el nuevo token en la base de datos!
                    $this->user->google_token = $newAccessToken['access_token'];
                    // Si Google envía un nuevo refresh_token (lo cual es raro, pero posible), lo guardamos.
                    if (isset($newAccessToken['refresh_token'])) {
                        $this->user->google_refresh_token = $newAccessToken['refresh_token'];
                    }
                    $this->user->save();
                    
                    Log::info('Google Token refrescado y guardado con éxito para: ' . $user->email);

                } catch (\Exception $e) {
                    // Si falla el refresh token, lanza una excepción para que el controlador lo capture
                    throw new \Exception('Error al renovar el token de Google: ' . $e->getMessage());
                }
            } else {
                // Si el token ha expirado y no hay refresh token, el usuario debe reconectarse.
                throw new \Exception('Token de acceso de Google expirado y no hay Refresh Token disponible.');
            }
        }

        // 4. Crear el servicio de Google Calendar
        $this->calendarService = new Calendar($this->client);
    }

    /**
     * Crea un evento en el calendario principal del usuario.
     *
     * @param string $summary Título del evento.
     * @param string $description Descripción del evento.
     * @param string $startDateTime Fecha y hora de inicio (formato RFC3339).
     * @param string $endDateTime Fecha y hora de fin (formato RFC3339).
     * @param string $timeZone Zona horaria (ej: 'Europe/Madrid').
     * @return Event Evento de Google creado.
     */
    public function createEvent(
        string $summary, 
        string $description, 
        string $startDateTime, 
        string $endDateTime, 
        string $timeZone = 'Europe/Madrid'
    ): Event
    {
        $event = new Event([
            'summary' => $summary,
            'description' => $description,
            'start' => [
                'dateTime' => $startDateTime,
                'timeZone' => $timeZone,
            ],
            'end' => [
                'dateTime' => $endDateTime,
                'timeZone' => $timeZone,
            ],
            'conferenceData' => [
    'createRequest' => [
        'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
        'requestId' => uniqid(),
    ],
],

            // Puedes agregar invitados, recordatorios, etc., aquí si es necesario
        ]);

        // 'primary' es el identificador del calendario principal del usuario
        $calendarId = 'primary';
        
    return $this->calendarService->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);

    }
}
