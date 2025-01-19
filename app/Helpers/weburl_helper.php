<?php

function admin_url($uri = null)
{
  return base_url('/web/admin/' . $uri);
}

function teacher_url($uri = null)
{
  return base_url('/web/teacher/' . $uri);
}
