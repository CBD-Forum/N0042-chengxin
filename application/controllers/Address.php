<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Address extends CI_Controller {

	public function choose()
	{
        var_dump($_SERVER);
        $this->load->view("Address/choose.html");
	}

}
