<?php

namespace App\Services;

use App\Models\Matching;
use App\Notifications\SendMatchingRequestNotification;
use GuzzleHttp\Client;
use Ramsey\Uuid\Uuid;

class FireBaseService extends BaseService
{
    protected $notification;

    public function __construct(Matching $matching)
    {
        $this->model = $matching;
    }

    public function sendNotification($matching, $type)
    {
        if ($matching->createdBy->user_type == 1) {
            $user = $matching->company->user;
        } else {
            $user = $matching->jobseeker->user;
        }
        //    $user->notify(new SendMatchingRequestNotification($matching));
        //     return true;

        $client = new Client();
        $access_token = env('FIREBASE_CREDENTIALS');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $title = ($user->user_type == 1) ? $user->jobseeker->first_name.' '.$user->jobseeker->last_name : $user->company_name;
        $body = ($user->user_type == 1) ? $title.'has send request for matching job' : $title.'has send request for matching job title '.$matching->job->job_title;

        $data = [
                   'title' => 'Job Matching',
                   'body' => $body,
        ];
        $url = 'this is url';
        $notificationData = $data;
        $notificationData['body'] = [
            'title' => $data['title'],
             'data' => [
                'url' => $url,
              ],
        ];
        $notificationId = Uuid::uuid4()->toString();
        $notification = $user->notify(new SendMatchingRequestNotification($notificationId, 'Matching Request', $user, 'App/Models/Matching', $notificationData));
        $message = [
           'to' => $user->device_token,
           'notification' => $data,
           'data' => [
               'url' => $url,
               'notificationId' => $notificationId,
           ],
        ];
        $output = $client->post($fcmUrl, [
           'headers' => [
               'Authorization' => 'key='.$access_token,
               'content-Type' => 'application/json',
           ],
           'json' => $message,
        ]);

        $respose = json_decode($output->getStatusCode());

        return json_decode($output->getBody());
    }

    public function sendOtp($user)
    {
        $client = new Client();
        $access_token = env('FIREBASE_CREDENTIALS');
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $data = [
            'title' => 'Your OTP for password reset',
            'body' => $user->otp,
        ];
        $message = [
            'to' => $user->device_token,
            'notification' => $data,
         ];
        $output = $client->post($fcmUrl, [
           'headers' => [
               'Authorization' => 'key='.$access_token,
               'content-Type' => 'application/json',
           ],
           'json' => $message,
        ]);
        $respose = json_decode($output->getStatusCode());

        return json_decode($output->getBody());
    }
}
