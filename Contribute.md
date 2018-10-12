# Project 6 Openclassrooms - ToDoList

## How to contribute to the project

### Fork the repository

Click on "fork" at the top right of the page

![alt tag](https://user.oc-static.com/upload/2016/09/19/14742902701046_fork_project.png)

### Clone the repository

- https://github.com/HDoumali/Project8_ToDo-Co.git

### Download project dependencies

- composer install 

### Creation and configuration of the database

- php bin/console doctrine:database:create
- php bin/console doctrine:schema:update --force

### Make your modifications

1) create a new branch

- git checkout -b my-new-feature

2) Commit 

- git commit -m "Commit message"

3) Send changes to the new branch

- git push origin my-new-feature

### Pull Request

Once your modifications have been sent to your GitHub fork, you have to send your change request by sending a pull request. 

To do this, go to your GitHub fork, on your new branch, and click on "Compare & pull request".

You will then be asked to write a message to present your proposal for changes to the author of the project.

the author of the project will consult your proposals, and you will receive a notification by GitHub when he / she integrates them or refuses them.

![alt tag](https://user.oc-static.com/upload/2016/09/19/14742929911757_PR.png)

### Quality process 

#### Respect PHP Standard Recommandations

- PSR-1 : Basic Coding Standard
- PSR-2 : Coding Style Guide 
- PSR-4 : Autoloading Standard

#### Quality

To ensure the quality of our application, we used the Codacy tool that allows us to review our code and control its quality.

#### Performance

To analyze the performance of the ToDoList application, we use the Blackfire tool to analyze the performance of the application.

#### Test

We used PHPUnit to perform the functional and functional tests of the application.

The test coverage report is available on the "web/test-coverage" folder


