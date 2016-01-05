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

namespace DealerTeam\Service;

use Dealer\Service\Base\AbstractBaseService;
use Dealer\Service\Base\BaseServiceInterface;
use DealerTeam\Event\DealerTeamEvent;
use DealerTeam\Event\DealerTeamEvents;
use DealerTeam\Model\DealerTeam;
use DealerTeam\Model\DealerTeamQuery;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class DealerTeamService
 * @package DealerTeam\Service
 */
class DealerTeamService extends AbstractBaseService implements BaseServiceInterface
{

    const EVENT_CREATE = DealerTeamEvents::DEALER_TEAM_CREATE;
    const EVENT_CREATE_BEFORE = DealerTeamEvents::DEALER_TEAM_CREATE_BEFORE;
    const EVENT_CREATE_AFTER = DealerTeamEvents::DEALER_TEAM_CREATE_AFTER;
    const EVENT_UPDATE = DealerTeamEvents::DEALER_TEAM_UPDATE;
    const EVENT_UPDATE_BEFORE = DealerTeamEvents::DEALER_TEAM_UPDATE_BEFORE;
    const EVENT_UPDATE_AFTER = DealerTeamEvents::DEALER_TEAM_UPDATE_AFTER;
    const EVENT_DELETE = DealerTeamEvents::DEALER_TEAM_DELETE;
    const EVENT_DELETE_BEFORE = DealerTeamEvents::DEALER_TEAM_DELETE_BEFORE;
    const EVENT_DELETE_AFTER = DealerTeamEvents::DEALER_TEAM_DELETE_AFTER;

    public function createFromArray($data, $locale = null)
    {
        $link = $this->hydrateObjectArray($data, $locale);

        $event = new DealerTeamEvent();
        $event->setDealerTeam($link);

        $this->create($event);

        return $event->getDealerTeam();
    }

    public function updateFromArray($data, $locale = null)
    {
        $link = $this->hydrateObjectArray($data, $locale);

        $event = new DealerTeamEvent();
        $event->setDealerTeam($link);

        $this->update($event);

        return $event->getDealerTeam();
    }

    public function deleteFromId($id)
    {
        $link = DealerTeamQuery::create()->findOneById($id);
        if ($link) {
            $event = new DealerTeamEvent();
            $event->setDealerTeam($link);

            $this->delete($event);
        }
    }

    /**
     * @inheritDoc
     */
    protected function createProcess(Event $event)
    {
        /** @var DealerTeamEvent $event */
        $event->getDealerTeam()->save();
    }

    /**
     * @inheritDoc
     */
    protected function updateProcess(Event $event)
    {
        /** @var DealerTeamEvent $event */
        $event->getDealerTeam()->save();
    }

    protected function deleteProcess(Event $event)
    {
        /** @var DealerTeamEvent $event */
        $event->getDealerTeam()->delete();
    }

    protected function hydrateObjectArray($data, $locale = null)
    {
        $model = new DealerTeam();

        if (isset($data['id'])) {
            $link = DealerTeamQuery::create()->findOneById($data['id']);
            if ($link) {
                $model = $link;
            }
        }

        if(isset($data["team_id"]) && isset($data["dealer_id"])){
            $link = DealerTeamQuery::create()->filterByDealerId($data["dealer_id"])->filterByTeamId($data["team_id"])->findOne();
            if ($link) {
                throw new \Exception("A link already exist",403);
            }

            $model->setTeamId($data["team_id"]);
            $model->setDealerId($data["dealer_id"]);
        }

        return $model;
    }


}