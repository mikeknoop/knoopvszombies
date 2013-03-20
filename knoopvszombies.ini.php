<?php

/* Muzombies Environment Configuration File */

  ini_set('display_errors',1);
  error_reporting(E_ALL|E_STRICT);

  /**
	 *  A string for what environment the script is executing in
	 *  dev/beta/prod -- not actually used anywhere in the source code
	 *  but I originally used this for some server enviornment config stuff
	 */
	define("ENV", "dev");
	
  /**
	 *  Directory location of this file, root of the application
	 *    eg:    /var/www/knoopvszombies/
	 */
	define("DOCUMENT_ROOT", "");
	
  /**
	 *  Domain of the application, used for creating HTML links, etc.
	 *    eg:   localhost or muzombies.org
	 */
	define("DOMAIN", "locahlhost");

  /**
	 *  Hostname of server
	 *    eg:    localhost or muzombies.org
	 */
	define("HOST", "muzombies.local");
	
  /**
	 *  Protocol for SSL. Used to write html links in a few places, can use this to force non ssl
	 *  	eg:    http or https
	 */
	define("HTTPS", "http");
	
  /**
	 *  Database name to use for the main game engine
	 */
	define("DATABASE", "knoopvszombies");

  /**
	 *  Database name to use for the forums
	 */
	define("FORUM_DATABASE", "knoopvszombies_forum");
	
  /**
	 *  Hostname of location for const DATABASE
	 */
	define("DATABASE_HOSTNAME", "localhost");

  /**
	 *  Database password for "Web" user
	 */
	define("DATABASE_PASS_FOR_WEB", "");
	
  /**
	 *  Database password for "cron" user (used when running cron jobs)
	 */
	define("DATABASE_PASS_FOR_CRON", "");
	
	/**
	 * Facebook application ID, get from facebook.org/developers
	 */
	define("FB_APP_ID", "");

	/**
	 * Facebook application API Key, get from facebook.org/developers
	 */
	define("FB_API_KEY", "");
	
  /**
	 * Facebook application secret (pairs with API Key), get from facebook.org/developers
	 */
	define("FB_SECRET", "");

  /**
	 * Facebook Page ID
	 */
	define("FB_PAGE_ID", "");

  /**
	 * Facebook Page Name
	 */
	define("FB_PAGE_NAME", "muzombies");

  /**
	 * Email Address 
	 */
	define("EMAIL", "mailer@localhost");
	
  /**
	 * Reply to address (emails send to EMAIL get forwarded to the reply to address)
	 */
	define("EMAIL_REPLY_TO", "admin@localhost");

  /**
	 * Archive Email Address
	 * a copy of all emails will be sent here
	 */
	define("ARCHIVE_EMAIL", "blackhole@localhost");
	
	/*
	 * Application Strings
	 * short abbreviation for the school or organization
	 */
	define("UNIVERSITY", "MU");

	/*
	 * Twitter Application keys
	 */
	define("TWITTER_CONSUMER_KEY", "");

	/*
	 * Twitter Application keys
	 */
	define("TWITTER_CONSUMER_SECRET", "");

	/*
	 * Twitter Account keys
	 */
	define("TWITTER_ACCESS_TOKEN", "");
	/*
	 * Twitter Account keys
	 */
	define("TWITTER_ACCESS_TOKEN_SECRET", "");
	
	/*
	 * Timezone setting
	 */
	date_default_timezone_set('America/Chicago');
	
	/*
	 * Game Logic Settings
	 * Maximum amount of seconds a zombie can survive without 
	 * feeding (marked deceased beyond this by CRON script)
	 */
	define("ZOMBIE_MAX_FEED_TIMER", 172800);  // 48 hours


?>