<?php

$deploy = array(
    'production' => array(
        'host' => getenv('DEPLOY_HOST'),
        'user' =>  getenv('DEPLOY_USER'),
        'key_path' => getenv('DEPLOY_SSH_KEY_PATH'),
        'port' => 65002,
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
