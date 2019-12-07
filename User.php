<?php
/**
 * User: Katzen48
 * Date: 07.12.2019
 * Time: 22:47
 */

namespace SocialiteProviders\MCSSO;


use Carbon\Carbon;

class User extends SocialiteProviders\Manager\OAuth2\User
{
    /**
     * The Minecraft Uuid of the user
     *
     * @var string
     */
    public $uuid;

    /**
     * If the user was verified
     *
     * @var boolean
     */
    public $verified;

    /**
     * The Twitch id of the user
     *
     * @var string | null
     */
    public $twitchId;

    /**
     * The verification date
     *
     * @var Carbon | null
     */
    public $verified_at;

    /**
     * Get the Minecraft Uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * If the user was verified
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * Get the Twitch id
     *
     * @return string|null
     */
    public function getTwitchId()
    {
        return $this->twitchId;
    }

    /**
     * Get the verification date
     *
     * @return Carbon|null
     */
    public function getVerifiedAt()
    {
        return $this->verified_at;
    }
}
