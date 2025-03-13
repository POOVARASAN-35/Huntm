<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebsiteController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('WebsiteModel'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library('session'); 
        $this->load->database(); 
    }

    public function index() {
        $data['users'] = $this->WebsiteModel->get_users();
        $data['errors'] = [];
        $this->load->view('add_website', $data);
    }

    public function store() {
        $data['users'] = $this->WebsiteModel->get_users();
        $data['errors'] = [];

        // Fetch input data
        $url = trim($this->input->post('url'));  
        $userId = trim($this->input->post('userId'));  
        $password = trim($this->input->post('password'));  
        $user_id = trim($this->input->post('user_id'));

        // Ensure URL has 'http://' or 'https://'
        if (!empty($url) && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }

        // Manual validation  
        if (empty($url)) {
            $data['errors']['url'] = 'Website URL is required.';  
        }
        if (empty($userId)) {
            $data['errors']['userId'] = 'Username is required.';  
        }
        if (empty($password)) {
            $data['errors']['password'] = 'Password is required.';  
        }
        if (empty($user_id)) {
            $data['errors']['user_id'] = 'Please select a user.';  
        }

        if (!empty($data['errors'])) {
            $this->load->view('add_website', $data);  
        } else {
            // Hash the password before storing it  
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare data for insertion  
            $insert_data = [
                'website_userId' => $userId,  // FIXED: Corrected variable name
                'website_password' => $hashed_password,  
                'website_url' => $url,  
                'user_id' => $user_id
            ];

            // Insert into database  
            if ($this->WebsiteModel->insert_website($insert_data)) {
                $this->session->set_flashdata('success', 'Website added successfully!');
                redirect('WebsiteController/dashboard');  
            } else {
                $this->session->set_flashdata('error', 'Failed to add website.');
                redirect('WebsiteController/index');
            }
        }
    }

    public function dashboard() {
        $data['websites'] = $this->WebsiteModel->get_all_websites();
        $this->load->view('dashboard_view', $data);
    }
    
}
?>
