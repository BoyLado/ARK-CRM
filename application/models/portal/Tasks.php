<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Model 
{
	//
	// CalendarController->loadCalendars()
	//
	public function loadTasks()
	{
		$columns = [
			'a.id',
			'a.subject',
			'a.start_date',
			'a.start_time',
			'a.end_date',
			'a.end_time',
			'a.status',
			'a.created_by',
			'a.created_date',
			'a.updated_by',
			'a.updated_date'
		];

		$this->db->select($columns);
		$this->db->from('tasks a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	//
	// TaskController->addTask()
	//
	public function addTask($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('tasks',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

}