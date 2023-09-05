<?php

namespace App\Http\Controllers;

use App\Models\Admin;
class AdminController extends Controller {

    protected $_adminModel;

    public function __construct() {
        $this->_adminModel = new Admin;
        $this->middleware('can:isAdmin');
    }

    public function index() {
        return view('admin');
    }

}
