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
                'command' => 'if [ ! -d ".git" ]; then git clone ' . getenv('GIT_REPO_URL') . ' .; fi'
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
