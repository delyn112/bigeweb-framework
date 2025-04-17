# Model, View And Controller (MVC) by bigeweb Solution.


## A full php project developed from scratch. This is similar with other mvc project. of course, will be slightly different from each other.

Generally, the MVC (Model-View-Controller) framework is a software architectural pattern commonly used in web development to organize code and separate concerns. Here's a brief description of each component:

Model: The model represents the data and business logic of the application. It interacts with the database, processes data, and contains the application's core logic. In an MVC framework, the model is responsible for managing data and ensuring its integrity.
View: The view is responsible for presenting the user interface of the application to the users. It receives data from the controller and renders it into a format that users can interact with, such as HTML, XML, or JSON. Views are typically separated from the application logic to promote code reusability and maintainability.
Controller: The controller acts as an intermediary between the model and the view. It receives user input from the view, processes it, and interacts with the model to retrieve or update data. The controller then passes the updated data to the view for display to the user. Controllers in MVC frameworks handle routing requests, invoking appropriate actions, and managing the application's flow.
In summary, the MVC framework provides a structured approach to developing web applications by separating the application's concerns into three distinct components: model, view, and controller. This separation of concerns promotes code organization, maintainability, and scalability, making it easier to manage and extend the application over time.

In this MVC, the most important feature includes
* The router: this help us to generate the url and make it user friendly.
* The view: This helps to display the html.
* The controllers.
* Facades and many more.


## How to install this project.
The first step to take in installing this project is to 
run `composer install bigeweb\framework`
This will download the full project in your working directory.

To open your first url, open your terminal and type `php -S localhost:8000 -t public`
Alternatively you can use `php -S 127.0.0.1:8000 -t public`. This will start a new server and provide
you with the appropriate url. Copy the url and paste it in your browser.

To make changes to the view open the resources' directory. Create a new file or add anything.
To make changes to the routes. Create a new file and give it any name you want. This will be automatically
added to the route list.

More information and updates will be available soon.