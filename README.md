# web-arriendo-facil

## Development environments
The following steps guieds how to add this to your local nginx servers.
### MacOS
Requirements:
- Homebrew
- PHP 8+
- Mysql
- Niginx

**Installation**
1. Install PHP with `brew install php`
2. Start PHP with `brew services start php`
3. Install Mysql with `brew install mysql`
4. Start Mysql with `brew services start mysql`
5. Install nginx with `brew install nginx`
6. Start nginx with `brew services start nginx`

**Configuration:**
- Go to `/opt/homebrew/etc/nginx/servers/`
- Create the `arriendo-facil.conf` file.
- Add the following lines to your `/etc/hosts` file:
```
127.0.0.1 arriendofacil.local
```
- Add the next configuration lines.
```nginx
server {
  listen 80;
  server_name arriendofacil.local;
  root /path/to/your/web-arriendo-facil/;

  index index.php index.html index.htm;

  # Log files
  access_log /opt/homebrew/var/log/nginx/arriendo-facil.access.log;
  error_log /opt/homebrew/var/log/nginx/arriendo-facil.error.log;

  # Standard WordPress location handling and rewrite rules
  location / {
    try_files $uri $uri/ /index.php?$args;
  }

  # Pass PHP scripts to PHP-FPM (using a Unix socket is often recommended on Mac/Linux)
  location ~ \.php$ {
    # Check if the file exists before processing
    try_files $uri =404;

    # Use the socket path for PHP-FPM, check your PHP-FPM installation for the correct path
    # Common paths: /opt/homebrew/var/run/php-fpm.sock or /usr/local/opt/homebrew/var/run/php-fpm.pid (check your specific setup)
    fastcgi_pass 127.0.0.1:9000;
    # If using a socket file (e.g., /path/to/file/php-fpm.sock), use:
    # fastcgi_pass unix:/path/to/file/php-fpm.sock;

    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param HTTP_X_FORWARDED_FOR $remote_addr; # Useful for correct IP logging
  }

  # Deny access to hidden files (like .htaccess or .DS_Store on Mac)
  location ~ /\. {
    deny all;
  }

  # Optional: Enable browser caching for static assets
  location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
    expires 30d;
    log_not_found off;
  }
}
``` 
- Access to http://arriendofacil.local in your browser to see the project running.
