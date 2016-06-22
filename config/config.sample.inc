 <?php
 /**
  * LOCAL Development settings for WebServerMonitor
  */
 
 // Update
putenv("MAX_LOAD=1");
putenv("MAX_CHILDREN=1");
putenv("TIME_LIMIT=1");
  
putenv("DB_CONFIG_HOST=localhost");
putenv("DB_CONFIG_USER=bla");
putenv("DB_CONFIG_PASSWORD=bla");
putenv("DB_CONFIG_DATABASE=bladatabase");

// optional
putenv("DB_CONFIG_FETCHMODE=\PDO::FETCH_ASSOC");
putenv("DB_CONFIG_CHARSET=utf8");
putenv("DB_CONFIG_PORT=1234");
putenv("DB_CONFIG_UNIXSOCKET=");
