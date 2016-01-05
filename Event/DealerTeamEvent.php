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

namespace DealerTeam\Event;

use DealerTeam\Model\DealerTeam;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DealerTeamEvent
 * @package DealerTeam\Event
 */
class DealerTeamEvent extends Event
{
    /**
     * @var DealerTeam $dealerTeam
     */
    protected $dealerTeam;

    /**
     * @return DealerTeam
     */
    public function getDealerTeam()
    {
        return $this->dealerTeam;
    }

    /**
     * @param DealerTeam $dealerTeam
     */
    public function setDealerTeam($dealerTeam)
    {
        $this->dealerTeam = $dealerTeam;
    }



}