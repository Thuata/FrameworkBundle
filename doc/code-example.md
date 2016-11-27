# Code Example

Be sure to have read the [Idea behind Thuata Framework Bundle](idea.md)

We continue with our exemple : the TODO list application. Let's have a
reminder.

>We need to create an application that will manage todo lists.
>
> Here are the needs :
>
>- As a user I can create a list with a name
>- As a user I can create a todo in a list with a content
>- As a user I can order my todos
>- As a user I can see a list of lists
>- As a user I can see a list of todos
>- As a user I can mark a todo as DONE
>- As a user I can remove a todo
>- As an admin I can see a chart with the number of todos created by day
>on a sliding month


Lets determine our technical stack :
 - An Nginx server
 - PHP with Symfony 3 and Thuata Framework Bundle
 - Mysql for database
 
Nothing exotic you see.

With our symfony project we have the following structure :

```
<your project>/
├─ app/
│   ├─ config/
│   ├─ Resources/
│   ├─ AppCache.php
│   ├─ AppKernel.php
│   └─ autoload.php
├─  bin/
├─ src/
│   └─ AppBundle/
│       ├─ Controller/
│       │   └─ DefaultController.php
│       ├─ Resources/
│       │   └─ views/
│       │       └─ Default/
│       │           └─ index.html.twig
│       └─ AppBundle.php
├─ var/
├─ vendor/
└─ web/
```


Let's start from the beginning. : __As a user I can create a list with
a name__.

Lets remind us how that story is resolved with the Thuata Framework :

>We need :
>- a form to be displayed from a controller action  (__user layer__)
>- an action to get values from the form and display a result (__user
layer__) 
>- an object to represent the list (__Entity__)
>- a method to create the list from the form data (__business layer__)
>witch will :
>   - verify that the name is unique (__technical layer__)
>   - create a new entity (__technical layer__)
>   - persist the entity (__data layer__)

Let's start with the [User Layer](code-example/user-layer.md)