<?php 
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(['form_validation', 'session']);
        $this->load->model('User_model');
        $this->load->database();
    }
    
    public function signup() {
        $this->load->view('signup_form');
    }

    public function submit() {
		$email = $this->input->post('email');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		$phone = $this->input->post('phone');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$role = $this->input->post('role');
		$address = $this->input->post('address');
		$pincode = $this->input->post('pincode');
		$city = $this->input->post('city');
		$officemaplink = $this->input->post('officemaplink');
		$officenumber = $this->input->post('officenumber');
	
		$errors = [];
	
		if (empty($email)) {
			$errors[] = 'Email field is required.';
		}
		if (empty($firstname)) {
			$errors[] = 'First Name field is required.';
		}
		if (empty($lastname)) {
			$errors[] = 'Last Name field is required.';
		}
		if (empty($phone)) {
			$errors[] = 'Mobile Number field is required.';
		}
		if (empty($username)) {
			$errors[] = 'User Name field is required.';
		}
		if (empty($password)) {
			$errors[] = 'Password field is required.';
		}
		if (empty($role)) {
			$errors[] = 'Role field is required.';
		}
		if (empty($address)) {
			$errors[] = 'Address field is required.';
		}
		if (empty($pincode)) {
			$errors[] = 'Pin Code field is required.';
		}
		if (empty($city)) {
			$errors[] = 'City field is required.';
		}
		if (empty($officemaplink)) {
			$errors[] = 'Office Map Link field is required.';
		}
		if (empty($officenumber)) {
			$errors[] = 'Office Mobile Number field is required.';
		}
	
		if (!empty($errors)) {
			foreach ($errors as $error) {
				echo "<script>alert('$error');</script>";
			}
			redirect('user/signup');
		}
	
		$data = [
			'Email' => $email,
			'Firstname' => $firstname,
			'Lastname' => $lastname,
			'Phone' => $phone,
			'Username' => $username,
			'Password' => password_hash($password, PASSWORD_DEFAULT),
			'Role' => $role,
			'Address' => $address,
			'Pincode' => $pincode,
			'City' => $city,
			'officemaplink' => $officemaplink,
			'Officenumber' => $officenumber
		];
	
		$response = $this->User_model->store($data);
		if ($response) {
			echo "<script>alert('Registration successful!');</script>";
			redirect('user/signup');
		} else {
			echo "<script>alert('Error in registration. Please try again.');</script>";
			redirect('user/signup');
		}
	}

    public function login() {
        if ($this->session->has_userdata('id')) redirect('user/suggestion_form');
        $this->load->view('login_form');
    }

    public function login_user() {
		$email = $this->input->post('email', true);
		$password = $this->input->post('password', true);
	
		$errors = [];
	
		if (empty($email)) {
			$errors['email'] = 'Email field is required.';
		}
		if (empty($password)) {
			$errors['password'] = 'Password field is required.';
		}
	
		if (!empty($errors)) {
			$this->session->set_flashdata('errors', $errors);
			redirect('user/login');
		}
	
		if ($user = $this->User_model->getUser($email)) {
			if (password_verify($password, $user->password)) {
				$this->session->set_userdata('id', $user->id);
				redirect('user/suggestion_form');
			} else {
				$this->session->set_flashdata('errors', ['password' => 'Incorrect password.']);
				redirect('user/login');
			}
		} else {
			$this->session->set_flashdata('errors', ['email' => 'No account exists with this email.']);
			redirect('user/login');
		}
	}
	

    // public function home() {
    //     $this->load->view('home');
    // }

    // public function logout() {
    //     $this->session->unset_userdata('id');
    //     redirect('user/login');
    // }

    public function suggestion_form() {
        $this->load->view('suggestion_form');
    }

    public function submit_suggestion() {
		$application = $this->input->post('application', true);
		$suggestion_type = $this->input->post('suggestion_type', true);
		$message = $this->input->post('message', true);
		$voice_message = $this->input->post('voice_message', true);
	
		$errors = [];
	
		if (empty($application)) {
			$errors[] = 'Application field is required.';
		}
		if (empty($suggestion_type)) {
			$errors[] = 'Suggestion type field is required.';
		}
		if (empty($message)) {
			$errors[] = 'Message field is required.';
		}
	
		if (!empty($errors)) {
			$this->session->set_flashdata('errors', $errors);
			redirect('user/suggestion_form');
		}
	
		$audio_filename = null;
		$audio_folder = FCPATH . 'application/audio/';
	
		if (!is_dir($audio_folder)) {
			if (!mkdir($audio_folder, 0777, true)) {
				$this->session->set_flashdata('errors', ['Failed to create audio folder.']);
				redirect('user/suggestion_form');
			}
		}
	
		if (!empty($voice_message)) {
			$audio_filename = 'audio_' . time() . '.wav';
			$audio_path = $audio_folder . $audio_filename;
	
			$decoded_audio = base64_decode($voice_message, true);
			if ($decoded_audio === false) {
				$this->session->set_flashdata('errors', ['Base64 decoding failed. Please check the provided audio data.']);
				redirect('user/suggestion_form');
			}
	
			if (file_put_contents($audio_path, $decoded_audio) === false) {
				$this->session->set_flashdata('errors', ['Failed to save the audio file. Please check file permissions.']);
				redirect('user/suggestion_form');
			}
		}
	
		$data = [
			'application' => $application,
			'suggestion_type' => $suggestion_type,
			'message' => $message,
			'voice_message' => $audio_filename
		];
	
		$inserted = $this->User_model->insert_suggestion($data);
	
		if ($inserted) {
			$this->session->set_flashdata('success', 'Suggestion submitted successfully.');
			redirect('user/suggestion_form');
		} else {
			$this->session->set_flashdata('errors', ['Failed to submit suggestion.']);
			redirect('user/suggestion_form');
		}
	}
}
?>