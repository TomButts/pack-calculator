# Pack Calculator

This is my answer to the 'Brucies Banana Bazaar' question where optimum packs must be calculated to provide a guide for fulfilling banana orders.

The problem stated firstly that packs could not be broken up. The number of bananas in delivered packs had to be greater than or equal to the number of bananas ordered. The primary goal was to deliver as few extra bananas as possible. A secondary goal was to deliver the minimum number of packs required while also delivering the least extra bananas. The examples implied packs can be used as many times as possible each with no limit.

This application built on Yii2 contains logic to suggest banana pack amount. Models, views and controllers that were required to display the calculations. The application also contains unit tests relating to the main algorithm.

## Pack Algorithm

Initially a method similar to the ‘greedy’ method [here](https://en.wikipedia.org/wiki/Change-making_problem) was used. This worked for the pack sizes given in the example. However during unit testing it was discovered this approach would not work for some other sizes. As the question stated to make the code extendable other options were researched. After some research a similar mathematical problem was found called [the coin change problem](https://en.wikipedia.org/wiki/Change-making_problem).

The coin change problem attempts to calculate the total number of coin combinations required in order to sum to an arbitrary amount. This problem is commonly solved using dynamic or recursive programming. A recursive solution to this problem was adapted to use conditions relevant to the question. Optimisations included using elements of the greedy algorithm, reversing available pack order and not checking permutations were applied. Unit tests run in almost no time for the project even on quite large numbers. 

It was decided to create a class around this combination solving algorithm. A static helper method approach was also considered. A class allows the solver to be a [dependency](https://en.wikipedia.org/wiki/Dependency_inversion_principle) of other functions. An interface was also added in order to allow interoperability and type hinting. The class also allows other important quantities to be tracked such as the value of the best sum and alternative combinations that are equally valid as an answer. Finally separating this algoirthm into a generic solver class comforms to the [single responsibility principle](https://en.wikipedia.org/wiki/Single_responsibility_principle).

## Application

The application was created using Yii2. This is the first time I have used Yii2 and I enjoyed learning about it. Overall however not much time was spent on the application structure of this project. 

The following list describes the main elements of developing this application.
* [PSR 2](https://www.php-fig.org/psr/psr-2/) coding standards were used for all PHP code written.
* The MVC pattern was used for packs and orders although a limited number of actions were required to answer the question. It was decided full CRUD operations were outside scope.
* A completely generic recursive combination finding algorithm. Business specific logic is found in pack and order models.
* The built in migration system was used in order to create required tables.
* Gii code generator was used to create boilerplate code for models and controllers.
* The boilerplate front end that comes with Yii was used. Unfortunately there was not time or scope to fully show my front end skills in this question. 

## Tests

Using the codeception library unit tests were written. These tests focus on the recursive solver model. Tests also cover some of the business related logic in the order model.

## Deployment

For deployment a digital ocean droplet was used.  A one click LAMP application mode is available on digital ocean which was used to install the basis of what is needed immediately. Some additional configuration was required however. MySql remote connections were allowed so sequel pro could be used to inspect the database. Git was used to pull the project onto the server. Some additional apache modules were enabled and the document root was changed. After that the project was initiated with composer and was able to be served.
    
## Conclusion

The core requirements were delivered successfully.

Additionally storing the pack sizes in the database and using an interface for the solver allows easy extension of the current code.

The answering of the question is also documented fairly well via this markdown file, code comments, doc blocks and also extent tests.

Improvements could be made to the front end, testing and pack CRUD operations. Time was limited however.

Please ask to change pack values or feel free to download the project and play with the unit tests.
