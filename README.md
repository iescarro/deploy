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

After installation, this should copy ```deploy``` script, ```.env.deploy``` file and configuration in ```application/config/deploy.php```.

### Configuration

If you need to modify the contents of application/config/deploy.php, you can edit it

```
<?php

$deploy = array(
    'production' => array(
        'host' => getenv('DEPLOY_HOST'),
        'user' =>  getenv('DEPLOY_USER'),
        'key_path' => getenv('DEPLOY_SSH_KEY_PATH'),
        'port' => getenv('DEPLOY_PORT'),
        'tasks' => array(
            array(
                'name' => '',
                'command' => getenv('DEPLOY_TASK_CHANGE_DIR'),
            ),
            array(
                'name' => '',
                'command' => 'git pull'
            ),
            array(
                'name' => '',
                'command' => 'composer2 install'
            )
        )
    )
);
```

like adding a staging and testing deployment. Additionally you can configure more commands like removing ```composer.lock``` and other 
Linux commands you need to configure. Values are retrieved from .env so we can refer to .env.deploy for the names. Add it to
.env file and change the values to meet with your deployment. The ```.env.deploy``` is just for reference, we can copy those configurations 
in .env like so

```
# More configurations above from .env file

DEPLOY_HOST=server_ip_address
DEPLOY_PORT=server_port
DEPLOY_USER=your_user
DEPLOY_SSH_KEY_PATH=~/.ssh/id_rsa
DEPLOY_TASK_CHANGE_DIR=cd domains/some.com/public_html
```

### Deploy

We can easily deploy our project via

```
php deploy
# or php deploy stage for staging deployment
```

### Troubleshooting

- Ensure that the SSH key is correctly configured.
- Verify that the server has the necessary PHP extensions installed.
- Check the server logs for any errors during deployment.

### Additional Resources

- [Composer Documentation](https://getcomposer.org/doc/)
