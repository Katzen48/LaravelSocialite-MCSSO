<?php

namespace SocialiteProviders\MCSSO;

use Carbon\Carbon;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'MCSSO';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://mc-sso.de/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://mc-sso.de/oauth/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://mc-sso.de/api/user', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        $data = $user['data'];

        $map = [
            // General User Info
            'id'            => $data['id'],
            'nickname'      => $data['name'],
            'name'          => $data['name'],

            // Minecraft
            'uuid'          => $data['minecraft']['uuid'],
            'verified'      => $data['minecraft']['verified'],
        ];

        if(array_key_exists('email', $data))
            $map['email'] = $data['email'];

        if(array_key_exists('verified_at', $data))
            $map['verified_at'] = $data['verified_at'];

        if(array_key_exists('twitch', $data))
            $map['twitchId'] = $data['twitch']['id'];

        return (new User())->setRaw($user['data'])->map($map);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code'
        ]);
    }
}
