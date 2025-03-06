<?php 
	class User extends CI_Controller{

			public function __construct(){
				parent::__construct();
				$this->load->helper('url');
				$this->load->library('form_validation');
				$this->load->model('user_model');
				$this->load->database();
				$this->load->library('session');
			}
			
			public function signup(){
				$this->load->view('signup_form');
			}

			public function submit(){
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('firstname', 'First Name', 'required');
                $this->form_validation->set_rules('lastname', 'Last Name', 'required');
                $this->form_validation->set_rules('phone', 'Mobile Number', 'required|numeric');
                $this->form_validation->set_rules('username', 'User Name', 'required');
                $this->form_validation->set_rules('role', 'Role', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('pincode', 'Pin Code', 'required|numeric');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('officemaplink', 'Office Map Link', 'valid_url');
                $this->form_validation->set_rules('officenumber', 'Office Mobile Number', 'required|numeric');

				if($this->form_validation->run()==FALSE){
					$this->load->view('signup_form');
				}else{
					$data = array(
                        'Email'         => $this->input->post('email'),
                        'Firstname'     => $this->input->post('firstname'),
                        'Lastname'      => $this->input->post('lastname'),
                        'Phone'         => $this->input->post('phone'),
                        'Username'      => $this->input->post('username'),
                        'Password'    => $this->input->post('password'),
                        'Role'        => $this->input->post('role'),
                        'Address'       => $this->input->post('address'),
                        'Pincode'       => $this->input->post('pincode'),
                        'City'          => $this->input->post('city'),
                        'officemaplink' => $this->input->post('officemaplink'),
                        'Officenumber'  => $this->input->post('officenumber')
                    );
				
				
					$response = $this->user_model->store($data);
					if($response==true){
						echo "<script>
                        alert('✅Registration successful!');
                        window.location.href = '" . base_url('Regisationform') . "';
                      </script>";
					}else{
                        echo "<script>alert('❌Error in registration. Please try again.');</script>";
					}
				}
			}

			//Load login form here
			public function login(){			
				if($this->session->has_userdata('id')){
					redirect('user/home');
				}
				$this->load->view('login_form');
			}

			public function login_user(){
				$this->form_validation->set_rules('email','Email','required');
				$this->form_validation->set_rules('Password','Password','required');

				if($this->form_validation->run()==FALSE){
					$this->load->view('login_form');
				}else{
					$email = $this->input->post('email');
					$password = $this->input->post('Password');
					$this->load->database();
					$this->load->model('user_model');
					if($user = $this->user_model->getUser($email)){
						if($user->password==$password){
							
							$this->load->library('session');
							$this->session->set_userdata('id',$user->id);
							redirect('user/submit_suggestion');
                            echo "<script>alert('✅Login successful!');</script>";
							
						}else{
							echo "<script>alert('❌Login Error!');</script>";
						}
					}else{
						echo "<script>alert('❌No account exists with this email!');</script>";
					}
				}			
			}

			public function home(){
				$this->load->view('home');
			}

			public function logout(){
				$this->session->unset_userdata('id');
				redirect('user/login');
			}

			// public function change_password(){
			// 	if($this->session->has_userdata('id')){
			// 		$this->load->view('change_password_form');
			// 	}else{
			// 		redirect('user/login');
			// 	}
			// }

			// public function update_password(){
			// 	$this->form_validation->set_rules('old_password','Old Password','required');
			// 	$this->form_validation->set_rules('new_password','New Password','required');
			// 	$this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[new_password]');

			// 	if($this->form_validation->run()==FALSE){
			// 		$this->load->view('change_password_form');
			// 	}else{
			// 		$old_password = $this->input->post('old_password');
			// 		$new_password = $this->input->post('new_password');
				

			// 		if(strcmp($old_password,$new_password)==0){
			// 			$message = "New password should be a different password";
			// 		}else{

			// 			$id = $this->session->userdata('id');
			// 			if($this->user_model->oldPasswordMatches($id,$old_password)){
			// 				$this->user_model->changeUserPassword($id,$new_password);
			// 				$message = "Password changed successfully";
			// 			}else{
			// 				$message = "Your old Password is wrong!";
			// 			}
						
			// 		}
			// 	}
			// }

			// public function forgot_password(){
			// 	$this->load->view('forgot_password');
            // }
			// public function send_password(){
			// 	$this->form_validation->set_rules('email','Email','required');

			// 	if($this->form_validation->run()==FALSE){
			// 		$this->load->view('forgot_password');
			// 	}else{
			// 		$email  = $this->input->post('email');
			// 		if($user = $this->user_model->getUserByEmail($email)){
			// 			$to = $email;
			// 			$subject = "Password";
			// 			$message = "Your password is ".$user->password;
			// 			$headers = "From:contact@jvlcode.com\r\n";

			// 			mail($to,$subject,$message,$headers);

			// 			echo "Email has been sent!. Please check your inbox";
			// 		}else{
			// 			echo "No user with this email exist!";
			// 		}
			// 	}

			// }


			//Load suggestion form here
			public function suggestion_form() {
				$this->load->view('suggestion_form');
			}
			
			// Submit Suggestion
			public function submit_suggestion() {
				$username = $this->input->post('anonymous') ? NULL : $this->input->post('username');
		
				// Validate Input
				$this->form_validation->set_rules('application', 'Application', 'required');
				$this->form_validation->set_rules('suggestion_type', 'Suggestion Type', 'required');
				$this->form_validation->set_rules('message', 'Message', 'required');
		
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('error', validation_errors());
					redirect(base_url('user/suggestion_form'));
					return;
				}
		
				// Prepare Data
				$data = [
					'username' => $username,
					'application' => $this->input->post('application'),
					'suggestion_type' => $this->input->post('suggestion_type'),
					'message' => $this->input->post('message'),
					'voice_message_path' => $this->_upload_voice_message()
				];
		
				// Save Suggestion
				if ($this->user_model->save_suggestion($data)) {
					$this->session->set_flashdata('success', 'Suggestion submitted successfully!');
				} else {
					$this->session->set_flashdata('error', 'Failed to submit suggestion.');
				}
		
				redirect(base_url('user/suggestion_form'));
			}
		
			// Upload voice message if exists
			private function _upload_voice_message() {
				if (!empty($_FILES['voice_message']['name'])) {
					$config['upload_path'] = './uploads/';
					$config['allowed_types'] = 'mp3|wav';
					$config['max_size'] = 5000;
					$config['file_name'] = time() . '_' . $_FILES['voice_message']['name'];
		
					$this->upload->initialize($config);
		
					if ($this->upload->do_upload('voice_message')) {
						return 'uploads/' . $this->upload->data('file_name');
					}
				}
				return NULL;
			}
	}


?>