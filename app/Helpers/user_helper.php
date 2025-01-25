<?php

function get_user_auth()
{
  $userModel = new \App\Models\User();

  $user = session()->get("auth_login");

  if (!$user || !is_array($user)) {
    return 0;
  }

  $user = $userModel->where("id_user", $user["id"])->first();

  return $user;
}

function get_user_auth_role()
{
  $userModel = new \App\Models\User();

  $user = session()->get("auth_login");

  if (!$user || !is_array($user)) {
    return 0;
  }

  $user = $userModel->where("id_user", $user["id"])->first();

  return $user->id_role;
}
