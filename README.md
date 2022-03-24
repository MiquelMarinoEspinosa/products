# Products
The project has been implemented using the symfony framework version 6.0 on PHP programming language version 8.1
The database used is mysql 8
The devel environment has been configured using docker

### SETUP
In order to setup the devel environment be sure that you have the docker engine installed in your computer.
Then run the following command

`$> make up`

This command will
* Create the following docker containers 
     * nginx
     * php-fpm
     * mysql
     * swagger
* Install the composer packages
* Create and populate the database

### RUN TESTS
In order to execute the `unit tests` run the following command

`$> make unit`

To see the unit test coverage run the following commands

`$> make coverage`

`$> open ./coverage/index.html`

To run the `acceptance tests` implemented using `behat` run the following command

`$> make acceptance`

### ARCHITECTURE
The architecture used to implement the application has been the `hexagonal architecture` based on a DDD approach using bundles to split the domains
The architecture is organized in 4 layers starting on the root folder `Product` as a bundle

#### UserInterface
* In this layer are located the application entrypoint
* Therefore the `controller` which will expose the API endpoint is placed at this layer
* The controller receive the `query params` whether they are informed - category and priceLessThan - build a query to retrieve the products based on that criteria
* The controller will execute the `query handler` using the [symfony messenger](https://symfony.com/doc/current/components/messenger.html) tool
* Once executed will format the response in the expected json format

#### Application
* In this layer are located the `query handler` as well as its `query` and its `response`
* The `query handler` use the `product repository` in order to retreive the products from the database based on the `query's criteria`
* Notice that the `product repository` is an interface without implementation and is injected to the `query handler` promoting the `Dependency Injection Principle` from the SOLID principles
* The handler will build a `ProductCriteria` based on the user filters passing it to the repository wich eventually will perform the database query
* Once the `products` have been retreived the handler will build a `response DTO` as response for the `controller`
* If there has been any error during the process the `CannotFindProducts` exception will be thrown to avoid couple external layers with any especific error
* Notice that the `ProductResponse` has been located to the `Response` folder for the sake of using it across other handlers
* To create future functionalities such as `saving products` a `commmand` will be implemented. The difference with the `query` is that the command will not return a response. A new folder will be created to locate these implementations at `Product/Application/Command`

#### Domain
* In this layer are located the `entities` as well as its `repositories` definition
* The main entity is the `Product` entity
* All the logic related to the `discounts` has been implemented at the `Product` entity. This way the business logic has been implemented in the domain entities creating a `rich domain` rather than having client classes such as the `query handler` at the application layer implementing the logic ending with this way with an `anemic domain`
* The `ProductCollection` consists of an array of `Products` entity
* The `Repository` folder has got the `product repository` definition

#### Infrastructure
* In this layer are located the `database definition` as well as the domain `product repository` implementation
* The database consists of a single table called `products` with the following fields
    * sku (as the row id)
    * name
    * category
    * price 
* The `ORM` used has been [doctrine](https://symfony.com/doc/current/doctrine.html)
* The definition is at `Resources/config/doctrine/Product.orm.xml`
* The repository uses the doctrine `entity manager` to build the query based on the `ProductCriteria`
* It will return a `ProductCollection` with the database results
* The database is populated using the [doctrine migrations](https://symfony.com/bundles/DoctrineMigrationsBundle/current/index.html) located at `src/Application/Migrations`

#### Tests
* Unit
    * It has been used the [phpunit](https://symfony.com/doc/current/components/phpunit_bridge.html) tool
    * The folders `Domain` and `Application` has been unit tested to `100% coverage`
    * This decision has been made because al the business logic - specially the `domain` layer - is located at this layers. This logic does not depend on tecnical details. Additionally the tests guarantee that the business logic works as expected 
    * The folders `UserInterface` and `Infrastructure` has been discarded to be unit tested giving the fact that they depend to much on technical details implementation. The tests would be to fragile. Therefore will be hard to maintain them
    * The unit tests will mock all third party dependencies such as the database connection

* Acceptance
    * It has been used the [behat](https://docs.behat.org/en/latest/) tool
    * This test will eventually make a request to the `/products` endpoint to retreive the products as well as check the response format
    * This test will test all the application layers including `UserInterface` and `Infrastructure`

### SWAGGER
* Additionally the API has been documented using the [swagger ui](https://swagger.io/tools/swagger-ui/)
* It could be accessed on http://localhost:8080
