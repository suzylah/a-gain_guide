<?php

return function($kirby, $pages, $page) {

    $alert = null;
    $id = null;

    if($kirby->request()->is('POST')) {

        try {

            $lastId = Db::max('ReuseQueries', 'id');

            $id = Db::insert('ReuseQueries', [
                'id'        => $lastId + 1,
                'userlang'  => ISSET($_POST['lang']) ? $_POST['lang'] : NULL,
                'product'   => ISSET($_POST['product']) ? implode(',',$_POST['product']) : NULL,
                'material'  => ISSET($_POST['material']) ? implode(',',$_POST['material']) : NULL,
                'amount'    => ISSET($_POST['amount']) ? $_POST['amount'] : NULL,
                'amount_unit' => ISSET($_POST['amount_unit']) ? $_POST['amount_unit'] : NULL,
                'origin'    => ISSET($_POST['origin']) ? implode(',', $_POST['origin']) : NULL,
                'size'      => ISSET($_POST['size']) ? implode(',', $_POST['size']) : NULL,
                'condition' => ISSET($_POST['condition']) ? $_POST['condition'] : NULL,
                'problem'   => ISSET($_POST['problem']) ? implode(',',$_POST['problem']): NULL,
                'serviceType' => ISSET($_POST['serviceType']) ? implode(',',$_POST['serviceType']) : NULL,
                're_style_my_wardrobe' => ISSET($_POST['re_style_my_wardrobe']) ? implode(',',$_POST['re_style_my_wardrobe']) : NULL,
                'repair' => ISSET($_POST['repair']) ? implode(',',$_POST['repair']) : NULL,
                'upcycle' => ISSET($_POST['upcycle']) ? implode(',',$_POST['upcycle']): NULL,
                'sell' => ISSET($_POST['sell']) ? implode(',',$_POST['sell']): NULL,
                'swap' => ISSET($_POST['swap']) ? implode(',',$_POST['swap']): NULL,
                'donate' => ISSET($_POST['donate']) ? implode(',',$_POST['donate']): NULL,
                'location' => ISSET($_POST['location']) ? $_POST['location']: NULL,
                'age' => ISSET($_POST['age']) ? $_POST['age'] : NULL,
                'budget' => ISSET($_POST['budget']) ? $_POST['budget']: NULL,
                'gender' => ISSET($_POST['gender']) ? $_POST['gender']: NULL,
                'occupation' => ISSET($_POST['occupation']) ? $_POST['occupation']: NULL,
                'habits' => ISSET($_POST['habits']) ? implode(',',$_POST['habits']): NULL,
                'frequency' => ISSET($_POST['frequency']) ? $_POST['frequency']: NULL,
                'source' => ISSET($_POST['source']) ? $_POST['source']: NULL,
                'interests' => ISSET($_POST['interests']) ? implode(',',$_POST['interests']): NULL,
            ]);

        } catch (Exception $error) {
            if(option('debug')):
                $alert['error'] = 'The data could not be saved: <strong>' . $error->getMessage() . '</strong>';
            else:
                $alert['error'] = 'The data could not be saved!';
            endif;
        }

        if (empty($alert) === true) {
            $success = 'Data saved successfully';
        }
        
    }

    return [
        'alert'   => $alert,
        'success' => $success ?? false,
        'id'      => $id
    ];
};