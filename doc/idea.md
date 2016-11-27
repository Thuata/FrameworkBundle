# The idea behind _Thuata Framework Bundle_

Any application can be split in layers :
 1. __User layer__ : This is where the user interacts with the
application.
 2. __Business layer__ : This is where the product owner constraints are
answered. In a Scrum method the methods from that layer should be driven
by the board stories.
 3. __Technical layer__ : This layer provides the tools the business
layer needs to resolve the constraints. As the fetch an modification
operations on objects. It will resolve the technical constraints and
validate the integrity of the objects.
 4. __Data layer__ :  This layer will handle the CRUD operations in the
databases or any other data storage component.

## Rules governing the interactions between layers

 - Each layer _has knowledge_ of __itself__ and the one __directly below__
 - Layers _do not have knowledge_ of the layers __above__
 - Layers _do not have knowledge_ of the layers __below__ if not
__directly__ below
 - Only the __Entity__ and its decorated versions can move across the
layers
 - The User layer *can* use the Technical layer __if and only if__
it is to fetch a single entity by a unique identifier

## Should I use _Thuata Framework Bundle_ ?

This idea of layers is the fundamentals behind _Thuata Framework Bundle_,
if that concept does not fit the way you develop, _Thuata Framework
Bundle_ won't fit you. It's sad but there are many design patterns for
applications and lots of them are good.

If you have not yet decided how you will design your model or if that
design is OK for you, then you're welcome to continue. 

## Exemple : TODO list application

Ok its not an original one, but its a smart one ;).

We need to create an application that will manage todo lists.

Here are the needs :

- As a user I can create a list with a name
- As a user I can create a todo in a list with a content
- As a user I can order my todos
- As a user I can see a list of lists
- As a user I can see a list of todos
- As a user I can mark a todo as DONE
- As a user I can remove a todo
- As an admin I can see a chart with the number of todos created by day
on a sliding month

We could have written lots more and lots of things more complicated. But that's enough
fir the example.

Lets study what goes in what layer :

- As a user I can create a list with a name. We need :
    - a form to be displayed from a controller action  (__user layer__)
    - an action to get values from the form and display a result (__user
layer__) 
    - an object to represent the list (__Entity__)
    - a method to create the list from the form data (__business layer__)
witch will :
       - verify that the name is unique (__technical layer__)
       - create a new entity (__technical layer__)
       - persist the entity (__data layer__)
- As a user I can create a todo in a list with a content. We need :
    - a form to be displayed from a controller action  (__user layer__)
    - an action to get values from the form (__user layer__)
    - an object to represent the todo (__Entity__)
    - a method to create the todo from the form data (__business layer__)
witch will :
       - verify that the list is provided and exists (__technical
layer__)
       - create a new entity (__technical layer__)
       - attach the entity to the list entity (__business layer__)
       - persist the entity (__data layer__)
- As a user I can order my todos. Assuming it's an AJAX request setting
a new position to a todo we need :
    - an action to get the new position (__user layer__)
    - a method to set the new position (__business layer__) that will :
        - fetch all entities from the new position to the end of the
list (__technical layer__)
        - update the positions to all thoses entities (__technical
layer__)
        - persist all thoses entities (__data layer__)
        
And so on...

Next step : [Code example](code-example)
