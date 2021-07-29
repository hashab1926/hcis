<?php
function getToken()
{
    return $_SESSION[sha1('hcis-master') . '_' . 'access_token'] ?? null;
}
