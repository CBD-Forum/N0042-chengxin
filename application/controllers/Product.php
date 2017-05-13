<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
	}


    public function detail()
    {
        $this->load->view("Product/detail.html");
    }

}
