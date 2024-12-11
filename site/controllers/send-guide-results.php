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
            //'results' => null,
            'text' => 'foo',
            'name' => 'username'
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
                    'to'       => $data['email'],
                    'subject'  => 'A–Gain Guide Results',
                    'data'     => [
                        'text'   => esc($data['text']),
                        'sender' => esc($data['name']),
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
                $success = 'Your results have been sent.';
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