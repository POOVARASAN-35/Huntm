<?php 
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library(['form_validation', 'session']);
        $this->load->model('User_model'); //load model here
        $this->load->database();
    }
    
    public function signup() {
        $this->load->view('signup_form'); //this is my signup page view
    }

    public function submit() { 
        $data = $this->input->post();
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email address';
        }

        if (empty($data['firstname'])) {
            $errors['firstname'] = 'Firstname is required';
        }

        if (empty($data['lastname'])) {
            $errors['lastname'] = 'Lastname is required';
        }

        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone number is required';
        } elseif (!is_numeric($data['phone'])) {
            $errors['phone'] = 'Enter a valid phone number';
        }

        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Password must be at least 6 characters long';
        }

        if (empty($data['role'])) {
            $errors['role'] = 'Role is required';
        }

        if (empty($data['address'])) {
            $errors['address'] = 'Address is required';
        }

        if (empty($data['pincode'])) {
            $errors['pincode'] = 'Pincode is required';
        } elseif (!is_numeric($data['pincode'])) {
            $errors['pincode'] = 'Enter a valid Pincode';
        }

        if (empty($data['city'])) {
            $errors['city'] = 'City is required';
        }

        if (empty($data['officemaplink'])) {
            $errors['officemaplink'] = 'Office map link is required';
        }

        if (empty($data['officenumber'])) {
            $errors['officenumber'] = 'Office mobile number is required';
        } elseif (!is_numeric($data['officenumber'])) {
            $errors['officenumber'] = 'Enter a valid office mobile number';
        }

        if (!empty($errors)) {
            $this->session->set_flashdata('errors', $errors);
            $this->session->set_flashdata('old_data', $data);
            redirect('user/signup');
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $response = $this->User_model->store($data);

		if ($response) {
			echo "<script>alert('✅ Registration successful! Redirecting to login page...'); window.location.href = '" . base_url('user/login') . "';</script>";
			exit;
		} else {
			$this->session->set_flashdata('error', '❌ Error in registration. Please try again.');
			redirect('user/signup');
		}
    }

	//Login page 
    public function login() {
        $this->load->view('login_form');
    }

	public function login_user() {
		$this->load->model('User_model');
	
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
			$this->session->set_flashdata('email', $email);
			redirect('user/login');
		}
	
		$user = $this->User_model->getUser($email);
		
		if ($user) {
			if (password_verify($password, $user->Password)) {  
				$this->session->set_userdata('id', $user->id);
				echo "<script>
				alert('✅ Login successful!');
				window.location.href='" . base_url('user/suggestion_form') . "';
			  </script>";
		exit;
			} else {
				$errors['password'] = 'Incorrect password.';
				$this->session->set_flashdata('errors', $errors);
				redirect('user/login');
			}
		} else {
			$errors['email'] = 'No account exists with this email.';
			$this->session->set_flashdata('errors', $errors);
			redirect('user/login');
		}
	}
	
	//here suggestion page section
    public function suggestion_form() {
        $this->load->view('suggestion_form'); 
    }

	public function submit_suggestion() {
		$name = $this->input->post('name', true);
		$application = $this->input->post('application', true);
		$suggestion_type = $this->input->post('suggestion_type', true);
		$message = $this->input->post('message', true);
		$voice_message = $this->input->post('voice_message', true);
	
		$errors = [];

		//check validation of form
		if (empty($name)) {
			$errors['name'] = 'Name field is required.';
		}
		if (empty($application)) {
			$errors['application'] = 'Application field is required.';
		}
		if (empty($suggestion_type)) {
			$errors['suggestion_type'] = 'Suggestion type field is required.';
		}
		if (empty($message)) {
			$errors['message'] = 'Message field is required.';
		}
	
		if (!empty($errors)) {
			$this->session->set_flashdata('errors', $errors);
			redirect('user/suggestion_form');
		}
	
		$audio_filename = null;
		$audio_folder = FCPATH . 'application/assets/audio/'; // Audio folder path
	
		if (!is_dir($audio_folder)) {
			if (!mkdir($audio_folder, 0777, true)) {
				$this->session->set_flashdata('errors', ['Failed to create audio folder.']);
				redirect('user/suggestion_form');
			}
		}
	
		if (!empty($voice_message)) {
			$sanitized_name = preg_replace('/[^a-zA-Z0-9\s]/', '', $name); 
			$sanitized_name = preg_replace('/\s+/', '_', $sanitized_name); 
			$audio_filename = $sanitized_name . '.wav'; 
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
			'name' => $name,
			'application' => $application,
			'suggestion_type' => $suggestion_type,
			'message' => $message,
			'voice_message' => $audio_filename
		];
	
		$inserted = $this->User_model->insert_suggestion($data);
	
		if ($inserted) {
			$this->session->set_flashdata('success', '✅ Suggestion submitted successfully.');
			redirect('user/suggestion_form');
		} else {
			log_message('error', 'Database insertion failed: ' . print_r($this->db->error(), true));
			$this->session->set_flashdata('errors', ['Failed to submit suggestion.']);
			redirect('user/suggestion_form');
		}
	}	
}
?>