<?php

use Nrg\Files\Action\File\UploadFileAction;
use Nrg\Files\Persistence\Abstraction\FileRepositoryInterface;
use Nrg\Files\Persistence\Repository\FlysystemFileRepository;

return [
    'routes' => [
        '/upload' => UploadFileAction::class,
    ],
    'services' => [
        FileRepositoryInterface::class => [
            FlysystemFileRepository::class,
            'uploadsPath' => __DIR__.'/uploads',
            'awsS3Config' => [
                'credentials' => [
                    'key' => 'AKIAJARQGZ32EWZEAQNQ',
                    'secret' => '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',
                ],
                'region' => 'us-east-1',
                'version' => 'latest',
            ],
            'bucket' => 'realtime-fun',
            'storageType' => 'local', // 'aws s3', 'local'(default)
        ],
    ],
];
