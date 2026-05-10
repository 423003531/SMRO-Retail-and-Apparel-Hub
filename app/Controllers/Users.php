<?php

namespace App\Controllers;

use App\Models\ApplicationModel;

class Users extends BaseController
{
    public function index()
    {
        // 1. Instantiate the model
        $applicationModel = new ApplicationModel();

        // 2. Grab all users from the database using the method we verified earlier
        $usersList = $applicationModel->getUser();

        // 3. Package the data to send to the View
        $data = array_merge($this->data ?? [], [
            'title' => 'User Management',
            'users' => $usersList
        ]);

        // 4. Load the view (We will check if this exists in the next step)
        return view('pages/users/index', $data);
    }
}