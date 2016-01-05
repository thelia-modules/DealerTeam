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

/**
 * Class DealerTeamEvents
 * @package DealerTeam\Event
 */
class DealerTeamEvents
{

    const DEALER_TEAM_CREATE = "dealer.team.create";
    const DEALER_TEAM_CREATE_BEFORE = "dealer.team.create.before";
    const DEALER_TEAM_CREATE_AFTER = "dealer.team.create.after";
    const DEALER_TEAM_UPDATE = "dealer.team.update";
    const DEALER_TEAM_UPDATE_BEFORE = "dealer.team.update.before";
    const DEALER_TEAM_UPDATE_AFTER = "dealer.team.update.after";
    const DEALER_TEAM_DELETE = "dealer.team.delete";
    const DEALER_TEAM_DELETE_BEFORE = "dealer.team.delete.before";
    const DEALER_TEAM_DELETE_AFTER = "dealer.team.delete.after";
}