<?php

// Send the user to a page to give our app authorization to access their info.
get('authorize', 'HomeController@authorize');

// Once access has been granted, GitHub will direct them here...
get('github/login', 'HomeController@login');

