<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ExceptionLoggingMail;
use App\Models\User;
use App\Services\CalendarService;
use Carbon\Carbon;
use DateTime;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_CreateConferenceRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AutomationController extends Controller
{
    private function fecthDateValueAfterEqual($string)
    {
        $value = substr($string, strpos($string, "=") + 1);
        return $value;
    }

    public function replyToReceivedMail(Request $request)
    {
        // $userReply = 'can you please tell me the pricing?';
        $userReply = 'I said next Tuesday at 1pm pt... On Fri, Nov 8, 2023 at 11:31 PM Miles Cole miles@yeshellogrowth.com wrote: Great, any of these times work (PT)? Sat Nov 9 4:00 pm Sun Nov 10 12:00 pm Mon Nov 11 8:00 am If not here is my calendly.';
        // $userReply = 'will you available for meeting, I want to discuss some case studies with you, If not here is my calendly.';

        $eventName = 'meeting';
        $email = 'hadiniazi801@gmail.com';
        $calendlyLink = null;
        $response = null;


        // $requestType = $this->getRequestType($userReply);

        $requestType = 'meeting request -- no date suggested';

        if (Str::contains($requestType, '1.') || Str::contains($requestType, 'information request')) {

            $system = '"send more info", "interesting", "what is pricing?", "how does it work?", "can you share some case studies?", "do you work on commission only?"'. 'the pricing is $10';

            $response = $this->fetchGptResponse($userReply, $system);

        }
        else if (Str::contains($requestType, '2.') || Str::contains($requestType, 'specific date suggested')) {

           try {

                $eventDate = null;
                $date = $this->fecthDateValueAfterEqual($requestType);

                if (! strtotime($date)) {

                    $requestType = $this->getRequestType($userReply);
                    $eventDate = $this->fecthDateValueAfterEqual($requestType);

                }
                else {
                    $eventDate = $date;
                }
                // dd($eventDate);
                $response = $this->bookSpecificDateEvent($email, $eventDate, $eventName);

           }
           catch(\Exception $ex) {
            Log::debug('Error from specific date event, the error is: '.$ex->getMessage());
            // Mail::to( config('custom.mail.exception_notification_mail') )->send(new ExceptionLoggingMail($ex->getMessage()));
           }

        }
        else if (Str::contains($requestType, '3.') || Str::contains($requestType, 'meeting request -- no date suggested')) {

            $tomorrowDate = now()->addDay();

            $availableTimes = $this->checkNineToFiveAvailabilityForNextThreeDays($email, $tomorrowDate);

            if ( empty($availableTimes) ) {
                $response = 'Here is my calendly link '. $calendlyLink;
            }

            $response = [
                'event' => $response,
                'available_times' => $availableTimes
            ];
        }
        else {

            $response = 'request type is not matched with above three requests';

            return $response;
            // dd('request type is not matched with above three requests');
        }

        $finalResponse = null;

        if (isset($response['event'])) {

            $eventName = isset($response['event']) ? $response['event']['summary']: null;
            $finalResponse = 'An event has been created on the calendar, and here are more details '.'Event name is: '. $eventName;

        }
        else if (isset($response['available_times'])) {

            $availableTimes = isset($response['available_times']) ? implode(', ', $response['available_times']): null;
            $finalResponse = 'You can choose these meeting dates '. $availableTimes;

        }
        else {
            $finalResponse = $response;
        }

        return $finalResponse;


    }


    private function bookSpecificDateEvent($email, $eventDate, $eventName)
    {
        $event = null;
        $availableTimes = [];
        $client = $this->generateCalendarToken($email);

        if ($client == false) {
            return 'no token';
        }

        $eventStartDate = Carbon::parse($eventDate)->toIso8601String();
        $eventEndDate = Carbon::parse($eventDate)->addHour()->toIso8601String();
        $dateTime = ['timeMin' => $eventStartDate, 'timeMax' => $eventEndDate];

        $events = $this->checkCalendarEventAvailability($dateTime, $email);

        if (empty($events)) {

            $event = $this->createCalendarEvent($eventStartDate, $eventEndDate, $client, $eventName);

            if ($event) {
                $event = [
                    'summary' => $event->summary
                ];
            }

        }
        else {
            $availableTimes = $this->checkNineToFiveAvailabilityForNextThreeDays($email, $eventDate);
        }

        $response = [
            'event' => $event,
            'available_times' => $availableTimes
        ];

        return $response;

    }

    private function getRequestType($userReply)
    {
       $system = "Sort the email reply into one of these six categories, given the call to action of the original email was 'mind if I send through some more info?' 1. information request ('send more info', 'interesting', 'what's pricing?', 'how does it work?', 'can you share some case studies?', 'do you work on commission only?')
        2. meeting request -- specific date suggested ('sure, how is friday at 2pm?', 'Let's talk -- can you do Monday afternoon ET?')
        3. meeting request -- no date suggested ('interesting. when are you available for a zoom?', 'let's talk'.)
        4. negative ('thanks for reaching out! we're not interested at this time', 'no', 'unsubscribe', 'stop')
        5. maybe later ('no budget right now, maybe next quarter.')
        6. confirmation ('thanks, grabbed a time on your calendar', 'booked a time on Monday', 'great, thanks.', 'looking forward to it!')". 'please add the mentioned date in dateformat here meeting_date={date}';
       ;

       $response = $this->fetchGptResponse($userReply, $system);

       return $response;
        // return response()->json(['response' => $data['choices'][0]['message'] ], 200, array(), JSON_PRETTY_PRINT);
    }

    private function fetchGptResponse($userReply, $system)
    {
        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '. config('services.open-ai.key'),
          ])
          ->post("https://api.openai.com/v1/chat/completions", [
            "model" => "gpt-4",
            'messages' => [
                [
                    "role" => "system",
                    "content" => $system,
                ],
                [
                   "role" => "user",
                   "content" => $userReply,
                ]
            ],

            // 'temperature' => 0.7,
            // "max_tokens" => 200,
            // "top_p" => 1.0,
            // "frequency_penalty" => 0.52,
            // "presence_penalty" => 0.5,
            // "stop" => ["11."],

          ])

        ->json();

        $response = null;

        if (isset($data['choices'][0]['message']['content'])) {
            $response = $data['choices'][0]['message']['content'];
        }

        return $response;
    }

    private function createCalendarEvent($startDate, $endDate, $client, $eventName)
    {
        $timeZone = 'Asia/Karachi';
        $service = new Google_Service_Calendar($client);
        $calendarId = 'primary';

        $event = new Google_Service_Calendar_Event([
            'summary' => $eventName,
            // 'description' => 'a demo de',
            "start"=> [
                "dateTime" => $startDate,
                "timeZone" => $timeZone
            ],
              "end" => [
                "dateTime" => $endDate,
                "timeZone" => $timeZone
              ],

              'conferenceData' => array(
                'createRequest' => array(
                    'requestId' => Str::random(6),
                    'conferenceSolutionKey' => array(
                        'type' => 'hangoutsMeet',
                    ),
                ),
            ),

        ]);

        // Set the conference data for Google Meet
        // $conferenceData = new Google_Service_Calendar_ConferenceData();
        // $conferenceData->setCreateRequest(new Google_Service_Calendar_CreateConferenceRequest(array(
        //     'requestId' => Str::random(8), // Provide a unique request ID
        // )));

        // $event->setConferenceData($conferenceData);

        $service->events->insert($calendarId, $event, [
            'conferenceDataVersion' => 1
        ]);

        // $meetLink = $event->getHangoutLink();


        return $event;

    }

    private function generateCalendarToken($email)
    {
        $accessToken = $this->generateAccessTokenFromRefreshToken($email);

        if (! $accessToken) {
            return false;
        }

        $client = new Google_Client();
        $client->setAccessToken($accessToken);

        return $client;
    }

    private function checkCalendarEventAvailability($datetime, $email)
    {
        $client =  $this->generateCalendarToken($email);

        if (! $client) {
            return to_route('google.login');
        }

        $service = new Google_Service_Calendar($client);

        $calendarId = 'primary';

        $results = $service->events->listEvents($calendarId, $datetime);
        $events = $results->getItems();
        return $events;
    }

    private function checkNineToFiveAvailabilityForNextThreeDays($email, $date)
    {
        $i = 0;
        $j = 0;
        $count = 0;
        $availableTimes = [];

        $startDay = Carbon::parse($date);
        $endDay = Carbon::parse($date);

        while ($i < 3) { // execute it 3 times to check the 3 days availability


            $startDateTime = $startDay->setHour(9)->setMinute(0)->setSecond(0);
            $endDateTime = $endDay->setHour(9)->setMinute(59)->setSecond(59);

            while ($j < 8) {

                if ($j != 0) {
                    $startDateTime = Carbon::parse($startDateTime)->addHours(26);
                    $endDateTime = Carbon::parse($endDateTime)->addHours(26);
                }

                $startDateTime = $startDateTime->toIso8601String();
                $endDateTime = $endDateTime->toIso8601String();

                $dateTime = ['timeMin' => $startDateTime, 'timeMax' => $endDateTime];

                $events = $this->checkCalendarEventAvailability($dateTime, $email);

                if (empty($events)) {

                    $availableTimes[] = $startDateTime;
                    $count++;

                }

                if ($count === 3) { // terminate the loop after creating three event
                    break;
                }

                $j++;

            }

            if ($count === 3) { // terminate the loop after creating three event
                break;
            }

            $i++;

        }

        return $availableTimes;

    }

    private function generateAccessTokenFromRefreshToken($email)
    {
        $user = User::where('email', $email)->first();

        if (! $user) {

            return false;

        }

        $refreshToken = $user->google_refresh_token;

        // Initialize the Google API Client
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));

        // Set the refresh token
        // $accessToken = ['access_token' => $user->google_token, 'refresh_token' => $refreshToken];
        // $client->setAccessToken($accessToken);
        $client->refreshToken($refreshToken);


        $client->fetchAccessTokenWithRefreshToken();

        $accessToken = $client->getAccessToken()['access_token'];

        return $accessToken;

    }




}
