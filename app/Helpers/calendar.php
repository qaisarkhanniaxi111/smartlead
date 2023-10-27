<?php

use Carbon\Carbon;
use Google_Client as GoogleCalendarClient;
use Google_Service_Calendar as GoogleServiceCalendar;
use Google_Service_Calendar_Event as GoogleServiceCalendarEvent;

if (! function_exists('createCalendarEvent')) {

    function createCalendarEvent($startDate, $endDate, $client) {

        $timeZone = 'Asia/Karachi';
        $service = new GoogleServiceCalendar($client);
        $calendarId = 'primary';

        $event = new GoogleServiceCalendarEvent([
            'summary' => 'A demo title',
            'description' => 'a demo de',
            "start"=> [
                "dateTime" => $startDate,
                "timeZone" => $timeZone
            ],
              "end" => [
                "dateTime" => $endDate,
                "timeZone" => $timeZone
              ]
            // 'reminders' => ['useDefault' => true],
        ]);

        $service->events->insert($calendarId, $event);

        return $event;

    }

}

if (! function_exists('generateCalendarToken')) {

    function generateCalendarToken($accessToken) {

        if (! session()->has('access_token')) {
            return false;
        }

        $client = new GoogleCalendarClient();
        $client->setAccessToken($accessToken);

        return $client;
    }

}

