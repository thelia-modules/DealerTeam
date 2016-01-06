<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/
/*************************************************************************************/

namespace DealerTeam\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Thelia\Tools\URL;

/**
 * Class PersonController
 * @package DealerTeam\Controller
 */
class PersonController extends \Team\Controller\PersonController
{
    /**
     * @inheritDoc
     */
    protected function redirectToListTemplate()
    {
        $id = $this->getRequest()->query->get("dealer_id");
        if(null === $id){
            $id = $this->getRequest()->request->get("dealer_id");
        }
        return new RedirectResponse(URL::getInstance()->absoluteUrl("/admin/module/Dealer/dealer/edit#dealerteam",["dealer_id" => $id]));
    }
}