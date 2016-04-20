# PHP-AJAX-Form
This form submits and validates each input field dynamically and passes the success message.
We use Ajax serialize json to send all data as a string. Once the string is page. the "mail.php" handler will check if all data is posted
and then split the string with the array.
Once you're done with the array, you'll be able to use a foreach to validate and sanitize all values. If the value finds an issue, it
will send it back with $error. 
