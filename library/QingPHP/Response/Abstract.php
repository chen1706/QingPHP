<?php
abstract class QingPHP_Response_Abstract
{
	protected $body = array();
	protected $header = array();

	public function setBody($body, $name = null)
	{
		$this->body = array();
		return $this->body[] = $body;
	}

	public function prependBody($body, $name)
	{
		return array_unshift($this->body, $body);
	}

	public function appendBody($body, $name)
	{
		return $this->body[] = $body;
	}

	public function clearBody($body)
	{
		return $this->body = array();
	}

	public function getBody()
	{
		return $this->body;
	}

	public function response()
	{

	}
}