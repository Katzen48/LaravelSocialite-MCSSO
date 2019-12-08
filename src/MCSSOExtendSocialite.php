<?php

namespace SocialiteProviders\MCSSO;

use SocialiteProviders\Manager\SocialiteWasCalled;

class MCSSOExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('mcsso', __NAMESPACE__.'\Provider');
    }
}
