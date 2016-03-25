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

namespace DealerTeam\Hook;

use Dealer\Model\DealerQuery;
use Dealer\Model\Map\DealerTableMap;
use DealerTeam\DealerTeam;
use DealerTeam\Model\DealerTeamQuery;
use DealerTeam\Model\Map\DealerTeamTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Team\Model\Map\PersonTeamLinkTableMap;
use Team\Model\Map\TeamTableMap;
use Team\Model\Team;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Translation\Translator;

/**
 * Class AdminHook
 * @package DealerTeam\Hook
 */
class AdminHook extends BaseHook
{
    protected $container;


    public function __construct($container)
    {
        $this->container = $container;
    }

    protected function transQuick($id, $locale, $parameters = [])
    {
        if ($this->translator === null) {
            $this->translator = Translator::getInstance();
        }

        return $this->trans($id, $parameters, DealerTeam::DOMAIN_NAME, $locale);
    }

    public function onDealerEditTab(HookRenderBlockEvent $event)
    {
        if ($this->checkAuth(DealerTeam::RESOURCES_TEAM, [], AccessManager::VIEW)) {
            $lang = $this->getSession()->getLang();

            $event->add(
                [
                    "id" => "dealerteam",
                    "class" => "",
                    "title" => $this->transQuick("Team", $lang->getLocale()),
                    "content" => $this->render("dealerteam.html", $event->getArguments()),
                ]
            );
        }
    }

    public function onDealerEditJs(HookRenderEvent $event)
    {
        $event->add($this->render("js/dealerteam-js.html"));
    }

    public function onTeamNavBar(HookRenderEvent $event)
    {
        $query = DealerTeamQuery::create();

        $joinPerson = new Join(DealerTeamTableMap::TEAM_ID, PersonTeamLinkTableMap::TEAM_ID, Criteria::LEFT_JOIN);

        $query
            ->addJoinObject($joinPerson)
            ->where(PersonTeamLinkTableMap::PERSON_ID . " " . Criteria::EQUAL . " " . $event->getArgument("person_id"));

        $dealer = $query->findOne();

        $args = $event->getArguments();

        if (null != $dealer) {
            $args["dealer_id"] = $dealer->getDealerId();
        }

        $event->add($this->render("includes/person-edit-link.html", $args));

    }

    protected function checkAuth($resources, $modules, $accesses)
    {
        $resources = is_array($resources) ? $resources : array($resources);
        $modules = is_array($modules) ? $modules : array($modules);
        $accesses = is_array($accesses) ? $accesses : array($accesses);

        if ($this->getSecurityContext()->isGranted(array("ADMIN"), $resources, $modules, $accesses)) {
            // Okay !
            return true;
        }

        return false;

    }

    /**
     * Return the security context, by default in admin mode.
     *
     * @return \Thelia\Core\Security\SecurityContext
     */
    protected function getSecurityContext()
    {
        return $this->container->get('thelia.securityContext');
    }
}