<?php

namespace Datacity\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DatacityUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
