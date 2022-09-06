<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendars extends CI_Model 
{
	/*
		CalendarController->loadCalendars()
	*/
	public function loadCalendars()
	{
		$columns = [
			'a.id',
			'a.calendar_name',
			'a.timezone',
			'a.created_by',
			'a.created_date',
			'a.updated_by',
			'a.updated_date'
		];

		$this->db->select($columns);
		$this->db->from('calendars a');
		$data = $this->db->get()->result_array();
    return $data;
	}

	/*
		CalendarController->addCalendar()
	*/
	public function addCalendar($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('calendars',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

}