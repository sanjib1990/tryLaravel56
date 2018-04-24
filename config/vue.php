<?php

return [
    'config_url' => env('CONFIG_URL', ''),
    'sessionkey' => env('VUE_SESSION_KEY', 'vue_session_key'),
    'auth_use_package' => false,
    'auth_modes' => ['JWT']
];
