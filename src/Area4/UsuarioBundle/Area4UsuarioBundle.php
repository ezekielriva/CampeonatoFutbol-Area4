<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Area4\UsuarioBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Area4UsuarioBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
