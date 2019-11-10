<?php


namespace App\FacebookConnection;


use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Support\Facades\Config;

class FacebookSDK
{
    static function sdkConnect($accessToken, $path)
    {
        $fb = new Facebook([
            'app_id' => Config::get('facebook.client.id'),
            'app_secret' => Config::get('facebook.client.secret'),
            'default_graph_version' => Config::get('facebook.client.version'),
            'default_access_token' => $accessToken,
        ]);

        try {
            $response = $fb->get(
                $path,
                $fb->getDefaultAccessToken()
            );
        } catch (FacebookSDKException $e) {
            return $e->getMessage();
        }
        return $response;
    }
}
