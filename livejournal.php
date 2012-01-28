<?php

/*******************************************************************************
* 
* Newest LiveJournal Pictures
*
* A simple PHP script to see the newest photos 
* posted by LiveJournal users to their blogs.
* 
* Copyright (C) 2005 Matt West <matt at mattdanger dot net>
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* For a copy of the GNU General Public License visit <http://www.gnu.org/licenses/>.
*
*******************************************************************************/

// Needed to comply with LJ's bot policy
$referrer = 'http://somereferrer.com';
$email = 'someone@somereferrer.com'; 

if ($fp = fsockopen('livejournal.com', 80)) {

    fputs($fp, "GET /stats/latest-img.bml HTTP/1.0\r\n" .
            "Host: www.livejournal.com\r\n" .
            "User-Agent: " . $referrer . "; " . $email . "\r\n\r\n");

    $data = '';
    while(!feof($fp)) {
        $data .= fgets($fp);
    }

    fclose($fp);
    preg_match_all("<recent-image img=\'([^\']+)\' url=\'([^\']+)\' />", $data, $out);

    for ($i = 0; $i < $n; $i++) {

        echo '<a href="' . $out[2][$i] . '"><img border="0" src="' . $out[1][$i] . '" alt="" /></a><br /><br />' . "\n";

    }

} else {

	echo "Connecting to LiveJournal failed...";

}
?>