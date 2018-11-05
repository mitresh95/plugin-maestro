<?php

return [
    'name'        => 'Mautic Maestro Plugin',
    'description' => 'Maestro plugin',
    'version'     => '1.0',
    'author'      => 'Mitresh Pandya',

    'routes' => [
        'main' => [
            'mautic_maestro_index' => [
                'path'       => '/maestro',
                'controller' => 'MauticMaestroBundle:Monitoring:index',
            ],
        ],
    ],

    'services' => [
        'models' => [
            "mautic.maestro.model.maestro" => [
                'class' => \MauticPlugin\MauticMaestroBundle\Model\MaestroModel::class,
                'arguments' => [
                    'doctrine.orm.entity_manager'
                ],
            ]
        ],
        'events' => [
            // Register any event listeners
        ],
        'other' => [
            
        ],
    ],
];
