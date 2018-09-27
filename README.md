# Project 6 Openclassrooms - ToDoList

## Parcours développeur d'application - PHP/Symfony 

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f7f72087878f44e899dcbd152b25cfcd)](https://www.codacy.com/app/HDoumali/Project8_ToDo-Co?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=HDoumali/Project8_ToDo-Co&amp;utm_campaign=Badge_Grade)

### Context 

This project was realized as part of my studies of application developer - PHP / Symfony.
Project 8 is an improvement to an existing Symfony application. It is a task management application.

To see the website code on github : https://github.com/HDoumali/Project8_ToDo-Co

### Project 

The objective of this project is to improve the quality of the application through the following tasks:

- The correction of anomalies
- Implementation of new features
- Achievement of unit and functional tests
- Quality and performance audit

### Information 

The project was developed with PHP7 and Symfony 3.4 framework.

It also uses:
- Bootstrap 3.3.7
- Google Font
- jQuery 1.12.4

### Installation

For the realization of the project, I used WAMP which you can download at the following address: www.wampserver.com.

Step 1 : Clone the Github repository : 
- https://github.com/HDoumali/Project8_ToDo-Co

Step 2 : In the project directory, return to your device and run the following command line : 
- composer install

Step 3  : Open the file app/Config/parameters and insert the following parameters :
- database_name: Enter your database name (project 6 bu default, you can choose name for the database)
- database_user: Enter your username for access to the mysql databse ("root" by default)
- database_password: Enter your password for access to the mysql database ("root" or "null" by default)

Step 4 : Creation of the database with the following commands :
- php bin/console doctrine:database:create
- php bin/console doctrine:schema:update --force

### Monitoring the qualité and performance of the application 

# Quality 

To ensure the quality of our application, we used the Codacy tool that allows us to review our code and monitor the quality of it

# Performance

In order to analyze the performance of the ToDoList application, we use the Blackfire tool that allows an analysis in the details of the application's performance.

# Test 

We used PHPUnit to perform the unit and functional tests of the application.

The test coverage report is available in web / test-coverage




