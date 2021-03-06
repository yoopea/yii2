<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\base;

/**
 * Action is the base class for all controller action classes.
 *
 * Action provides a way to divide a complex controller into
 * smaller actions in separate class files.
 *
 * Derived classes must implement a method named `run()`. This method
 * will be invoked by the controller when the action is requested.
 * The `run()` method can have parameters which will be filled up
 * with user input values automatically according to their names.
 * For example, if the `run()` method is declared as follows:
 *
 * ~~~
 * public function run($id, $type = 'book') { ... }
 * ~~~
 *
 * And the parameters provided for the action are: `array('id' => 1)`.
 * Then the `run()` method will be invoked as `run(1)` automatically.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Action extends Component
{
	/**
	 * @var string ID of the action
	 */
	public $id;
	/**
	 * @var Controller the controller that owns this action
	 */
	public $controller;

	/**
	 * Constructor.
	 * @param string $id the ID of this action
	 * @param Controller $controller the controller that owns this action
	 * @param array $config name-value pairs that will be used to initialize the object properties
	 */
	public function __construct($id, $controller, $config = array())
	{
		$this->id = $id;
		$this->controller = $controller;
		parent::__construct($config);
	}

	/**
	 * Returns the unique ID of this action among the whole application.
	 * @return string the unique ID of this action among the whole application.
	 */
	public function getUniqueId()
	{
		return $this->controller->getUniqueId() . '/' . $this->id;
	}

	/**
	 * Runs this action with the specified parameters.
	 * This method is mainly invoked by the controller.
	 * @param array $params the parameters to be bound to the action's run() method.
	 * @return mixed the result of the action
	 * @throws InvalidConfigException if the action class does not have a run() method
	 */
	public function runWithParams($params)
	{
		if (!method_exists($this, 'run')) {
			throw new InvalidConfigException(get_class($this) . ' must define a "run()" method.');
		}
		$args = $this->controller->bindActionParams($this, $params);
		return call_user_func_array(array($this, 'run'), $args);
	}
}
