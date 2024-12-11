<?php

return function($kirby, $pages, $page) {

    $alert = null;
    $contact = '###';

    if($kirby->request()->is('POST') && get('submit')) {

        // check the honeypot
        if(empty(get('website')) === false) {
            go($page->url());
            exit;
        }

        $data = [
            'email' => get('email'),
        ];

        $rules = [
            'email' => ['required', 'email'],
        ];

        $messages = [
            'email' => 'Please enter a valid email address',
        ];

        // some of the data is invalid
        if($invalid = invalid($data, $rules, $messages)) {
            $alert = $invalid;

            // the data is fine, let's send the email
        } else {
            try {
                $kirby->email([
                    'template' => 'email',
                    'from'     => $contact,
                    'replyTo'  => $contact,
                    'to'       => $data['email'],
                    'subject'  => 'Here are your results from the A–Gain Guide!',
                    'data'     => [
                        'text'   => 'Here comes a list of results',
                        'sender' => $contact,
                        'email' => esc($data['email'])
                    ]
                ]);

            } catch (Exception $error) {
                if(option('debug')):
                    $alert['error'] = 'The form could not be sent: <strong>' . $error->getMessage() . '</strong>';
                else:
                    $alert['error'] = 'The form could not be sent!';
                endif;
            }

            // no exception occurred, let's send a success message
            if (empty($alert) === true) {
                $success = 'Ok, sent!';
                $data = [];
            }
        }
    }

    return [
        'alert'   => $alert,
        'data'    => $data ?? false,
        'success' => $success ?? false
    ];
};