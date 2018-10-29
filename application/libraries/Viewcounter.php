<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewcounter{
	/**
	 * This library displays the tally of page views as well as other analytics related to page visits.
	 */

	public function __construct(){
	    $this->CI =& get_instance();
	}

	private function get_session_id(){
		/**
		 * Gets id of current session, if non-existent creates new session first, then returns its id
		 */
		if($this->session->userdata('session_id')){
			return $this->session->userdata('sesion_id');
		} else {
			// This is a new session, save details in database
			$data = ['start_time' => date('Y-m-d H:i:s')];
			$this->CI->db->insert('sessions', $data);
			$session_id = $this->CI->db->insert_id();
			$this->session->userdata('session_id') = $session_id;
			return $session_id;
		}
	}

	public function request_details(){
		/**
		 * Gets the details of a request from request headers
		 * Returns an array of request details for the current request
		 */
		
		if ($this->CI->agent->is_browser())
		{
		        $agent = $this->CI->agent->browser();
		        $agent_type = 'browser';
		}
		elseif ($this->CI->agent->is_robot())
		{
		        $agent = $this->CI->agent->robot();
		        $agent_type = 'robot';
		}
		elseif ($this->CI->agent->is_mobile())
		{
		        $agent = $this->CI->agent->mobile();
		        $agent_type = 'mobile';
		}
		else
		{
		        $agent = 'Other';
		        $agent_type = 'other';
	    }

		$request['agent'] = $agent;
		$request['agent_type'] = $agent_type;
		$request['ip_address'] = $this->CI->input->ip_address;
		$request['referrer'] = $this->CI->agent->referrer();
		$request['session_id'] = $this->get_session_id();

		return $request;
	}

	public function save_request(){
		/**
		 * Saves the request details to db
		 */
		
		$request = $this->request_details();

		$this->db->insert('requests', $request);
	}

	public function get_requests(){
		/**
		 * Returns a list of all requests ever made to this site
		 */
		$query = $this->db->get('requests');
		return $query->result();
	}

	public function request_summary(){
		/**
		 * Returns a summary of the requests made to this site
		 */
		$summary = [];
		$summary['total_requests'] = $this->db->count_all('requests');
		$summary['total_sessions'] = $this->db->count_all('sessions');
		
		return $summary;
	}

}

?>