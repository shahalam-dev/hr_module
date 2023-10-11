# Eboss core

### Table of content

- [Eboss core](#eboss-core)
  - [Table of content](#table-of-content)
  - [Project Overview](#project-overview)
  - [Installation](#installation)
  - [Folder Structure](#folder-structure)
  - [Core Classes description](#core-classes-description)
    - [API response Class and Methods](#api-response-class-and-methods)
    - [error handling Class and Methods](#error-handling-class-and-methods)
    - [File upload Class and Methods](#file-upload-class-and-methods)
    - [Handle token](#handle-token)
    - [Database Class and Methods](#database-class-and-methods)
      - [Inserting data method](#inserting-data-method)
      - [Updating data method](#updating-data-method)
      - [Fetching data method](#fetching-data-method)
      - [Deleting data method](#deleting-data-method)
      - [Retrive last inserted ID method](#retrive-last-inserted-id-method)
  - [Skeleton of micro-services](#skeleton-of-micro-services)
    - [Renaming file, folder and classes and methods names](#renaming-file-folder-and-classes-and-methods-names)
    - [Module skeleton (about business logic class)](#module-skeleton-about-business-logic-class)
    - [Endpoint skeleton (about handling api request and response)](#endpoint-skeleton-about-handling-api-request-and-response)

## Project Overview

This codebase is a project led by Awfatech Global, primarily aimed at supporting microservices within the Eboss ecosystem. Within this codebase, you will find a collection of objects and methods designed to facilitate the development of PHP-based microservices.

---

## Installation

To get started, follow these steps:

1. **Fork the Codebase**
   : Begin by creating a copy of the codebase in your own Git repository. This process is commonly referred to as "forking."

2. **Pull the Source Code**
   : Retrieve the source code from the remote repository by running the appropriate Git command.

3. **Navigate to the Source Code's Root Directory**
   : Once you have the source code locally, access the root directory of the project.

4. **Start the PHP and Nginx Server**
   : aunch the PHP and Nginx server using Docker Compose by running the following command:
   ```bash
   docker compose up
   ```
   This command will initialize a container and start the server.
5. **Stop the Container**
   : If you need to stop the container, execute the following command:
   ```
   docker compose down
   ```
   This will halt the running container.

These steps will allow you to set up and run the PHP and Nginx server within a Docker container for your project.

---

## Folder Structure

```
    │
    ├── docker [config files for docker]
    ├── logs [nginx logs]
    ├── src [root folder]
    │   ├── api [api endpoints]
    │   ├── assets
    │   │   ├── core [core object's folder]
    │   │   │   ├── lib [library/package's folder]
    │   │   ├──  [specific business logic object's folder]
    │   ├── logs [error log]
    │   ├── secrets [secret keys]
    ├── README.md
    ├── docker-compose.yml
    ├── .env
    └── .gitignore

```

## Core Classes description

Within this codebase, you'll encounter a diverse set of Classes, each tailored to fulfill distinct requirements. These Classes have been designed and implemented to serve specific purposes, reflecting the versatility and flexibility of the codebase. Whether it's handling various data processing tasks, managing database interactions, or facilitating backend operations, these Classes have been intricately crafted to meet the diverse needs of our application.

Files inside core:

```text
│ core
│ ├── api_response.php
│ ├── err.php
│ ├── file_up.php
│ ├── handle_token.php
│ ├── sql_pdo.php

```

---

### API response Class and Methods

This is a straightforward Class designed for the construction of API responses and their transmission to the client.

Creating Object from the `ApiResponse` Class

```php
$responseBuilder = new ApiResponse('<status code>','<status>','<message>','<data>');
```

By executing this snippet, create a new instance of the ApiResponseBuilder object, enabling you to utilize its functionalities for crafting and transmitting API responses to clients.

Afterward, it is necessary to utilize the following method to transmit the response to the client:

```php
echo $responseBuilder->toJson();
```

Executing this line will ensure that the assembled API response reaches its intended recipient.

---

### error handling Class and Methods

The error handling component, integrated into the core objects, specializes in logging service-related errors while excluding those originating from user mistakes. Business logic is responsible for addressing errors caused by users based on specific requirements. During the initialization of the error object, it necessitates three parameters: the error description, the application responsible for the error, and the user accountable for triggering it.

How to use the error object in code:

```php

try {
   // logic
} catch (Throwable $e) {
   ErrorHandler::handleException($e, '<app name>', '<user id>');
}

```

---

### File upload Class and Methods

The `FileUpload` Class is pretty simple and has one `store_file` method to store file. When creating object form the class need pass three parameters which are, the app name (which send this request) and the user id (who send the request). after that call the method `store_file` (_incomplete_)

---

### Handle token

---

The JWToken class plays a crucial role in the Eboss ecosystem by facilitating the decoding of JWTs and the extraction of vital information. Within this ecosystem, the API gateway takes charge of generating tokens enriched with client-specific details. These tokens are transmitted alongside every request to microservices. This allows microservices to leverage the enclosed information for diverse tasks, ranging from establishing connection-specific data for individual clients to directing file storage to specific file servers.

_*NOTE:*_

1. **Create a Folder:** Open your terminal or file explorer and navigate to the location where you want to create the `secrets` folder.

   ```bash
   mkdir secrets
   ```

   This command creates a new directory named `secrets`.

2. **Navigate to the 'secrets' Folder:** You need to move into the `secrets` folder.

   ```bash
   cd secrets
   ```

3. **Create a Public Key File:** Now, create a file named `public.key` inside the `secrets` folder. You can use a text editor or the `touch` command to create an empty file.

   Using a text editor:

   ```bash
   nano public.key
   ```

   This will open the `public.key` file in the `nano` text editor. You can paste your public key into this file and save it.

   Alternatively, you can create an empty file using the `touch` command:

   ```bash
   touch public.key
   ```

4. **Add Public Key:** Open the `public.key` file with a text editor and paste your public key information into it. Save the file.

Now, you have successfully created a folder named `secrets`, created a file named `public.key` inside it, and added your public key for decoding tokens.

Utilizing the JWToken class is a simple process, involving just one method: decodeToken. Here's a basic example of how to use it:

```php

$jwt = new JWToken();
$appInfo = $jwt->decodeToken('<token>');

```

To gain a deeper understanding of how to effectively utilize the JWToken object and its decodeToken method, it is recommended to consult the skeleton documentation. This documentation typically offers a comprehensive resource with detailed explanations, practical examples, and usage guidelines.

---

### Database Class and Methods

---

The MySQLDatabaseHandler class is a versatile and essential component designed to streamline interactions with a MySQL database. This class encapsulates the intricacies of database connectivity and offers a user-friendly interface for executing common database operations, including insertion, updating, deletion, and selection of data.

Creating Object from the `PDODB` Class

```php
$DB = new PDODB($appInfo); // pass appinfo array as parameter (decoded form token)
```

#### Inserting data method

This method will insert data into database.

```php
$sql="INSERT into <rest of query>";
$this->DB->insert($sql);
```

#### Updating data method

This method will update data into database and will return `1` if data will have updated otherwise 0.

```php
$sql="UPDATE <table_name> SET <map column> WHERE <rest of clause>";
$this->DB->update($sql);
```

#### Fetching data method

This method will fetch data from database and return the as array.

```php
$sql="SELECT <rest of query> WHERE <rest of cluse>";
$this->DB->select($sql);
```

#### Deleting data method

This method will delete data from database.

```php
$sql="insert into <rest of query>";
$this->DB->delete($sql);
```

#### Retrive last inserted ID method

This method will return latest inserted row id.

```php
$this->DB->lastInsertedId($sql);
```

---

---

## Skeleton of micro-services

There is a skeleton of for business login class and api endpoint. just need to copy rename where it necessary.

### Renaming file, folder and classes and methods names

_*NOTE: where `skeleton` phrase is exists need to replace*_

1. `module-skeleton` is inside `src/assets/`. inside `module-skeleton` diretory there is a file called `module-skeleton.php`. replace the directory and file with an appropiate name.(like micro-service/module name).
2. In `module-skeleton.php` there two classes. one for property name which store in data (map property name with database column name, but property name must be meaningful) and another one is for methods those will handle business logic part. replace those classes name.
3. Inside `src/api/v1` there is a folder named `endpoint-skeleton` and file named `endpoint-skeleton.php`

### Module skeleton (about business logic class)

Replace the class name with `<module_name+Data>` like `NewsData` or `PosData`. Declare public property for every columns on the database table assosciate with this module.

_*location*_`src/module-skeleton/`

Replace the class name `Skeleton` to apporipiate name and `SkeletonData` to whatever name given to Skeleton Data class.

```php

class SkeletonData{
    //Common Properties associate with database table
    public $example_property;
}
```

The property names within the `Skeleton` class should be intuitive and self-explanatory. If a property's purpose is not immediately clear, please refer to the accompanying comment for clarification.

```php
class Skeleton extends SkeletonData {
    public $data; // api response data
    public $msg; // api response message
    public $status; // api response status
    public $status_code; // api response status code
    public $total_data;
    //Standard Filter for listing by page limit. Use for paging
    public $page_start;
    public $page_limit;

    //Standard Properties
    public $user_id;//User id that access this class
    public $branch_id;//Branch id that access this class
    public $app_name; //app name
    public $DB;//Class of DB connector from sql_com

    // Class Initialized
    public function __construct($appinfo,$db, $payload){
        $this->user_id = $appinfo['user_id'];
        $this->app_name = $appinfo['app_name'];
        $this->branch_id= $appinfo['sid'];
        $this->DB=$db;

        // mapping payload to properties
        $this->example_property = $payload['example_property'] ?? null;
    }
}
```

Replace the methods name. Write down all the logics inside try block. Call the `resBody` method to construct api response body.

```php
function skeleton_method() {
    try {
        //logic goes here

        $this->resBody('<status code>','<status>','<msg>','<data>');
        return true;
    } catch (Throwable $e) {
        //if any error occurs, it will be handled here
        ErrorHandler::handleException($e, $this->app_name, $this->user_id);
        $this->resBody(400,'error','Internal server error',null);
        return false;
    }
}

```

---

### Endpoint skeleton (about handling api request and response)

This `$request_body` variable capture the data sends from client-side and then `$payload` is an array of decoded json data.

```php
$request_body = file_get_contents('php://input');
$payload = json_decode($request_body,true);
```

This function will extract data from `X-Encrypted-Key` token (the token sends with every request form apigateway) and set set those data into `appInfoArr`.

```php
function get_app_info() {
    $appInfoArr = [];
    foreach (getallheaders() as $name => $value) {
        $headerKey = strtolower(str_replace('-', '_', $name));
        if($headerKey=="x_encrypted_key") $token=$value;
        if($headerKey=="x_user_id") $appInfoArr['user_id'] = $value;
    }

    // JWT Token class initialization
    $jwt = new JWToken();
    // Decode the token
    $appInfo = $jwt->decodeToken($token);
    // Extract the data
    foreach ($appInfo as $key => $value) {
        $appInfoArr[$key] = $value;
    }
    return $appInfoArr;
}

$appInfo = get_app_info();

```

This object creation from `PDODB` class provides istablishing connection to data base and give the useful methods needed for database transaction.

```php

//DB connection initialization
$DB = new PDODB($appInfo);
```

This object creation from the business logic class (mentioned above) takes parameters.

```php
//Business logic class initialization
$Skeleton = new Skeleton($appInfo,$DB, $payload);
```

Endpoint specific action handaling function. which is responsible for executing business logic class's method send the respose to the client.

```php
$action_execution_function = function() use ($Skeleton){
    $Skeleton->skeleton_method();

    $response = new ApiResponse($Skeleton->status_code, $Skeleton->status, $Skeleton->msg, $Skeleton->data);
    echo $response->toJson();
};

```

This function will handle exceptions like, if there is no action found or given action are not in this endpoint.

```php
$action_not_found = function(){
    $response = new ApiResponse(404, "error", "Action not found", null);
    echo $response->toJson();
};
```

This switch block will handle function execution based on action

```php
switch ($payload ? $payload['action'] : "") {
    case '<action_name>':
            $action_execution_function();
        break;
    default:
            $action_not_found();
        break;
}

```
