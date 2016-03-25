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

namespace DealerTeam;

use DealerTeam\Model\DealerTeamQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Model\Resource;
use Thelia\Model\ResourceQuery;
use Thelia\Module\BaseModule;

class DealerTeam extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'dealerteam';

    const RESOURCES_TEAM = "admin.dealer.team";

    public function postActivation(ConnectionInterface $con = null)
    {
        try {
            DealerTeamQuery::create()->findOne();
        } catch (\Exception $e) {
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);
        }

        $this->addResource(self::RESOURCES_TEAM);
    }

    protected function addResource($code)
    {
        if(null === ResourceQuery::create()->findOneByCode($code)){
            $resource = new Resource();
            $resource->setCode($code);
            $resource->setTitle($code);
            $resource->save();
        }
    }
}
