<?php

namespace App\Service;

use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\WebPushConfig;

class PushNotificationService extends BaseFirebase
{
    const FRIEND_TITLE = 'Lời mời kết bạn';

    const ADD_FRIEND_BODY = ' đang yêu cầu kết bạn với bạn';

    const ACCEPT_FRIEND_BODY = ' đã đồng ý kết bạn với bạn';

    const INVITE_TO_TRIP_TITLE = "Mời tham gia chuyến đi";

    const INVITE_TO_TRIP_BODY = " đã mời bạn tham gia chuyến đi của họ";

    const ACCEPT_INVITATION_BODY = " đã chấp nhận lời mời tham gia chuyến đi của bạn";

    const REQUEST_TO_JOIN_TRIP_TITLE = "Xin Tham gia chuyến đi";

    const REQUEST_TO_JOIN_TRIP_BODY = " đã xin tham gia chuyến đi của bạn";

    const ACCEPT_JOIN_REQUEST_BODY = " đã đồng ý yêu cầu tham gia chuyến đi của bạn";

    public function addFriend($friendRecord)
    {
        $messaging = $this->firebase->getMessaging();
        if (count($friendRecord->userOne->device) > 0) {
            $message = CloudMessage::withTarget('token', $friendRecord->userTwo->device[0]->device_token)->withNotification([
                'title' => self::FRIEND_TITLE,
                'body' => $friendRecord->userOne->name.self::ADD_FRIEND_BODY,
            ])->withWebPushConfig([
                'fcm_options' => [
                    'link' => route('home'),
                ],
            ]);
            $messaging->send($message);
            foreach ($friendRecord->userTwo->device as $key => $device) {
                if ($key === 0) {
                    continue;
                }
                $anotherDeviceToken = $device->device_token;
                $message->withChangedTarget('token', $anotherDeviceToken);
            }

            return;
        }
    }

    public function acceptFriend($friendRecord)
    {
        $messaging = $this->firebase->getMessaging();
        if (count($friendRecord->userOne->device) > 0) {
            $message = CloudMessage::withTarget('token', $friendRecord->userOne->device[0]->device_token)->withNotification([
                'title' => self::FRIEND_TITLE,
                'body' => $friendRecord->userTwo->name.self::ACCEPT_FRIEND_BODY,
            ])->withWebPushConfig([
                'fcm_options' => [
                    'link' => route('home'),
                ],
            ]);
            $messaging->send($message);
            foreach ($friendRecord->userTwo->device as $key => $device) {
                if ($key === 0) {
                    continue;
                }
                $anotherDeviceToken = $device->device_token;
                $message->withChangedTarget('token', $anotherDeviceToken);
            }

            return;
        }
    }

    public function inviteFriendToTrip($memberInTrip)
    {
        $messaging = $this->firebase->getMessaging();
        if (count($memberInTrip->user->device) > 0) {
            $message = CloudMessage::withTarget('token', $memberInTrip->user->device[0]->device_token)->withNotification([
                'title' => self::INVITE_TO_TRIP_TITLE,
                'body' => $memberInTrip->trip->user->name.self::INVITE_TO_TRIP_BODY,
            ])->withWebPushConfig([
                'fcm_options' => [
                    'link' => route('home'),
                ],
            ]);
            $messaging->send($message);
            foreach ($memberInTrip->user->device as $key => $device) {
                if ($key === 0) {
                    continue;
                }
                $anotherDeviceToken = $device->device_token;
                $message->withChangedTarget('token', $anotherDeviceToken);
            }

            return;
        }
    }

    public function acceptInvitation($memberInTrip)
    {
        $messaging = $this->firebase->getMessaging();
        if (count($memberInTrip->trip->user->device) > 0) {
            $message = CloudMessage::withTarget('token', $memberInTrip->trip->user->device[0]->device_token)->withNotification([
                'title' => self::INVITE_TO_TRIP_TITLE,
                'body' => $memberInTrip->user->name.self::ACCEPT_INVITATION_BODY,
            ])->withWebPushConfig([
                'fcm_options' => [
                    'link' => route('home'),
                ],
            ]);
            $messaging->send($message);
            foreach ($memberInTrip->trip->user->device as $key => $device) {
                if ($key === 0) {
                    continue;
                }
                $anotherDeviceToken = $device->device_token;
                $message->withChangedTarget('token', $anotherDeviceToken);
            }

            return;
        }
    }

    public function requestToJoinTrip($memberInTrip)
    {
        $messaging = $this->firebase->getMessaging();
        if (count($memberInTrip->trip->user->device) > 0) {
            $message = CloudMessage::withTarget('token', $memberInTrip->trip->user->device[0]->device_token)->withNotification([
                'title' => self::REQUEST_TO_JOIN_TRIP_TITLE,
                'body' => $memberInTrip->user->name.self::REQUEST_TO_JOIN_TRIP_BODY,
            ])->withWebPushConfig([
                'fcm_options' => [
                    'link' => route('home'),
                ],
            ]);
            $messaging->send($message);
            foreach ($memberInTrip->trip->user->device as $key => $device) {
                if ($key === 0) {
                    continue;
                }
                $anotherDeviceToken = $device->device_token;
                $message->withChangedTarget('token', $anotherDeviceToken);
            }

            return;
        }
    }

    public function acceptJoinRequest($memberInTrip)
    {
        $messaging = $this->firebase->getMessaging();
        if (count($memberInTrip->user->device) > 0) {
            $message = CloudMessage::withTarget('token', $memberInTrip->user->device[0]->device_token)->withNotification([
                'title' => self::REQUEST_TO_JOIN_TRIP_TITLE,
                'body' => $memberInTrip->trip->user->name.self::ACCEPT_JOIN_REQUEST_BODY,
            ])->withWebPushConfig([
                'fcm_options' => [
                    'link' => route('home'),
                ],
            ]);
            $messaging->send($message);
            foreach ($memberInTrip->user->device as $key => $device) {
                if ($key === 0) {
                    continue;
                }
                $anotherDeviceToken = $device->device_token;
                $message->withChangedTarget('token', $anotherDeviceToken);
            }

            return;
        }
    }
}
