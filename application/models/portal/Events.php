<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Model 
{
	//
	// CalendarController->loadCalendars()
	//
	public function loadEvents()
	{
		$columns = [
			'a.id',
			'a.subject',
			'a.start_date',
			'a.start_time',
			'a.end_date',
			'a.end_time',
			'a.status',
			'a.type',
			'a.created_by',
			'a.created_date',
			'a.updated_by',
			'a.updated_date'
		];

		$this->db->select($columns);
		$this->db->from('events a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	//
	// EventController->addEvent()
	//
	public function addEvent($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('events',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	public function selectEvent()
	{

	}

	//
	// EventController->editEvent()
	//
	public function editEvent($arrData,$eventId)
	{
		try {
		  $this->db->trans_start();
		    $this->db->update('events',$arrData,['id'=>$eventId]);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

}