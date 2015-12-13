# Define MVC

Define MVC is a **Front Controller** based MVC framework for developing web based applications. It is an open source and will always remain.

The name **Define** because you can define it the way you want. I have tried to keep everything configurable.

### Contribute

Please feel free to contribute. But try to keep the implementation simple so that a developer working for first time shouldn't find it difficult to understand and use it.



### How to use it

Since it is a Front Controller based MVC, the URL should be in the following pattern:

**http://www.domain.com/controller/action/param1-param2/**

So, if the URL is http://www.example.com/user/profile/33-90/ then:

<pre>
<code>

class UserController extends ApplicationController {
	public function profileAction($param1, $param2) {
		// logic goes here
	}
}
</code>
</pre>

Check IndexController inside application/controller to get an idea.

All the view files will be inside 'application/view/' folder.

You can add display value in view by using View object. For example:

<pre>
<code>
class UserController extends ApplicationController {
	public function profileAction($param1, $param2) {
		$this->view->addObject("msg", "I am the value to be displayed.");
		$this->view->render('user');
	}
}
</code>
</pre>

In 'view' folder, create a file named 'user.php', and put the following code:

<pre>
<code>
echo $msg
</code>
</pre>



** All the files related to your project will be inside 'application' folder**. However, you can change the configurations defined in 'configuration/define.inc'.

To test after importing the project in your local server, try accessing the following:
http://www.domain.com/

http://www.domain.com/index/default/me-you/

http://www.domain.com/index/test-from-service/

http://www.domain.com/index/test-from-dao/

- where domain.com is your local server.

### Configuration

Define MVC is completely configurable. 

For example, you want your UserController to be UserXYZ go to 'configuration/define.inc' and change CONTROLLER_SUFFIX to XYZ. Similarly, you can change other configuration properties.

### API Documentation

Check docs/index.html for API documentation.

### TODO
// More documentation to come. However, it's open for contribution.
