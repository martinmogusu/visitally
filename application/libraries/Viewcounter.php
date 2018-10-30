<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Viewcounter{
	/**
	 * This library displays the tally of page views as well as other analytics related to page visits.
	 */

	public function __construct(){
	    $this->CI =& get_instance();
	}

	private function session_details(){
		/**
		 * Gets current session details, if session record non-existent in db, creates new session record first
		 */
		
		if($this->CI->session->userdata('session_id')){
			return $this->CI->session->all_userdata();
		} else {
			// This is a new session, save details in database
			$start_time = date('Y-m-d H:i:s');
			$data = array(
				'ip_address' => $this->CI->input->ip_address(),
				'start_time' => $start_time
			);

			$this->CI->db->insert('sessions', $data);
			$session_id = $this->CI->db->insert_id();
			$this->CI->session->set_userdata('session_id', $session_id);
			$this->CI->session->set_userdata('session_start_time', $start_time);
			return $this->CI->session->all_userdata();
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
		$request['ip_address'] = $this->CI->input->ip_address();
		$request['referrer'] = $this->CI->agent->referrer();
		$request['session_id'] = $this->session_details()['session_id'];
		$request['session_start_time'] = $this->session_details()['session_start_time'];

		return $request;
	}

	public function save_request(){
		/**
		 * Saves the request details to db
		 */
		
		$request = $this->request_details();
		$data = array(
			'agent' => $request['agent'],
			'agent_type' => $request['agent_type'],
			'ip_address' => $request['ip_address'],
			'referrer' => $request['referrer'],
			'session_id' => $request['session_id'],
		);

		$this->CI->db->insert('requests', $data);
	}

	public function requests(){
		/**
		 * Returns a list of all requests ever made to this site
		 */
		$query = $this->CI->db->get('requests');
		return $query->result();
	}

	public function request_summary(){
		/**
		 * Returns a summary of the requests made to this site
		 */
		$summary = [];
		$summary['total_requests'] = $this->CI->db->count_all('requests');
		$summary['total_sessions'] = $this->CI->db->count_all('sessions');
		$summary['unique_ip'] = $this->CI->db->select('count(id) as total')->group_by('ip_address')->get('requests')->num_rows();
		$summary['unique_browsers'] = $this->CI->db->select('count(*) as total')->group_by('agent')->get('requests')->num_rows();
		$summary['unique_referrers'] = $this->CI->db->select('count(*) as total')->group_by('referrer')->get('requests')->num_rows();
		
		return $summary;
	}

}

?>