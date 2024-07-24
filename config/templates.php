<?php

return [
    'page' => [
        'home' => [
            'body' => '',
            'alert' => '',
        ],
    ],
    'menu' => '
        <li><a href="{{home_page}}">Home</a></li>
        <li><a href="{{search_page}}">Search</a></li>
        <li><a href="{{organizations_page}}">Organizations</a></li>
        <li><a href="{{newlistings_page}}">Recent Listings</a></li>
    ',
    'footer' => '
        <span>IPE/Simulation Registry <br> &copy; 2024 Binghamton University |
            <a href="https://www.binghamton.edu" target="_blank" style="color:white;">Binghamton University</a>
        </span>
    ',
];
