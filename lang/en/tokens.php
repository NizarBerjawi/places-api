<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Personal Access Token Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for tokens for various messages
    | that we need to display to the user.
    |
    */
    'index' => '<span class="has-text-weight-bold">Personal access tokens function like ordinary OAuth access tokens.</span> They can be used to authenticate to the API over Basic Authentication.',
    'expiry' => 'If you don\'t set an expiration date, your token will never expire.',
    'delete' => 'You are permenantly deleting this API access token. Any scripts or applications using this token will stop working. <div class="has-text-weight-bold block">This action is irreversible!</div>',
    'regenerate' => 'If you\'ve lost or forgotten this token, you can regenerate it, but be aware that any scripts or applications using this token will need to be updated.<span class="has-text-weight-bold block">This action is irreversible!</span><div class="mt-2 has-text-weight-bold block">Your expiry for this token will remain the same.</div>',
    'edit' => 'To set a new expiration date, you must <a class="has-text-weight-bold" href=":regenerateLink">regenerate</a> the token.',
    'copy' => 'Make sure to copy your personal access token now. <span class="has-text-weight-bold">You won\'t be able to see it again!</span>',
];
