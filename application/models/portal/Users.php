<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model 
{
	// IndexController->signUp();
	public function signUp($arrData, $whereParams)
	{
		try {
		  $this->db->trans_start();
		  	$this->db->where($whereParams);
		    $this->db->update('users',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? $this->db->affected_rows() : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	// UserController->inviteNewUser();
	public function inviteNewUser($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('users',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	// UserController->loadUsers();
	// UserController->loadPendingInvites();
	public function loadUsers($whereParams)
	{
		$columns = [
			'id as user_id',
			'salutation',
			'first_name',
			'last_name',
			'user_email',
			'user_status'
		];

		$this->db->where($whereParams);
		$this->db->select($columns);
		$this->db->from('users');
		$data = $this->db->get()->result_array();
		return $data;
	}

	public function test($arrData)
	{
		try {
		  $this->db->trans_start();
		    $this->db->insert('users',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	// IndexController->login();
	public function validateLogIn($logInRequirements)
	{
    $columns = [
      'id as user_id',
      'first_name',
      'last_name'
    ];

    $this->db->where($logInRequirements);
    $this->db->select($columns);
    $this->db->from('users');
    $data = $this->db->get()->row_array();
    return $data;
	}

	// IndexController->forgotPassword();
	public function createPasswordAuthCode($arrData, $emailReceiver)
	{
		try {
		  $this->db->trans_start();
		  	$this->db->where('user_email',$emailReceiver);
		    $this->db->update('users',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	// IndexController->changePassword()
	public function changePassword($arrData, $whereParams)
	{
		try {
		  $this->db->trans_start();
		  	$this->db->where($whereParams);
		    $this->db->update('users',$arrData);
		  $this->db->trans_complete();
		  return ($this->db->trans_status() === TRUE)? 1 : 0;
		} catch (PDOException $e) {
		  throw $e;
		}
	}

	// IndexController->forgotPassword();
	// UserController->inviteNewUser();
	public function loadUser($whereParams)
	{
		$columns = [
		  'id as user_id',
		  'first_name',
		  'last_name',
		  'user_auth_code',
		  'password_auth_code'
		];

		$this->db->where($whereParams);
		$this->db->select($columns);
		$this->db->from('users');
		$data = $this->db->get()->row_array();
		return $data;
	}

}