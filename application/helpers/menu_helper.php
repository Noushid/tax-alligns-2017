<?php
/**
 * Created by PhpStorm.
 * User: psybo-03
 * Date: 9/2/17
 * Time: 5:04 PM
 */

function dashboard_menu()
{
    $menu = [
        'dashboard' => [
            'title' => 'dashboard',
            'icon' => 'fa-tachometer',
            'link' => 'dashboard'
        ],
        'users' => [
            'title' => 'users',
            'icon' => 'fa-users',
            'link' => 'users'
        ],
        'testimonial' => [
            'title' => 'testimonial',
            'icon' => 'fa-comments',
            'link' => 'testimonial'
        ],
        'blog' => [
            'title' => 'blog',
            'icon' => 'fa-picture-o',
            'link' => 'blog'
        ],
        'documents' => [
            'title' => 'documents',
            'icon' => 'fa-file',
            'link' => 'documents'
        ],
        'messages' => [
            'title' => 'messages',
            'icon' => 'fa-envelope',
            'link' => 'messages'
        ],
        'excel template' => [
            'title' => 'excel template',
            'icon' => 'fa-file-text',
            'link' => 'doc-template'
        ]
    ];

    $html = '<div class="sidebar-collapse">' . PHP_EOL .
            '<ul class="nav" id="main-menu">';
    foreach ($menu as $key => $value) {
//        $html .= '<li><a href="' . base_url('admin/#'.$value['link']) . '" ng-class="{active : url == \'' . $value['link'] . '\'}"> '.ucfirst($value['title']).' &nbsp;<i class="menu-icon fa '.$value['icon'].' pull-right"></i></a></li>';
        $html .= '<li>' .
            '<a ng-class="{\'active-menu\' : url == \'' . $value['link'] . '\'}" href="' . base_url('dashboard/#' . $value['link']) . '"><i class="fa ' . $value['icon'] . '"></i> ' . ucfirst($value['title']) . '</a>' . PHP_EOL .
            '</li>';
    }

    $html .= '</ul>' . PHP_EOL .
        '</div>' . PHP_EOL .
        '</nav>';

    return $html;
}

function menu($current)
{
    $menu = [
        'Home' => [
            'title' => 'Home',
            'icon' => '',
            'link' => 'home'
        ],
        'About me' => [
            'title' => 'About me',
            'icon' => '',
            'link' => 'about'
        ],
        // 'Videos' => [
        //     'title' => 'Videos',
        //     'icon' => '',
        //     'link' => 'videos'
        // ],
        // 'Polish Yourself' => [
        //     'title' => 'Polish Yourself',
        //     'icon' => '',
        //     'link' => 'PolishYourself'
        // ],
        // 'Writing Wizard' => [
        //     'title' => 'Writing Wizard',
        //     'icon' => '',
        //     'link' => 'WritingWizard'
        // ],
        'My Services' => [
            'title' => 'My Services',
            'icon' => '',
            'link' => 'My Services',
            'sub' => [
                'Polish Yourself' => [
                    'title' => 'Polish Yourself',
                    'icon' => '',
                    'link' => 'PolishYourself'
                ],
                'Writing Wizard' => [
                    'title' => 'Writing Wizard',
                    'icon' => '',
                    'link' => 'WritingWizard'
                ],
                'Worksheets' => [
                    'title' => 'Worksheets',
                    'icon' => '',
                    'link' => 'worksheets'
                ],
                'Videos' => [
                    'title' => 'Videos',
                    'icon' => '',
                    'link' => 'videos'
                ]
            ]
        ],
        // 'Worksheets' => [
        //     'title' => 'Worksheets',
        //     'icon' => '',
        //     'link' => 'worksheets',
        // ],
        'Anchoring' => [
            'title' => 'Anchoring',
            'icon' => '',
            'link' => 'Anchoring'
        ],
        'Moments' => [
            'title' => 'Moments',
            'icon' => '',
            'link' => 'moments'
        ],
        'Contact' => [
            'title' => 'Contact',
            'icon' => '',
            'link' => 'contact'
        ]
    ];

    $html = '';
    foreach ($menu as $key=>$value) {
        if (isset($value['sub'])) {
            $html .= '<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $key . '</a>' . PHP_EOL . '
                        <ul class="dropdown-menu">' . PHP_EOL . '
                            <li><a href="PolishYourself">Polish Yourself</a></li>' . PHP_EOL . '
                            <li><a href="WritingWizard">Writing Wizard</a></li>' . PHP_EOL . '
                            <li><a href="worksheets">Worksheets</a></li>' . PHP_EOL . '
                            <li><a href="videos">My Videos</a></li>' . PHP_EOL . '
                        </ul>' . PHP_EOL . '
                    </li>';
        }else{
            if ($key == $current) {
                $html .= '<li class="active"><a href="' . base_url($value['link']) . '">' . $key . '</a></li>' . PHP_EOL;
            }else{
                $html .= '<li><a href="' . base_url($value['link']) . '">' . $key . '</a></li>' . PHP_EOL;
            }
        }

    }
    return $html;
}
