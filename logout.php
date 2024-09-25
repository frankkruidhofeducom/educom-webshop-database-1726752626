<?php

function doLogoutUser()
{
    session_unset();
    session_destroy();
    
}
