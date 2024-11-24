<?php

// Script for å populere databasen med studentbrukere
require_once '../account.php';


$dummy_users = [
    [
        'fname' => 'John',
        'lname' => 'Doe',
        'username' => 'johndoe',
        'email' => 'johndoe@example.com',
        'password' => 'password123'
    ],
    [
        'fname' => 'Jane',
        'lname' => 'Smith',
        'username' => 'janesmith',
        'email' => 'janesmith@example.com',
        'password' => 'securepass456'
    ],
    [
        'fname' => 'Alice',
        'lname' => 'Johnson',
        'username' => 'alicej',
        'email' => 'alicej@example.com',
        'password' => 'mysecret789'
    ],
    [
        'fname' => 'Bob',
        'lname' => 'Brown',
        'username' => 'bobbrown',
        'email' => 'bobbrown@example.com',
        'password' => 'passw0rd101'
    ],
    [
        'fname' => 'Charlie',
        'lname' => 'Davis',
        'username' => 'charlied',
        'email' => 'charlied@example.com',
        'password' => 'letmein202'
    ]
];

foreach($dummy_users as $dummy){
    $account = new Student();
    $account->setFirstName($dummy['fname']);
    $account->setLastName($dummy['lname']);
    $account->setUsername($dummy['username']);
    $account->setEmail($dummy['email']);
    $account->setPassword(password_hash($dummy['password'], PASSWORD_DEFAULT)); // Hashet passord
    $account->setRegDate(date('Y-m-d'));

    $account->createAccount();
}