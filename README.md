# globalPrice

PHP 설치 <br>
Composer 설치 <br>
Codeigniter 설치 <br>
- composer init
- composer create-project codeigniter4/appstarter 프로젝트명

php extension 추가 확장
- openssl
- mbstring
- intl
- gd2
- fileinfo
- ftp
- curl
- mysqli
- calendar
- gettext
- iconv
- json
- phar
- sockets
- tokenizer
- zip
- bz2
- exif

nginx 세팅

server {

		listen		127.0.0.1:81	default_server;		# Do Not Change ! Security Risk !
		#listen		[::1]:80	ipv6only=on;		# Do Not Change ! Security Risk !
		server_name	localhost;				# Do Not Change ! Security Risk !

		# This directive is modified automatically by WinNMP.exe for portability.
		root		"path";
		autoindex on;

		index       index.php;
		allow		127.0.0.1;	# Do Not Change ! Security Risk !
		allow		::1;		# Do Not Change ! Security Risk !
		deny		all;		# Do Not Change ! Security Risk !

		## deny access to .htaccess files, if Apache's document root concurs with nginx's one
		location / {
        # Check if a file or directory index file exists, else route it to index.php.
        	try_files $uri $uri/ /index.php;
        }

		location ~ /\.ht {
			deny  all;
		}

		location = /favicon.ico {
				log_not_found off; 
		}
		location = /robots.txt {
				log_not_found off; 
		}


		## Tools are now served from include/tools/
		location ~ ^/tools/.*\.php$ {					
			root "c:/winnmp/include";
			try_files $uri =404; 
			include		nginx.fastcgi.conf;
			fastcgi_pass	php_farm;
			allow		127.0.0.1;		# Do Not Change ! Security Risk !
			allow		::1;			# Do Not Change ! Security Risk !
			deny		all;			# Do Not Change ! Security Risk !
		}
		location ~ ^/tools/ {
			root "c:/winnmp/include";
			allow		127.0.0.1;		# Do Not Change ! Security Risk !
			allow		::1;			# Do Not Change ! Security Risk !
			deny		all;			# Do Not Change ! Security Risk !
		}


		## How to add phpMyAdmin 
		## Copy phpMyAdmin files to c:/winnmp/include/phpMyAdmin then uncomment:

		#location ~ ^/phpMyAdmin/.*\.php$ {
		#	root "c:/winnmp/include";
		#	try_files $uri =404; 
		#	include         nginx.fastcgi.conf;
		#	fastcgi_pass    php_farm;
		#	allow           127.0.0.1;  
		#	allow           ::1;
		#	deny            all;
		#}       
		#location ~ ^/phpMyAdmin/ {
		#	root "c:/winnmp/include";
		#}

		## Notice that the root directive lacks /phpMyAdmin because Nginx adds the URL path /phpMyAdmin to the root path, so the resulting directory is c:/winnmp/include/phpMyAdmin
		

		## PHP for localhost ##
		#######################

		location ~ \.php$ {
			try_files $uri =404; 
			include		nginx.fastcgi.conf;
			include		nginx.redis.conf;
			fastcgi_pass	php_farm;
			allow		127.0.0.1;		# Do Not Change ! Security Risk !
			allow		::1;			# Do Not Change ! Security Risk !
			deny		all;			# Do Not Change ! Security Risk !
	        }

		# How to allow access from LAN and Internet to your local project:
		# http://WinNMP.wtriple.com/howtos.php#How-to-allow-access-from-LAN-and-Internet-to-your-local-project



	}
