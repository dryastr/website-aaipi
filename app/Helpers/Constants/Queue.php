<?php

namespace App\Helpers\Constants;

class Queue
{
    public const SEND_EMAIL = 'queue_website_website_send_email';

    public const SYNC_USER_LMS = 'queue_website_lms_sync_user';

    public const SYNC_USER_TS = 'queue_website_ts_sync_user';

    public const LOGOUT_LMS = 'queue_website_lms_logout';

    public const LOGOUT_TS = 'queue_website_ts_logout';
}
