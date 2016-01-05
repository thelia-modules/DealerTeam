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

namespace DealerTeam\Loop;

use DealerTeam\Model\Map\DealerTeamTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Team\Model\Map\TeamTableMap;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class TeamLoop
 * @package DealerTeam\Loop
 */
class TeamLoop extends \Team\Loop\TeamLoop
{
    /**
     * @inheritDoc
     */
    protected function getArgDefinitions()
    {
        /** @var ArgumentCollection $arguments */
        $arguments = parent::getArgDefinitions();

        $arguments->addArgument(
            Argument::createIntListTypeArgument("dealer_id")
        );

        return $arguments;
    }

    /**
     * @inheritDoc
     */
    public function buildModelCriteria()
    {
       $query = parent::buildModelCriteria();

        if(null != $id = $this->getDealerId()){
            if (is_array($id)) {
                $id = implode(",", $id);
            }

            $dealerJoin = new Join(TeamTableMap::ID, DealerTeamTableMap::TEAM_ID, Criteria::LEFT_JOIN);
            $query
                ->addJoinObject($dealerJoin, "dealerJoin")
                ->where(DealerTeamTableMap::DEALER_ID . " " . Criteria::IN . " (" . $id . ")");

        }

        return $query;
    }

}