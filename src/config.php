<?php

// Parse PostgreSQL database URL 
$db_url = parse_url(getenv("DATABASE_URL"));

// Get database name from database URL
$db_url["path"] = ltrim($db_url["path"], "/");

// Define SSL mode for database URL
$db_url["sslmode"] = "require";


// Set up PostgreSQL connection variables

// Host name
$host = $db_url["host"];

// Username
$username = $db_url["user"];

// Password
$password = $db_url["pass"];

// Database name
$dbname = $db_url["path"];

// SSL
$ssl = $db_url["sslmode"]

?>