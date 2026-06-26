-- Create your custom database if it doesn't exist
CREATE DATABASE IF NOT EXISTS tomato;

-- Give your development user global administrative privileges
GRANT ALL PRIVILEGES ON *.* TO 'dev_user'@'%' WITH GRANT OPTION;

-- Apply the permission changes immediately
FLUSH PRIVILEGES;