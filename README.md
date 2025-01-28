## DeployPHP

### Prerequisites

- PHP installed on the server
- SSH access to the server
- Composer installed

### Installation

```
composer require iescarro/deploy
php vendor/iescarro/deploy/install
```

After installation, this should copy ```deploy``` script and configuration in 
application/config/deploy.php.

### Configuration

1. **Create a `deploy.php` configuration file:**
    ```php
    <?php

    return [
        'repository' => getenv('DEPLOY_REPOSITORY'),
        'branch' => getenv('DEPLOY_BRANCH'),
        'server' => getenv('DEPLOY_SERVER'),
        'username' => getenv('DEPLOY_USERNAME'),
        'path' => getenv('DEPLOY_PATH'),
    ];
    ```

2. **Add the deployment configuration to your `.env` file:**
    ```
    DEPLOY_REPOSITORY=git@github.com:yourusername/yourrepository.git
    DEPLOY_BRANCH=main
    DEPLOY_SERVER=server_ip
    DEPLOY_USERNAME=username
    DEPLOY_PATH=/path/to/your/project
    ```

3. **Create a deployment script (`deploy.php`):**
    ```php
    <?php

    $config = include 'config/deploy.php';

    $commands = [
        "ssh {$config['username']}@{$config['server']} 'cd {$config['path']} && git pull origin {$config['branch']}'",
        "ssh {$config['username']}@{$config['server']} 'cd {$config['path']} && composer install'",
        "ssh {$config['username']}@{$config['server']} 'cd {$config['path']} && chmod -R 775 storage bootstrap/cache'",
        "ssh {$config['username']}@{$config['server']} 'cd {$config['path']} && php artisan migrate'",
        "ssh {$config['username']}@{$config['server']} 'cd {$config['path']} && php artisan config:cache'",
        "ssh {$config['username']}@{$config['server']} 'sudo service apache2 restart'",
    ];

    foreach ($commands as $command) {
        echo "Executing: $command\n";
        system($command);
    }
    ```

4. **Run the deployment script:**
    ```sh
    php deploy.php
    ```

### Steps

1. **Connect to the server via SSH:**
    ```sh
    ssh username@server_ip
    ```

2. **Navigate to the project directory:**
    ```sh
    cd /path/to/your/project
    ```

3. **Pull the latest changes from the repository:**
    ```sh
    git pull origin main
    ```

4. **Install PHP dependencies using Composer:**
    ```sh
    composer install
    ```

5. **Set the correct permissions for the storage and cache directories:**
    ```sh
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    ```

6. **Run database migrations:**
    ```sh
    php artisan migrate
    ```

7. **Clear and cache the configuration:**
    ```sh
    php artisan config:cache
    ```

8. **Restart the web server (if necessary):**
    ```sh
    sudo service apache2 restart
    ```

### Troubleshooting

- Ensure that the SSH key is correctly configured.
- Verify that the server has the necessary PHP extensions installed.
- Check the server logs for any errors during deployment.

### Additional Resources

- [Composer Documentation](https://getcomposer.org/doc/)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)