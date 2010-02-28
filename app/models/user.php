<?php

class User extends Model
{
  function register($username, $password, $email) {
    $this->db->select('id')->where('username', $username);
    $query = $this->db->get('users');
    if ($query->num_rows > 0) {
      return null;
    }

    $this->load->plugin('salt');
    $this->load->helper('date');

    $salt = salt();
    $now = mdate('%Y-%m-%d %H:%i:%s', time());
    $data = array(
      'username' => $username,
      'email' => $email,
      'password' => sha1("$password$salt"),
      'salt' => $salt,
      'registered_at' => $now,
      'current_login_at' => $now
    );
    $this->db->insert('users', $data);
    return $this->db->insert_id();
  }

  function isRegistered($username, $password) {
    $this->db->select('salt')->where('username', $username);
    $query = $this->db->get('users');
    if ($query->num_rows != 1) {
      return false;
    }

    $salt = $query->row()->salt;
    $this->db->select('id')->where('username', $username)->where('password', sha1("$password$salt"));
    $query = $this->db->get('users');
    return $query->num_rows == 1;
  }

  function markLogin($username) {
    $this->load->helper('date');

    $this->db->where('username', $username)->set('last_login_at', 'current_login_at', false)->update('users');

    $now = mdate('%Y-%m-%d %H:%i:%s', time());
    $this->db->where('username', $username)->update('users', array('current_login_at' => $now));

    return $this->findByUsername($username);
  }

  function findByUsername($username) {
    $query = $this->db->select('id, username, email')->where('username', $username)->get('users');
    if ($query->num_rows == 1) {
      $result = $query->result();
      return $result[0];
    }
    else {
      return null;
    }
  }

  function findById($id) {
    $columns = 'id, username, email, registered_at, current_login_at, last_login_at, updated_at';
    $query = $this->db->select($columns)->where('id', $id)->get('users');
    if ($query->num_rows == 1) {
      $result = $query->result();
      return $result[0];
    }
    else {
      return null;
    }
  }

  function update($userid, $email, $password = null) {
    $this->load->helper('date');
    $data = array('email' => $email, 'updated_at' => mdate('%Y-%m-%d %H:%i:%s', time()));
    if ($password != null) {
      $this->load->plugin('salt');
      $salt = salt();
      $data['salt'] = $salt;
      $data['password'] = sha1("$password$salt");
    }
    $this->db->where('id', $userid)->set($data)->update('users');
  }
}

