<?php
namespace App\Services;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Spatie\GoogleCalendar\Event;

class CalendarService {

    // public function generateCalendarToken()
    // {
    //     $accessToken = session()->get('access_token');

    //     if (! session()->has('access_token')) {
    //         return false;
    //     }

    //     $client = new Google_Client();
    //     $client->setAccessToken($accessToken);

    //     return $client;
    // }

    // public function store($startDate, $endDate, $client)
    // {
    //     $timeZone = 'Asia/Karachi';
    //     $service = new Google_Service_Calendar($client);
    //     $calendarId = 'primary';

    //     $event = new Google_Service_Calendar_Event([
    //         'summary' => 'A demo title',
    //         'description' => 'a demo de',
    //         "start"=> [
    //             "dateTime" => $startDate,
    //             "timeZone" => $timeZone
    //         ],
    //           "end" => [
    //             "dateTime" => $endDate,
    //             "timeZone" => $timeZone
    //           ]
    //         // 'reminders' => ['useDefault' => true],
    //     ]);

    //     $service->events->insert($calendarId, $event);

    //     return $event;
    // }

}
