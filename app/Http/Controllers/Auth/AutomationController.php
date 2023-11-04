<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ExceptionLoggingMail;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\CalendarService;
use Carbon\Carbon;
use DateTime;
use Exception;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_CreateConferenceRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AutomationController extends Controller
{
    protected $apiKey = 'b367a8a2-4ec1-40c1-926d-ef6a1b7c439b_07atdeq';

    private function fecthDateValueAfterEqual($string)
    {
        $value = substr($string, strpos($string, "=") + 1);
        return $value;
    }

    public function replyToReceivedMail(Request $request)
    {
        // below variable values will be pulled from webhook
        $statsId = "cb79c0e6-a979-484c-ab36-777180de8ac0";
        $replyMessageId = "<CAFEB4d1mVuc=26kkoBBP0D6_=0e6SuigL1N+Opz8M1O36srxXQ@mail.gmail.com>";
        $replyEmailDateTime = "2023-10-31T07:05:25+00:00";
        $replyBody = '<div dir=\"ltr\">Once more at 31-10-2023 12:05pm</div><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">On Tue, Oct 31, 2023 at 11:18\u202fAM Hadayat Niazi &lt;<a href=\"mailto:hadiniazi801@gmail.com\">hadiniazi801@gmail.com</a>&gt; wrote:<br></div><blockquote class=\"gmail_quote\" style=\"margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex\"><div dir=\"ltr\">Hadayat Niazi is testing it on 31-10-2023 11:18am according to gmt+5 timezone.</div><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">On Tue, Oct 31, 2023 at 9:49\u202fAM Hadayat Niazi &lt;<a href=\"mailto:hadiniazi801@gmail.com\" target=\"_blank\">hadiniazi801@gmail.com</a>&gt; wrote:<br></div><blockquote class=\"gmail_quote\" style=\"margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex\"><div dir=\"ltr\">Hadayat is replying for testing</div><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">On Wed, Oct 18, 2023 at 12:30\u202fPM Hadayat Niazi &lt;<a href=\"mailto:hadiniazi801@gmail.com\" target=\"_blank\">hadiniazi801@gmail.com</a>&gt; wrote:<br></div><blockquote class=\"gmail_quote\" style=\"margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex\"><div dir=\"ltr\">Once more</div><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">On Wed, Oct 18, 2023 at 12:29\u202fPM Hadayat Niazi &lt;<a href=\"mailto:hadiniazi801@gmail.com\" target=\"_blank\">hadiniazi801@gmail.com</a>&gt; wrote:<br></div><blockquote class=\"gmail_quote\" style=\"margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex\"><div dir=\"ltr\">Hadayat is replying back again for testing</div><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">On Thu, Oct 5, 2023 at 1:29\u202fPM Hadayat Niazi &lt;<a href=\"mailto:hadiniazi801@gmail.com\" target=\"_blank\">hadiniazi801@gmail.com</a>&gt; wrote:<br></div><blockquote class=\"gmail_quote\" style=\"margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex\"><div dir=\"ltr\">Hadayat is replying back.</div><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">On Thu, Oct 5, 2023 at 11:01\u202fAM Miles Cole &lt;<a href=\"mailto:miles@tryhellogrowth.com\" target=\"_blank\">miles@tryhellogrowth.com</a>&gt; wrote:<br></div><blockquote class=\"gmail_quote\" style=\"margin:0px 0px 0px 0.8ex;border-left:1px solid rgb(204,204,204);padding-left:1ex\"><u></u>\r\n  \r\n  \r\n    \r\n    \r\n     \r\n      \r\n    \r\n  \r\n  \r\n  <div>\r\n  <div>Hi Hadayat!</div><div><br></div><div>Test test, pitch.</div><div><br></div><div>Mind if I send some more information?</div><div><br></div><div>Miles</div><img src=\"http://ismart.tryhellogrowth.com/image?messageId=%3Csw-cb79c0e6-a979-484c-ab36-777180de8ac0@tryhellogrowth.com%3E\" alt=\"\" title=\"\" style=\"display: none;\" width=\"1\" height=\"1\">\r\n  </div>\r\n  \r\n  \r\n</blockquote></div>\r\n</blockquote></div>\r\n</blockquote></div>\r\n</blockquote></div>\r\n</blockquote></div>\r\n</blockquote></div>\r\n"';
        // ==== end ==== //

        $userReply = null;
        $requestType = $request->request_type;

        if ($requestType == 'information-request') {
            $userReply = 'can you please tell me the pricing?';
        }

        else if ($requestType == 'specific-date') {
            $userReply = 'I said next Tuesday at 1pm pt... On Fri, Nov 8, 2023 at 11:31 PM Miles Cole miles@yeshellogrowth.com wrote: Great, any of these times work (PT)? Sat Nov 9 4:00 pm Sun Nov 10 12:00 pm Mon Nov 11 8:00 am If not here is my calendly.';
        }

        else if ($requestType == 'no-date') {
            $userReply = 'will you available for meeting, I want to discuss some case studies with you, If not here is my calendly.';
        }
        else {
            $userReply = $request->request_type;
        }


        $eventName = 'meeting';
        $eventDuration = 30;
        $email = auth()->user()->email;
        $calendlyLink = null;
        $companyName = null;
        $companyDescription = null;
        $leadName = null;
        $responseTrainingData = [];
        $linksData = [];

        $response = null;
        $tokenMessage = null;

        $user = auth()->user();

        if ($user) {

            if ($details = $user->userDetail) {
                $eventName = $details->event_name;
                $eventDuration = $details->event_duration_in_minutes;
                $companyName = $details->company_name;
                $companyDescription = $details->company_description;
            }

            if ($responseTraining = $user->responseTrainings) {

                foreach ($responseTraining as $training) {
                    $responseTrainingData[] = 'Reply from lead ='.$training->reply_from_lead;
                    $responseTrainingData[] = 'Ideal SDR response ='.$training->ideal_sdr_response;
                }

            }

            if ($links = $user->links) {

                foreach ($links as $link) {
                    $linksData[] = 'Link name ='.$link->key;
                    $linksData[] = 'Link Value ='.$link->value;
                }

            }

        }

        try {

            $requestType = $this->getRequestType($userReply);

            if (Str::contains($requestType, '1.') || Str::contains($requestType, 'information request')) {

                $system = '
                    You are an SDR at'.$companyName.' '.$companyDescription. '. You are fielding a positive/interested reply to a cold email sequence. You are a smart, casual salesperson. Not overly formal but professional. You are straight to the point but not rude. The call-to-action to your emails should be trying to set up a call with the calendly link ('.$calendlyLink.'). Do not restate their question or request. Just answer it quickly.
                    The lead first name is '.$leadName.'. The company name is '.$companyName.'. Their company description is '.$companyDescription.'. Here are some sample positive replies and ideal answers you should be trying to write:

                    Here are some supporting links/documents:
                    [TRAINING DATA LINKS WITH CATEGORY (e.g. case study 1: link.com)]
                    '.
                    implode('=', $responseTrainingData)
                    .
                    implode('=', $linksData)
                ;

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
                    $response = $this->bookSpecificDateEvent($email, $eventDate, $eventName, $eventDuration);

            }
            catch(\Exception $ex) {
                Log::debug('Error from specific date event, the error is: '.$ex->getMessage());
                // Mail::to( config('custom.mail.exception_notification_mail') )->send(new ExceptionLoggingMail($ex->getMessage()));
            }

            }
            else if (Str::contains($requestType, '3.') || Str::contains($requestType, 'meeting request -- no date suggested')) {

                $tomorrowDate = now()->addDay();

                $availableTimes = $this->checkNineToFiveAvailabilityForNextThreeDays($email, $tomorrowDate);

                if ($availableTimes == false) { // authentication required if it's returns the false;
                    // throw new Exception('Something went wrong in gpt, please refresh webpage and try again. If still problem persists contact with administrator');
                    $tokenMessage = 'No token found, please connect google calendar';
                }

                else if ( empty($availableTimes) ) {
                    $calendlyLink = 'Here is my calendly link '. $calendlyLink;
                }

                $response = [
                    'token_message' => $tokenMessage,
                    'event' => $response,
                    'link' => $calendlyLink,
                    'available_times' => $availableTimes
                ];
            }
            else {

                $response = 'request type is not matched with above three requests';

                return $response;
                // dd('request type is not matched with above three requests');
            }

            $finalResponse = null;

            if (isset($response['token_message'])) {

                $finalResponse = $response['token_message'];

            }
            else if (isset($response['event']) && $response['event'] != null) {
                $eventName = isset($response['event']) ? $response['event']['summary']: null;
                $finalResponse = 'An event has been created on the calendar, and here are more details '.'Event name is: '. $eventName;

            }
            else if (isset($response['link']) && $response['link'] != null) {
                $finalResponse = $response['link'];
            }
            else if (isset($response['available_times'])) {

                $availableTimes = isset($response['available_times']) ? implode(', ', $response['available_times']): null;
                $finalResponse = 'You can choose these meeting dates <b>'. $availableTimes. '</b>';

            }
            else {
                $finalResponse = $response;
            }

        }

        catch (\Exception $ex) {
            return back()->withErrors('Failed due to this error, '.$ex->getMessage());
        }

        $result = $this->sendReplyBackToApi($statsId, $finalResponse, $replyMessageId, $replyEmailDateTime, $replyBody);

        return view('auth.webhook', compact('result', 'userReply'));


    }

    private function bookSpecificDateEvent($email, $eventDate, $eventName, $eventDuration)
    {
        $event = null;
        $availableTimes = [];
        $client = $this->generateCalendarToken($email);

        if ($client === false) {
            return 'No token found, please connect google calendar';
        }

        $eventStartDate = Carbon::parse($eventDate)->toIso8601String();
        $eventEndDate = Carbon::parse($eventDate)->addMinute($eventDuration)->toIso8601String();
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
        else {
            throw new Exception('Something went wrong in gpt, please refresh webpage and try again. If still problem persists contact with administrator');
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
            return false;
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

                if ($events === false) { // mean authentication required
                    return false;
                }

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

    public function generateWebhookLink(Request $request)
    {
        $user = auth()->user();
        $appUrl = config('app.url');

        if (! $user) {
            return back()->withErrors('Unabel to find the user, please refresh the webpage and try again');
        }

        try {
            $randomString = $this->generateRandomString();

            $users = User::where('webhook_url', $randomString)->get();

            if (count($users) > 0) {
                $randomString = $this->generateRandomString();
            }

            $webhookLink = $appUrl.'/'.$randomString;

            return response()->json([
                'webhook_link' => $webhookLink
            ], 201);
        }
        catch (\Exception $ex) {
            return response()->json([
                'error' => 'Failed due to this error, '.$ex->getMessage()
            ]);
        }

    }

    private function generateRandomString() {

        $string = $randomString = Str::random(3). rand(9, 99). Str::random(3);

        return $string;
    }

    private function fetchAllCampaigns()
    {
        $data = null;
        $apiKey = $this->apiKey;

        $response = Http::get("https://server.smartlead.ai/api/v1/campaigns?api_key={$apiKey}");


        if ($response->successful()) {

            $data = $response->json();

        } else {

            $error = $response->json(); // will catch it later

        }


        return $data;

    }

    private function fetchCampaignById()
    {
        $campaign_id = 103603;
        $apiKey = $this->apiKey;
        $data = null;

        $response = Http::get("https://server.smartlead.ai/api/v1/campaigns/{$campaign_id}?api_key={$apiKey}");

        if ($response->successful()) {

            $data = $response->json();

        } else {

            $error = $response->json();  // will catch it later

        }

        return $data;
    }

    private function sendReplyBackToApi($statsId, $ourAppReply, $replyMessageId, $replyEmailDateTime, $replyBody)
    {
        $campaign_id = 103603;
        $apiKey = $this->apiKey;
        $data = null;
        $replyEmailDateTime = Carbon::parse($replyEmailDateTime);
        $cc = "miles@tryhellogrowth.com";
        $bcc = "hadiniazi801@gmail.com";

        $response = Http::post("https://server.smartlead.ai/api/v1/campaigns/{$campaign_id}/reply-email-thread?api_key={$apiKey}", [
            "email_stats_id" => $statsId,
            "email_body" => $ourAppReply, // later on replace it with our app response
            "reply_message_id" => $replyMessageId,
            // "reply_email_time" => "2023-06-19T08:10:35.000Z",
            "reply_email_body" => $replyBody,
            // "cc" => $cc,
            "bcc" => $bcc,
            "add_signature" => true
        ]);

        if ($response->successful()) {

            return 'Email reply sent successfully';

        } else {

            $error = $response->json(); // throw exception here

        }

        return $data;

    }



}
