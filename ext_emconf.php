<?php

/*
 * This file is part of the composer package buepro/typo3-container-elements.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Background for container elements',
    'description'      => 'Provides posibility to add backgrounds to container content elements.',
    'category'         => 'misc',
    'version'          => '1.0.0-dev',
    'state'            => 'beta',
    'clearCacheOnLoad' => 1,
    'author'           => 'Andreas Sommer',
    'author_email'     => 'sommer@belsignum.com',
    'constraints'      => [
        'depends'   => [
            'typo3'                 => '11.5.1-12.99.99',
            'container'             => '2.2.0-2.99.99',
            'container_elements'    => '5.0.0-5.99.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Belsignum\\ContainerBackground\\' => 'Classes'
        ],
    ],
];
