## User Layer

The __user layer__ is provided by Symfony with the View and Controller.

We continue with our exemple : the TODO list application. Let's have a
reminder.

>We need to create an application that will manage todo lists.
>
> Here are the needs :
>- As a user I can create a list with a name
>- As a user I can create a todo in a list with a content
>- As a user I can order my todos
>- As a user I can see a list of lists
>- As a user I can see a list of todos
>- As a user I can mark a todo as DONE
>- As a user I can remove a todo
>- As an admin I can see a chart with the number of todos created by day
>on a sliding month
>
>We work on the first story : __As a user I can create a list with a
>name__

Lets assume we created a login page and an empty home page.

Behind the login page we put a LoginController with the default symfony
authentication mechanics.

Behind the home page we put a TodoController with a defaultAction
action.

So our structure is now :

```
<your project>/
├─ app/
│   ├─ Resources/
│   │   └─ views/
│   │       ├─ Login/
│   │       └─ Todo/
...
├─ src/
│   └─ AppBundle/
│       ├─ Controller/
│       │   ├─ LoginController.php
│       │   └─ TodoController.php
...
```

For the form lets use the Symfony Forms. We will also use the same
action to display and treat the form.

Lets have a ```createListAction``` in the ```TodoController``` :

```php
<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * <b>TodoController</b><br>
 *
 * @package AppBundle\Controller
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoController extends Controller
{
    /**
     * Index action
     *
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('Todo/index.html.Twig');
    }

    /**
     * Action to create a new list
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/list/create-list.html", name="create_list")
     */
    public function createListAction(Request $request)
    {
        $formBuilder = $this->createFormBuilder();

        $formBuilder->add('name', 'text', [
            'label' => 'Name'
        ]);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData();

            // here we will call the business layer to create the list

            // We redirect to home for the moment with a 201 "CREATED" HTTP status
            return $this->redirect($this->generateUrl('home', 201));
        }

        return $this->render('Todo/create-list.html.twig', [
            'listForm' => $form->createView()
        ]);
    }
}

```

As you see here, nothing is really different from a standard Symfony
code.

You see in the code the following line :
 
```php
// here we will call the business layer to create the list
```

It's time to talk about that [Business Layer](code-example/business-layer.md).